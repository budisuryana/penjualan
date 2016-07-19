<?php



namespace App\Models;

use DB,Input,Response;

use Illuminate\Database\Eloquent\Model;



class Customer extends Model

{

    protected $table = 'customer';
    protected $fillable = [
        'name',
        'address',
        'phone',
        'city',
        'zip_code',
        'email'
    ];

    public function orders()
    {
        return $this->hasMany('App\Models\Sales', 'customer_id', 'id');
    }

    public static function getName($id)
    {
        $query  = Customer::find($id);
        foreach ($query as $row) 
        {
            $name = $row->name;
        }
        return $name;
    }

    public static function drop_options()
    {
        $query = array('' => 'Select Customer') + Customer::pluck('name', 'id')->toArray();
        return $query;
    }

    public static function autocomplete()
    {

        $term = Input::get('term');
        $results = array();
        $queries = Customer::where('name', 'LIKE', '%'.$term.'%')->get();
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->id, 'value' => $query->name ];
        }
        return Response::json($results);

    }

}

