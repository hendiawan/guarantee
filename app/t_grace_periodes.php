<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class t_grace_periodes extends Model
{
    
//     public $timestamps = false;
    
     protected $fillable = [
        
        'id_penjaminan', 
        'tgl_mulai', 
        'periode', 
         'created_at',
         'updated-at',
        ];
    //
}
