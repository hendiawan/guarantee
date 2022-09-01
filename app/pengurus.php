<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\users;

class pengurus extends Model {
    //
    protected $table = 'pengurus';
    public $timestamps = false;
    protected $fillable = [
        'nama',
        'jabatan',
        'url',
        'tgl_efektif', 
        'user_id',  
        ];
    
       
    public function user()
    {
        return $this->hasOne(users::class,'id','user_id');
    }
    
}
