<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['taxNumber', 'bussinesName', 'name', 'abbreviation', 'directory'];




    public function addresses()
    {
        return $this->morphMany('App\Address', 'addressable');
    }
    public function contacts()
    {
        return $this->morphMany('App\Contact', 'contactable');
    }
}
