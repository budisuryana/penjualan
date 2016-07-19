<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\Category;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderDetail;
use App\Models\Branch;
use App\Models\PaymentType;
use App\Models\SettingSystem;
use App\Models\SettingGeneral;
use DB,Validator,Input,Redirect,Session,Sentinel,Response,Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SalesController extends Controller
{
    public function __construct() {
        $this->middleware('webAuth');
    }
    
    public function index()
    {
        $data['title']   = 'Sales Transactions';
        $data['invoice'] = $this->auto_invoice();
        $data['data']    = Sales::join('customer', 'orders.customer_id', '=', 'customer.id')
                           ->join('order_detail', 'orders.invoice_no', '=', 'order_detail.invoice_no')
                           ->select('orders.*','customer.name as customer', DB::raw('sum(order_detail.amount) as billing'))
                           ->groupBy('orders.invoice_no')
                           ->get();

        return view('sales.index', $data);
    }

    public function create()
    {
        $data['title']       = 'New Invoice';
        $data['invoice']     = $this->auto_invoice();
        $data['customer']    = Customer::drop_options();
        $data['custID']      = null;
        $data['branch_id']   = Sentinel::getUser()->branch_id;
        $data['branchname']  = Branch::where('id', $data['branch_id'])->value('name');
        return view('sales.create', $data);
    }

    public function auto_item()
    {
        $term = Input::get('term');
    
        $results = array();
        
        $queries = Product::where('name', 'LIKE', '%'.$term.'%')
                   ->orWhere('id', 'LIKE', '%'.$term.'%')
                   ->get();
        
        foreach ($queries as $query)
        {
            $count   = DB::table('po_detail')->where('product_id', $query->id)->count();
            $summary = DB::table('po_detail')->where('product_id', $query->id)->sum('price');

            if($count)
            {
                $costPrice = $summary/$count;
            }
            else
            {
                $costPrice = 0;
            }

            $results[] = [
                            'id' => $query->id,
                            'cost_price' => $costPrice,
                            'sell_price' => $query->sell_price,
                            'value' => $query->name,
                         ];
        }

        return Response::json($results);
    }

    public function addItem(Request $request)
    {
        $rules = [
                   'name'           => 'required',
                   'qty'            => 'required|numeric',
                   'price'          => 'required|numeric',
                   'discount_per'   => 'numeric',
                   'discount_value' => 'numeric',
                   'amount'         => 'required|numeric'
                 ];

        $data  = [
                  'id'             => Input::get('id'),
                  'name'           => Input::get('name'),
                  'qty'            => Input::get('qty'),
                  'price'          => Input::get('price'),
                  'discount_per'   => Input::get('discount_per'),
                  'discount_value' => Input::get('discount_value'),
                  'amount'         => Input::get('amount')
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

        Session::put('invoice', Input::get('invoice'));
        Session::put('branch_id', Input::get('branch_id'));
        Session::put('customer_id', Input::get('customer_id'));

        $temp = [
                  'id'             => Input::get('id'),
                  'name'           => Input::get('name'),
                  'qty'            => Input::get('qty'),
                  'price'          => Input::get('price'),
                  'discount_per'   => Input::get('discount_per'),
                  'discount_value' => Input::get('discount_value'),
                  'amount'         => Input::get('amount')
                ];
            
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
               'data' => $temp
               ]);
    }

    public function store(Request $request)
    {
        $rules = [
                   'branch_id'    => 'required',
                   'customer_id'  => 'required',
                   'invoice_date' => 'required|date'
                 ];

            $this->validate($request, $rules);

            DB::beginTransaction();
            try { 
                
                $order = DB::table('orders')->insert([
                          'invoice_no'    => Input::get('invoice_no'),
                          'customer_id'   => Input::get('customer_id'),
                          'invoice_date'  => Carbon::parse(Input::get('invoice_date'))->format('Y-m-d'),
                          'paid_status'   => 'Unpaid',
                          'type'          => 'Invoice',
                          'user_id'       => Sentinel::getUser()->id,
                          'created_at'    => Carbon::now()->format('Y-m-d'),
                          'updated_at'    => Carbon::now()->format('Y-m-d')
                      ]);

                foreach (Session::get('items') as $value) {
                    $categoryCode = Product::where('id', $value['id'])->value('category_id');
                    $podetail = DB::table('order_detail')->insert([
                                'invoice_no'     => Input::get('invoice_no'),
                                'product_id'     => $value['id'],
                                'category_id'    => $categoryCode,
                                'qty'            => $value['qty'],
                                'price'          => $value['price'],
                                'discount_per'   => $value['discount_per'],
                                'discount_value' => $value['discount_value'],
                                'amount'         => $value['amount'],
                                'created_at'     => Carbon::now()->format('Y-m-d'),
                                'updated_at'     => Carbon::now()->format('Y-m-d')
                                ]);

                    Session::forget('items');
                    Session::forget('invoice_no');
                }

                $amount  = DB::table('order_detail')->where('invoice_no', Input::get('invoice_no'))->sum('amount');
                $payment = DB::table('payment')->insert([
                          'invoice_no'    => Input::get('invoice_no'),
                          'payment_date'  => Carbon::now()->format('Y-m-d'),
                          'amount'        => $amount,
                          'user_id'       => Sentinel::getUser()->id,
                          'customer_id'   => Input::get('customer_id'),
                          'created_at'    => Carbon::now()->toDateTimeString(),
                          'updated_at'    => Carbon::now()->toDateTimeString()
                      ]);
            }
            
            catch(\Illuminate\Database\QueryException $e) {
                DB::rollback();
                return redirect()->back()->with('errorMessage', 'Integrity Constraint');
            }

            DB::commit();
            Session::flash('successMessage', 'New Invoice Created');
            return Redirect('sale');
    }

    public function auto_invoice()
    {
        $system = SettingSystem::all();
        $prefix = $system[0]['prefix_invoice'];
        $code   = DB::select('select max(invoice_no) as code from orders');
        foreach ($code as $key) 
        {
            $kode = substr($key->code, 3,4);

        }
        
        $plus = $kode+1;
        if($plus < 10)
        {
            $id = $prefix."000".$plus;
        }
        else
        {
            $id = $prefix."00".$plus;
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

    public function clearsale()
    {
        Session::forget('items');
        Session::forget('invoice');
        Session::forget('customer_id');
    }

    public function invoice($id)
    {
        $data['data1'] = DB::table('orders')
                            ->join('order_detail', 'orders.invoice_no', '=', 'order_detail.invoice_no')
                            ->leftJoin('category', 'order_detail.category_id', '=', 'category.id')
                            ->leftJoin('product', 'order_detail.product_id', '=', 'product.id')
                            ->select('order_detail.*', 'orders.*', 'category.name as category', 'product.name as product')
                            ->where('orders.invoice_no', $id)->get();

        $data['data2'] = DB::table('orders')
                            ->join('customer', 'orders.customer_id', '=', 'customer.id')
                            ->join('users', 'orders.user_id', '=', 'users.id')
                            ->select('orders.invoice_no', 'orders.invoice_date', 'customer.*', 'users.first_name', 'users.last_name', 'users.email as emailuser')
                            ->where('orders.invoice_no', $id)->first();

        $data['total'] = DB::table('order_detail')->where('invoice_no', $id)->sum('amount');

        return view('sales.invoice', $data);
    }

}
