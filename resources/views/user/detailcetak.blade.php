@extends('layout.user')
@section('content')


<body ng-app="Penjaminan" ng-controller="PenjaminanController">
<div class="container">
    
   
<!--        <h2 align="center">PENGAJUAN PENJAMINAN KREDIT</h2>-->
    <h2  align="center">Detail Cetak Sertifikat</h2>
         <div class="box box-solid">
                    <br>                      
                    <table id="tabel-test" class=" table table-hover"  style="font-size: 12px; border: 1px; border-color:  black"    >
                        <thead>
                            <tr style="width: 30px; background-color:#23527c ;color: #000000">
                                <th>NO</th> 
                                <th>NOMOR SERTIFIKAT</th>                         
                                <th>TERBIT</th>                         
                                <th>TERJAMIN</th>                      
                                <th>JNS KERDIT</th>
                                <th>MULAI</th>
                                <th>SAMPAI</th>                           
                                <th>MASA</th>                           
                                <th>PLAFON(Rp.)</th>
                                <th>TANGGAL CETAL</th> 
                                <th>USER CETAK</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $premi = 0;
                            $dis = 0;
                            $nett = 0;                            
                             
                            ?>
                            @foreach($data as $datas)
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{$datas -> kodesertifikat}}</td>  
                                <td>{{date('d-m-Y', strtotime($datas -> tglterbit))}}</td>
                                <td>{{$datas -> nama}}</td>                                                        
                                <td>{{$datas -> jeniskredit}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tgljatuhtempo))}}</td>                            
                                <td>{{$datas -> masakredit}} Bln</td>
                                <td>{{number_format($datas -> plafon, 0, ',', '.')}}</td>
                                <td>{{$datas -> tglcetak}} </td>
                                <td>{{strtoupper($datas -> oleh)}} </td>
                            </tr>
                            <?php
                            $i++;
                             
                            ?>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    </tbody>

                </div>
     
</div>
</body>

@endsection
