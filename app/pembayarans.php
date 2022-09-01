<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pembayarans extends Model {
    //
    public $timestamps = false;
    protected $fillable = [
        'idbank', 
        'kodebayar', 
        'tglbayar', 
        'jumlah', 
        'url_file_bayar', 
        'file'];

}
