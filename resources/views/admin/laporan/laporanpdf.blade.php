<?php
//echo'<pre>';
//print_r($data);
//echo '</pre>';
//dd($data)

?>
 <style>
hr { 
    display: block;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
    margin-left: auto;
    margin-right: auto;
    border-style: inset;
    border-width: 1px;
} 
</style>
    <div id="pengajuanbaru" class="tab-pane fade in active">
       
        @if($data['jenislaporan']=='%')
        <table>
            <tr>
                <th><img style="vertical-align:middle;"  src="img/jamkrida.jpg"class="img-responsive" width='10%'  alt="User Image"></th>

                @if($data['jeniskredit']=='%')
                <th><h4>LAPORAN PEJAMINAN KREDIT</h4></th>
                <th> 
                    @if($data['bank']=='%')
                    <h4>BANK NTB DAN PD. BPR NTB</h4>
                    @else
                    <h4>{{$data['data'][0]['namabank']}}</h4>
                    @endif                   
                </th>
              
                @else
                <th><h4>LAPORAN PEJAMINAN KREDIT {{$data['jeniskredit']}}</h4></th>
                <th>
                    @if($data['bank']=='%')
                    <h4>BANK NTB DAN PD. BPR NTB</h4>
                    @else
                    <h4>{{$data['data'][0]['namabank']}}</h4>
                    @endif   
                </th>
                
                @endif
                <th>        
                    <h4 align="center"> Dari {{date('d/m/Y',strtotime($data['dari']))}} Sampai {{date('d/m/Y',strtotime($data['sampai']))}}</h4>
                </th>
            </tr>
        </table>
        @else
        <table>
            <tr>
                <th><img style="vertical-align:middle;margin-left: -14%;"  src="img/jamkrida.jpg"class="img-responsive" width='10%'  alt="User Image"></th>
                @if($data['jeniskredit']=='%')
                <th><h4>LAPORAN PEJAMINAN KREDIT</h4></th>
                <th> 
                    @if($data['bank']=='%')
                    <h4>BANK NTB DAN PD. BPR NTB</h4>
                    @else
                 <h4>{{$data['data'][0]['namabank']}}</h4>
                    @endif                   
                </th>
                @else
                <th><h4>LAPORAN PEJAMINAN KREDIT {{$data['jeniskredit']}}</h4></th>
                <th>
                    @if($data['bank']=='%')
                    <h4></h4>
                    @else
                    <h4>{{$data['data'][0]['namabank']}}</h4>
                    @endif   
                </th>
                @endif
                <th>        
                    <h4 align="center"> Dari {{date('d/m/Y',strtotime($data['dari']))}} Sampai {{date('d/m/Y',strtotime($data['sampai']))}}</h4>
                </th>
            </tr>
        </table>
        
        @endif
 
        <body ng-app="Penjaminan" ng-controller="PenjaminanController">
            <section  class="col-lg-13 connectedSortable">
                <!-- Map box -->
                <div class="box box-solid">
                    
                    <table class="table table-hover"  style="font-size: 11px;border: 1px; border-color:  black" >
                        <thead>
                            <tr style="background-color:#23527c ;color: #000000">
                                <th>NO</th>
                                <th>TGL PENGAJUAN</th> 
                                @if($data['bank']=='%')
                                <th>PENERIMA</th>    
                                @endif
<!--                                <th>NO KTP</th>-->
                                <th>NAMA TERJAMIN</th>                        
                                <th>JENIS KREDIT</th>                        
                                <th>TGL LAHIR</th>                        
                                <th>UMUR</th>
                                <th>PEKERJAAN</th>
                                <th>MULAI TGL</th>
                                <th>SAMPAI TGL</th>                           
                                <th>JUMLAH</th>                                
                                <th>PLAFON</th>
                                <th>RATE IJP(%)</th>
                                <th>GROSS IJP</th>
                                <th>DISC(Rp)</th>
                                <th>NET. IJP(Rp)</th>
                                @if($data['bank']!='%')
                                <th>STATUS PENGAJUAN</th>
                                <th>STATUS BAYAR</th>
                                @endif
                               
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
                            ?>
                            @foreach( $data['data'] as $datas)
                            
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{date('d-m-Y', strtotime($datas->tglpengajuan))}}</td>   
                                @if($data['bank']=='%')
                                <td>{{$datas->namabank}}</td>
                                @endif
<!--                                <td>{{$datas->ktp}}</td>-->
                                <td>{{$datas->nama}}</td>
                                <td>{{$datas->jeniskredit}}</td>
                                <td>{{date('d-m-Y', strtotime($datas->tgllahir))}}</td> 
                                <td>{{$datas->umur}}</td>
                                <td>{{strtoupper($datas->pekerjaan)}}</td>
                                <td>{{date('d-m-Y', strtotime($datas->tglrealisasi))}}</td> 
                                <td>{{date('d-m-Y', strtotime($datas->tgljatuhtempo))}}</td> 
                                <td>{{$datas->masakredit}}</td>     
                                <td align="right">{{number_format( $datas->plafon, 2, ',', '.')}}</td>      
                                <td>{{$datas->rate}}</td>     
                                <td align="right">{{number_format( $datas->premi, 2, ',', '.')}}</td>       
                                <td align="right">{{number_format( $datas->pot, 2, ',', '.')}}</td>       
                                <td align="right">{{number_format( $datas->nett, 2, ',', '.')}}</td>  
                                
                                @if($data['bank']!='%')
                                <td>{{strtoupper($datas->app)}}</td>
                                @if($datas->statusbayar==0)
                                <td style="color: red"><b>{{strtoupper('BELUM BAYAR')}}</b></td>
                                @else
                                <td  style="color:green">{{strtoupper('SUDAH BAYAR')}}</td>
                                @endif
                                @endif
                                
                                
                            </tr>
                            
                            <?php 
                            $totalpenjaminan=$totalpenjaminan+$datas ->plafon;
                            $totalgrossijp=$totalgrossijp+$datas ->premi;
                            $totaldis=$totaldis+$datas ->pot;
                            $totalnetijp=$totalnetijp+$datas ->nett;
                            $i++ 
                             ?>
                            @endforeach
                            <tr>
                                <td>TOTAL</td>
                                <td></td>
                                @if($data['bank']!='%')
                                <td></td>
                                @endif
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                @if($data['bank']=='%')
                                <td></td>
                                <td></td>
                                @endif
                                <td></td>
                                <td></td>   
                                <td align='right'><b>{{number_format( $totalpenjaminan, 2, ',', '.')}}</b></td>
                                <td></td>
                                <td align='right'><b>{{number_format( $totalgrossijp, 2, ',', '.')}}</b></td>
                                <td align='right'><b>{{number_format( $totaldis, 2, ',', '.')}}</b></td>
                                <td align='right'><b>{{number_format( $totalnetijp, 2, ',', '.')}}</b></td>
                               
                                
                                 
                              
                            </tr>
                        </tbody>
                    </table>

                </div>
            </section>
        </body>                
    </div>
<br>
 

 

