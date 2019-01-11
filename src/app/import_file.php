<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class import_file extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['fileName', 'supplier_id', 'status'];
}
