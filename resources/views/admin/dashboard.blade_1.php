@extends('layout.admin')
@section('content')


<div class="container">
    @if (Session::has('message'))
    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ Session::get('message') }}
    </div>
    @endif
    @if (Auth::user()->level != 'direksi')
    @if (Session::has('ubahpass'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <b><a href="logout" style="color:green">Password berhasil di ubah, silahkan Logout kemudian Login kembali</a></b>
    </div>
    @endif
    
    @if (Session::has('pesan'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ Session::get('pesan') }}
    </div>
    @endif
    
    @if($totalcasesetuju>0)
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <a href="hasil-app-direksi" style="color:red">Ada <b>{{$totalcasesetuju}}</b> pengajuan <b style="color:black"> CASE BY CASE </b> yang sudah di setujui Direksi</a>
    </div>
    @endif
    
    @if($totalcasetolak>0)
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <a href="hasil-app-direksi" style="color:red">Ada <b>{{$totalcasetolak}}</b> pengajuan <b style="color:black"> CASE BY CASE </b> yang sudah di tolak Direksi</a>
    </div>
    @endif
    
    @if($totalbaru>0)
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <a href="belumProsesAll" style="color:red">Ada <b>{{$totalbaru}}</b> pengajuan baru belum diverifikasi, silahkan verifikasi pengajuan !!!</a>
    </div>
    @endif
    
    @if($totalkompensasi>0)
    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <a href="belumproseskompensasi" style="color:black">Ada <b  style="color:black">{{$totalkompensasi}}</b> pengajuan <b>kompensasi</b> belum diverifikasi, silahkan verifikasi pengajuan !!!</a>
    </div>
    @endif
    
    @if($totalulang>0)
    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <a href="belumProsesUlang" style="color:black">Ada <b>{{$totalulang}}</b> pengajuan ulang belum diverifikasi, silahkan verifikasi pengajuan !!!</a>
    </div>
    @endif
    
    @if($totalulangcase>0)
    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <a href="belumProsesUlangCase" style="color:black">Ada <b>{{$totalulangcase}}</b> pengajuan ulang Case By Case belum diverifikasi, silahkan verifikasi pengajuan !!!</a>
    </div>
    @endif
    
    @if($totalcase>0)
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <a href="belumProsesCaseAll" style="color:red">Ada <b>{{$totalcase}}</b> pengajuan CASE BY CASE belum diverifikasi, silahkan verifikasi pengajuan !!!</a>
    </div>
    @endif
    
    @if($totalcasebayar>0)
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <a href="sudahprosescaseall" style="color:red">Ada <b>{{$totalcasebayar}}</b> pengajuan CASE BY CASE sudah melakukan pembayaran, silahkan validasi pembayaran</a>
    </div>
    @endif
    
    @if($totalsetuju>0)
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <a href="sudahsetujuall" style="color:red">Ada <b>{{$totalsetuju}}</b> pengajuan sudah disetujui belum diterbitkan sertifikat, silahkan terbikan sertifikat !!!</a>
    </div>
    @endif
    
    @else
      @if($totalappdireksi>0)
        <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <a href="appdireksi" style="color:red">Ada <b>{{$totalappdireksi}}</b> Pengajuan Case by Case yang membutuhkan approval anda !!!</a>
        </div>
      @endif
    @endif
<!--     <legend>DATA SATU BULAN TERAKHIR</legend>
   <hr>
      <section class="col-lg-3 "> 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong><i class="glyphicon glyphicon-user"></i>  Jumlah Terjamin</strong>
                </div>
                <div class="panel-body">

                </div>
            </div>
        </section> /.Left col 
        <section class="col-lg-3 "> 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong><i class="glyphicon glyphicon-inbox"></i>  Total  Penjaminan</strong>
                </div>
                <div class="panel-body">

                </div>
            </div>
        </section> /.Left col 
        <section class="col-lg-3 "> 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong><i class="glyphicon glyphicon-usd"></i>IJP Gross</strong>
                </div>
                <div class="panel-body">

                </div>
            </div>
        </section> /.Left col 
        <section class="col-lg-3 "> 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong><i class="glyphicon glyphicon-equalizer"></i>IJP Nett</strong>
                </div>
                <div class="panel-body">

                </div>
            </div>

        </section> /.Left col -->
     <legend>Menu Utama</legend>
   <hr>
    <ul  class="nav nav-tabs">
        @if (Auth::user()->level != 'direksi') <li ><a style="color: black"  class="label label-success" data-toggle="tab" href="#home">Pengajuan Baru @if($totalbaru>0)<span class="label label-danger">{{$totalbaru}}</span>@endif</a></li>@endif
        <li><a style="color: black"  class="label label-success" data-toggle="tab" href="#home1">Case by Case @if($totalcase+$totalcasebayar>0)<span class="label label-danger">{{$totalcase+$totalcasebayar}}</span>@endif</a></li>
        @if (Auth::user()->level != 'direksi')<li><a style="color: black"   class="label label-success" data-toggle="tab" href="#disetujui">Disetujui @if($totalsetuju)<span class="label label-danger">{{$totalsetuju}}</span>@endif</a></li>@endif
        <li><a style="color: black"  class="label label-success"  data-toggle="tab" href="#ditolak">Ditolak</a></li>
        <li><a style="color: black"  class="label label-success"  data-toggle="tab" href="#dicetak">Sertifikat Terbit</a></li>    
        <li><a style="color: black"  class="label label-success"  data-toggle="tab" href="#laporan">Rekap</a></li>
    </ul>
    <br>
    
<div class="tab-content">
    @if (Auth::user()->level != 'direksi')
    <div id="home" class="tab-pane fade in active">
        <h2></h2>   
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <h2 align="center">PENGAJUAN PENJAMINAN KREDIT</h2>
                    <h2 style="color: red" align="center">BELUM VERIFIKASI</h2>
                </strong>
            </div>
            <div class="panel-body">
                <section  class="col-lg-13 connectedSortable">
                    <!-- Map box -->
                    <div class="box box-solid">
                        <table style="font-size: 11px" class="table table-bordered tabel">
                            <thead>
                                <tr style="background-color:#23527c ;color: #ffffff">
                                    <th>No</th>                             
                                    <th>Nama Bank</th>
                                    <th>Total Pengajuan Belum Di Proses</th>
                                    <th>Action</th>                       
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($data as $datas)
                                <tr style="background-color:#bdbdbd ;color: #000000">  
                                    <td>{{$i}}</td>                           
                                    <td>{{$datas-> namabank}}</td>
                                    <td>{{$datas-> total}}</td>
                                    <td><a href="/belumproses/{{$datas-> idbank}}">View Detail</a></td>  
                                </tr>
                                <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>    
                    </div>
                </section>  
            </div>
        </div>
            <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <h2 align="center">DATA TERJAMIN DI SERVER LOKAL </h2>
                    <h2 style="color:red" align="center">PERIODE {{date('M')}} {{date('Y')}} </h2>
                </strong>
            </div>
            <div class="panel-body">
                <section  class="col-lg-13 connectedSortable">
                    <!-- Map box -->
                    <div class="box box-solid">
                        <table style="font-size: 11px" class="table table-bordered tabel">
                            <thead>
                         <tr style="background-color:#23527c ;color: #ffffff">
                                    <th>No</th>                             
                                    <th>Kode Terjamin</th>
                                    <th>Nama Terjamin</th>
                                    <th>Tanggal Register</th>
                                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($terjamin as $datas)
                                <tr style="background-color:#bdbdbd ;color: #000000">  
                                    <td>{{$i}}</td>                           
                                    <td>{{$datas->kd_terjamin}}</td>
                                    <td>{{$datas->nama}}</td>
                                    <td>{{$datas->tanggal_daftar}}</td>
                                </tr>
                                <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>    
                    </div>
                </section>  
            </div>
        </div>
        
 
    </div>
    @endif
    <div id="home1" class="tab-pane fade">
        <h2></h2> 
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <h2 align="center">PENGAJUAN PENJAMINAN KREDIT CASE BY CASE</h2>
                    <h2 style="color: red" align="center">BELUM VERIFIKASI</h2>
                </strong>
            </div>
            <div class="panel-body">
                <section  class="col-lg-13 connectedSortable">
                    <!-- Map box -->
                    <div class="box box-solid">
                        <table style="font-size: 11px" class="table table-bordered tabel">
                            <thead>
                                   <tr style="background-color:#23527c ;color: #ffffff">
                                    <th>No</th>                             
                                    <th>Nama Bank</th>
                                    <th>Total Pengajuan Belum Di Proses</th>
                                    <th>Action</th>                       
                                </tr>
                            </thead>
                            <tbody>
                                <?php
//                        echo '<pre>';
//                        print_r($casebycase);
//                        echo '</pre>';
                                $i = 1;
                                ?>                       
                                @foreach($casebycase as $datas)
                                <tr style="background-color:#bdbdbd ;color: #000000">  
                                    <td>{{$i}}</td>                           
                                    <td>{{$datas-> namabank}}</td>
                                    <td>{{$datas-> total}}</td>
                                    <td><a href="/belumprosescase/{{$datas->idbank}}">View Detail</a></td>                             
                                </tr>
                                <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </section>  
            </div>
        </div>
        @if (Auth::user()->level != 'direksi')
        <div class="panel panel-default">
            <div class="panel-heading">
                 <strong>
                    <h2 align="center">PENGAJUAN PENJAMINAN KREDIT CASE BY CASE</h2>
                    <h2 style="color: red" align="center">SUDAH PROSES BAYAR</h2>
                </strong>   
            </div>
            <div class="panel-body">
                <section  class="col-lg-13 connectedSortable">
                    <!-- Map box -->
                    <div class="box box-solid">
                        <table style="font-size: 11px" class="table table-bordered tabel">
                            <thead>
                                 <tr style="background-color:#23527c ;color: #ffffff">
                                    <th>No</th>                             
                                    <th>Nama Bank</th>
                                    <th>Total Pengajuan Belum Di Proses</th>
                                    <th>Action</th>                       
                                </tr>
                            </thead>
                            <tbody>
                                <?php
//                        echo '<pre>';
//                        print_r($casebycase);
//                        echo '</pre>';
                                $i = 1;
                                ?>                       
                                @foreach($casebycasesudahbayar as $datas)
                                <tr style="background-color:#bdbdbd ;color: #000000">  
                                    <td>{{$i}}</td>                           
                                    <td>{{$datas-> namabank}}</td>
                                    <td>{{$datas-> total}}</td>
                                    <td><a href="/sudahprosescase/{{$datas->idbank}}">View Detail</a></td>                             
                                </tr>
                                <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>  
            </div>
        </div>
        @endif
    </div>
    
    <div id="disetujui" class="tab-pane fade">
        <div class="panel panel-default">
            <div class="panel-heading">
                
                <strong>
                    <h2 align="center">PENGAJUAN PENJAMINAN KREDIT </h2>
                    <h2 style="color: red" align="center">SUDAH DISETUJUI BELUM TERBIT SERTIFIKAT</h2>
                </strong>      
            </div>
            <div class="panel-body">
                <section  class="col-lg-13 connectedSortable">
                    <!-- Map box -->
                    <div class="box box-solid">
                        <table style="font-size: 11px" class="table table-bordered tabel">
                            <thead>
                                 <tr style="background-color:#23527c ;color: #ffffff">
                                    <th>No</th>                             
                                    <th>Nama Bank</th>
                                    <th>Total Disetujui</th>
                                    <th>Action</th>                       
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($setuju as $datas)
                                <tr style="background-color:#bdbdbd ;color: #000000">  
                                    <td>{{$i}}</td>                           
                                    <td>{{$datas-> namabank}}</td>
                                    <td>{{$datas-> total}}</td>
                                    <td><a href="/sudahsetuju/{{$datas-> idbank}}">View Detail</a></td>  
                                </tr>
                                <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>    
                    </div>
                </section>  
            </div>
        </div>
    </div>
    <div id="ditolak" class="tab-pane fade">
       <div class="panel panel-default">
            <div class="panel-heading">
               <strong>
                    <h2 align="center">PENGAJUAN PENJAMINAN KREDIT </h2>
                    <h2 style="color: red" align="center">DITOLAK</h2>
                </strong>   
            </div>
            <div class="panel-body">
                <section  class="col-lg-13 connectedSortable">
                    <!-- Map box -->
                    <div class="box box-solid">
                        <table style="font-size: 11px" class="table table-bordered tabel">
                            <thead>
                              <tr style="background-color:#23527c ;color: #ffffff">
                                    <th>No</th>                             
                                    <th>Nama Bank</th>
                                    <th>Total Ditolak</th>
                                    <th>Action</th>                       
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($tolak as $datas)
                                <tr style="background-color:#bdbdbd ;color: #000000">  
                                    <td>{{$i}}</td>                           
                                    <td>{{$datas-> namabank}}</td>
                                    <td>{{$datas-> total}}</td>
                                    <td><a target="_blank" href="/tolakan/{{$datas-> idbank}}">View Detail</a></td>  
                                </tr>
                                <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>    
                    </div>
                </section>  
            </div>
        </div>
    </div>
    <div id="dicetak" class="tab-pane fade">
       <div class="panel panel-default">
            <div class="panel-heading">
            <strong>
                    <h2 align="center">PENGAJUAN PENJAMINAN KREDIT </h2>
                    <h2 style="color: red" align="center">SUDAH CETAK SERTIFIKAT</h2>
                </strong>       
            </div>
            <div class="panel-body">
                <section  class="col-lg-13 connectedSortable">
                    <!-- Map box -->
                    <div class="box box-solid">
                        <table style="font-size: 11px" class="table table-bordered tabel">
                            <thead>
                                <tr style="background-color:#23527c ;color: #ffffff">
                                    <th>No</th>                             
                                    <th>Nama Bank</th>
                                    <th>Total Sertifikat Terbit</th>
                                    <th>Action</th>                       
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($cetak as $datas)
                                <tr style="background-color:#bdbdbd ;color: #000000">  
                                    <td>{{$i}}</td>                           
                                    <td>{{$datas-> namabank}}</td>
                                    <td>{{$datas-> total}}</td>
                                    <td><a target='_blank' href="/sertifikatTerbit/{{$datas-> idbank}}">View Detail</a></td>  
                                </tr>
                                <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>    
                    </div>
                </section>  
            </div>
        </div>
    </div>
    <div id="laporan" class="tab-pane fade">
  
    <body ng-app="Penjaminan" ng-controller="PenjaminanController">
        <section  class="col-lg-13 connectedSortable">
            <!-- Map box -->
            <div class="box box-solid">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><i class="glyphicon glyphicon-"></i>    <h2 align="center">REKAP PENJAMINAN</h2> </strong>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="cetaklaporan">
                            {{csrf_field()}}
                            <table>
                                <tr>
                                    <th style="width:20% ">Bank</th>
                                    <th style="width:20% ">Dari</th>
                                    <th style="width:20% ">Sampai</th>
                                    <th style="width:20% ">Jns Kredit</th>
                                    <th style="width:20% "> Jns Laporan</th>
                                </tr>
                                <tr> 
                                    <th>
                                        <select id="pilihbank" required="" name="bank" class="form-control">
                                            <option value="">Pilih Bank</option>
                                            <option value="%">Semua Bank</option>                                                
                                            @foreach($bank as $data)
                                            <option value="{{$data->idbank}}">{{$data->namabank}}</option>                                                
                                            @endforeach 
                                        </select>
                                    </th>
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
                                            <option value="KONSUMTIF">KOMSUMTIF</option>                                                
                                        </select>
                                    </th>
                                    <th>
                                        <select required="" name="jenislaporan" class="form-control">
                                            <option value="">Pilih Jenis</option>
                                            <option value="%">SEMUA</option>   
                                            <option value="INTERNAL">LAPORAN INTERNAL</option>
                                            <option value="CASE">CASE BY CASE</option>                                                
<!--                                            <option value="Pengecekan">BARU</option>                                                
                                            <option value="Setuju">DISETUJUI</option>                                                
                                            <option value="Tolak">DITOLAK</option>                                            -->

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
            
        </section>
    </body>
</div>
    
</div>
 
  
<br>
<br>
</div>
<ul class="nav nav-tabs">
<!--    <li>
        <button type="button" name="add_button" ng-click="addDataPenjaminan()" class="btn btn-primary">ADD PENJAMINAN</button>
    </li>  -->
</ul>


@endsection