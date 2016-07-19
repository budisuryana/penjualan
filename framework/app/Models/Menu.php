<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $table = 'appmenu';
    public $primaryKey = 'menu_id';
    protected $fillable = [
        'description',
        'menu_url',
        'menu_alias',
        'ismenu',
        'parent',
        'menu_icon',
        'menu_order'
    ];

    
}
