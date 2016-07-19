<?php



namespace App\Models;

use DB;

use Illuminate\Database\Eloquent\Model;



class HistoryUser extends Model

{

    protected $table = 'history_user';

    protected $fillable = [

        'entry_time',

        'user_id',

        'description'

    ];

    public function user()
    {
    	return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    

}

