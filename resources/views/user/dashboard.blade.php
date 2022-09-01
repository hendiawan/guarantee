
@extends('layout.user')
@section('content')
<!--<div align="center">
    <button type="button" name="add" id="add_data" class="btn btn-success btn-sm">Add</button>
</div>-->

<body>
    
<div class="container">
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
        <a href="belumBayar" style="color:red">Anda memiliki <b>{{$totalbaru}}</b> pengajuan baru belum diproses bayar</a>
    </div>
    @endif
    
    @if($totalcasedapatbayar>0)
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <a href="CaseSudahBayar" style="color:red">Anda memiliki <b>{{$totalcasedapatbayar}}</b> pengajuan Case By Case yang dapat di lakukan diproses bayar</a>
    </div>
    @endif
    
    @if($totaldisetujui>0)
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <a href="setuju" style="color:green">Anda memiliki <b>{{$totaldisetujui}}</b> pengajuan baru yang sudah disetujui</a>
    </div>
    @endif
    
    @if($totalditolak>0)
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <a href="tolak" style="color:red">Anda memiliki <b>{{$totalditolak}}</b> pengajuan baru yang ditolak</a>
    </div>
    @endif
    
     @if($totalcetak>0)
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <a href="viewsertifikatcetak" style="color:green">Anda memiliki <b>{{$totalcetak}}</b> pengajuan baru yang sudah di terbitkan sertifikat</a>
    </div>
    @endif
    
    
   <div class="panel panel-default">
    <div class="panel-heading">
        <strong><i class="glyphicon glyphicon-menu-right"></i>  Menu Utama</strong>
    </div>
    <div class="panel-body">
        <ul class="nav nav-tabs">
            <li class="active"><a  class="label label-success "  data-toggle="tab" href="#pengajuanbaru">Pengajuan Baru @if($totalbaru>0) <span class="label label-danger">{{$totalbaru}}</span>@endif</a></li>
            <li><a class="label label-success"  data-toggle="tab" href="#casebycase">Pengajuan Case by Case  @if($totalcasebycase>0) <span class="label label-danger">{{$totalcasebycase}}</span>@endif</a></li>
            <li><a  class="label label-success"   data-toggle="tab" href="#sudahbayar">Sudah Bayar @if($totalsudahbayar>0) <span class="label label-danger">{{$totalsudahbayar}}</span>@endif</a></li>
            <li><a  class="label label-success"  data-toggle="tab" href="#setuju">Sudah Di Setujui @if($totaldisetujui>0) <span class="label label-danger">{{$totaldisetujui}}</span>@endif </a></li>
            <li><a   class="label label-success"  data-toggle="tab" href="#ditolak">Pengajuan Ditolak @if($totalditolak>0) <span class="label label-danger">{{$totalditolak}}</span>@endif </a></li>
            <li><a   class="label label-success"  data-toggle="tab" href="#dapatcetak"> Sertifikat Terbit @if($totalcetak>0) <span class="label label-danger">{{$totalcetak}}</span>@endif</a></li>
            <li><a   class="label label-success"  data-toggle="tab" href="#laporan">Rekap </a></li>
        </ul>
    </div>
</div>
  
    
<div class="tab-content">

<!--    //pengajuan belum bayar--> 
    <div id="pengajuanbaru" class="tab-pane fade in active">

        <h2 align="center">DATA PENGAJUAN PENJAMINAN KREDIT</h2>
        <h2 style="color: red" align="center">BELUM PROSES BAYAR</h2>
        <hr>
        <body ng-app="Penjaminan" ng-controller="PenjaminanController">
            <section  class="col-lg-13 connectedSortable">
                <!-- Map box -->
                <div class="box box-solid">
                    <br/>
                    @if (Session::has('pesan'))
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ Session::get('pesan') }}
                    </div>
                    @endif          
                    <br/>

<!--                    @if ($data->count()>0)
                    <a  href="/prosesbayar" class="btn btn-danger btn-xs">Lanjut Ke Proses Pembayaran</a>
                    @endif   -->

                    <table class="table table-hover"  style="font-size: 11px;border: 1px; border-color:  black" id="tabelpenjaminan"  >
                        <thead>
                            <tr style="background-color:#23527c ;color: #000000">
                                <th>NO</th>
                                <th>TGL PENGAJUAN</th>                           
<!--                                <th>NO KTP</th>-->
                                <th>NAMA</th>                        
                                <th>UMUR</th>                     
                                <th>JNS KREDIT</th>
<!--                                <th>MULAI TGL</th>
                                <th>SAMPAI TGL</th>                           -->
                                <th>PLAFON(Rp.)</th>   
                                <th>Rate</th>
                                <th>Gross IJP</th>                         
                                <th>Dis(Rp.)</th>
                                <th>Net IJP</th>
                                <th>Admin</th>
                                <th>Materai</th>
                                <th>Tot Bayar</th>
                                <th>JNS PENJAMINAN</th>
                                <th>AGING</th>
                                <th>DOKUMEN</th>                         
                                <th>ACTION</th>
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
                                <td align="right">{{number_format($datas -> rate, 2, ',', '.')}}</td>                                  
                                <td align="right">{{number_format($datas -> premi, 2, ',', '.')}}</td>                                  
                                <td align="right">{{number_format($datas -> pot, 2, ',', '.')}}</td>                                  
                                <td align="right">{{number_format($datas -> nett, 2, ',', '.')}}</td>                                  
                                <td align="right">{{number_format($datas -> admin, 2, ',', '.')}}</td>                                  
                                <td align="right">{{number_format($datas -> materai, 2, ',', '.')}}</td>                                  
                                <td align="right">{{number_format($datas -> nett+$datas -> admin+$datas -> materai, 2, ',', '.')}}</td>  
                                <td>{{$datas -> jenispenjaminan}}</td>
                                <td><b><p style="color: red;font-size: 15px">{{aging($datas -> tglpengajuan) }}</p></b>Hari</td>
                                <td>
                                    <a <?php if ($datas->files == '' ) {echo 'hidden=""';$hide='true';}else{$hide='';} ?> href="files/suratsehat/{{$datas -> files}}">Download Surat Sehat</a>
                                    <a <?php if ($datas->files2 == '') { echo 'hidden=""'; } ?> href="files/scanlab/{{$datas -> files2}}">Download Cek Lab</a>  
                                    <b style="color: red;"> <a href="" class="uploadsuratsehat" id="{{$datas -> idpenjaminan}}" style="color: red">Upload Surat Sehat</a></b></td>
                                <td>
                                    <div class=" btn-group-vertical">
                                        <?php if ($datas->files == '') 
                                            {
                                            $hide = 'true';
                                            } else {
                                            $hide = '';
                                            }
                                        ?>
                                        <button data-toggle="tooltip" data-placement="top" title="Lihat detail dan Ubah data" id="{{$datas->idpenjaminan}}"  type="button" class="btn btn-warning btn-xs editpenjaminan">Detail</button> 
                                        <a data-toggle="tooltip" data-placement="top" title="Lanjutkan ke proses bayar" ng-hide="{{$hide}}" href="/prosesbayarauto/{{ Crypt::encrypt($datas -> nosertifikat)}}" class="btn btn-primary btn-xs">Bayar</a>
                                        <button  data-toggle="tooltip" data-placement="top" title="Hapus data pengajuan"  id="{{$datas->idpenjaminan}}"   class="btn btn-danger btn-xs deletepenjaminan">Reject</button>
                                       
                                    </div>
                                </td>
                            </tr>
                            <?php $i++ ?>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </section>
        </body>                
    </div>
<!--    //pengajuan case by case-->
<div id="casebycase" class="tab-pane fade" align="center">

    <!-- Map box -->
    <h2 align="center">DATA PENGAJUAN PENJAMINAN KREDIT</h2>
    <h2 style="color: red" align="center">CASE BY CASEs</h2>
    <hr>
        <body ng-app="Penjaminan" ng-controller="PenjaminanController"> 
            <section  class="col-lg-13 connectedSortable">
                <!-- Map box -->
                <div class="box box-solid"> 
                    <table class="table table-hover"  style="font-size: 11px;border: 1px; border-color:  black" id="pembayaran"  > 
                        <thead>
                            <tr style="background-color:#23527c ;color: #000000">
                                <th>NO</th>
                                <th>TGL PENGAJUAN</th>                           
<!--                                <th>NO KTP</th>-->
                                <th>NAMA</th>                        
                                <th>TGL LAHIR</th>                        
                                <th>UMUR</th>                     
                                <th>JNS KREDIT</th>
                                <th>MULAI TGL</th>
                                <th>SAMPAI TGL</th>                           
                                <th>PLAFON(Rp.)</th>                               
                                <th>JNS PENJAMINAN</th>
                                <th>AGING</th>
                                <th>DOKUMEN</th>  
<!--                                <th>Status</th>-->
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            
//                           dd($case1);
                            ?>
                            @foreach($case1 as $datas)
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tglpengajuan))}}</td>     
<!--                                <td>{{$datas -> ktp}}</td>-->
                                <td>{{$datas -> nama}}</td>
                                <td>{{$datas -> tgllahir}}</td>
                                <td style="width:100%">{{$datas -> umur}}</td>                           
                                <td>{{$datas -> jeniskredit}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tgljatuhtempo))}}</td>                            
                                <td>{{number_format( $datas -> plafon, 0, ',', '.')}}</td>                                
                                <td>{{$datas -> jenispenjaminan}}</td>
                                <td><b><p style="color: red;font-size: 15px">{{aging($datas -> tglpengajuan) }}</p></b>Hari</td>
                               <td>
                                   
                                       <li <?php if ($datas->files == '') { echo 'hidden=""';} ?>><b><a href="" class="uploadscanlab" id="{{$datas -> idpenjaminan}}" style="color: green">Upload Scan Lab</a></b></li>
                                       <li <?php if ($datas->files == '' ) {echo 'hidden=""';} ?>><a  href="files/suratsehat/{{$datas -> files}}">Download Surat Sehat</a></li>
                                       <li <?php if ($datas->files2 == '') { echo 'hidden=""';} ?>><a href="files/scanlab/{{$datas -> files2}}">Download Cek Lab</a></li>
                                       <li><b style="color: red"> <a href="" class="uploadsuratsehat" id="{{$datas -> idpenjaminan}}" style="color: red">Upload Surat Sehat</a></b></li>
  
                                </td> 
                               
<!--                                <td><a style="color: red"><b>{{strtoupper($datas->app)}}</b></a></td>-->
                                <td>
                                <div    class=" btn-group-vertical">
                                    <?php if($datas->app=='Pembayaran'){$hide='true';}else{$hide='';} ?>
                                    <button id="{{$datas->idpenjaminan}}}" ng-hide="{{$hide}}" type="button" class="btn btn-warning btn-xs editpenjaminan">Detail</button> 
                                    <a ng-hide="<?php if($datas->app==''||$datas->app=='Tolak'||$datas->app=='Pengecekan'){echo 'true';} ?>" href="/prosesbayarcase/{{ base64_encode($datas -> nosertifikat)}}" class="btn btn-primary">Bayar</a>
                                    <button  data-toggle="tooltip" data-placement="top" title="Hapus data pengajuan"  id="{{$datas->idpenjaminan}}"   class="btn btn-danger btn-xs deletepenjaminan">Reject</button>
                                </div>
                                </td>
                            </tr>
                            <?php $i++ ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </body>

    </div>
<!--    //pengajuan Sudah Bayar-->
    <div id="sudahbayar" class="tab-pane fade">
    <h2 align="center">DATA PENGAJUAN PENJAMINAN KREDIT</h2>
    <h2 style="color: red" align="center">SUDAH PROSES BAYAR</h2>
        <body ng-app="Penjaminan" ng-controller="PenjaminanController">
            <section  class="col-lg-13 connectedSortable">
                <!-- Map box -->
                <div class="box box-solid">
                    <br>                      
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
    </div>
<!--    //pengajuan Sudah Di Setujui-->
    <div id="setuju" class="tab-pane fade">
        <h2 align="center">DATA PENGAJUAN PENJAMINAN KREDIT</h2>
    <h2 style="color: red" align="center">SUDAH DISETUJUI</h2>
        <body ng-app="Penjaminan" ng-controller="PenjaminanController">
            <section  class="col-lg-13 connectedSortable">
                <!-- Map box -->
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
    </div>
<!--    //pengajuan Di Tolak-->
    <div id="ditolak" class="tab-pane fade">
     <h2 align="center">DATA PENGAJUAN PENJAMINAN KREDIT</h2>
     <h2 style="color: red" align="center">DITOLAK</h2>
        <body ng-app="Penjaminan" ng-controller="PenjaminanController">
            <section  class="col-lg-13 connectedSortable">
                <!-- Map box -->
                <div class="box box-solid">
                    <br>                      
                    <table id="tabelpembayaran" class=" table table-hover"  style="font-size: 12px;  margin-left: -1%; border: 1px; border-color:  black"    >
                        <thead>
                            <tr style="width: 30px; background-color:#23527c ;color: #000000">
                                <th>NO</th> 
                                <th>TGL PENGAJUAN</th>                         
                                <th>TGL APPROVAL</th>                         
                                <th>NAMA</th>                      
                                <th>JNS KREDIT</th>
                                <th>MULAI TGL</th>
                                <th>SAMPAI TGL</th>                           
                                <th>MASA KREDIT</th>                           
                                <th>PLAFON</th>
                                <th>JNS PENJAMINAN</th> 
                                <th>STATUS</th>                           
                                <th>CATATAN</th>                     
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
                                <td>{{$datas -> jeniskredit}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tgljatuhtempo))}}</td>                            
                                <td>{{$datas -> masakredit}} Bulan</td>
                                <td>{{number_format($datas -> plafon, 0, ',', '.')}}</td>
                                <td>{{$datas -> jenispenjaminan}}</td>                           
                                <td>@if($datas -> app=='Tolak') <span class="label label-danger"> <i class="glyphicon glyphicon-remove">&nbsp;{{$datas -> app}}</i></span>@endif </td>
                                <td><textarea class="form-control" disabled="">{{$datas -> analisa}}</textarea></td>  
                                
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
<!--    //Sudah Terbit Sertifikat-->
    <div id="dapatcetak" class="tab-pane fade">
        <h2 align="center">DATA PENGAJUAN PENJAMINAN KREDIT</h2>
    <h2 style="color: red" align="center">SUDAH TERBIT SERTIFIKAT</h2>
        <body ng-app="Penjaminan" ng-controller="PenjaminanController">
            <section  class="col-lg-13 connectedSortable">
                <!-- Map box -->
                <div class="box box-solid">
                    <br>                      
                    <table id="tabel-test" class=" table table-hover"  style="font-size: 12px;  margin-left: -1%; border: 1px; border-color:  black"    >
                        <thead>
                            <tr style="width: 30px; background-color:#23527c ;color: #000000">
                                <th>NO</th> 
                                <th>NOMOR SERTIFIKAT</th>                         
                                <th>TGL TERBIT</th>                         
                                <th>NAMA TERJAMIN</th>                      
                                <th>JNS KERDIT</th>
                                <th>MULAI TGL</th>
                                <th>SAMPAI TGL</th>                           
                                <th>MASA KREDIT</th>                           
                                <th>PLAFON(Rp.)</th>
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
                            @foreach($cetak as $datas)
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
                          
                                <td>
                                    <div class=" btn-group-vertical">
                                        <a class="btn btn-primary" href="/cetakpdf/{{$datas ->nosertifikat}}"><i class="glyphicon glyphicon-print"></i> Cetak Sertifikat</a>
                                        <a class="btn btn-primary" href="/cetakpenjaminanpdf/{{$datas ->nosertifikat}}"> <i class="glyphicon glyphicon-print"></i> Cetak Penjaminan</a>
                                     </div>
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
                    </table>
                </div>
            </section>
        </body>
    </div>
<div id="laporan" class="tab-pane fade">
    <h2 align="center">CETAK REKAP PENGAJUAN</h2> 
    <body ng-app="Penjaminan" ng-controller="PenjaminanController">
        <section  class="col-lg-13 connectedSortable">
            <!-- Map box -->
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
                                            <option value="Setuju">DISETUJUI</option>                                                
                                            <option value="Tolak">DITOLAK</option>                                            

                                        </select>
                                    </th>
                                    <th>
                                        <br>
                                        <div class="input-group">
                                            <td><button  type="submit" class="btn btn-danger btn-xs">Filter</button></td>
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
            
        </section>
    </body>
</div>
</div>
  
</div>

    <div id="modalEditPenjaminan" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <form action="/UpdatePenjaminanUser" method="post"  id="formPenjaminanUpdate"  enctype="multipart/form-data" >
                <div class="panel-body">             
                    <div class="box-body col-sm-6">
                        <div class="box-body">
                            <h2>TERJAMIN</h2>
                            <hr color="#ff0000">                        
                            <div class="form-group">   
                                  <input hidden=""  class="form-control" id="idpenjaminan"  name="idpenjaminan" >   
                                @if (Session::has('idbank'))
                                                             
                                <input hidden="" required="" value="{{Session::get('idbank') }}" class="form-control" id="idbank"    name="idbank" placeholder="ID Bank"  maxlength="16" >                                  
                                @endif
                            </div>
                            <div class="form-group">
                                <label>No KTP</label>
                                <input required="" value="{{old('ktp')}}" class="form-control" id="ktp"   onkeypress="return  hanyaAngka(event, false)" name="ktp" placeholder="Nomor KTP"  maxlength="16" >
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
                            <div class="form-group ">
                                <label>Tanggal Lahir</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-time">
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
                            <div class="form-group">
                                <label>Pekerjaan</label>
                                <select required="" ng-model="pekerjaan" id="pekerjaan" name="pekerjaan" class="form-control">
                                    <option value="">Pilih Pekerjaan</option>
                                    <option value="PNS">PNS</option>                                                
                                    <option value="TNI">TNI</option>                                                
                                    <option value="POLRI">POLRI</option>                                                
                                    <option value="ANGGOTA DPR">ANGGOTA DPR</option>                                                
                                    <option value="PETANI">PETANI</option>                                                
                                    <option value="NELAYAN">NELAYAN</option>                                                
                                    <option value="KARYAWAN SWASTA">KARYAWAN SWASTA</option>                                               
                                    <option value="KARYAWAN BUMN">KARYAWAN BUMN</option>                                               
                                    <option value="KARYAWAN BUMD">KARYAWAN BUMD</option>                                               
                                    <option value="WIRASWASTA">SWASTA</option>                                               
                                    <option value="WIRASWASTA">WIRASWASTA</option>                                               
                                </select>
                                @if($errors->has('pekerjaan'))
                                <p style="color: red"> {{ $errors->first('pekerjaan')}}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Jenis Kredit</label>
                                <select required="" name="kredit" id="jeniskredit" class="form-control">
                                    <option value="">Pilih Jenis</option>
                                    <option value="PRODUKTIF">PRODUKTIF</option>                                                
                                    <option value="KONSUMTIF">KONSUMTIF</option>                                               
                                </select>
                                @if($errors->has('kredit'))
                                <p style="color: red"> {{ $errors->first('kredit')}}</p>
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
                        <h2>PENJAMINAN</h2>
                        <hr>
                        <div class="form-group ">
                             
                            <label>Tanggal Realisasi</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time">
                                    </i>
                                </div>
                                <input required=""  id="tglrealisasi" name="tglrealisasi"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                            </div>
                            @if($errors->has('tglrealisasi'))
                            <p style="color: red"> {{ $errors->first('tglrealisasi')}}</p>
                            @endif
                        </div>                          
                        <div class="form-group ">
                            <label>Tanggal Jatuh Tempo</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time">
                                    </i>
                                </div>
                                <input required="" id="tgljatuhtempo" name="tgljatuhtempo"   onchange="hitungUmurJatuhTempo()" id="tgljatuhtempo" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">

                            </div>
                            <br>

                            @if($errors->has('tgljatuhtempo'))
                            <p style="color: red"> {{ $errors->first('tgljatuhtempo')}}</p>
                            @endif
                        </div>                                
                        <div class="form-group ">
                            <label>Masa Kredit [Bulan]</label>
                            <div class="input-group">

                                <input hidden="" name="masakredit" id="masaKredit1" type="text">
                                <input required="" disabled="" id="masaKredit" type="text" class="form-control" >
                                <div class="input-group-addon">
                                    Bulan
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Umur Terjamin Saat Jatuh Tempo</label><br>
                            <input name="umurjatuhtempo" hidden="" class="form-control"  id="umurjatuhtempo1" >
                            <input required="" disabled=""  class="form-control"  id="umurjatuhtempo" >
                        </div>
                        <div id="pesanUmurJtauhTempo"></div>

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

                                @if($errors->has('plafon'))
                                <p style="color: red"> {{ $errors->first('plafon')}}</p>
                                @endif

                            </div>
                            <div id="pesanPlafon"></div>
                        </div>
                        <div class="form-group">
                            <label>Jenis Penjaminan</label>                            
                            <div id="Jenispilihan"></div>
                            <select required="" name="jenisPenjaminan"   id="JenisPnj"  class="form-control">
                                <option value="">Pilih Jenis Penjaminan</option>
                            </select>

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
                                <input hidden="" id="tglpengajuan1" name="tglPengajuan"   type="text">
                                <input disabled=""  id="tglpengajuan" type="text" class="form-control">
                            </div>
                        </div>
                       

                        <button type="submit" id="simpan" class="btn btn-warning btn-xs">Update</button>
                        {{csrf_field()}}
                    </div>
                </div>
            </form>  
        </div>
    </div>
</div>
    
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