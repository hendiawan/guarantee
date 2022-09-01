<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\penjaminans;

class sertifikats extends Model
{
     
    public $timestamps = false;
    protected $fillable = [
        'kodesertifikat',
        'idpenjaminan',
        'tglterbit',
        'verify',
        'url',
        'digitalSign',
        'sinkronisasi',
        'tgl_sink',
        'diterbitkan'];
    
    public function  penjaminan()
    {
//        return $this->hasOne(penjaminans::class,'foreign_key','local_key');
          return $this->belongsTo(penjaminans::class,'idpenjaminan','idpenjaminan')
                  ->with('terjamin','kesehatan','bank','pembayaran');
    }
    
}
