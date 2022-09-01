<?php


namespace App\Http\Controllers;


class AkrualController_1 extends Controller {
    
    public function HitungSdAkhir(){ 
        $I       = 0;//@KEUANGAN
        $J       = 0 ;//@mulai
        $K      = 0;//@SET_MULAI
        $M     = 0; //@akhir
        $N      = 0 ;//@SET_AKHIR 
        $O      = 0; //@TGL_KLAIM  
        //set $mulai
         if ($J>$N){
             $sdAkhir = 0;
         }else{ 
           //set $mulai
             if ($I>$J){
                $mulai =  $J;
             }else{
                 if ($I<$J){
                     $mulai =  $J;
                 }else{
                      $mulai =  $I;
                 }
             } 
          //set $akhir 
             if(isNull($O)){
                    IF($M<$N){
                        $akhir  = $M;
                    }else{
                       $akhir   =   $N;
                    }
             }else{
                   IF($O>$N) { 
                       if ($N>$M){
                             $akhir   = $M;
                       }else{
                            $akhir   = $N; 
                       } 
                   }else{ 
                       $akhir   = $M; 
                   }
             } 
             
            $mulai      = new DateTime($mulai);
            $akhir       = new DateTime($akhir);
            $JumlahsdAkhir  = $akhir->diff($mulai)->format("%a");
         } 
         return $JumlahsdAkhir; 
    }
    
    public function HitungJumlahPeriode(){ 
        $I       = 0;//@KEUANGAN
        $J       = 0 ;//@mulai
        $K      = 0;//@SET_MULAI
        $M     = 0; //@akhir
        $N      = 0 ;//@SET_AKHIR 
        $O      = 0; //@TGL_KLAIM  
      
    IF($J>$N){
        $jumlahPeriode=0 ;
    }else{
         if(isNull($O)){
              IF($M<$K){
                  
                  IF($M<$I and $I>$K){
                         $mulai      = new DateTime($J);
                         $akhir       = new DateTime($M); 
                         $jumlahPeriode = $akhir->diff($mulai)->format("%a");
                  }else{
                         $jumlahPeriode=0; 
                  } 
              }else{
                  IF($I>$M){ 
                      //cek mulai
                        IF($J<$K){
                            $mulai = $J ;
                        }else{
                            $mulai = $K;
                        }
                        //cek akhir
                      IF($M<$N){
                          $akhir = $M; 
                       }else{
                          $akhir =$N;
                       }
                         $mulai      = new DateTime($mulai);
                         $akhir       = new DateTime($akhir);
                         $jumlahPeriode = $akhir->diff($mulai)->format("%a");
                          
                  }else{
                      //set mulai 
                        IF($J<$K){ 
                            IF($K<=$I & $K>$J)
                            {
                               $mulai=$J;
                            }else{
                                $mulai =    $K   ;
                            } 
                        } else {
                             $mulai =    $J   ;
                        }  
                        
                        
                     //set akhir
                        IF($M<$N){
                           $akhir = $M ;
                        }else{
                          $akhir =  $N ;
                        }   
                          $mulai      = new DateTime($mulai);
                          $akhir       = new DateTime($akhir);
                          $jumlahPeriode = $akhir->diff($mulai)->format("%a");
                          
                         
                  }
              }
         }else{
             
               IF($O<$K){
                          $jumlahPeriode=0; 
               }else{ 
                        IF($K>$M){
                            $jumlahPeriode =0;
                        }else{ 
                            //Set Mulai 
                               IF($I>$J){
                                   IF($K>$J and $K>$I){
                                       $mulai = $K;
                                   }else{ 
                                       $mulai =  $J ;  
                                   } 
                               }else{
                                   IF($K<$J){
                                       $mulai = $J ;
                                   }else{ 
                                        $mulai =   $K ;
                                   }
                               }
                                //Set Akhir 
                                  IF($O>$N){ 
                                       IF($N>$M){
                                             $akhir = $M;
                                         }else{ 
                                              $akhir = $N ;
                                         }
                                  }else{
                                      IF($M>$N and $O>$M){
                                          $akhir = $N;
                                      }else{
                                          $akhir = $M ;
                                      }
                                  }
                                 $mulai      = new DateTime($mulai);
                                 $akhir       = new DateTime($akhir);
                                 $jumlahPeriode = $akhir->diff($mulai)->format("%a");
                        } 
                        
               }
         }
    } 
         return $jumlahPeriode; 
    } 
    
}