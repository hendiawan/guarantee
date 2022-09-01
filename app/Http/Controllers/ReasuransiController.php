<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

/**
 * Description of ReasuransiController
 *
 * @author ROG
 */
use Illuminate\Support\Facades\Session;
use App\banks;
use App\m_rekanan_asuransi;
use App\sertifikats;
use App\penjaminans;
use Illuminate\Http\Request;
use App\t_reasuransi;
//use GuzzleHttp;
use GuzzleHttp\Client;
use GuzzleHttp;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AkrualController;
//use App\Http\Controllers\AdminController;
use App\Http\Controllers\laporanController;
   use PDF;
class ReasuransiController extends Controller {
    //put your code here
    
 
    public function index(){
//        dd($_POST); 
 
//     $laporan    =   new laporanController();
     $data = new AdminController();
     $data->nama_admin="Muhammad";
     $reasuransi = m_rekanan_asuransi::get();  
     $bank = banks::get();
//     $terbilang=$data->terbilang(2500000);
//     dd($terbilang);
//     dd($_POST);

//                  dd(  $_SERVER);
     if($_SERVER['REQUEST_METHOD'] == 'POST'){
         
//         dd($_POST['sampai']);
         
     $dari=$this->tanggal($_POST['dari']);
     $sampai=date ('Y-m-d 23:59:59.000',strtotime($this->tanggal($_POST['sampai'])));
     $id_bank=$_POST['bank'];         
//        dd($sampai);
        $datareasuransi = penjaminans:: 
                whereBetween('tglterbit', array($dari,$sampai)) 
                ->wherein('penjaminans.app',['Lunas','Cetak'])    
                ->where
                ([ 
                    ($_POST['bank']=='%') ? ['penjaminans.idbank','like',"%$id_bank%"]:['penjaminans.idbank',$id_bank], 
//                    ['penjaminans.idbank', ($request->bank=='%') ? '"like","%$request->bank%" ':$request->bank],  
                 ])
//                ->where('penjaminans.idbank','like', '%' . $bank . '%') 
//                          ->where('kodesertifikat', 'like', '%' . $request->data . '%')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank') 
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan') 
                ->orderBy('banks.kodepusat') 
                ->groupBy('penjaminans.idbank')     
                ->select('penjaminans.idbank', 'banks.namabank', \DB::raw('count(*) as total'))
//                ->orderBy('sertifikats.id', 'desc') 
                ->take(1000)
                ->get();
        
        return view('admin.register-reasuransi', compact(
                            'datareasuransi', 
                            'reasuransi',
                            'dari',
                            'sampai',
                            'bank',
                            'id_bank'
                ) );
//     dd($datareasuransi);
     }else{
            $datareasuransi = penjaminans:: wherein('penjaminans.app',['Lunas','Cetak'])     
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank') 
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan') 
                ->orderBy('banks.kodepusat') 
                ->groupBy('penjaminans.idbank')     
                 ->where(\DB::raw("(DATE_FORMAT(sertifikats.tglterbit,'%m'))"), date('m'))
                ->select('penjaminans.idbank', 'banks.namabank', \DB::raw('count(*) as total'))
//                ->orderBy('sertifikats.id', 'desc') 
                ->take(1000)
                ->get();
  
     }
     
     $dari=date ('Y-m-d 01:00:00.000');
     $sampai=date ('Y-m-d 23:59:59.000');
//        dd($datareasuransi);
        return view('admin.register-reasuransi', compact(
                'datareasuransi', 
                'reasuransi',
                 'dari',
                'sampai',
                'bank' ) );
         
//           dd($datareasuransi);
           
    }
    
    
    public function reasuransi() {
        
        $rekanan_asuransi = m_rekanan_asuransi::get();
//        dd($rekanan_asuransi);
        
        $bank = banks::get();
//        dd($bank);
        return view('admin.formReasuransi', [
            'reasuransi' => $rekanan_asuransi,
            'bank' => $bank,
        ]);
        
        
    }
    
    public  function cekSertifikat(request $request){
//        dd($request);
        $dataSertifikat = penjaminans::leftJoin('sertifikats','penjaminans.idpenjaminan','=','sertifikats.idpenjaminan')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->where('sertifikats.kodesertifikat',$request->no_sertifikat)->first();
                
         return json_encode($dataSertifikat) ;
    }
    
    public function insert(request $request){
         date_default_timezone_set("Asia/Jakarta");
         $nilaiJaminan = ($request->plafon*$request->share)/100;
         $ijp = ($request->ijp*$request->share)/100;
//              dd($request);
        $simpandata = t_reasuransi::insert([
                    'penjaminan_id'=>$request->penjaminan_id,
                    'rekanan_id'=>$request->id_reasuransi,
                    'tgl_proses'=>date('Y-m-d H:i:s',strtotime('+1 hour')),
                    'share_risk'=>$request->share,
                    'nilai_jaminan'=>$nilaiJaminan,
                    'ijp'=>$ijp,
                    'commision'=>$request->commision,
        ]);
         Session::flash('pesan-reasuransi', 'Data Reasuransi Berhasil di input');
        return back();
        
    }
    
    public function CekRentensiSendiri($PersentRetensiSendiri,$plafonRetensi,$plafonPenjaminan){
        
//          $RetensiSendiri = $this->CekRentensiSendiri(15, 25000000, $pengajuan->plafon);
                     $PersentaseRetensiSendiri = $PersentRetensiSendiri;
                     $RetensiSendiri      =   $plafonRetensi;
                     $RetensiSendiri1    =   $plafonPenjaminan*$PersentaseRetensiSendiri/100; 
                     if($RetensiSendiri1>$RetensiSendiri){
                         $RetensiSendiri =$RetensiSendiri1;
                     }else{
                          $RetensiSendiri=$RetensiSendiri;
                     }
                     
                     return $RetensiSendiri;
    }

    public function multipleInsert(request $request){
         date_default_timezone_set("Asia/Jakarta");
//          
//       dd($request);
         foreach ($request->datareas as $idpenjaminan => $value) {

               
            $pengajuan = penjaminans:: where('penjaminans.idpenjaminan', $idpenjaminan)
                    ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                    ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                    ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                    ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                    ->first();
            //
            
            // Rp25.000.000,00 (dua puluh lima juta rupiah),
            // wajib ditahan sendiri paling sedikit 75% (tujuh
            // puluh lima per seratus) 
            
            ////Rp25.000.000,00 (dua puluh
            //lima juta rupiah) sampai dengan kurang
            //dari Rp250.000.000,00 (dua ratus lima
            //puluh juta rupiah), wajib ditahan sendiri
            // paling sedikit sebesar jumlah paling banyak
            //antara:
                        //1. Rp25.000.000,00 (dua puluh lima juta
                        //rupiah); atau
                        //2. 15% (lima belas per seratus) dari nilai
                        //Penjaminan atau Penjaminan Syariah
                        //dimaksud;
                        // untuk nilai Penjaminan atau Penjaminan
            
            
            //Syariah dari Rp250.000.000,00 (dua ratus lima
            //puluh juta rupiah) sampai dengan kurang dari
            //Rp1.000.000.000,00 (satu miliar rupiah), wajib
            //ditahan sendiri paling sedikit sebesar jumlah
                    //paling banyak antara:
                    //1. Rp50.000.000,00 (lima puluh juta rupiah);
                    //atau
                    //2. 10% (sepuluh per seratus) dari nilai
                    //Penjaminan atau Penjaminan Syariah
                    //dimaksud;
            //    untuk nilai Penjaminan atau Penjaminan
          
            //  //Syariah sama dengan atau lebih dari
            //Rp1.000.000.000,00 (satu miliar rupiah), wajib
            //ditahan sendiri paling sedikit sebesar jumlah
            //paling banyak antara:
                        //1. Rp100.000.000,00 (seratus juta rupiah);
                        //atau
                        //2. 5% (lima per seratus) dari nilai Penjaminan
                        //atau Penjaminan Syariah dimaksud


             $nilaiPenjaminan = ($pengajuan->plafon * $pengajuan->share / 100);
//            if($pengajuan->plafon<25000000){
            if ($nilaiPenjaminan < 25000000) {
                
//             Wajib ditahan sendiri paling sedikit 75% dari nilai penjaminan 
                $penjaminanReasuransi = $nilaiPenjaminan * 25 / 100;
                $shareReasuransi = 25;
            } else if ($nilaiPenjaminan >= 25000000 && $nilaiPenjaminan < 250000000) {
                // 25 Juta sampai 40 Juta
                
//                Wajib ditahan sendiri paling sedikit sebesar jumlah paling banyak antara:
//                1. Rp25 juta; atau
//                2. 15% dari nilai penjaminan
                
                if ($nilaiPenjaminan >= 25000000 && $nilaiPenjaminan <= 40000000) {
                        $penjaminanReasuransi   = $nilaiPenjaminan - 25000000;// ketika nilai penjaminan 25Jt maka share ke reasuransi akan 0 atau tidak dijamin reasuransi
                        $shareReasuransi               = $penjaminanReasuransi / $nilaiPenjaminan * 100;
              }
                // 40 Juta sampai 250 Juta
                else if ($nilaiPenjaminan > 40000000 && $nilaiPenjaminan <= 250000000) {
                            $penjaminanReasuransi = $nilaiPenjaminan * 40 / 100;
                            $shareReasuransi = 40; // Nilai minimal 15 %, dinaikkan menjadi 40% sesuai request bagian penjaminan
                } 
                //sesuai ketentuan minimal OJK
//                    $penjaminanReasuransi       = $nilaiPenjaminan-($this->CekRentensiSendiri(15, 25000000,$nilaiPenjaminan));
//                    $shareReasuransi                   = floor($penjaminanReasuransi/$nilaiPenjaminan*100);
            } else if ($nilaiPenjaminan >= 250000000 && $nilaiPenjaminan < 1000000000) {
                
//              "Wajib ditahan sendiri paling sedikit sebesar jumlah paling banyak antara:
//                     1. Rp50 juta; atau
//                     2. 10% dari nilai penjaminan" 
//                     
//               sesuai ketentuan minimal OJK
//                    $penjaminanReasuransi           =   $nilaiPenjaminan- ($this->CekRentensiSendiri(10, 50000000, $nilaiPenjaminan));
//                    $shareReasuransi                        =  floor($penjaminanReasuransi/$nilaiPenjaminan*100);
                //sesuai request bagian Penjaminan
                    $penjaminanReasuransi   = $nilaiPenjaminan * 40 / 100;
                    $shareReasuransi               = 40;
            } else if ($nilaiPenjaminan >= 1000000000) {
                //sesuai ketentuan POJK
//                "Wajib ditahan sendiri paling sedikit sebesar jumlah paling banyak antara:
//                1. Rp100 juta; atau
//                2. 5% dari nilai penjaminan" 

                $penjaminanReasuransi = $nilaiPenjaminan - ($this->CekRentensiSendiri(5, 100000000, $nilaiPenjaminan));
                $shareReasuransi              = $penjaminanReasuransi / $nilaiPenjaminan * 100;
            }

//            $nilaiJaminan = ($nilaiPenjaminan * $shareReasuransi) / 100;
//                $ijp    = ($pengajuan->premi * $shareReasuransi) / 100;//gross
                $ijp    = ($pengajuan->nett * $shareReasuransi) / 100;
//              dd($request);
           
                if ($pengajuan->plafon!=25000000)
                {
                     $simpandata = t_reasuransi::insert([
                               'penjaminan_id' => $idpenjaminan,
                               'rekanan_id' => $request->id_reasuransi,
                               'tgl_proses' => date('Y-m-d H:i:s', strtotime('+1 hour')),
                               'share_risk' => $shareReasuransi,
                               'nilai_jaminan' => $penjaminanReasuransi,
                               'ijp' => $ijp,
                               'commision' => $request->commision,
                   ]);
                } 
        } 
           Session::flash('pesan-reasuransi', 'Data Reasuransi Berhasil di input');
           return back();
        
    }
    
    public function update(request $request){
         date_default_timezone_set("Asia/Jakarta");
         $nilaiJaminan = ($request->plafon*$request->share)/100;
         $ijp = ($request->ijp*$request->share)/100;
//              dd($request);
        $simpandata = t_reasuransi::where('t_reasuransi.id',$request->t_reasuransi_id)
                    ->update([
                    'penjaminan_id'=>$request->penjaminan_id,
                    'rekanan_id'=>$request->id_reasuransi,
                    'tgl_proses'=>date('Y-m-d H:i:s',strtotime('+1 hour')),
                    'share_risk'=>$request->share,
                    'nilai_jaminan'=>$nilaiJaminan,
                    'ijp'=>$ijp,
                    'commision'=>$request->commision,
        ]);
         Session::flash('pesan-reasuransi', 'Data Reasuransi Berhasil di update !!');
        return back();
        
    }
    
    public function edit($id){
        
//   dd(function_exists('curl_version'));
        
        $datareasuransi = t_reasuransi::select(
                        '*', 't_reasuransi.id as t_reasuransi_id')
                ->leftjoin('m_rekanan_reasuransi','m_rekanan_reasuransi.id','=','t_reasuransi.rekanan_id')
                ->leftjoin('penjaminans','penjaminans.idpenjaminan','=','t_reasuransi.penjaminan_id')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->where('t_reasuransi.id',$id)
                ->first();
        
        $rekanan_asuransi = m_rekanan_asuransi::get();
        $bank = banks::get(); 
        return view('admin.formReasuransEdit', compact('datareasuransi'),[
              'reasuransi' => $rekanan_asuransi,
              'bank' => $bank,
        ]); 
    }
    
    public function read(){
        $datareasuransi = $datareasuransi = t_reasuransi::with('penjaminan')
                                            ->orderBy('t_reasuransi.id','desc')  
                                            ->limit(200)
                                            ->get();   
         return view('admin.datareasuransi', compact('datareasuransi'));
//    dd($datareasuransi);
         
    }
    
    public function rekap(){ 
     $datareasuransi = t_reasuransi::with('penjaminan')
                                            ->orderBy('t_reasuransi.id','desc')  
                                            ->limit(200)
                                            ->get(); 
        $bank = banks::get();
         return view('admin.datareasuransirekap', compact(
                 'datareasuransi',
                 'bank' 
                 ));  
    }
    
    public function rekapData(request $request){ 
//     $laporan    =   new laporanController();
     $dari              = date('Y-m-d',strtotime($request->dari));
     $sampai        = date ('Y-m-d 23:59:59.000',strtotime($request->sampai));
     $id_bank       = $_POST['bank'];     
//        dd($sampai); 
     $datareasuransi = t_reasuransi::with('penjaminan')
                                           ->leftjoin('penjaminans','penjaminans.idpenjaminan','=','t_reasuransi.penjaminan_id')
                                           ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                                            ->where
                                                  ([ 
                                                      ($request->bank=='%') ? 
                                                      ['penjaminans.idbank','like',"%$id_bank%"]:['penjaminans.idbank',$id_bank],  
                                                   ])   
                                             ->whereBetween(DB::raw('DATE(t_reasuransi.tgl_proses)'), [$dari, $sampai])
                                             ->orderBy('t_reasuransi.id','desc')  
                                             ->get(); 
//       echo 'dari : '.$dari.'<br>';
//       echo 'dari : '.$sampai;
//     dd($datareasuransi);
        $bank = banks::get();
        return view('admin.datareasuransirekap', compact(
                        'datareasuransi',
                        'bank' 
                 ));  
         
    }
    
//    public function cetakpdf ($id,$dari,$sampai){
////    dd($sampai);
////     $laporan    =   new laporanController();
//      //  $akrual = new AkrualController();
//        
//        $dari       = date('Y-m-d', strtotime($dari));
//        $sampai = date('Y-m-d 23:59:59.000', strtotime($sampai));
//        $id_bank = $id;
//        $datareasuransi = t_reasuransi::with('penjaminan')
//                ->leftjoin('penjaminans', 'penjaminans.idpenjaminan', '=', 't_reasuransi.penjaminan_id')
//                ->where
//                        ([
//                    ($id_bank == '%') ? ['penjaminans.idbank', 'like', "%$id_bank%"] : ['penjaminans.idbank', $id_bank],
//                ])
////                ->whereBetween('t_reasuransi.tgl_proses', array($dari, $sampai))
//                ->where('t_reasuransi.tgl_proses', '<=',$sampai)
//                ->orderBy('t_reasuransi.id', 'desc') 
//                ->get(); 
//         
//        $bank = banks::get();  
////        dd($datareasuransi[0]);
//        return View('user.laporan.laporanreasuransi', compact(
//                        'datareasuransi', 
//                        'bank',
//                        'dari', 
//                        'sampai'
//        ));
//    }
    
     public function cetakpdf ($id,$dari,$sampai){
//    dd($sampai);
//     $laporan    =   new laporanController();
        $dari = date('Y-m-d', strtotime($dari));
        $sampai = date('Y-m-d 23:59:59.000', strtotime($sampai));
        $id_bank = $id;

        $datareasuransi = t_reasuransi::with('penjaminan')
                ->leftjoin('penjaminans', 'penjaminans.idpenjaminan', '=', 't_reasuransi.penjaminan_id')
                ->where
                        ([
                    ($id_bank == '%') ? ['penjaminans.idbank', 'like', "%$id_bank%"] : ['penjaminans.idbank', $id_bank],
                ])
                ->whereBetween('t_reasuransi.tgl_proses', array($dari, $sampai))
                ->orderBy('t_reasuransi.id', 'desc') 
                ->get(); 
        $bank = banks::get(); 
        return View('user.laporan.laporanreasuransi', compact(
                        'datareasuransi', 'bank',   'dari', 
                        'sampai'
        ));
    }
    
    public function search(request $request){
//        dd($request);
//         $datareasuransi = $datareasuransi = t_reasuransi::with('penjaminan')
//                                            ->orderBy('t_reasuransi.id','desc')  
//                                            ->limit(200)
//                                            ->get();   
//         return view('admin.datareasuransi', compact('datareasuransi'));
         
        $datareasuransi = t_reasuransi::with('penjaminan')
                ->leftjoin('penjaminans', 'penjaminans.idpenjaminan', '=', 't_reasuransi.penjaminan_id')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->where
                        ([
                    ($request->jenis == 'nama') ?
                    ['terjamins.nama', 'like', "$request->data%"] :
                    ['sertifikats.kodesertifikat', $request->data],
                ]) 
                ->get();
        return view('admin.datareasuransi', compact('datareasuransi'));
    }
    
    
     public function FilterExport($id,$dari,$sampai) 
     {
     
      $penjaminan_id = t_reasuransi::pluck('penjaminan_id')->all();
//      dd($penjaminan_id);
      
     $datareasuransi =penjaminans::whereNotIn('sertifikats.idpenjaminan', $penjaminan_id)
                ->whereBetween(DB::raw('DATE(sertifikats.tglterbit)'), [$dari, $sampai])
                ->wherein('penjaminans.app',['Lunas','Cetak']) 
                ->where('banks.idbank',$id)  
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
//                ->where(\DB::raw("(DATE_FORMAT(sertifikats.tglterbit,'%m'))"), date('m'))
                ->get();
//           dd($datareasuransi);  

                $reasuransi = m_rekanan_asuransi::get();
              return view('admin.register-reasuransi-detail',compact('datareasuransi','reasuransi'));
        
     }
     
     public function tgl_indo($tanggal) {
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

        return  $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[2];
    }   
    
   public function tanggal($tgl) {
        $data = explode("/", $tgl);
        $isi = "$data[2]-$data[1]-$data[0]";
        return $tgl = date('Y-m-d', strtotime($isi));
    }
}
