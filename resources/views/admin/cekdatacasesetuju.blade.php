@extends('layout.admin')
@section('content')


<body ng-app="Penjaminan" ng-controller="PenjaminanController">
     <div class="panel panel-default">
    <div class="panel-heading">
        <strong>
        <h2 align="center">DATA PENGAJUAN PENJAMINAN KREDIT</h2>
        <h2 style="color: red" align="center">CASE BY CASE SUDAH DI APPROV DIREKSI</h2>
        </strong>
    </div>
    <div class="panel-body">
             <section  class="col-lg-13 connectedSortable">
        <!-- Map box -->
        <div class="box box-solid">   
                <table id="tabelpembayaran" class=" table table-hover"  style="font-size: 11px;  border: 1px; border-color:  black"    >
                        <thead>
                            <tr style="width: 30px; background-color:#23527c ;color: #000000">
                                <th>No</th>
                                <th>Nama Bank</th>
                                <th>Tgl Pengajuan</th>   
                                <th>Nama Terjamin</th>                      
                                <th>Jns Kredit</th>
<!--                            <th>Tgl Realisasi</th>
                                <th>Tgl Jth Tempo</th>                           -->
                                <th>Masa Kredit</th>                           
                                <th>Plafon</th>                          
                                <th>Aging</th>                     
                                <th>Analisa Staff</th>       
                                <th>Tanggapan Direksi</th>       
                                <th>Approval</th>  
                                <th>Action</th>                           
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $premi = 0;
                            $dis = 0;
                            $nett = 0;
                             function aging($tanggal) {
                                $tanggal1 = new DateTime($tanggal);
                                $tanggal2 = new DateTime();
                                return  $aging = $tanggal2->diff($tanggal1)->format("%a");
                            }
                            
                            ?>
                            @foreach($pengajuan as $data)
                           
                             
                            
                            
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                               
                                <td>{{$data -> namabank}}</td>  
                                <td>{{date('d-m-Y', strtotime($data -> tglpengajuan))}}</td>    
                              
                                <td>{{$data -> nama}}</td>                                                        
                                <td>{{$data -> jeniskredit}}</td>
<!--                                <td>{{date('d-m-Y', strtotime($data -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($data -> tgljatuhtempo))}}</td>                            -->
                                <td>{{$data -> masakredit}} Bln</td>
                                <td>{{number_format($data -> plafon, 0, ',', '.')}}</td>
                               
                                <td><b><p style="color: red;font-size: 15px">{{aging($data -> tglpengajuan) }}</p></b>Hari</td>                    
                                <td>{{$data ->hasil_akhir}}</td>                    
                                <td>{{$data ->tanggapandir}}</td>  
                                <td>@if($data ->app=='CaseSetuju') Setuju @else Tolak @endif</td>  
                                <td>
                                    <div class=" btn-group-vertical">
                                    @if($data ->app=='CaseSetuju')
                                    <a id="{{$data->nosertifikat}}" target="_blank" href="/cetaksp3/{{$data->nosertifikat}}" class="btn  btn-warning">Draft SP3</a>
                                    <a id="{{$data->idpenjaminan}}" class="btn  btn-success klickvalidasisp3">Terbitkan SP3</a>
                                    @else
                                    <a id="{{$data->idpenjaminan}}" class="btn  btn-warning validasicaseBelumBayar">Ajukan Kembali</a>
                                    <a id="{{$data->idpenjaminan}}" class="btn  btn-danger klickvalidasitolak">Tolak</a>
                                    @endif
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
<!--  ('admin.modal')-->
   @include('admin.modalcasebelumbayar')
   @include('admin.modalTolak')
</body>   
<br>
<br>
@endsection



 