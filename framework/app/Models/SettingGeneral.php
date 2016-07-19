<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingGeneral extends Model
{
    protected $table    = 'setting_general';
    protected $fillable = [
    	'app_name', 
    	'app_description',
    	'company', 
    	'company_address',
    	'logo', 
    	'phone',
    	'fax', 
    	'email'
    ];
}
