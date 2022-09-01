<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;

class blogs extends Model
{
    
    //use SoftDeletes;
    
    //protected  $dates = ['deleted_at'];
    
    public  $timestamps=false;
    
    protected $fillable=['title','description','created_at'];
//    protected $guarded=['created_at'];//untuk memfilter isian di database
}
