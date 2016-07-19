<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



use Cartalyst\Sentinel\Roles\EloquentRole as SentinelRole;



class Role extends SentinelRole

{

    public static $rules = [

        'name'          => 'required|min:2|unique:roles,name',
        'menu_id'       => 'required'

    ];



    public function appMenu() {

		return $this->belongsToMany('App\Models\AppMenu','appmenu_role','role_id','appmenu_id');

	}



	public function user() {

		return $this->belongsToMany('App\Models\User','role_users','role_id','user_id');

	}



	public function historyUser()

    {

        return $this->hasMany('App\Models\HistoryUser', 'role_id');

    }



    public static function drop_options()

    {

        $query = array('' => '') + Role::pluck('name', 'id')->toArray();

        return $query;

    }

    public static function boot() {

        parent::boot();
        static::saving(function($role) {
            $role->slug = str_slug(\Input::get('name'), '-');
        });
    
    }

}

