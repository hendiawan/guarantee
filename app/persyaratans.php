<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class persyaratans extends Model {
    //
    public $timestamps = false;
    protected $fillable = [
            'bank_id',
            'jns_kredit', 
            'jns_penjaminan', 
            'max_plafon', 
            'max_umur', 
            'doc_surat_pernyataan_sehat', 
            'doc_cek_lab', 
            'doc_getaran_jantung', 
            'doc_ktp', 
            'doc_foto_usaha', 
            'doc_slik', 
            'doc_analisa_kelayakan', 
            'doc_taksasi', 
            'doc_persetujuan_kredit', 
        ];

}
