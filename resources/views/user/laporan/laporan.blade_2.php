<?php
//echo $data['jeniskredit'];
//dd($data);

?>
 
    <div id="pengajuanbaru" class="tab-pane fade in active">
        @if($data['jeniskredit']=='%')
           <h3 align="center">REKAP PENGAJUAN PEJAMINAN KREDIT </h3>
        @else
           <h3 align="center">REKAP PENGAJUAN PEJAMINAN KREDIT {{$data['data'][0]['jeniskredit']}}</h3>
        @endif
       
     
        <h3 align="center"><b>{{$data['data'][0]['namabank']}}</h3>
<!--        <h5 align="center"><b>@if(isset($data['data'][0]['alamat'])){{$data['data'][0]['alamat']}}@endif</b></h5>-->
        <h4 align="center">(Periode {{date('d/m/Y',strtotime($data['dari']))}} - {{date('d/m/Y',strtotime($data['sampai']))}})</h4>
        
        <hr>
        <body ng-app="Penjaminan" ng-controller="PenjaminanController">
            <section  class="col-lg-13 connectedSortable">
                <!-- Map box -->
                <div class="box box-solid">
                    
                    <table class="table table-hover"  style="font-size: 11px;border: 1px; border-color:  black" >
                        <thead>
                            <tr style="background-color:#23527c ;color: #000000">
                                <th>NO</th>
                                <th>TGL PENGAJUAN</th>                           
                                <th>NO KTP</th>
                                <th>NAMA TERJAMIN</th>                        
                                <th>JENIS KREDIT</th>                        
                                <th>TGL LAHIR</th>                        
                                <th>UMUR</th>
                                <th>PEKERJAAN</th>
                                <th>MULAI TGL</th>
                                <th>SAMPAI TGL</th>                           
                                <th>JUMLAH(Bln)</th>                                
                                <th>PLAFON (Rp)</th>
                                <th>RATE IJP(%)</th>
                                <th>GROSS IJP (Rp)</th>
                                <th>DISC(Rp)</th>
                                <th>NET. IJP(Rp)</th>
                                
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
                                <td>{{$datas->ktp}}</td>
                                <td>{{$datas->nama}}</td>
                                <td>{{$datas->jeniskredit}}</td>
                                <td>{{date('d-m-Y', strtotime($datas->tgllahir))}}</td> 
                                <td>{{$datas->umur}}</td>
                                <td>{{strtoupper($datas->pekerjaan)}}</td>
                                <td>{{date('d-m-Y', strtotime($datas->tglrealisasi))}}</td> 
                                <td>{{date('d-m-Y', strtotime($datas->tgljatuhtempo))}}</td> 
                                <td>{{$datas->masakredit}}</td>     
                                <td  align="right">{{number_format( $datas->plafon, 0, ',', '.')}}</td>      
                                <td>{{$datas->rate}}</td>     
                                <td align="right">{{number_format( $datas->premi, 0, ',', '.')}}</td>       
                                <td align="right">{{number_format( $datas->pot, 0, ',', '.')}}</td>       
                                <td align="right">{{number_format( $datas->nett, 0, ',', '.')}}</td>  
                                
                            </tr>
                            
                            
                            <?php 
                            $totalpenjaminan=$totalpenjaminan+$datas ->plafon;
                            $totalgrossijp=$totalgrossijp+$datas ->premi;
                            $totaldis=$totaldis+$datas ->pot;
                            $totalnetijp=$totalnetijp+$datas ->nett;
                            $i++ 
                             ?>
                            @endforeach
                            <tr style="background-color:#27ae60 ;color: #000000">
                                <td align='center' colspan="11">TOTAL</td>
                                
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
 

 

 