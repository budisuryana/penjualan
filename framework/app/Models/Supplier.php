<?php

namespace App\Models;
use DB,Input,Response;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';
    protected $fillable = [
        'id',
        'name',
        'address',
        'phone',
        'email'
    ];

    public function PurchaseOrder()
    {
        return $this->hasMany('App\Models\PurchaseOrder', 'supplier_id', 'id');
    }

    public static function drop_options()
    {
        $query = Supplier::pluck('name', 'id');
        return $query;
    }

}
