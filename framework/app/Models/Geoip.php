<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Geoip extends Model
{
    protected $table = 'login_location';
    protected $fillable = ['user_id', 'ip', 'isocode', 'country', 'city', 'state', 'postal_code', 'timezone', 'lat', 'lon'];

    public function user()
    {
    	return $this->belongsTo('App\Models\User', 'user_id');
    }
}
