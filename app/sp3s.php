<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sp3s extends Model
{
    //
    
    public $timestamps = false;
    protected $fillable=[
        'idpenjaminan',
        'tglterbit',
        'user',
    ];
}
