<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_terjamin extends Model
{
    //
    public $timestamps = false;
    protected  $connection='sqlsrv';
    protected $table='m_terjamin';
}
