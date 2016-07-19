<?php

namespace App\Http\Controllers;

use DB,Sentinel,Carbon\Carbon,Datatables;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\HistoryUser;
use App\Models\Product;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
	public function __construct() {
		$this->middleware('webAuth');
	}

    public function index() {
    	
    	$data['title'] = 'Selamat datang di dashboard';

    	$data['open_invoice'] = DB::table('order_detail')
                            ->join('orders', 'order_detail.invoice_no', '=', 'orders.invoice_no')
                            ->select(DB::raw('sum(amount) as open_invoice'))
                            ->where('orders.paid_status', 'Unpaid')
                            ->where('orders.type', 'Invoice')
                            ->first();

		$data['paid'] = DB::table('payment')
                            ->select(DB::raw('sum(amount) as paid'))
                            ->where('is_paid', 'Y')
                            ->first();
        
        $data['popularity'] = DB::table('product')
                              ->select('name', DB::raw('max(sold) as total'))
                              ->get();

        $data['data'] = DB::table('orders')
                        ->join('customer', 'orders.customer_id', '=', 'customer.id')
                        ->join('order_detail', 'orders.invoice_no', '=', 'order_detail.invoice_no')
                        ->select(['orders.*','customer.name', DB::raw('sum(order_detail.amount) as billing')])
                        ->groupBy('orders.invoice_no')
                        ->get();

        $data['categories'] = [];
        $data['products']   = [];

        foreach (Category::all() as $data['category']) {
           array_push($data['categories'], $data['category']->name);
           array_push($data['products'], $data['category']->product->count());
        }

        $data['activities'] = HistoryUser::where('user_id', Sentinel::getUser()->id)
                             ->where('created_at', Carbon::now()->format('Y-m-d'))
                             ->orderBy('id', 'desc')
                             ->get();

    	return view('dashboard', $data);
    }

    
}
