<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class AppMenu extends Model

{

    public $table = 'appmenu';

	public $primaryKey = 'menu_id';

    protected $fillable = [

        'menu_id',

        'description',

        'menu_url',

        'menu_alias',

        'ismenu',

        'parent',

        'menu_icon',

        'menu_order'

    ];



	public function role()

	{

		return $this->belongsToMany('App\Models\Role','appmenu_role','role_id','appmenu_id');

	}



	public function scopeMainMenu($query)

    {

        return $query->where(function ($qWhere) {

        	$qWhere->whereNull('parent');

        	$qWhere->whereIsmenu('Y');

        });

    }



    public function scopeIsMenu($query)

    {

    	return $query->whereIsmenu('Y');

    }

    public function scopeNotMenu($query)

    {

    	return $query->whereIsmenu('N');

    }

    public function scopeIsActive($query)

    {

        return $query->whereIsActive('Y');

    }


	public function childs() {

		return $this->hasMany('App\Models\AppMenu', 'parent', 'menu_id');

	}

	public function parent() {

		return $this->belongsTo('App\Models\AppMenu', 'parent', 'menu_id');

	}



    public static function drop_options()

    {

        $query = array(null => 'No Parent') + AppMenu::where('ismenu', 'Y')->pluck('description', 'menu_id')->toArray();

        return $query;

    }

}

