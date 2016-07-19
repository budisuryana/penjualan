<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'orders';
    
	public static $rulesOrder = [
		'invoice_no'    => 'required|unique:orders',
		'customer_id'   => 'required',
		'invoice_date'  => 'required|date',
		'due_date'      => 'required|date'
		
	];

	protected $fillable = [
		'invoice_no', 
		'customer_id', 
		'invoice_date', 
		'due_date', 
		'type', 
		'status', 
		'payment_date', 
		'payment_method'
	];

	public function customer()
	{
		return $this->belongsTo('App\Models\Customer', 'customer_id', 'id');
	}
}
