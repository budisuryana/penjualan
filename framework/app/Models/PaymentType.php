<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    protected $table = 'payment_type';
    protected $fillable = [
        'name',
        'status'
    ];

    public static function drop_options()
    {
        $query = PaymentType::pluck('name', 'id');
        return $query;
    }
}
