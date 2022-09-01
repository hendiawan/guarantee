<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class history_cases extends Model
{
    //
    public $timestamps = false;
    protected $fillable=[
        'idpenjaminan',
        'tensi',
        'guladarah',
        'kolesterol',
        'tekanan_jantung',
        'analisa_pekerjaan',
        'analisa_umur',
        'catatan_pembayaran',
        'hasil_akhir',
        'analisa_kesehatan',
        'rekomendasi_kabag'
    ];
}
