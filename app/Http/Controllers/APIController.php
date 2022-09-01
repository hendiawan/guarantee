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
 use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\t_history_banks;
ini_set('memory_limit', '512M');
/**
 * Description of BlogController
 *
 * @author ASUS
 */
class APIController extends Controller {
  
    public function __construct() {
//        $this->middleware('auth');
        $this->middleware('auth.api');
//         $this->middleware('guest:api') ;
    }
    
    public function tanggal($tgl) {
        $data = explode("/", $tgl);
        $isi = "$data[2]-$data[1]-$data[0]";
        return $tgl = date('Y-m-d', strtotime($isi));
    }
    
    
    public function sertifikatTerbitById($id) 
    {
                  $pengajuan = penjaminans:: select('*','penjaminans.dis')
                    ->where('penjaminans.idpenjaminan',$id)
                    ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                    ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                    ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                    ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                    ->leftJoin('users', 'users.name', '=', 'sertifikats.diterbitkan')
                    ->first();
//            dd($pengajuan);
         echo json_encode($pengajuan);
     }
     public function dataSertifikatTerbitPerbank($id,$daritgl,$sampaitgl2) 
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
     
     
     public function test() { 
                $dari           =date('Y-1-1');
                $sampai     =date('Y-1-30'); 
                $client        =new \GuzzleHttp\Client();  
                $response   = $client->get( "https://penjaminan.jamkridantb.com/get-sertifikat/$dari/$sampai",[
                                'headers' => [ 
                                  'Authorization' => "Bearer allahuakbar" 
                              ]
                ]); 

                $request        = $response->getBody(); 
                 $dataweb      = json_decode($request, true);
            //Json ke array
                $ArrayPengajuan = json_decode($request, true);
                $array_sertifikat = array(); 
               foreach ($ArrayPengajuan as $data => $value) {
                   $Penjaminan = (object) $value;
                   $array_sertifikat[] =  $Penjaminan->kodesertifikat.'( '.($Penjaminan->nama).' )';
               }

               $kalimat = implode("|",$array_sertifikat); 
               return  $kalimat; 
    }
     
     public function updateStatusSinkronisasi($id) 
     {
            date_default_timezone_set("Asia/Jakarta");
            date('Y-m-d H:i:s',strtotime('+1 hour'));   
            $data = sertifikats::where('sertifikats.idpenjaminan',$id)
                       ->update([
                           'sertifikats.sinkronisasi'=>'Y',
                           'tgl_sink'                               => date('Y-m-d H:i:s',strtotime('+1 hour')),
                           ]);   
             $msg = [
                 'status'=>'Success Updated !',
             ];                 
             echo json_encode($msg);                
     }
     
      public function groupSertifikatByBank($dariTgl,$sampaiTgl) 
      {
    
            $dari           = date('Y-m-d',strtotime($dariTgl));
            $sampai     = date('Y-m-d 23:59:59.000',strtotime($sampaiTgl));
    
    //        dd($sampai);
           $DataPenjaminan = penjaminans:: 
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
                echo json_encode($DataPenjaminan);
        }
        
    public function findSertifikat(Request $request) 
    { 

                  $sertifikat =$request->nomor_sertifikat;
//                dd($request);
//                         $sertifikat ='02.0004.12.08.01.08.2021';

                   $pengajuan = penjaminans:: select('*','penjaminans.dis')
                     ->where('sertifikats.kodesertifikat',$sertifikat)
                     ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                     ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                     ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                     ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                     ->leftJoin('users', 'users.name', '=', 'sertifikats.diterbitkan')
                     ->first(); 
          echo json_encode($pengajuan);
      }
      
      public function postSertifikatWeb(request $request) 
      { 
//                  dd($request->nomor_sertifikat);
                $client = new \GuzzleHttp\Client(); 
                //mengakses dari endpoint web penjaminan
                $response = $client->post( "https://penjaminan.jamkridantb.com/find-sertifikat",[
                                'headers' => [ 
                                  'Authorization' => "Bearer allahuakbar" 
                              ],
                                'form_params' => [ 
                                       'no_sertifikat' => $request->nomor_sertifikat
                              ]
                ]);
                $request = $response->getBody();
                //proses konversi data penjaminan Json Ke Array
                $ArrayPengajuan = json_decode($request, true);
                //proses konversi Array ke Object
                $ObejctPengajuan = (object) $ArrayPengajuan; 
                $sertifikat              = $ObejctPengajuan; 
                dd($sertifikat);
        
     }
     
      public function showToken() {
         echo csrf_token(); 
//         echo csrf_token(); 
    }
    
   
    //akan diletakkan pada APIController  VPSsign
    public function prosesSignKreditById(request $request)  { 
            $key    = $request->penjaminan_id; 
//            dd($request->passphrase);
            //update informasi sertifikat, siapa yang melakukan tanda tangan
             $userttd = [
                                     'usr_ttd' =>   'Lalu Taufik Mulyajati',
                                     'jabatan' =>  'Direktur Utama',      
                                     'url_ttd' =>    'ttd_taufik.jpg',      
                    ]; 
            $update_sertifikat = sertifikats::where('idpenjaminan', $key)
                            ->update
                            ([  
                                    'usr_ttd' =>  $userttd['usr_ttd'],
                                    'jabatan' =>  $userttd['jabatan'],
                                    'url_ttd'  =>   $userttd['url_ttd'],
                             ]);       
            $sertifikat = penjaminans::where('penjaminans.idpenjaminan', $key)
                    ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                    ->leftJoin('banks', 'penjaminans.idbank', '=', 'banks.idbank')
                    ->leftJoin('users', 'users.idbank', '=', 'banks.idbank')
                    ->leftJoin('t_history_banks', 'banks.idbank', '=', 't_history_banks.bank_id')
                    ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                    ->get();
//            dd($userttd['usr_ttd']);
            //cek apakah sertifikat sudah ditandatangai
            if ($sertifikat[0]['digitalSign'] != 1)
                           
                {
                $namabank                   = str_replace(" ", "-", $sertifikat[0]['namabank']);
                $namaTerjamin           = str_replace(" ", "-", $sertifikat[0]['nama']);
                $BuatFolderSimpan   = 'SertifikatPenjaminanKreditSign/' . date("Y") . '/' . date("m") . '/' . date("d"). '/' . $namabank . '/' ;
                $Buat                                = File::makeDirectory($BuatFolderSimpan, $mode = 0777, true, true); 
                $PublicPath                   = public_path($BuatFolderSimpan);
                $fileNameOri                = $sertifikat[0]['kodesertifikat'] . '-' . $namaTerjamin . '.pdf';  
                
                //kondisi untuk memilih sertifikat
                if ($sertifikat[0]['level'] == 'koperasi') {
                    $pdf = PDF::loadView('user.laporan.sign.autosign.sertifikatKoperasi', compact('sertifikat','userttd'));
                } else {
                    $pdf = PDF::loadView('user.laporan.sign.autosign.sertifikat', compact('sertifikat','userttd'));
                }
                
                $pdf->setPaper('A4', 'portrait');
                //menyimpan sertifikat hasil generate PDF
                $pdf->save($PublicPath . '/' . $fileNameOri);  
                $LokasiFolderSimpan = $sertifikat[0]['url'];
                
                if ($LokasiFolderSimpan == null) {
                    $ubahsertifikat = sertifikats::where('idpenjaminan', $key)
                            ->update
                            ([
                                 'url' => $BuatFolderSimpan . '/' . $fileNameOri,
                            ]);
                }
 
                $namaTerjamin = str_replace(" ", "-", $sertifikat[0]['nama']);
                $Datasertifikat = sertifikats::where('idpenjaminan', $key)->first();
                                
                //menjalankan modul tanda tangan BSSN/BsRE 
                $esign = new BSrE_Esign_Cli();
                if ($esign->directoryName == false) {
                    // jika lokasi direktory sertifikat tidak ditemukan, maka
                    //akan di ambil lokasi sertifikat baru
                    $lokasiSertifikat = $BuatFolderSimpan . '/' . $fileNameOri;
                } else {
                    // jika lokasi direktory sertifikat  ditemukan, maka
                    //akan di ambil lokasi saat penerbitan sertifikat (Saat penerbitan sertifikat oleh staff)
                    $lokasiSertifikat = $Datasertifikat->url;
                }
               
                $esign->setDocument(public_path() . '/' . $lokasiSertifikat);

            //      $esign->setDirOutput('/output', true);
            //          $esign->setSuffixFileName('');

                $esign->setAppearance
                (
                        $x = 60,
                        $y = 45, 
                        $width = 230,
                        $height = 320, 
                        $page = 1,
//                $spesimen = '',
                        $spesimen = public_path() . '/example/spesimen/ttd1.png',
                        $qr = null
                );

                        $hasil = $esign->sign(
                                '5208051004930002', //nik
                                'Hend!4wandip@'    //passphrase
                        ); 

//                $hasil = $esign->sign(
//                        $request->nik, //nik
//                        $request->passphrase   //passphrase
//                );  
                            if (!$hasil) { 
                                    $pesan = $esign->error; 
                                    $status =400;
                            } else {
                                  $pesan = "File Berhasil di tandatangani";
                                   $status =200; 
                                   date_default_timezone_set("Asia/Jakarta");
                                   date('Y-m-d H:i:s',strtotime('+1 hour')); 
                                   // dd(Auth::user()->name);
                                    $fileNameSign = $sertifikat[0]['kodesertifikat'] . '-' . $namaTerjamin . '_signed.pdf';
                                    $ubahsertifikat = sertifikats::where('idpenjaminan', $key)
                                    ->update
                                    ([
                                            'url' => $BuatFolderSimpan . '/' . $fileNameSign,
                                            'digitalSign' => '1',
                                            'tgl_ttd' => date('Y-m-d H:i:s',strtotime('+1 hour ')),
                                            'usr_ttd' =>  $userttd['usr_ttd'],
                                     ]); 			  
                            }
                            
            }
            else
                {
                $pesan = "Sertfikat sudah di ttd "; 
                $status =200;
            } 
            
            $info=[
                'msg'=>$pesan,
                'status'=>$status
            ];
             echo json_encode($info);
    } 
     //akan diletakkan pada client web Penjaminan ( method ini akan mengeksekusi method prosesSignKreditById pada VPS)
   public function  signKreditFromCloud($penjaminan_id,$nik,$passphrase){
                $client = new \GuzzleHttp\Client();  
//                $response = $client->post( "https://sign.jamkridantb.com/proses-sign",[
                $response = $client->post( "localhost:8088/proses-sign",[
                                'headers' => [ 
                                      'Authorization' => "Bearer allahuakbar" 
                              ],
                                'form_params' => [ 
                                       'penjaminan_id' => $penjaminan_id,
                                       'nik'                        => $nik,
                                       'passphrase'       => $passphrase,
                              ]
                ]);
                $request                        = $response->getBody();   
                $ArrayPengajuan      = json_decode($request, true); 
                $ObejctPengajuan     = (object) $ArrayPengajuan; 
                return $sign               = $ObejctPengajuan; 
    } 
    
   //akan diletakkan pada  APIController  VPSsign
   public function signsbById(request $request) 
   {
//        dd($request); 
          $key = $request->sppsb_id; 
//          dd($key);  
          $table_sppsb = db::CONNECTION('db_sb')->table('sppsb');
          $table_result = db::CONNECTION('db_sb')->table('results'); 
          $sertifikat = $table_sppsb->select('*','sppsb.created_at as tgl_input','sppsb.id as id')
                    ->where('sppsb.id',$key) ->get();  
//            dd($sertifikat);  
            //cek apakah sertifikat sudah ditandatangai
            if ($sertifikat[0]->digitalSign != 1)
            { 
                   $userttd = [
                                     'usr_ttd' =>   'Lalu Taufik Mulyajati',
                                     'jabatan' =>  'Direktur Utama',      
                                     'url_ttd' =>    'ttd_taufik.jpg',      
                    ];
              
                  $setInformasiSertifikat = $table_sppsb->where('sppsb.id', $key)
                            ->update
                            ([      
                                    'usr_ttd' =>   $userttd['usr_ttd'],
                                    'url_ttd' =>  $userttd['url_ttd'],
                                    'usr_jabatan' =>  $userttd['jabatan'],
                             ]);

                $namaDinas                 = str_replace(" ", "-", $sertifikat[0]->pemilik_proyek);
                $namaKontraktor      = str_replace(" ", "-", $sertifikat[0]->nama_kontraktor);
                $BuatFolderSimpan  = 'SertifikatSuretyBondSign/' . date("Y") . '/' . date("m") . '/' . date("d").'/' . $namaDinas ;
                $Buat                               = File::makeDirectory($BuatFolderSimpan, $mode = 0777, true, true); 
                $PublicPath                  = public_path($BuatFolderSimpan);
                $fileNameOri               = $sertifikat[0]->no_jaminan . '-' . $namaKontraktor . '.pdf'; 
                
                $sppsb                             = $table_sppsb->leftJoin('users','users.id','=','sppsb.user_id')->where('sppsb.id',$key)->first();
                $result                             = $table_result->where('sppsb_id',$key)->first();        
                 
                $adminController      = new AdminController();
                $selisih                           = ucwords($adminController->terbilang($sppsb->durasi));
                
                $direksiController      = new DireksiController();
                
                $nilaiProyek                  = ucwords($direksiController->terbilang($sppsb->nilai_proyek));
                $nilaiJaminan                = ucwords($direksiController->terbilang($sppsb->nilai_jaminan));
                $nilaiProyekFormat   = number_format($sppsb->nilai_proyek,2,",",".");
                $nilaiJaminanFormat = number_format($sppsb->nilai_jaminan,2,",",".");
                $charge                            = number_format($result->service_charge,2,",",".");

            //        dd($nilaiJaminanFormat);
            //dd($sppsb);
                if($sppsb->jenis_sppsb == '1'){
                        $pathSppsb = 'report-sb.autosign.sertifikatpenawaran';
                }elseif($sppsb->jenis_sppsb == '2'){
                        $pathSppsb = 'report-sb.autosign.sertifikatpelaksanaan';
                }elseif($sppsb->jenis_sppsb == '3'){
                        $pathSppsb = 'report-sb.autosign.sertifikatuangmuka';
                }elseif($sppsb->jenis_sppsb == '4'){
                        $pathSppsb = 'report-sb.autosign.sertifikatpemeliharaan';
                }elseif($sppsb->jenis_sppsb == '5'){
                        $pathSppsb = 'report-sb.autosign.sertifikatpembayaran';
                }elseif($sppsb->jenis_sppsb == '6'){
                        $pathSppsb = 'report-sb.autosign.sertifikatsanggahbanding';
                }

                $pdf = PDF::loadView($pathSppsb, compact(
                        'sppsb',
                        'userttd',
                        'result',
                        'selisih',
                        'nilaiJaminan',
                        'nilaiJaminanFormat',
                        'charge')); 
 
                $pdf->setPaper('A4', 'portrait');
                //menyimpan sertifikat hasil generate PDF
                $pdf->save($PublicPath . '/' . $fileNameOri); 

                $LokasiFolderSimpan = $sertifikat[0]->url; 
            
                $table_sppsb = db::CONNECTION('db_sb')->table('sppsb');
                
                $ubahUrlSertifikat = $table_sppsb->where('sppsb.id', $key)
                    ->update
                    ([
                            'url' => $BuatFolderSimpan . '/' . $fileNameOri,
                      ]); 
                
                $Datasertifikat         = $table_sppsb->where('sppsb.id', $key)->first(); 
//                    dd($Datasertifikat);
                $lokasiSertifikat       = $Datasertifikat->url; 
                //menjalankan modul tanda tangan BSSN/BsRE 
                $esign                      = new BSrE_Esign_Cli(); 
                $esign->setDocument(public_path() . '/' . $lokasiSertifikat);

                // $esign->setDirOutput('/output', true);
                //$esign->setSuffixFileName('');

             $esign->setAppearance
                        (
                        $x = 480, $y = 45, $width = 330, $height = 320, $page = 1,
//                $spesimen = '',
                        $spesimen = public_path() . '/example/spesimen/ttd1.png', $qr = null
                ); 
                
                //proses tanda tangan
                      $hasil = $esign->sign(
                                '5208051004930002', //nik
                                'Hend!4wandip@'    //passphrase
                    );
//                $hasil = $esign->sign(
    //                        $request->nik, //nik
    //                        $request->passphrase   //passphrase
//                );
				 
                //dd($esign);
                //  echo  $lokasiSertifikat ;  
                if (!$hasil) { 
                     $pesan = $esign->error; 
                     $status =400;
                 } else {
                     $pesan = "File Berhasil di tandatangani";
                     $status =200; 

                    date_default_timezone_set("Asia/Jakarta");
                    date('Y-m-d H:i:s',strtotime('+1 hour')); 
                   // dd(Auth::user()->name);
                    $fileNameSign = $sertifikat[0]->no_jaminan . '-' . $namaKontraktor . '_signed.pdf';
                    
                    $ubahKeteranganSertifikat = $table_sppsb->where('sppsb.id', $key)
                    ->update
                    ([
                            'url' => $BuatFolderSimpan . '/' . $fileNameSign,
                            'digitalSign' => '1',
                            'tgl_ttd' => date('Y-m-d H:i:s',strtotime('+1 hour ')),
                            'usr_ttd' =>     $userttd['usr_ttd'],
                     ]);


//              echo 'Proses tanda tangan berhasil';

//                    $exists = Storage::disk('ftp')->exists($BuatFolderSimpan);
                    //echo "<br>";
                    // echo $BuatFolderSimpan;
                    //dd($exists);
                    //buat folder halo
//                    if ($exists != true) {
//                        //jika lokasi folder pada FTP server tidak ada, maka akan dibuat folder baru 
//                        Storage::disk('ftp')->makeDirectory($BuatFolderSimpan);
//                    }
//                             Storage::disk('ftp')
                            //menyimpan File sesuai Folder FPT yang sudah dibuat
//                            ->put($BuatFolderSimpan . '/' . $fileNameSign,
                            //mengambil File dari direktory loka yang akan dimasukkan ke folder FTP
//                              fopen($BuatFolderSimpan . '/' . $fileNameSign, 'r+'));

                            //menghapus file pada Server Lokal (VPS)
//                            $hapusFileOri= unlink(public_path() . '/' . $BuatFolderSimpan . '/' . $fileNameOri);
//                            $hapusFileTTD= unlink(public_path() . '/' . $BuatFolderSimpan . '/' . $fileNameSign);
 			  
                }
                        $info=[
                           'msg'    =>$pesan,
                           'status'=>$status
                       ];
            }else{
                        $info=[
                           'msg'=>"Sertifikat sudah di TTD",
                           'status'=>200
                       ];
            } 
            echo json_encode($info);
   
    } 
    
     //akan diletakkan pada client web Penjaminan ( method ini akan mengeksekusi method prosesSignKreditById pada VPS)
    public function  signSbFromCloud($sppsb_id,$nik,$passphrase)
    {
         
                $client = new \GuzzleHttp\Client();  
                $response = $client->post( "https://sign.jamkridantb.com/proses-sign-sb",[
                                'headers' => [ 
                                      'Authorization' => "Bearer allahuakbar" 
                              ],
                                'form_params' => [ 
                                       'sppsb_id'             => $sppsb_id,
                                       'nik'                        => $nik,
                                       'passphrase'       => $passphrase,
                              ]
                ]);
                
                
//                 dd($sppsb_id); 
                 
                $request = $response->getBody();  
                $ArrayPengajuan = json_decode($request, true); 
                $ObejctPengajuan = (object) $ArrayPengajuan; 
                return $sign            = $ObejctPengajuan; 
    }
      
    public function dataSertifikatTerbitAll($daritgl,$sampaitgl2) 
    {
             $sampaitgl2 = date ('Y-m-d 23:59:59.000',strtotime($sampaitgl2));
//        dd($sampaitgl2);
            $pengajuan = penjaminans::
                whereBetween('tglterbit', array($daritgl,$sampaitgl2))
                ->whereNotIn('sertifikats.sinkronisasi',['Y']) 
//                ->Where('penjaminans.idbank',$id)
                ->wherein('penjaminans.app',['Lunas','Cetak']) 
                ->leftJoin('banks', 'banks.idbank', '=', 'penjaminans.idbank')
                ->leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftJoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->orderBy('banks.idbank', 'desc')
//                ->take(1000)
                ->get(); 
         echo json_encode($pengajuan);
     }
     
    public function autoSinkronisasiData() {
         
                    $dari           = date('Y-m-1');
                    $sampai     = date('Y-m-t'); 
                    $client        = new \GuzzleHttp\Client();  
                    $response = $client->get( "https://penjaminan.jamkridantb.com/get-sertifikat/$dari/$sampai",[
                                    'headers' => [ 
                                      'Authorization' => "Bearer allahuakbar" 
                                  ]
                    ]); 
                    $request                    = $response->getBody(); 
                    $dataweb                  = json_decode($request, true);
                    //Json ke array
                    $ArrayPengajuan  = json_decode($request, true);
                    $array_sertifikat    = array(); //--->digunakan untuk menampung data sertifikat
                    $SinkronisasiData = new ExportController();

                    foreach ($ArrayPengajuan as $data => $value) {
                        $Penjaminan                 = (object) $value; 
                        $SinkronisasiData->SinkronisasiDataSertifikatFromCloud($Penjaminan->idpenjaminan);
                        $array_sertifikat[]      =  $Penjaminan->kodesertifikat.'( '.($Penjaminan->nama).' )';
                    }   
                    
                     // menggabungkan isi array menjadi string
                    $kalimat = implode("|",$array_sertifikat); 
                    
                    if($kalimat){
                        $this->sendMessageTelegramBot($kalimat);
                    }
                    return  "Sukses sinkronisasi data ". $kalimat;                     
//                  return  "Sukses !!!"; 
    }
    
    public function showSertifikatSb(){ 
         
            $dari           = date('Y-m-1');
            $sampai     = date('Y-m-t'); 
            $table_sppsb = DB::CONNECTION('db_sb')->table('v_report_export'); 
            $sppsb = $table_sppsb
                                   ->select('v_report_export.*')  
                                   ->whereNotIn('v_report_export.sink',['Y']) 
                                   ->whereBetween('v_report_export.created_at', array($dari,$sampai))
                                   ->where('v_report_export.status', 'C')
                                   ->orderby('v_report_export.id', 'ASC')
                                   ->get(); 
            
         return   $datasb = json_encode($sppsb); 
//        dd($datasb);
    }
    
    public function autoSinkronisasiDataSb() {
                    $dari           = date('Y-m-1');
                    $sampai     = date('Y-m-t'); 
                    $client        = new \GuzzleHttp\Client();  
                    $response = $client->get( "https://penjaminan.jamkridantb.com/show-sertifikat-sb",[
                                    'headers' => [ 
                                      'Authorization' => "Bearer allahuakbar" 
                                  ]
                    ]); 
                    $request                       = $response->getBody();  
                    $ArrayPengajuan     = json_decode($request, true);
//                         dd($ArrayPengajuan);
                    //Json ke array 
                    $array_sertifikat    = array(); //--->digunakan untuk menampung data sertifikat
                    $SinkronisasiData = new ExportController(); 
                    foreach ($ArrayPengajuan as $data => $value) {
                                $Penjaminan                 = (object) $value;  
                                $array_sertifikat[]      =  $SinkronisasiData->SinkronisasiDataSbFromCloud($Penjaminan); 
                           
                    }    
                     // menggabungkan isi array menjadi string
                    $string_informasi = implode("|",$array_sertifikat); 
                    if($string_informasi){
                        $this->sendMessageTelegramBot($string_informasi);
                    }
                    
                    return   $string_informasi;   
    }
    
    public function updateStatusSb($sppsb_id){
            $data = DB::CONNECTION('db_sb')->table('sppsb')->where('sppsb.id',$sppsb_id)->update(['sppsb.sink'=>'Y']);
            if($data){$msg = ['status'=>'Success Updated !',];}else{$msg= ['status'=>'Failed Updated !!!',];}
            echo json_encode($msg); 
    }
    
    public  function updateStatusSbFromCloud($sppsb_id){
                     $client         = new \GuzzleHttp\Client();  
                               $response  = $client->get( "https://penjaminan.jamkridantb.com/update-status-sink-sb/$sppsb_id",[
                                        'headers' => [ 
                                             'Authorization' => "Bearer allahuakbar" 
                                        ]
                        ]); 
    }


    public function  sendMessageTelegramBot($pesan){
        
        $token = "1977822334:AAEXQuaqFh10uV-r0PebN9chDZ2NrhlWiRQ"; // token bot
        $data = [
            'text' => "$pesan",
            'chat_id' => '887489020'  //contoh bot, chat_id Telegram Hendiawan Dipa
        ];
        $data = file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data));
//        dd($data);
    }
    
  
    
}
