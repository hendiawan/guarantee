@extends('layout.admin')
@section('content')
<body ng-app="Penjaminan" ng-controller="PenjaminanController">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <h2 align="center">PENGAJUAN PENJAMINAN KREDIT</h2>
                    <h2 style="color:red" align="center">SUDAH TERBIT SERTIFIKAT</h2>
                    <h2 align="center">({{$pengajuan[0]['namabank']}})</h2>
                </strong>
            </div>
            <div class="panel-body">
                <section  class="col-lg-13 connectedSortable">
                    <!-- Map box -->
                    <div class="box box-solid">         
                        <table id="tabelpembayaran" class=" table table-hover"  style="font-size: 11px; border: 1px; border-color:  black"    >
                            <thead>
                                <tr style="width: 30px; background-color:#23527c ;color: #000000">
                                    <th>NO</th>
                                    <th>NO SERTIFIKAT</th>   
                                    <th>TGL TERBIT</th>   
                                    <th>NO KTP</th>
                                    <th>NAMA</th>                        
                                    <th>LAHIR</th>                   
                                    <th>JENIS KREDIT</th>
                                    <th>PLAFON</th>
<!--                                 <th>UMUR</th>
                                    <th>PEKERJAAN</th>                              
                                    <th>NO PK</th>
                                    <th>MULAI TGL</th>
                                    <th>SAMPAI TGL</th>                           
                                    <th>JUMLAH</th>                                
                                   -->
    <!--                                <th>RATE IJP(%)</th>
                                    <th>JUMLAH IJP</th>
                                    <th>DISC(Rp)</th>
                                    <th>NET. IJP(Rp)</th>-->
<!--                                    <th>QR</th>                           -->
                                    <th>DOKUMEN</th>                           

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $premi = 0;
                                $dis = 0;
                                $nett = 0;
                                ?>
                                @foreach($pengajuan as $data)           
                                <tr style="background-color:#bdbdbd ;color: #000000">  
                                    <td>{{$i}}</td>
                                    <td>{{$data -> kodesertifikat}}</td> 
                                    <td>{{date('d-m-Y', strtotime($data -> tglterbit))}}</td>    
                                    <td>{{$data -> ktp}}</td> 
                                    <td>{{$data -> nama}}</td> 
                                    <td>{{$data -> tgllahir}}</td>    
                                    <td>{{$data -> jeniskredit}}</td>
<!--                                    <td>{{$data -> umurjatuhtempo}}</td>                                                        
                                    <td>{{$data -> pekerjaan}}</td>
                                  
                                    <td>{{$data -> nopk}}</td>
                                    <td>{{date('d-m-Y', strtotime($data -> tglrealisasi))}}</td>                            
                                    <td>{{date('d-m-Y', strtotime($data -> tgljatuhtempo))}}</td>                            
                                    <td>{{$data -> masakredit}} Bln</td>-->
                                    <td>{{number_format($data -> plafon, 0, ',', '.')}}</td>
    <!--                                <td>{{$data ->rate}}</td>
                                    <td>{{number_format($data ->premi, 0, ',', '.')}}</td>
                                    <td>{{number_format($data ->pot, 0, ',', '.')}}</td>
                                    <td>{{number_format($data ->nett, 0, ',', '.')}}</td>-->
<!--                                    <td>
                                        <img src="https://chart.googleapis.com/chart?chs=70x70&cht=qr&chl={{$data -> nosertifikat}}" title="Link to Google.com">
     
                                    </td>-->
                                    <td>
                                        <div class=" btn-group-vertical">
                                            <a target="_blank" class="btn btn-primary" href="/cetaksertifikat/{{$data -> nosertifikat}}">Cetak Sertifikat</a>
<!--                                       <a class="btn btn-primary btn-xs" href="/cetakdaftarsertifikat/{{$data -> nosertifikat}}">Cetak Daftar</a>-->
                                        </div>
                                    </td>                         


                                </tr>
                                <?php
                                $i++;
                                $premi = $premi + $data->premi;
                                $dis = $dis + $data->pot;
                                $nett = $nett + $data->nett;
                                ?>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </section>  
            </div>
        </div>
</body>
 
@endsection

 