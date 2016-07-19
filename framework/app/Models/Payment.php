<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    
	protected $fillable = ['invoice_no', 'payment_date', 'amount', 'is_paid', 'user_id', 'receipt_no', 'payment_type'];

	public static function generate_faktur()
	{
		$query      = Payment::orderBy('receipt_no', 'desc')->take(1)->value('receipt_no'); 
        $code       = substr($query, -4);
        $month      = substr($query, -6,2);
        $this_month = date('m');
        $today      = date('ym');
        $num        = (int)$code;

        if($num==0 || $num==null || $month!=$this_month)
        {
          $temp = 1;
        }
        else
        {
          $temp = $num+1;
        }

        $temp2  = "REC".$today."".str_pad($temp, 4, 0, STR_PAD_LEFT);
        return $temp2;
	}
}
