<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;

class User extends SentinelUser
{
    
    protected $fillable = [
        'id',
        'email',
        'username',
        'password',
        'last_name',
        'first_name',
        'permissions',
        'avatar'
    ];

    public static $rules = [
        'username'          => 'required|min:5|unique:users,username,:id',
        'email'             => 'required|email|unique:users,email,:id',
        'password'          => 'confirmed|required|min:5',
        'first_name'        => 'required',
        'last_name'         => 'required',
        'role_id'           => 'required'
    ];

    protected $loginNames = ['email', 'username'];

    public function PurchaseOrder()
    {
        return $this->hasMany('App\Models\PurchaseOrder', 'orderby', 'id');
    }

    public function role() {
    	return $this->belongsToMany('App\Models\Role','role_users','role_id','user_id');
    }

    public function historyUser()
    {
        return $this->hasMany('App\Models\HistoryUser', 'user_id');
    }

}
