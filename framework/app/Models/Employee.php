<?php

namespace App\Models;
use DB,Input,Response;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';
    public $primaryKey = 'employeecode';
    public $incrementing = false;
    protected $fillable = [
        'employeecode',
        'name',
        'address',
        'phone',
        'city',
        'zip_code',
        'email'
    ];

    public static function getName($id)
    {
        $query  = Employee::find($id);
        foreach ($query as $row) 
        {
            $name = $row->name;
        }
        
        return $name;
    }

    public static function drop_options()
    {
        $query = array('' => '') + Employee::pluck('name', 'employeecode')->toArray();
        return $query;
    }

    public static function autocomplete()
    {
        $term = Input::get('term');
    
        $results = array();
        
        $queries = Employee::where('name', 'LIKE', '%'.$term.'%')->get();
        
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->employeecode, 'value' => $query->name ];
        }
        return Response::json($results);
    }
}
