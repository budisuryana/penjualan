<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table     = 'product';
    public $timestamps   = false;
    protected $fillable  = [
        'id',
        'productcode',
        'name',
        'category_id',
        'stock',
        'cost_price',
        'sell_price',
        'discount',
        'created_at',
        'updated_at'

    ];

    public function category()
    {
        return $this->belongsTo('\App\Models\Category', 'category_id', 'id');
    }

    public function itemSupplier()
    {
        return $this->belongsToMany('\App\Models\Supplier','item_supplier', 'product_id', 'supplier_id');
    }

}
