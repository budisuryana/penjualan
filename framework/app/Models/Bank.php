<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'bank';
    protected $fillable = [
        'name'
    ];
    
    public static function getName($id)
    {
        $query  = Bank::find($id);
        foreach ($query as $row) 
        {
            $name = $row->name;
        }
        
        return $name;
    }

    public static function drop_options()
    {
        $query = array('' => 'Select Bank') + Bank::pluck('name', 'id')->toArray();
        return $query;
    }
}
