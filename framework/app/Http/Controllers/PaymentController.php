<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\Sales;
use App\Models\Bank;
use App\Models\Customer;
use DB,Validator,Input,Redirect,Session,Sentinel,Response,Carbon\Carbon;
use App\Http\Requests;

class PaymentController extends Controller
{
    public function __construct() {
        $this->middleware('webAuth');
    }
    
    public function index()
    {
        $data['title']   = 'List Payment';
        $data['data']    = Payment::join('order_detail', 'payment.invoice_no', '=', 'order_detail.invoice_no')
                           ->join('orders', 'order_detail.invoice_no', '=', 'orders.invoice_no')
                           ->join('customer', 'orders.customer_id', '=', 'customer.id')
                           ->select('payment.invoice_no', 'payment.receipt_no', 'orders.invoice_date', 'customer.name', 
                           			DB::raw('(case when payment.is_paid = "N" then "Unpaid" else "Paid" end) as status'), 
                           			DB::raw('sum(order_detail.amount) as billing'))
                           ->groupBy('orders.invoice_no')
                           ->get();

        return view('payment.index', $data);
    }

    public function create($id)
    {
    	$data['title']          = 'Add Payment';
    	$data['payment_method'] = PaymentType::drop_options();
      $data['bank']           = Bank::drop_options();
      $data['receipt_no']     = Payment::generate_faktur();
    	$data['code']           = DB::table('orders')->where('invoice_no', $id)->value('customer_id');
    	$data['customer']       = Customer::find($data['code']);

    	$data['dataSale']       = DB::table('orders')
                                ->join('order_detail', 'orders.invoice_no', '=', 'order_detail.invoice_no')
                                ->leftJoin('category', 'order_detail.category_id', '=', 'category.id')
                                ->leftJoin('product', 'order_detail.product_id', '=', 'product.id')
                                ->select('order_detail.*', 'orders.*', 'category.name as category', 'product.name as product')
                                ->where('orders.invoice_no', $id)->get();

        $data['subtotal']     = DB::table('order_detail')->where('invoice_no', $id)->sum('amount');
        $data['tax']          = (5/100) * $data['subtotal'];
        $data['total']        = $data['subtotal'] + $data['tax'];
        $data['totalDisc']    = DB::table('order_detail')->where('invoice_no', $id)->sum('discount_value');
        $data['grandtotal']   = $data['subtotal'] + $data['totalDisc'];
    	return view('payment.create', $data);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
          Payment::where('invoice_no', $request->input('invoice_no'))->update([
                   'payment_date'  => Carbon::now('Asia/Jakarta')->toDateTimeString(),
                   'is_paid'       => 'Y',
                   'user_id'       => Sentinel::getUser()->id,
                   'receipt_no'    => Payment::generate_faktur(),
                   'payment_type'  => $request->payment_method,
                   'bank_id'       => $request->bank,
                   'giro_no'       => $request->giro_no,
                   'card_no'       => $request->card_no,
                   'totaldisc'     => $request->totaldisc,
                   'totaltax'      => $request->totaltax,
                   'amount_paid'   => str_replace(",","", $request->amount_paid),
                   'amount_change' => str_replace(",","", $request->amount_change),
                   'created_at'    => Carbon::now('Asia/Jakarta')->toDateTimeString(),
                   'updated_at'    => Carbon::now('Asia/Jakarta')->toDateTimeString()
                   ]);

          Sales::where('invoice_no', $request->input('invoice_no'))->update(['paid_status' => 'Paid']);
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->with('errorMessage', 'Something Went Wrong, Please Try Again.');
        }

        DB::commit();
        return redirect('payment')->with('successMessage', 'Invoice has been Paid');
    }

    public function revision(Request $request)
    {
        $data['title']   = 'Payment Revision';
        $data['invoice'] = Payment::where('is_paid', 'Y')->pluck('invoice_no', 'invoice_no');
        $data['query']   = Payment::join('customer', 'payment.customer_id', '=', 'customer.id')
                           ->select('payment.*', 'customer.name')
                           ->where('invoice_no', $request->input('invoice'))
                           ->get();

        $data['cnt']     = count($data['query']);
        return view('payment.revision', $data);
    }

    public function storeRevision(Request $request)
    {
        $rules = ['description' => 'required'];

        $this->validate($request, $rules);
        
        Payment::where('invoice_no', $request->input('invoice_no'))->update([
                 'is_paid' => 'N',
                 'description' => $request->input('description'),
                 'amount_paid' => 0,
                 'amount_change' => 0,
                 'receipt_no' => '',
                 'payment_type' => '',
                 'bank_id' => '',
                 'card_no' => '',
                 'giro_no' => '',
                 'totaldisc' => 0,
                 'totaltax' => 0
                 ]);

        Sales::where('invoice_no', $request->input('invoice_no'))->update(['paid_status' => 'Unpaid']);

        return redirect('payment')->with('successMessage', 'Payment has been revised');

    }

}
