
@extends('layout.user')
@section('content')
<!--<div align="center">
    <button type="button" name="add" id="add_data" class="btn btn-success btn-sm">Add</button>
</div>-->
<body>
  
    <div  style="margin-top: 35px;"class="row">
     <div class="container-fluid">
          <section class="col-lg-12"> 
         @if (Session::has('pesan'))
                    <div class="alert alert-warning alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ Session::get('pesan') }}
                    </div>
        @endif          
                    
        @if(Session::get('level')!='User')
        @if (Session::has('ubahpass'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <b><a href="logout" style="color:green">Password berhasil di ubah, silahkan Logout kemudian Login kembali</a></b>
        </div>
        @endif
        @if (Session::has('message'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('message') }}
        </div>
        @endif
        @if($totalbaru>0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <a href="prosesbayar" style="color:red">Anda memiliki <b style="color: black">{{$totalbaru}}</b> pengajuan penjaminan, silahkan lanjutkan ke proses<b style="color:black"> Pembayaran</b> !!!</a>
        </div>
        @endif
        @if($totalcasedapatbayar>0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <a href="CaseSudahBayar" style="color:red">Anda memiliki <b style="color: black" >{{$totalcasedapatbayar}}</b> pengajuan  <b style="color: black">Case By Cases</b> yang <b style="color: black">sudah disetujui</b>, Silahkan lakukan diproses pembayaran</a>
        </div>
        @endif
        @if($totalrevisi>0)
        <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <a href="Revisi" style="color:red">Anda memiliki <b style="color: black" >{{$totalrevisi}}</b> pengajuan  yang <b style="color: black">perlu direvisi</b>, Silahkan cek detail data !!!</a>
        </div>
        @endif
        @if($totaldisetujui>0)
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <a href="setuju" style="color:green">Anda memiliki <b>{{$totaldisetujui}}</b> pengajuan penjaminan yang sudah disetujui</a>
        </div>
        @endif

        @if($totalditolak>0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <a href="tolak" style="color:red">Anda memiliki <b style="color: black">{{$totalditolak}}</b> pengajuan penjaminan yang<b style="color: black"> ditolak</b></a>
        </div>
        @endif

        @if($totalcetak>0)
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <a href="viewsertifikatcetak" style="color:green">Anda memiliki <b>{{$totalcetak}}</b> pengajuan  yang sudah di terbitkan sertifikat</a>
        </div>
        @endif
        @endif
        
          </section>
         
      
    
        <section class="col-lg-12 ">
            <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Menu Utama</strong>
            </div>
            <div class="panel-body box-solid">
                <ul class="nav nav-tabs ">
                    <li class="active"><a  style="color: black" class="label label-default "  data-toggle="tab" href="#pengajuanbaru">Pengajuan Penjaminan @if($totalbaru>0) <span class="label label-danger">{{$totalbaru}}</span>@endif</a></li>
                    <li><a style="color: black;" class="label label-default"  data-toggle="tab" href="#casebycase">Pengajuan Case by Case  @if($totalcasebycase>0) <span class="label label-danger">{{$totalcasebycase}}</span>@endif</a></li>
<!--                    <li><a style="color: black" class="label label-info"   data-toggle="tab" href="#sudahbayar">Sudah Bayar @if($totalsudahbayar>0) <span class="label label-danger">{{$totalsudahbayar}}</span>@endif</a></li>
                    <li><a style="color: black" class="label label-info"  data-toggle="tab" href="#setuju">Sudah Di Setujui @if($totaldisetujui>0) <span class="label label-danger">{{$totaldisetujui}}</span>@endif </a></li>-->
                    <li><a style="color: black"  class="label label-default"  data-toggle="tab" href="#ditolak">Pengajuan Ditolak @if($totalditolak>0) <span class="label label-danger">{{$totalditolak}}</span>@endif </a></li>
                    <li><a style="color: black"  class="label label-default"  data-toggle="tab" href="#dapatcetak"> Sertifikat Terbit @if($totalcetak>0) <span class="label label-danger">{{$totalcetak}}</span>@endif</a></li>
                    <li><a style="color: black"  class="label label-default"  data-toggle="tab" href="#laporan">Rekap Pengajuan</a></li>
                </ul>
            </div>
        </div> 
    
<div class="tab-content">
<!--    //pengajuan belum bayar--> 
    <div id="pengajuanbaru" class="tab-pane fade in active">
        <div class="panel panel-default">
            <a href="/penjaminanAdd"class="btn" style="color: #23527c;margin: 5px;"> <i class="glyphicon glyphicon-plus-sign"></i> <b>Tambah</b></a>
            <div class="panel-heading">
                <strong>  
                <h2 align="center">PENGAJUAN PENJAMINAN KREDIT</h2>
                  </strong>
                    <p style="font-size: 21px;color: red" align="center">Sistem Automatic Conditional Cover</p> 
            </div>
             <body ng-app="Penjaminan" ng-controller="PenjaminanController">
            <section  class="col-lg-13 connectedSortable">
                <!-- Map box -->
                <div class="box box-solid" style="margin: 20px; ">
<!--                    @if ($data->count()>0)
                    <a  href="/prosesbayar" class="btn btn-danger btn-xs">Lanjut Ke Proses Pembayaran</a>
                    @endif   -->

                    <table class="table table-hover"  style="width: 100%;font-size: 12px;border: 1px; border-color:  black" id="tabelpenjaminan"  >
                        <thead>
                            <tr style="background-color:#cccccc ;color: #000000">
                                <th>No</th>
                                <th>Tgl Pengajuan</th>                           
<!--                                <th>NO KTP</th>-->
                                <th>Terjamin</th>                       
                                <th>Umur</th>                     
                                <th>Jns kredit</th>
<!--                            <th>MULAI TGL</th>
                                <th>SAMPAI TGL</th>                           -->
                                <th>Plafon(Rp.)</th>  
                                <!--<th>Rate</th>-->
                                <th>Gross IJP</th>                         
                                <!--<th>Dis(Rp.)</th>-->
                                <!--<th>Net IJP</th>-->
<!--                                <th>Admin</th>
                                <th>Materai</th>-->
                                <!--<th>Tot Bayar</th>-->
<!--                                <th>JNS PENJAMINAN</th>-->
                                <th>Aging</th>
                                <th>Bank</th>
<!--                                <th>PEMOHON</th>-->
                                @if(Session::get('level')!='User')
                                <th>Document</th>                         
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            function aging($tanggal) {
                                $tanggal1 = new DateTime($tanggal);
                                $tanggal2 = new DateTime();
                                return  $aging = $tanggal2->diff($tanggal1)->format("%a");
                            }
                            ?>
                            @foreach($data as $datas)
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tglpengajuan))}}</td>     
<!--                                <td>{{$datas -> ktp}}</td>-->
                                <td>{{$datas -> nama}}</td>
                                <td >{{$datas -> umur}}</td>                           
                                <td>{{$datas -> jeniskredit}}</td>
<!--                                <td>{{date('d-m-Y', strtotime($datas -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tgljatuhtempo))}}</td>                            -->
                                <td>{{number_format( $datas -> plafon, 0, ',', '.')}}</td>   
                           <!--<td align="right">{{number_format($datas -> rate, 2, ',', '.')}}</td>-->                                  
                                <td align="right" style="color:red; "><b>{{number_format($datas -> premi, 2, ',', '.')}}</b></td>                                  
                                <!--<td align="right">{{number_format($datas -> pot, 2, ',', '.')}}</td>-->                                  
                                <!--<td align="right" style="color:red"><b>{{number_format($datas -> nett, 2, ',', '.')}}</b></td>-->                                  
<!--                                <td align="right">{{number_format($datas -> admin, 2, ',', '.')}}</td>                                  
                                <td align="right">{{number_format($datas -> materai, 2, ',', '.')}}</td>                                  -->
                                <!--<td align="right" style="color:red"><b>{{number_format($datas -> nett+$datas -> admin+$datas -> materai, 2, ',', '.')}}</b></td>-->  
<!--                                <td>{{$datas -> jenispenjaminan}}</td>-->
                                <td><b><p style="color: red;font-size: 15px">{{aging($datas -> tglpengajuan) }}</p></b>Hari</td>
                                <td>{{$datas -> namabank}}</td>
<!--                                <td>{{$datas -> pemohon}}</td>-->
                                @if(Session::get('level')!='User')
                                <td>
                                    <ul>
                                          <li> <b style="color: red;"> <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-info uploadsuratsehat" href=""  type="button"  id="{{$datas -> idpenjaminan}}" style="color: #ffffff">Upload Surat Sehat Terjamin</a></b></li>
                                           <li   <?php if ($datas->files == '' )  {echo 'hidden=""';$hide='true';}else{$hide='';} ?>><a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary" target="_BLANK"  href="@if($datas->url_penjaminan!=null)<?php echo $datas -> url_penjaminan.$datas -> files?>@else files/buktibayar/{{$datas ->files}} @endif">Download Surat Sehat Terjamin</a></li>
                                        <li > <b style="color: red;"> <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-info uploadsuratsehatRs" href=""  type="button"  id="{{$datas -> idpenjaminan}}" style="color: #ffffff">Upload Surat Sehat RS</a></b></li>
                                        <li  <?php if ($datas->files3 == '' ) {echo 'hidden=""';$hide='true';}else{$hide='';} ?> >  <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary uploadsuratsehatRs"  target="_BLANK" href="@if($datas->url_penjaminan!=null)<?php echo $datas -> url_penjaminan.$datas -> files3 ?>@else files/buktibayar/{{$datas ->files3}} @endif">Download Surat Sehat RS</a></li>
                                        <li  <?php if ($datas->files2 == '') { echo 'hidden=""';} ?>><a  target="_blank" href="@if($datas->url_penjaminan!=null)<?php echo $datas -> url_penjaminan.$datas -> files2?>@else files/buktibayar/{{$datas->files2}} @endif">Download Dokumen Cek Lab</a></li>
<!--                                        <li ><b><a href=""   type="button" class="btn btn-success uploadscanlab" id="{{$datas -> idpenjaminan}}" style="color: #ffffff">Upload Dokumen Cek Lab</a></b></li>-->
                                        <li> <b>  <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary uploadsuratsehatRs" target="_BLANK" href="cetaksuratpengajuan/{{$datas ->nosertifikat}}"  style="color: black">Cetak Surat Pengajuan</a></b></li>
                                    </ul>  
                                </td>
                                <td>
                                    <div class=" btn-group-vertical">
                                        <?php if ($datas->files == '') 
                                            {
                                            $hide = 'true';
                                            } else {
                                            $hide = '';
                                            }
                                            
                                        ?>
                                        <button data-toggle="tooltip" data-placement="top" title="Lihat detail dan Ubah data" id="{{$datas->idpenjaminan}}"  type="button" class="btn btn-warning   editpenjaminan">Detail</button> 
                                        <a data-toggle="tooltip" data-placement="top" title="Lanjutkan ke proses bayar" ng-hide="{{$hide}}" href="/prosesbayarauto/{{ Crypt::encrypt($datas -> nosertifikat)}}" class="btn btn-primary ">Bayar</a>
                                        <button  data-toggle="tooltip" data-placement="top" title="Hapus data pengajuan"  id="{{$datas->idpenjaminan}}"   class="btn btn-danger deletepenjaminan">Reject</button>
                                       
                                    </div>
                                </td>
                               @endif 
                            </tr>
                            <?php $i++ ?>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </section>
        </body> 
        </div>      
    </div>
<!--    //pengajuan case by case-->
<div id="casebycase" class="tab-pane fade" align="center">
   <div class="panel panel-default">
            <div class="panel-heading">
                <strong>  
                <h4align="center">PENGAJUAN PENJAMINAN KREDIT</h4>
                 <h5 style="color: red" align="center">CASE BY CASE</h5>
                </strong>
            </div>
        <hr>
        <body ng-app="Penjaminan" ng-controller="PenjaminanController">

            <section  class="col-lg-13 connectedSortable">
                <!-- Map box -->
                <div class="box box-solid">
                    <table class="table table-hover"  style="font-size: 11px;border: 1px; border-color:  black"   >
                        <thead>
                            <tr >
                                <th>NO</th>
                                <th>TGL PENGAJUAN</th>                           
<!--                                <th>NO KTP</th>-->
                                <th>NAMA</th>                        
                                <th>TGL LAHIR</th>                        
                                <th>UMUR</th>                     
                                <th>JNS KREDIT</th>
<!--                                <th>MULAI TGL</th>
                                <th>SAMPAI TGL</th>                           -->
                                <th>PLAFON(Rp.)</th>                               
                                <th>JNS PENJAMINAN</th>
                                <th>AGING</th>
                                <th>BANK</th> 
                                <th>PEMOHON</th> 
                                @if(Session::get('level')!='User')
                                <th>DOKUMEN</th>  
<!--                                <th>Status</th>-->
                                <th>ACTION</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            
//                           dd($case1);
                            ?>
                            @foreach($case1 as $datas)
                            <tr style="color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tglpengajuan))}}</td>     
<!--                                <td>{{$datas -> ktp}}</td>-->
                                <td>{{$datas -> nama}}</td>
                                <td>{{$datas -> tgllahir}}</td>
                                <td>{{$datas -> umur}}</td>                           
                                <td>{{$datas -> jeniskredit}}</td>
<!--                                <td>{{date('d-m-Y', strtotime($datas -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tgljatuhtempo))}}</td>                            -->
                                <td>{{number_format( $datas -> plafon, 0, ',', '.')}}</td>                                
                                <td>{{$datas -> jenispenjaminan}}</td>
                                <td><b><p style="color: red;font-size: 15px">{{aging($datas -> tglpengajuan) }}</p></b>Hari</td>
                                <td>{{$datas -> namabank}}</td>
                                <td>{{$datas -> pemohon}}</td>
                                @if(Session::get('level')!='User')
                                <td> 
                                    <style>
                                    .ftable tr:not(.fble_htr) {
                                        counter-increment: rowNumber;
                                    } 
                                    .ftable tr:not(.fble_htr) td:first-child::before {
                                        content: counter(rowNumber);
                                        min-width: 1em;
                                        margin-right: 0.5em;
                                    }
                                    </style> 
                                    @php
                                             if ($datas ->doc_surat_pernyataan_sehat=='No'){ $showDocSehat = "hide" ; }else {$showDocSehat = "" ;}
                                             if ($datas ->doc_surat_keterangan_sehat=='No'){ $showDocSehatrs = "hide" ; }else {$showDocSehatrs = "" ;}
                                             if ($datas ->doc_cek_lab=='No'){ $showDocLab= "hide" ; }else {$showDocLab = "" ;}
                                             if ($datas ->doc_getaran_jantung=='No'){ $showDocJantung = "hide" ; }else {$showDocJantung = "" ;}
                                             if ($datas ->doc_ktp=='No'){ $showktp = "hide" ; }else {$showktp = "" ;}
                                             if ($datas ->doc_foto_usaha=='No'){ $showfotousaha = "hide" ; }else {$showfotousaha = "" ;}
                                             if ($datas ->doc_slik=='No'){ $showslik = "hide" ; }else {$showslik = "" ;}
                                             if ($datas ->doc_analisa_kelayakan=='No'){ $showDocAnalisa= "hide" ; }else {$showDocAnalisa = "" ;}
                                             if ($datas ->doc_taksasi=='No'){ $showDocTaksasi= "hide" ; }else {$showDocTaksasi = "" ;}
                                             if ($datas ->doc_persetujuan_kredit=='No'){ $showDocPersetujuanKredit = "hide" ; }else {$showDocPersetujuanKredit = "" ;}
                                             if ($datas ->doc_riwayat_kredit=='No'){ $showDocRiwayatKredit = "hide" ; }else {$showDocRiwayatKredit = "" ;} 
                                             if ($datas ->doc_sk=='No'){ $showDocSk = "hide" ; }else {$showDocSk= "" ;} 
                                  
                                    @endphp
                                    <table class="ftable"> 
                                        <tr class="{{$showDocSehat}}">  
                                            <td></td>
                                            <td><b>Surat Sehat </b></td>
                                            <td><a style="color:black; border-radius:6px; border-color: #cccccc"  class="btn" target="_BLANK"  href="@if($datas->url_penjaminan!=null)<?php echo $datas -> url_penjaminan.$datas -> files?>@else files/buktibayar/{{$datas ->files}} @endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <td><a style="color:black; margin: 1px; border-radius:6px; border-color: #cccccc"  id="{{$datas -> idpenjaminan}}"  class="btn uploadsuratsehat"  > <i class="glyphicon glyphicon-open"></i></a></td> 
                                        </tr>
                                        <tr class="{{$showDocSehatrs}}"> 
                                             <td></td>
                                            <td><b>Surat Sehat Dari RS</b></td>
                                            <td><a style="color:black;border-color: #cccccc"   class="btn " target="_BLANK" href="@if($datas->url_penjaminan!=null)<?php echo $datas -> url_penjaminan.$datas -> files3 ?>@else files/buktibayar/{{$datas ->files3}} @endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <td><a  style="color:black; margin: 1px; border-color: #cccccc" id="{{$datas -> idpenjaminan}}"  class="btn uploadsuratsehatRs"  > <i class="glyphicon glyphicon-open"></i></a></td> 
                                        </tr>
                                        <tr class="{{$showDocLab}}"> 
                                             <td></td>
                                            <td><b>Hasil Cek Lab</b></td>
                                            <td><a style="color:black;border-color: #cccccc"  class="btn" targettarget="_blank" href="@if($datas->url_penjaminan!=null)<?php echo $datas -> url_penjaminan.$datas -> files2?>@else files/buktibayar/{{$datas->files2}} @endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <td><a  style="color:black; margin: 1px;border-color: #cccccc"  id="{{$datas -> idpenjaminan}}"  class="btn  uploadscanlab"  > <i class="glyphicon glyphicon-open"></i></a></td> 
                                        </tr>
                                        <tr class="{{$showDocJantung}}"> 
                                             <td></td>
                                            <td><b>Dokumen Getaran Jantung</b></td>
                                            <td><a style="color:black;border-color: #cccccc"  class="btn" targettarget="_blank" href="@if($datas->url_penjaminan!=null)<?php echo $datas -> url_penjaminan.$datas -> getaran_jantung?>@endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <td><a  style="color:black; margin: 1px;border-color: #cccccc"  id="{{$datas -> idpenjaminan}}"  class="btn  uploadGetaranJantung"  > <i class="glyphicon glyphicon-open"></i></a></td> 
                                        </tr>
                                        <tr class="{{$showktp}}"> 
                                             <td></td>
                                            <td><b>KTP Terjamin + Pasangan</b></td>
                                            <td><a style="color:black;border-color: #cccccc"  class="btn" targettarget="_blank" href="@if($datas->url_penjaminan!=null)<?php echo $datas -> url_penjaminan.$datas ->foto_ktp?>@else files/buktibayar/{{$datas->foto_ktp}} @endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <td><a  style="color:black; margin: 1px;border-color: #cccccc"  id="{{$datas -> idpenjaminan}}"  class="btn  uploadktp"  > <i class="glyphicon glyphicon-open"></i></a></td> 
                                        </tr>
                                        <tr class="{{$showfotousaha}}"> 
                                             <td></td>
                                            <td><b>Foto Usaha</b></td>
                                            <td><a style="color:black;border-color: #cccccc"  class="btn" targettarget="_blank" href="@if($datas->url_penjaminan!=null)<?php echo $datas -> url_penjaminan.$datas ->foto_usaha?> @endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <td><a  style="color:black; margin: 1px;border-color: #cccccc"  id="{{$datas -> idpenjaminan}}"  class="btn  uploadFotoUsaha"  > <i class="glyphicon glyphicon-open"></i></a></td> 
                                        </tr>
                                        <tr class="{{$showslik}}"> 
                                             <td></td>
                                            <td><b>Hasil SLIK</b></td>
                                            <td><a style="color:black;border-color: #cccccc"  class="btn" targettarget="_blank" href="@if($datas->url_penjaminan!=null)<?php echo $datas -> url_penjaminan.$datas ->hasil_slik?> @endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <td><a  style="color:black; margin: 1px;border-color: #cccccc"  id="{{$datas -> idpenjaminan}}"  class="btn  uploadHasilSlik"  > <i class="glyphicon glyphicon-open"></i></a></td> 
                                        </tr>
                                       <tr class="{{$showDocAnalisa}}"> 
                                             <td></td>
                                            <td><b>Analisis Kelayakan</b></td>
                                            <td><a style="color:black;border-color: #cccccc"  class="btn" targettarget="_blank" href="@if($datas->url_penjaminan!=null)<?php echo $datas -> url_penjaminan.$datas ->analisis_kelayakan?> @endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <td><a  style="color:black; margin: 1px;border-color: #cccccc"  id="{{$datas -> idpenjaminan}}"  class="btn  uploadAnalisis"  > <i class="glyphicon glyphicon-open"></i></a></td> 
                                        </tr> 
                                         <tr class="{{$showDocTaksasi}}"> 
                                             <td></td>
                                            <td><b>Hasil Taksasi Agunan</b></td>
                                            <td><a style="color:black;border-color: #cccccc"  class="btn" targettarget="_blank" href="@if($datas->url_penjaminan!=null)<?php echo $datas -> url_penjaminan.$datas ->taksasi_agunan?> @endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <td><a  style="color:black; margin: 1px;border-color: #cccccc"  id="{{$datas -> idpenjaminan}}"  class="btn  uploadTaksasi"  > <i class="glyphicon glyphicon-open"></i></a></td> 
                         
                                         <tr class="{{$showDocPersetujuanKredit}}">  
                                             <td></td>
                                            <td><b>Surat Persetujuan Kredit</b></td>
                                            <td><a style="color:black;border-color: #cccccc"  class="btn" target="_blank" href="@if($datas->url_penjaminan!=null)<?php echo $datas -> url_penjaminan.$datas ->surat_persetujuan_kredit?> @endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <td><a  style="color:black; margin: 1px;border-color: #cccccc"  id="{{$datas -> idpenjaminan}}"  class="btn  uploadPersetujuanKredit"  > <i class="glyphicon glyphicon-open"></i></a></td> 
                                        </tr>
                                        <tr class="{{$showDocRiwayatKredit}}">  
                                             <td></td>
                                            <td><b>Doc Riwayat Kredit</b></td>
                                            <td><a style="color:black;border-color: #cccccc"  class="btn" target="_blank" href="@if($datas->url_penjaminan!=null)<?php echo $datas -> url_penjaminan.$datas ->surat_riwayat_kredit?> @endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <td><a  style="color:black; margin: 1px;border-color: #cccccc"  id="{{$datas -> idpenjaminan}}"  class="btn  uploadRiwayatKredit"  > <i class="glyphicon glyphicon-open"></i></a></td> 
                                        </tr>
                                 
                                        <tr class="{{$showDocSk}}">  
                                             <td></td>
                                            <td><b>Doc SK Pengangkatan</b></td>
                                            <td><a style="color:black;border-color: #cccccc"  class="btn" target="_blank" href="@if($datas->url_penjaminan!=null)<?php echo $datas -> url_penjaminan.$datas ->sk_pengangkatan?> @endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <td><a  style="color:black; margin: 1px;border-color: #cccccc"  id="{{$datas -> idpenjaminan}}"  class="btn  uploadDocSk"  > <i class="glyphicon glyphicon-open"></i></a></td> 
                                        </tr>
                                        <tr> 
                                            <td></td>
                                            <td><b>Print  Pengajuan</b></td>
                                            <td><a  style="color:black; margin: 1px;border-color: #cccccc"class="btn"  target="_BLANK" href="cetaksuratpengajuan/{{$datas ->nosertifikat}}"> <i class="glyphicon glyphicon-print"></i></a></td>
                                            <td></td> 
                                        </tr>
                                    </table> 
                                </td> 
                               
<!--                                <td><a style="color: red"><b>{{strtoupper($datas->app)}}</b></a></td>-->
                                <td>
                                <div class=" btn-group-vertical">
                                    <?php if($datas->app=='Pembayaran'){$hide='true';}else{$hide='';} ?>
                                    <button style="border-color: #cccccc" id="{{$datas->idpenjaminan}}}" ng-hide="{{$hide}}" type="button" class="btn  editpenjaminan">Detail</button> 
                                    <button  style="border-color: #cccccc"  id="{{$datas->idpenjaminan}}}" ng-hide="{{$hide}}" type="button" class="btn kirimPenjaminan">Kirim</button> 
                                    <button  style="border-color: #cccccc;"  ng-hide="{{$hide}}"  data-toggle="tooltip" data-placement="top" title="Hapus data pengajuan"  id="{{$datas->idpenjaminan}}"   class="btn deletepenjaminan"><p style="color: red">Reject</p></button>
                                </div>
                                </td>
                                @endif
                            </tr>
                            <?php $i++ ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </body>

   </div>
    <!-- Map box -->
    </div>
<!--    //pengajuan Sudah Bayar-->
<!--    <div id="sudahbayar" class="tab-pane fade">
    <h2 align="center">PENGAJUAN PENJAMINAN KREDIT</h2>
    <h2 style="color: red" align="center">SUDAH PROSES BAYAR</h2>
        <body ng-app="Penjaminan" ng-controller="PenjaminanController">
            <section  class="col-lg-13 connectedSortable">
                 Map box 
                <div class="box box-solid">
                    <table id="tabelpembayaran" class=" table table-hover"  style="font-size: 11px;  border: 1px; border-color:  black"    >
                        <thead>
                            <tr style="width: 30px; background-color:#23527c ;color: #000000">
                                <th>NO</th>
                                <th>KODE BAYAR</th>
                                <th>TGL PENGAJUAN</th>                         
                                <th>TGL BAYAR</th>                         
                                <th>TERJAMIN</th>                      
                                <th>JNS KREDIT</th>
                                <th>PLAFON</th>                          
                                <th>AGING BAYAR</th>                           
                                <th>DOKUMEN</th>                           
                                <th>STATUS</th>                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $premi = 0;
                            $dis = 0;
                            $nett = 0;
                            
                             
                            ?>
                            @foreach($bayar as $datas)
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{$datas -> kodebayar}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tglpengajuan))}}</td>     
                                <td><p style="color:red">{{date('d-m-Y', strtotime($datas -> tglbayar))}}</p></td>     
                                <td>{{$datas -> nama}}</td>                                                        
                                <td>{{$datas -> jeniskredit}}</td>                                       
                                <td>{{number_format($datas -> plafon, 0, ',', '.')}}</td>                                       
                                <td><b><p style="color: red;font-size: 15px">{{aging($datas -> tglbayar) }}</p></b>Hari</td>
                                <td>
                                    <ul>
                                        <li><a href="/files/buktibayar/{{$datas ->file}}">Download Bukti Bayar</a></li>
                                        <li><b style="color: red"> <a href="" class="uploadbuktibayar" id="{{$datas->idpenjaminan}}" style="color: red">Upload Bukti Bayar</a></b></td></li>
                                    </ul>                             
                                </td>                         
                                <td> <span class="label label-warning">{{strtoupper($datas -> app)}}</span></td>
                            </tr>
                            <?php
                            $i++;
                            $premi = $premi + $datas->premi;
                            $dis = $dis + $datas->pot;
                            $nett = $nett + $datas->nett;
                            ?>
                            @endforeach
                        </tbody>
                    </table>                 
                </div>
            </section>
        </body>
    </div>-->
<!--    //pengajuan Sudah Di Setujui-->
<!--    <div id="setuju" class="tab-pane fade">
        <h2 align="center">PENGAJUAN PENJAMINAN KREDIT</h2>
    <h2 style="color: red" align="center">SUDAH DISETUJUI</h2>
        <body ng-app="Penjaminan" ng-controller="PenjaminanController">
            <section  class="col-lg-13 connectedSortable">
                 Map box 
                <div class="box box-solid">
                    <br>                      
                    <table id="tabelSetuju" class=" table table-hover"  style="font-size: 12px;  margin-left: 0%; border: 1px; border-color:  black"    >
                        <thead>
                            <tr style="width: 30px; background-color:#23527c ;color: #000000">
                                <th>NO</th>
                                <th>KODE PENGAJUAN</th>
                                <th>TGL PENGAJUAN</th>                         
                                <th>TGL APPROVAL</th>                         
                                <th>NAMA TERJAMIN</th>                      
                                <th>JNS KREDIT</th>
                                <th>MULAI TGL</th>
                                <th>SAMPAI TGL</th>                           
                                <th>MASA KREDIT</th>                           
                                <th>PLAFON</th>                                
                                <th>STATUS</th>                           
                                <th>CATATAN</th> 
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
                            @foreach($setuju as $datas)
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{$datas -> nosertifikat}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tglpengajuan))}}</td> 
                                <td>{{date('d-m-Y', strtotime($datas -> tglanalisa))}}</td> 
                                <td>{{strtoupper($datas -> nama)}}</td>                                                        
                                <td>{{$datas -> jeniskredit}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tgljatuhtempo))}}</td>                            
                                <td>{{$datas -> masakredit}} Bln</td>
                                <td>{{number_format($datas -> plafon, 0, ',', '.')}}</td>
                                <td>@if($datas -> app=='Setuju') <span class="label label-success"> <i class="glyphicon glyphicon-check">&nbsp;{{$datas -> app}}</i></span>@endif </td>
                                <td>{{strtoupper($datas -> analisa)}}</td>   
                                <td>
                                    <ul>
                                        <li><a data-toggle="tooltip" data-placement="top" title="Download File Bukti Bayar" href="/files/buktibayar/{{$datas ->file}}"><span class="label label-success"> <i class="glyphicon glyphicon-download"></i>Bukti Bayar</span></a></li>
                                    </ul>
                                </td>                      
                              </tr>
                            <?php
                            $i++;
                             
                            ?>
                            @endforeach
                        </tbody>
                    </table>    
                        </tbody>
                    </table>
                </div>
            </section>
        </body>
    </div>-->
<!--    //pengajuan Di Tolak-->
    <div id="ditolak" class="tab-pane fade">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>  
                   <h2 align="center">PENGAJUAN PENJAMINAN KREDIT</h2>
                   <h2 style="color: red" align="center">DITOLAK</h2>
                </strong>
            </div>
            <body ng-app="Penjaminan" ng-controller="PenjaminanController">
            <section  class="col-lg-13 connectedSortable">
                <!-- Map box -->
                <div class="box box-solid">
                    <br>                      
                    <table id="tabelpembayaran" class=" table table-hover"  style="font-size: 12px; border: 1px; border-color:  black"    >
                        <thead>
                            <tr style="width: 30px; background-color:#23527c ;color: #000000">
                                <th>NO</th> 
                                <th>TGL PENGAJUAN</th>                         
                                <th>TGL APPROVAL</th>                         
                                <th>NAMA</th>                      
<!--                                <th>JNS KREDIT</th>-->
                                <th>MULAI TGL</th>
                                <th>SAMPAI TGL</th>                           
<!--                                <th>MASA KREDIT</th>                           -->
                                <th>PLAFON</th>
<!--                                <th>JNS PENJAMINAN</th> -->
                                <th>STATUS</th>   
                                <th>BANK</th> 
                                <th>PEMOHON</th> 
                                <th>NET IJP</th> 
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $premi = 0;
                            $dis = 0;
                            $nett = 0;    
                            ?>
                            @foreach($ditolak as $datas)
                            
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tglpengajuan))}}</td> 
                                <td>{{date('d-m-Y', strtotime($datas -> tglanalisa))}}</td> 
                                <td>{{$datas -> nama}}</td>                                                        
<!--                                <td>{{$datas -> jeniskredit}}</td>-->
                                <td>{{date('d-m-Y', strtotime($datas -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tgljatuhtempo))}}</td>                            
<!--                                <td>{{$datas -> masakredit}} Bulan</td>-->
                                <td>{{number_format($datas -> plafon, 0, ',', '.')}}</td>
<!--                                <td>{{$datas -> jenispenjaminan}}</td>                           -->
                                <td>@if($datas -> app=='Tolak') <span class="label label-danger"> <i class="glyphicon glyphicon-remove">&nbsp;{{$datas -> app}}</i></span>@endif </td>
                               
                               
                                <td>{{$datas -> namabank}}</td>
                                <td>{{$datas -> pemohon}}</td>
                                <td>{{number_format($datas -> nett, 0, ',', '.')}}</td>
                                
                            </tr>
                            <?php
                            $i++;
                             
                            ?>
                            @endforeach
                        </tbody>
                    </table>
                    <br>  
                        </tbody>
                    </table>
                </div>
            </section>
        </body>
        </div>
     
        
    </div>
<!--    //Sudah Terbit Sertifikat-->
    <div id="dapatcetak" class="tab-pane fade">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>  
                   <h2  align="center">CETAK SERTIFIKAT</h2>
                </strong>
            </div>
            <body ng-app="Penjaminan" ng-controller="PenjaminanController">
            <section  class="col-lg-13 connectedSortable">
                <!-- Map box -->
                <div class="box box-solid">
                    <br>                      
                    <table  class=" table table-hover tabel"  style="font-size: 12px; border: 1px; border-color:  black">
                        <thead>
                            <tr style="width: 30px; background-color:#23527c ;color: #000000">
                                <th>NO</th> 
                                <th>NOMOR SERTIFIKAT</th>                         
                                <th>TERBIT</th>                         
                                <th>TERJAMIN</th>                      
                                <th>JNS KERDIT</th>
<!--                                <th>MULAI</th>
                                <th>SAMPAI</th>                           -->
                                <th>MASA</th>                           
                                <th>PLAFON(Rp.)</th>
                                <th>BANK</th> 
                                <th>PEMOHON</th> 
                                <th>DOKUMEN</th> 
                                <th>DETAIL</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $premi = 0;
                            $dis = 0;
                            $nett = 0;                            
                             
                            ?>
                            @foreach($cetak as $datas)
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{$datas -> kodesertifikat}}</td>  
                                <td>{{date('d-m-Y', strtotime($datas -> tglterbit))}}</td>
                                <td>{{$datas -> nama}}</td>                                                        
                                <td>{{$datas -> jeniskredit}}</td>
<!--                                <td>{{date('d-m-Y', strtotime($datas -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tgljatuhtempo))}}</td>                            -->
                                <td>{{$datas -> masakredit}} Bln</td>
                                <td>{{number_format($datas -> plafon, 0, ',', '.')}}</td>
                                <td>{{$datas -> namabank}}</td>
                                <td>{{$datas -> pemohon}}</td>
                                <td>
                                    <div class=" btn-group-vertical">
                                          <li>
                                                <b>
                                                    <a style="color: red" target="_blank " id="{{$datas ->idpenjaminan}}" class="logcetaksertifikat"  href="/cetakpdf/{{$datas ->nosertifikat}}" >Cetak Sertifikat</a> 
                                                </b>
                                          </li>
                                          <li> 
                                              <b> <a target="_blank "  href="cetaksuratpengajuan/{{$datas ->nosertifikat}}"  style="color: black">Cetak Surat Pengajuan</a></b>
                                          </li>
                                        
<!--                                        <a class="btn btn-primary" href="/cetakpenjaminanpdf/{{$datas ->nosertifikat}}">Cetak Daftar</a>-->
                                     </div>
                                </td>
                                <td>
                                    <b>
                                    <a style="color: red" target="_blank " id="{{$datas ->idpenjaminan}}"   href="/detailcetak/{{$datas ->nosertifikat}}" >Lihat</a> 
                                    </b>
                                </td>
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
            </section>
        </body>
        </div> 
    </div>

    
<div id="laporan" class="tab-pane fade">
    <div class="box box-solid">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><i class="glyphicon glyphicon-search"></i>  Pilih Range Tanggal dan Jenis Laporan</strong>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="filterPenjaminan">
                            {{csrf_field()}}
                            <table>
                                <tr>
                                    <th>Dari</th>
                                    <th>Sampai</th>
                                    <th>Jenis Kredit</th>
                                    <th>Jenis Laporan</th>
                                </tr>
                                <tr>                    
                                    <th> 
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-time">
                                                </i>
                                            </div>
                                            <input required="" value="{{old('dari')}}"   id="dari"  name="dari"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                                        </div>
                                    </th>

                                    <th> 
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-time">
                                                </i>
                                            </div>
                                            <input required="" value="{{old('sampai')}}"   id="sampai"  name="sampai"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                                        </div>
                                    </th>
                                    <th>
                                        <select required="" name="jenisKredit" class="form-control">
                                            <option value="">Pilih Jenis</option>
                                            <option value="%">SEMUA</option>                                                
                                            <option value="PRODUKTIF">PRODUKTIF</option>                                                
                                            <option value="KONSUMTIF">KONSUMTIF</option>
                                        </select>
                                    </th>
                                    <th>
                                        <select required="" name="jenislaporan" class="form-control">
                                            <option value="">Pilih Jenis</option>
                                            <option value="%">SEMUA</option>                                                
                                            <option value="cetak">SUDAH TERBIT SERTIFIKAT</option>                                                
                                            <option value="pengecekan">BARU</option>                           
                                            <option value="Tolak">DITOLAK</option> 
                                        </select>
                                    </th>
                                    <th>
                                        <br>
                                        <div class="input-group">
                                            <td><button  type="submit" class="btn btn-danger">Filter</button></td>
                                        </div>
                                    </th>
                                </tr>                
                            </table>
                        </form>       
                    </div>
                    <div class="panel-footer">
                        
                    </div>
                </div>
            </div>
</div>

<div id="laporan" class="tab-pane fade">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>  
                <h2 align="center">REKAP PENGAJUAN</h2> 
                </strong>
            </div>
            <body ng-app="Penjaminan" ng-controller="PenjaminanController">
            <section  class="col-lg-13 connectedSortable">
                <!-- Map box -->
                 <form method="post" action="filterPenjaminan">
                            {{csrf_field()}}
                            <table>
                                <tr>
                                    <th>Dari</th>
                                    <th>Sampai</th>
                                    <th>Jenis Kredit</th>
                                    <th>Jenis Laporan</th>
                                </tr>
                                <tr>                    
                                    <th> 
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-time">
                                                </i>
                                            </div>
                                            <input required="" value="{{old('dari')}}"   id="dari"  name="dari"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                                        </div>
                                    </th>

                                    <th> 
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-time">
                                                </i>
                                            </div>
                                            <input required="" value="{{old('sampai')}}"   id="sampai"  name="sampai"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                                        </div>
                                    </th>
                                    <th>
                                        <select required="" name="jenisKredit" class="form-control">
                                            <option value="">Pilih Jenis</option>
                                            <option value="%">SEMUA</option>                                                
                                            <option value="PRODUKTIF">PRODUKTIF</option>                                                
                                            <option value="KONSUMTIF">KONSUMTIF</option>
                                        </select>
                                    </th>
                                    <th>
                                        <select required="" name="jenislaporan" class="form-control">
                                            <option value="">Pilih Jenis</option>
                                            <option value="%">SEMUA</option>                                                
                                            <option value="cetak">SUDAH TERBIT SERTIFIKAT</option>                                                
                                            <option value="pengecekan">BARU</option>                           
                                            <option value="Tolak">DITOLAK</option> 
                                        </select>
                                    </th>
                                    <th>
                                        <br>
                                        <div class="input-group">
                                            <td><button  type="submit" class="btn btn-danger">Filter</button></td>
                                        </div>
                                    </th>
                                </tr>                
                            </table>
                        </form>  
            </section>
        </body> 
        </div>      
    </div>

</div>
 
 <div id="modalEditPenjaminan" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
           <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <center>
               <h3 class="modal-title">DATA PENJAMINAN</h3>
            </center>
        </div>
            <form action="/UpdatePenjaminanUser" method="post"  id="formPenjaminanUpdate"  enctype="multipart/form-data" >
                <div class="panel-body">             
                    <div class="box-body col-sm-6">
                        <div class="box-body">
                            <h4>TERJAMIN</h4>
                            <hr >                        
                            <div class="form-group">   
                                  <input hidden=""  class="form-control" id="idpenjaminan"  name="idpenjaminan" >   
                                @if (Session::has('idbank'))
                                                             
                                <input hidden="" required=""   class="form-control" id="kodepusat"    name="kodepusat" placeholder="Kode Pusat Bank"  maxlength="16" >                                  
                                <input hidden="" required="" value="{{Session::get('idbank') }}" class="form-control" id="idbank"    name="idbank" placeholder="ID Bank"  maxlength="16" >                                  
                                @endif
                            </div>
                            <div class="form-group">
                                <label>No KTP</label>
                                <input required="" value="{{old('ktp')}}" class="form-control" id="ktp"   onkeypress="return  hanyaAngka(event, false)" name="ktp" placeholder="Nomor KTP"  maxlength="16" >
                                <input hidden="" required=""  id="ktplama"   onkeypress="return  hanyaAngka(event, false)" name="ktplama" maxlength="16" >
                                @if($errors->has('ktp'))
                                <p style="color: red"> {{ $errors-> first('ktp')}}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Nama Terjamin</label>
                                <input required="" value="{{old('ktp')}}" class="form-control" id="name" name="name" placeholder="Name" type="text" >
                                @if($errors->has('name'))
                                <p style="color: red"> {{ $errors-> first('name')}}</p>
                                @endif
                            </div>   
                             <div class="form-group">
                                <label>No Telepon | Hp <b style="color: red">( * )</b></label>
                                <input value="{{old('phone')}}"  required="" type="number" minlength="10" maxlength="15" class="form-control" id="phone" name="phone" placeholder="phone" type="text" >
                                @if($errors->has('phone'))
                                <p style="color: red"> {{ $errors-> first('phone')}}</p>
                                @endif
                            </div>   
                            <div class="form-group ">
                                <label>Tempat Lahir<b style="color: red">( * )</b></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-map-marker">
                                        </i>
                                    </div>
                                    <input required=""     id="tempatlahir"  name="tempatlahir"  type="text" class="form-control" >
                                </div>
                            </div>
                            
                            <div class="form-group ">
                                <label>Tanggal Lahir</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-calendar">
                                        </i>
                                    </div>
                                    <input required="" value="{{old('tglLhr')}}"  onchange="hitungUmur()" id="tglLahir"  name="tglLhr"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                                </div>
                                @if($errors->has('tglLhr'))
                                <p style="color: red"> {{ $errors->first('tglLhr')}}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Umur</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-hourglass">
                                        </i>
                                    </div>
                                    <input required="" value="{{old('umur')}}" disabled="" class="form-control" name="umur"  id="tampil1"  type="text">  
                                    <input hidden="" name="umur"  id="tampil"  type="text">  
                                </div>
                            </div>
<!--                            <div class="form-group">
                                <label >Pekerjaan</label>
                                <select required="" name="kredit" id="pekerjaan" class="form-control">
                                    <option value="">Pilih Jenis</option>
                                    <option value="PENGUSAHA">PENGUSAHA</option>                                                
                                    <option value="KARYAWAN">KARYAWAN</option>                                               
                                </select>
                                @if($errors->has('kredit'))
                                <p style="color: red"> {{ $errors->first('kredit')}}</p>
                                @endif
                            </div>-->
                              <div class="form-group">
                                 <p>Pekerjaan<b style="color: red"> * </b></p> 
                                <div class="icheck-greensea icheck-inline">
                                    <input {{old('jenis_pekerjaan')=='KARYAWAN' ? "checked" : "" }}   value="KARYAWAN" name="jenis_pekerjaan" required="" type="radio" id="radio-karyawan" />
                                    <label for="radio-karyawan">Karyawan</label> 
                                </div>
                                <div class="icheck-greensea icheck-inline">
                                    <input {{old('jenis_pekerjaan')=='PENGUSAHA' ? "checked" : "" }}  value="PENGUSAHA" name="jenis_pekerjaan" required="" type="radio" id="radio-pengusaha" />
                                    <label for="radio-pengusaha">Pengusaha</label> 
                                </div> 
                            </div>
                            <div class="form-group">
                                <label id="detailPekerjaan">Detail Pekerjaan</label>
                                <input id="detail_Pekerjaan" name="pekerjaan" class="form-control">
                               
                                @if($errors->has('pekerjaan'))
                                <p style="color: red"> {{ $errors->first('pekerjaan')}}</p>
                                @endif
                            </div>
                            <div class="form-group ">
                                <label>Alamat</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-map-marker">
                                        </i>
                                    </div>
                                    <textarea required="" id="alamat" name="alamat"  type="text"  class="form-control" ></p></textarea>
                                </div>
                                @if($errors->has('alamat'))
                                <p style="color: red"> {{ $errors->first('alamat')}}</p>
                                @endif
                            </div>  
                            
                             
                        @if(session::get('level')=='Bntb')
                            <div class="form-group">
                                <label>NPWP</label>
                                <input required="" value="{{old('npwp')}}" class="form-control" id="npwp"    name="npwp" placeholder="Nomor Pajak Wajib Pajak"  maxlength="25" >
                                @if($errors->has('ktp'))
                                <p style="color: red"> {{ $errors-> first('npwp')}}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>SIUP</label>
                                <input required="" value="{{old('siup')}}" class="form-control" id="siup"    name="siup" placeholder="SIUP"  maxlength="16" >
                                @if($errors->has('siup'))
                                <p style="color: red"> {{ $errors-> first('siup')}}</p>
                                @endif
                            </div>
                            
                            @endif
                        </div>
                    </div>

                    <div class="box-body col-sm-6">
                        <h4>PENJAMINAN</h4>
                        <hr> 
<!--                        
                              <div class="form-group">
                                <label >JENIS KREDIT</label>
                                <select required="" name="kredit" id="jeniskredit" class="form-control">
                                    <option value="">Pilih Jenis</option>
                                    <option value="PRODUKTIF">PRODUKTIF</option>                                                
                                    <option value="KONSUMTIF">KONSUMTIF</option>                                               
                                </select>
                                @if($errors->has('kredit'))
                                <p style="color: red"> {{ $errors->first('kredit')}}</p>
                                @endif
                            </div>-->
                        
                        <div class="form-group">
                            <p>Skema Kredit<b style="color: red"> * </b></p> 
                           <div class="icheck-greensea icheck-inline">
                               <input {{ old('kredit')=='KONSUMTIF' ? "checked" : "" }}   value="KONSUMTIF" name="kredit" required="" type="radio" id="radio-konsumtif" />
                               <label for="radio-konsumtif">Konsumtif</label> 
                           </div>
                           <div class="icheck-greensea icheck-inline">
                               <input {{ old('kredit')=='PRODUKTIF' ? "checked" : "" }}  value="PRODUKTIF" name="kredit" required="" type="radio" id="radio-produktif" />
                               <label for="radio-produktif">Produktif</label> 
                           </div>
                       </div>
                        
                        <div class="form-group">
                                <label>Tujuan Penggunaan Kredit</label>
                                <input required="" value="{{old('penggunaan')}}" class="form-control" id="penggunaan"  name="penggunaan" placeholder="penggunaan kredit"  > 
                                @if($errors->has('penggunaan'))
                                <p style="color: red"> {{ $errors-> first('penggunaan')}}</p>
                                @endif
                        </div>

                        <div class="form-group "> 
                            <label>Tanggal Realisasi</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-calendar">
                                    </i>
                                </div>
                                <input required=""  id="tglrealisasi" name="tglrealisasi"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                            </div>
                            @if($errors->has('tglrealisasi'))
                            <p style="color: red"> {{ $errors->first('tglrealisasi')}}</p>
                            @endif
                        </div>       
                        <div class="form-group ">
                            <label>Masa Kredit [Bulan]</label>
                            <div class="input-group">

<!--                                <input hidden="" id="masaKredit1" type="text">-->
                                <input onchange="hitungUmurJatuhTempo()" required="" id="masaKredit" name="masakredit"  type="text" class="form-control" >
                                <div class="input-group-addon">
                                    Bulan
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label>Tanggal Jatuh Tempo</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time">
                                    </i>
                                </div>
<!--                                <input required="" id="tgljatuhtempo" name="tgljatuhtempo"   onchange="hitungUmurJatuhTempo1()" id="tgljatuhtempo" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                                <input required="" id="tgljatuhtempo" name="tgljatuhtempo"   onchange="hitungUmurJatuhTempo1()" id="tgljatuhtempo" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">-->
                                <input required="" hidden=""   value="{{old('tgljatuhtempo')}}" name="tgljatuhtempo"  id="tgljatuhtempo1" type="text" >
                                <input required="" disabled=""  value="{{old('tgljatuhtempo')}}" class="form-control" maxlength="3"  id="tgljatuhtempo" type="text" >
                          
                            </div>
                            <br>
                            @if($errors->has('tgljatuhtempo'))
                            <p style="color: red"> {{ $errors->first('tgljatuhtempo')}}</p>
                            @endif
                        </div>                                
                        
                        <div class="form-group">
                            <label>Umur Terjamin Saat Jatuh Tempo</label><br>
                            <input name="umurjatuhtempo" hidden="" class="form-control"  id="umurjatuhtempo1" >
                            <input required="" disabled=""  class="form-control"  id="umurjatuhtempo" >
                        </div>
                        <div id="pesanUmurJtauhTempo"></div>
                        <div id="formGracePeriod" class="form-group hidden" >
                             <hr>
                        <div class="form-group ">
                            <label>Tgl. Mulai Grace Periode<b style="color: red">( * )</b></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time">
                                    </i>
                                </div>
                                <input value="{{old('tglGrace')}}"  id="tglGrace" name="tglGrace"  type="text" class="form-control tanggal" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                            </div>
                            @if($errors->has('tglGrace'))
                            <p style="color: red"> {{ $errors->first('tglGrace')}}</p>
                            @endif 
                        </div>   
                        <div class="form-group ">
                            <label>Masa Grace Periode [Bulan]</label>
                            <div class="input-group">
                                <input  value="{{old('masaGrace')}}"  id="masaGrace" onkeypress="return  hanyaAngka(event, false)"  name="masaGrace"  type="text" class="form-control" >
                                <div class="input-group-addon">
                                    Bulan
                                </div>
                            </div>
                        </div> 
                         <hr>
                        </div>
                        <div class="form-group">
                            <label>No. Perjanjian Kredit</label>
                            <input required="" class="form-control" id="nopk"   name="nopk" placeholder="Nomor PK"  maxlength="16" >
                            @if($errors->has('nopk'))
                            <p style="color: red"> {{ $errors->first('nopk')}}</p>
                            @endif
                        </div>

                        <div class="form-group ">
                            <label>Tanggal Perjanjian Kredit</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time">
                                    </i>
                                </div>
                                <input required="" name="tglpk" id="tglpk" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">

                            </div>
                            @if($errors->has('tglpk'))
                            <p style="color: red"> {{ $errors->first('tglpk')}}</p>
                            @endif

                        </div>

                        <div class="form-group ">
                            <label>Plafon Kredit</label><br>
                            <div class="input-group">                                        
                                <div class="input-group-addon">
                                    Rp.
                                </div>
                                <input required="" id="plafon"  onchange="CekPlafon()" onmousemove="FormatCurrency(this)" onkeyup="FormatCurrency(this)" class="form-control" name="plafon">
                                <input hidden="" id="level" value="{{session::get('level')}}" />

                                @if($errors->has('plafon'))
                                <p style="color: red"> {{ $errors->first('plafon')}}</p>
                                @endif

                            </div>
                            <div id="pesanPlafon"></div>
                        </div>
                        
                        <input hidden="" id="caseket"   class="form-control" name="caseket">

                                                   
                        <div class="form-group">
                            <label>Jenis Penjaminan</label>                            
                            <div id="Jenispilihan"></div>
                            
<!--                            <select required="" name="jenisPenjaminan"   id="JenisPnj"  class="form-control">
                                <option value="">Pilih Jenis Penjaminan</option>
                            </select>-->
<!--                            <select  required="" name="jenisPenjaminan" id="jenis_penjaminan" class="form-control">
                                    <option value="">Pilih Jenis Penjaminan</option>
                                    @foreach($rate as $rates)
                                      <option value="{{$rates->namarate}}">{{$rates->namarate}}</option> 
                                    @endforeach
                            </select>-->
                                
                            @if($errors->has('jenisPenjaminan'))
                            <p style="color: red"> {{ $errors->first('jenisPenjaminan')}}</p>
                            @endif
                        </div>     

                        <div class="form-group ">
                            <label>Tanggal Registrasi</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time">
                                    </i>
                                </div>
                                <input hidden="" id="proses" name="proses"  value="update" type="text">
                                <input hidden="" id="statusbayar" name="statusbayar"   type="text">
                                <input hidden="" id="tglpengajuan1" name="tglPengajuan"   type="text">
                                <input disabled=""  id="tglpengajuan" type="text" class="form-control">
                            </div>
                        </div>
                       
                        <button type="submit" id="simpan" class="btn btn-warning btnUpdateBank">Update</button>
                        {{csrf_field()}}
                    </div>
                </div>
            </form>  
        </div>
         
    </div>
    
</div>
            
            
       </section> 
</div><!-- /.ro (main row) --> 
</div>   
  @include('user.modalajukanlagi')
  @include('user.modalKirim')
  @include('user.modal')
</body>
@endsection


<!--<table class="table table-hover"  style="font-size: 11px;border: 1px; border-color:  black" id="tabel-test"  >
    <thead>
        <tr style="background-color:#23527c ;color: #000000">
            <th>TGL PENGAJUAN</th>
            <th>NAMA</th>                           
            <th>UMUR</th>
            <th>JNS KREDIT</th> 
            <th>PLAFON</th>   
            <th>ACTION</th>                        
        </tr>
    </thead>
</table>

<form method="post" id="search-form">
    <input name="nama" class="form-control">
    <input type="submit">
</form>-->