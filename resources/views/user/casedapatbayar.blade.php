@extends('layout.user')
@section('content')


<body ng-app="Penjaminan" ng-controller="PenjaminanController">
<div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <h2 align="center">PENGAJUAN PENJAMINAN KREDIT CASE BY CASE SUDAH DISETUJUI</h2>
                <h3 style="color: red" align="center">SILAHKAN LAKUKAN PROSES PEMBAYARAN UNTUK PENGAJUAN DI BAWAH INI</h3>
            </strong>
        </div>
        <div class="panel-body">
             <table class="table table-hover"  style="font-size: 11px;border: 1px; border-color:  black;" id="tabelcasebycase"  >
                        <thead>
                            <tr style="background-color:#23527c ;color: #000000">
                                <th>No</th>
                                <th>Tgl Pengajuan</th>                           
                                <th>No KTP</th>
                                <th>Nama</th>                        
                                <th>Umur</th>                     
                                <th>Jenis Kredit</th>
                                <th>Realisasi</th>
                                <th>Tempo</th>                           
                                <th>Plafon</th>                               
                                <th>Penjaminan</th>
                                <th>Aging</th>
                                <th>Dokumen</th>  
<!--                                <th>Status</th>-->
<!--                                <th>Catatan</th>-->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;

                            function aging($tanggal) {
                                $tanggal1 = new DateTime($tanggal);
                                $tanggal2 = new DateTime();
                                return $aging = $tanggal2->diff($tanggal1)->format("%a");
                            }
                            ?>
                            @foreach($data as $datas)
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tglpengajuan))}}</td>     
                                <td>{{$datas -> ktp}}</td>
                                <td>{{$datas -> nama}}</td>
                                <td>{{$datas -> umur}}</td>                           
                                <td>{{$datas -> jeniskredit}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tgljatuhtempo))}}</td>                            
                                <td>{{$datas -> plafon}}</td>
                                <td>{{$datas -> jenispenjaminan}}</td>
                                <td><b><p style="color: red;font-size: 15px">{{aging($datas -> tglpengajuan) }}</p></b>Hari</td>

                                
                                <td>
                                    <div>
                                        <li><a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary"  target="_blank"  href=" /cetaksp3/{{$datas -> nosertifikat}}">Cetak SP3</a></li>
                                        <li <?php if ($datas->files == '' ) {echo 'hidden=""';} ?>><a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary"  target="_blank"  href="  @if($datas->url_penjaminan!=null) <?php echo url( $datas->url_penjaminan.$datas->files)?> @else files/suratsehat/{{$datas -> files}} @endif">Surat Sehat</a></li>
                                       <li> <b style="color: red"> <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary uploadsuratsehat"  href=""  id="{{$datas -> idpenjaminan}}" style="color: red">Upload Surat Sehat</a></b></li>
                                       <li <?php if ($datas->files3 == '' ) {echo 'hidden=""';$hide='true';}else{$hide='';} ?> > <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary"   target="_blank"  href="@if($datas->url_penjaminan!=null) <?php echo url( $datas->url_penjaminan.$datas->files3)?> @else files/suratsehatrs/{{$datas -> files3}} @endif">Ket. Sehat</a></li>
                                       <li <?php if ($datas->plafon<100000000) { echo 'hidden=""';} ?>> <b style="color: red;"> <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary uploadsuratsehatRs" href=""   id="{{$datas -> idpenjaminan}}" style="color: red">Upload Surat Sehat RS</a></b></li>
                                       <li <?php if ($datas->files2 == '') { echo 'hidden=""';} ?>><a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary"   target="_blank"  href="@if($datas->url_penjaminan!=null) <?php echo url( $datas->url_penjaminan.$datas->files2)?> @else files/scanlab/{{$datas -> files2}} @endif">Cek Lab</a></li>
                                       <li <?php if ($datas->plafon<200000000) { echo 'hidden=""';} ?>><b><a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary uploadscanlab"  href="" id="{{$datas -> idpenjaminan}}" style="color: green">Upload Scan Lab</a></b></li>
                                       
                                  </div> 
                                </td>  
                               
<!--                                <td><a style="color: red"><b>{{strtoupper($datas->app)}}</b></a></td>-->
<!--                                <td><b>{{$datas->catatan}}</b></td>-->
                                <td>
                                <div  class=" btn-group-vertical">
                                   
                                    <a ng-hide="<?php if($datas->app==''||$datas->app=='Tolak'||$datas->app=='Pengecekan'){echo 'true';} ?>" href="/prosesbayarcase/{{ base64_encode($datas -> nosertifikat)}}" class="btn btn-primary">Bayar</a>
                                </div>
                                    
                                </td>
                            </tr>
                            <?php $i++ ?>
                            @endforeach
                        </tbody>
                    </table>
        </div>
    </div>
    @include('user.modal')
</body>

@endsection


