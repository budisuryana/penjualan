<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $item;
    protected $table      = 'item';
    protected $fillable   = [
                                'product_code',
                                'product_name',
                                'product_category_id',
                                'product_stock',
                                'product_cost_price',
                                'product_sell_price',
                                'status'
                            ];

    public function getName($id)
    {
        $query  = DB::table('item')->where('id', $id)->get();
        foreach ($query as $row) 
        {
            $name = $row->product_name;
        }
        
        return $name;
    }

    public function getCategoryId($id)
    {
        $query  = DB::table('item')->where('id', $id)->get(); 
        foreach ($query as $row) 
        {
            $name = $row->product_category_id;
        }
        return $name;
    }

    public function drop_options()
    {
        $query = Item::lists('product_name', 'id');
        return $query;
    }
}
