<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingSystem extends Model
{
    protected $table = 'setting_system';
    protected $fillable = [
    	'page_per_rows',
    	'language_id',
    	'timezone',
    	'prefix_invoice'
    ];
}
