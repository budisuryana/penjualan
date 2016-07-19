<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    protected $table = 'states';
    protected $fillable = ['id', 'name', 'country_id'];

}
