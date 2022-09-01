<?php

namespace App\Http\Controllers;
use App\users;
use App\penjaminans;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\DireksiController;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
//use Illuminate\Support\Facades\Storage;
use Storage;
use Response;
use App\sertifikats;

class VerifyController extends Controller {
 
    public function verify($id) {
        
        $sertifikat = penjaminans::leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftjoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('banks', 'pembayarans.idbank', '=', 'banks.idbank')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->where('sertifikats.verify', $id)
                ->first();
        if($sertifikat){
              return view('verify.detail',compact('sertifikat'));
        }else{
              return   redirect('/Not Found');
        }
      
        
    }
    
      public function detail($id)
      {
        $id= dekripsi($id);
        $table_sppsb = db::CONNECTION('db_sb')->table('sppsb');
        $table_result = db::CONNECTION('db_sb')->table('results');

        $sppsb = $table_sppsb->leftJoin('users', 'users.id', '=', 'sppsb.user_id')->where('sppsb.id', $id)->first();
      
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

        return view('verify.detailsppsb', compact(
                'sppsb',
                'agen',
                'dokPendukung',
                'brgAgunan',
                'nilaiProyek',
                'nilaiJaminan',
                'history',
                'charge',
                'rate',
                'grossIjp',
                'feeAgen',
                'fee',
                'feeAdmin',
                'materai'));
    }
    
    public function verifyDocSb($id) 
    {
        $direksi        = new DireksiController();
        $id                 = $direksi->dekripsi($id); 
        $table_sppsb = db::CONNECTION('db_sb')->table('sppsb');
        $table_result = db::CONNECTION('db_sb')->table('results'); 
        $sertifikat = $table_sppsb->select('*','sppsb.created_at as tgl_input','sppsb.id as id')
                ->leftJoin('users', 'users.id', '=', 'sppsb.user_id')->where('sppsb.id', $id)->first(); 
        if($sertifikat){
                $result = $table_result->where('sppsb_id', $id)->first(); 
                $charge = number_format($result->service_charge, 2, ",", ".");
//                dd($sertifikat);
               if ($sertifikat->digitalSign == 1) {
                    return view('dokumen.sertifikatsb', compact('sertifikat'));
                } else {
                    return view('verify.detailSb', compact('sertifikat'));
                }
        }else{
                 return   redirect('/Not Found');
        } 
    }
    
   public function showDocument(Request $request)
   {
//       dd($request);
        
        $direksi            = new DireksiController();
        $id                     = $direksi->dekripsi( $request->key);
        $table_sppsb  = db::CONNECTION('db_sb')->table('sppsb');
        $table_result  = db::CONNECTION('db_sb')->table('results'); 
        $sertifikat        = $table_sppsb->leftJoin('users', 'users.id', '=', 'sppsb.user_id')->where('sppsb.id', $id)->first();
//        return redirect('https://penjaminan.jamkridantb.com/'.$sertifikat->url);
        $url ='https://sign.jamkridantb.com/'.$sertifikat->url; 
        $fileName = $sertifikat->no_jaminan.'-'.$sertifikat->nama_kontraktor.'.pdf';
        return Response::make(file_get_contents($url), 200, [
                    'Content-Type'=> 'application/pdf',
                    'Content-Disposition' => 'inline; filename="'.$fileName.'"'
        ]);
    }
   public function showDocumentKredit(Request $request)
   { 
//       echo'halo';
//       dd($request);
       
         $sertifikat = penjaminans::leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftjoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('banks', 'pembayarans.idbank', '=', 'banks.idbank')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->where('sertifikats.verify',  $request->key)
                ->first();
//       dd($sertifikat);
//        $sertifikat        = sertifikats::->leftJoin('users', 'users.id', '=', 'sppsb.user_id')->where('sppsb.id', $id)->first();
//        return redirect('https://penjaminan.jamkridantb.com/'.$sertifikat->url);
        return redirect('/'.$sertifikat->url);
//        $url ='https://penjaminan.jamkridantb.com/'.$sertifikat->url; 
//        $url =$sertifikat->url; 
        $fileName = $sertifikat->kodesertifikat.'-'.$sertifikat->nama.'-'.$sertifikat->namabank.'.pdf';
        return Response::make(file_get_contents($url), 200, [
                    'Content-Type'=> 'application/pdf',
                    'Content-Disposition' => 'inline; filename="'.$fileName.'"'
        ]);
    }
    
     public function verifyDoc($id) {
//        dd($id);
        $sertifikat = penjaminans::leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftjoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('banks', 'pembayarans.idbank', '=', 'banks.idbank')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->where('sertifikats.verify', $id)
                ->first();
//       dd($sertifikat);
        if($sertifikat->digitalSign==1){
              return view('dokumen.sertifikat', compact('sertifikat'));
        }else{
              return   redirect('verifikasi-sertifikat-penjaminan/'.$id);
        }
      
        
    }
    
    public function verifyttd($id) {
        
        $sertifikat = penjaminans::leftJoin('terjamins', 'terjamins.id', '=', 'penjaminans.idterjamin')
                ->leftjoin('pembayarans', 'pembayarans.kodebayar', '=', 'penjaminans.kodebayar')
                ->leftJoin('banks', 'pembayarans.idbank', '=', 'banks.idbank')
                ->leftJoin('sertifikats', 'sertifikats.idpenjaminan', '=', 'penjaminans.idpenjaminan')
                ->where('sertifikats.verify', $id)
                ->first();
        if($sertifikat){
              return view('verify.detailttd',compact('sertifikat'));
        }else{
              return   redirect('/Not Found');
        }
       
    }


}
