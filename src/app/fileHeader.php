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
}
