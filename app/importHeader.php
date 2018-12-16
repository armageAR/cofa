<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class importHeader extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['custNumber', 'custName', 'invoiceDate', 'file_id', 'fileStatus'];
}
