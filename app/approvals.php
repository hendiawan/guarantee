<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class approvals extends Model
{
    //
    public $timestamps = false;
    protected $fillable=[
        'cekpekerjaan',
        'idpenjaminan',
        'ceknama',
        'cekumur',
        'cekjenispenjaminan',
        'cekperiode',
        'cekmasakredit',
        'cekplafon',
        'cekrate',
        'ceknett',
        'cekijp',
        'ceksuratsehat',
        'ceksuratsehatrs',
        'ceklab',
        'cekjeniskredit',
        'cektgllahir',
        'ceknopk',
        'cekpotongan',
        'cekktp',
        'hasilakhir',
        'analisa',
        'oleh',
        'tglanalisa',
        'cekpembayaran'];
}
