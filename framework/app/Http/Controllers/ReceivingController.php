<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receiving;
use App\Models\Item;
use App\Models\Supplier;
use DB;
use Validator;
use Input;
use Redirect;
use Session;
use Sentinel;
use Datatables;
use Response;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReceivingController extends Controller
{
    
    public function __construct() {
        $this->middleware('webAuth');
    }
    
    public function getIndex()
    {
        $this->data['title']   = 'List Receiving';
        $this->data['invoice'] = $this->auto_invoice();
        
        return view('receiving.index', $this->data);
    }

    public function anyData(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $receiving = DB::table('receiving')
                ->select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                  'id', 'receiving_date', 'person_charge', 'faktur_no', 'po_no']);
                                    
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return Datatables::of($receiving)
            ->addColumn('action', function ($receiving) {
                return '
                <a href="faktur_no/'.$receiving->faktur_no.'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-print"></i> Print</a>
                ';
            })
            
            ->editColumn('id', 'ID: {{$id}}')
            ->removeColumn('id')
            ->make(true);
        
    }

    public function anyDataPO(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $po = DB::table('purchase_order')
                ->join('supplier', 'purchase_order.supplier_id', '=', 'supplier.id')
                ->join('po_detail', 'purchase_order.po_no', '=', 'po_detail.po_no')
                ->select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                  'purchase_order.*','supplier.name',
                  DB::raw('sum(po_detail.amount) as subtotal')])
                ->groupBy('purchase_order.po_no');
                                    
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return Datatables::of($po)
            ->addColumn('action', function ($po) {
                return '
                <a href="addreceiving/'.$po->po_no.'" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> Add Receiving</a>
                ';
            })
            
            ->editColumn('id', 'ID: {{$id}}')
            ->removeColumn('id')
            ->make(true);
        
    }

    
    public function create_receive($id)
    {
        $this->data['title']    = 'Receiving';
        $this->data['cek']      = DB::table('purchase_order')->distinct()->select('po_no')->get(); 
        $arr = [];
        
        foreach ($this->data['cek'] as $key) {
            array_push($arr, $key->po_no);
        }

        $this->data['po_no']    = DB::table('purchase_order')
                                    ->join('supplier', 'purchase_order.supplier_id', '=', 'supplier.id')
                                    ->select(DB::raw('concat (po_no," - ",supplier.name) as po_supplier, purchase_order.po_no as po_no'))
                                    ->whereIn('purchase_order.po_no', $arr)
                                    ->lists('po_supplier', 'po_no');
        
        $this->data['data']     = DB::table('purchase_order')
                                    ->join('supplier', 'purchase_order.supplier_id', '=', 'supplier.id')
                                    ->join('po_detail', 'purchase_order.po_no', '=', 'po_detail.po_no')
                                    ->select('po_detail.id', 'po_detail.po_no', 'purchase_order.supplier_id', 'supplier.name', 'po_detail.item_id',
                                             'po_detail.unit_id', 'po_detail.unit_conversion_id','po_detail.tax','po_detail.item_name', 'po_detail.qty','po_detail.price','po_detail.discount_per', 'po_detail.discount_value', 'po_detail.amount')
                                    ->where('purchase_order.po_no', $id)
                                    ->get();
        
        $this->data['data2']     = DB::table('purchase_order')
                                    ->join('supplier', 'purchase_order.supplier_id', '=', 'supplier.id')
                                    ->join('po_detail', 'purchase_order.po_no', '=', 'po_detail.po_no')
                                    ->select('purchase_order.*', 'supplier.id as supplierid', 'supplier.name', 'po_detail.item_id', 'po_detail.item_name', 'po_detail.qty', 'po_detail.price','po_detail.discount_per', 'po_detail.discount_value', 'po_detail.amount')
                                    ->where('purchase_order.po_no', $id)
                                    ->first();

        $this->data['options_conversion'] = DB::table('unit_conversion as a')
                                            ->join('unit AS b', 'a.parent_unit', '=', 'b.id')
                                            ->join('unit AS c', 'a.child_unit', '=', 'c.id')
                                            ->select('a.id', DB::raw('concat("1 ",b.name, " = ", a.qty_conversion, " ", c.name ) as unit'))
                                            ->lists('unit', 'id');

        $this->data['discount']   = Input::get('discount');
        $this->data['suppName']   = $this->data['data2']->name;
        $this->data['suppID']     = $this->data['data2']->supplierid;
        $this->data['poSelected'] = $this->data['data2']->po_no;

        return view('receiving.create', $this->data);
        
    }

    
    public function store()
    {
        $post = Input::all();

        $this->data['po_no']          = $post['po_no'];
        $this->data['supplier_id']    = $post['supplier_id'];
        $this->data['faktur_no']      = $post['faktur_no'];
        $this->data['person_charge']  = $post['person'];
        $this->data['description']    = $post['note'];
        $this->data['receiving_date'] = $post['date'];
        $this->data['subtotal']       = $post['sub_total'];
        $this->data['discount']       = $post['discount'];
        $this->data['amount']         = $post['total_cost'];
        $this->data['created_at']     = date('Y-m-d');
        $this->data['updated_at']     = date('Y-m-d');

        $rules                        = array(
                                          'supplier_id'    => 'required',
                                          'person_charge'  => 'required',
                                          'po_no'          => 'required',
                                          'faktur_no'      => 'required|unique:receiving',
                                          'receiving_date' => 'required|date'
                                          );

        $validator                    = Validator::make($this->data, $rules);
        
        if($validator->fails())
        {
            return Redirect::to('addreceiving/' .$post['po_no'])->withErrors($validator)->withInput();
        }
        else
        {
            $insertreceiving  = DB::table('receiving')->insertGetId($this->data);

            $qty              = 0;
            $noBatch          = '-';
            $unitConversionID = 0;
            $discount_per     = 0;
            $discount_value   = 0;
            $tax              = 0;
            $total            = 0;

            $dataItemReceiving = array();

            for ($i = 1; $i <= 20; $i++) {
                    
            if (Input::get('item_id' . $i) != '' && Input::get('qty' . $i) > 0) {

                if (Input::get('item_id' . $i)) {
                    $item_id = Input::get('item_id' . $i);
                }

                if (Input::get('qty' . $i) == null) {
                    $qty = 0;
                } else {
                    $qty = Input::get('qty' . $i);
                }

                $tglExpTmp = Input::get('exp_date' . $i);
                if (!empty($tglExpTmp)) {
                    $tglExplode = explode('-', Input::get('exp_date' . $i));
                    $tglExp     = $tglExplode[2] . '-' . $tglExplode[1] . '-' . $tglExplode[0];
                } else {
                    $tglExp = '';
                }

                if (Input::get('unit_conversion_id' . $i)) {
                    $unitConversionID = Input::get('unit_conversion_id' . $i);
                }

                $unitConversion = DB::table('unit_conversion')->where('id', $unitConversionID)->first();

                $price    = Input::get('price' . $i);
                $taxValue = (Input::get('tax' . $i) / 100) * $price;

                if (Input::get('batch' . $i)) {
                    $noBatch = Input::get('batch' . $i);
                }

                if (Input::get('discount_per' . $i)) {
                    $discount_per = Input::get('discount_per' . $i);
                }

                if (Input::get('discount_value' . $i)) {
                    $discount_value = Input::get('discount_value' . $i);
                }

                if (Input::get('tax' . $i)) {
                    $tax = Input::get('tax' . $i);
                }

                if (Input::get('subtotal_cost' . $i)) {
                    $total = Input::get('subtotal_cost' . $i);
                }

                $dataItemReceiving['receiving_id']       = $insertreceiving;
                $dataItemReceiving['item_id']            = $item_id;
                $dataItemReceiving['qty']                = $qty;
                $dataItemReceiving['batch_no']           = $noBatch;
                $dataItemReceiving['expired_date']       = $tglExp;
                $dataItemReceiving['price']              = $price;
                $dataItemReceiving['no_faktur']          = $post['faktur_no'];
                $dataItemReceiving['unit_id']            = $unitConversion->parent_unit;
                $dataItemReceiving['unit_conversion_id'] = $unitConversionID;
                $dataItemReceiving['discount_per']       = $discount_per;
                $dataItemReceiving['discount_value']     = $discount_value;
                $dataItemReceiving['tax']                = $tax;
                $dataItemReceiving['total']              = $total;

                $insertReceivingItem                     = DB::table('receiving_detail')->insertGetId($dataItemReceiving);
                $updateStatusOrder                       = DB::table('purchase_order')->where('po_no', $post['po_no'])->update(array('status_receiving' => 0));
                

                /*$arrDataGeneralLedger                    = array();
                $unit                                    = DB::table('unit')->where('id', $dataItemReceiving['unit_id'])->value('name');
                $konversi                                = DB::table('unit_conversion')->where('parent_unit', $dataItemReceiving['unit_conversion_id'])->value('qty_conversion'); 
                $item                                    = DB::table('item')->where('id', $dataItemReceiving['item_id'])->value('product_name');
                
                $unitName = '';
                if (!empty($unit)) {
                    $unitName = $unit;
                }
                

                $itemName = '';
                if (!empty($item)) {
                    $itemName = $item;
                }
                
                $price                                  = Input::get('price' . $i);
                $taxValue                               = (Input::get('tax' . $i) / 100) * $price;

                $arrDataGeneralLedger['transaction_id'] = $insertreceiving;
                $arrDataGeneralLedger['item_id']        = $dataItemReceiving['item_id'];
                $arrDataGeneralLedger['item_name']      = $itemName;
                $arrDataGeneralLedger['unit_id']        = $dataItemReceiving['unit_id'];
                
                $arrDataGeneralLedger['unit_name']      = $unitName;
                $arrDataGeneralLedger['qty']            = $dataItemReceiving['qty'] * $konversi; 
                $arrDataGeneralLedger['price']          = $dataItemReceiving['total'] / ($dataItemReceiving['qty'] * $konversi);
                $arrDataGeneralLedger['type']           = 'PO';
                $arrDataGeneralLedger['description']    = 'Faktur - ' . $post['faktur_no'];
                $arrDataGeneralLedger['created_by']     = Sentinel::getUser()->id;
                $arrDataGeneralLedger['created_at']     = date('Y-m-d');
                $arrDataGeneralLedger['updated_at']     = date('Y-m-d');
                // Insert
                $insertGeneralLedger                    = DB::table('general_ledger')->insert($arrDataGeneralLedger);
                
                // Rollback Stock
                $rowsStockGeneralLedger = DB::table('general_ledger')
                                           ->select('id','type','qty','stock')
                                           ->where('item_id', $dataItemReceiving['item_id'])
                                           ->orderBy('created_at', 'ASC')
                                           ->get();
                                       
                if (!empty($rowsStockGeneralLedger)) {
                    $i = 0;
                    $stock0 = 0;
                    $stockValue = 0;
                    foreach ($rowsStockGeneralLedger as $row):
                    $i++;
                    ${'type' . $i} = $row->type;
                    ${'qty' . $i} = $row->qty;

                    if($row->type == 'SO'){
                       ${'stock' . $i} = $row->stock;
                       $stockValue = $row->stock;
                    }else{
                        ${'stock' . $i} = ${'stock' . ($i - 1)} + ${'qty' . $i};
                        $stockValue = ${'stock' . ($i - 1)} + ${'qty' . $i};
                    }

                    DB::table('general_ledger')->where('id', $row->id)->where('type', '!=', 'SO')->update(array('stock' => $stockValue));
                    endforeach;

                    // Update stok
                    DB::table('item')->where('id', $dataItemReceiving['item_id'])->update(array('product_stock' => $stockValue));

                }*/
                
                
            }
                    

                    
        }
        
        Session::flash('succesMessage', 'Receiving item successfully added');
        return redirect('receiving');
        
        }

        

    }

    public function auto_item()
    {
        $term = Input::get('term');
    
        $results = array();
        
        $queries = DB::table('item')
            ->where('product_name', 'LIKE', '%'.$term.'%')
            ->orWhere('product_code', 'LIKE', '%'.$term.'%')
            ->get();
        
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->id, 'price' => $query->product_sell_price, 'value' => $query->product_name, 'stock' => $query->product_stock ];
        }

        return Response::json($results);
    }

    public function auto_customer()
    {
        $term = Input::get('term');
    
        $results = array();
        
        $queries = DB::table('customer')
            ->where('name', 'LIKE', '%'.$term.'%')
            ->orWhere('code', 'LIKE', '%'.$term.'%')
            ->get();
        
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->id, 'address' => $query->address, 'value' => $query->name ];
        }
        return Response::json($results);
    }

    public function add_item()
    {
        $post       = Input::all();
        $dataTemp   = array(
                    'invoice_no'   => Input::get('invoice_no'),
                    'item_id'      => Input::get('item_id'),
                    'item_name'      => Input::get('item_name'),
                    'qty'          => Input::get('qty'),
                    'price'        => Input::get('price'),
                    'discount_per' => Input::get('discount_per'),
                    'diskonrp'     => Input::get('diskonrp'),
                    'discount'     => Input::get('discount'),
                    'subtotal'     => (Input::get('price') * Input::get('qty')) - Input::get('discount'),
                    'user'         => Sentinel::getUser()->id
                    );

        $rules = array('item_id'  => 'required|unique:tmp_receiving', 'item_name'  => 'required|unique:tmp_receiving', 'qty' => 'required|numeric');
        
        $validator = Validator::make($post, $rules);
        
        if($validator->fails())
        {
            return Redirect::to('addreceiving')->withErrors($validator)->withInput();
        }
        else
        {
            $insertTemp = DB::table('tmp_receiving')->insert($dataTemp);
        }
        

        
    }

    public function add_return()
    {
        
        $id           = Input::get('id');
        $post         = Input::all();
        $dataReturn   = array(
                    'tmp_id'       => Input::get('id'),
                    'invoice_no'   => Input::get('invoice_no'),
                    'item_id'      => Input::get('item_id'),
                    'item_name'    => Input::get('item_name'),
                    'qty'          => Input::get('qty'),
                    'price'        => Input::get('price'),
                    'subtotal'     => Input::get('price') * Input::get('qty'),
                    'description'  => Input::get('description'),
                    'user'         => Sentinel::getUser()->id
                    );
        
        $rules = array('item_name'  => 'required|unique:return_receiving', 'description' => 'required');
        $validator = Validator::make($post, $rules);
        
        if($validator->fails())
        {
            return Redirect::to('addreceiving')->withErrors($validator);
            
        }
        else
        {
            $insertReturn    = DB::table('return_receiving')->insert($dataReturn);
        }

        $oldQty          = DB::table('tmp_receiving')->where('id', $id)->value('qty');
        $oldDiscount_per = DB::table('tmp_receiving')->where('id', $id)->value('discount_per');
        $newQty          = $oldQty - Input::get('qty');

        $dataTemp        = array(
                            'qty'          => $newQty,
                            'item_id'      => Input::get('item_id'),
                            'price'        => Input::get('price'),
                            'discount_per' => $oldDiscount_per,
                            'diskonrp'     => ($oldDiscount_per / 100) * (Input::get('price') * $newQty),
                            'subtotal'     => (Input::get('price') * $newQty) - ($oldDiscount_per / 100) * (Input::get('price') * $newQty)
                            );

        $updateTemp   = DB::table('tmp_receiving')->where('id', $id)->update($dataTemp);

    }

    public function auto_invoice()
    {
        
        $code   = DB::select('select max(invoice_no) as code from orders');
        foreach ($code as $key) 
        {
            $kode = substr($key->code, 3,4);

        }
        
        $plus = $kode+1;
        if($plus < 10)
        {
            $id = "INV000".$plus;
        }
        else
        {
            $id = "INV00".$plus;
        }

        return $id;
    }

    public function destroy($id)
    {
        $data = DB::table('tmp_receiving')->where('id', $id)->delete();
    }

    public function cancelreturn($id)
    {
        $tmpID            = DB::table('return_receiving')->where('id', $id)->value('tmp_id');
        $oldQty           = DB::table('tmp_receiving')->where('id', $tmpID)->value('qty');
        $oldDiscount_per  = DB::table('tmp_receiving')->where('id', $tmpID)->value('discount_per');
        $qty              = DB::table('return_receiving')->where('id', $id)->value('qty');
        $price            = DB::table('return_receiving')->where('id', $id)->value('price');
        $data             = array(
                                    'qty'      => $oldQty + $qty,
                                    'diskonrp' => ($oldDiscount_per / 100) * ($oldQty + $qty) * $price,
                                    'subtotal' => (($oldQty + $qty) * $price) - (($oldDiscount_per / 100) * ($oldQty + $qty) * $price)
                                 );

        $tmpData = DB::table('tmp_receiving')->where('id', $tmpID)->update($data);
        $data    = DB::table('return_receiving')->where('id', $id)->delete();
    }

    public function editreceiving($id)
    {
        $data = DB::table('tmp_receiving')
              ->join('item', 'tmp_receiving.item_id', '=', 'item.id')
              ->select('tmp_receiving.*', 'item.product_name', 'item.product_stock')
              ->where('tmp_receiving.id', $id)->first();

        echo json_encode($data);
    }

    public function returnreceiving($id)
    {
        $data = DB::table('tmp_receiving')
              ->join('item', 'tmp_receiving.item_id', '=', 'item.id')
              ->select('tmp_receiving.*', 'item.product_name', 'item.product_stock')
              ->where('tmp_receiving.id', $id)->first();

        echo json_encode($data);
    }

    public function check_returnID()
    {
        $searchVal = Input::get('item_name1');

        try
        {
            $sql       = DB::table('return_receiving')->where('item_name', $searchVal)->value('item_name');
            $count     = count($sql);

            if($count > 0)
            {
                return 'false';
            }
            else
            {
                return 'true';
            }
        }

        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function check_tempID()
    {
        $searchVal = Input::get('item_name');

        try
        {
            $sql       = DB::table('tmp_receiving')->where('item_name', $searchVal)->value('item_name');
            $count     = count($sql);

            if($count > 0)
            {
                return 'false';
            }
            else
            {
                return 'true';
            }
        }

        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function update()
    {
        $id    = Input::get('id');
        $post  = Input::all();
        
        $data  = array(
                    'id'           => Input::get('id'),
                    'invoice_no'   => Input::get('invoice_no'),
                    'item_id'      => Input::get('item_id'),
                    'item_name'    => Input::get('item_name'),
                    'qty'          => Input::get('qty'),
                    'price'        => Input::get('price'),
                    'discount_per' => Input::get('discount_per'),
                    'diskonrp'     => Input::get('diskonrp'),
                    'discount'     => (Input::get('discount_per') / 100) * (Input::get('price') * Input::get('qty')),
                    'subtotal'     => (Input::get('price') * Input::get('qty')) - Input::get('discount'),
                    'user'         => Sentinel::getUser()->id
                    );
        
        $rules = array('item_name'  => 'required', 'qty' => 'required|numeric', 'discount_per' => 'numeric');
        $validator = Validator::make($post, $rules);
        
        if($validator->fails())
        {
            return Redirect::to('addreceiving')->withErrors($validator)->withInput();
        }
        else
        {
            $update  = DB::table('tmp_receiving')->where('id', $id)->update($data);
        }

    }

    public function invoice($id)
    {
        $list = DB::table('order_detail')
                ->join('orders', 'order_detail.invoice_no', '=', 'orders.invoice_no')
                ->join('customer', 'order_detail.order_id', '=', 'customer.id')
                ->select('order_detail.*', 'orders.date_order', 'customer.name', 'customer.address', 'customer.phone', 'customer.email')
                ->where('order_detail.invoice_no', $id)->first();

        $list2 = DB::table('order_detail')
                ->join('orders', 'order_detail.invoice_no', '=', 'orders.invoice_no')
                ->join('customer', 'order_detail.order_id', '=', 'customer.id')
                ->select('order_detail.*', 'orders.date_order', 'customer.name', 'customer.address', 'customer.phone', 'customer.email')
                ->where('order_detail.invoice_no', $id)->get();

        $subtotal = DB::table('order_detail')->where('invoice_no', $id)->sum('amount');
        return view('receivings.invoice', compact('list', 'subtotal', 'list2'));
    }


}
