<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branch';
    protected $fillable = [
        'name',
        'description',
        'address',
        'city',
        'zip_code',
        'phone',
        'type'
    ];

    public function PurchaseOrder()
    {
        return $this->hasMany('App\Models\PurchaseOrder', 'branch_id', 'id');
    }

    public function branchType()
    {
        return $this->belongsTo('\App\Models\BranchType', 'type', 'id');
    }

    public static function drop_options()
    {
        $query = array('' => '') + Branch::pluck('name', 'id')->toArray();
        return $query;
    }
}
