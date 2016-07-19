<?php

namespace App\Models;
use DB,Input,Response;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $fillable = [
        'name',
        'description'
    ];
    
    public function product()
    {
        return $this->hasMany('\App\Models\Product', 'category_id', 'id');
    }

    public static function getName($id)
    {
        $query  = Category::find($id);
        foreach ($query as $row) 
        {
            $name = $row->name;
        }
        
        return $name;
    }

    public static function drop_options()
    {
        $query = Category::pluck('name', 'id');
        return $query;
    }

    
}
