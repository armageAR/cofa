<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'street',
        'number',
        'apartment',
        'city',
        'state',
        'zip',
        'country',
        'note',
        'type',
    ];

    protected $dates = ['deleted_at'];


}
