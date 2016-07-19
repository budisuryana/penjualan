<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\SettingSystem;
use DB, Carbon\Carbon;
use App\Http\Requests;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
    	$system           = SettingSystem::all();
        $data['customer'] = Customer::pluck('name', 'id');
    	$data['status']   = ['unpaid' => 'Unpaid', 'paid' => 'Paid'];
    	$data['query']    = Sales::join('customer', 'orders.customer_id', '=', 'customer.id')
	    					 ->join('order_detail', 'orders.invoice_no', '=', 'order_detail.invoice_no')
	    					 ->select('orders.*', 'customer.name', DB::raw('sum(order_detail.amount) as billing'))
	    					 ->orderBy('invoice_date');

    	if($request->from) $data['query']->where('invoice_date', '>=', $request->from);
	    	else
	            $data['query']->where('invoice_date', '>=', Carbon::now()->format('Y-m-d'));

    	if($request->until) $data['query']->where('invoice_date', '<=', Carbon::parse($request->until)->addDays(1));
    		else
            	$data['query']->where('invoice_date', '<=', Carbon::now()->addDays(1)->format('Y-m-d'));

    	if($request->invoice_no) $data['query']->where('orders.invoice_no', 'like', '%'.$request->invoice_no.'%');
    	if($request->customer) $data['query']->where('customer.name', 'like', '%'.$request->customer.'%');
    	if($request->status) $data['query']->where('orders.paid_status', '=', $request->status);

    	$data['data'] = $data['query']->paginate($system[0]['page_per_rows']);

    	return view('report.sales', $data)->withTitle('Sales Report');
    }

    public function product(Request $request)
    {
        $system  = SettingSystem::all();
        $data['supplier'] = Supplier::pluck('name', 'id');
        $data['category'] = Category::pluck('name', 'id');
        $data['query'] = Product::join('item_supplier', 'product.id', '=', 'item_supplier.product_id')
                         ->join('category', 'product.category_id', '=', 'category.id')
                         ->leftJoin('supplier', 'item_supplier.supplier_id', '=', 'supplier.id')
                         ->select('product.*', 'category.name as category', 'supplier.name as supplier')
                         ->orderBy('product.name', 'asc');

        if($request->productcode) $data['query']->where('product.productcode', 'like', '%'.$request->productcode.'%');
        if($request->name) $data['query']->where('product.name', 'like', '%'.$request->name.'%');
        if($request->supplier_id) $data['query']->where('item_supplier.supplier_id', '=', $request->supplier_id);
        if($request->category_id) $data['query']->where('product.category_id', '=', $request->category_id);

        $data['data'] = $data['query']->paginate($system[0]['page_per_rows']);

        return view('report.product', $data)->withTitle('Products Report');

    }
}
