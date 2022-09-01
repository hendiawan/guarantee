@extends('layout.admin')
@section('content')


<body ng-app="Penjaminan" ng-controller="PenjaminanController">
     <div class="panel panel-default">
    <div class="panel-heading">
        <strong>
        <h2 align="center">DATA PENGAJUAN ULANG</h2>
        <h2 style="color: red" align="center">BELUM VERIFIKASI</h2>
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
                                <th>Kode Bayar</th>
                                <th>Nama Bank</th>
                                <th>Tgl Pengajuan</th>                           
                                <th>Tgl Bayar</th>                      
                                <th>Nama Terjamin</th>                      
                                <th>Jns Kredit</th>
<!--                                <th>Tgl Realisasi</th>
                                <th>Tgl Jth Tempo</th>                           -->
                                <th>Masa Kredit</th>                           
                                <th>Plafon</th>                          
                                <th>Aging</th>                     
                                <th>Dokumen Pendukung</th>                     
                                                   
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
                                <td>{{$data -> kodebayar}}</td>  
                                <td>{{$data -> namabank}}</td>  
                                <td>{{date('d-m-Y', strtotime($data -> tglpengajuan))}}</td>    
                                <td>{{$bayar}}</td> 
                                <td>{{$data -> nama}}</td>                                                        
                                <td>{{$data -> jeniskredit}}</td>
<!--                                <td>{{date('d-m-Y', strtotime($data -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($data -> tgljatuhtempo))}}</td>                            -->
                                <td>{{$data -> masakredit}} Bln</td>
                                <td>{{number_format($data -> plafon, 0, ',', '.')}}</td>
                               
                                <td><b><p style="color: red;font-size: 15px">{{aging($data -> tglpengajuan) }}</p></b>Hari</td>                    
                               <td>
                                       <li><a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary" href="cetaksuratpengajuanadmin/{{$data ->nosertifikat}}"  style="color: black"><b>Cetak Surat Pengajuan</b></a></li>                               
                                       <li <?php if ($data->files == '' ) {echo 'hidden=""';} ?>><a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary" target="_blank" href="@if($data->url_penjaminan!=null)<?php echo $data -> url_penjaminan.$data -> files ?>@else files/suratsehatrs/{{$data -> files}} @endif">Download Surat Sehat Terjamin</a></li>
                                       <li><b style="color: red"> <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-info uploadsuratsehat"  href=""  id="{{$data -> idpenjaminan}}" style="color: red">Upload Surat Sehat Terjamin</a></b></li>
                                       <li <?php if ($data->files3 == '' ) {echo 'hidden=""';}?> > <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary" target="_blank" href="@if($data->url_penjaminan!=null)<?php echo $data -> url_penjaminan.$data -> files3 ?>@else files/suratsehatrs/{{$data -> files3}} @endif">Download Surat Sehat RS</a></li>
                                       <li <?php if ($data->plafon<100000000) { echo 'hidden=""';} ?>> <b style="color: red;"> <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-info uploadsuratsehatRs"   href=""   id="{{$data -> idpenjaminan}}" style="color: red">Upload Surat Sehat Dari RS</a></b></li>
                                       <li <?php if ($data->files2 == '') { echo 'hidden=""';} ?>><a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary"  target="_blank" href="@if($data->url_penjaminan!=null)<?php echo $data -> url_penjaminan.$data -> files2 ?>@else files/scanlab/{{$data -> files2}} @endif">Download Dokumen Cek Lab</a></li>
                                       <li <?php if ($data->plafon<200000000) { echo 'hidden=""';} ?>><b><a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-info uploadscanlab" href="" id="{{$data -> idpenjaminan}}" style="color: red">Upload Cek Lab</a></b></li>
                                       <li><a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary"  target="_blank"  href="@if($data->url_penjaminan!=null)<?php echo $data -> url_penjaminan.$data -> file ?>@else files/scanlab/{{$data -> file}} @endif">Download Bukti Bayar</a></li>
                                       <li><b style="color: red"> <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-info uploadbuktibayar"  href="" c id="{{$data->idpenjaminan}}" style="color: red">Upload Bukti Bayar</a></b></td></li>
 
                                </td> 
                                <td>
                                    <!--<a id="{{$data->nosertifikat}}" class="btn btn-xs btn-primary klickvalidasi">VERIFIKASI</a>-->
                                    <a href="/detailPenjaminan/{{$data->idpenjaminan}}"class="btn btn-xs btn-danger ">DETAIL</a>
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
   @include('admin.modal')
   @include('admin.modal_dokumen')
</body>   
<br>
<br>

@if($i<2)

<script>
  alert('Silahkan  lanjut ke proses Penerbitan sertifikat');
  window.location.href = "sudahsetujuall";
</script>

@endif

@endsection



 