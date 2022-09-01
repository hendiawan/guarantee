 
@extends('layout.admin')

@section('content')

        
    <div id="pengajuanbaru" class="tab-pane fade in active">
        
           <h3 align="center">LAPORAN PEJAMINAN KREDIT</h3>
       
         <h3 align="center">(Periode {{date('d/m/Y',strtotime($dari))}} - {{date('d/m/Y',strtotime($sampai))}})</h3>
        <hr>
        <center>
         <table>
           <tr>
           <form method="post" action="cetaklaporanexceladmin">
               {{csrf_field()}}
               <input hidden="" name="bank" value="{{$bank}}">  
               <input hidden="" name="dari" value="{{$dari}}">  
               <input hidden="" name="sampai" value="{{$sampai}}">  
               <input hidden="" name="jenisKredit" value="{{$jenis}}"> 
               <input hidden="" name="jenislaporan" value="{{$app}}">
               <button  type="submit" class="btn btn-danger">  <span class="glyphicon glyphicon-print"></span>  Cetak EXCEL</button>                       
           </form> 
           </tr>
        </table>
        </center>
        
        <hr>
        
        <body ng-app="Penjaminan" ng-controller="PenjaminanController">
            <section  class="col-lg-13 connectedSortable">
                <!-- Map box -->
                <div class="box box-solid">
                    
                    <table  class="table table-hover "  style="font-size: 11px;border: 1px; border-color:  black" >
                        <thead>
                            <tr style="background-color:#cccccc ;color: #000000">
                                <th>NO</th>
                                <th>PENGAJUAN</th>                           
                                <th>NO. SERTIFIKAT</th>                           
                                <th>PENERIMA</th>                           
<!--                                <th>NO KTP</th>-->
                                <th>TERJAMIN</th>                        
                                <th>KREDIT</th>                        
                                <th>JENIS</th>                        
                                <th>LAHIR</th>                        
                                <th>UMUR</th>
                                <th>PEKERJAAN</th>
                                <th>PLAFON</th>
                                <th>MULAI</th>
                                <th>AKHIR</th>                           
                                <th>(Bln)</th>                                
                                <th>(Hari)</th> 
                                <th>BERJALAN</th> 
                                <th>SISA</th> 
                                <th>IJP/(Hari)</th> 
<!--                                <th>IJPYMP</th>                    
                                <th>IJPYMB</th>                    -->
                                <th>RATE(%)</th>
                                <th>GROSS IJP</th>
                                <th>DISC(Rp)</th>
                                <th>NET. IJP(Rp)</th>
                                <th>STATUS</th>
                                <th>TGLTERBIT</th>
<!--                                <th>STATUS BAYAR</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            $totalpenjaminan=0;
                            $totalgrossijp=0;
                            $totaldis=0;
                            $totalnetijp=0;
                            function aging($tanggal) {
                                $tanggal1 = new DateTime($tanggal);
                                $tanggal2 = new DateTime();
                                return  $aging = $tanggal2->diff($tanggal1)->format("%a");
                            }
                            function aging2($tanggal) {
                                $tanggal1 = new DateTime($tanggal);
                                $tanggal2 = new DateTime();
                                return  $aging = $tanggal1->diff($tanggal2)->format("%a");
                            }
                            
                                
                                ?>
                            @foreach($data as $datas)
                            <?php
                            $mulai= new DateTime($datas->tglrealisasi);
                            $akhir= new DateTime($datas->tgljatuhtempo);
                            $sekarang= new DateTime();
                            $hari=$akhir->diff($mulai)->format("%a");
                            $berjalan=aging($datas->tglrealisasi);
                           
                            if($berjalan>=$hari){$berjalan=$hari;}
                            $sisa=$hari-$berjalan;
                            $ijpperhari=$datas ->nett/$hari;
                            if($sisa==0){$ijpperhari=0;};
                            $ijpymp=$ijpperhari*$berjalan;
                            $ijpymb=$ijpperhari*$sisa;
                            ?>
                            <tr style="background-color:#ffffff ;color: #000000">  
                                <td>{{$i}}</td>  
                                <td>{{date('d-m-y', strtotime($datas->tglpengajuan))}}</td>     
                                <td>{{$datas->kodesertifikat}}</td>
                                <td>{{$datas->bank->namabank}}</td>
                                <td>{{$datas->terjamin->nama}}</td>
                                <td>{{$datas->jeniskredit}}</td>
                                <td>{{$datas->jenispenjaminan}}</td>
                                <td>{{date('d-m-y', strtotime($datas->terjamin->tgllahir))}}</td> 
                                <td>{{$datas->terjamin->umur}}</td>
                                <td>{{strtoupper($datas->terjamin->pekerjaan)}}</td>
                                <td align="right">{{number_format( $datas ->plafon, 2, ',', '.')}}</td>      
                                <td>{{date('d-m-y', strtotime($datas->tglrealisasi))}}</td> 
                                <td>{{date('d-m-y', strtotime($datas->tgljatuhtempo))}}</td> 
                                <td>{{$datas ->masakredit}}</td>     
                                <td>{{$hari}}</td>     
                                <td>{{$berjalan}}</td> 
                                <td>{{$sisa}}</td> 
                                <td align="right">{{number_format( $ijpperhari, 2, ',', '.')}}</td>     
<!--                                <td align="right">{{number_format( $ijpymp, 2, ',', '.')}}</td>     
                                <td align="right">{{number_format( $ijpymb, 2, ',', '.')}}</td>     -->
                                <td align="right">{{$datas->rate}}</td>     
                                <td align="right">{{number_format( $datas ->premi, 2, ',', '.')}}</td>       
                                <td align="right">{{number_format( $datas ->pot, 2, ',', '.')}}</td>       
                                <td align="right">{{number_format( $datas ->nett, 2, ',', '.')}}</td>  
                                <td>{{strtoupper($datas->app)}}</td>
                                <td>{{date('d-m-Y', strtotime($datas->tglterbit))}}</td> 

<!--                                @if($datas->statusbayar==0)
                                <td style="color: red"><b>{{strtoupper('BELUM BAYAR')}}</b></td>
                                @else
                                 <td  style="color:green">{{strtoupper('SUDAH BAYAR')}}</td>
                                @endif-->
                            </tr>
                            
                             <?php 
                            $totalpenjaminan=$totalpenjaminan+$datas ->plafon;
                            $totalgrossijp=$totalgrossijp+$datas ->premi;
                            $totaldis=$totaldis+$datas ->pot;
                            $totalnetijp=$totalnetijp+$datas ->nett;
                            $i++ 
                             ?>
                            @endforeach
                            <tr style="background-color: #B0BEC5">
                                <td>TOTAL</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td align='right'><b>{{number_format( $totalpenjaminan, 2, ',', '.')}}</b></td>
                                <td></td>
                                <td></td>   
                                <td></td> 
                                <td></td>   
<!--                                <td></td>   
                                <td></td>   -->
                                <td></td>   
                                <td></td>   
                                <td></td>   
                                <td></td>
                                <td align='right'><b>{{number_format( $totalgrossijp, 2, ',', '.')}}</b></td>
                                <td align='right'><b>{{number_format( $totaldis, 2, ',', '.')}}</b></td>
                                <td align='right'><b>{{number_format( $totalnetijp, 2, ',', '.')}}</b></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </section>
        </body>                
    </div>
<br>
@endsection
     

 

