<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deposit;
use App\Models\Customer;
use App\Models\Bank;
use App\Models\PaymentType;
use App\Http\Requests;
use DB,Validator,Input,Redirect,Session,Sentinel,Response,Carbon\Carbon;
class DepositController extends Controller
{
    public function __construct() {
        $this->middleware('webAuth');
    }

    public function index()
    {
        $data['title'] = 'Input Deposit Customer';
        $data['data']  = Deposit::with('customer')->get();
                         /*Deposit::join('customer', 'deposit.customer_id', '=', 'customer.id')
                         ->select('customer.name', 'customer.address', 'customer.city', 'customer.zip_code', 'deposit.amount as deposit')
                         ->get();*/

        return view('deposit.index', $data);
    }

    public function create()
    {
        $data['title']          = 'Input Deposit Customer';
        $data['customer']       = Customer::drop_options();
        $data['payment_method'] = PaymentType::drop_options();
        $data['bank']           = Bank::drop_options();
        return view('deposit.create', $data);
    }

    public function store(Request $request)
    {
          $cek = Deposit::where('customer_id', $request->input('customer_id'))->count();  
          if($cek)
          {
              return back()->with('errorMessage', 'The Customer has already been deposit.');  
          }

          $cekCardNo = Deposit::where('card_no', $request->input('card_no'))->count();
          if($cekCardNo)
          {
              return back()->with('errorMessage', 'The Card No. has already been taken.');  
          }

          Deposit::create($request->all());
          return redirect('deposit')->with('successMessage', 'Deposit has been Created');
    }
}
