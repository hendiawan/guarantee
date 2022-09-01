<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class t_history_banks extends Model
{
    public  $timestamps=false;
    
    protected $fillable=[
        'nama_perubahan',
        'tgl_perubahan'];
   
}
