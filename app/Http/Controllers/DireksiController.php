<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\penjaminans;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use PDF;
use App\sertifikats;
use Illuminate\Support\Facades\Session;
use App\history_apps;
//use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class DireksiController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('direksi');
    }
   public function cekappdireksi()
   {

        $pengajuan = penjaminans::select('*','penjaminans.idpenjaminan')
                ->where('penjaminans.app', 'direksi')
                ->where('case', 'Ya')
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->get();
//        dd($pengajuan);
        return view('admin.cek.cekappdireksi', ['pengajuan' => $pengajuan]);
    }
    
    
    public function DigitalSign()
   {
        $pengajuan = penjaminans::where('penjaminans.app', 'Cetak')
//                ->where('case', 'Tidak')
                ->whereNotIn('sertifikats.digitalSign', [1])
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
            //    ->where(DB::raw('MONTH(sertifikats.tglterbit)'), date('m'))
//                ->where(DB::raw('YEAR(sertifikats.tglterbit)'), date('Y'))
                ->where('sertifikats.tglterbit','>', '2021-04-08 23:59:59')// tgl rups pengangkatan pak taufik
                ->orderBy('sertifikats.id', 'desc')
                ->limit(5) 
                ->get(); 
        return view('admin.cek.digitalSign', ['pengajuan' => $pengajuan]);
    }
    
    public function DigitalSignSb()
    {
          $table_sppsb = db::CONNECTION('db_sb')->table('sppsb');
//          dd($table_sppsb);
          $table_result = db::CONNECTION('db_sb')->table('results');
           $sppsb = $table_sppsb->select('*','sppsb.created_at as tgl_input','sppsb.id as id')
                   ->leftJoin('users','users.id','=','sppsb.user_id')
                   ->where('sppsb.status','C')
                    ->whereNotIn('sppsb.digitalSign', [1])
                   ->limit(5)
                   ->orderby('sppsb.id','desc')->get(); 
//           dd($sppsb);
           return view('admin.cek.digitalSignSb', ['pengajuan' => $sppsb]);
    }
     

     
    
//    public function testingsign(request $request) {
////        dd($request->proses );
//        $jumlah_sertifikat=1;
//        foreach ($request->proses as $key => $value) 
//        {
//            //update informasi sertifikat, siapa yang melakukan tanda tangan
//            $update_sertifikat = sertifikats::where('idpenjaminan', $key)
//                            ->update
//                            ([  
//                                    'usr_ttd' =>  Auth::user()->name,
//                                    'jabatan' =>  Auth::user()->jabatan,
//                                    'url_ttd' =>  Auth::user()->url_ttd,
//                             ]);
//            $sertifikat = penjaminans::where('penjaminans.idpenjaminan', $key)
//                    ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
//                    ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
//                    ->leftJoin('users', 'users.idbank', '=', 'banks.idbank')
//                    ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
//                    ->get();
//            //cek apakah sertifikat sudah ditandatangai
//            if ($sertifikat[0]['digitalSign'] != 1)
//            {
//                $namabank                   = str_replace(" ", "-", $sertifikat[0]['namabank']);
//                $namaTerjamin           = str_replace(" ", "-", $sertifikat[0]['nama']);
//                $BuatFolderSimpan   = 'SertifikatPenjaminanKreditSign/' . date("Y") . '/' . date("m") . '/' . date("d"). '/' . $namabank . '/' ;
//                $Buat                               = File::makeDirectory($BuatFolderSimpan, $mode = 0777, true, true);
//				//dd($Buat);
//                $PublicPath                   = public_path($BuatFolderSimpan);
//                $fileNameOri                = $sertifikat[0]['kodesertifikat'] . '-' . $namaTerjamin . '.pdf';  
//                
//                //kondisi untuk memilih sertifikat
//                if ($sertifikat[0]['level'] == 'koperasi') {
//                    $pdf = PDF::loadView('user.laporan.sign.sertifikatKoperasi', compact('sertifikat'));
//                } else {
//                    $pdf = PDF::loadView('user.laporan.sign.sertifikat', compact('sertifikat'));
//                }
//                
//                $pdf->setPaper('A4', 'portrait');
//                //menyimpan sertifikat hasil generate PDF
//                $pdf->save($PublicPath . '/' . $fileNameOri); 
//
//                $LokasiFolderSimpan = $sertifikat[0]['url'];
//                
//                if ($LokasiFolderSimpan == null) {
//                    $ubahsertifikat = sertifikats::where('idpenjaminan', $key)
//                            ->update
//                            ([
//                                 'url' => $BuatFolderSimpan . '/' . $fileNameOri,
//                            ]);
//                }
//
//
//                $namaTerjamin = str_replace(" ", "-", $sertifikat[0]['nama']);
//                $Datasertifikat = sertifikats::where('idpenjaminan', $key)->first();
//                
//                
//                //menjalankan modul tanda tangan BSSN/BsRE 
//                $esign = new BSrE_Esign_Cli();
//                if ($esign->directoryName == false) {
//                    // jika lokasi direktory sertifikat tidak ditemukan, maka
//                    //akan di ambil lokasi sertifikat baru
//                    $lokasiSertifikat = $BuatFolderSimpan . '/' . $fileNameOri;
//                } else {
//                    // jika lokasi direktory sertifikat  ditemukan, maka
//                    //akan di ambil lokasi saat penerbitan sertifikat (Saat penerbitan sertifikat oleh staff)
//                    $lokasiSertifikat = $Datasertifikat->url;
//                }
//
//               
//                $esign->setDocument(public_path() . '/' . $lokasiSertifikat);
//
//            //      $esign->setDirOutput('/output', true);
//            //          $esign->setSuffixFileName('');
//
//                $esign->setAppearance
//                (
//                        $x = 60, $y = 45, $width = 230, $height = 320, $page = 1,
////                $spesimen = '',
//                        $spesimen = public_path() . '/example/spesimen/ttd1.png', $qr = null
//                );
//
//
//                $hasil = $esign->sign(
//                        '5208051004930002', //nik
//                        'Hend!4wandip@'    //passphrase
//                );
//                
//                //teting developer
////                $hasil = $esign->sign(
////                        '30122019', //nik
////                        $request->passphrase  //passphrase
//						#4321qwer*
////                );
//
////                $hasil = $esign->sign(
////                        $request->nik, //nik
////                        $request->passphrase   //passphrase
////                );
//				 
//				//dd($esign);
//                //  echo  $lokasiSertifikat ; 
//             
//
//                if (!$hasil) { 
//                        session::flash('pesan_error', $esign->error);
//                        return redirect('/DigitalSign');
//                } else {
//
//                    date_default_timezone_set("Asia/Jakarta");
//                    date('Y-m-d H:i:s',strtotime('+1 hour')); 
//                   // dd(Auth::user()->name);
//                    $fileNameSign = $sertifikat[0]['kodesertifikat'] . '-' . $namaTerjamin . '_signed.pdf';
//                    $ubahsertifikat = sertifikats::where('idpenjaminan', $key)
//                            ->update
//                            ([
//                                    'url' => $BuatFolderSimpan . '/' . $fileNameSign,
//                                    'digitalSign' => '1',
//                                    'tgl_ttd' => date('Y-m-d H:i:s',strtotime('+1 hour ')),
//                                    'usr_ttd' =>  Auth::user()->name,
//                             ]);
//
//
////                 echo 'Trranser File ke FTP';
//                   // $this->TransferFile($BuatFolderSimpan, $fileNameSign);
//                    //menghapus file pada Server Lokal (VPS)
////                           $hapusFileOri= unlink(public_path() . '/' . $BuatFolderSimpan . '/' . $fileNameOri);
////                           $hapusFileTTD= unlink(public_path() . '/' . $BuatFolderSimpan . '/' . $fileNameSign);
//
//                    session::flash('pesan_sukses',$jumlah_sertifikat);
//				  
//                }
//            }
//            $jumlah_sertifikat++;
//        }
//        return redirect('/DigitalSign');
//    }
    
    
    public  function TransferFile($BuatFolderSimpan,$fileNameSign){
                    
                    // Cek apakah folder sudah ada
                    $exists = Storage::disk('ftp')->exists($BuatFolderSimpan);
                    //echo "<br>";
                    // echo $BuatFolderSimpan;
                    //dd($exists);
                    //buat folder halo
                    if ($exists != true) {
                        //jika lokasi folder pada FTP server tidak ada, maka akan dibuat folder baru 
                        Storage::disk('ftp')->makeDirectory($BuatFolderSimpan);
                    }
                           Storage::disk('ftp')
                            //menyimpan File sesuai Folder FPT yang sudah dibuat
                            ->put($BuatFolderSimpan . '/' . $fileNameSign,
                            //mengambil File dari direktory lokal yang akan dimasukkan ke folder FTP
                              fopen($BuatFolderSimpan . '/' . $fileNameSign, 'r+')); 
    }


      public function testingsign(request $request) {
                $jumlah_sertifikat=1;
                foreach ($request->proses as $key => $value) 
                { 
                        $sign     =     new APIController();   
                        $data     =     $sign->signKreditFromCloud($key, $request->nik, $request->passphrase);
        //               dd($sertifikat->msg); 
                         $jumlah_sertifikat++;
                }
                session::flash('pesan_sukses',$data->msg);
                return redirect('/DigitalSign');
    }
     
    
       public function signsb(request $request) {
 
                 $jumlah_sertifikat=1;
                 foreach ($request->proses as $key => $value) 
                 { 
         //            
                         $sign     =     new APIController();           
                       
                         
                         $data     =     $sign->signSbFromCloud($key, $request->nik, $request->passphrase);
//                        dd( $request->nik); 
                          $jumlah_sertifikat++;
                 }
                 session::flash('pesan_sukses',$data->msg); 
                 return redirect('/DigitalSignSb');
    }
    
    
//    public function signsb(request $request) {
////        dd($request);
//        $jumlah_sertifikat=1;
//        
//         $table_sppsb = db::CONNECTION('db_sb')->table('sppsb');
//         $table_result = db::CONNECTION('db_sb')->table('results');
//         
//        foreach ($request->proses as $key => $value) 
//        {
//            $sertifikat = $table_sppsb->select('*','sppsb.created_at as tgl_input','sppsb.id as id')
//                    ->where('sppsb.id',$key) ->get(); 
////            dd($sertifikat[0]->digitalSign);  
//            //cek apakah sertifikat sudah ditandatangai
//            if ($sertifikat[0]->digitalSign != 1)
//            {
//                
//                  $setInformasiSertifikat = $table_sppsb->where('sppsb.id', $key)
//                            ->update
//                            ([      
//                                    'usr_ttd' =>  Auth::user()->name,
//                                    'url_ttd' =>  Auth::user()->url_ttd,
//                                    'usr_jabatan' =>  Auth::user()->jabatan,
//                             ]);
//
//                $namaDinas                 = str_replace(" ", "-", $sertifikat[0]->pemilik_proyek);
//                $namaKontraktor       = str_replace(" ", "-", $sertifikat[0]->nama_kontraktor);
//                $BuatFolderSimpan   = 'SertifikatSuretyBondSign/' . date("Y") . '/' . date("m") . '/' . date("d").'/' . $namaDinas ;
//                $Buat                              = File::makeDirectory($BuatFolderSimpan, $mode = 0777, true, true);
//				//dd($Buat);
//                $PublicPath                   = public_path($BuatFolderSimpan);
//                $fileNameOri                 = $sertifikat[0]->no_jaminan . '-' . $namaKontraktor . '.pdf'; 
//                
//                $sppsb                             = $table_sppsb->leftJoin('users','users.id','=','sppsb.user_id')->where('sppsb.id',$key)->first();
//                $result                             = $table_result->where('sppsb_id',$key)->first();        
//
//                $selisih                            = $sppsb->durasi;
//                $nilaiProyek                  = ucwords($this->terbilang($sppsb->nilai_proyek));
//                $nilaiJaminan                = ucwords($this->terbilang($sppsb->nilai_jaminan));
//                $nilaiProyekFormat    = number_format($sppsb->nilai_proyek,2,",",".");
//                $nilaiJaminanFormat  = number_format($sppsb->nilai_jaminan,2,",",".");
//                $charge                            = number_format($result->service_charge,2,",",".");
//
//            //        dd($nilaiJaminanFormat);
//            //dd($sppsb);
//                if($sppsb->jenis_sppsb == '1'){
//                    $pathSppsb = 'report-sb.sertifikatpenawaran';
//                }elseif($sppsb->jenis_sppsb == '2'){
//                    $pathSppsb = 'report-sb.sertifikatpelaksanaan';
//                }elseif($sppsb->jenis_sppsb == '3'){
//                    $pathSppsb = 'report-sb.sertifikatuangmuka';
//                }elseif($sppsb->jenis_sppsb == '4'){
//                    $pathSppsb = 'report-sb.sertifikatpemeliharaan';
//                }elseif($sppsb->jenis_sppsb == '5'){
//                    $pathSppsb = 'report-sb.sertifikatpembayaran';
//                }elseif($sppsb->jenis_sppsb == '6'){
//                    $pathSppsb = 'report-sb.sertifikatsanggahbanding';
//                }
//
//                $pdf = PDF::loadView($pathSppsb, compact(
//                        'sppsb',
//                        'result',
//                        'selisih',
//                        'nilaiJaminan',
//                        'nilaiJaminanFormat',
//                        'charge')); 
// 
//                $pdf->setPaper('A4', 'portrait');
//                //menyimpan sertifikat hasil generate PDF
//                $pdf->save($PublicPath . '/' . $fileNameOri); 
//
//                $LokasiFolderSimpan = $sertifikat[0]->url; 
//            
//                $table_sppsb = db::CONNECTION('db_sb')->table('sppsb');
//                
//                $ubahUrlSertifikat = $table_sppsb->where('sppsb.id', $key)
//                                    ->update
//                                    ([
//                                            'url' => $BuatFolderSimpan . '/' . $fileNameOri,
//                                      ]); 
//                
//                $Datasertifikat         = $table_sppsb->where('sppsb.id', $key)->first(); 
////                    dd($Datasertifikat);
//                $lokasiSertifikat       = $Datasertifikat->url; 
//                //menjalankan modul tanda tangan BSSN/BsRE 
//                $esign                      = new BSrE_Esign_Cli(); 
//                $esign->setDocument(public_path() . '/' . $lokasiSertifikat);
//
//                // $esign->setDirOutput('/output', true);
//                //$esign->setSuffixFileName('');
//
//             $esign->setAppearance
//                        (
//                        $x = 480, $y = 45, $width = 330, $height = 320, $page = 1,
////                $spesimen = '',
//                        $spesimen = public_path() . '/example/spesimen/ttd1.png', $qr = null
//                ); 
//                
//                //proses tanda tangan
//                
////                   $hasil = $esign->sign(
////                        '30122019', //nik
////                        '#1234qwer*'    //passphrase
////                );
//                   
//                      $hasil = $esign->sign(
//                '5208051004930002', //nik
//                'Hend!4wandip@'    //passphrase
//        );
//
////                $hasil = $esign->sign(
////                        $request->nik, //nik
////                        $request->passphrase   //passphrase
////                );
//				 
//                //dd($esign);
//                //  echo  $lokasiSertifikat ;  
//                if (!$hasil) { 
//                        session::flash('pesan_error', $esign->error);
//                        return redirect('/DigitalSignSb');
//                } else {
//
//                    date_default_timezone_set("Asia/Jakarta");
//                    date('Y-m-d H:i:s',strtotime('+1 hour')); 
//                   // dd(Auth::user()->name);
//                    $fileNameSign = $sertifikat[0]->no_jaminan . '-' . $namaKontraktor . '_signed.pdf';
//                    
//                    $ubahKeteranganSertifikat = $table_sppsb->where('sppsb.id', $key)
//                            ->update
//                            ([
//                                    'url' => $BuatFolderSimpan . '/' . $fileNameSign,
//                                    'digitalSign' => '1',
//                                    'tgl_ttd' => date('Y-m-d H:i:s',strtotime('+1 hour ')),
//                                    'usr_ttd' =>  Auth::user()->name,
//                             ]);
//
//
////              echo 'Proses tanda tangan berhasil';
//
////                    $exists = Storage::disk('ftp')->exists($BuatFolderSimpan);
//                    //echo "<br>";
//                    // echo $BuatFolderSimpan;
//                    //dd($exists);
//                    //buat folder halo
////                    if ($exists != true) {
////                        //jika lokasi folder pada FTP server tidak ada, maka akan dibuat folder baru 
////                        Storage::disk('ftp')->makeDirectory($BuatFolderSimpan);
////                    }
////                             Storage::disk('ftp')
//                            //menyimpan File sesuai Folder FPT yang sudah dibuat
////                            ->put($BuatFolderSimpan . '/' . $fileNameSign,
//                            //mengambil File dari direktory loka yang akan dimasukkan ke folder FTP
////                              fopen($BuatFolderSimpan . '/' . $fileNameSign, 'r+'));
//
//                            //menghapus file pada Server Lokal (VPS)
////                            $hapusFileOri= unlink(public_path() . '/' . $BuatFolderSimpan . '/' . $fileNameOri);
////                            $hapusFileTTD= unlink(public_path() . '/' . $BuatFolderSimpan . '/' . $fileNameSign);
//
//                            session::flash('pesan_sukses',$jumlah_sertifikat);
//				  
//                }
//            }
//            $jumlah_sertifikat++;
//        }
//        return redirect('/DigitalSignSb');
//    }
    


//     public function TestingSingleSign(request $request) 
//     {
//         
//       $esign = new BSrE_Esign_Cli();
//         
////       dd($esign);
//             // mendapatkan nama berkas asli
//        $fileName = $request->file('file_ttd')->getClientOriginalName();
//        // mendapatkan ektensi berkas
//        $ekstensi = $request->file('file_ttd')->getClientOriginalExtension();
//        // mendapatkan ukuran berkas
//        $request->file('file_ttd')->getClientSize();
//        $NamaFile = md5($fileName) . '-' . $request->kodepembayaran . '.' . $ekstensi; 
//        $uploadedFile = $request->file('file_ttd');
//        $UploadFileTTD = $request->file('file_ttd')->move("files/ttd/", $NamaFile);
//         
//        $esign->setDocument(public_path() . '/files/ttd/' . $NamaFile); 
//              
////          $esign->setDirOutput('/output', true);
////          $esign->setSuffixFileName('');
//
//                $esign->setAppearance
//                        (
//                        $x = 60, $y = 45, $width = 230, $height = 320, $page = 1, 
//                        $spesimen = public_path() . '/example/spesimen/ttd1.png', 
//                        $qr = null
//                     );
//
//                $hasil = $esign->sign(
//	  '30122019',   //nik
//                         '#4321qwer*'    //passphrase
//                      
//                );
//      
//                
//                if (!$hasil) {
//                    echo $esign->getError();
//                } else {
//                    
//                        session::flash('pesan', 'Sertifikat berhasil di tandatangani secara digital');
//                }
//        return redirect('/SingleDigitalSign'); 
//    }
//    
     public function TestingSingleSign(request $request) 
     { 
         
//            dd($full_path_source);
         
          if($request->hasFile('file_ttd')) {
          
              $filenamewithextension = $request->file('file_ttd')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('file_ttd')->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename . '_' . uniqid() . '.' . $extension;
            $fileinternal = 'internal.pdf';
  
             //cek apakah folder halo ada
             $exists = Storage::disk('ftp')->exists('halo');  
                
              //buat folder halo
                if ($exists!=true){
                                   Storage::disk('ftp')->makeDirectory('halo'); 
                } 
            
                Storage::disk('ftp')->put('/halo/'.$filenametostore, fopen($request->file('file_ttd'), 'r+'));
//                Storage::disk('ftp')->put('/halo/'.$fileinternal, fopen('Sertifikat/test.pdf', 'r+')); 
 
        }
      
 
        //Store $filenametostore in the database
    }
    
//    public function testingsign(request $request) 
//    {
//          
//        $sertifikat = penjaminans::where('penjaminans.idpenjaminan', $request->idpenjaminan)
//                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
//                ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
//                ->leftJoin('users', 'users.idbank', '=', 'banks.idbank')
//                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
//                ->get();
//       
//        $namabank           = str_replace(" ", "-", $sertifikat[0]['namabank']);
//        $namaTerjamin       = str_replace(" ", "-", $sertifikat[0]['nama']);
//        
//            
//        
//        $BuatFolderSimpan   = 'Sertifikat/' . $namabank . '/' . date("Y") . '/' . date("m") . '/' . date("d");
//        File::makeDirectory($BuatFolderSimpan, $mode = 0777, true, true);
//          
//        $PublicPath         = public_path($BuatFolderSimpan);
//        $fileName           = $sertifikat[0]['kodesertifikat'].'-'.$namaTerjamin. '.pdf';
//        
//        
//        
//        if($sertifikat[0]['level']=='koperasi')
//         {
//            $pdf = PDF::loadView('user.laporan.sertifikatKoperasi', compact('sertifikat'));
//         }
//         else
//         {
//            $pdf = PDF::loadView('user.laporan.sertifikat', compact('sertifikat'));
// 
//         }
//        
//        $pdf->setPaper('A4', 'portrait');
//        $pdf->save($PublicPath . '/' . $fileName);
//          
////        $sertifikat = penjaminans::where('idpenjaminan', $request->idpenjaminan)
////                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
////                ->leftJoin('banks', 'pembayarans.idbank', '=', 'banks.idbank')
////                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
////                ->first();
//     
//            
//        $LokasiFolderSimpan   = $sertifikat[0]['url'];  
//        if($LokasiFolderSimpan==null)
//        {
//            $ubahsertifikat = sertifikats::where('idpenjaminan', $request->idpenjaminan)
//            ->update
//            ([
//                'url' => $BuatFolderSimpan.'/'.$fileName,
//            ]);
//        }
//        
//        
//        $namaTerjamin= str_replace(" ", "-", $sertifikat[0]['nama']);
//        $Datasertifikat = sertifikats::where('idpenjaminan', $request->idpenjaminan)->first();
//            
////        $PublicPath           = public_path($LokasiFolderSimpan);
////        $fileName             = $sertifikat->kodesertifikat.'-'.$namaTerjamin.'.pdf';
////     
//            
//        $esign = new BSrE_Esign_Cli();
//        $esign->setDocument(public_path() . '/'.$Datasertifikat->url);
////        dd($LokasiFolderSimpan);
//        
////      $esign->setDirOutput('/output', true);
////$esign->setSuffixFileName('');
//
//        $esign->setAppearance
//        (
//                $x = 60, 
//                $y = 45,
//                $width = 230, 
//                $height = 320, 
//                $page = 1,
////                $spesimen = '',
//                $spesimen = public_path() . '/example/spesimen/ttd1.png',
//                $qr = null
//        );
//
////        $hasil = $esign->sign(
////                '30122019', //nik
////                '12345678'    //passphrase
////        );
//        
//        //teting developer
//        $hasil = $esign->sign(
//                '30122019', //nik
//                '12345678'  //passphrase
//        );
//           
//        if (!$hasil)
//        {
//            echo $esign->getError(); 
//        } 
//        else
//        {
//             $fileName           = $sertifikat[0]['kodesertifikat'].'-'.$namaTerjamin. '_signed.pdf';
//             $ubahsertifikat = sertifikats::where('idpenjaminan', $request->idpenjaminan)
//            ->update
//            ([
//                'url'           => $BuatFolderSimpan.'/'.$fileName,
//                'digitalSign'   => '1',
//            ]);
//            
//            unlink(public_path() . '/'.$Datasertifikat->url);
////            echo 'Proses tanda tangan berhasil';
//              session::flash('pesan', 'Sertifikat berhasil di tandatangani secara digital');
//             return redirect('/DigitalSign');
//        }   
//           
//       
//       
//        
//        
////        $hasil = $esign->verifikasi(public_path().'/output/example_signed.pdf');
////
////        if (!$hasil)
////            echo $esign->getError();
////        else
////            echo "<pre>";
////        print_r($hasil);
////        echo"</pre>";
//    }

    public function post_app_direksi(Request $request) {
        
        if($request->approval=='SETUJU'){
            $app='CaseSetuju';
        }else{
            $app='CaseTolak';
        }
        $penjaminan = penjaminans::where('idpenjaminan', $request->idpenjaminan)
                ->update([
                    'app' => $app,
                    'tanggapandir' => $request->tanggapan,
                 ]);
        $this->CreateHistoryApproval($request,$app);
        $success_output = 'Penjaminan telah dikirim ke Analis';
        $output = array(
            'success' => $success_output,
        );
        echo json_encode($output);
        
           $users = User::where('level', 'admin')->get();
           foreach ($users as $data) {
           Mail::send('emails.welcome', ['name' => 'Office'], function ($message) use ($data) {
                $message->to($data->email)->cc('it.dev@gmail.com')->subject('Aplikasi Penjaminan Kredit - Approval Direksi');
            });
           }
        
    }
    
     protected function CreateHistoryApproval($request,$app)
    {
        date_default_timezone_set("Asia/Jakarta");
        date('Y-m-d H:i:s',strtotime('+1 hour'));
        history_apps::create([
                           'analisa'       => $request->tanggapan,
                           'approval'       => $app,
                           'tgl_analisa'    =>  date('Y-m-d H:i:s',strtotime('+1 hour')),
                           'user'           => Auth::user()->id,
                           'idpenjaminan'   => $request->idpenjaminan,
//                           'komputer'       => gethostname(),
              ]);
        
    }
   
       function terbilang($x) {
        if ($x < 0) {
            $hasil = "minus " . trim(konversi(x));
        } else {
            $poin = trim($this->tkoma($x));
            $hasil = trim($this->konversi($x));
        }

        if ($poin) {
            $hasil = $hasil . " Rupiah " . $poin." Sen";
        } else {
            $hasil = $hasil." Rupiah";
        }
        return $hasil;
    }
       function konversi($x) {

        $x = abs($x);
        $angka = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";

        if ($x < 12) {
            $temp = " " . $angka[$x];
        } else if ($x < 20) {
            $temp = $this->konversi($x - 10) . " belas";
        } else if ($x < 100) {
            $temp = $this->konversi($x / 10) . " puluh" . $this->konversi($x % 10);
        } else if ($x < 200) {
            $temp = " seratus" . $this->konversi($x - 100);
        } else if ($x < 1000) {
            $temp = $this->konversi($x / 100) . " ratus" . $this->konversi($x % 100);
        } else if ($x < 2000) {
            $temp = " seribu" . konversi($x - 1000);
        } else if ($x < 1000000) {
            $temp = $this->konversi($x / 1000) . " ribu" . $this->konversi($x % 1000);
        } else if ($x < 1000000000) {
            $temp = $this->konversi($x / 1000000) . " juta" . $this->konversi($x % 1000000);
        } else if ($x < 1000000000000) {
            $temp = $this->konversi($x / 1000000000) . " milyar" . $this->konversi($x % 1000000000);
        }

        return $temp;
    }
       function tkoma($x) {
  
     
        $str = stristr($x, ".");
        $ex = explode('.', $x);
       
          
//        echo $ex[1];
//        dd($ex[1]);
//     echo $ex[1] ;
            if(isset($ex[1])){
            $nilai = $ex[1] / 10;
            if ($nilai >= 1) {
                $a = abs($ex[1]);
            }else{
                 $a = 0;
            }
            
//dd($x);

            $string = array("nol", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
            $temp = "";

            $a2 = $ex[1] / 10;
            $pjg = strlen($str);
            $i = 1;


            if ($a >= 1 && $a < 12) {
                $temp .= " " . $string[$a];
            } else if ($a > 12 && $a < 20) {
                $temp .= $this->konversi($a - 10) . " ";
            } else if ($a > 20 && $a < 100) {
                $temp .= $this->konversi($a / 10) . " " . $this->konversi($a % 10);
            } else {
                if ($a2 < 1) {

                    while ($i < $pjg) {
                        $char = substr($str, $i, 1);
                        $i++;
                        $temp .= " " . $string[$char];
                    }
                }
            } 
             return $temp;
        }
       
    }
    
    
    
function enkripsi( $string )
{
    $output = false;
 
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'bismillahirrahmanirrahim';
    $secret_iv = 'bismillahirrahmanirrahim';
 
    // hash
    $key = hash('sha256', $secret_key);
     
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
 
    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);
 
    return $output;
}
 
function dekripsi($string)
{
    $output = false;
 
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'bismillahirrahmanirrahim';
    $secret_iv = 'bismillahirrahmanirrahim';
 
    // hash
    $key = hash('sha256', $secret_key);
     
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
 
    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
 
    return $output;
}

function tgl_indo($tanggal)
{
    $bulan = array (1 =>   'Januari',
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
    $split = explode('-', $tanggal);
    return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
}

public function CariSertifikatSign(request $request) {

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
                    ->limit(10)
                    ->get();
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
                    ->limit(10)
                    ->get();
        }


        return view('admin.cek.digitalSign', ['pengajuan' => $pengajuan]);
    }
public function CariSertifikatSignSB(request $request) 
   {
         $table_sppsb = db::CONNECTION('db_sb')->table('sppsb');
         $table_result = db::CONNECTION('db_sb')->table('results');
           if ($request->jenis == 'kodesertifikat') {
                  $sppsb = $table_sppsb->select('*','sppsb.created_at as tgl_input','sppsb.id as id')
                  ->leftJoin('users','users.id','=','sppsb.user_id')
                  ->where('sppsb.no_jaminan', 'like', '%' . $request->data . '%')
//                   ->limit(5)
                  ->orderby('sppsb.id','desc')->get(); 
           }else{
                  $sppsb = $table_sppsb->select('*','sppsb.created_at as tgl_input','sppsb.id as id')
                  ->leftJoin('users','users.id','=','sppsb.user_id')
                   ->where('sppsb.nama_kontraktor', 'like', '%' . $request->data . '%')
//                   ->limit(5)
                  ->orderby('sppsb.id','desc')->get(); 
           }

//           dd($sppsb);
          return view('admin.cek.digitalSignSb', ['pengajuan' => $sppsb]);
       }
      
}
