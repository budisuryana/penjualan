<?php

namespace App\Models;
use Sentinel;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public $table      = 'order_detail';
	public static $rulesInsert = [
		'invoice_no'    => 'required',
		'order_id'      => 'required',
		'item_id'       => 'required',
		'item_name'     => 'required',
		'category_id'   => 'required',
		'category_name' => 'required',
		'qty'           => 'required|numeric',
		'price'         => 'required|numeric',
		'amount'        => 'required|numeric'
	];

	protected $fillable = ['invoice_no', 'order_id', 'item_id', 'item_name','category_id','category_name', 'qty', 'price', 'amount'];

}
