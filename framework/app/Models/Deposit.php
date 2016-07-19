<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $table = 'deposit';
    
	protected $fillable = ['deposit_date', 'amount', 'user_id', 'customer_id', 'payment_method', 'bank_id', 'giro_no', 'card_no'];

	public function customer()
	{
		return $this->belongsTo('App\Models\Customer', 'customer_id', 'id');
	}

	public static function boot() {

		parent::boot();
		static::saving(function($obj) {
			$obj->amount = str_replace(",","", \Input::get('amount'));
			$obj->deposit_date = \Carbon\Carbon::now('Asia/Jakarta')->toDateTimeString();
			$obj->user_id = \Sentinel::getUser()->id;
		});
	
	}
}
