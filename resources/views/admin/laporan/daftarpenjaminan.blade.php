<html>
    <head>
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
    <body>
    <center>
        
      <h1><img style="vertical-align:middle;margin-left: -14%;"  src="img/jamkrida.jpg"class="img-responsive" width='10%'  alt="User Image">
DAFTAR PENJAMINAN KREDIT {{strtoupper($sertifikat['sertifikat'][0]['jeniskredit'])}}</h1>
        <h3>{{strtoupper($sertifikat['sertifikat'][0]['namabank'])}}</h3>
        <h3>Nomor : {{strtoupper($sertifikat['sertifikat'][0]['kodesertifikat'])}}</h3>
       
        <table class="table table-hover"  style="font-size: 11px;border: 1px; border-color:  black" >
            <thead>
                <tr style="background-color:#23527c ;color: #000000">
                    <th>NO</th>                          
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
                    <th>RATE(%)</th>
                    <th>GROSS IJP</th>
                    <th>DISC(Rp)</th>
                    <th>NET. IJP(Rp)</th>               
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                ?>
                @foreach($sertifikat['sertifikat'] as $datas)

                <tr style="background-color:#bdbdbd ;color: #000000">  
                    <td>{{$i}}</td>
                    <td>{{$datas->ktp}}</td>
                    <td>{{$datas->nama}}</td>
                    <td>{{$datas->jeniskredit}}</td>
                    <td>{{date('d-m-Y', strtotime($datas->tgllahir))}}</td> 
                    <td>{{$datas->umur}}</td>
                    <td>{{strtoupper($datas->pekerjaan)}}</td>
                    <td>{{date('d-m-Y', strtotime($datas->tglrealisasi))}}</td> 
                    <td>{{date('d-m-Y', strtotime($datas->tgljatuhtempo))}}</td> 
                    <td>{{$datas ->masakredit}}</td>     
                    <td>{{number_format( $datas ->plafon, 0, ',', '.')}}</td>      
                    <td>{{$datas->rate}}</td>     
                    <td align="right">{{number_format( $datas ->premi, 0, ',', '.')}}</td>       
                    <td align="right">{{number_format( $datas ->pot, 0, ',', '.')}}</td>       
                    <td align="right">{{number_format( $datas ->nett, 0, ',', '.')}}</td>  

                </tr>

                <?php $i++ ?>
                @endforeach
            </tbody>
        </table>
        <table>
            <tr>
                <td>Terbilang : <b><i>{{strtoupper($terbilang)}}</i></b></td>
                
            </tr>
        </table>
        <table>
            <tr>
                <th>Diterbitkan di </th>
                <th>:</th>
                <th>Mataram</th>   
            </tr>
            <tr>
                <th>Pada Tanggal</th>
                <th>:</th>
                <th>{{date('d-m-Y',strtotime($sertifikat['sertifikat'][0]['tglterbit']))}}</th>   
            </tr>
        </table>
        <br>
        <br>
        <br>
        <br>
        <table>
            <tr>
                <th><u>INDRA MANTHICA</u></th>
            </tr>
        </table>
         
        <table>
            <tr>             
               <th>Direktur Utama</th>
            </tr>
        </table>
        
      </center>
    <br>
    <img src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(100)->generate(md5(base64_encode($sertifikat['sertifikat'][0]['nosertifikat'])))) }} ">
 
    
</body>
</html>

