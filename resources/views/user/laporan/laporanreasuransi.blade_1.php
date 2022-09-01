<?php
//echo $data['jeniskredit'];
//dd($data);
use App\Http\Controllers\ReasuransiController;
use App\Http\Controllers\AkrualController; 
$reasuransi    = new ReasuransiController();
$akrual            = new AkrualController(); 
$tanggal          = date('d-m-Y', strtotime($datareasuransi[0]['tgl_proses']));
//dd($tanggal);
$cetakTanggal=$reasuransi->tgl_indo($tanggal);

?>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>PENGAJUAN BORDERO FAKULTATIF {{ strtoupper($cetakTanggal)}}</title>
        <style type="text/css">
                 body{
                        font-family: 'Dejavu Sans';
                        font-size: 10px;
                }
                .widget-content.pad20f {
                            padding: 0 20px 20px;
                }
                h3{
                                font-size: 18px;
                                line-height: 20px;
                                margin-bottom: 40px
                        }
                p{
                                margin: 0;
                                padding: 0;
                                text-align: justify;
                    }
                 table.data thead tr{
                                background: #efefef;
                                padding: 4px 0;
                }
                table.data tr td{
                                font-size: 10px;
                }
        </style>
    </head>
     <body> 
                <center>
                    <p>PT.  JAMKRIDA NTB BERSAING</p>
                    <p>PENGAJUAN BORDERO FAKULTATIF {{ strtoupper($cetakTanggal)}} </p>
                </center>
                <br>
                <table border="1"  style=" font-family: Arial, Helvetica, sans-serif; font-size: 10px; border-collapse: collapse;"  class="table table-hover"  >
                        <thead>
                            <tr style="background-color:#e0e0e0 ;color: #000000">
                                <th>NO</th>
                                <th>NAMA REASURANSI</th>
                                <th>TGL TERBIT</th>                           
                                <!--<th>NO KTP</th>-->
                                <th>NOMOR SERTIFIKAT</th>                        
                                <th>NAMA TERJAMIN</th>                        
                                <th>NAMA BANK</th>                        
                                <th>JENIS KREDIT</th>                        
                                <!--<th>TGL LAHIR</th>-->                        
                                <!--<th>UMUR</th>-->
                                <!--<th>PEKERJAAN</th>-->
                                <th>MULAI TGL</th>
                                <th>SAMPAI TGL</th>                           
                                <th style="width: 10px">JANGKA (Bln)</th>                                
                                <th style="width: 10px">Lama (Hari)</th>                                
                                <th>PLAFON (Rp)</th>
                                <th>PENJAMINAN (%)</th>
                                <th>NILAI PENJAMINAN (Rp)</th>
                                <th>PENJAMINAN JAMKRIDA (Rp)</th>
                                <th>PENJAMINAN REGARANSI (Rp)</th>
                                <!--<th>RATE IJP(%)</th>-->
                                <th>GROSS IJP (Rp)</th>
                                <th>DISC (Rp)</th>
                                <th>NET. IJP (Rp)</th>
                                <th> IJP JAMKRIDA-REAS (Rp)</th>
                                <th>SHARE DENGAN REASURANSI(%)</th>
                                <th>IJP REASURANSI (Rp)</th>
                                <th>RI Commision (Rp)</th>
                                <th>NET IJP REASURANSI (Rp)</th>
                                <th>JENIS PENJAMINAN</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $totalpenjaminan = 0;
                            $totalplafond = 0;
                            $totalgrossijp = 0;
                            $totaldis = 0;
                            $totalnetijp = 0;
                            $totalnetijpReasuransi = 0;
                            $totalPenjaminanReasuransi = 0;
                            $totalPenjaminanJamkrida = 0;
                            $totalnetijpJamkrida = 0;
                            $totalricommision = 0;
                            $totalnettijpreas = 0;
                            $totalnilaiPenjaminan = 0;

                            function aging($tanggal) {
                                $tanggal1 = new DateTime($tanggal);
                                $tanggal2 = new DateTime();
                                return $aging = $tanggal2->diff($tanggal1)->format("%a");
                            }
                            ?>
                            @foreach( $datareasuransi as $datas)

                            <tr style="background-color:whitesmoke ;color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{$datas->penjaminan->reasuransi->rekanan->nama_asuransi}}</td>
                                <td>{{date('d-m-Y', strtotime($datas->penjaminan->sertifikat->tglterbit))}}</td>     
                                <!--<td>{{$datas->ktp}}</td>-->
                                <td>{{$datas->penjaminan->sertifikat->kodesertifikat}}</td>
                                <td>{{strtoupper($datas->penjaminan->terjamin->nama)}}</td>
                                <td>{{$datas->penjaminan->bank->namabank}}</td>
                                <td>{{$datas->jeniskredit}}</td>
                                <!--<td>{{date('d-m-Y', strtotime($datas->tgllahir))}}</td>--> 
                                <!--<td>{{$datas->umur}}</td>-->
                                <!--<td>{{strtoupper($datas->pekerjaan)}}</td>-->
                                <td>{{date('d-m-Y', strtotime($datas->tglrealisasi))}}</td> 
                                <td>{{date('d-m-Y', strtotime($datas->tgljatuhtempo))}}</td> 
                                <td>{{$datas->masakredit}}</td>     
                                <td>{{$akrual->HitungSdAkhir($datas->tglproses,$datas->tglrealisasi,$datas->tgljatuhtempo,$dari,$sampai,null)}}</td>     
                                <td  align="right">{{number_format( $datas->plafon, 0, ',', '.')}}</td>      
                                <td  align="right">{{number_format( $share = $datas->penjaminan->reasuransi->share_risk, 0, ',', '.')}}</td>      
                                <td  align="right">{{number_format( $nilaiPenjaminan=$datas->plafon*$share/100, 0, ',', '.')}}</td>      
                                <td  align="right">{{number_format( $penjaminanJamkrida=$datas->plafon-$datas->nilai_jaminan, 0, ',', '.')}}</td>      
                                <td  align="right">{{number_format( $penjaminanReas=$datas->nilai_jaminan, 0, ',', '.')}}</td>      
                                <!--<td>{{$datas->rate}}</td>-->     
                                <td align="right">{{number_format( $datas->premi, 0, ',', '.')}}</td>       
                                <td align="right">{{number_format( $datas->pot, 0, ',', '.')}}</td>       
                                <td align="right">{{number_format( $datas->nett, 0, ',', '.')}}</td>  
                                <td align="right">{{number_format( $nettJamkrida=$datas->nett-($datas->nett*$datas->share_risk/100), 0, ',', '.')}}</td>  
                                <td align="right">{{$datas->share_risk}}</td>  
                                <td align="right">{{number_format( $ijpreas=$datas->nett*$datas->share_risk/100, 0, ',', '.')}}</td>  
                                <td align="right">{{number_format( $ricommision=$ijpreas*$datas->commision/100, 0, ',', '.')}}</td>  
                                <td align="right">{{number_format( $nettijpreas=$ijpreas-$ricommision, 0, ',', '.')}}</td>  
                                @if($datas->jenispenjaminan='KREDIT DENGAN PEMBAYARAN MUSIMAN(PLAFOND)')
                                <td align="right">MACET KARENA MENINGGAL DUNIA</td>  
                                @else
                                <td align="right">{{$datas->jenispenjaminan}}</td>  
                                @endif 
                            </tr>
                            <?php
                            $totalplafond = $totalplafond + $datas->plafon;
                            $totalgrossijp = $totalgrossijp + $datas->premi;
                            $totaldis = $totaldis + $datas->pot;
                            $totalnetijp = $totalnetijp + $datas->nett;
                            $totalnetijpJamkrida = $totalnetijpJamkrida + $nettJamkrida;
                            $totalnetijpReasuransi = $totalnetijpReasuransi + $ijpreas;
                            $totalPenjaminanReasuransi = $totalPenjaminanReasuransi + $penjaminanReas;
                            $totalPenjaminanJamkrida = $totalPenjaminanJamkrida + $penjaminanJamkrida;
                            $totalricommision = $totalricommision + $ricommision;
                            $totalnettijpreas = $totalnettijpreas + $nettijpreas;
                            $totalnilaiPenjaminan = $totalnilaiPenjaminan + $nilaiPenjaminan;

                            $i++
                            ?>
                            @endforeach
                            <tr style="background-color:#e0e0e0 ;color: #000000">
                                <td align='center' colspan="10">TOTAL</td>
                                <td align='right'><b>{{number_format( $totalplafond, 0, ',', '.')}}</b></td>
                                <td align='right'><b></b></td>
                                <td align='right'><b>{{number_format( $totalnilaiPenjaminan, 0, ',', '.')}}</b></td>
                                <td align='right'><b>{{number_format( $totalPenjaminanJamkrida, 0, ',', '.')}}</b></td>
                                <td align='right'><b>{{number_format( $totalPenjaminanReasuransi, 0, ',', '.')}}</b></td> 
                                <td align='right'><b>{{number_format( $totalgrossijp, 0, ',', '.')}}</b></td>
                                <td align='right'><b>{{number_format( $totaldis, 0, ',', '.')}}</b></td>
                                <td align='right'><b>{{number_format( $totalnetijp, 0, ',', '.')}}</b></td>
                                <td align='right'><b>{{number_format( $totalnetijpJamkrida, 0, ',', '.')}}</b></td>
                                <td align='right'><b> </b></td>
                                <td align='right'><b>{{number_format( $totalnetijpReasuransi, 0, ',', '.')}}</b></td>
                                <td align='right'><b>{{number_format( $totalricommision, 0, ',', '.')}}</b></td>
                                <td align='right'><b>{{number_format( $totalnettijpreas, 0, ',', '.')}}</b></td>
                                <td align='right'></td> 
                            </tr>
                        </tbody>
                    </table> 
       
    </body>
<br>
 

 

 