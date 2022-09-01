<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class history_apps extends Model
{
    public $timestamps = false;
    protected $fillable=[
        'analisa',
        'approval',
        'tgl_analisa',
        'user',
        'idpenjaminan',
        'komputer'
    ];
}
