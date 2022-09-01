<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\m_rekanan_asuransi;

class t_reasuransi extends Model
{
    //
      protected $table = 't_reasuransi'; 
      public $timestamps = false;
      
       protected $fillable = [
            'penjaminan_id',
            'rekanan_id',
            'tgl_proses',
            'share',
            'nilai_jaminan',
            'ijp',
            'commision',
       ];
       
       public function rekanan(){
           return $this->belongsTo(m_rekanan_asuransi::class,'rekanan_id','id');
       }
       
       public function penjaminan()
       {
           return $this->belongsTo(penjaminans::class,'penjaminan_id','idpenjaminan')
                   ->with('terjamin','kesehatan','bank','pembayaran','reasuransi');
       }
       
       
}
