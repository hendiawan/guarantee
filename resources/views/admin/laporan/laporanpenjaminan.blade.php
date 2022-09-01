<?php
//echo'<pre>';
//print_r($data);
//echo '</pre>';
//dd($data)

?>
 
    <div id="pengajuanbaru" class="tab-pane fade in active">
        @if($data['jenis']=='%')
           <h3 align="center">DAFTAR PEJAMINAN KREDIT </h3>
        @else
           <h3 align="center">LAPORAN PEJAMINAN KREDIT {{$data['data'][0]['jeniskredit']}}</h3>
        @endif
        
        @if($data['bank']!='%')
          <h5 align="center">{{$data['data'][0]['namabank']}}</h5>  
          <h5 align="center"> {{$data['data'][0]['alamat']}}</h5>
        @else
         <h5 align="center">BPR DAN BANK NTB</h5>  
        @endif
     
        <h2 align="center">(Periode {{date('d/m/Y',strtotime($data['dari']))}} - {{date('d/m/Y',strtotime($data['sampai']))}})</h2>
        
        
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
                                <th>JUMLAH</th>                                
                                <th>PLAFON</th>
                                <th>RATE IJP(%)</th>
                                <th>GROSS IJP</th>
                                <th>DISC(Rp)</th>
                                <th>NET. IJP(Rp)</th>
                                <th>STATUS PENGAJUAN</th>
                                <th>STATUS BAYAR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
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
                                <td>{{$datas->nama}}</td>
                                <td>{{$datas->ktp}}</td>
                                <td>{{$datas->jeniskredit}}</td>
                                <td>{{date('d-m-Y', strtotime($datas->tgllahir))}}</td> 
                                <td>{{$datas->umur}}</td>
                                <td>{{strtoupper($datas->pekerjaan)}}</td>
                                <td>{{date('d-m-Y', strtotime($datas->tglrealisasi))}}</td> 
                                <td>{{date('d-m-Y', strtotime($datas->tgljatuhtempo))}}</td> 
                                <td>{{$datas->masakredit}}</td>     
                                <td>{{number_format( $datas->plafon, 0, ',', '.')}}</td>      
                                <td>{{$datas->rate}}</td>     
                                <td align="right">{{number_format( $datas->premi, 0, ',', '.')}}</td>       
                                <td align="right">{{number_format( $datas->pot, 0, ',', '.')}}</td>       
                                <td align="right">{{number_format( $datas->nett, 0, ',', '.')}}</td>  
                                <td>{{strtoupper($datas->app)}}</td>
                                @if($datas->statusbayar==0)
                                <td style="color: red"><b>{{strtoupper('BELUM BAYAR')}}</b></td>
                                @else
                                 <td  style="color:green">{{strtoupper('SUDAH BAYAR')}}</td>
                                @endif
                            </tr>
                            
                            <?php $i++ ?>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </section>
        </body>                
    </div>
<br>
 

 

