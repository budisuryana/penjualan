<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PurchaseOrder;

use App\Models\Branch;

use App\Models\Category;

use App\Models\Supplier;

use App\Models\Product;

use App\Models\Unit;

use DB;

use Validator;

use Input;

use Redirect;

use Session;

use Sentinel;

use Response;

use Carbon\Carbon;

use App\Http\Requests;

use App\Http\Controllers\Controller;



class POController extends Controller

{

    public function __construct() {

        $this->middleware('webAuth');

    }

    public function index()

    {

        $data['title']   = 'List Purchase Order';

        $data['invoice'] = $this->auto_po_no();

        $data['data']    = PurchaseOrder::with('supplier', 'branch', 'user')->get();

        return view('po.index', $data);

    }



    public function create()

    {

        $data['title']       = 'Purchase Order';

        $data['po_no']       = $this->auto_po_no();

        $data['supplier']    = Supplier::drop_options();

        $data['branch_id']   = Sentinel::getUser()->branch_id;

        $data['branchname']  = Branch::where('id', $data['branch_id'])->value('name');

        $data['conversion']  = DB::table('unit_conversion as a')

                                    ->join('unit AS b', 'a.parent_unit', '=', 'b.id')

                                    ->join('unit AS c', 'a.child_unit', '=', 'c.id')

                                    ->select('a.id', DB::raw('concat("1 ",b.name, " = ", a.qty_conversion, " ", c.name ) as unit'))

                                    ->lists('unit', 'id');

        return view('po.create', $data);

    }

    public function store(Request $request)

    {

        $rules = [
                   'po_no'        => 'required',
                   'supplierid'   => 'required',
                 ];

            $this->validate($request, $rules);

            DB::beginTransaction();
            try { 
                
                $order = DB::table('purchase_order')->insert([
                          'po_no'       => Input::get('po_no'),
                          'supplier_id' => Input::get('supplierid'),
                          'branch_id'   => Input::get('branch_id'),
                          'date_order'  => Carbon::now()->format('Y-m-d'),
                          'orderby'     => Sentinel::getUser()->id,
                          'created_at'  => Carbon::now()->format('Y-m-d'),
                          'updated_at'  => Carbon::now()->format('Y-m-d')
                      ]);

                foreach (Session::get('items') as $value) {
                    $categoryId = Product::where('id', $value['id'])->value('category_id');
                    $unitId     = DB::table('unit_conversion')
                                  ->where('id', $value['unit_conversion_id'])
                                  ->value('parent_unit');

                    $podetail = DB::table('po_detail')->insert([
                                'po_no'              => Input::get('po_no'),
                                'supplier_id'        => Input::get('supplierid'),
                                'product_id'         => $value['id'],
                                'category_id'        => $categoryId,
                                'unit_id'            => $unitId,
                                'unit_conversion_id' => $value['unit_conversion_id'],
                                'qty'                => $value['qty'],
                                'price'              => $value['price'],
                                'discount_per'       => $value['discount_per'],
                                'discount_value'     => $value['discount_value'],
                                'amount'             => $value['amount'],
                                'created_at'         => Carbon::now()->format('Y-m-d'),
                                'updated_at'         => Carbon::now()->format('Y-m-d')
                                ]);

                    Session::forget('items');
                    Session::forget('po_no');
                }

            }
            
            catch(\Illuminate\Database\QueryException $e) {
                DB::rollback();
                return redirect()->back()->with('errorMessage', 'Integrity Constraint');
            }

            DB::commit();
            Session::flash('successMessage', 'New Purchase Order Created');
            return Redirect('po');

    }

    public function addItem(Request $request)

    {

        $rules = [
                   'name'               => 'required',
                   'qty'                => 'required|numeric',
                   'unit_conversion_id' => 'required',
                   'price'              => 'required|numeric',
                   'discount_per'       => 'numeric',
                   'discount_value'     => 'numeric',
                   'amount'             => 'required|numeric'
                 ];

        $data  = [
                  'id'                 => Input::get('id'),
                  'name'               => Input::get('name'),
                  'qty'                => Input::get('qty'),
                  'unit_conversion_id' => Input::get('unit_conversion_id'),
                  'unit_name'          => Input::get('unit_conversion_id'),
                  'price'              => Input::get('price'),
                  'discount_per'       => Input::get('discount_per'),
                  'discount_value'     => Input::get('discount_value'),
                  'amount'             => Input::get('amount')
                 ];

        $validator = Validator::make($data, $rules);
            
        if($validator->fails())
        {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()->toArray(),
                'is_rules'  => 0
                ]);
        }

        Session::put('po_no', Input::get('po_no'));
        Session::put('branch_id', Input::get('branch_id'));
        Session::put('supplierid', Input::get('supplierid'));

        $temp = [
                  'id'                 => Input::get('id'),
                  'name'               => Input::get('name'),
                  'qty'                => Input::get('qty'),
                  'unit_conversion_id' => Input::get('unit_conversion_id'),
                  'price'              => Input::get('price'),
                  'discount_per'       => Input::get('discount_per'),
                  'discount_value'     => Input::get('discount_value'),
                  'amount'             => Input::get('amount')
                ];
        
        $unitId = DB::table('unit_conversion')
                      ->where('id', $temp['unit_conversion_id'])
                      ->value('parent_unit');

        $unit   = Unit::find($unitId);

        if(!is_null(Session::get('items')))
        {
            $arrtmp = Session::get('items');
            $exist = FALSE;         
            foreach ($arrtmp as $key => $value) {
              if(Input::get('id') == $value['id']){
                $exist = TRUE;
              };
            }
        
            if($exist)
            {
                return response()->json([
                'errors'   => 'Product '.Input::get('name').' has already been taken',
                ]);
            }
        }
            
        Session::push('items', $temp);
        return response()->json([
               'success'  => true,
               'data' => $temp,
               'unit' => $unit->name
               ]);
        
    }

    public function auto_po_no()

    {

        $code   = PurchaseOrder::select(DB::raw('max(po_no) as code'))->get();

        foreach ($code as $key) 

        {
            $kode = substr($key->code, 3,3);
        }

        $plus = $kode+1;

        if($plus < 10)

        {

            $id = "PO000".$plus;
        }

        else

        {

            $id = "PO00".$plus;
        }

        return $id;

    }

    public function destroy($id)

    {

        if (Session::has('items') && is_array(Session::get('items'))) {
            $arr = Session::get('items');
            unset($arr[$id]);

            $arr = array_values($arr);
            Session::put('items', $arr);
            
            return back();
        }

    }

    public function invoice($id)

    {

        $list = DB::table('po_detail')

                ->join('purchase_order', 'po_detail.po_no', '=', 'purchase_order.po_no')
                ->join('supplier', 'po_detail.supplier_id', '=', 'supplier.id')
                ->select('po_detail.*', 'purchase_order.date_order', 'supplier.name', 'supplier.address', 'supplier.phone', 'supplier.email')

                ->where('po_detail.po_no', $id)->first();



        $list2 = DB::table('po_detail')

                ->join('purchase_order', 'po_detail.po_no', '=', 'purchase_order.po_no')
                ->join('product', 'po_detail.product_id', '=', 'product.id')
                ->join('category', 'po_detail.category_id', '=', 'category.id')
                ->join('unit', 'po_detail.unit_id', '=', 'unit.id')
                ->join('supplier', 'po_detail.supplier_id', '=', 'supplier.id')
                ->select('po_detail.*', 'product.name as product', 'category.name as category', 'unit.name as unit', 
                         'purchase_order.date_order', 'supplier.name', 'supplier.address', 'supplier.phone', 
                         'supplier.email')

                ->where('po_detail.po_no', $id)->get();



        $subtotal = DB::table('po_detail')->where('po_no', $id)->sum('amount');

        return view('po.invoice', compact('list', 'subtotal', 'list2'));

    }

}

