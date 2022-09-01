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
ini_set('memory_limit', '512M');
/**
 * Description of BlogController
 *
 * @author ASUS
 */
class ExportController extends Controller {
  
    public function __construct() {
        $this->middleware('auth');
//        $this->middleware('auth.api');
//         $this->middleware('guest:api') ;
    }
    
    public function tanggal($tgl) {
        $data = explode("/", $tgl);
        $isi = "$data[2]-$data[1]-$data[0]";
        return $tgl = date('Y-m-d', strtotime($isi));
    }
    
    
     public function FilterExport(request $request) 
     {
        
         $dari=$this->tanggal($request->dari);
         $sampai=date ('Y-m-d 23:59:59.000',strtotime($this->tanggal($request->sampai)));
         
//        dd($sampai);
        $pengajuan = penjaminans::
                
                whereBetween('tglterbit', array($dari,$sampai))
                ->whereNotIn('sertifikats.sinkronisasi',['Y'])
//                ->where('sertifikats.sinkronisasi','')
                ->wherein('penjaminans.app',['Lunas','Cetak'])  
                
//                ->where('penjaminans.idbank,'.'like'."%$request->bank%")
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank') 
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan') 
                ->orderBy('banks.kodepusat') 
                ->groupBy('penjaminans.idbank')     
                ->select('penjaminans.idbank', 'banks.namabank', \DB::raw('count(*) as total'))
//                ->orderBy('sertifikats.id', 'desc')
                
                ->take(1000)
                ->get();
        
        return view('admin.singkronisasiperbank', [
            'pengajuan'     => $pengajuan,
            'dari'          => $dari,
            'sampai'        => $sampai,
            
        ]);
     }
     
     
     public function DataSinkronisasiDetailPertgl($id,$daritgl,$sampaitgl2) 
     {
             $sampaitgl2 = date ('Y-m-d 23:59:59.000',strtotime($sampaitgl2));
//        dd($sampaitgl2);
        $pengajuan = penjaminans::
                whereBetween('tglterbit', array($daritgl,$sampaitgl2))
                ->whereNotIn('sertifikats.sinkronisasi',['Y']) 
                ->Where('penjaminans.idbank',$id)
                ->wherein('penjaminans.app',['Lunas','Cetak']) 
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
//                ->orderBy('sertifikats.id', 'desc')
                ->take(1000)
                ->get(); 
        return view('admin.singkronisasiperbankdetail', [
                'pengajuan' => $pengajuan,
            ]);
     
        
     }
     public function DataSinkronisasi() 
     {
         
        $dari=date('Y-m-1');
        $sampai=date('Y-m-t');
       
        $pengajuan = penjaminans::
                  whereBetween('tglterbit', array($dari,$sampai))
                ->where('penjaminans.export',null)
//                whereNotIn('penjaminans.export',['Y'])
                ->wherein('penjaminans.app',['Lunas','Cetak']) 
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->select('penjaminans.idbank', 'banks.namabank', \DB::raw('count(*) as total'))
                ->orderBy('sertifikats.id', 'desc')
                ->groupBy('penjaminans.idbank')
                ->take(1000)
                ->get();
        
        return view('admin.singkronisasiperbank', [
            'pengajuan'     => $pengajuan,
            
        ]);
     }
     
     public function DataSinkronisasiDetail($id) 
     {
        $pengajuan = penjaminans::
                 where('penjaminans.export',null)
//                whereNotIn('penjaminans.export',['Y'])
                ->Where('penjaminans.idbank',$id)
                ->wherein('penjaminans.app',['Lunas','Cetak']) 
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->orderBy('sertifikats.id', 'desc')
                ->take(1000)
                ->get();
        
        return view('admin.singkronisasiperbankdetail', [
            'pengajuan'     => $pengajuan,
            
        ]);
     }
     
     public function SaveExport(request $request) 
     {
       
//        dd($request->export);
        foreach ($request->export as $key => $value) {

//        dd($request);
            $pengajuan = penjaminans:: select('*','penjaminans.dis')
                    ->where('penjaminans.idpenjaminan',$key)
                    ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                    ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                    ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                    ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                    ->leftJoin('users', 'users.name', '=', 'sertifikats.diterbitkan')
                    ->first();
//            dd($pengajuan);
            //PENGECEKAN INPUTAN DATA

            $m_penjaminan = db::CONNECTION('sqlsrv')->table('t_penjaminan')
                    ->rightJoin('m_terjamin', 'm_terjamin.kd_terjamin', '=', 't_penjaminan.kd_terjamin')
                    ->rightJoin('m_penerima_jaminan', 'm_penerima_jaminan.kd_penerima', '=', 't_penjaminan.kd_penerima')
                    ->select(
                            'm_penerima_jaminan.nama as nama_bank', 'm_terjamin.nama as nama_terjamin', 'm_terjamin.tanggal_daftar as tgl_daftar_terjamin', '*')
                    ->where('m_penerima_jaminan.kd_penerima', $pengajuan->kd_penerima) //kodebank pada simpk
                    ->where('m_terjamin.nama', $pengajuan->nama)
                    ->where('t_penjaminan.nilai',$pengajuan->plafon)
                    ->where('t_penjaminan.no_perjanjian',$pengajuan->nopk)
                    ->where('t_penjaminan.mulai',date('Y-m-d', strtotime($pengajuan->tglrealisasi)))
                    ->where('t_penjaminan.akhir',date('Y-m-d', strtotime($pengajuan->tgljatuhtempo)))
//                    ->where(DB::raw('YEAR(m_terjamin.tanggal_daftar)'), date('Y', strtotime($pengajuan->tglpengajuan)))
//                    ->where(DB::raw('MONTH(m_terjamin.tanggal_daftar)'), date('m', strtotime($pengajuan->tglpengajuan)))
//                    ->where(DB::raw('DAY(m_terjamin.tanggal_daftar)'), date('d', strtotime($pengajuan->tglpengajuan)))
                    ->count();
            
//            echo " mulai ".date('Y-m-d', strtotime($pengajuan->tglrealisasi)).'<br>';
//            echo " akhir ".date('Y-m-d', strtotime($pengajuan->tgljatuhtempo)).'<br>';
//            echo " plafon ".$pengajuan->plafon.'<br>';
//            echo " pk ".$pengajuan->nopk.'<br>';
//            dd($m_penjaminan); 
            if ($m_penjaminan > 0) {
                   session::flash('pesan', 'Data Penjaminan sudah ada di Sistem !!!'); 
            } 
            else 
            {
//                  dd($m_terjamin_last);
                //cek nama dan tanggal lahir terjamin
                $cek_jumlah_terjamin = db::CONNECTION('sqlsrv')
                       ->table('m_terjamin')
                       ->select('nama','kd_terjamin')
                       ->where('nama',$pengajuan->nama) 
                       ->where('lahir',date('Y-m-d', strtotime($pengajuan->tgllahir)))
                       ->count(); 
             
                if($cek_jumlah_terjamin<1)
                { 
                      $m_terjamin_last = db::CONNECTION('sqlsrv')
                                        ->table('m_terjamin')
                                        ->orderBy('kd_terjamin', 'desc')
                                        ->take(1)
                                        ->first();  
                       $kode_terjamin = ++$m_terjamin_last->kd_terjamin; 
                }else{ 
                        $data_m_terjamin = db::CONNECTION('sqlsrv')
                       ->table('m_terjamin')
                       ->select('nama','kd_terjamin','lahir','alamat')
                       ->where('nama',$pengajuan->nama)
//                       ->where('kd_terjamin',$pengajuan->ktp) 
                       ->where('lahir',date('Y-m-d', strtotime($pengajuan->tgllahir))) 
                       ->first(); 
                         $kode_terjamin = $data_m_terjamin->kd_terjamin;
                }
//                         dd($kode_terjamin);
                 if($cek_jumlah_terjamin<1){
                     
//                     $kode_terjamin = ++$m_terjamin->kd_terjamin;
                  
//                input data terjamin ke sql server Lokal
                    $terjamin = new m_terjamin;
                    $terjamin->kd_terjamin = $kode_terjamin;
                    $terjamin->kd_kota          = 'KAA002';
                    $terjamin->nama               = $pengajuan->nama;
                    $terjamin->kontak            = $pengajuan->telp;
                    $terjamin->npwp               = $pengajuan->npwp;
                    $terjamin->alamat            = $pengajuan->alamat;
                    $terjamin->telepon           = '-';
                    $terjamin->fax                     = '-';
                    $terjamin->email               = '-';
                    $terjamin->lahir                 = date('Y-m-d', strtotime($pengajuan->tgllahir));
                    $terjamin->perusahaan   = '-';
                    $terjamin->jenis_usaha    = $pengajuan->pekerjaan;
                    $terjamin->nomor              = '-';
                    $terjamin->direktur          = '-';
                    $terjamin->status               = '2'; //status terjamin (1=Surety Bond;2=Penjaminan Kredit)
                    $terjamin->keterangan   = '-';
                    //tanggal daftar yang terbaca di ambil dari tanggal pengajuan di sistem
                    $terjamin->tanggal_daftar = date('Y-m-d', strtotime($pengajuan->tglterbit));
                    $terjamin->referensi            = 'TAH996';
                    $terjamin->save();
                    
                }
                else
                { 
//                    $kode_terjamin = $data_m_terjamin->kd_terjamin; 
                    db::CONNECTION('sqlsrv')
                         ->table('m_terjamin')
                         ->where('kd_terjamin',$kode_terjamin)
                         ->update([
                                //update data kontraktor(Terjamin) ke Sql Server Lokal 
                                'alamat'             => $pengajuan->alamat,
                                'kontak'             => $pengajuan->telp, 
                                'jenis_usaha'    => $pengajuan->pekerjaan,   
                      ]);
                 }
//                dd($kode_terjamin);

                //input data Penjaminan ke sql server Lokal
                 
                //mencari nomor transaksi berdasarkan tanggal hari ini
                $m_penjaminan = db::CONNECTION('sqlsrv')->table('t_penjaminan')
                        ->where('t_penjaminan.no_transaksi', 'like', '%'.'KU'.date('ymd').'%')
                        ->orderBy('t_penjaminan.no_transaksi', 'desc')
                        ->take(1)
                        ->first();
                
                if($m_penjaminan){
                     $sub_kalimat = substr($m_penjaminan->no_transaksi, 8);
                }else{
                     $sub_kalimat =0;
                }
                
               
                $no_transaksi   = 'KU' . date('ymd') . str_pad($sub_kalimat, 4, '0', STR_PAD_LEFT);
                $notransaksi     = ++$no_transaksi;
//              dd($no_transaksi);
                
                if ($pengajuan->jeniskredit == 'PRODUKTIF') {
                    $kode_produk = 'BPR-PRO';
                } else {
                    $kode_produk = 'KONSUMTIF';
                }

                $DATA_T_PENJAMINAN_INSERT = db::CONNECTION('sqlsrv')->table('t_penjaminan')->insert(
                        [
                            'no_transaksi'              => $notransaksi,
                            'kd_divisi'                     => 'DAA001',
                            'kd_penerima'             => $pengajuan->kd_penerima,
                            'kd_terjamin'               => $kode_terjamin,
                            'kd_produk'                 => $kode_produk,
                            'no_sertifikat'             => $pengajuan->kodesertifikat,
                            'tanggal_sertifikat'    => '2001-01-01',
                            //tanggal verifikasi  di sistem yaitu tanggal terbitsertifikat
                            'tanggal'                        => date('Y-m-d', strtotime($pengajuan->tglterbit)),
                            'mulai'                           => date('Y-m-d', strtotime($pengajuan->tglrealisasi)),
                            'akhir'                            => date('Y-m-d', strtotime($pengajuan->tgljatuhtempo)),
                            'tarif_ijp'                       => $pengajuan->rate,
                            'total_ijp_kotor'          => $pengajuan->premi,
                            'total_ijp_bersih'        => $pengajuan->nett,
                            'nilai'                             => $pengajuan->plafon,
                            'nilai_penjaminan'    => $pengajuan->share,
                            'diskon'                        => $pengajuan->dis,
                            'biaya1'                        => 0,
                            'biaya2'                        => 0,
                            'biaya3'                        => 0,
                            'keterangan'               => '-',
//                            'kd_user'                      => Session::get('kd_user'),
                            'kd_user'                      => $pengajuan->kodeuser,
                            'jenis'                            => '2',
                            'no_permintaan_penjamin' => '-',
                            'tanggal_permintaan_penjamin' => date('Y-m-d', strtotime($pengajuan->tglterbit)),
                            'no_perjanjian'          => $pengajuan->nopk,
                            'tanggal_perjanjian' => date('Y-m-d', strtotime($pengajuan->tglpk)),
                            'jenis_kredit' => '-',
                        ]
                );

                //INSERT DATA KE TABEL VERIFIKASI PENJAMINAN
                
//                $data_t_penjaminan = db::CONNECTION('sqlsrv')->table('t_penjaminan')
//                        ->where('kd_terjamin', $kode_terjamin)
//                        ->first();

                $DATA_INSERT_VERIFIKASI = db::CONNECTION('sqlsrv')->table('t_penjaminan_verifikasi')->insert(
                        [
//                            'no_transaksi' => $data_t_penjaminan->no_transaksi,
                            'no_transaksi'      => $notransaksi,
                            //tanggal verifikasi keuangan di sistem yaitu tanggal sinkronisasi
                            'tanggal'               => date('Y-m-d', strtotime($pengajuan->tglterbit)),
                            'kd_user'               => $pengajuan->kodeuser,
                            'keterangan'        => '-',
                            'tanggal_server' => date('Y-m-d', strtotime($pengajuan->tglterbit)),
                            'status'                  => '1'
                        ]
                );

                //INSERT DATA KE TABEL VERIFIKASI KEUANGAN


                $kd_kas = $pengajuan->kodekas;
                
//                $DATA_INSERT_PENJAMINAN_KEUANGAN = db::CONNECTION('sqlsrv')->table('t_penjaminan_keuangan')->insert(
//                        [
////                        'no_transaksi' => $data_t_penjaminan->no_transaksi,
//                            'no_transaksi'      =>$notransaksi,
//                            'tanggal'                 =>date('Y-m-d', strtotime($pengajuan->tglterbit)),
//                            'kd_jenis'               => 'JAA001',
//                            'kd_kas'                  => $kd_kas,
//                            'no_bukti'              => '-',
//                            'keterangan'         => '-',
//                            'kd_user'                => $pengajuan->kodeuser,
//                            'tanggal_server'  =>date('Y-m-d', strtotime($pengajuan->tglterbit))
//                        ]
//                ); 
//                
                
                date_default_timezone_set("Asia/Jakarta");
                date('Y-m-d H:i:s',strtotime('+1 hour'));  
                $updatepenjaminanexport = sertifikats::where('sertifikats.idpenjaminan', $key)
                        ->update([
                            'sinkronisasi' => 'Y',
                            'tgl_sink' =>    date('Y-m-d H:i:s',strtotime('+1 hour')),
                ]);

             session::flash('pesan', 'Data pengajuan berhasil di export');
            } 
        } 
        return back(); 
     }
     
     public function sinkronisasi() 
     {
        $pengajuan = penjaminans::
                 wherein('penjaminans.app',['Lunas','Cetak']) 
//                ->where(DB::raw('MONTH(sertifikats.tglterbit)'), date('m'))
                ->whereNotIn('penjaminans.export',['Y']) 
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->orderBy('sertifikats.id', 'desc')
                ->take(1000)
                ->get();
        
//        $m_penjaminan = db::CONNECTION('sqlsrv')->table('t_penjaminan')->where(DB::raw('YEAR(tanggal)'), date('Y'))
//                ->where(DB::raw('MONTH(tanggal)'), date('m'))
//                ->where(DB::raw('DAY(tanggal)'), date('d'))
//                ->count();
//                
//                //UNTUK MENGECEK NO TRANSAKSI TERAKHIR DALAM SATU HARI
//        $m_penjaminan = db::CONNECTION('sqlsrv')->table('t_penjaminan')
//                ->where('t_penjaminan.no_transaksi', 'like', '%'.'KU'.date('ymd').'%')
//                ->orderBy('t_penjaminan.no_transaksi', 'desc')
//                ->take(1)
//                ->first();
//        $sub_kalimat = substr($m_penjaminan->no_transaksi,8);
//        
//        $no_transaksi = 'KU' . date('ymd') . str_pad($sub_kalimat, 4, '0', STR_PAD_LEFT);
       
//        dd($no_transaksi);
       
        $m_penjaminan = db::CONNECTION('sqlsrv')->table('t_penjaminan')
                ->rightJoin('m_terjamin', 'm_terjamin.kd_terjamin', '=', 't_penjaminan.kd_terjamin')
                ->rightJoin('m_penerima_jaminan', 'm_penerima_jaminan.kd_penerima', '=', 't_penjaminan.kd_penerima')
                ->rightJoin('t_penjaminan_verifikasi', 't_penjaminan_verifikasi.no_transaksi', '=', 't_penjaminan.no_transaksi')
                ->rightJoin('t_penjaminan_keuangan', 't_penjaminan_keuangan.no_transaksi', '=', 't_penjaminan.no_transaksi')
                ->select(
                        'm_penerima_jaminan.nama as nama_bank', 
                        'm_terjamin.nama as nama_terjamin', 
                        'm_terjamin.tanggal_daftar as tanggal_daftar_terjamin',
                        't_penjaminan_verifikasi.tanggal as tanggal_verifikasi_kasi', 
                        't_penjaminan_keuangan.tanggal_server as tanggal_verifikasi_keuangan',
                        '*')
//                ->where(DB::raw('YEAR(t_penjaminan.tanggal)'), date('Y'))
//                ->where(DB::raw('MONTH(t_penjaminan.tanggal)'), date('m'))
                ->where(DB::raw('YEAR(t_penjaminan.tanggal)'), date('Y'))
                ->where(DB::raw('MONTH(t_penjaminan.tanggal)'),date('m'))
                ->orderBy('t_penjaminan.no_transaksi','desc')
                ->get();
//        dd($m_penjaminan);
        
        $m_kas = db::CONNECTION('sqlsrv')->table('m_kas')->where('status','3')->get();
        
        
        $LabaRugi = db::CONNECTION('sqlsrv')
                ->table("mon_GetOJKLabaRugiHarian('2019/01/01','2019/12/31')")
//                ->take(200)
                ->get();
       
        return view('admin.singkronisasi', [
            'pengajuan'     => $pengajuan,
            'data_lokal'    => $m_penjaminan,
            'kas'           => $m_kas,
            'LabaRugi'      => $LabaRugi,
        ]);
    }
    
     public function sinkronisasi_cek_data(Request $request) 
     {
//        dd($request);
        $pengajuan = penjaminans::where('app', 'Cetak')
                ->where('sertifikats.kodesertifikat', $request->nosertifikat)
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->first();

        //PENGECEKAN INPUTAN DATA

        $m_penjaminan = db::CONNECTION('sqlsrv')->table('t_penjaminan')
                ->rightJoin('m_terjamin', 'm_terjamin.kd_terjamin', '=', 't_penjaminan.kd_terjamin')
                ->rightJoin('m_penerima_jaminan', 'm_penerima_jaminan.kd_penerima', '=', 't_penjaminan.kd_penerima')
                ->select(
                        'm_penerima_jaminan.nama as nama_bank', 'm_terjamin.nama as nama_terjamin', 'm_terjamin.tanggal_daftar as tgl_daftar_terjamin', '*')
                ->where('m_penerima_jaminan.kd_penerima', $pengajuan->kd_penerima)
                ->where('m_terjamin.nama', $pengajuan->nama)
                ->where(DB::raw('YEAR(m_terjamin.tanggal_daftar)'), date('Y', strtotime($pengajuan->tglpengajuan)))
                ->where(DB::raw('MONTH(m_terjamin.tanggal_daftar)'), date('m', strtotime($pengajuan->tglpengajuan)))
                ->where(DB::raw('DAY(m_terjamin.tanggal_daftar)'), date('d', strtotime($pengajuan->tglpengajuan)))
                ->count();

        if ($m_penjaminan > 0) {

            $success_output = $m_penjaminan;
            $output = array(
                'success' => 'Data yang di pilih sudah ada di sistem...',
            );
        } else {
            //mengambil kode terakhir terjamin yang di input

            $m_terjamin = m_terjamin::where(DB::raw('YEAR(tanggal_daftar)'), date('Y'))
//                ->where(DB::raw('MONTH(tanggal_daftar)'), 03)
                    ->orderBy('kd_terjamin', 'desc')
                    ->take(1)
                    ->first();

            $kode_terjamin = ++$m_terjamin->kd_terjamin;

            //input data terjamin ke sql server Lokal
            $terjamin = new m_terjamin;
            $terjamin->kd_terjamin = $kode_terjamin;
            $terjamin->kd_kota = 'KAA002';
            $terjamin->nama = $pengajuan->nama;
            $terjamin->kontak = $pengajuan->telp;
            $terjamin->npwp = $pengajuan->npwp;
            $terjamin->alamat = $pengajuan->alamat;
            $terjamin->telepon = '-';
            $terjamin->fax = '-';
            $terjamin->email = '-';
            $terjamin->lahir = date('Y-m-d', strtotime($pengajuan->tgllahir));
            $terjamin->perusahaan = '-';
            $terjamin->jenis_usaha = $pengajuan->pekerjaan;
            $terjamin->nomor = '-';
            $terjamin->direktur = '-';
            $terjamin->status = '2';
            $terjamin->keterangan = '-';
            //tanggal daftar yang terbaca di ambil dari tanggal pengajuan di sistem
            $terjamin->tanggal_daftar = $this->tanggal($request->tgl_verifikasi_kasi);
            $terjamin->referensi = 'TAH996';
            $terjamin->save();

            //input data Penjaminan ke sql server Lokal

            $m_penjaminan = db::CONNECTION('sqlsrv')->table('t_penjaminan')
                ->orderBy('t_penjaminan.no_transaksi', 'desc')
                ->take(1)
                ->first();
            $sub_kalimat = substr($m_penjaminan->no_transaksi,8);
        
            $no_transaksi = 'KU' . date('ymd') . str_pad($sub_kalimat, 4, '0', STR_PAD_LEFT);
//            $no = ++$no_transaksi;
       
            if ($pengajuan->jeniskredit == 'PRODUKTIF') {
                $kode_produk = 'BPR-PRO';
            } else {
                $kode_produk = 'KONSUMTIF';
            }

            $DATA_T_PENJAMINAN_INSERT = db::CONNECTION('sqlsrv')->table('t_penjaminan')->insert(
                    [
                        'no_transaksi' => ++$no_transaksi,
                        'kd_divisi' => 'DAA001',
                        'kd_penerima' => $pengajuan->kd_penerima,
                        'kd_terjamin' => $kode_terjamin,
                        'kd_produk' => $kode_produk,
                        'no_sertifikat' => $pengajuan->kodesertifikat,
                        'tanggal_sertifikat' => '2001-01-01',
                        //tanggal verifikasi  di sistem yaitu tanggal sinkronisasi
                        'tanggal' => $this->tanggal($request->tgl_verifikasi_kasi),
                        'mulai' => date('Y-m-d', strtotime($pengajuan->tglrealisasi)),
                        'akhir' => date('Y-m-d', strtotime($pengajuan->tgljatuhtempo)),
                        'tarif_ijp' => $pengajuan->rate,
                        'total_ijp_kotor' => $pengajuan->premi,
                        'total_ijp_bersih' => $pengajuan->nett,
                        'nilai' => $pengajuan->plafon,
                        'nilai_penjaminan' => $pengajuan->share,
                        'diskon' => $pengajuan->dis,
                        'biaya1' => 0,
                        'biaya2' => 0,
                        'biaya3' => 0,
                        'keterangan' => '-',
                        'kd_user' => Session::get('kd_user'),
                        'jenis' => '2',
                        'no_permintaan_penjamin' => '-',
                        'tanggal_permintaan_penjamin' => $this->tanggal($request->tgl_verifikasi_kasi),
                        'no_perjanjian' => $pengajuan->nopk,
                        'tanggal_perjanjian' => date('Y-m-d', strtotime($pengajuan->tglpk)),
                        'jenis_kredit' => '-',
                    ]
            );

            //INSERT DATA KE TABEL VERIFIKASI PENJAMINAN
            $data_t_penjaminan = db::CONNECTION('sqlsrv')->table('t_penjaminan')
                    ->where('kd_terjamin', $kode_terjamin)
                    ->first();

            $DATA_INSERT_VERIFIKASI = db::CONNECTION('sqlsrv')->table('t_penjaminan_verifikasi')->insert(
                    [
                        'no_transaksi' =>$data_t_penjaminan->no_transaksi,
                        //tanggal verifikasi keuangan di sistem yaitu tanggal sinkronisasi
                        'tanggal' => $this->tanggal($request->tgl_verifikasi_kasi),
                        'kd_user' => Session::get('kd_user'),
                        'keterangan' => '-',
                        'tanggal_server'=> $this->tanggal($request->tgl_verifikasi_kasi),
                        'status' => '1'
                    ]
            );

            //INSERT DATA KE TABEL VERIFIKASI KEUANGAN

            
            if($request->kd_kas==null){
                $kd_kas=$pengajuan->kodekas;
            }else{
                $kd_kas=$request->kd_kas;
            }
            $DATA_INSERT_PENJAMINAN_KEUANGAN = db::CONNECTION('sqlsrv')->table('t_penjaminan_keuangan')->insert(
                    [
                        'no_transaksi' => $data_t_penjaminan->no_transaksi,
                        'tanggal' => $this->tanggal($request->tgl_verifikasi_keu),
                        'kd_jenis' => 'JAA001',
                        'kd_kas' =>$kd_kas,
                        'no_bukti' => '-',
                        'keterangan' => '-',
                        'kd_user' => Session::get('kd_user'),
                        'tanggal_server' => $this->tanggal($request->tgl_verifikasi_keu)
                    ]
            );

            $rate = penjaminans::leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                    ->where('sertifikats.kodesertifikat', $request->nosertifikat)
                    ->update([
                'export' => 'Y',
            ]);

            $success_output = 'Data Berhasil Di Sinkronisasi...';
            $output = array(
                'success' => $success_output,
            );
        }

        echo json_encode($output);
    }

      public function hapus_data_penjaminan(Request $request) {
        $m_penjaminan = db::CONNECTION('sqlsrv')->table('t_penjaminan')
                ->rightJoin('m_terjamin', 'm_terjamin.kd_terjamin', '=', 't_penjaminan.kd_terjamin')
                ->rightJoin('m_penerima_jaminan', 'm_penerima_jaminan.kd_penerima', '=', 't_penjaminan.kd_penerima')
                ->select(
                        'm_penerima_jaminan.nama as nama_bank', 'm_terjamin.nama as nama_terjamin', '*')
                ->where('t_penjaminan.no_transaksi', $request->no_transaksi)
                ->first();



        //HAPUS DATA VERIFIKASI PENJAMINAN PADA TABEL t_penjaminan_verifikasi

        $delete_t_penjaminan_verifikasi = db::CONNECTION('sqlsrv')->table('t_penjaminan_verifikasi')
                        ->where('no_transaksi', $request->no_transaksi)->delete();

        //HAPUS DATA VERIFIKASI KEUANGAN PADA TABEL t_penjaminan_keuangan

        $delete_t_penjaminan_keuangan = db::CONNECTION('sqlsrv')->table('t_penjaminan_keuangan')
                ->where('t_penjaminan_keuangan.no_transaksi', $request->no_transaksi)
                ->delete();

        //HAPUS DATA TRANSAKSI PENJAMINAN PADA TABEL t_penjaminan

        $delete_t_penjaminan = db::CONNECTION('sqlsrv')->table('t_penjaminan')
                ->where('t_penjaminan.no_transaksi', $request->no_transaksi)
                ->delete();

        //HAPUS DATA  MASTER TERJAMIN PADA TABEL m_terjamin

        $delete_m_terjamin = db::CONNECTION('sqlsrv')->table('m_terjamin')
                ->where('m_terjamin.kd_terjamin', $request->kd_terjamin)
                ->delete();

        if (
                $delete_t_penjaminan_verifikasi and
                $delete_t_penjaminan_keuangan and
                $delete_t_penjaminan and
                $delete_m_terjamin
        ) {
            $output = [
                'success' => 'Data Berhasil Di Hapus',
            ];
        } else {
            $output = [
                'success' => 'Data Gagal Di Hapus',
            ];
        }


        echo json_encode($output);
    }
   
    
      public function eksport_data_penjaminan_view(Request $request) {
        
      
        $penjaminan= penjaminans::where('sertifikats.kodesertifikat', $request->nosertifikat)
                 ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                 ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                 ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                 ->first();        
        
         $output = [
            'statusbayar'       => $penjaminan->statusbayar,
            'namabank'          => $penjaminan->namabank, 
            'kodesertifikat'    => $penjaminan->kodesertifikat,
            'ktp'               => $penjaminan->ktp,
            'tempatlahir'       => $penjaminan->tempatlahir,
            'namaterjamin'      => $penjaminan->nama,
            'tglpengajuan'      => date('d/m/Y',strtotime($penjaminan->tglpengajuan)),
            'idpenjaminan'      => $penjaminan->idpenjaminan,
            'idbank'            => $penjaminan->idbank,
            'nosertifikat'      => $penjaminan->nosertifikat,
            'ktp'               => $penjaminan->ktp,
            'nama'              => $penjaminan->nama,
            'tempatlahir'       => $penjaminan->tempatlahir,
            'tglterbit'          => date('d/m/Y', strtotime($penjaminan->tglterbit)),
            'tgllahir'          => date('d/m/Y', strtotime($penjaminan->tgllahir)),
            'umur'              => $penjaminan->umur,
            'pekerjaan'         => $penjaminan->pekerjaan,
            'jeniskredit'       => $penjaminan->jeniskredit,
            'tglrealisasi'      => date('d/m/Y', strtotime($penjaminan->tglrealisasi)),
            'tgljatuhtempo'     => date('d/m/Y', strtotime($penjaminan->tgljatuhtempo)),
            'umurjatuhtempo'    => $penjaminan->umurjatuhtempo,
            'nopk'              => $penjaminan->nopk,
            'tglpk'             => date('d/m/Y', strtotime($penjaminan->tglpk)),
            'jenispenjaminan'   => $penjaminan->jenispenjaminan,
            
         ];
         
         echo json_encode($output); 
       
    }
    
     public function dataSertifikatTerbit($id,$daritgl,$sampaitgl2) 
     {
             $sampaitgl2 = date ('Y-m-d 23:59:59.000',strtotime($sampaitgl2));
//        dd($sampaitgl2);
            $pengajuan = penjaminans::
                whereBetween('tglterbit', array($daritgl,$sampaitgl2))
                ->whereNotIn('sertifikats.sinkronisasi',['Y']) 
                ->Where('penjaminans.idbank',$id)
                ->wherein('penjaminans.app',['Lunas','Cetak']) 
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
//                ->orderBy('sertifikats.id', 'desc')
                ->take(1000)
                ->get(); 
         echo json_encode($pengajuan);
     }
     
     
      public function FilterExportWeb(request $request) 
     {
        
         $dari       = $this->tanggal($request->dari);
         $sampai = date ('Y-m-d 23:59:59.000',strtotime($this->tanggal($request->sampai)));
         
         $client = new \GuzzleHttp\Client(); 
        //mengakses dari endpoint web penjaminan
        $response = $client->get( "https://penjaminan.jamkridantb.com/get-sertifikat-group/$dari/$sampai",[
                        'headers' => [ 
                          'Authorization' => "Bearer allahuakbar" 
                      ]
        ]);
        $request = $response->getBody();
        //proses konversi data penjaminan Json Ke Array
        $ArrayPengajuan = json_decode($request, true);
        //proses konversi Array ke Object
        $ObejctPengajuan = (object) $ArrayPengajuan; 
        $pengajuan              = $ObejctPengajuan; 
//        dd($pengajuan);
        return view('admin.singkronisasiperbankweb', [
            'pengajuan'     => $pengajuan,
            'dari'          => $dari,
            'sampai'        => $sampai,
            
        ]);
     }
     
public function signSbFromCloud($sppsb_id,$nik,$passphrase){
 
        $url      = "https://sign.jamkridantb.com/proses-sign-sb"; 
        $headers  = [
                "Accept: application/json",
                "Authorization: Bearer allahuakbar",
        ];
         $data  =[
                "sppsb_id"=>$sppsb_id,
                "nik"=>$nik,
                "passphrase"=>$passphrase,
         ];
            
        $curl           = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //for debug only!
//        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
//        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
        $resp = curl_exec($curl);
        curl_close($curl); 
        // konversi json ke array
        $ArraySign     = json_decode($resp, true); 
        // konversi array ke object
        $ObjectSign = (object) $ArraySign; 
        
        //    echo $resp;
       // print_r($ObejctSertifikat->nama);
         print_r($ObjectSign);
       
    }
    
    
    


     public function DataSinkronisasiWeb() 
     {
        $dari=date('Y-m-1');
        $sampai=date('Y-m-t');
        
//         $url = "https://penjaminan.jamkridantb.com/get-sertifikat-group/$dari/$sampai";
//
//        $curl = curl_init($url);
//        curl_setopt($curl, CURLOPT_URL, $url);
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//
//        $headers = array(
//           "Accept: application/json",
//           "Authorization: Bearer bismillah",
//        );
//        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//        //for debug only!
//        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
//        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//
//        $resp = curl_exec($curl);
//        curl_close($curl);
//        var_dump($resp);
         
      
         
         $client = new \GuzzleHttp\Client(); 
        //mengakses dari endpoint web penjaminan
        $response = $client->get( "https://penjaminan.jamkridantb.com/get-sertifikat-group/$dari/$sampai",[
                        'headers' => [ 
                          'Authorization' => "Bearer allahuakbar" 
               ]
        ]);
        $request = $response->getBody();
   
        //proses konversi data penjaminan Json Ke Array
        $ArrayPengajuan = json_decode($request, true);
        //proses konversi Array ke Object
        $ObejctPengajuan = (object) $ArrayPengajuan; 
        $pengajuan              = $ObejctPengajuan; 
      
        
        return view('admin.singkronisasiperbankweb', [
            'pengajuan'     => $pengajuan,
            
        ]);
     }
     
    public function DataSinkronisasiFilterPerbank($idbank,$tgl1,$tgl2) 
    {
        $client = new \GuzzleHttp\Client(); 

        $response = $client->get( "https://penjaminan.jamkridantb.com/get-sertifikat/$idbank/$tgl1/$tgl2",[
                        'headers' => [ 
                          'Authorization' => "Bearer allahuakbar" 
               ]
        ]);
//        dd($response);
//        dd($response);
//        echo $response->getStatusCode(); // 200
//        echo $response->getHeaderLine('content-type'); // 'application/json; charset=utf8'
//        $request = $response->getBody()->getContents();
        $request = $response->getBody();
//        dd($request);
        $dataweb = json_decode($request, true);
//        return view('admin.singkronisasiperbankdetail', [
        return view('admin.singkronisasiweb', compact('dataweb'));
    }
     
    public function SaveExportWeb(request $request) 
    {
//            dd($request);
            foreach ($request->export as $key ) {
                  $this->SinkronisasiDataSertifikatFromCloud($key);
            } 
            return back(); 
     }
     
    public function SinkronisasiDataSertifikatFromCloud($penjaminan_id) 
    { 

               $client = new \GuzzleHttp\Client(); 
               //mengakses dari endpoint web penjaminan
               $response = $client->get( "https://penjaminan.jamkridantb.com/get-sertifikat/$penjaminan_id",[ //idpenjaminan
                               'headers' => [ 
                                 'Authorization' => "Bearer allahuakbar" 
                      ]
               ]);
               $request                  = $response->getBody();
               //proses konversi data penjaminan Json Ke Array
               $ArrayPengajuan = json_decode($request, true);
                   
               //proses konversi Array ke Object
               $ObejctPengajuan = (object) $ArrayPengajuan; 
               $pengajuan              = $ObejctPengajuan;
               
       //        dd($pengajuan); 
                   //PENGECEKAN INPUTAN DATA 
                   $m_penjaminan = db::CONNECTION('sqlsrv')->table('t_penjaminan')
                           ->rightJoin('m_terjamin', 'm_terjamin.kd_terjamin', '=', 't_penjaminan.kd_terjamin')
                           ->rightJoin('m_penerima_jaminan', 'm_penerima_jaminan.kd_penerima', '=', 't_penjaminan.kd_penerima')
                           ->select(
                                   'm_penerima_jaminan.nama as nama_bank', 'm_terjamin.nama as nama_terjamin', 'm_terjamin.tanggal_daftar as tgl_daftar_terjamin', '*')
                           ->where('m_penerima_jaminan.kd_penerima', $pengajuan->kd_penerima) //kodebank pada simpk
                           ->where('m_terjamin.nama', $pengajuan->nama)
                           ->where('t_penjaminan.nilai',$pengajuan->plafon)
                           ->where('t_penjaminan.no_perjanjian',$pengajuan->nopk)
                           ->where('t_penjaminan.mulai',date('Y-m-d', strtotime($pengajuan->tglrealisasi)))
                           ->where('t_penjaminan.akhir',date('Y-m-d', strtotime($pengajuan->tgljatuhtempo)))
       //                    ->where(DB::raw('YEAR(m_terjamin.tanggal_daftar)'), date('Y', strtotime($pengajuan->tglpengajuan)))
       //                    ->where(DB::raw('MONTH(m_terjamin.tanggal_daftar)'), date('m', strtotime($pengajuan->tglpengajuan)))
       //                    ->where(DB::raw('DAY(m_terjamin.tanggal_daftar)'), date('d', strtotime($pengajuan->tglpengajuan)))
                           ->first();
         
//               dd($pengajuan->kodesertifikat);
       //            echo " mulai ".date('Y-m-d', strtotime($pengajuan->tglrealisasi)).'<br>';
       //            echo " akhir ".date('Y-m-d', strtotime($pengajuan->tgljatuhtempo)).'<br>';
       //            echo " plafon ".$pengajuan->plafon.'<br>';
       //            echo " pk ".$pengajuan->nopk.'<br>';

                   if (isset($m_penjaminan->no_sertifikat)) {
                          session::flash('pesan', 'Data Penjaminan: '.$pengajuan->kodesertifikat.' sudah ada di Sistem dengan sertifikat : '.$m_penjaminan->no_sertifikat); 
                   } 
                   else 
                   {
       //                  dd($m_terjamin_last);
                       //cek nama dan tanggal lahir terjamin
                       $cek_jumlah_terjamin = db::CONNECTION('sqlsrv')
                              ->table('m_terjamin')
                              ->select('nama','kd_terjamin')
                              ->where('nama',$pengajuan->nama) 
                              ->where('lahir',date('Y-m-d', strtotime($pengajuan->tgllahir)))
                              ->count(); 
  
                       if($cek_jumlah_terjamin<1)
                       { 
                             $m_terjamin_last = db::CONNECTION('sqlsrv')
                                               ->table('m_terjamin')
                                               ->orderBy('kd_terjamin', 'desc')
                                               ->take(1)
                                               ->first();  
                              $kode_terjamin = ++$m_terjamin_last->kd_terjamin;  
                             
                       }else{ 
                               $data_m_terjamin = db::CONNECTION('sqlsrv')
                              ->table('m_terjamin')
                              ->select('nama','kd_terjamin','lahir','alamat')
                              ->where('nama',$pengajuan->nama)
       //                       ->where('kd_terjamin',$pengajuan->ktp) 
                              ->where('lahir',date('Y-m-d', strtotime($pengajuan->tgllahir))) 
                              ->first(); 
                                $kode_terjamin = $data_m_terjamin->kd_terjamin;
                       }
                       
              
//                                dd(substr($pengajuan->pekerjaan, 0, 50));
                        if($cek_jumlah_terjamin<1){

       //                     $kode_terjamin = ++$m_terjamin->kd_terjamin;

       //                input data terjamin ke sql server Lokal
                           $terjamin = new m_terjamin; 
                           $terjamin->kd_terjamin = $kode_terjamin;
                           $terjamin->kd_kota          = 'KAA002';
                           $terjamin->nama               = $pengajuan->nama;
                           $terjamin->kontak            = $pengajuan->telp;
                           $terjamin->npwp               = $pengajuan->npwp;
                           $terjamin->alamat            = $pengajuan->alamat;
                           $terjamin->telepon           = '-';
                           $terjamin->fax                     = '-';
                           $terjamin->email               = '-';
                           $terjamin->lahir                 = date('Y-m-d', strtotime($pengajuan->tgllahir));
                           $terjamin->perusahaan   = '-';
                           $terjamin->jenis_usaha    = substr($pengajuan->pekerjaan, 0, 50);
                           $terjamin->nomor              = '-';
                           $terjamin->direktur          = '-';
                           $terjamin->status               = '2'; //status terjamin (1=Surety Bond;2=Penjaminan Kredit)
                           $terjamin->keterangan   = '-';
                           //tanggal daftar yang terbaca di ambil dari tanggal pengajuan di sistem
                           $terjamin->tanggal_daftar = date('Y-m-d', strtotime($pengajuan->tglterbit));
                           $terjamin->referensi            = 'TAH996';
                           $terjamin->save();

                       }
                       else
                       { 
       //                    $kode_terjamin = $data_m_terjamin->kd_terjamin; 
                            db::CONNECTION('sqlsrv')
                                ->table('m_terjamin')
                                ->where('kd_terjamin',$kode_terjamin)
                                ->update([
                                       //update data kontraktor(Terjamin) ke Sql Server Lokal 
                                       'alamat'             => $pengajuan->alamat,
                                       'kontak'             => $pengajuan->telp, 
                                       'jenis_usaha'    => $pengajuan->pekerjaan,   
                             ]);
                        }
       //                dd($kode_terjamin);

                       //input data Penjaminan ke sql server Lokal

                       //mencari nomor transaksi berdasarkan tanggal hari ini
                       $m_penjaminan = db::CONNECTION('sqlsrv')->table('t_penjaminan')
                               ->where('t_penjaminan.no_transaksi', 'like', '%'.'KU'.date('ymd').'%')
                               ->orderBy('t_penjaminan.no_transaksi', 'desc')
                               ->take(1)
                               ->first();

                       if($m_penjaminan){
                            $sub_kalimat = substr($m_penjaminan->no_transaksi, 8);
                       }else{
                            $sub_kalimat =0;
                       }


                       $no_transaksi   = 'KU' . date('ymd') . str_pad($sub_kalimat, 4, '0', STR_PAD_LEFT);
                       $notransaksi     = ++$no_transaksi;
       //              dd($no_transaksi);

                       if ($pengajuan->jeniskredit == 'PRODUKTIF') {
                           $kode_produk = 'BPR-PRO';
                       } else {
                           $kode_produk = 'KONSUMTIF';
                       }

                       $DATA_T_PENJAMINAN_INSERT = db::CONNECTION('sqlsrv')->table('t_penjaminan')->insert(
                               [
                                   'no_transaksi'              => $notransaksi,
                                   'kd_divisi'                     => 'DAA001',
                                   'kd_penerima'             => $pengajuan->kd_penerima,
                                   'kd_terjamin'               => $kode_terjamin,
                                   'kd_produk'                 => $kode_produk,
                                   'no_sertifikat'             => $pengajuan->kodesertifikat,
                                   'tanggal_sertifikat'    => '2001-01-01',
                                   //tanggal verifikasi  di sistem yaitu tanggal terbitsertifikat
                                   'tanggal'                        => date('Y-m-d', strtotime($pengajuan->tglterbit)),
                                   'mulai'                           => date('Y-m-d', strtotime($pengajuan->tglrealisasi)),
                                   'akhir'                            => date('Y-m-d', strtotime($pengajuan->tgljatuhtempo)),
                                   'tarif_ijp'                       => $pengajuan->rate,
                                   'total_ijp_kotor'          => $pengajuan->premi,
                                   'total_ijp_bersih'        => $pengajuan->nett,
                                   'nilai'                             => $pengajuan->plafon,
                                   'nilai_penjaminan'    => $pengajuan->share,
                                   'diskon'                        => $pengajuan->dis,
                                   'biaya1'                        => 0,
                                   'biaya2'                        => 0,
                                   'biaya3'                        => 0,
                                   'keterangan'               => '-',
       //                            'kd_user'                      => Session::get('kd_user'),
                                   'kd_user'                      => $pengajuan->kodeuser,
                                   'jenis'                            => '2',
                                   'no_permintaan_penjamin' => '-',
                                   'tanggal_permintaan_penjamin' => date('Y-m-d', strtotime($pengajuan->tglterbit)),
                                   'no_perjanjian'          => $pengajuan->nopk,
                                   'tanggal_perjanjian' => date('Y-m-d', strtotime($pengajuan->tglpk)),
                                   'jenis_kredit' => '-',
                               ]
                       );

                       //INSERT DATA KE TABEL VERIFIKASI PENJAMINAN

       //                $data_t_penjaminan = db::CONNECTION('sqlsrv')->table('t_penjaminan')
       //                        ->where('kd_terjamin', $kode_terjamin)
       //                        ->first();

                       $DATA_INSERT_VERIFIKASI = db::CONNECTION('sqlsrv')->table('t_penjaminan_verifikasi')->insert(
                               [
       //                            'no_transaksi' => $data_t_penjaminan->no_transaksi,
                                   'no_transaksi'      => $notransaksi,
                                   //tanggal verifikasi keuangan di sistem yaitu tanggal sinkronisasi
                                   'tanggal'               => date('Y-m-d', strtotime($pengajuan->tglterbit)),
                                   'kd_user'               => $pengajuan->kodeuser,
                                   'keterangan'        => '-',
                                   'tanggal_server' => date('Y-m-d', strtotime($pengajuan->tglterbit)),
                                   'status'                  => '1'
                               ]
                       );

                       //INSERT DATA KE TABEL VERIFIKASI KEUANGAN


                       $kd_kas = $pengajuan->kodekas;

       //                $DATA_INSERT_PENJAMINAN_KEUANGAN = db::CONNECTION('sqlsrv')->table('t_penjaminan_keuangan')->insert(
       //                        [
       ////                        'no_transaksi' => $data_t_penjaminan->no_transaksi,
       //                            'no_transaksi'      =>$notransaksi,
       //                            'tanggal'                 =>date('Y-m-d', strtotime($pengajuan->tglterbit)),
       //                            'kd_jenis'               => 'JAA001',
       //                            'kd_kas'                  => $kd_kas,
       //                            'no_bukti'              => '-',
       //                            'keterangan'         => '-',
       //                            'kd_user'                => $pengajuan->kodeuser,
       //                            'tanggal_server'  =>date('Y-m-d', strtotime($pengajuan->tglterbit))
       //                        ]
       //                ); 
       //                

       //                date_default_timezone_set("Asia/Jakarta");
       //                date('Y-m-d H:i:s',strtotime('+1 hour'));  
       //                $updatepenjaminanexport = sertifikats::where('sertifikats.idpenjaminan', $key)
       //                        ->update([
       //                            'sinkronisasi' => 'Y',
       //                            'tgl_sink' =>    date('Y-m-d H:i:s',strtotime('+1 hour')),
       //                ]);
       //                
       //                
                       
                       if($DATA_INSERT_VERIFIKASI){
                           // akan melakukan porses update status sink menjadi "Y" mendandakan bahwa telah di sinkronkan
                         $response = $client->get( "https://penjaminan.jamkridantb.com/update-status-sink/$penjaminan_id",[
                               'headers' => [ 
                                 'Authorization' => "Bearer allahuakbar" 
                               ]
                        ]);
                         session::flash('pesan', 'Data pengajuan berhasil di export');
                       }  
                   } 
     }
     
  public function SinkronisasiDataSbFromCloud($sppsb){
      
//            $tgl_verifikasi_keu=date('Y-m-d',strtotime($data['tgl_ver_keu']));
//            $tgl_verifikasi_kasi=date('Y-m-d',strtotime($data['tgl_ver_kasi']));
//            dd($data);
    
             $m_penjaminan = DB::CONNECTION('sqlsrv')->table('t_penjaminan') 
                 ->select('*')
                ->leftJoin('m_terjamin', 'm_terjamin.kd_terjamin', '=', 't_penjaminan.kd_terjamin')
                ->leftJoin('m_penerima_jaminan', 'm_penerima_jaminan.kd_penerima', '=', 't_penjaminan.kd_penerima') 
                ->where([
                    ['t_penjaminan.no_perjanjian',$sppsb->nama_dokumen],
                    ['t_penjaminan.nilai',$sppsb->nilai_jaminan],
                    ['t_penjaminan.jenis_kredit',$sppsb->jenis_pekerjaan],
                        ])
                ->whereDate('t_penjaminan.mulai','=',$sppsb->waktu_mulai)
                ->whereDate('t_penjaminan.akhir','=', $sppsb->waktu_selesai)
                ->where('m_terjamin.nama', $sppsb->nama_kontraktor)
//                ->select(\DB::raw('count(*) as total'),'*')
                ->get();
//               dd($m_penjaminan);
//             dd($m_penjaminan);
//             dd($m_penjaminan->total);
//             $m_penjaminan=0;
             
//             dd($sppsb);
          if (count($m_penjaminan) > 0) 
          {
                 $api = (new APIController())->updateStatusSbFromCloud($sppsb->id);
                 return "Sertifikat " .$sppsb->no_jaminan." (".$sppsb->nama_kontraktor.") Sudah ada disistem !!!";

          } 
          else 
          {
               //mengambil kode terakhir terjamin yang di input

               $m_terjamin_last=db::CONNECTION('sqlsrv')
                       ->table('m_terjamin')
                       ->orderBy('kd_terjamin', 'desc')
                       ->take(1)
                       ->first();
//               DD($m_terjamin);
               
               $jumlah_m_terjamin = db::CONNECTION('sqlsrv')
                       ->table('m_terjamin')
                       ->select('nama','kd_terjamin')
                       ->where('nama',$sppsb->nama_kontraktor)
                       ->take(1)
                       ->count();
               
               $data_m_terjamin = db::CONNECTION('sqlsrv')
                       ->table('m_terjamin')
                       ->select('nama','kd_terjamin')
                       ->where('nama',$sppsb->nama_kontraktor)
//                       ->where('nama','like', '%'.$sppsb->nama_kontraktor.'%')
                       ->take(1)
                       ->first();
               
//               dd($data_m_terjamin);
                      
//               $jumlahDataTerajmin=count($m_terjamin);
//                       dd($jumlahDataTerajmin);
//               $sppsb= db::table('sppsb')->where('id',$data['id'])->get();
//                          dd(count($sppsb));
//               echo '<pre>';
//               print_r($m_terjamin_cekjumlah);
//               echo '</pre>';
//              dd($m_terjamin_cekjumlah);
               
              if($jumlah_m_terjamin<1)
              { //cek jumalh terjamin yang ada di sitem

               $kodeterjamin=++$m_terjamin_last->kd_terjamin;
       
               db::CONNECTION('sqlsrv')->table('m_terjamin')->insert(
               [
                 //input data kontraktor(Terjamin) ke Sql Server Lokal
                   'kd_terjamin'   => $kodeterjamin,
                   'kd_kota'       => 'KAA002',
                   'nama'          => $sppsb->nama_kontraktor,
                   'kontak'        => '-',
                   'npwp'          => '-',
                   'alamat'        => $sppsb->alamat_kontraktor,
                   'telepon'       => '-',
                   'fax'           => '-',
                   'email'         => '-',
                   'lahir'         => date('Y-m-d'),
                   'perusahaan'    => '-',
                   'jenis_usaha'   => $sppsb->bidang_usaha,
                   'nomor'         => '-',
                   'direktur'      =>$sppsb->direksi,
                   'status'        => '1',//status terjamin untuk sb (1=sb;2=kredit)
                   'keterangan'    => '-',
                    //tanggal daftar yang terbaca di ambil dari tanggal pengajuan di sistem
                   'tanggal_daftar' => date('Y-m-d', strtotime($sppsb->created_at)),
                   'referensi'     => 'TAH996',
               ]);

               }
               else
               { 
                    $kodeterjamin = $data_m_terjamin->kd_terjamin; 
                    db::CONNECTION('sqlsrv')
                         ->table('m_terjamin')
                         ->where('kd_terjamin',$kodeterjamin)
                         ->update([
                                //input data kontraktor(Terjamin) ke Sql Server Lokal
                                'kd_kota' => 'KAA002',
                                'nama' => $sppsb->nama_kontraktor,
                                'kontak' => '-',
                                'npwp' => '-',
                                'alamat' => $sppsb->alamat_kontraktor,
                                'telepon' => '-',
                                'fax' => '-',
                                'email'=> '-',
                                'perusahaan' => '-',
                                'jenis_usaha' => $sppsb->bidang_usaha,
                                'nomor' => '-',
                                'direktur' => $sppsb->direksi,
                                'status' => '2',
                                'keterangan' => '-',
                //tanggal daftar yang terbaca di ambil dari tanggal pengajuan di sistem
//                                'tanggal_daftar' => date('Y-m-d', strtotime($sppsb->created_at)),
                                'referensi' => 'TAH996',
                      ]);
                }
               //input data Penjaminan ke sql server Lokal 
//               dd($m_penjaminan);
               

                //cek apakah penerima jaminan sudah ada di tabel server lokal jnb
               $jumlah_m_penerima_jaminan = 
                       db::CONNECTION('sqlsrv')
                       ->table('m_penerima_jaminan')
                       ->where('nama',$sppsb->pemilik_proyek)
                       ->take(1)
                       ->count();
                $m_penerima_jaminan = 
                       db::CONNECTION('sqlsrv')
                       ->table('m_penerima_jaminan')
                       ->where('nama',$sppsb->pemilik_proyek)
                       ->take(1)
                       ->first();
                
//               dd($jumlah_m_penerima_jaminan);
////               
//               $jumlahDataPenerimajaminan=count($m_penerima_jaminan);

               if($jumlah_m_penerima_jaminan<1){
                   
                   //MENGAMBIL KODE PENERIMA JMINAN TERAKHIR
                   $m_penerima_jaminan = db::CONNECTION('sqlsrv')
                            ->table('m_penerima_jaminan')
                            ->orderBy('kd_penerima', 'desc')
                            ->take(1)
                            ->first();
         
                   $kode_penerima=++$m_penerima_jaminan->kd_penerima;
                   $insert_penerima_jaminan=
                           db::CONNECTION('sqlsrv')->table('m_penerima_jaminan')
                           ->insert(
                           [
                             'kd_penerima'     => $kode_penerima,
                             'kd_kota'         => 'KAA001' ,//kodemataram
                             'nama'            => $sppsb->pemilik_proyek,
                             'kontak'          => '-',
                             'alamat'          => $sppsb->alamat,
                             'telepon'         => '-',
                             'fax'             => '-',
                             'email'           => '-',
                             'website'         => '-',
                             'direktur'        =>$sppsb->nama_pejabat,
                             'tanggal_daftar'  =>date('Y-m-d', strtotime($sppsb->created_at)),
                             'keterangan'      => '-',
                             'status'          => '3', // kode untuk bukan lembaga keuangan
                             'referensi'       => '-',
                            ]);

               }
               else
               {
                    $kode_penerima=$m_penerima_jaminan->kd_penerima; 
                    db::CONNECTION('sqlsrv')->table('m_penerima_jaminan')
                         ->where('kd_penerima',$kode_penerima)
                         ->update(
                          [ 
                             'kd_kota'         => 'KAA001' ,//kodemataram
                             'nama'            => $sppsb->pemilik_proyek,
                             'kontak'          => '-',
                             'alamat'          => '-',
                             'telepon'         => '-',
                             'fax'             => '-',
                             'email'           => '-',
                             'website'         => '-',
                             'direktur'        =>$sppsb->nama_pejabat, 
                             'keterangan'      => '-',
                             'status'          => '1',
                             'referensi'       => '-',
                          ]
                                 );
               }
            
               //UNTUK MENGECEK NO TRANSAKSI TERAKHIR DALAM SATU HARI
               $m_penjaminan = db::CONNECTION('sqlsrv')->table('t_penjaminan')
                        ->where('t_penjaminan.no_transaksi', 'like', '%'.'KU'.date('ymd').'%')
                        ->orderBy('t_penjaminan.no_transaksi', 'desc')
                        ->take(1)
                        ->first();
                
                if($m_penjaminan){
                     $sub_kalimat = substr($m_penjaminan->no_transaksi, 8);
                }else{
                     $sub_kalimat =0;
                }
               
                $no_transaksi = 'KU' . date('ymd') . str_pad($sub_kalimat, 4, '0', STR_PAD_LEFT);

//               dd($no_transaksi);
                
//                $BiayaAdminstrasi       =  $sppsb->fee_admin+$sppsb->materai;
//                $ijpBulat                          =   $sppsb->service_charge-22000;
//                $feeAgen                          =   $ijpBulat- ($sppsb->fee_agen/100);
//                $NettIJP                            =  $ijpBulat+$BiayaAdminstrasi-$feeAgen;
                
                
                $DATA_T_PENJAMINAN_INSERT = db::CONNECTION('sqlsrv')->table('t_penjaminan')
                       ->insert(
                       [
                           'no_transaksi' => ++$no_transaksi,
                           'kd_divisi' => 'DAA001',
                           'kd_penerima' => $kode_penerima,
                           'kd_terjamin' => $kodeterjamin,
                           'kd_produk' => $sppsb->kd_produk,
                           'no_sertifikat' => $sppsb->no_jaminan,
                           'tanggal_sertifikat' => '2001-01-01',
                           //tanggal verifikasi  di sistem yaitu tanggal sinkronisasi
//                           'tanggal' => date('Y-m-d', strtotime($sppsb->tgl_cetak)),//digunakan sebagai tanggal terbit sertifikat
                           'tanggal' => date('Y-m-d', strtotime($sppsb->created_at)),//digunakan sebagai tanggal terbit sertifikat
                           'mulai' => date('Y-m-d', strtotime($sppsb->waktu_mulai)),
                           'akhir' => date('Y-m-d', strtotime($sppsb->waktu_selesai)),
                           'tarif_ijp' => $sppsb->rate_ijp,
                           'total_ijp_kotor' => $sppsb->gross_ijp,
                           'total_ijp_bersih' => $sppsb->net_ijp,
                           'nilai' => $sppsb->nilai_jaminan,
                           'nilai_penjaminan' =>'100',
                           'diskon' => $sppsb->diskon,
                           'biaya1' => $sppsb->materai,
                           'biaya2' => $sppsb->fee_admin,
                           'biaya3' =>  '0',
                           'keterangan' =>$sppsb->durasi,
//                           'kd_user' => 'UAA020', //KODE USERNYA DENTICKHA MAGHFIRA
                           'kd_user' => 'UAA003', //KODE USERNYA FUAD
                           'jenis' => '2',
                           'no_permintaan_penjamin' => $sppsb->no_dokumen,
                           'tanggal_permintaan_penjamin' => $sppsb->tgl_dokumen,//TANGGAL DOKUMEN PENDUNJUKAN
                           'no_perjanjian' => $sppsb->nama_dokumen,
                           'tanggal_perjanjian' => date('Y-m-d', strtotime($sppsb->tgl_dokumen)),//TANGGAL DOKUMEN PENDUNJUKAN
                           'jenis_kredit' => $sppsb->jenis_pekerjaan,
                       
                         ]);

               //INSERT DATA KE TABEL VERIFIKASI PENJAMINAN 
                //INSERT DATA KE TABEL VERIFIKASI PENJAMINAN
//            $data_t_penjaminan = db::CONNECTION('sqlsrv')->table('t_penjaminan')
//                    ->where('kd_terjamin', $kode_terjamin)
//                    ->first();
//                dd($no_transaksi);
               $DATA_INSERT_VERIFIKASI = db::CONNECTION('sqlsrv')->table('t_penjaminan_verifikasi')->insert(
                       [
                           'no_transaksi' =>$no_transaksi,
                           //tanggal verifikasi keuangan di sistem yaitu tanggal sinkronisasi
                           'tanggal' =>$sppsb->created_at,
                           'kd_user' =>'UAA020',
                           'keterangan' => '-',
                           'tanggal_server' => $sppsb->created_at,
                           'status' => '1'
                       ]
               );
                
              
                if($DATA_INSERT_VERIFIKASI){
                           // Untuk mengubah status sink pada tabel sppsb
                           $api = (new APIController())->updateStatusSbFromCloud($sppsb->id);
                }
            

               //INSERT DATA KE TABEL VERIFIKASI KEUANGAN
              
//               $DATA_INSERT_PENJAMINAN_KEUANGAN = db::CONNECTION('sqlsrv')
//                       ->table('t_penjaminan_keuangan')->insert(
//                       [
//                           'no_transaksi' =>$no_transaksi,
//                           'tanggal' => $tgl_verifikasi_keu,
//                           'kd_jenis' => 'JAA001',
//                           'kd_kas' => 'KAA002',//kode kas untuk Giro Pada Bank NTB Syariah Pejanggik
//                           'no_bukti' => '-',
//                           'keterangan' => '-',
//                           'kd_user' => 'UAA009', //KODE USERNYA SIGIT
//                           'tanggal_server' =>$tgl_verifikasi_keu
//                       ]
//               );
               
                 return "Succes Sinkronisasi : " .$sppsb->no_jaminan." ".$sppsb->nama_kontraktor;
           }
  } 
     
     
}
