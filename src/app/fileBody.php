<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class fileBody extends Model
{
    protected $table = "files_bodies";
    //


    public function header()
    {
        $this->belongsTo('App\fileHeader');
    }
}
