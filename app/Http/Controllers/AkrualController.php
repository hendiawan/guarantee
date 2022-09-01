<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use DateTime;
class AkrualController extends Controller {
    
    public function HitungSdAkhir($tgl_keuangan,$tgl_mulai,$tgl_akhir,$set_mulai,$set_akhir,$tgl_klaim)
    { 
//           echo "S/D Akhir :".   $total = $this->
//           
//           HitungSdAkhir($data->Keuangan,$data->Mulai,$data->Akhir,'2021/02/01','2021/02/28',$data->Klaim)."<br>"; ;  
        $keuangan      = date('Y-m-d',strtotime($tgl_keuangan));//@KEUANGAN
        $mulai               = date('Y-m-d',strtotime($tgl_mulai)) ;//@mulai
        $akhir                = date('Y-m-d',strtotime($tgl_akhir)); //@akhir
        $set_mulai       = date('Y-m-d',strtotime($set_mulai));//@SET_MULAI 
        $set_akhir        = date('Y-m-d',strtotime($set_akhir)) ;//@SET_AKHIR 
        $tgl_mulai        = date('Y-m-d',strtotime($tgl_klaim)); //@TGL_KLAIM  
        
        if($tgl_mulai=='1970-01-01'){$tgl_mulai=null;}
//        
//       echo "keuangan :". $keuangan."<br>"  ;
//    echo   "mulai :" .$mulai            ."<br>"      ;
//   echo    "akhir :" .$akhir            ."<br>"   ;
//   echo    "set_mulai :" . $set_mulai    ."<br>";
//   echo   "set_akhir :" .$set_akhir     ."<br>" ;
//   echo     "tgl_klaim :" .$tgl_mulai     ."<br>" ;
//        
//        dd($keuangan);
        //
        //
        //    
        //set $mulai
         if ($mulai>$set_akhir ){
             //periode yang diminta secara logika belum terdaftar
             $sdAkhir = 0;
         }
         else
         { 
           //set $mulai
             if ($keuangan>$mulai)
             {
                $mulai =  $mulai;
             }
             else
             {
                 if ($keuangan<$mulai)
                 {
                     //jika tgl keuangan lebih kecil dari tgl mulai, maka tanggal mulai akan diambil dari tanggal mulai
                     $mulai =  $mulai;
                 }
                 else
                 { 
                      $mulai =  $keuangan;
                 }
             } 
             //set $akhir 
             //jika tanggal klaim kosong
             if(empty($tgl_mulai))
             {
                 //jika periode akhir lebih kecil dari tanggal permintaan akhir, maka akhir diambil dari akhir
                    IF($akhir<$set_akhir )
                    {
                      $akhir  = $akhir;
                    }
                    else
                    {
                      $akhir   = $set_akhir ;
                    }
             }else{
                   IF($tgl_mulai>$set_akhir ) 
                   { 
                        if ($set_akhir>$akhir){
                             $akhir   = $akhir;
                       }else{
                             $akhir   = $set_akhir ; 
                       }  
                   }
                   else
                   { 
                         $akhir   = $akhir; 
                   }
             }  
            $mulai      = new DateTime($mulai);
            $akhir       = new DateTime($akhir);
            $sdAkhir  = $akhir->diff($mulai)->format("%a")+1;
         } 
         return $sdAkhir; 
    }
    
    public function HitungJumlahPeriode($tgl_keuangan,$tgl_mulai,$tgl_akhir,$set_mulai,$set_akhir,$klaim)
    {  
//        echo $tgl_klaim; 
           
        $keuangan      = date('Y-m-d',strtotime($tgl_keuangan));//@KEUANGAN 
//             dd($keuangan);
        $mulai              = date('Y-m-d',strtotime($tgl_mulai)) ;//@mulai
        $akhir               = date('Y-m-d',strtotime($tgl_akhir)); //@akhir
        $set_mulai      = date('Y-m-d',strtotime($set_mulai));//@SET_MULAI 
        $set_akhir       = date('Y-m-d',strtotime($set_akhir)) ;//@SET_AKHIR 
        $tgl_klaim       = date('Y-m-d',strtotime($klaim)); //@TGL_KLAIM  
//        dd($tgl_klaim);
        if($tgl_klaim=='1970-01-01') {$tgl_klaim=null;}
            
//       echo $keuangan  ."<br>"  ; 
// echo       $mulai              ."<br>"  ; 
//  echo      $akhir              ."<br>"   ;
//    echo    $set_mulai    ."<br>" ;
//   echo     $set_akhir      ."<br>"; 
//    echo    $tgl_mulai    ."<br>" ;
////      
//      dd(empty($tgl_mulai));
 
                IF($mulai>$set_akhir )
                {
                    $jumlahPeriode=0 ;
                }
                else
                {
                      if(empty($tgl_klaim))
                      { 
//                          DD($tgl_mulai);
                          IF($akhir<$set_mulai)
                          {  
                                        IF($akhir<$keuangan and $keuangan>$set_mulai){
                                               $mulai      = new DateTime($mulai);
                                               $akhir       = new DateTime($akhir); 
                                               $jumlahPeriode = $akhir->diff($mulai)->format("%a");
                                        }else{
                                               $jumlahPeriode=0; 
                                        } 
                          }
                          else
                          { 
                              IF($keuangan>$akhir)
                              { 
                                        //cek mulai
                                          IF($mulai<$set_mulai)
                                          {
                                              $mulai = $mulai ;
                                          }
                                          else
                                          {
                                              $mulai = $set_mulai;
                                          }
                                          //cek akhir
                                        IF($akhir<$set_akhir )
                                        {
                                            $akhir = $akhir; 
                                         }
                                         else
                                         {
                                            $akhir =$set_akhir ;
                                         }
                                           $mulai      = new DateTime($mulai);
                                           $akhir       = new DateTime($akhir);
                                           $jumlahPeriode = $akhir->diff($mulai)->format("%a")+1; 
                              }
                              else
                              { 
                                  //set mulai 
                                    IF($mulai<$set_mulai)
                                    { 
                                           IF($set_mulai<=$keuangan && $set_mulai>$mulai)
                                           {
                                                $mulai=$mulai;
                                           }else{
                                                $mulai =$set_mulai   ;
//                                                     dd($mulai);
                                           }  
                                    }
                                    else 
                                    {
                                            $mulai =    $mulai   ;
                                    }  
                                 //set akhir
                                    IF($akhir<$set_akhir )
                                    {
                                            $akhir = $akhir ;
                                    }
                                    else
                                    {
                                            $akhir =  $set_akhir  ;
                                    }   
                                            $mulai      = new DateTime($mulai);
                                            $akhir       = new DateTime($akhir);
                                            $jumlahPeriode = $akhir->diff($mulai)->format("%a")+1; 
                              }
                          }
                     }
                     else
                     {
                           IF($tgl_klaim<$set_mulai)
                           {
                                     $jumlahPeriode=0; 
                           }
                           else
                           { 
                                    IF($set_mulai>$akhir)
                                    {
                                             $jumlahPeriode =0;
                                    }
                                    else
                                    { 
                                        //Set Mulai
                                             IF($keuangan>$mulai){
                                                        IF($set_mulai>$mulai and $set_mulai>$keuangan){
                                                            $mulai = $set_mulai;
                                                        }else{ 
                                                            $mulai =  $mulai ;  
                                                        } 
                                            }else{
                                                        IF($set_mulai<$mulai){
                                                            $mulai = $mulai ;
                                                        }else{ 
                                                             $mulai =   $set_mulai ;
                                                        }
                                            }
                                            //Set Akhir 
                                              IF($tgl_klaim>$set_akhir )
                                              {
                                                        IF($set_akhir>$akhir){
                                                              $akhir = $akhir;
                                                          }else{ 
                                                               $akhir = $set_akhir  ;
                                                          } 
                                              }
                                              else
                                              {
                                                        IF($akhir>$set_akhir and $tgl_klaim>$akhir )
                                                        {
                                                            $akhir = $set_akhir;
                                                        }
                                                        else
                                                        {
                                                            $akhir = $akhir  ;
                                                        }
                                              }
                                             $mulai      = new DateTime($mulai);
                                             $akhir       = new DateTime($akhir);
                                             $jumlahPeriode = $akhir->diff($mulai)->format("%a")+1;
                                    }  
                           }
                     }
            } 
         return $jumlahPeriode; 
    } 
    
    public function cekJumlahTotal($mulai,$akhir)
    {
//                  dd($mulai);
          $mulai      = new DateTime($mulai);
          $akhir       = new DateTime($akhir);
          $jumlahTotal= $akhir->diff($mulai)->format("%a")+1;
          

          return $jumlahTotal;
    }
    
    public function hitungAkrual()
    { 
        
           $akrual = db::CONNECTION('sqlsrv')
                ->table("t_penjaminan")
                ->get();   
        dd($akrual);
        
      $set_mulai =date("Y-m-d", strtotime('2021/02/01'));
      $set_akhir=date("Y-m-d", strtotime('2021/02/28'));
//        dd($set_akhir);
      $akrual = db::CONNECTION('sqlsrv')
                ->table("GetRekapAccrualPenjaminanHarianNominal('$set_mulai','$set_akhir')")
                ->where('Nomor','KU2012290187')
                ->take(200)
                ->get();   
//      dd($akrual[0]);
    
        foreach ($akrual as $data){ 
//              dd($data);
          echo "Nomor :".  $data->Nomor."<br>"; 
          echo "Total :".  $total = $this->cekJumlahTotal($data->Mulai,$data->Akhir)."<br>"; 
          echo "S/D Akhir :".   $total = $this->HitungSdAkhir($data->Keuangan,$data->Mulai,$data->Akhir,$set_mulai,$set_akhir,$data->Klaim)."<br>"; ;  
          echo "Periode :".   $total = $this->HitungJumlahPeriode($data->Keuangan,$data->Mulai,$data->Akhir,$set_mulai,$set_akhir,$data->Klaim)."<br>"; ; 
          echo "---------------------"."<br>"; ;  
//          dd($data); 
        }
  
    }
    
    
    
    
}