<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchType extends Model
{
    protected $table    = 'branch_type';
    protected $fillable = ['name'];

    public function branch()
    {
    	return $this->hasMany('App\Models\Branch', 'type', 'id');
    }

    public static function drop_options()
    {
        $query = BranchType::pluck('name', 'id');
        return $query;
    }

}
