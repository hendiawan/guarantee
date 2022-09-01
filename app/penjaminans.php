<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\terjamins;
use App\kesehatans;
use App\banks;
use App\sertifikats;
use App\pembayarans;
use App\t_reasuransi;

class penjaminans extends Model {
    //
    public $timestamps = false;
    protected $fillable = [
            'siup',
            'npwp',
            'cek',
            'ktp', 
            'nama', 
            'tgllahir', 
            'umur', 
            'pekerjaan', 
            'alamat', 
            'jeniskredit', 
            'penggunaan',
            'tglrealisasi', 
            'tgljatuhtempo', 
            'umurjatuhtempo', 
            'nopk', 
            'tglpk', 
            'plafon', 
            'jenispenjaminan', 
            'jenispenjaminan',
            'tglpengajuan',
            'masakredit',
            'premi',
            'idbank',
            'rate',
            'dis',
            'pot',
            'nett',
            'case',
            'nosertifikat',
            'statusbayar',
            'pemohon',
            'tempatlahir',
            'jenispengajuan',
            'pklama',
            'idterjamin',
            'sertifikatlama',
            'app',
            'user',
            'tanggapandir',
            'export',
            'url_penjaminan',
            'lama_usaha',
            'nilai_taksasi',
            'taksiran_taksasi',
            'suku_bunga',
            'angsuran',         
            'omset_penjualan',         
            'hpp',         
            'biaya_rumah_tangga',         
            'biaya_usaha',         
            'angsuran_lainnya',         
            'nilai_pasar',         
            'detail_skim',         
            'pendapatan_utama',         
            'pendapatan_lainnya',         
            'pendapatan_bersih',         
            'persentase_penjaminan',         
            'persyaratan_id',         
        ];
    
     public static function tgl_indo($tanggal) {
        $bulan = array(
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun

        return $pecahkan[0] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[2];
    }
    
    public function terjamin(){
        return $this->belongsTo(terjamins::class, 'idterjamin', 'id');
    }
    public function kesehatan(){
//    return $this->belongsTo(User::class, 'foreign_key (nama field yang terdapat pada tabel  master)', 'owner_key(nama field yang terdapat pada tabel transaksi)');
        return $this->belongsTo(kesehatans::class, 'idpenjaminan','idpenjaminan');
    }
    
    public function sertifikat()
    {
        return $this->belongsTo(sertifikats::class,'idpenjaminan','idpenjaminan');
    }
   
    public function bank()
    {
        return $this->hasOne(banks::class,'idbank','idbank');
    }
    
    public  function pembayaran()
    {
        return $this->belongsTo(pembayarans::class,'kodebayar','kodebayar');
    }
    
    public function reasuransi()
    {
        return $this->belongsTo(t_reasuransi::class,'idpenjaminan','penjaminan_id')->with('rekanan');
    }
    
}
