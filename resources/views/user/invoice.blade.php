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
        <h2>BUKTI PEMBAYARAN</h2>
        <table>
            <tr>
                <th>Nomor</th>
                <th>#{{$bayar[0]['kodebayar']}}</th>
            </tr><tr>
                <th>Tanggal Bayar &nbsp;</th>
                <th>: {{$bayar[0]['tglbayar']}}</th>
            </tr>
        </table>
        <h3>DATA PEMBAYARAN</h3>
        <table>
            <tr>
                <th>Nama</th>
                <th>: {{$bayar[0]['namabank']}}</th>
            </tr>
        </table>
        <h3>DETAIL PEMBAYARAN</h3>
        <table id="tabelpembayaran" class=" table table-hover"  style="font-size: 11px;  margin-left: -5%; border: 1px; border-color:  black"    >
            <thead>
                <tr style="width: 30px; background-color:#23527c ;color: #000000">


                    <th>Tanggal Pengajuan</th>                         
                    <th>Nama Terjamin</th>                      
                    <th>Jenis Kredit</th>
                    <th>Realisasi</th>
                    <th>Tempo</th>                           
                    <th>Masa Kredit</th>                           
                    <th>Plafon</th>
                    <th>Penjaminan</th>                           
                    <th>Rate</th>                           
                    <th>Premi</th>                           
                    <th>Discount</th>                           
                    <th>Potongan</th>                           
                    <th>Nett</th>                           
                    <th>Status</th>                           
                </tr>
            </thead>
            <tbody>

                @foreach($bayar as $datas)
                <tr style="background-color:#bdbdbd ;color: #000000">  


                    <td>{{date('d-m-Y', strtotime($datas -> tglpengajuan))}}</td>     

                    <td>{{$datas -> nama}}</td>                                                        
                    <td>{{$datas -> jeniskredit}}</td>
                    <td>{{date('d-m-Y', strtotime($datas -> tglrealisasi))}}</td>
                    <td>{{date('d-m-Y', strtotime($datas -> tgljatuhtempo))}}</td>                            
                    <td>{{$datas -> masakredit}} Bulan</td>
                    <td>{{number_format($datas -> plafon, 0, ',', '.')}}</td>
                    <td>{{$datas -> jenispenjaminan}}</td>                         
                    <td>{{$datas -> rate}}</td>                         
                    <td>{{number_format($datas -> premi, 0, ',', '.')}}</td>                         
                    <td>{{$datas -> dis}}</td>                         
                    <td>{{number_format($datas -> pot, 0, ',', '.')}}</td>                         
                    <td>{{number_format($datas -> nett, 0, ',', '.')}}</td>                         
                    <td>{{ strtoupper( $datas -> app)}}</td>

                </tr>

                @endforeach
            </tbody>
        </table>
    </body>
</html>

