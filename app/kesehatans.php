<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\penjaminans;

class kesehatans extends Model {
    //
    protected  $table = 'kesehatan';
    public $timestamps = false;
    protected $fillable = [
        'nosertifikat',
        'files',
        'files2',
        'files3',
        'getaran_jantung',
        'foto_ktp',
        'foto_usaha',
        'hasil_slik',
        'analisis_kelayakan',
        'taksasi_agunan',
        'surat_persetujuan_kredit',
        'sk_pengangkatan',
        'surat_riwayat_kredit',
        'idpenjaminan'
        ];
    
    
    public function penjaminan()
    { 
        return $this->hasOne(penjaminans::class,'idpenjaminan'); 
    }

}
