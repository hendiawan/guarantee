@extends('layout.admin')
@section('content')


<ul class="nav nav-tabs">
<!--    <li>
        <button type="button" name="add_button" ng-click="addDataPenjaminan()" class="btn btn-primary">ADD PENJAMINAN</button>
    </li>  -->
</ul>

<body ng-app="Penjaminan" ng-controller="PenjaminanController">
<div class="panel panel-default">
    <div class="panel-heading">
        <strong><h2 align="center">Cek Pengajuan Penjaminan Case By Case Belum Bayar {{$pengajuan[0]['namabank']}}</h2></strong>
    </div>
    <div class="panel-body">
             <section  class="col-lg-13 connectedSortable">
        <!-- Map box -->
        <div class="box box-solid">  
            <div class="container">
                <table id="tabelpembayaran" class=" table table-hover"  style="font-size: 11px;  border: 1px; border-color:  black"    >
                        <thead>
                            <tr style="width: 30px; background-color:#23527c ;color: #000000">
                                <th>No</th>
                                <th>Kode Bayar</th>
                                <th>Tgl Pengajuan</th>                           
                                <th>Tgl Bayar</th>                      
                                <th>Nama</th>                      
                                <th>Jns Kredit</th>
                                <th>Realisasi</th>
                                <th>Tempo</th>                           
                                <th>Masa Kredit</th>                           
                                <th>Plafon</th>                          
                                <th>Aging</th>
                                <th>Proses</th>                           
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
                           <?php
                           
                           if ($data -> tglbayar!=''){
                                $bayar=date('d-m-Y', strtotime($data -> tglbayar));
                                $kode=$data -> kodebayar;
                           }else{
                               $bayar='Belum Bayar';
                               $kode='Belum Bayar';
                           }
                            
                           ?>
                             
                            
                            
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{$bayar}}</td>
                                <td>{{date('d-m-Y', strtotime($data -> tglpengajuan))}}</td>    
                                <td>{{$bayar}}</td> 
                                <td>{{$data -> nama}}</td>                                                        
                                <td>{{$data -> jeniskredit}}</td>
                                <td>{{date('d-m-Y', strtotime($data -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($data -> tgljatuhtempo))}}</td>                            
                                <td>{{$data -> masakredit}} Bln</td>
                                <td>{{number_format($data -> plafon, 0, ',', '.')}}</td>
                                <td><b><p style="color: red;font-size: 15px">{{aging($data -> tglpengajuan) }}</p></b>Hari</td>
                                <td><a id="{{$data ->idpenjaminan}}" class="btn btn-xs btn-primary validasicaseBelumBayar">Validasi</a></td>                         

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
                
            
        </div>
    </section>  
    </div>
</div>
@include('admin.modalcasebelumbayar')
</body>   
<br>
<br>
@endsection

 