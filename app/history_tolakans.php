<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class history_tolakans extends Model
{
    //
    public $timestamps = false;
    protected $fillable=[
        'idpenjaminan',
        'alasan',
        'tgl_tolak',
        'user',
        'cek',
    ];
}
