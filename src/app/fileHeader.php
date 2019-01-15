<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class fileHeader extends Model
{
    protected $table = "files_headers";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['supplier_id', 'custNumber', 'custName', 'invoiceDate', 'fileName', 'status'];

    /**
     * Local Scopes
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
    public function scopeSupplier($query, $supplier_id)
    {
        return $query->where('supplier_id', $supplier_id);
    }

    public function test()
    {
        return "test";
    }

    public function bodies()
    {
        return $this->hasMany('App\fileBody', 'filesHeader_id');
    }
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

}
