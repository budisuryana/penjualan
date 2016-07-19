<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class PurchaseOrder extends Model

{

    protected $table = 'purchase_order';

    protected $fillable = [

        'po_no',
        'supplier_id',
        'branch_id',
        'supplier_id',
        'date_order',
        'orderby'

    ];

    public function supplier()
    {
    	return $this->belongsTo('App\Models\Supplier', 'supplier_id', 'id');
    }

    public function branch()
    {
    	return $this->belongsTo('App\Models\Branch', 'branch_id', 'id');
    }

    public function user()
    {
    	return $this->belongsTo('App\Models\User', 'orderby', 'id');
    }

}

