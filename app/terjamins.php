<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class terjamins extends Model
{
    
     public $timestamps = false;
    
     protected $fillable = [
        
        'ktp', 
        'nama', 
        'phone', 
        'tempatlahir', 
        'tgllahir', 
        'umur', 
        'pekerjaan', 
        'jenis_pekerjaan', 
        'alamat', 
        'register', 
        'nama_perusahaan',
        'jabatan', 
        'masa_kerja', 
         
        ];
    //
}
