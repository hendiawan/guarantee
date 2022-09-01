<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Cetak Sertifikat Penjaminan Kredit</title>
        <style type="text/css">
         body{
                font-family: 'Dejavu Sans';
                font-size: 12px;
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
    <body >  
    <body >  
        @if($data['jeniskredit']=='%')
           <h3 align="center">REKAP  PENJAMINAN KREDIT {{$data['data'][0]['bank']['namabank']}} </h3>
        @else
           <h3 align="center">REKAP  PENJAMINAN KREDIT {{$data['data'][0]['jeniskredit']}} </h3>
        @endif   
        <hr>   
        <table cellspacing="0" width="100%">
            <tr>
                <td width="10%">Nama Bank</td>
                <td>: {{$data['data'][0]['bank']['namabank']}}</td>
            </tr>
            <tr>
                <td width="10%">Periode</td>
                <td>: {{date('d/m/Y',strtotime($data['dari']))}} - {{date('d/m/Y',strtotime($data['sampai']))}}</td>
            </tr>
        </table>
        <table style="line-height: 9px;margin-top: 10px" class="data" cellspacing="0" cellpadding="2" width="100%" border="1">
            <thead>
                <tr >
                    <th>NO</th>
                    <th>TGL PENGAJUAN</th>                           
                    <th>NO SERTIFIKAT</th>
                    <th>NO PK</th>   
                    <th>NAMA TERJAMIN</th>  
                    <th>UMUR</th>					
                    <th>JENIS KREDIT</th>   
                    <th>PEKERJAAN</th>
                    <th>MULAI TGL</th>
                    <th>SAMPAI TGL</th>                           
                    <th>(Bln)</th>                                
                    <th>PLAFON (Rp)</th>
                    <th>RATE(%)</th>
                    <th>GROSS IJP (Rp)</th>
                    <th>DISC(Rp)</th>
                    <th>NET. IJP(Rp)</th> 
                </tr>
            </thead>
          
                <?php
                $i = 1;
                $totalpenjaminan = 0;
                $totalgrossijp = 0;
                $totaldis = 0;
                $totalnetijp = 0;

                function aging($tanggal) {
                    $tanggal1 = new DateTime($tanggal);
                    $tanggal2 = new DateTime();
                    return $aging = $tanggal2->diff($tanggal1)->format("%a");
                }
                ?>
                @foreach( $data['data'] as $datas)

                <tr style="background-color:#bdbdbd ;color: #000000">  
                    <td>{{$i}}</td>
                    <td>{{date('d-m-Y', strtotime($datas->tglpengajuan))}}</td>     
                    <td>{{$datas->kodesertifikat}}</td>
                    <td>{{$datas->nopk}}</td> 
                    <td>{{$datas->terjamin->nama}}</td>
                    <td>{{$datas->terjamin->umur}}</td>
                    <td>{{$datas->jeniskredit}}</td>  
                    <td>{{strtoupper($datas->terjamin->pekerjaan)}}</td>
                    <td>{{date('d-m-Y', strtotime($datas->tglrealisasi))}}</td> 
                    <td>{{date('d-m-Y', strtotime($datas->tgljatuhtempo))}}</td> 
                    <td  align="right">{{$datas->masakredit}}</td>     
                    <td  align="right">{{number_format( $datas->plafon, 0, ',', '.')}}</td>      
                    <td align="right">{{$datas->rate}}</td>     
                    <td align="right">{{number_format( $datas->premi, 0, ',', '.')}}</td>       
                    <td align="right">{{number_format( $datas->pot, 0, ',', '.')}}</td>       
                    <td align="right">{{number_format( $datas->nett, 0, ',', '.')}}</td>  
                </tr>


                <?php
                $totalpenjaminan = $totalpenjaminan + $datas->plafon;
                $totalgrossijp = $totalgrossijp + $datas->premi;
                $totaldis = $totaldis + $datas->pot;
                $totalnetijp = $totalnetijp + $datas->nett;
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
            
        </table> 
        </body>                

 
<br>
    
</html>
    
 

 

 