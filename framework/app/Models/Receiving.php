<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receiving extends Model
{
    protected $table = 'receiving';
    protected $fillable = [
        'supplier_id',
        'po_id'
    ];
}
