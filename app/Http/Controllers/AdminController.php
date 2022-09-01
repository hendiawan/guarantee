<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\blogs;
use App\penjaminans;
use Illuminate\Foundation\Http\FormRequest;
use App\banks;
use App\rate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
//untuk registrasi
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\User;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\approvals;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\sertifikats;
use App\produks;
//use LaravelQRCode\Facades\QRCode;
//use MilonBarcodeDNS2D as DNS2D;
//use MilonBarcodeDNS1D as DNS1D;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\kesehatans;
use App\pembayarans;
use App\terjamins;
use App\cetaks;
use Illuminate\Support\Facades\Mail;
use App\tutupbuku;
use App\m_terjamin;
use Carbon;
use DateTime;
use App\history_cases;
use App\history_apps;
use App\Http\Controllers\BSrE_Esign_Cli;
use Illuminate\Support\Facades\File;
use App\history_tolakans;
use  \App\sp3s;
use \App\t_grace_periodes;
use App\pengurus;
use App\t_history_banks;
/**
 * Description of BlogController
 *
 * @author ASUS
 */

class AdminController extends Controller {

    public $nama_admin="Lalu Hendiawan Dipa";
    
    
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('ceklogin');
    }

    use AuthenticatesAndRegistersUsers,
        ThrottlesLogins;

    public function nilai($nilai) {
        $pecah = explode(",", $nilai);
        return implode("", $pecah);
    }
    

    
    protected function validator(array $data) 
    {
        return Validator::make($data, [
                    'idbank' => 'required|max:255|unique:users',
                    'username' => 'required|max:255|unique:users',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|min:6|confirmed',
                    'jenis' => 'required',
        ]);
    }

  public  function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = self::penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = self::penyebut($nilai / 10) . " puluh" . self::penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . self::penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = self::penyebut($nilai / 100) . " ratus" . self::penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . self::penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = self::penyebut($nilai / 1000) . " ribu" . self::penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = self::penyebut($nilai / 1000000) . " juta" . self::penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = self::penyebut($nilai / 1000000000) . " milyar" . self::penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = self::penyebut($nilai / 1000000000000) . " trilyun" . self::penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

   public function terbilang($nilai) 
    {
        if ($nilai < 0) {
            $hasil = "minus " . trim(self::penyebut($nilai));
        } else {
            $hasil = trim(self::penyebut($nilai));
        }
        return $hasil;
     }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {
        return User::create([
                    'idbank' => $data['idbank'],
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'level' => $data['jenis'],
                    'password' => bcrypt($data['password']),
        ]);
    }

    protected $redirectTo = '/';

    public function tanggal($tgl) {
        $data = explode("/", $tgl);
        $isi = "$data[2]-$data[1]-$data[0]";
        return $tgl = date('Y-m-d', strtotime($isi));
    }

    public function Index() {

        $rate = DB::table('rate')
                ->leftJoin('banks', 'banks.idbank', '=', 'rate.idbank')
                ->get();
        ;

        return view('admin/penjaminan', ['rate' => $rate]);
    }
    
        public function importExport() {

        $rate = rate::where('idbank', Session::get('idbank'))->groupBy('namarate')->get();
        $bank = banks::get();
//        dd($bank);
        return view('admin.export', [
            'rate' => $rate,
            'bank' => $bank,
        ]);
    }
       
 
    public function importExcel(Request $request) {
    
     
     ini_set('max_execution_time', 300);
     
       $bank = banks::where('banks.idbank',$request->bank)
                ->leftJoin('users', 'users.idbank', '=', 'banks.idbank')
               ->first(); 
       
        
          
        if ($request->hasFile('file')) {
            $path = $request->file('file')->getRealPath(); 
          
            $data = Excel::load($path, function($reader) {})->get();
             
//         dd($data);
            if (!empty($data) && $data->count()) {
                $kode = penjaminans::count();
                $kode = $kode + 1;
                $i=0;
          
                foreach ($data[0] as $key => $val) //mengambil nilai berdasarkan sheet 1
                {
                      
                    //mengambil nilai berdasarkan sheet 1
                    //No Sertifikat
//                             dd($val);
                    
                     date_default_timezone_set("Asia/Jakarta");
                     $hariini                    = date('Y-m-d');
                     $realisasi                = date('Y-m-d',strtotime($val->tglrealisasi));
                     
//                     dd($realisasi);
                     
                    $nosertifikat = 'RGJNBEXC' . session::get('idbank') . date('Ymdhis') . $kode;
                    //cek umur
                    $taggallahir = date('Y/m/d', strtotime($val->tgllahir));
                    $lahir = new DateTime($taggallahir);

                    $sekarang = new DateTime();
                    $DataUmur = $lahir->diff($sekarang);
                    $umur = $DataUmur->y;
                    $realisasi = new DateTime(date('Y-m-d',strtotime($val->tglrealisasi)));
                    $tgljatuhtempo = date('Y-m-d', strtotime("+$val->lamabulan month", strtotime("now")));

                    $tanggaljatuhtmp=date('Y-m-d',strtotime($val->tgljatuhtempo));
                    $jatuhtempo = new DateTime($tanggaljatuhtmp);
                    $Datamasakredit = $realisasi->diff($jatuhtempo);


                    $lahir = new DateTime(date('Y-m-d',strtotime($val->tgllahir)));
                    $sekarang = new DateTime();
                    $DataUmur = $lahir->diff($jatuhtempo);
                    $umurJatuhTempo = $DataUmur->y;

                    if (session::get('level') == 'bntb') {
                        if ($umurJatuhTempo > 70) {
                            $app_jatuhtempo = 'Tolak';
                            $catatan_jatuhtempo = 'Mohon maaf maksimal umur terjamin saat jatuh tempo yaitu 70 Tahun';
                        } else {
                            $app_jatuhtempo = 'Pengecekan';
                            $catatan_jatuhtempo = '';
                        }

                        if ($val->plafon > 200000000) {
                            $case = 'Ya';
                        } else {
                            $case = 'Tidak';
                        }
                    } else if ($bank->level == 'bpr') {

                        if ($umurJatuhTempo > 65) {
                            $app_jatuhtempo = 'Tolak';
                            $catatan_jatuhtempo = 'Mohon maaf maksimal umur terjamin  saat jatuh tempo  yaitu 65 Tahun';
                        } else {
                            $app_jatuhtempo = 'Pengecekan';
                            $catatan_jatuhtempo = '';
                        }

                        if ($val->plafon > 200000000) {
                            $case = 'Ya';
                        } else {
                            $case = 'Tidak';
                        }
                    } else if ($bank->level== 'koperasi') {
                        if ($umurJatuhTempo > 65) {
                            $app_jatuhtempo = 'Tolak';
                            $catatan_jatuhtempo = 'Mohon maaf maksimal umur terjamin  saat jatuh tempo  yaitu 65 Tahun';
                        } else {
                            $app_jatuhtempo = 'Pengecekan';
                            $catatan_jatuhtempo = '';
                        }

                        if ($val->plafon > 200000000) {
                            $case = 'Ya';
                        } else {
                            $case = 'Tidak';
                        }
                    }

                        $jenisKredit = strtoupper($val->jenis_kredit);
                        $jenisSkema = $val->jenis_skema;
                        $GracePeriod = $val->grace_periode;
                        $masakredit = $val->lamabulan;

                    if ($jenisKredit == 'PRODUKTIF') {
                        $kodeProduk = '5';
                    } else {
                        $kodeProduk = '1';
                    }

//                   dd($val);
                    if ($jenisSkema == 'Musiman') {
                            $jenisSkema = 'KREDIT DENGAN PEMBAYARAN MUSIMAN(PLAFOND)';
                    } else if ($jenisSkema == 'PHK ASN') {
                             $jenisSkema = 'MACET KARENA MENINGGAL DUNIA & MACET PHK ASN';
                    } else if ($jenisSkema == 'Meninggal Dunia') {
                            $jenisSkema = 'MACET KARENA MENINGGAL DUNIA';
                    }
//                    echo $jenisSkema;
                    // Cek Rate
//                    $rate = rate::leftJoin('banks', 'banks.idbank', '=', 'rate.idbank')
//                            ->where('banks.idbank', Session::get('idbank'))
//                            ->where('rate.dari', '<=', $masakredit)
//                            ->where('rate.sampai', '>=', $masakredit)
//                            ->where('rate.namarate', $jenisSkema)
//                            ->where('rate.idproduk', $kodeProduk)
//                            ->first();
                    
//                    echo '<pre>';
//                    print_r($rate);
//                      echo '</pre>';
//                        echo $jenisSkema.'<br>';
                    // Validasi Nomor KTP
//                    dd($val);
                    $id = $val->ktp;
                    $kodepusat = $bank->kodepusat; 
                    $penjaminan = penjaminans::where('terjamins.ktp', $id)
                            ->where('banks.kodepusat', $kodepusat)
                            ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                            ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                            ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                            ->first();
                    
                
               

                    $hariini = date('Y-m-d');
                    if ($penjaminan) {
                        $jatuhtempo = $penjaminan->tgljatuhtempo;
                        if ($jatuhtempo < $hariini) {
                            $app_ktp = 'Pengecekan';
                            $catatan_ktp = '';
                        } else {
                            $app_ktp = 'Tolak';
                            if ($penjaminan->kodesertifikat) {
                                $catatan_ktp = 'Mohon maaf nomor KTP yang di dimasukkan sudah terdaftar dengan nomor sertifikat : ' . $penjaminan->kodesertifikat . 'di bank:' . $penjaminan->namabank . ' masa berlaku sertifikat sampai: ' . $penjaminan->tgljatuhtempo;
                            } else {
                                $catatan_ktp = 'Mohon maaf nomor KTP yang di masukkan sudah di gunakan pada Nasabah atas nama : ' . $penjaminan->nama;
                            }
                        }
                    } else {
                        $app_ktp = 'Pengecekan';
                        $catatan_ktp = '';
                    }

                    //validasi umur
                    if ($umur < 15) {
                        $app_umur = 'Tolak';
                        $catatan_umur = 'Mohon Periksa penulisan Umur, Minimal umur Terjamin adalah 15 Tahun, mohon cek penulisan tanggal lahir di file excel, format yang di dukung yaitu: Tahun/Bulan/Tanggal contoh penulisan : 1993/04/10 !!  ';
                    } else {
                        if ($val->tgllahir == null) {
                            $app_umur = 'Tolak';
                            $catatan_umur = 'Minimal umur Terjamin adalah 15 Tahun, mohon cek penulisan tanggal lahir di file excel, format yang di dukung  yaitu: Tahun/Bulan/Tanggal contoh penulisan : 1993/04/10 !! ';
                        } else {
                            $app_umur = 'Pengecekan';
                            $catatan_umur = '';
                        }
                    }


                    // Validasi Nomor PK
                    
            
                    $penjaminan = penjaminans::where('nopk',$val->nopk)
                            ->where('banks.kodepusat', $kodepusat)
                            ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                            ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                            ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                            ->first();
                    
                 
                    //                  dd($id);
                    if ($penjaminan) {
                        $app_pk = 'Tolak';
                        if ($penjaminan->kodesertifikat) {
                            $catatan_pk = 'Mohon maaf Nomor Perjanjian Kredit yang di dimasukkan sudah terdaftar dengan nomor sertifikat : ' . $penjaminan->kodesertifikat . 'di bank:' . $penjaminan->namabank . ' masa berlaku sertifikat sampai: ' . $penjaminan->tgljatuhtempo;
                        } else {
                            $catatan_pk = 'Mohon maaf nomor Perjanjian Kredit yang di gunakan sebelumnya pada Nasabah atas nama : ' . $penjaminan->nama . ' Bank : ' . $penjaminan->namabank;
                        }
                    } else {
                        $app_pk = 'Pengecekan';
                        $catatan_pk = '';
                    }

                    //hasil pengecekan akhir
                    if ($app_ktp == 'Pengecekan' and
                            $app_jatuhtempo == 'Pengecekan' and
                            $app_umur == 'Pengecekan' and
                            $app_pk == 'Pengecekan') {
                        $app = 'Pengecekan';
//                            $app = 'Setuju';
                    } else {
//                        $app = 'Tolak';
//                        $app = 'Setuju';
                           $app = 'Pengecekan';
                    }
            
                    $catatan = $catatan_jatuhtempo . ','
                            . $catatan_ktp . ','
                            . $catatan_pk . ','
                            . $catatan_umur;
        

                    $ijp = $val->grossijp;
                                     
//dd($ijp);
                    $discount =  $val->fee/$val->grossijp*100;
//                    dd($discount);
                    $potongan = $ijp * $discount / 100;
                   
                    $nett = $ijp - $potongan;
//    dd($val);
//                          dd($potongan);
//                    echo $rate->rate;
                    
                      $terjamin = terjamins::create([
                                'ktp' => $val->ktp,
                                'nama' => $val->nama,
                                'phone' => '081',
                                'tempatlahir' => $val->tempatlahir,
                                'tgllahir' => $val->tgllahir,
                                'umur' => $umur . 'Tahun',
                                'pekerjaan' => $val->pekerjaan,
                                'alamat' => $val->alamat,
                                'register' => $nosertifikat,
                    ]);

                      
                    $dataterjamin = terjamins::where('register', $nosertifikat)->first();
                    $penjaminan = new penjaminans;
                    $penjaminan->user =1;
                    $penjaminan->tglpengajuan = $sekarang;
                    $penjaminan->idbank =$request->bank; 
                    $penjaminan->idterjamin = $dataterjamin->id;
                    $penjaminan->tglrealisasi = date('Y-m-d',strtotime($val->tglrealisasi));
                    $penjaminan->tgljatuhtempo = date('Y-m-d',strtotime($val->tgljatuhtempo));
                    $penjaminan->umurjatuhtempo = $umurJatuhTempo . 'Tahun';
                    $penjaminan->masakredit = $masakredit;
                    $penjaminan->nopk = $val->nopk;
                    $penjaminan->tglpk = date('Y-m-d',strtotime($val->tglpk));
                    $penjaminan->plafon = $val->plafon;
//                    $penjaminan->jenispenjaminan = $jenisSkema;
//                    $penjaminan->jenispenjaminan = 'MACET KARENA MENINGGAL DUNIA';
                    $penjaminan->jenispenjaminan = $val->jenis_skema;
//                    $penjaminan->jeniskredit = $jenisKredit;
                    $penjaminan->jeniskredit = "KONSUMTIF";
                    $penjaminan->rate = $val->rate;
                    $penjaminan->premi = $ijp;
                    $penjaminan->dis = $discount;
//                    $penjaminan->statusbayar = 0;
                    $penjaminan->statusbayar = 1;
                    $penjaminan->app = $app;
                    $penjaminan->nosertifikat = $nosertifikat;
                    $penjaminan->pot = $potongan;
                    $penjaminan->nett = $nett;
                    $penjaminan->catatan = $catatan;
                    $penjaminan->pemohon = $request->pemohon;
                    $penjaminan->case = $case;
                    $penjaminan->cek = '0';
                    $penjaminan->jenispengajuan = 'baru';
                    $penjaminan->export = 'Ya';
                    $penjaminan->detail_skim= 'JIWA';
                    $penjaminan->persentase_penjaminan = 100;
                    $penjaminan->save();
                    
                    
                    $datapenjaminan = penjaminans::where('nosertifikat', $nosertifikat)->first();

                    $kesehatan = kesehatans::create([
                                'idpenjaminan' => $datapenjaminan->idpenjaminan,
                                'nosertifikat' => $datapenjaminan->nosertifikat,
                    ]);
                    
                    if($val->grace_periode == 'Ya') {
                        $simpanDataGrace = t_grace_periodes::create([
                                    'id_penjaminan' => $datapenjaminan->idpenjaminan,
                                    'tgl_mulai' => $val->tglrealisasi,
                                    'periode' => $val->masa_grace,
                        ]);
                    }


                    $i++;
                     $kode = $kode + 1;
                }
            }
              return redirect('/importexportadmin');
        }
      
    }

    public function datapenjaminan() {
        return view('admin/datapenjaminan');
    }

    public function datarate() {

        $bank = banks::all();
        $rate = DB::table('rate')
                ->leftJoin('banks', 'banks.idbank', '=', 'rate.idbank')
                ->get();
        ;
        return view('admin.datarate', ['bank' => $bank, 'rate' => $rate]);
    }

    public function registerbank() {

        $bank = banks::all();

        return view('login.registerbank', ['bank' => $bank]);
    }

    public function CekPengajuanKompensasi() {
        $pengajuan = penjaminans::where('statusbayar', 1)
                ->where('case', 'Tidak')
                ->where('app', 'Pengecekan')
                ->where('jenispengajuan', 'kompensasi')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar') 
                ->leftJoin('kesehatan', 'kesehatan.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->get();
        // dd($pengajuan);
        return view('admin.cek.cekpengajuanbelumproses', ['pengajuan' => $pengajuan]);
    }

    public function ubahrate(request $request) {

        $data = rate::where('idrate', $request->idrate)
                ->first();

        $output = [
            'idbank' => $data->idbank,
            'idproduk' => $data->idproduk,
            'namaproduk' => $data->namarate,
            'jenispenjaminan' => $data->jnspnj,
            'dari' => $data->dari,
            'sampai' => $data->sampai,
            'rate' => $data->rate,
        ];
        return json_encode($output);
    }

    public function rate() {

        $bank = banks::all();
        $produk = produks::all();


        $rate = DB::table('rate')
                ->leftJoin('banks', 'banks.idbank', '=', 'rate.idbank')
                ->groupBy('rate.idbank')
                ->select('banks.idbank', 'banks.namabank', 'rate.namarate', 'rate.jnspnj', 'rate.dari', 'rate.sampai', 'rate.rate', 'rate.idrate', \DB::raw('count(*) as total'))
                ->get();



        return view('admin.rate', [
            'bank' => $bank,
            'produk' => $produk,
            'rate' => $rate
        ]);
    }

    public function detailrate($id) {
        
        
        $bank = banks::all();
        $produk = produks::all();


        $rate = DB::table('rate')
                ->leftJoin('banks', 'banks.idbank', '=', 'rate.idbank')
                ->where('banks.idbank', $id)
                ->get();

        return view('admin.detailrate', [
            'bank' => $bank,
            'produk' => $produk,
            'rate' => $rate
        ]);
    }

    public function datapenjaminanview() 
    {

//        $m_terjamin = m_terjamin::where(DB::raw('YEAR(tanggal_daftar)'), date('Y'))
////                ->where(DB::raw('MONTH(tanggal_daftar)'), date('m'))
//                ->where(DB::raw('MONTH(tanggal_daftar)'), '04')
//                ->get();
            // $kirim = ((new APIController())->sendMessageTelegramBot("halo"));
            //  dd($kirim);
        $sum_revisi = penjaminans::leftjoin('banks', 'banks.idbank', '=', 'penjaminans.idbank') 
                ->where([
                    ['app', 'Revisi'], 
                ])   
                ->get()->count() ;
        $sum_direksi = penjaminans::leftjoin('banks', 'banks.idbank', '=', 'penjaminans.idbank') 
                ->where([
                    ['app', 'Direksi'], 
                ])   
                ->get()->count() ;
        
        $sum_kabag = penjaminans::where([
                                            ['app', 'kabag'], 
                                    ]) ->get()->count() ;
        
        
//                dd($sum_revisi);
//               ->count('nett');
        $sum_terjamin = penjaminans::leftjoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan') 
                ->where([
                    ['app', 'Cetak'],
                    [DB::raw('MONTH(tglterbit)'), date('m')],
                    [DB::raw('YEAR(tglterbit)'), date('Y')],
                ])   
                ->get() 
               ->count('nett');
     
        
        $sum_ijp = penjaminans::leftjoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan') 
                ->where([
                    ['app', 'Cetak'],
                    [DB::raw('MONTH(tglterbit)'), date('m')],
                    [DB::raw('YEAR(tglterbit)'), date('Y')],
                ])   
                ->get() 
               ->sum('nett');
        
      
        
        
        $sum_plafon = penjaminans::leftjoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan') 
                ->where([
                    ['app', 'Cetak'],
                    [DB::raw('MONTH(tglterbit)'), date('m')],
                    [DB::raw('YEAR(tglterbit)'), date('Y')],
                ])   
                ->get() 
               ->sum('plafon');
        
//        dd($penjaminan);
        $penjaminan = penjaminans::leftjoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->where('statusbayar', 1)
                ->where('app', 'Pengecekan')
                ->where('case', 'Tidak')
                ->groupBy('penjaminans.idbank')
                ->select('penjaminans.idbank', 'banks.namabank', \DB::raw('count(*) as total'))
                ->get();

        $setuju = penjaminans::leftjoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->where('statusbayar',1)
                ->where('app', 'Setuju')
                ->groupBy('penjaminans.idbank')
                ->select('penjaminans.idbank', 'banks.namabank', \DB::raw('count(*) as total'))
                ->get();
//dd($setuju);
        $cetak = penjaminans::leftjoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->where('statusbayar', 1)
                ->where('app', 'Cetak')
                ->groupBy('penjaminans.idbank')
                ->select('penjaminans.idbank', 'banks.namabank', \DB::raw('count(*) as total'))
                ->get();
        
        $sign= penjaminans::leftjoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftjoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->where('sertifikats.digitalSign', 1)
                ->where('app', 'Cetak')
                ->groupBy('penjaminans.idbank')
                ->select('penjaminans.idbank', 'banks.namabank', \DB::raw('count(*) as total'))
                ->get();
        
            $table_sppsb = db::CONNECTION('db_sb')->table('sppsb'); 
            $sppsb = $table_sppsb
                    ->select('*', 'sppsb.created_at as tgl_input', 'sppsb.id as id')
                    ->leftJoin('users', 'users.id', '=', 'sppsb.user_id')
                    ->limit(30)
                    ->where('sppsb.digitalSign',1)
                    ->orderby('sppsb.id', 'desc')->get();

        $tolak = penjaminans::leftjoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->where('app', 'Tolak')
                ->groupBy('penjaminans.idbank')
                ->select('penjaminans.idbank', 'banks.namabank', \DB::raw('count(*) as total'))
                ->get();

        $casebycase = penjaminans::where('statusbayar', 0)
                ->where('case', 'Ya')
                ->where('app', 'AnalisPenjaminan')
                ->leftjoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->groupBy('penjaminans.idbank')
                ->select('penjaminans.idbank', 'banks.namabank', \DB::raw('count(*) as total'))
                ->get();

        $casebycasesudahbayar = penjaminans::where('statusbayar', 1)
                ->where('case', 'Ya')
                ->where('cek', 0)
                ->where('app', 'Pengecekan')
                ->leftjoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->groupBy('penjaminans.idbank')
                ->select('penjaminans.idbank', 'banks.namabank', \DB::raw('count(*) as total'))
                ->get();

        $totalbaru = penjaminans::where('statusbayar', '1')
                ->where('case', 'Tidak')
                ->where('app', 'Pengecekan')
                ->where('jenispengajuan', 'baru')
                ->count();
        
        $totalsign = sertifikats::where('cek', '') ->where('digitalSign', '1')
                ->count();
        
        $totalsignsb = $table_sppsb->where('cek', '') ->where('digitalSign', '1')
                ->count();

        $totalcasesetuju = penjaminans::where('case', 'Ya')
                ->where('app', 'CaseSetuju')
                ->count();

        $totalcasetolak = penjaminans::where('case', 'Ya')
                ->where('app', 'CaseTolak')
                ->count();

        $totalkonpensasi = penjaminans::where('statusbayar', '1')
                ->where('app', 'Pengecekan')
                ->where('case', 'Tidak')
                ->where('jenispengajuan', 'kompensasi')
                ->count();

        $totalulang = penjaminans::where('app', 'ulang')
                ->where('case', 'Tidak')
                ->count();
        
        $totalulangcase = penjaminans::where('app', 'ulang')
                ->where('case', 'Ya')
                ->count();

        $totalcasebycase = penjaminans::where('case', 'Ya')
                ->where('statusbayar', 0)
                ->where('app', 'AnalisPenjaminan')
                ->count();

        $totalappdireksi = penjaminans::where('case', 'Ya')
                ->where('statusbayar', 0)
                ->where('app', 'direksi')
                ->count();

        $totalcasesudahbayar = penjaminans::where('case', 'Ya')
                ->where('statusbayar', 1)
                ->where('app', 'Pengecekan')
                ->count();

        $totalsetuju = penjaminans::where('statusbayar', 1)
                ->where('app', 'Setuju')
                ->count();
        
        $totalProduktif = penjaminans::where('statusbayar', 1)
                ->where('app', 'Cetak')
                ->where('jeniskredit', 'PRODUKTIF')
                ->count();
        
        $totalKonsumtif = penjaminans::where('statusbayar', 1)
               ->where('app', 'Cetak')
                ->where('jeniskredit', 'KONSUMTIF')
                ->count();

          $sumJanuariProduktif = penjaminans::leftjoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan') 
                ->where([
                    ['jeniskredit', 'PRODUKTIF'],
                    ['app', 'Cetak'],
                    [DB::raw('MONTH(tglterbit)'), 1],
                    [DB::raw('YEAR(tglterbit)'), date('Y')],
                ])   
                ->get() 
               ->sum('nett');
        
        $sumJanuariKonsumtif = penjaminans::leftjoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan') 
                ->where([
                    ['jeniskredit', 'KONSUMTIF'],
                    ['app', 'Cetak'],
                    [DB::raw('MONTH(tglterbit)'), 2],
                    [DB::raw('YEAR(tglterbit)'), date('Y')],
                ])   
                ->get() 
               ->sum('nett');
        
        $bank = banks::all();




// dd($totalcasebycase);
        return view('admin.dashboard', [
      //      'terjamin' => $m_terjamin,
            'data' => $penjaminan,
            'casebycase' => $casebycase,
            'casebycasesudahbayar' => $casebycasesudahbayar,
            'setuju' => $setuju,
            'totalcasesetuju' => $totalcasesetuju,
            'totalcasetolak' => $totalcasetolak,
            'totalsetuju' => $totalsetuju,
            'totalappdireksi' => $totalappdireksi,
            'totalbaru' => $totalbaru,
            'totalsign' => $totalsign,
            'totalsignsb' => $totalsignsb,
            'sppsb' => $sppsb,
            'totalulang' => $totalulang,
            'totalulangcase' => $totalulangcase,
            'totalcase' => $totalcasebycase,
            'totalcasebayar' => $totalcasesudahbayar,
            'tolak' => $tolak,
            'cetak' => $cetak,
            'totalkompensasi' => $totalkonpensasi,
            'bank' => $bank,
            'sign' => $sign,
            'sum_terjamin' => $sum_terjamin,
            'sum_ijp' => $sum_ijp,
            'sum_plafon' => $sum_plafon,
            'sum_revisi' => $sum_revisi,
            'sum_direksi' => $sum_direksi,
            'sum_kabag' => $sum_kabag,
            'totalProduktif' => $totalProduktif,
            'totalKonsumtif' => $totalKonsumtif,
            'sumJanuariProduktif' => $this->hitungTotalBulanan('PRODUKTIF',1),
            'sumJanuariKonsumtif' => $this->hitungTotalBulanan('KONSUMTIF',1),
            'sumFebruariProduktif' => $this->hitungTotalBulanan('PRODUKTIF',2),
            'sumFebruariKonsumtif' => $this->hitungTotalBulanan('KONSUMTIF',2),
            'sumMaretProduktif' => $this->hitungTotalBulanan('PRODUKTIF',3),
            'sumMaretKonsumtif' => $this->hitungTotalBulanan('KONSUMTIF',3),
            'sumAprilProduktif' => $this->hitungTotalBulanan('PRODUKTIF',4),
            'sumAprilKonsumtif' => $this->hitungTotalBulanan('KONSUMTIF',4),
            'sumMeiProduktif' => $this->hitungTotalBulanan('PRODUKTIF',5),
            'sumMeiKonsumtif' => $this->hitungTotalBulanan('KONSUMTIF',5),
            'sumJuniProduktif' => $this->hitungTotalBulanan('PRODUKTIF',6),
            'sumJuniKonsumtif' => $this->hitungTotalBulanan('KONSUMTIF',6),
            'sumJuliProduktif' => $this->hitungTotalBulanan('PRODUKTIF',7),
            'sumJuliKonsumtif' => $this->hitungTotalBulanan('KONSUMTIF',7), 
            'sumAgsProduktif' => $this->hitungTotalBulanan('PRODUKTIF',8),
            'sumAgsKonsumtif' => $this->hitungTotalBulanan('KONSUMTIF',8),
            'sumSepProduktif' => $this->hitungTotalBulanan('PRODUKTIF',9),
            'sumSepKonsumtif' => $this->hitungTotalBulanan('KONSUMTIF',9),
            'sumOktProduktif' => $this->hitungTotalBulanan('PRODUKTIF',10),
            'sumOktKonsumtif' => $this->hitungTotalBulanan('KONSUMTIF',10),
            'sumNovProduktif' => $this->hitungTotalBulanan('PRODUKTIF',11),
            'sumNovKonsumtif' => $this->hitungTotalBulanan('KONSUMTIF',11),
            'sumDesProduktif' => $this->hitungTotalBulanan('PRODUKTIF',12),
            'sumDesKonsumtif' => $this->hitungTotalBulanan('KONSUMTIF',12),
        ]);
    }
    
    public function hitungTotalBulanan($jenis,$bulan){
       $data= penjaminans::leftjoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan') 
                ->where([
                    ['jeniskredit', $jenis],
                    ['app', 'Cetak'],
                    [DB::raw('MONTH(tglterbit)'), $bulan],
                    [DB::raw('YEAR(tglterbit)'), date('Y')],
                ])   
                ->get() 
               ->sum('nett');

       return(round($data));
        
    }

    public function bank() {

        $bank = banks::all();

        return view('admin.bank', ['bank' => $bank]);
    }

    public function simpanrate(Request $request) {

        $this->validate($request, [
            'idbank' => 'required',
            'kategori' => 'required',
            'namarate' => 'required',
            'daribulan' => 'required',
            'sampaibulan' => 'required',
            'jenispenjaminan' => 'required',
            'rate' => 'required',
        ]);
        if ($request->submit == 'Ubah') {
            $rate = rate::where('idrate', $request->hidden_id)
                    ->update([
                'idbank' => $request->idbank,
                'idproduk' => $request->kategori,
                'namarate' => $request->namarate,
                'jnspnj' => $request->jenispenjaminan,
                'dari' => $request->daribulan,
                'sampai' => $request->sampaibulan,
                'rate' => $request->rate
            ]);
            session::flash('pesan', 'Data rate berhasil diubah');
        } else {
            $rate = rate::create([
                        'idbank' => $request->idbank,
                        'idproduk' => $request->kategori,
                        'namarate' => $request->namarate,
                        'dari' => $request->daribulan,
                        'sampai' => $request->sampaibulan,
                        'rate' => $request->rate,
                        'jnspnj' => $request->jenispenjaminan,
            ]);
            session::flash('pesan', 'Data rate berhasil tambah');
        }

        return redirect('rate');
    }

    public function simpandatabank(Request $request) {
//      kodecabang
        $this->validate($request, [
            'name' => 'required|max:50',
            'telp' => 'required',
            'kodecabang' => 'required',
            'alamat' => 'required',
            'minijp' => 'required',
            'discount' => 'required',
            'share' => 'required',
            'admin' => 'required',
            'materai' => 'required',
        ]);


        if ($request->action == 'update') {
            $banks = banks::where('idbank', $request->idbank)
                    ->update([
                'kodecabang' => $request->kodecabang,
                'namabank' => $request->name,
                'alamatbank' => $request->alamat,
                'telp' => $request->telp,
                'dis' => $request->discount,
                'admin' => $request->admin,
                'materai' => $request->materai,
                'share' => $request->share,
                'minijp' => $request->minijp,
            ]);
            session::flash('pesan', 'Data bank berhasil diupdate');
            return redirect('bank');
        } else {
            $bank = banks::create([
                        'kodecabang' => $request->kodecabang,
                        'namabank' => $request->name,
                        'alamatbank' => $request->alamat,
                        'telp' => $request->telp,
                        'dis' => $request->discount,
                        'admin' => $request->admin,
                        'materai' => $request->materai,
                        'share' => $request->share,
                        'minijp' => $request->minijp,
            ]);

            session::flash('pesan', 'Data bank berhasil disimpan');
            return redirect('datapenjaminanview');
        }
    }

    public function CekPengajuan($id) {
        $pengajuan = penjaminans::select(
                        '*', 'penjaminans.idpenjaminan')
                ->where('statusbayar', 1)
                ->where('penjaminans.idbank', $id)
                ->where('case', 'Tidak')
                ->where('app', 'Pengecekan')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('kesehatan', 'kesehatan.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->get();
//         dd($pengajuan);
        return view('admin.cekdatapengajuan', ['pengajuan' => $pengajuan]);
    }

    public function CekPengajuanAll() 
    {
        $pengajuan = penjaminans::where('statusbayar', 1)
                ->where('case', 'Tidak')
                ->where('app', 'Pengecekan')
                ->where('jenispengajuan','!=', 'kompensasi')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('kesehatan', 'kesehatan.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->get();
        // dd($pengajuan);
        return view('admin.cek.cekpengajuanbelumproses', ['pengajuan' => $pengajuan]);
    }

    public function CekPengajuanUlang() 
    {
        $pengajuan = penjaminans::where('app', 'ulang')
                ->where('case','Tidak')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('kesehatan', 'kesehatan.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->get();
//         dd($pengajuan);
        return view('admin.cek.cekpengajuanulang', ['pengajuan' => $pengajuan]);
    }

    public function Setuju($id) {
        $pengajuan = penjaminans::where('statusbayar', 1)
                ->where('penjaminans.idbank', $id)
                ->where('app', 'Setuju')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->get();
        // dd($pengajuan);
        return view('admin.setuju', ['pengajuan' => $pengajuan]);
    }

    public function SetujuAll() {
         date_default_timezone_set("Asia/Jakarta");
        $jam=date('H:i:s',strtotime('+1 hour')); 
      
        if($jam>'24:00:00'){
             Session::flash('pesan', 'Tidak dapat melakukan penerbitan sertifikat diatas jam 16:00:00 !!!!');
             return redirect('/datapenjaminanview');
//            dd($jam);
        }else{ 
                $pengajuan = penjaminans::select('*','penjaminans.idpenjaminan')->where('statusbayar', 1)
                        ->where('app', 'Setuju')
                        ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                        ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                        ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                        ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                        ->get();
                // dd($pengajuan);
                return view('admin.cek.ceksetuju', ['pengajuan' => $pengajuan]);
        } 
       
    }

    public function sertifikatTerbit($id) {
        $pengajuan = penjaminans::
                where('penjaminans.idbank', $id)
                ->where('app', 'Cetak')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->orderBy('sertifikats.id', 'desc')
                ->limit(100)
                ->get();
        // dd($pengajuan);
        return view('admin.sertifikatterbit', ['pengajuan' => $pengajuan]);
    }
    
    public function sertifikatSign($id) {
        $pengajuan = penjaminans::
                where('penjaminans.idbank', $id)
                ->where('app', 'Cetak')
                ->where('sertifikats.digitalSign',1)
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->orderBy('sertifikats.tgl_ttd', 'desc')
                ->limit(100)
                ->get();
//         dd($pengajuan);
        return view('admin.sertifikatsign', ['pengajuan' => $pengajuan]);
    }

   public function sertifikatTerbitAll() 
    {
//           $pengajuan = sertifikats::with('penjaminan')->orderby('id','desc')->limit(10)->get();
           $pengajuan = penjaminans::with(['terjamin','kesehatan','bank','pembayaran','reasuransi'])
                    ->Join('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                   ->where('app', 'Cetak')
                   ->orderBy('sertifikats.id','desc')
//                    ->limit(100)
//                    ->get(); 
                         ->paginate(500); 
//            dd($pengajuan);
        return view('admin.sertifikatterbitall', ['pengajuan' => $pengajuan]);
    }
    
     public function sertifikatTerbitAllBackup() 
    {
                  $pengajuan = sertifikats::select( 
                        'banks.namabank',
                        'terjamins.ktp',
                        'terjamins.nama',
                        'penjaminans.jeniskredit',
                        'penjaminans.jenispenjaminan',
                        'penjaminans.plafon',
                        'penjaminans.case',
                        'penjaminans.nosertifikat',
                        'sertifikats.tglterbit',
                        'sertifikats.kodesertifikat',
                        'penjaminans.nett',
                        'pembayarans.file',
                        'kesehatan.files',
                        'kesehatan.files2',
                        'kesehatan.files3'
                        )
                    
            //    ->where('app', 'Cetak')
            //   ->orWhere('app', 'Lunas')
                ->leftJoin('penjaminans', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('kesehatan', 'kesehatan.idpenjaminan', '=', 'penjaminans.idpenjaminan') 
                ->where(DB::raw('MONTH(sertifikats.tglterbit)'), date('m'))
                ->where(DB::raw('YEAR(sertifikats.tglterbit)'), date('Y'))
                ->orderBy('sertifikats.id', 'desc')
                ->limit(100) 
                ->get();
//         dd($pengajuan);
        return view('admin.sertifikatterbitall', ['pengajuan' => $pengajuan]);
    }
    
    
    public function sertifikatTerbitSign() 
    {
            $pengajuan = penjaminans::
                select( 
                        'banks.namabank',
                        'terjamins.ktp',
                        'terjamins.nama',
                        'penjaminans.jeniskredit',
                        'penjaminans.jenispenjaminan',
                        'penjaminans.plafon',
                        'penjaminans.case',
                        'penjaminans.nosertifikat',
                        'sertifikats.verify',
                        'sertifikats.tglterbit',
                        'sertifikats.kodesertifikat',
                        'sertifikats.tgl_ttd',
                        'sertifikats.usr_ttd',
                        'penjaminans.nett',
                        'pembayarans.file',
                        'kesehatan.files',
                        'kesehatan.files2',
                        'kesehatan.files3'
                        )
                    
            //    ->where('app', 'Cetak')
            //   ->orWhere('app', 'Lunas')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('kesehatan', 'kesehatan.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->where('sertifikats.digitalSign','1')
               // ->where(DB::raw('MONTH(sertifikats.tglterbit)'), date('m'))
               // ->where(DB::raw('YEAR(sertifikats.tglterbit)'), date('Y'))
                ->orderBy('sertifikats.tgl_ttd', 'desc')
                ->limit(150)
                ->get();
//         dd($pengajuan);
        return view('admin.sertifikatsign', ['pengajuan' => $pengajuan]);
    }
 public function sertifikatTerbitSignSb() 
    {
            $table_sppsb = db::CONNECTION('db_sb')->table('sppsb'); 
            $sppsb = $table_sppsb
                    ->select('*', 'sppsb.created_at as tgl_input', 'sppsb.id as id')
                    ->leftJoin('users', 'users.id', '=', 'sppsb.user_id')
                    ->limit(30)
                    ->where('sppsb.digitalSign',1)
                    ->orderby('sppsb.id', 'desc')->get();
        return view('admin.sertifikatsignceksb', ['sppsb' => $sppsb]);
    }
    
   public function sertifikatTerbitSignCekSb(){
        $table_sppsb = db::CONNECTION('db_sb')->table('sppsb'); 
            $sppsb = $table_sppsb
                    ->select('*', 'sppsb.created_at as tgl_input', 'sppsb.id as id')
                    ->leftJoin('users', 'users.id', '=', 'sppsb.user_id')
                    ->limit(30)
                    ->where('sppsb.digitalSign',1)
                    ->where('sppsb.cek','')
                    ->orderby('sppsb.id', 'desc')->get();
         return view('admin.sertifikatsignsb', ['sppsb' => $sppsb]);
   } 
   public function sertifikatTerbitSignCek() 
   {
            $pengajuan = penjaminans::
                select( 
                        'banks.namabank',
                        'terjamins.ktp',
                        'terjamins.nama',
                        'penjaminans.jeniskredit',
                        'penjaminans.jenispenjaminan',
                        'penjaminans.plafon',
                        'penjaminans.case',
                        'penjaminans.nosertifikat',
                        'sertifikats.id',
                        'sertifikats.verify',
                        'sertifikats.tglterbit',
                        'sertifikats.kodesertifikat',
                        'sertifikats.tgl_ttd',
                        'sertifikats.usr_ttd',
                        'penjaminans.nett',
                        'pembayarans.file',
                        'kesehatan.files',
                        'kesehatan.files2',
                        'kesehatan.files3'
                        )
                    
            //    ->where('app', 'Cetak')
            //   ->orWhere('app', 'Lunas')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('kesehatan', 'kesehatan.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->where('sertifikats.digitalSign','1')
                ->where('sertifikats.cek','')
               // ->where(DB::raw('MONTH(sertifikats.tglterbit)'), date('m'))
               // ->where(DB::raw('YEAR(sertifikats.tglterbit)'), date('Y'))
                ->orderBy('sertifikats.tgl_ttd', 'desc')
                ->limit(150)
                ->get();
//         dd($pengajuan);
        return view('admin.sertifikatsigncek', ['pengajuan' => $pengajuan]);
    }

    public function carisertifikat(request $request) {

//        dd($request);

        if ($request->jenis == 'kodesertifikat') {
            $pengajuan = penjaminans::
                    wherein('penjaminans.app',['Lunas','Cetak'])     
                    ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                    ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                    ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                    ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                    ->leftJoin('kesehatan', 'kesehatan.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                    ->orderBy('sertifikats.id', 'desc')
                    ->where('kodesertifikat', 'like', '%' . $request->data . '%')
                    ->paginate(500); 
        } else {
            $pengajuan = penjaminans::
                     wherein('penjaminans.app',['Lunas','Cetak']) 
                    ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                    ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                    ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                    ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                    ->leftJoin('kesehatan', 'kesehatan.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                    ->orderBy('sertifikats.id', 'desc')
                    ->where('terjamins.nama', 'like', '%' . $request->data . '%')
                     ->paginate(500); 
        }
//dd($pengajuan);

        return view('admin.sertifikatterbitall', ['pengajuan' => $pengajuan]);
    }

    public function tolakan($id) {

        $pengajuan = penjaminans::select('*','penjaminans.idpenjaminan')
                ->where('app', 'Tolak')
                ->where('penjaminans.idbank', $id)
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->get();
//        dd($pengajuan);
        return view('admin.tolakan', ['pengajuan' => $pengajuan]);
    }
    
    public function revisi() {

        $pengajuan = penjaminans::where('app', 'Revisi') 
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('history_cases', 'history_cases.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->get();
        return view('admin.revisi', ['pengajuan' => $pengajuan]);
    }
    public function PengajuanPadaDireksi() {

        $pengajuan = penjaminans::where('app', 'direksi') 
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('history_cases', 'history_cases.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->get();
        return view('admin.revisi', ['pengajuan' => $pengajuan]);
    }
    public function PengajuanPadaKabag() {

        $pengajuan = penjaminans::where('app', 'kabag') 
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('history_cases', 'history_cases.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->get();
        return view('admin.kabag', ['pengajuan' => $pengajuan]);
    }

    public function cariDataPenjaminan(request $request) {
           
           $penjaminan = penjaminans::with(['terjamin','kesehatan','bank','pembayaran','sertifikat'])
                                    ->select('*','penjaminans.idpenjaminan')
                                    ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                                    ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                                    ->where([
                                          ($request->jenis=='nama') ? 
                                          ['terjamins.nama', 'like', $request->data . '%'] :
                                          ['sertifikats.kodesertifikat', 'like',  $request->data . '%'] 
                                      ]) 
                                    ->orderby('penjaminans.idpenjaminan','desc') 
                                    ->paginate(500);  
//           dd($penjaminan);
        return view('admin.ubah', ['data' => $penjaminan]);
    }

    public function caridatapelunasan(request $request) {

        if ($request->jenis == 'kodesertifikat') {
            $penjaminan = penjaminans::leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
                    ->leftJoin('users', 'users.idbank', '=', 'banks.idbank')
                    ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                    ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                    ->where('kodesertifikat', 'like', '%' . $request->data . '%')
                    ->where('app', 'cetak')
                    ->get();
        } else if ($request->jenis == 'nama') {
            $penjaminan = penjaminans::leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
                    ->leftJoin('users', 'users.idbank', '=', 'banks.idbank')
                    ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                    ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                    ->where('terjamins.nama', 'like', '%' . $request->data . '%')
                    ->where('app', 'cetak')
                    ->get();
        }
//         dd($penjaminan);
        return view('admin.pelunasan', ['data' => $penjaminan]);
    }

    public function ubahdatapenjaminanadmin(request $request) {
            
        $id = $request->data;
        $penjaminan = penjaminans::select('*', 'penjaminans.idpenjaminan','banks.idbank')
                ->where('penjaminans.idpenjaminan', $id)
                ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('t_grace_periodes', 't_grace_periodes.id_penjaminan', '=', 'penjaminans.idpenjaminan')
                ->first();
//        dd($penjaminan);
        $output = [ 
            'phone' =>$penjaminan->phone,
            'masaGrace' =>$penjaminan->periode,
            'tglGrace' =>date('d/m/Y', strtotime($penjaminan->tgl_mulai)),
            'admin' => number_format($penjaminan->admin, 2, '.', ','),
            'materai' => number_format($penjaminan->materai, 2, '.', ','),
            'idbank' => $penjaminan->idbank,
            'siup' => $penjaminan->siup,
            'npwp' => $penjaminan->npwp,
            'idpenjaminan' => $penjaminan->idpenjaminan,
            'idbank' => $penjaminan->idbank,
            'nosertifikat' => $penjaminan->nosertifikat,
            'ktp' => $penjaminan->ktp,
            'nama' => $penjaminan->nama,
            'tempatlahir' => $penjaminan->tempatlahir,
            'tgllahir' => date('d/m/Y', strtotime($penjaminan->tgllahir)),
            'umur' => $penjaminan->umur,
            'pekerjaan' => $penjaminan->pekerjaan,
            'jenis_pekerjaan' => $penjaminan->jenis_pekerjaan,
            'penggunaan' => $penjaminan->penggunaan,
            'jeniskredit' => $penjaminan->jeniskredit,
            'alamat' => $penjaminan->alamat,
            'tglrealisasi' => date('d/m/Y', strtotime($penjaminan->tglrealisasi)),
            'tgljatuhtempo' => date('d/m/Y', strtotime($penjaminan->tgljatuhtempo)),
            'umurjatuhtempo' => $penjaminan->umurjatuhtempo,
            'nopk' => $penjaminan->nopk,
            'tglpk' => date('d/m/Y', strtotime($penjaminan->tglpk)),
//            'jenispenjaminan' => $penjaminan->jenispenjaminan,
            'tglpengajuan' => $penjaminan->tglpengajuan,
            'statusbayar' => $penjaminan->statusbayar,
            'kodebayar' => $penjaminan->kodebayar,
            'masakredit' => $penjaminan->masakredit,
            'plafon' => $penjaminan->plafon,
            'rate' => $penjaminan->rate,
            'premi' => $penjaminan->premi,
            'dis' => $penjaminan->dis,
            'pot' => $penjaminan->pot,
            'nett' => number_format($penjaminan->nett, 2, '.', ','),
            'app' => $penjaminan->app,
            'case' => $penjaminan->case,
            'kodepusat' => $penjaminan->kodepusat,
            'jenispenjaminan1' => $penjaminan->jenispenjaminan,
            'jenispenjaminan' =>$penjaminan->jenispenjaminan,
        ];
        echo json_encode($output);
    }

   public function ubahdata() 
  {
         $penjaminan = penjaminans::with(['terjamin','kesehatan','bank','pembayaran','sertifikat'])
                                    ->orderby('penjaminans.idpenjaminan','desc') 
                                    ->paginate(500);  
        return view('admin.ubah', ['data' => $penjaminan]);
    }

    public function pelunasan() {
        $penjaminan = penjaminans::leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
                ->where('penjaminans.app', 'cetak')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
//                ->leftJoin('users', 'users.idbank', '=', 'banks.idbank')
                ->get();

        return view('admin.pelunasan', ['data' => $penjaminan]);
    }

    public function CekPengajuanCase($id) {

        $pengajuan = penjaminans::where('statusbayar', 0)
                ->where('penjaminans.idbank', $id)
                ->where('app', 'Pengecekan')
                ->where('case', 'Ya')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->get();
        return view('admin.cekpengajuancasebelumbayar', ['pengajuan' => $pengajuan]);
    }

            
 public function CekPengajuanCaseAll() {
        $pengajuan = penjaminans::where('statusbayar', 0)
                ->where('app', 'AnalisPenjaminan')
                ->where('case', 'Ya')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('kesehatan', 'kesehatan.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->get();
        return view('admin.cek.cekpengajuancase', ['pengajuan' => $pengajuan]);
    }
    public function CekPengajuanCaseSudahBayar($id) {

        $pengajuan = penjaminans::where('statusbayar', 1)
                ->where('penjaminans.idbank', $id)
                ->where('penjaminans.app', 'Pengecekan')
                ->where('case', 'Ya')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->get();
        return view('admin.cekpengajuancase', ['pengajuan' => $pengajuan]);
    }

    public function CekPengajuanCaseSudahBayarAll() {

        $pengajuan = penjaminans::
                select(
                        '*', 'penjaminans.idpenjaminan')
                ->where('statusbayar', 1)
                ->where('penjaminans.app', 'Pengecekan')
                ->where('case', 'Ya')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->get();
            
        return view('admin.cek.cekpengajuancasesudahbayar', ['pengajuan' => $pengajuan]);
    }

    
    protected function PenomoranSertifikat($id)
    {
        $penjaminans = penjaminans::where('penjaminans.idpenjaminan', $id)
//                ->leftjoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
                ->leftJoin('users', 'banks.idbank', '=', 'users.idbank')
//                ->leftJoin('rate', 'rate.idbank', '=', 'banks.idbank')
//                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->get();
        
        if (date('Y') == '2019')
        {

            $hitungsertifikat = sertifikats::
                    where(\DB::raw("(DATE_FORMAT(tglterbit,'%Y'))"), date('Y'))->count();

            if ($hitungsertifikat < 1) {
                $hitungsertifikat = 100 + 1;
            } else {

                $pengajuan = sertifikats::
                        where(\DB::raw("(DATE_FORMAT(tglterbit,'%Y'))"), date('Y'))
                        ->orderBy('sertifikats.id', 'desc')
                        ->take(2)
                        ->first();
                $data = explode('.', $pengajuan->kodesertifikat);
                $hitungsertifikat = ++$data[1];
            }
        } 
        else 
        { 
//               dd($penjaminans);
            if($penjaminans[0]['level']=="koperasi")
            {
               $hitungsertifikat = sertifikats::
                     leftJoin('penjaminans', 'penjaminans.idpenjaminan', '=', 'sertifikats.idpenjaminan')
                    ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
                    ->where('banks.jenisbank','like', '%koperasi%')
                    ->where(\DB::raw("(DATE_FORMAT(sertifikats.tglterbit,'%Y'))"), date('Y'))
                    ->count();
//               dd($hitungsertifikat);
            }
            else  if($penjaminans[0]['level']=="bpr")
            {
               $hitungsertifikat = sertifikats::
                     leftJoin('penjaminans', 'penjaminans.idpenjaminan', '=', 'sertifikats.idpenjaminan')
                    ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
                    ->where('banks.jenisbank','like', '%bpr%')
                    ->where(\DB::raw("(DATE_FORMAT(sertifikats.tglterbit,'%Y'))"), date('Y'))
                    ->count(); 
            }
            
           
            if ($hitungsertifikat < 1) 
            {
                $hitungsertifikat = $hitungsertifikat + 1;
            } 
            else
            {
             
                if ($penjaminans[0]['level']=="koperasi")
                {
                    $pengajuan = sertifikats::
                            leftJoin('penjaminans', 'penjaminans.idpenjaminan', '=', 'sertifikats.idpenjaminan')
                            ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
                            ->where('banks.jenisbank','like', '%koperasi%')
                            ->where(\DB::raw("(DATE_FORMAT(sertifikats.tglterbit,'%Y'))"), date('Y'))
                            ->orderBy('sertifikats.id', 'desc')
                            ->first();
//                    dd($pengajuan);
                    
                }
                else  if ($penjaminans[0]['level']=="bpr")
                {
                   $pengajuan = sertifikats::
                        where(\DB::raw("(DATE_FORMAT(tglterbit,'%Y'))"), date('Y'))
                        ->leftJoin('penjaminans', 'penjaminans.idpenjaminan', '=', 'sertifikats.idpenjaminan')
                        ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank') 
                        ->orderBy('sertifikats.id', 'desc')
                        ->where('banks.jenisbank','like', '%bpr%')
                        ->where(\DB::raw("(DATE_FORMAT(sertifikats.tglterbit,'%Y'))"), date('Y')) 
                        ->first();  
                }

                $data = explode('.', $pengajuan->kodesertifikat);
                $hitungsertifikat = ++$data[1];
            }
//             dd($pengajuan);
        }

        $nourutsertifikat = $hitungsertifikat;
        
        if($penjaminans[0]['level']=="koperasi")
        {
           $jeniskredit = '04'; 
        }
        else
        {
            if ($penjaminans[0]['jeniskredit'] == 'PRODUKTIF') {
                $jeniskredit = '02'; //jika dilihat di SK penomoran jenis kredit 02 adalah Kredit Usaha Kecil
            } else if ($penjaminans[0]['jeniskredit'] == 'KONSUMTIF') {
                $jeniskredit = '12'; //jika dilihat di SK penomoran jenis kredit 12 adalah KSG PNS Otonom
            } else {
                $jeniskredit = '13';
            }
        }
        
        
         //untuk menampilkan registrasi bank
        if ($penjaminans[0]['jenisbank'] == 'bpdNTB') {
            $registrasibank = '01';
        } else if($penjaminans[0]['jenisbank'] == 'bprpemda') {
            $registrasibank = '02';
        } else if($penjaminans[0]['jenisbank'] == 'bprnonpemda'){
            $registrasibank = '03';
        }  
        else if($penjaminans[0]['jenisbank'] == 'koperasiPns') 
        {
            $registrasibank = '04'; //kode registrasi untuk koperasi
        }else if($penjaminans[0]['jenisbank'] == 'koperasiSwasta') 
        {
            $registrasibank = '05'; //kode registrasi untuk koperasi
        }


        $bulan = date('m');
        switch ($bulan) {
            case '1' :
                $bulan = '01';
                break;
            case '2' :
                $bulan = '02';
                break;
            case '3' :
                $bulan = '03';
                break;
            case '4' :
                $bulan = '04';
                break;
            case '5' :
                $bulan = '05';
                break;
            case '6' :
                $bulan = '06';
                break;
            case '7' :
                $bulan = '07';
                break;
            case '8' :
                $bulan = '08';
                break;
            case '9' :
                $bulan = '09';
                break;
            case '10' :
                $bulan = '10';
                break;
            case '11' :
                $bulan = '11';
                break;
            case '12' :
                $bulan = '12';
                break;
        }
        $kodesertifikat = $registrasibank . '.' .
                str_pad($nourutsertifikat, 4, '0', STR_PAD_LEFT) . '.' .
                $jeniskredit . '.' .
                $penjaminans[0]['kodecabang'] . '.' .
                '01' . '.' . //kode agen
                $bulan . '.' .
                date('Y');
        return  $kodesertifikat;
    }
    
    function fetchdataValidasi(Request $request) 
    {
//        dd($request);
        $id = $request->id;
        $penjaminan = penjaminans::where('penjaminans.idpenjaminan', $id)
                ->leftJoin('kesehatan', 'kesehatan.nosertifikat', '=', 'penjaminans.nosertifikat')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->first(); 
        $history_cases = penjaminans::where('penjaminans.idpenjaminan', $id)
                     ->leftJoin('history_cases', 'history_cases.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                     ->first();
            

        $totalbayar = $penjaminan->nett + $penjaminan->admin + $penjaminan->materai;
        $output = [
            'kodesertifikat' => $this->PenomoranSertifikat($id),
            'totalbayar' => number_format($totalbayar, 2, '.', ','),
            'periode' => date('d/m/Y', strtotime($penjaminan->tglrealisasi)) . '-' . date('d/m/Y', strtotime($penjaminan->tgljatuhtempo)),
            'admin' => number_format($penjaminan->admin, 2, '.', ','),
            'materai' => number_format($penjaminan->materai, 2, '.', ','),
            'siup' => $penjaminan->siup,
            'npwp' => $penjaminan->npwp,
            'idpenjaminan' => $penjaminan->idpenjaminan,
            'idbank' => $penjaminan->idbank,
            'nosertifikat' => $penjaminan->nosertifikat,
            'ktp' => $penjaminan->ktp,
            'nama' => $penjaminan->nama,
            'tgllahir' => date('d/m/Y', strtotime($penjaminan->tgllahir)),
            'umur' => $penjaminan->umur,
            'pekerjaan' => $penjaminan->pekerjaan,
            'jeniskredit' => $penjaminan->jeniskredit,
            'alamat' => $penjaminan->alamat,
            'tglrealisasi' => date('d/m/Y', strtotime($penjaminan->tglrealisasi)),
            'tgljatuhtempo' => date('d/m/Y', strtotime($penjaminan->tgljatuhtempo)),
            'umurjatuhtempo' => $penjaminan->umurjatuhtempo,
            'nopk' => $penjaminan->nopk,
            'tglpk' => date('d/m/Y', strtotime($penjaminan->tglpk)),
            'jenispenjaminan' => $penjaminan->jenispenjaminan,
            'tglpengajuan' => $penjaminan->tglpengajuan,
            'statusbayar' => $penjaminan->statusbayar,
            'kodebayar' => $penjaminan->kodebayar,
            'masakredit' => $penjaminan->masakredit,
            'plafon' => number_format($penjaminan->plafon, 2, '.', ','),
            'rate' => $penjaminan->rate,
            'ijp' => number_format($penjaminan->premi, 2, '.', ','),
            'dis' => $penjaminan->dis,
            'potongan' => number_format($penjaminan->pot, 2, '.', ','),
            'analisa' => $penjaminan->analisa,
            'nett' => number_format($penjaminan->nett, 2, '.', ','),
            'app' => $penjaminan->app,
            'kesehatan' => $penjaminan->files,
            'kesehatanrs' => $penjaminan->files3,
            'ceklab' => $penjaminan->files2,
            'pembayaran' => $penjaminan->file,
            'namabank' => $penjaminan->namabank,
            'ceknama' => $penjaminan->ceknama,
            'cekktp' => $penjaminan->cekktp,
            'cektgllahir' => $penjaminan->cektgllahir,
            'cekpekerjaan' => $penjaminan->cekpekerjaan,
            'cekjeniskredit' => $penjaminan->cekjeniskredit,
            'cekjenispenjaminan' => $penjaminan->cekjenispenjaminan,
            'cekperiode' => $penjaminan->cekperiode,
            'cekijp' => $penjaminan->cekijp,
            'cekpembayaran' => $penjaminan->cekpembayaran,
            'ceksuratsehat' => $penjaminan->ceksuratsehat,
            'ceksuratsehatrs' => $penjaminan->ceksuratsehatrs,
            'ceklabcek' => $penjaminan->ceklab,
            'cekmasakredit' => $penjaminan->cekmasakredit,
            'cekpotongan' => $penjaminan->cekpotongan,
            'cekumur' => $penjaminan->cekumur,
            'ceknopk' => $penjaminan->ceknopk,
            'cekplafon' => $penjaminan->cekplafon,
            'cekrate' => $penjaminan->cekrate,
            'ceknett' => $penjaminan->ceknett,
            'analisaPekerjaan' => $penjaminan->analisa_pekerjaan,
            'url_penjaminan' => $penjaminan->url_penjaminan,
            'analisaUmur' => $history_cases->analisa_umur,
            'TekananDarah' => $history_cases->tensi,
            'GulaDarah' => $history_cases->guladarah,
            'Kolesterol' => $history_cases->kolesterol,
            'Tekananjantung' => $history_cases->tekanan_jantung,
            'analisaKesehatan' => $history_cases->analisa_kesehatan,
            'hasilakhir' => $history_cases->hasil_akhir,
            'tanggapandir' => $history_cases->tanggapandir,
            
        ];
        echo json_encode($output);
    }

    function fetchdataValidasiPengajuan(Request $request) 
    {
        $id = $request->id;
        $penjaminan = penjaminans::select(
                        '*', 'penjaminans.idpenjaminan')
                ->where('penjaminans.nosertifikat', $id)
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('kesehatan', 'kesehatan.nosertifikat', '=', 'penjaminans.nosertifikat')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('history_cases', 'history_cases.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('t_grace_periodes', 't_grace_periodes.id_penjaminan', '=', 'penjaminans.idpenjaminan')
                ->first();
            
        $totalbayar = $penjaminan->nett + $penjaminan->admin + $penjaminan->materai;
        $tanggal1 = new DateTime($penjaminan->tglpengajuan);
        $tanggal2 = new DateTime($penjaminan->tglrealisasi);
        $perbedaan = $tanggal2->diff($tanggal1)->format("%a");

        if ($perbedaan > 0) 
        {
            $pengajuan = 'Pengajuan :' . date('d-m-Y', strtotime($penjaminan->tglpengajuan)) . ' Realisasi: ' . date('d-m-Y', strtotime($penjaminan->tglrealisasi)) . ', Pengajuan Ini Lewat '
                    . $perbedaan . ' Hari';
        } 
        else
        {
            $pengajuan = '';
        }
        
        IF(Session::get('level')=='Direksi')
        {
            if ($penjaminan->jenispenjaminan == "KREDIT DENGAN PEMBAYARAN MUSIMAN(PLAFOND)") 
            {
                $jenisPenjaminan = "MACET KARENA MENINGGAL DUNIA";
            } ELSE {
                $jenisPenjaminan = $penjaminan->jenispenjaminan;
            }
        }
        else
        {
           $jenisPenjaminan = $penjaminan->jenispenjaminan;
   
        }
        
        $taggallahir         =  date('d/m/Y', strtotime($penjaminan->tgllahir));
         
        $lahir                     = new DateTime($penjaminan->tgllahir); 
        
//        dd($lahir);
       
         $sekarang           = new DateTime();
        $DataUmur         =  $lahir->diff($sekarang);
     
         $tgl_jatuh_tempo      = date('d/m/Y', strtotime($penjaminan->tgljatuhtempo));
         $jatuhtempo              = new DateTime($penjaminan->tgljatuhtempo); 
         $DataUmur                = $lahir->diff($jatuhtempo);
         $umurJatuhTempo = $DataUmur->y . ' Tahun, '. $DataUmur->m . ' Bulan, '. $DataUmur->d .' Hari';
         $cek_jatuh_tempo  = $DataUmur->y;
        
        $output = [ 
            'cek_jatuh_tempo' => $cek_jatuh_tempo,
            'akhirGrace' => date('d-m-Y', strtotime("+$penjaminan->periode month", strtotime($penjaminan->tgl_mulai))),
            'tglGrace' => date('d/m/Y', strtotime($penjaminan->tgl_mulai)),
            'masaGrace' => $penjaminan->periode,
            'phone' => $penjaminan->phone,
            'oleh' => $penjaminan->oleh,
            'totalbayar' => number_format($totalbayar, 2, '.', ','),
            'periode' => date('d/m/Y', strtotime($penjaminan->tglrealisasi)) . ' - ' . date('d/m/Y', strtotime($penjaminan->tgljatuhtempo)),
            'admin' => number_format($penjaminan->admin, 2, '.', ','),
            'materai' => number_format($penjaminan->materai, 2, '.', ','),
            'siup' => $penjaminan->siup,
            'npwp' => $penjaminan->npwp,
            'jenispengajuan' => $penjaminan->jenispengajuan,
            'idpenjaminan' => $penjaminan->idpenjaminan,
            'idbank' => $penjaminan->idbank,
            'nosertifikat' => $penjaminan->nosertifikat,
            'ktp' => $penjaminan->ktp,
            'nama' => $penjaminan->nama,
            'tgllahir' => date('d/m/Y', strtotime($penjaminan->tgllahir)),
            'umur' => $penjaminan->umur,
            'pekerjaan' => $penjaminan->pekerjaan,
            'jeniskredit' => $penjaminan->jeniskredit,
            'alamat' => $penjaminan->alamat,
            'tglrealisasi' => date('d/m/Y', strtotime($penjaminan->tglrealisasi)),
            'tgljatuhtempo' => date('d/m/Y', strtotime($penjaminan->tgljatuhtempo)),
            'umurjatuhtempo' => $umurJatuhTempo,
            'nopk' => $penjaminan->nopk,
            'tglpk' => date('d/m/Y', strtotime($penjaminan->tglpk)),
            'jenispenjaminan' => $jenisPenjaminan,
            'tglpengajuan' => $penjaminan->tglpengajuan,
            'statusbayar' => $penjaminan->statusbayar,
            'kodebayar' => $penjaminan->kodebayar,
            'masakredit' => $penjaminan->masakredit,
            'plafon' => number_format($penjaminan->plafon, 2, '.', ','),
            'rate' => $penjaminan->rate,
            'ijp' => number_format($penjaminan->premi, 2, '.', ','),
            'dis' => $penjaminan->dis,
            'potongan' => number_format($penjaminan->pot, 2, '.', ','),
            'analisa' => $penjaminan->analisa,
            'nett' => number_format($penjaminan->nett, 2, '.', ','),
            'app' => $penjaminan->app,
            'kesehatan' => $penjaminan->files,
            'kesehatanrs' => $penjaminan->files3,
            'ceklab' => $penjaminan->files2,
            'pembayaran' => $penjaminan->file,
            'tensi' => $penjaminan->tensi,
            'guladarah' => $penjaminan->guladarah,
            'kolesterol' => $penjaminan->kolesterol,
            'tekanan_jantung' => $penjaminan->tekanan_jantung,
            'analisa_pekerjaan' => $penjaminan->analisa_pekerjaan,
            'analisa_umur' => $penjaminan->analisa_umur,
            'analisa_kesehatan' => $penjaminan->analisa_kesehatan,
            'hasilakhir' =>$penjaminan->hasil_akhir,
            'tanggapandir' =>$penjaminan->tanggapandir,
            'pengajuan' => $pengajuan,
            'lewat' => $perbedaan,
            'url_penjaminan' => $penjaminan->url_penjaminan,
        ];
        echo json_encode($output);
    }

    function FetchDataBank(Request $request) {
        $id = $request->id;
        $data = banks::where('idbank', $id)->first();


        $output = [
            'kodecabang' => $data->kodecabang,
            'namabank' => $data->namabank,
            'alamat' => $data->alamatbank,
            'telp' => $data->telp,
            'dis' => $data->dis,
            'admin' => $data->admin,
            'materai' => $data->materai,
            'share' => $data->share,
            'minijp' => $data->minijp,
        ];

        echo json_encode($output);
    }

    function ratecase(Request $request) {
        $idpenjaminan = $request->idpenjaminan;
        $rate = $request->ratecase / 100;

        $data = penjaminans::where('idpenjaminan', $idpenjaminan)
                ->leftjoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->first();

        $ijp = $data->plafon * $rate;
        $dis = $ijp * ($data->dis / 100);
        $net = $ijp - $dis;

        $output = [
            'ijp' => number_format($ijp, 2, '.', ','),
            'potongan' => number_format($dis, 2, '.', ','),
            'nett' => number_format($net, 2, '.', ','),
        ];

        echo json_encode($output);
    }
    
    protected function  CekPembayaranCase($request,$approval)
    {
         $data = approvals::where('idpenjaminan', $request->idpenjaminan)
                            ->update
                            ([
                                'ceklab'                        => $request->ceklab,
                                'idpenjaminan'          => $request->idpenjaminan,
                                'cekjenispenjaminan'    => $request->jenispenjaminan,
                                'cekpekerjaan'          => $request->pekerjaan,
                                'cekperiode'            => $request->periode,
                                'cekplafon'             => $request->plafon,
                                'cekrate'               => $request->rate,
                                'ceknett'               => $request->premi,
                                'cekpotongan'           => $request->potongan,
                                'cekijp'                => $request->ijp,
                                'ceksuratsehat'         => $request->kesehatan,
                                'ceksuratsehatrs'       => $request->kesehatanrs,
                                'ceknama'               => $request->nama,
                                'cekumur'               => $request->umur,
                                'analisa'               => $request->analisa,
                                'cekjeniskredit'        => $request->jeniskredit,
                                'cektgllahir'           => $request->tgllahir,
                                'ceknopk'               => $request->nopk,
                                'cekmasakredit'         => $request->masaKredit,
                                'cekktp'                => $request->ktp,
                                'cekpembayaran'         => ($request->pembayaran)?$request->pembayaran:null,
                                'hasilakhir'            => $approval,
                                'tglanalisa'            => date('Y-m-d'),
                                'oleh'                  => Auth::user()->name,
                            ]);
        
    }
    
    protected function Update_History_Case($request)
    {
                           $analisa = history_cases::where('idpenjaminan', $request->idpenjaminan)
                                    ->update([
                                        'idpenjaminan' => $request->idpenjaminan,
                                        'tensi' => $request->TekananDarah,
                                        'guladarah' => $request->GulaDarah,
                                        'kolesterol' => $request->Kolesterol,
                                        'tekanan_jantung' => $request->Tekananjantung,
                                        'analisa_pekerjaan' => $request->analisa,
                                        'analisa_umur' => $request->analisaUmur,
                                        'analisa_kesehatan' => $request->analisaKesehatan,
                                        'catatan_pembayaran' => $request->catatanPembayaran,
                                        'hasil_akhir' => $request->hasilakhir,
                                        'rekomendasi_kabag' => $request->rekomendasiKabag,
                                       ]);
    }
    
    protected function CreateApproval($request,$approval)
    {
            
        $data = approvals::create([
                                'cekpotongan'           => $request->potongan,
                                'ceklab'                => ($request->ceklab)?($request->ceklab):'-',
                                'idpenjaminan'          => $request->idpenjaminan,
                                'cekjenispenjaminan'    => $request->jenispenjaminan,
                                'cekpekerjaan'          => $request->pekerjaan,
                                'cekperiode'            => $request->periode,
                                'cekplafon'             => $request->plafon,
                                'cekrate'               => $request->rate,
                                'ceknett'               => $request->premi,
                                'cekpotongan'           => $request->potongan,
                                'cekijp'                => $request->ijp,
                                'ceksuratsehat'         => ($request->kesehatan)?($request->kesehatan):'-',
                                'ceksuratsehatrs'       => $request->kesehatanrs,
                                'ceknama'               => $request->nama,
                                'cekumur'               => $request->umur,
                                'analisa'               => $request->analisa,
                                'cekjeniskredit'        => $request->jeniskredit,
                                'cektgllahir'           => $request->tgllahir,
                                'ceknopk'               => $request->nopk,
                                'cekmasakredit'         => $request->masaKredit,
                                'cekktp'                => $request->ktp,
                                'hasilakhir'            => $approval,
                                'tglanalisa'            => date('Y-m-d'),
                                'oleh'                  => Auth::user()->name,
                    ]);
    }
    
    protected function CreateHistoryApproval($request)
    {
//            dd($request);
        
//        if ($request->analisaKesehatan)
//        {
//           $analisa=$request->analisa.", ". $request->analisaUmur.", ".  $request->analisaKesehatan.", ".  $request->hasilakhir;
//        }
//        else if ($request->catatanPembayaran!="")
//        {
//              $analisa=  $request->catatanPembayaran; 
//        }else{
//              $analisa=  $request->analisa;
//        }
        
        
        if ($request->catatanPembayaran!="")
        {
              $analisa=  $request->catatanPembayaran; 
        }else{
              $analisa=  $request->hasilakhir;
        }
        
        if ($request->rekomendasiKabag!="")
        {
              $analisa=  $request->rekomendasiKabag; 
        }else{
              $analisa=  $request->hasilakhir;
        }
        
        if ($request->keputusanDireksi!="")
        {
              $analisa=  $request->keputusanDireksi; 
        }else{
              $analisa=  $request->hasilakhir;
        }
        
//dd($request->keputusanDireksi);
        
        date_default_timezone_set("Asia/Jakarta");
        date('Y-m-d H:i:s',strtotime('+1 hour')); 
        history_apps::create([
                           'analisa'   => $analisa,
                           'approval'       => $request->approval,
                           'tgl_analisa'    =>  date('Y-m-d H:i:s',strtotime('+1 hour ')),
                           'user'           => Auth::user()->id,
                           'idpenjaminan'   => $request->idpenjaminan,
//                           'komputer'       => gethostname(),
              ]);
        
    }
    
    protected function CreateHistoryApp($request,$analisa)
    { 
        date_default_timezone_set("Asia/Jakarta");
        date('Y-m-d H:i:s',strtotime('+1 hour')); 
        history_apps::create([
                           'analisa'   => $analisa,
                           'approval'       => $request->approval,
                           'tgl_analisa'    =>  date('Y-m-d H:i:s',strtotime('+1 hour ')),
                           'user'           => Auth::user()->id,
                           'idpenjaminan'   => $request->idpenjaminan,
//                           'komputer'       => gethostname(),
              ]);
        
    }
    
    protected function CreateHistoryCase($request)
    {
        $analisa = history_cases::create([
                           'idpenjaminan'   => $request->idpenjaminan,
                           'tensi'          => ($request->TekananDarah)? $request->TekananDarah:'',
                           'guladarah'      =>($request->GulaDarah)? $request->GulaDarah:'',
                           'kolesterol'     => ($request->Kolesterol)? $request->Kolesterol:'',
                           'tekanan_jantung'=> ($request->Tekananjantung)?$request->Tekananjantung:'',
                           'analisa_pekerjaan'=>( $request->analisa)? $request->analisa:'',
                           'analisa_umur'    => ( $request->analisaUmur)?$request->analisaUmur:'',
                           'analisa_kesehatan'=> ( $request->analisaKesehatan)?$request->analisaKesehatan:'',
                           'hasil_akhir'=>  ( $request->hasilakhir)?$request->hasilakhir:'',
                           'rekomendasi_kabag'=>  ( $request->rekomendasiKabag)?$request->rekomendasiKabag:'',
                ]);
    }
    
   public function ValidasiCaseByCase($request)
   {
     
                $validation     = $this->ValidasiIsianFormValidasi($request);
                $error_array    = array();
                $success_output = '';
                
                if ($validation->fails()) 
                {
                    foreach ($validation->messages()->getMessages() as $field_name => $messages) 
                    {
                        $error_array[] = $messages;
                    }
                } 
                else                     
                {
                    if (
                            $request->periode             == 'Ok' & 
                            $request->plafon                 == 'Ok' &
	    $request->premi                 == 'Ok' &
                            $request->rate                     == 'Ok' &
                            $request->kesehatan       == 'Ok' &
                            $request->kesehatanrs   == 'Ok' &
                            $request->nama                  == 'Ok' &
                            $request->pekerjaan        == 'Ok' &
                            $request->umur                  == 'Ok' &
                            $request->masaKredit    == 'Ok' &
                            $request->potongan         == 'Ok' &
                            $request->ktp                      == 'Ok' &
                            $request->jenispenjaminan == 'Ok' &
                            $request->tgllahir              == 'Ok' &
                            $request->nopk                   == 'Ok' &
	    $request->ceklab             == 'Ok' 
                    ) 
                    { 
                         if ($request->approval == 'direksi') 
                            {
                                $approval = $request->approval;
                                $success_output = 'Pengajuan berhasil dikirim ke direksi !!';
                                Mail::send('emails.welcome', ['name' => 'Hendiawan Dipa'], function ($message) {
                                    $message->to('hendiawan.dipa@gmail.com')
                                            ->cc('it.dev@jamkridantb.com')
                                            ->subject('Pengajuan Case By Case');
                                });
                            } 
                            else 
                            {
                                $approval = $request->approval;
                                $error_array = array();
                                $success_output = 'Pengajuan dikembalikan ke Bank !!';
                            } 
                    }
                    else 
                    {
//                        $approval = 'Tolak';
                        $approval = $request->approval;
                        $success_output = ' Pengajuan dikembalikan ke Bank  !';
                    }

                    $penjaminan = penjaminans::where('idpenjaminan', $request->idpenjaminan)
                        ->update([
                        'app'       => $approval,
                        'catatan'   => $request->hasilakhir,
                    ]);
                    
                    if($approval=='Tolak'){
                          date_default_timezone_set("Asia/Jakarta");
                          history_tolakans::create([
                            'idpenjaminan'=>$request->idpenjaminan,
                            'alasan'=>$request->hasilakhir,
                            'tgl_tolak'=>date('Y-m-d H:i:s',strtotime('+1 hour')),
                            'user'=> Session::get('id_user'),
                        ]);
                    }
                    
                     $this->CreateApproval($request,$approval);
                     $this->CreateHistoryApproval($request);
                     $this->CreateHistoryCase($request);
                }
          
            
            $data= [
                'data'=> $error_array,
                'succes'=>$success_output
            ];
            return $data;
   }
   
   public function ValidasiIsianFormValidasi($request)
   {
       $validation = Validator::make($request->all(),[
                            'ktp'                       => 'required',
                            'nama'                   => 'required',
                            'pekerjaan'          => 'required',
                            'tgllahir'               => 'required',
                            'umur'                   => 'required',
                            'jeniskredit'        => 'required',
                            'jenispenjaminan' => 'required',
                            'nopk'                  => 'required',
                            'periode'               => 'required',//TANGGAL PERTANGGUNGAN
                            'masaKredit'    => 'required',//LAMA KREDIT
                            'plafon'        => 'required',
                            'rate'          => 'required',
                            'ijp'           => 'required',//GROSS
                            'potongan'      => 'required',//DISCOUNT
                            'premi'         => 'required',//NETT
                            'kesehatan'     => 'required',
                            'kesehatanrs'   => 'required',
                            'ceklab'        => ($request->caseket=='Ya')?'required':'',
                            'pembayaran'    => ($request->caseket=='Tidak')?'required':'',
                            'analisa'       => 'required',
                            'analisaUmur'   => ($request->caseket=='Ya')?'required':'',
                            'TekananDarah'  => ($request->caseket=='Ya')?'required':'',
                            'GulaDarah'     => ($request->caseket=='Ya')?'required':'',
                            'Kolesterol'    =>($request->caseket=='Ya')?'required':'',
                            'Tekananjantung'=> ($request->caseket=='Ya')?'required':'',
                            'analisaKesehatan'=> ($request->caseket=='Ya')?'required':'',
                            'hasilakhir'=> ($request->caseket=='Ya')?'required':'',
                ]);
       return $validation;
   }
   public function ValidasiAutocover($request)
   {
      
                $validation     = $this->ValidasiIsianFormValidasi($request);
                $error_array    = array();
                $success_output = '';
//                                dd($error_array);
                if ($validation->fails()) 
                {
                    foreach ($validation->messages()->getMessages() as $field_name => $messages) {
                        $error_array[] = $messages;
                    }
                } 
                else  
                {
                    $penjaminan = penjaminans::
                             where('idpenjaminan', $request->idpenjaminan)
                            ->where('app','Pengecekan')
                            ->update
                             ([
                                'app'       => $request->approval,
                                'catatan'   => $request->analisa,
                             ]);
                    
                   
                    if($penjaminan)
                    {
                         $data= $this->CreateApproval($request,$request->approval);
                         $success_output = 'Pengajuan Berhasil di Approv';
                    }
                    else
                    {
                         $success_output = 'Pengajuan Sudah Diapprov Sebelumnya'; 
                    }
                    
               }
            
            
             $data= [
                'data'=> $error_array,
                'succes'=>$success_output
            ];
            return $data;
       
   }
   function postdataValidasi(Request $request) 
   { 
//       echo $requsssest;
//       dd($request);
        $approval       ='';
        $cek_approv     ='';
        $cekapproval    = approvals::where('idpenjaminan', $request->idpenjaminan)->count();
         
        if ($cekapproval > 0) //jika approval lebih dari satu, pengecekan untuk yang pengajuan ulang
        {
            if ($request->validasi == 'casebycase') //cek apakah jenis pengajuan case by case
            {
                   //jika case by case sudah melakukan pembayaran
                
                if ($request->cekpembayaran=='1')
                {
                         $validation = Validator::make($request->all(),[
                                'catatanPembayaran'    => 'required',
                                'pembayaran' => 'required',
                    ]);
    
                    $error_array = array();
                    $success_output = '';
                    if ($validation->fails()) 
                    {
                        foreach ($validation->messages()->getMessages() as $field_name => $messages) 
                        {
                            $error_array[] = $messages;
                        }
                    } 
                    else 
                    {
                        if ($request->pembayaran == 'Ok') {
                            $approval = 'Setuju';
                            $success_output = 'Data Updated';
                        } else {
                            $approval = $request->approval;
                            $success_output = 'DATA  DI KEMBALIKAN KE BANK';
                        }
                        $penjaminan = penjaminans::where('idpenjaminan', $request->idpenjaminan)
                                ->update([
                            'app' => $approval, 
                        ]);

                        $approval = approvals::where('idpenjaminan', $request->idpenjaminan)
                                ->update([
                            'analisa' => $request->analisa,
                            'cekpembayaran' => $request->pembayaran,
                            'hasilakhir' => $approval,
                        ]);
                        
                        $this->CekPembayaranCase($request, $approval);
                        $this->Update_History_Case($request);
                        $this->CreateHistoryApproval($request);
                    }
                }
                else
                {
                      $validation     = $this->ValidasiIsianFormValidasi($request);
                      $error_array    = array();
                      $success_output = '';
                
                    if ($validation->fails()) 
                    {
                        foreach ($validation->messages()->getMessages() as $field_name => $messages) 
                        {
                            $error_array[] = $messages;
                        }

                    } 
                    else 
                    {

                        if($request->cekpembayaran=='0')//untuk mengecek sudah bayar ato belum(0 UNTUK BELUM BAYAR, 1 UNTUK YANG SUDAH BAYAR )
                        {
                                    $cekpembayaran=''; //ini variabel yang digunakan untuk memberikan nilai kosong pada ceklist approval

                                    if (
                                        $request->ktp         == 'Ok' &
                                        $request->nama        == 'Ok' &
                                        $request->pekerjaan   == 'Ok' &
                                        $request->tgllahir    == 'Ok' &
                                        $request->umur        == 'Ok' &
                                        $request->jeniskredit == 'Ok' &
                                        $request->jenispenjaminan == 'Ok' &
                                        $request->nopk        == 'Ok' &
                                        $request->periode     == 'Ok' &
                                        $request->masaKredit  == 'Ok' &
                                        $request->plafon      == 'Ok' &
                                        $request->rate        == 'Ok' &
                                        $request->ijp         == 'Ok' &
                                        $request->potongan    == 'Ok' &
                                        $request->premi       == 'Ok' &
                                        $request->ceklab      == 'Ok' &
                                        $request->kesehatan   == 'Ok' &
                                        $request->kesehatanrs    == 'Ok'

                                ) 
                                {
                                            $approval       = $request->approval;

                                            if($request->approval=='direksi')
                                            {
                                                $success_output = 'Pengajuan berhasil dikirim ke direksi !!';
                                                Mail::send('emails.welcome', ['name' => 'Hendiawan Dipa'], function ($message) {
                                                $message->to('hendiawan.dipa@gmail.com')
                                                        ->cc('it.dev@jamkridantb.com')
                                                        ->subject('Pengajuan Case By Case');
                                                });
                                            }
                                            else
                                            {
                                               $error_array = array();
                                               $success_output = 'Pengajuan berhasil diapprov !!';
                                            }

                                }
                                else 
                                {
                                    $approval           = $request->approval;
                                    $success_output     = 'Data '.$request->approval.' dikembalikan ke Bank';
                                } 
                                
                                $penjaminan = penjaminans::where('idpenjaminan', $request->idpenjaminan) 
                                    ->update
                                     ([
                                        'app'       => $approval,
                                        'catatan'   => $request->hasilakhir,
                                     ]);
                                
                                     $this->CekPembayaranCase($request,$approval);
                                     $this->Update_History_Case($request);
                                     $this->CreateHistoryApproval($request);
                                     
                        }
                        else
                        {
                           //ketika pembayaran case by case ditolak maka akan mengarah pada block ini
                          if (
                                    $request->premi     == 'Ok' &
                                    $request->rate      == 'Ok' &
                                    $request->plafon    == 'Ok' &
                                    $request->ceklab    == 'Ok' &
                                    $request->periode   == 'Ok' &
                                    $request->premi     == 'Ok' &
                                    $request->kesehatan == 'Ok' &
                                    $request->kesehatanrs == 'Ok' &
                                    $request->nama      == 'Ok' &
                                    $request->pekerjaan == 'Ok' &
                                    $request->umur      == 'Ok' &
                                    $request->masaKredit== 'Ok' &
                                    $request->potongan  == 'Ok' &
                                    $request->pembayaran== 'Ok' &
                                    $request->ktp       == 'Ok' &
                                    $request->jenispenjaminan == 'Ok' &
                                    $request->tgllahir  == 'Ok' &
                                    $request->nopk      == 'Ok'
                            ) 
                            {
                                $approval = 'Setuju';
                                $success_output = 'Pembayaran Case By Case Berhasil Di validasi';
                            } 
                            else 
                            {
                                $approval = $request->approval;
                                $success_output = 'Data dikembalikan ke Bank..!!';
                            }
                            $cekpembayaran=$request->pembayaran;

                            $penjaminan = penjaminans::where('idpenjaminan', $request->idpenjaminan)
                                ->where('app','ulang')
                                ->update
                                ([
                                    'app'       => $approval,
    //                                'catatan'   => $request->analisa,
                                 ]);

                                $this->CekPembayaranCase($request,$approval);
                                $this->Update_History_Case($request);
                                $this->CreateHistoryApproval($request);


                        }
                    
                }
                    
                }

              
            }
            else if ($request->validasi == 'autocover') //cek apakah jenis pengajuan automatic
            {
               
                $validation = Validator::make($request->all(),[
                            'analisa'    => 'required',
                            'pembayaran' => 'required',
                ]);

                $error_array = array();
                $success_output = '';
                if ($validation->fails()) 
                {
                    foreach ($validation->messages()->getMessages() as $field_name => $messages) 
                    {
                        $error_array[] = $messages;
                    }
                } 
                else 
                {
                    
                    if ($request->pembayaran == 'Ok') 
                    {
                        $approval = 'Setuju';
                    } 
                    else 
                    {
                        $approval = 'Tolak';
                    }
                    
                    $penjaminan = penjaminans::where('idpenjaminan', $request->idpenjaminan)
//                            ->where('app','ulang')
                            ->update
                            ([
                                'app'       => $request->approval,
                                'catatan'   => $request->analisa,
                            ]);
                    
                    $data = approvals::where('idpenjaminan', $request->idpenjaminan)
                            ->update
                            ([
                                'analisa'       => $request->analisa,
                                'cekpembayaran' => $request->pembayaran,
                                'hasilakhir'    => $request->approval,
                            ]);
                            $this->CreateHistoryApproval($request);
                    if($data)
                    {
                          $success_output = 'Pengajuan Ulang Berhasil Di update'; 
                          $cek_approv     = '1';
                    }
                    else
                    {
                          $success_output = 'Pengajuan Sudah Diapprov Sebelumnya'; 
                    }
                    
                  
                }
            }
            
        } 
        else 
        {
             
           if ($request->validasi == 'autocover') 
           {
               $data=$this->ValidasiAutocover($request);
//                  dd($cekapproval);
               $this->CreateHistoryApproval($request);
            
               $error_array=$data['data'];
               $success_output =$data['succes'];
           }
           else if ($request->validasi == 'casebycase') 
           {
              
              $data=$this->ValidasiCaseByCase($request);
//                 dd($requssest);
              $error_array=$data['data'];
              $success_output =$data['succes']; 
           }
           
        }

        $output = 
            [
                'error'             => $error_array,
                'success'           => $success_output,
                'approval'          => $approval,
                'cek_sudah_app'     => $cek_approv,
            ];
        echo json_encode($output);
    }

    

    public function cetakdaftarsertifikat($id) 
    {

        $sertifikat = penjaminans::where('nosertifikat', $id)
                ->leftjoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('banks', 'pembayarans.idbank', '=', 'banks.idbank')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->get();

        $pdf = PDF::loadView('admin.laporan.daftarpenjaminan', [
                    'sertifikat' => compact('sertifikat'),
                    'terbilang' => self::terbilang($sertifikat[0]['nett']),
        ]);
        $pdf->setPaper('A4', 'landscape');
        // $pdf = App::make('dompdf');

        return $pdf->stream('Sertifikat' . '/' . $sertifikat[0]['namabank'] . '/' . $sertifikat[0]['kodebayar'] . '/' . $sertifikat[0]['jeniskredit'] . '/' . $sertifikat[0]['jenispenjaminan'] . '.pdf');
    }
    
    public function ShowHistoryApproval(request $request)
    {
//        dd($request);
        $DataHistoryApp = history_apps::
                          select(
                                'history_apps.id', 
                                'history_apps.analisa', 
                                'history_apps.approval', 
                                'history_apps.tgl_analisa', 
                                'users.name', 
                                'history_apps.komputer' 
                                )
                         ->where('idpenjaminan',$request->id)
                         ->leftjoin('users','users.id','=','history_apps.user')
                         ->orderBy('history_apps.id', 'desc')
                         ->get();
//        dd($DataHistoryApp);
//        $data = [
//            'pesan'=>$DataHistoryApp,
//        ];
//        
//        return json_encode($data);
        
        echo '<table class="table table-hover">';
        echo '<thead>';
        echo '<tr style="background-color:#23527c ;color: #000000"> ';
            echo '<th> Id</th>';
            echo '<th> Analisa</th>';
            echo '<th> Approval</th>';
            echo '<th> Tanggal Approv</th>';
            echo '<th> Petugas</th>';
//            echo '<th> Login</th>';
        echo '</tr>';
        echo '</thead>';
        
        echo '<tbody>';
        $i=1;
        foreach ($DataHistoryApp as $key => $data) 
        {
              echo '<tr>';
              echo '<td> '.$i.'</td>';
              echo '<td> '.$data->analisa.'</td>';
              echo '<td> '.$data->approval.'</td>';
              echo '<td> '.$data->tgl_analisa.'</td>';
              echo '<td> '.$data->name.'</td>';
//              echo '<td> '.$data->komputer.'</td>';
              echo '<tr>';
              $i++;
        }
        echo '</tbody>';
        
        echo '</table>';
    }

//    public function terbitkansertifikat($id) {
//
//        $penjaminans = penjaminans::where('nosertifikat', $id)
//                ->leftjoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
//                ->leftJoin('banks', 'pembayarans.idbank', '=', 'banks.idbank')
//                ->get();
//
//        $hitungsertifikat = sertifikats::leftjoin('penjaminans', 'penjaminans.idpenjaminan', '=', 'sertifikats.idpenjaminan')
//                        ->where('penjaminans.idbank', $penjaminans[0]['idbank'])->count();
//
//        $nourutsertifikat = $hitungsertifikat + 1;
//
//        if ($penjaminans[0]['jeniskredit'] == 'PRODUKTIF') 
//        {
//            $jeniskredit = 'I';
//        }
//        else if ($penjaminans[0]['jeniskredit'] == 'KONSUMTIF') 
//        {
//            $jeniskredit = 'II';
//        } 
//        else
//        {
//            $jeniskredit = 'III';
//        }
//
//        if ($penjaminans[0]['jenispenjaminan'] == 'JIWA') 
//            {
//            $jenispenjaminan = 'J';
//        } 
//        else if ($penjaminans[0]['jenispenjaminan'] == 'MACET') 
//        {
//            $jenispenjaminan = 'M';
//        }
//        else if ($penjaminans[0]['jenispenjaminan'] == 'JIWA DAN MACET') 
//        {
//            $jenispenjaminan = 'JM';
//        } 
//        ELSE 
//        {
//            $jenispenjaminan = 'L';
//        }
//
//        $kodesertifikat = $penjaminans[0]['idbank'] . '.' .
//                $jeniskredit . '.' .
//                $jenispenjaminan . '.' .
//                $penjaminans[0]['masakredit'] . '.' .
//                date('Ymd') . '.' . $nourutsertifikat;
//
//
//
//        $inputsertifikat = sertifikats::create([
//                    'kodesertifikat' => $kodesertifikat,
//                    'idpenjaminan' => $penjaminans[0]['idpenjaminan'],
//                    'tglterbit' => date('Y-m-d'),
//                    'diterbitkan' => Auth::user()->name,
//        ]);
//        $penjaminan = penjaminans::where('nosertifikat', $id)
//                ->update([
//            'app' => 'Cetak',
//            'cek' => '0',
//        ]);
//
//        if ($inputsertifikat) {
//            Session::flash('pesan', 'Sertifikat berhasil diterbitkan');
//        } else {
//            Session::flash('pesan', 'Sertifikat gagal diterbitkan');
//        }
//
//        return redirect('/datapenjaminanview');
//    }

    
//penerbitan sertifikat
    
   public function PostSertifikat(request $request) {
       

        date_default_timezone_set("Asia/Jakarta");
        $id = $request->id;

        $validation = Validator::make($request->all(), [
                    'sertifikat' => 'required',
        ]);

        $error_array = array();
        $success_output = '';
        if ($validation->fails()) 
        {
            foreach ($validation->messages()->getMessages() as $field_name => $messages) {
                $error_array[] = $messages;
            }
        } 
        else 
        {
            
            //proses penerbitan sertifikat jika sudah disetujui 
            
            $sertifikat = penjaminans::where('idpenjaminan', $id)
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
                ->first();
            $namabank= str_replace(" ", "-", $sertifikat->namabank);
            $namaTerjamin= str_replace(" ", "-", $sertifikat->nama);
             
            $BuatFolderSimpan = 'Sertifikat/' . date("Y") . '/' . date("m") . '/' . date("d"). $namabank . '/' ;

         //   File::makeDirectory($BuatFolderSimpan, $mode = 0777, true, true);
            $pengurus = pengurus::first();
//              dd($pengurus->url);
            $inputsertifikat = sertifikats::insert([
                        'kodesertifikat' => $request->sertifikat,
                        'idpenjaminan' => $id,
                        'tglterbit' =>    date('Y-m-d H:i:s',strtotime('+1 hour')),
                        'diterbitkan' => Auth::user()->name,
                        'verify' => md5(base64_encode($request->registrasi)),
                        'url' =>$BuatFolderSimpan,
                        'usr_ttd' =>$pengurus->nama,
                        'jabatan' =>$pengurus->jabatan,
                        'url_ttd' =>$pengurus->url,
            ]);
//         
           
            $penjaminan = penjaminans::where('idpenjaminan', $id)
                    ->update([
                        'app' => 'Cetak',
                        'cek' => '0',
                  ]);
            
            $sertifikat = penjaminans::where('penjaminans.idpenjaminan', $id)
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->get();
                              
           $fileName   = $request->sertifikat.'-'.$namaTerjamin. '.pdf';
           $UpdateSertifikat = 
                    sertifikats::where('idpenjaminan', $id)
                    ->update
                     ([
                            'url' => $BuatFolderSimpan.'/'.$fileName,
                     ]);
            
             //proses tanda tangan digital sertifikat penjaminan kredit
            $dataSign=[
                        'nik'=>'5208051004930002', 
                        'passphrase'=>'Hend!4wandip@'    //passphrase
            ]; 
             //akses API Sign 
            $sign = (new APIController())->signKreditFromCloud($id, $dataSign['nik'], $dataSign['passphrase']);           
//untuk simpan file sertifikat
//            $PublicPath     = public_path($BuatFolderSimpan);
//            $pdf                    = PDF::loadView('user.laporan.sertifikat', compact('sertifikat'));
//            $pdf->setPaper('A4', 'portrait');
//            $pdf->save($PublicPath . '/' . $fileName);
            
            $success_output = '<div class="alert alert-success">Sertifikat berhasil diterbitkan</div>';
        }
        $output = array(
            'error' => $error_array,
            'success' => $success_output,
        );
        echo json_encode($output);
    }

  
    protected function CekSiup($request)
    {
       if ($request->siup and $request->npwp) 
        {
            $siup = $request->siup;
            $npwp = $request->npwp;
        } 
        else 
        {
            $siup = '-';
            $npwp = '-';
        }
        
       return $data= ['siup'=>$siup,'npwp'=>$npwp];
    }
    
     protected function CekRate($request)
    {
        
        if ($request->kredit == 'PRODUKTIF') 
        {
            $produk = '5';
        } else {
            $produk = '1';
        }
         
        $data = explode('|', $request->jenisPenjaminan);
        
        $jenisPenjaminan = $data[0];
        $rate_detail = rate::leftJoin('banks', 'banks.idbank', '=', 'rate.idbank')
                ->where('banks.idbank', $request->idbank)
                ->where('rate.dari', '<=', $request->masakredit)
                ->where('rate.sampai', '>=', $request->masakredit)
                ->where('rate.namarate', $jenisPenjaminan)
                ->where('rate.idproduk', $produk)
                ->first(); 
//        dd($rate_detail);
       return $rate_detail;
        
    }
    
    protected function CekMinIJP($rate,$plafon)
    {
      
        $ijp = ($rate->rate / 100) * $plafon;
        if ($ijp < $rate->minijp) 
        {
            $ijp = $rate->minijp;
        }
        
        return $ijp;
    }
    
    public function UpdatePenjaminan(Request $request) 
    {
                  
//   dd($request);
//        if ($request->approval == 'ulang') 
//        {
//            $app = 'ulang';
//        } 
//        else 
//        {
//            $app = 'Pengecekan';
//        }
        
        if($request->statusbayar=='0' && $request->caseket=='Ya')
        {
             $realisasi='';
             $tglPK='';
//             $NoPK='';
             $jatuhtempo='';
             $umurJatuhTempo=$request->umurjatuhtempo;
        }
        else
        {
//               dd($request->tglpk);
             $tglPK             =self::tanggal($request->tglpk);
//             $NoPK              =$request->nopk;  
             $umurJatuhTempo    =$request->umurjatuhtempo;
             $realisasi         = self::tanggal($request->tglrealisasi);
             $jatuhtempo        = date('Y/m/d', strtotime("+$request->masakredit month", strtotime($realisasi)));
           
        }
//      

        $masakredit         = $request->masakredit;
        $dataumur           = explode(':', $request->umur);
        $tahun              = $dataumur[0];
        $CekSiup            = $this->CekSiup($request);
        $siup               = $CekSiup['siup'];
        $npwp               = $CekSiup['npwp'];
        $plafon             = self::nilai($request->plafon);
        $tarif              = $this->CekRate($request);
        $ijp                = $this->CekMinIJP($tarif,$plafon);
        $rate               = $tarif->rate;
        $dis                = $tarif->dis;
        $potongan           = $ijp * ($dis / 100);
        $nett               = $ijp - $potongan;
        $premi              = $ijp;
        $jenisPenjaminan    = $tarif->namarate;

        $update = penjaminans::where('idpenjaminan', $request->idpenjaminan)
                ->update([
                    'case'          => $request->caseket,
                    'siup'          => $siup,
                    'npwp'          => $npwp,
                    'masakredit'    => $request->masakredit,
                    'jeniskredit'   => $request->kredit,
                    'penggunaan'   => $request->penggunaan,
                    'tglrealisasi'  => $realisasi,
                    'tgljatuhtempo' => $jatuhtempo,
                    'umurjatuhtempo'=> $umurJatuhTempo,
                    'nopk'          => $request->nopk,
                    'idbank'        => $request->idbank,
                    'tglpk'         => $tglPK,
                    'plafon'        => self::nilai($request->plafon),
                    'rate'          => $rate,
                    'premi'         => $premi,
                    'dis'           => $dis,
                    'pot'           => $potongan,
                    'nett'          => $nett,
//                    'app'           => $app,
                    'jenispenjaminan' => $jenisPenjaminan,
        ]);

        $dataterjamin = penjaminans::where('idpenjaminan', $request->idpenjaminan)->first();
        $updateTerjamin = terjamins::where('id', $dataterjamin->idterjamin)
                ->update([
                    'ktp'           => $request->ktp,
                    'phone'          => $request->phone,
                    'nama'          => $request->name,
                    'tgllahir'      => self::tanggal($request->tglLhr),
                    'tempatlahir'   => $request->tempatlahir,
                    'umur'          => $tahun,
                    'jenis_pekerjaan'     => $request->jenis_pekerjaan,
                    'pekerjaan'     => $request->pekerjaan,
                    'alamat'        => $request->alamat,
        ]);

         //jika proses update biasa
            Session::flash('pesan', 'Data pengajuan berhasil di update');
            return redirect('ubahdata');

    }

    public function prosespelunasan(Request $request) {
        $update = penjaminans::where('idpenjaminan', $request->idpenjaminan)
                ->update([
            'app' => 'Lunas',
        ]);

        Session::flash('pesan', 'Proses Pelunasan Sukses');
        return redirect('pelunasan');
    }

    public function qrcode() {
        return view('qrcode.index');
    }

    public function verifysertifikat(request $request) 
    {
        $sertifikat = sertifikats::where('verify', $request->verify)
                ->leftjoin('penjaminans', 'penjaminans.idpenjaminan', '=', 'sertifikats.idpenjaminan')
                ->first();
        if ($sertifikat) {

            $output = [
                'id' => $sertifikat->idpenjaminan,
                'nama' => $sertifikat->nama,
                'kode' => $sertifikat->kodesertifikat,
                'verify' => $sertifikat->verify,
            ];
        } else {
            $output = [
                'id' => '',
                'nama' => '',
                'kode' => '',
                'verify' => '',
            ];
        }
        return json_encode($output);
    }
    
    public function qrcodegenerator() 
    {

        return view('admin.qrcode');
    }
    
    public function hapuspenjaminan(request $request) 
    {

        $id = $request->id;
//        dd($id);
        //  DB::delete('delete from penjaminans where idpenjaminan = ?',[$id]);

        $dataterjamin = penjaminans::where('idpenjaminan', $id)->first();

        $hapusterjamin = terjamins::where('id', $dataterjamin->idterjamin)->delete();
        //Hapus data Penjaminan

        $penjaminan = penjaminans::where('idpenjaminan', $id)->delete();

        $kesehatan = kesehatans::
                where('idpenjaminan', '=', $id)
                ->first();
        $pembayaran = pembayarans::
                where('idpenjaminan', '=', $id)
                ->first();

        @unlink('files/suratsehatrs/' . $kesehatan->files3);
        @unlink('files/suratsehat/' . $kesehatan->files);
        @unlink('files/scanlab/' . $kesehatan->files2);
        @unlink('files/buktibayar/' . $pembayaran->file);

        $kesehatan = kesehatans::
                where('idpenjaminan', '=', $id)
                ->delete();

        $sertifikat = sertifikats::
                where('idpenjaminan', '=', $id)
                ->delete();
        $approval = approvals::
                where('idpenjaminan', '=', $id)
                ->delete();

        $pembayaran = pembayarans::
                where('idpenjaminan', '=', $id)
                ->delete();

        echo json_encode('Data pengajuan berhasil di hapus');
    }

    public function PostChangePass(request $request) 
    {
        $this->validate($request, [
            'username' => 'required|max:255',
            'passwordlama' => 'required|min:6',
            'password' => 'required|min:6|confirmed',
        ]);


        $credentials = [
            'username' => $request->get('username'),
            'password' => $request->get('passwordlama'),
        ];

        if (\Auth::validate($credentials)) {
            $user = \App\User::where('username', $request->username)
                    ->update([
                'password' => bcrypt($request->password)
            ]);
            Session::flash('ubahpass', '');
            return redirect('datapenjaminanview');
        } else {
            Session::flash('pesan', 'Password lama yang dimasukkan tidak sesuai');
            return redirect('datapenjaminanview');
        }
    }

    public function simpanvalidasi(request $request) 
    {
        
//          dd($request);  
        foreach ($request->bayar as $key => $value) 
        {

            $penjaminan = penjaminans::where('idpenjaminan', $key)
                    ->where('app','Pengecekan')
                    ->update([
                            'app' => 'Setuju',
                            'catatan' => 'Sesuai',
                     ]);
            $approval = approvals::create([
                        'idpenjaminan' => $key,
                        'cekjenispenjaminan' => 'Ok',
                        'cekpekerjaan' => 'Ok',
                        'cekperiode' => 'Ok',
                        'cekplafon' => 'Ok',
                        'cekijp' => 'Ok',
                        'cekpembayaran' => $value,
                        'ceksuratsehat' => 'Ok',
                        'ceknama' => 'Ok',
                        'cekumur' => 'Ok',
                        'analisa' => 'Sesuai',
                        'cekjeniskredit' => 'Ok',
                        'cektgllahir' => 'Ok',
                        'ceknopk' => 'Ok',
                        'cekmasakredit' => 'Ok',
                        'cekpotongan' => 'Ok',
                        'cekktp' => 'Ok',
                        'hasilakhir' => 'Setuju',
                        'tglanalisa' => date('Y-m-d'),
                        'oleh' => Auth::user()->name,
            ]);
        }

        session::flash('pesan', 'Data pengajuan sudah diverifikasi');
        return redirect('datapenjaminanview');
    }
 
    public function cetaksuratpengajuan($id) {

        $suratpengajuan = penjaminans::where('nosertifikat', $id)
                ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
               ->leftJoin('t_history_banks', 'banks.idbank', '=', 't_history_banks.bank_id')
                ->get();
//        dd($suratpengajuan);
        $pdf = PDF::loadView('user.laporan.suratpengajuan', compact('suratpengajuan'));
        $pdf->setPaper('A4', 'portrait');
        // $pdf = App::make('dompdf');

        return $pdf->stream('SuratPengajuan' . '/' . $suratpengajuan[0]['namabank'] . '/' . $suratpengajuan[0]['kodebayar'] . '/' . $suratpengajuan[0]['jeniskredit'] . '/' . $suratpengajuan[0]['jenispenjaminan'] . '.pdf');
    }

    public function casesetuju() {
        $pengajuan = penjaminans::select(
                   '*', 
                   'penjaminans.idpenjaminan')
                ->where('case', 'Ya')
                ->where('app', 'CaseSetuju')
                ->orwhere('app', 'CaseTolak')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('history_cases', 'history_cases.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->get();
//         dd($pengajuan);
        return view('admin.cekdatacasesetuju', ['pengajuan' => $pengajuan]);
    }

    public function terbitkansurattolak(Request $request) {
//      echo  gethostbyaddr($_SERVER['REMOTE_ADDR']);
//        echo gethostname();
//        $mac1 = shell_exec("ipconfig /all");
//        $mac = shell_exec("arp -a ".escapeshellarg($_SERVER['REMOTE_ADDR'])." | grep -o -E '(:xdigit:{1,2}:){5}:xdigit:{1,2}'");
//        dd($mac1);
        date_default_timezone_set("Asia/Jakarta");
        $penjaminan = penjaminans::where('idpenjaminan', $request->idpenjaminan)
                ->update([
            'app' => 'Tolak',
        ]);
        
        $simpantolakan = history_tolakans::create([
                        'idpenjaminan'=>$request->idpenjaminan,
                        'alasan'=>$request->analisa,
                        'tgl_tolak'=>date('Y-m-d H:i:s',strtotime('+1 hour')),
                        'user'=> Session::get('id_user'),
                        ]);
        $this->CreateHistoryApproval($request);
        
        $success_output = 'Surat Penolakan Penjaminan Berhasil di Terbitkan';
        $output = array(
            'success' => $success_output,
        );
        echo json_encode($output);
    }

    public function terbitkansp3(Request $request) {
        date_default_timezone_set("Asia/Jakarta");
        date('Y-m-d H:i:s',strtotime('+1 hour'));
        
        $penjaminan = penjaminans::where('idpenjaminan', $request->id)
                ->update([
            'app' => 'Pembayaran',
        ]);
        
        $data = sp3s::create([
            'idpenjaminan'=> $request->id,
            'tglterbit'=> date('Y-m-d H:i:s',strtotime('+1 hour')),
            'user'=> Auth::user()->id
        ]);
                
        $success_output = 'Surat Persetujuan Prinsip Pejamainan Berhasil Di Terbitkan';
        $output = array(
            'success' => $success_output,
        );
        echo json_encode($output);
    }
    
 

    function autonumber($id_terakhir, $panjang_kode, $panjang_angka) 
    {

        // mengambil nilai kode ex: KNS0015 hasil KNS
        $kode = substr($id_terakhir, 0, $panjang_kode);

        // mengambil nilai angka
        // ex: KNS0015 hasilnya 0015
        $angka = substr($id_terakhir, $panjang_kode, $panjang_angka);

        // menambahkan nilai angka dengan 1
        // kemudian memberikan string 0 agar panjang string angka menjadi 4
        // ex: angka baru = 6 maka ditambahkan strig 0 tiga kali
        // sehingga menjadi 0006
        $angka_baru = str_repeat("0", $panjang_angka - strlen($angka)) . ($angka);

        // menggabungkan kode dengan nilang angka baru
        $id_baru = $kode . $angka_baru;

        return $id_baru;
    }

   
    public function cek_buktibayar($id) {

        $pengajuan = penjaminans::where('statusbayar', 1)
                ->where('case', 'Tidak')
//                ->where('app', 'Pengecekan')
                ->where('nosertifikat', $id)
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->get();
        // dd($pengajuan);
        return view('dokumen.cek_bukti_bayar', ['data' => $pengajuan]);
    }

    public function cek_kesehatan($id) {
           
//        $pengajuan = penjaminans::where('app', 'Ulang')
        $pengajuan = penjaminans::
                    where('penjaminans.nosertifikat', $id)
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('kesehatan', 'kesehatan.nosertifikat', '=', 'penjaminans.nosertifikat')
                ->get();
// dd($pengajuan);
        return view('dokumen.cek_sket', ['data' => $pengajuan]);
    }
    public function cek_kesehatanrs($id) {
           
//        $pengajuan = penjaminans::where('app', 'Ulang')
        $pengajuan = penjaminans::
                    where('penjaminans.nosertifikat', $id)
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('kesehatan', 'kesehatan.nosertifikat', '=', 'penjaminans.nosertifikat')
                ->get();
// dd($pengajuan);
        return view('dokumen.cek_sketrs', ['data' => $pengajuan]);
    }

    function cek_jumlah_sudah_app() {

        $pengajuan = penjaminans::where('statusbayar', 1)
                ->where('case', 'Tidak')
                ->where('app', 'Pengecekan')
                ->count();
        $output = [
            'jumlah' => $pengajuan,
        ];
        echo json_encode($output);
    }
    
    function cek_jumlah_setuju() {

        $pengajuan = penjaminans::where('statusbayar', 1)
                ->where('app', 'Setuju')
                ->count();
        $output = [
            'jumlah' => $pengajuan,
        ];
        echo json_encode($output);
    }
    
    public function CekPengajuanUlangCase() 
    {
        $pengajuan = penjaminans::where('app', 'ulang')
                 ->select(
                   '*', 
                   'penjaminans.idpenjaminan')
                ->where('case', 'Ya')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->get();
//         dd($pengajuan);  
                return view('admin.cek.cekpengajuanulangcase', ['pengajuan' => $pengajuan]);
    }
    
    public function sertifikatSppsb($id) {
//     $id =4;
        $table_sppsb = db::CONNECTION('db_sb')->table('sppsb');
        $table_result = db::CONNECTION('db_sb')->table('results');

        $sppsb = $table_sppsb->select('*','sppsb.created_at as tgl_input','sppsb.id as id','sppsb.url_ttd as url_ttd')
                ->leftJoin('users', 'users.id', '=', 'sppsb.user_id')
                ->where('sppsb.id', $id)
                ->first();
//        dd($sppsb);
        $result = $table_result->where('sppsb_id', $id)->first();

        //$selisih = ((abs(strtotime ($sppsb->waktu_mulai) - strtotime ($sppsb->waktu_selesai)))/(60*60*24));
        $selisih = ucwords($this->terbilang($sppsb->durasi));
//       dd($selisih);
        $nilaiProyek = ucwords($this->terbilang($sppsb->nilai_proyek));
        $nilaiJaminan = ucwords($this->terbilang($sppsb->nilai_jaminan));
        $nilaiProyekFormat = number_format($sppsb->nilai_proyek, 2, ",", ".");
        $nilaiJaminanFormat = number_format($sppsb->nilai_jaminan, 2, ",", ".");
//           dd($id);
        $charge = number_format($result->service_charge, 2, ",", ".");

     
//dd($sppsb);
        if ($sppsb->jenis_sppsb == '1') {
            $pathSppsb = 'report-sb.sertifikatpenawaran';
        } elseif ($sppsb->jenis_sppsb == '2') {
            $pathSppsb = 'report-sb.sertifikatpelaksanaan';
        } elseif ($sppsb->jenis_sppsb == '3') {
            $pathSppsb = 'report-sb.sertifikatuangmuka';
        } elseif ($sppsb->jenis_sppsb == '4') {
            $pathSppsb = 'report-sb.sertifikatpemeliharaan';
        } elseif ($sppsb->jenis_sppsb == '5') {
            $pathSppsb = 'report-sb.sertifikatpembayaran';
        } elseif ($sppsb->jenis_sppsb == '6') {
            $pathSppsb = 'report-sb.sertifikatsanggahbanding';
        }
//dd($pathSppsb);
        $pdf = PDF::loadView($pathSppsb, compact(
                                'sppsb', 'result', 'selisih', 'nilaiJaminan', 'nilaiJaminanFormat', 'charge'));

        return $pdf->stream('sertifikat.pdf');

        //return view($pathSppsb, compact('sppsb','result','selisih','nilaiJaminan','nilaiJaminanFormat','charge'));
    }
    
    
    function detailPenjaminan($id) 
    {    
        $penjaminan = penjaminans::select('*','penjaminans.idpenjaminan')->where('penjaminans.idpenjaminan', $id)
                ->leftJoin('kesehatan', 'kesehatan.nosertifikat', '=', 'penjaminans.nosertifikat')
                ->leftJoin('persyaratans', 'persyaratans.id', '=', 'penjaminans.persyaratan_id') 
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('approvals', 'approvals.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
               ->leftJoin('history_cases', 'history_cases.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->first();  
  
//        $history_cases = penjaminans::where('penjaminans.idpenjaminan', $id)
//                     ->leftJoin('history_cases', 'history_cases.idpenjaminan', '=', 'penjaminans.idpenjaminan')
//                     ->first(); 
         $user = Auth::user()->jabatan;
        $historyApproval = history_apps::
                          select(
                                'history_apps.id', 
                                'history_apps.analisa', 
                                'history_apps.approval', 
                                'history_apps.tgl_analisa', 
                                'users.username as name', 
                                'history_apps.komputer' 
                                )
                         ->where('idpenjaminan',$id)
                         ->leftjoin('users','users.id','=','history_apps.user')
                         ->orderBy('history_apps.id', 'desc')
                         ->get();
            
        
        $detailSkim = $penjaminan->detail_skim;
   
//        echo json_encode($output);
                    
       if($detailSkim=="JIWA"){
            return     $this->showJiwa($penjaminan,$historyApproval,$user);
       }else if ($detailSkim=="MACET"){
           if($penjaminan->jeniskredit=='PRODUKTIF'){
              return  $this->showMacet($penjaminan,$historyApproval,$user);
           }else{ 
              return   $this-> showPhk($penjaminan,$historyApproval,$user);
           }
       }else if ($detailSkim=="PHK"){
//              dd(Auth::user()->jabatan);  
         return   $this->showPhk($penjaminan, $historyApproval, $user); 
       }else{ 
          return  $this->showJiwa($penjaminan,$historyApproval,$user);
       }
     
    }
    
    public function showJiwa($penjaminan,$historyApproval,$user){ 
             if (Auth::user()->jabatan == 'Direktur'){
                     return view('admin.detailPenjaminanJiwaDireksi', compact('penjaminan','historyApproval','user'));
            }else if (Auth::user()->jabatan == 'Kabag'){   
//                      dd($detailSkim);
                     return view('admin.detailPenjaminanJiwaKabag', compact('penjaminan','historyApproval','user')); 
            }else { 
                     return view('admin.detailPenjaminan', compact('penjaminan','historyApproval','user'));
            } 
    }

    public function showPhk($penjaminan,$historyApproval,$user){
            
          if (Auth::user()->jabatan == 'Kabag'){
                   return view('admin.detailPenjaminanPhkKabag', compact('penjaminan','historyApproval','user'));
//                dd();
            }else if (Auth::user()->jabatan == 'Direktur'){
                   return view('admin.detailPenjaminanPhkDireksi', compact('penjaminan','historyApproval','user'));
            }else{ 
//                  dd(Auth::user()->jabatan);  
                 
                   return view('admin.detailPenjaminanPhk', compact('penjaminan','historyApproval','user')); 
            } 
    }
    
    public function  showMacet($penjaminan,$historyApproval,$user){ 
            
            if (Auth::user()->jabatan == 'Kabag'){
                   return view('admin.detailPenjaminanMacetKabag', compact('penjaminan','historyApproval','user'));
                
            }else if (Auth::user()->jabatan == 'Direktur'){
                   return view('admin.detailPenjaminanMacetDireksi', compact('penjaminan','historyApproval','user'));
            }else{  
                   return view('admin.detailPenjaminanMacet', compact('penjaminan','historyApproval','user'));
            } 
    }


    public function postValidasi(request $request) 
    { 

       
//         $validation = Validator::make($request->all(),[
//                                'catatanPembayaran'    => 'required',
//                                'pembayaran' => 'required',
//                    ]);
                
        if ($request->caseket!='Ya')
         {
                 $this->validate($request, [
                 'hasilakhir'=>(Auth::user()->jabatan == 'Staf')?'required':'',
                 'rekomendasiKabag'=>(Auth::user()->jabatan == 'Kabag')?'required':'',
                'approval' => 'required', 
                ]);
        }
        else
            {
            $this->validate($request, [ 
                'analisa' => 'required|max:255',//analisa pekerjaan
                'approval' => 'required', 
                'analisaUmur'   => 'required', 
                'TekananDarah'  =>  'required', 
                'GulaDarah'     => 'required', 
                'Kolesterol'    => 'required', 
                'Tekananjantung'=>  'required', 
                'analisaKesehatan'=> 'required', 
                'hasilakhir'=>   (Auth::user()->jabatan == 'Staf')?'required':'',
                'catatanPembayaran'    => ($request->statusbayar==1)?'required':'',
            ]);
        }
     

            $penjaminan = penjaminans::where('idpenjaminan', $request->idpenjaminan)
//                    ->where('app','Pengecekan')
                 ->update([
                         'app' =>$request->approval,
                         'catatan' =>$request->hasilakhir,
                  ]);
            
            $cek  = approvals::where('idpenjaminan', $request->idpenjaminan)->count();
//            dd($cek);
            if($cek<1){
                $this->create_approval($request);
            }else{
                 approvals::where('idpenjaminan', $request->idpenjaminan)
                ->update([
                     'hasilakhir' => $request->approval,
                     'tglanalisa' => date('Y-m-d'),
                     'oleh' => Auth::user()->name,
                 ]);
            } 
            
             if (Auth::user()->jabatan == 'Direktur') {
                    $analisa = $request->keputusanDireksi;
                     $penjaminan = penjaminans::where('idpenjaminan', $request->idpenjaminan)
                        ->update([
                            'tanggapandir' => $request->keputusanDireksi,
                         ]);
                } else   if (Auth::user()->jabatan == 'Kabag') {
                    $analisa = $request->rekomendasiKabag;
                } else {
                    $analisa = $request->hasilakhir;
                }
       
        
        if( $request->approval=='Tolak'){
                          date_default_timezone_set("Asia/Jakarta");
                          history_tolakans::create([
                            'idpenjaminan'=>$request->idpenjaminan,
                            'alasan'=>$analisa,
                            'tgl_tolak'=>date('Y-m-d H:i:s',strtotime('+1 hour')),
                            'user'=> Session::get('id_user'),
                        ]);
            }
            
           if ($request->approval == 'direksi') 
                { 
//                    Mail::send('emails.welcome', ['name' => 'Hendiawan Dipa'], function ($message) {
//                        $message->to('hendiawan.dipa@gmail.com')
//                                ->cc('it.dev@jamkridantb.com')
//                                ->subject('Pengajuan Case By Case');
//                    });
                } 
//                   $this->CreateHistoryApproval($request);
//         
//                   
//                    if($request->approval=='AnalisPenjaminan'){
//                        $this->CreateHistoryApp($request,$request->rekomendasiKabag);
//                }else  if($request->approval=='kabag'){
//                    if ( Session::get('level')=='Direksi'){
//                            $this->CreateHistoryApp($request,$request->keputusanDireksi);
//                    }else{
//                            $this->CreateHistoryApp($request,$request->hasilakhir);
//                    } 
//                }else  if($request->approval=='direksi'){
//                       $this->CreateHistoryApp($request,$request->rekomendasiKabag); 
//                }else  if($request->approval=='CaseSetuju'){
//                       $this->CreateHistoryApp($request,$request->keputusanDireksi);
//                      
//                }
//                  if($request->approval=='Revisi'){ 
//                        $this->CreateHistoryApp($request,$analisa);
//                         $penjaminan = penjaminans::where('idpenjaminan', $request->idpenjaminan)
//                        ->update([
//                            'catatan' => $analisa,
//                         ]);
//                  }
                 
            
          
                 if ($request->caseket=='Ya'){ 
                      if ($request->catatanPembayaran) {
                             $analisa= $request->catatanPembayaran;
                      }  
                    $cek  = history_cases::where('idpenjaminan', $request->idpenjaminan)->count();
                        if($cek<1){
                             $this->CreateHistoryCase($request);
                        }else{
                             $this->Update_History_Case($request);
                        } 
                  }
                 $this->CreateHistoryApp($request,$analisa);   
                $penjaminan = penjaminans::where('idpenjaminan', $request->idpenjaminan)
                 ->update([
                     'catatan' => $analisa,
                  ]); 
        
               
               session::flash('pesan', 'Data pengajuan sudah diverifikasi');
               return redirect('datapenjaminanview');
    } 
    
    public function postValidasiProduktif(request $request) 
    { 

       
//         $validation = Validator::make($request->all(),[
//                                'catatanPembayaran'    => 'required',
//                                'pembayaran' => 'required',
//                    ]);
//           echo "halo";
//      dd($request);    
        if ($request->caseket!='Ya')
            {
                 $this->validate($request, [
                'hasilakhir'=>(Auth::user()->jabatan == 'Staf')?'required':'',
                'rekomendasiKabag'=>(Auth::user()->jabatan == 'Kabag')?'required':'',
                'approval' => 'required', 
                ]);
        }
        else{
            $this->validate($request, [ 
                'approval' => 'required', 
                'hasilakhir'=>(Auth::user()->jabatan == 'Staf')?'required':'',
                'catatanPembayaran'    => ($request->statusbayar==1)?'required':'',
                'rekomendasiKabag'=>(Auth::user()->jabatan == 'Kabag')?'required':'',
                'sukuBunga'    => 'required',  
                'angsuran'    => 'required',  
                'pengecekanSlik'    =>'required',  
                'omsetPenjualan'    => 'required',  
                'hpp'    => 'required',  
                'biayaRumahTangga'    => 'required',  
                'biayaUsaha'    => 'required',  
                'angsuranKreditTempatLain'    => 'required',  
                'nilaiPasar'    =>'required',  
                'taksiran_taksasi'    =>'required',  
                'jenisAgunan'    =>'required',   
                'kapasitas'    =>'required',   
            ]);
        }
     
//          dd($request);    
            $penjaminan = penjaminans::where('idpenjaminan', $request->idpenjaminan)
//                    ->where('app','Pengecekan')
                 ->update([
                         'suku_bunga' =>$request->sukuBunga,
                         'angsuran' => $this->nilai($request->angsuran),
                         'pengecekan_slik' => $request->pengecekanSlik ,
                         'omset_penjualan' => $this->nilai($request->omsetPenjualan),
                         'hpp' => $this->nilai($request->hpp),
                         'biaya_rumah_tangga' => $this->nilai($request->biayaRumahTangga),
                         'biaya_usaha' => $this->nilai($request->biayaUsaha),
                         'angsuran_lainnya' => $this->nilai($request->angsuranKreditTempatLain),
                         'pendapatan_bersih' => $this->nilai($request->labaBersih),
                         'nilai_pasar' => $this->nilai($request->nilaiPasar), 
                         'jenis_agunan' => $request->jenisAgunan, 
                         'kapasitas' =>$request->kapasitas, 
                         'catatan' =>$request->hasilakhir,
                         'taksiran_taksasi' =>$this->nilai($request->taksiran_taksasi),
                         'app' =>$request->approval, 
                  ]);
            
            $cek  = approvals::where('idpenjaminan', $request->idpenjaminan)->count();
//            dd($cek);
            if($cek<1){
                $this->create_approval($request);
            }else{
                 approvals::where('idpenjaminan', $request->idpenjaminan)
                ->update([
                     'hasilakhir' => $request->approval,
                     'tglanalisa' => date('Y-m-d'),
                     'oleh' => Auth::user()->name,
                 ]);
            } 
            
            if (Auth::user()->jabatan == 'Direktur') {
                     $analisa = $request->keputusanDireksi;
                     $penjaminan = penjaminans::where('idpenjaminan', $request->idpenjaminan)
                        ->update([
                            'tanggapandir' => $request->keputusanDireksi,
                         ]);
                } else   if (Auth::user()->jabatan == 'Kabag') {
                    $analisa = $request->rekomendasiKabag;
                } else {
                    $analisa = $request->hasilakhir;
                }
//        dd($request->rekomendasiKabag);
       
       
         if( $request->approval=='Tolak'){
                          date_default_timezone_set("Asia/Jakarta");
                          history_tolakans::create([
                            'idpenjaminan'=>$request->idpenjaminan,
                            'alasan'=>$analisa,
                            'tgl_tolak'=>date('Y-m-d H:i:s',strtotime('+1 hour')),
                            'user'=> Session::get('id_user'),
                        ]);
            }
            
         
//              $penjaminan = penjaminans::where('idpenjaminan', $request->idpenjaminan)
//                ->update([
//                    'app' => $request->approval,
//                    'tanggapandir' => $request->keputusanDireksi,
//                 ]);
            
           if ($request->approval == 'direksi') 
           { 
//                    Mail::send('emails.welcome', ['name' => 'Hendiawan Dipa'], function ($message) {
//                        $message->to('hendiawan.dipa@gmail.com')
//                                ->cc('it.dev@jamkridantb.com')
//                                ->subject('Pengajuan Case By Case');
//                    });
                } 
            
//                if($request->approval=='AnalisPenjaminan'){
//                        $this->CreateHistoryApp($request,$request->rekomendasiKabag);
//                }else  if($request->approval=='kabag'){
//                    if ( Session::get('level')=='Direksi'){
//                            $this->CreateHistoryApp($request,$request->keputusanDireksi);
//                    }else{
//                            $this->CreateHistoryApp($request,$request->hasilakhir);
//                    } 
//                }else  if($request->approval=='direksi'){
//                       $this->CreateHistoryApp($request,$request->rekomendasiKabag); 
//                }else  if($request->approval=='CaseSetuju'){
//                       $this->CreateHistoryApp($request,$request->keputusanDireksi);
//                       $penjaminan = penjaminans::where('idpenjaminan', $request->idpenjaminan)
//                        ->update([
//                            'tanggapandir' => $request->keputusanDireksi,
//                         ]);
//                }
                
              
                if ($request->caseket=='Ya'){ 
                      if ($request->catatanPembayaran) {
                             $analisa= $request->catatanPembayaran;
                      }  
                    $cek  = history_cases::where('idpenjaminan', $request->idpenjaminan)->count();
                        if($cek<1){
                             $this->CreateHistoryCase($request);
                        }else{
                             $this->Update_History_Case($request);
                        } 
                  }
                  
                $this->CreateHistoryApp($request,$analisa);                      
                $penjaminan = penjaminans::where('idpenjaminan', $request->idpenjaminan)
                 ->update([
                     'catatan' => $analisa,
                  ]); 
            
            
               session::flash('pesan', 'Data pengajuan sudah diverifikasi');
               return redirect('datapenjaminanview');
    } 
    public function postValidasiKonsumtif(request $request) 
    { 

//         $validation = Validator::make($request->all(),[
//                                'catatanPembayaran'    => 'required',
//                                'pembayaran' => 'required',
//                    ]);
//           echo "halo";
//             dd($this->nilai($request->pendaptanBersih));
        if ($request->caseket!='Ya'){
                 $this->validate($request, [
                 'hasilakhir'=>(Auth::user()->jabatan == 'Staf')?'required':'',
                 'rekomendasiKabag'=>(Auth::user()->jabatan == 'Kabag')?'required':'',
                'approval' => 'required', 
                ]);
        }else{
            $this->validate($request, [ 
                'approval' => 'required', 
                'hasilakhir'=>   (Auth::user()->jabatan == 'Staf')?'required':'',
                 'rekomendasiKabag'=>(Auth::user()->jabatan == 'Kabag')?'required':'',
                'catatanPembayaran'    => ($request->statusbayar==1)?'required':'',
                'sukuBunga'    => 'required',  
                'angsuran'    => 'required',  
                'pengecekanSlik'    =>'required',  
                'pendapatanPemohon'    => 'required',  
                'pendapatanLainnya'    => 'required',  
                'biayaRumahTangga'    => 'required',  
//                'biayaUsaha'    => 'required',  
                'angsuranKreditTempatLain'    => 'required',  
//                'nilaiPasar'    =>'required',  
//                'jenisAgunan'    =>'required',   
                'kapasitas'    =>'required',   
            ]);
        }
     

            $penjaminan = penjaminans::where('idpenjaminan', $request->idpenjaminan)
//                    ->where('app','Pengecekan')
                 ->update([
                         'suku_bunga' =>$request->sukuBunga,
                         'angsuran' => $this->nilai($request->angsuran),
                         'pengecekan_slik' => $request->pengecekanSlik ,
                         'pendapatan_utama' => $this->nilai($request->pendapatanPemohon),
                         'pendapatan_lainnya' => $this->nilai($request->pendapatanLainnya), 
                         'biaya_rumah_tangga' => $this->nilai($request->biayaRumahTangga),
                         'biaya_usaha' => $this->nilai($request->biayaUsaha),
                         'angsuran_lainnya' => $this->nilai($request->angsuranKreditTempatLain),
                         'pendapatan_bersih' => $this->nilai($request->pendapatanBersih),
                         'nilai_pasar' => $this->nilai($request->nilaiPasar), 
                         'jenis_agunan' => $request->jenisAgunan, 
                         'kapasitas' =>$request->kapasitas, 
                         'catatan' =>$request->hasilakhir,
                         'app' =>$request->approval, 
                  ]);
            
            $cek  = approvals::where('idpenjaminan', $request->idpenjaminan)->count();
//            dd($cek);
            if($cek<1){
                $this->create_approval($request);
            }else{
                 approvals::where('idpenjaminan', $request->idpenjaminan)
                ->update([
                     'hasilakhir' => $request->approval,
                     'tglanalisa' => date('Y-m-d'),
                     'oleh' => Auth::user()->name,
                 ]);
            } 
            
            if (Auth::user()->jabatan == 'Direktur') {
                     $analisa = $request->keputusanDireksi;
                     $penjaminan = penjaminans::where('idpenjaminan', $request->idpenjaminan)
                        ->update([
                            'tanggapandir' => $request->keputusanDireksi,
                         ]);
                } else   if (Auth::user()->jabatan == 'Kabag') {
                    $analisa = $request->rekomendasiKabag;
                } else {
                    $analisa = $request->hasilakhir;
                }
//        dd($request->rekomendasiKabag);
       
       
         if( $request->approval=='Tolak'){
                          date_default_timezone_set("Asia/Jakarta");
                          history_tolakans::create([
                            'idpenjaminan'=>$request->idpenjaminan,
                            'alasan'=>$analisa,
                            'tgl_tolak'=>date('Y-m-d H:i:s',strtotime('+1 hour')),
                            'user'=> Session::get('id_user'),
                        ]);
            }
            
         
//              $penjaminan = penjaminans::where('idpenjaminan', $request->idpenjaminan)
//                ->update([
//                    'app' => $request->approval,
//                    'tanggapandir' => $request->keputusanDireksi,
//                 ]);
            
           if ($request->approval == 'direksi') 
           { 
//                    Mail::send('emails.welcome', ['name' => 'Hendiawan Dipa'], function ($message) {
//                        $message->to('hendiawan.dipa@gmail.com')
//                                ->cc('it.dev@jamkridantb.com')
//                                ->subject('Pengajuan Case By Case');
//                    });
                } 
            
//                if($request->approval=='AnalisPenjaminan'){
//                        $this->CreateHistoryApp($request,$request->rekomendasiKabag);
//                }else  if($request->approval=='kabag'){
//                    if ( Session::get('level')=='Direksi'){
//                            $this->CreateHistoryApp($request,$request->keputusanDireksi);
//                    }else{
//                            $this->CreateHistoryApp($request,$request->hasilakhir);
//                    } 
//                }else  if($request->approval=='direksi'){
//                       $this->CreateHistoryApp($request,$request->rekomendasiKabag); 
//                }else  if($request->approval=='CaseSetuju'){
//                       $this->CreateHistoryApp($request,$request->keputusanDireksi);
//                       $penjaminan = penjaminans::where('idpenjaminan', $request->idpenjaminan)
//                        ->update([
//                            'tanggapandir' => $request->keputusanDireksi,
//                         ]);
//                }
                
              
               
                  if ($request->caseket=='Ya'){ 
                      if ($request->catatanPembayaran) {
                             $analisa= $request->catatanPembayaran;
                      }
                    $cek  = history_cases::where('idpenjaminan', $request->idpenjaminan)->count();
                        if($cek<1){
                             $this->CreateHistoryCase($request);
                        }else{
                             $this->Update_History_Case($request);
                        } 
                  }  
                    $this->CreateHistoryApp($request,$analisa); 
                      
                    $penjaminan = penjaminans::where('idpenjaminan', $request->idpenjaminan)
                        ->update([
                            'catatan' => $analisa,
                         ]);
         
            
               session::flash('pesan', 'Data pengajuan sudah diverifikasi');
               return redirect('datapenjaminanview');
    } 
    
    
    public function create_approval($request){
          $approval = approvals::create([
                            'idpenjaminan' => $request->idpenjaminan,
                            'cekjenispenjaminan' => 'Ok',
                            'cekpekerjaan' => 'Ok',
                            'cekperiode' => 'Ok',
                            'cekplafon' => 'Ok',
                            'cekijp' => 'Ok',
                            'cekpembayaran' => 'Ok',
                            'ceksuratsehat' => 'Ok',
                            'ceknama' => 'Ok',
                            'cekumur' => 'Ok',
                            'analisa' => 'Sesuai',
                            'cekjeniskredit' => 'Ok',
                            'cektgllahir' => 'Ok',
                            'ceknopk' => 'Ok',
                            'cekmasakredit' => 'Ok',
                            'cekpotongan' => 'Ok',
                            'cekktp' => 'Ok',
                            'hasilakhir' => $request->approval,
                            'tglanalisa' => date('Y-m-d'),
                            'oleh' => Auth::user()->name,
                ]);
    }
    
     protected function hitungLabaBersih(request $request) {
 
         $angsuran                              = $this->GabungNilai($request->angsuran);
         $omset                                     = $this->GabungNilai($request->omset);
         $hpp                                          = $this->GabungNilai($request->hpp);
         $biayaRumahTangga         = $this->GabungNilai($request->biayaRumahTangga);
         $biayaUsaha                          = $this->GabungNilai($request->biayaUsaha);
         $angsuranKreditTempatLain   = $this->GabungNilai($request->angsuranKreditTempatLain);
         
           
         $labaRugi = $omset-($hpp+$biayaRumahTangga+$biayaUsaha+$angsuranKreditTempatLain+$angsuran);
         if(0<$labaRugi){$kapasitas="memenuhi";}else{$kapasitas="tidak";};
         
         $data=[
             'labarugi'=>number_format($labaRugi,0,'.',','),
             'kapasitas_bayar'=>$kapasitas,
         ];
        return  json_encode($data);
 
    }

     protected function hitungPendapatanBersih(request $request) {
 
         $angsuran                              = $this->GabungNilai($request->angsuran);
         $pendapatan                          = $this->GabungNilai($request->pendapatan);
         $pendapatanLainnya         = $this->GabungNilai($request->pendapatanLainnya);
         $biayaRumahTangga         = $this->GabungNilai($request->biayaRumahTangga); 
         $angsuranKreditTempatLain   = $this->GabungNilai($request->angsuranKreditTempatLain); 
         $pendapatanBersih = ($pendapatan+$pendapatanLainnya)-($biayaRumahTangga+$angsuranKreditTempatLain+$angsuran);
      
         if(0<$pendapatanBersih){$kapasitas="memenuhi";}else{$kapasitas="tidak";};         
         $data=[
             'pendapatanBersih'=>number_format($pendapatanBersih,0,'.',','),
             'kapasitas_bayar'=>$kapasitas,
         ];
        return  json_encode($data);
 
    }


    
        protected function GabungNilai($nilai) {

        $pecah = explode(",", $nilai);
        return implode("", $pecah);
    }
}
