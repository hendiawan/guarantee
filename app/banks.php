<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class banks extends Model
{
    public  $timestamps=false;
    
    protected $fillable=[
        'namabank',
        'kodecabang',
        'alamatbank',
        'telp',
        'dis',
        'admin',
        'materai',
        'share',
        'minijp'];

    
}
