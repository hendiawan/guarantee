@extends('layout.admin')
@section('content')
<script>
    $(document).ready(function() {
        
        var ctx = $("#chart-line");
        var myLineChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
//                labels: ["Produktif", "Konsumtif", "Fall", "Winter"],
                labels: ["Konsumtif", "Produktif"],
                datasets: [{
//                    data: [1200, 1700, 800, 200],
                    data: [{{$totalKonsumtif}}, {{$totalProduktif}}],
                    backgroundColor: ["rgba(255, 0, 0, 0.5)", "rgba(100, 255, 0, 0.5)", "rgba(200, 50, 255, 0.5)", "rgba(0, 100, 255, 0.5)"]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Penjaminan'
                }
            }
        });
         
        var options = {
          series: [
          {
            name: "Konsumtif",
            data: [
               {{$sumJanuariKonsumtif}},
               {{$sumFebruariKonsumtif}},
               {{$sumMaretKonsumtif}}, 
               {{$sumAprilKonsumtif}},  
               {{$sumMeiKonsumtif}},  
               {{$sumJuniKonsumtif}}, 
               {{$sumJuliKonsumtif}},  
               {{$sumAgsKonsumtif}},  
               {{$sumSepKonsumtif}},  
               {{$sumOktKonsumtif}},  
               {{$sumNovKonsumtif}},  
               {{$sumDesKonsumtif}},  
               ]
          },
          {
            name: "Produktif",
            data: [
                {{$sumJanuariProduktif}},
                {{$sumFebruariProduktif}},
                {{$sumMaretProduktif}}, 
                {{$sumAprilProduktif}},  
                {{$sumMeiProduktif}},  
                {{$sumJuniProduktif}},   
                {{$sumJuliProduktif}},    
                {{$sumAgsProduktif}},    
                {{$sumSepProduktif}},    
                {{$sumOktProduktif}},    
                {{$sumNovProduktif}},    
                {{$sumDesProduktif}},    
                             ]
               },
          
        ],
          chart: {
          height: 350,
          type: 'line',
          dropShadow: {
            enabled: true,
            color: '#000',
            top: 18,
            left: 7,
            blur: 10,
            opacity: 0.2
          },
          toolbar: {
            show: false
          }
        },
        colors: ['#77B6EA', '#545454'],
        dataLabels: {
          enabled: true,
        },
        stroke: {
          curve: 'smooth'
        },
        title: {
          text: 'Tingkat Penerimaan IJP',
          align: 'left'
        },
        grid: {
          borderColor: '#e7e7e7',
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        markers: {
          size: 1
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul','Ags','Sep','Okt','Nov','Des'],
          title: {
            text: 'Penjaminan'
          }
        },
        yaxis: {
          title: {
            text: 'Nilai IJP'
          },
          min: 1000000,
          max: 300000000
        },
        legend: {
          position: 'top',
          horizontalAlign: 'right',
          floating: true,
          offsetY: -25,
          offsetX: -5
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
         
    });
    
    $('#tooltips').tooltip('toggle')
</script>
 <br>
 
 @php
use App\Http\Controllers\DireksiController;
$direksi = new DireksiController();
@endphp
 
<div class="container-fluid "> 
    @if (Session::has('message'))
    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ Session::get('message') }}
    </div>
    @endif
    
   @if (Auth::user()->level != 'direksi')
    @if($totalsign>0)
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <a href="/CetaksertifikatSignCek" style="color:red">Ada <b>{{$totalsign}}</b> Dokumen sertifikat yang sudah ditandatangani Direksi !!!</a>
    </div>
    @endif
    @if($totalsignsb>0)
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <a href="/CetaksertifikatSignCekSb" style="color:red">Ada <b>{{$totalsignsb}}</b> Dokumen sertifikat Surety Bond yang sudah ditandatangani Direksi !!!</a>
    </div>
    @endif
    

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
    @if(Auth::user()->level == 'direksi')
    <legend>TANDA TANGANI DOKUMEN</legend>
    <hr> 
    <div class="container"> 
     <section class="col-lg-6 " > 
            <div class="panel panel-default"  >
                <div class="panel-heading" >
                           <strong><i class="glyphicon glyphicon-file"></i>  Penjaminan Kredit</strong>
                </div>
                <div class="panel-body">
                     <a style="border-radius: 20px;width: 100%"  href="{{url('/DigitalSign')}}"  class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i>   Sign</a>
                </div>
            </div>
        </section>  
      <section class="col-lg-6"> 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong><i class="glyphicon glyphicon-file"></i>  Surety Bond</strong>
                </div>
                <div class="panel-body">
                    <a  style="border-radius: 20px;width: 100%" href="{{url('/DigitalSignSb')}}" class="btn btn-success"><i class="glyphicon glyphicon-pencil"></i>   Sign</a>
                </div>
            </div>
        </section>   
    </div>
    @endif
    @if (Auth::user()->level != 'direksi') 
    
    <style>
        .maincontainer {
            width: 100%;
            margin: 10px auto; 
        }
        .mainprogressbar {
            counter-reset: step;
        }
        .mainprogressbar li {
            list-style-type: none;
            width: 11.6%;
            float: left;
            font-size: 12px;
            position: relative;
            text-align: center;
            text-transform: uppercase;
            color: #7d7d7d;
        }
        .mainprogressbar li:before {
            width: 30px;
            height: 30px;
            content: counter(step);
            counter-increment: step;
            line-height: 30px;
            border: 2px solid #7d7d7d;
            display: block;
            text-align: center;
            margin: 0 auto 10px auto;
            border-radius: 50%;
            background-color: white;
        }
        .mainprogressbar li:after {
            width: 100%;
            height: 2px;
            content: '';
            position: absolute;
            background-color: #7d7d7d;
            top: 15px;
            left: -50%;
            z-index: -1;
        }
        .mainprogressbar li:first-child:after {
            content: none;
        }
        .mainprogressbar li.active {
            color: green;
        }
        .mainprogressbar li.active:before {
            border-color: #55b776;
        }
        .mainprogressbar li.active + li:after {
            background-color: #55b776;
        }
    </style>
    <div style="margin-left: 2%" class="maincontainer">
        <ul class="mainprogressbar"> 
          <li class="active"><a  style="border-radius: 20px;width: 95%" class="btn btn-primary" href="/belumProsesAll" target="_blank"> {{$totalbaru}} Pengajuan </a></li> 
          <li><a  style="border-radius: 20px;width: 95%" class="btn btn-primary" href="/belumProsesCaseAll" target="_blank">   {{$totalcase}} Case </a></li> 
          <li><a  style="border-radius: 20px;width: 95%" class="btn btn-primary" href="/sudahprosescaseall" target="_blank">   {{$totalcasebayar}} Pembayaran </a></li>
          <li class="active">   <a  style="border-radius: 20px;width: 95%" class="btn btn-primary" href="/revisi" target="_blank">  {{$sum_revisi}} Revisi</a></li> 
          <li>  <a style="border-radius: 20px;width: 95%" class="btn btn-primary" href="/posisi-kabag"     target="_blank">  {{$sum_kabag}} Kabag</a> </li> 
          <li>  <a style="border-radius: 20px;width: 95%" class="btn btn-primary" href="/posisi-direksi"     target="_blank">  {{$sum_direksi}} Direksi</a> </li> 
          <li><a  style="border-radius: 20px;width: 95%" class="btn btn-primary" href="hasil-app-direksi" style="color:red"> {{$totalcasesetuju}} Setuju</a></li> 
          <li> <a style="border-radius: 20px;width: 95%"  class="btn btn-primary" href="/CetaksertifikatSignCek" style="color:red"> <b>{{$totalsign}}</b> Sign</a></li>
       
  </ul> 
    </div>
    <br>
    <br>
    <br>
    <br>
    
    <hr>
    <style>
        .sidenav {
  width: 80px;
  position: fixed;
  z-index: 1;
  top: 230px;
  left: 20px;
  background: #cccccc;
  overflow-x: hidden;
  padding: 8px 0;
  border-radius: 15px; 
  opacity: 0.6;
   text-align: center; 
}

.sidenav:hover {
 opacity:1
 }

.sidenav a {
  padding: 20px 10px 20px 5px;
  text-decoration: none;
  font-size: 13px;
  color: #ffffff;
  display: block;
  margin-bottom: 10px;
  text-align:center; 
 border-radius: 5px;
 text-align: center;
  opacity:1
}
/*
.sidenav a:hover {
   opacity:2
}*/

.sidenav a:hover {
    color: #ff3333;
     font-weight: 600;
}

.tooltip {
  position:relative; /* making the .tooltip span a container for the tooltip text */
  border-bottom:1px dashed #000; /* little indicater to indicate it's hoverable */
}
    </style>
    
    
    <div class="sidenav">
        <div style="margin:10px">
            <a style="width: 100%" class="btn btn-primary"  href="#about"> <i class="glyphicon glyphicon-user"></i> </a>
            <a style="width: 100%" class="btn btn-primary"   href="#services"><i class="glyphicon glyphicon-user"></i> </a>
            <a style="width: 100%" class="btn btn-primary"   href="#clients"><i class="glyphicon glyphicon-user"></i> </a>
            <a style="width: 100%" class="btn btn-primary"   href="#contact"><i class="glyphicon glyphicon-user"></i> </a>
        </div> 
    </div>
    <section style="  left: 70px;" class="col-lg-2 " > 
         <legend style="font-size: 22px;"><b>Data Penjaminan </b></legend>
   
        <div class="panel panel-default" style="border-radius: 15px"   >
             <div class="panel-heading" style="border-radius: 15px 15px 0px 0px"  >
                 <strong><i class="glyphicon glyphicon-user"></i>  Jumlah Terjamin</strong>
             </div>
             <div class="panel-body">
                 {{$sum_terjamin}} Terjamin
             </div>
         </div>
      <div class="panel panel-default" style="border-radius: 15px"   >
             <div class="panel-heading" style="border-radius: 15px 15px 0px 0px"  >
                    <strong><i class="glyphicon glyphicon-equalizer"></i> IJP Nett</strong>
                </div>
                <div class="panel-body">
                        Rp. {{number_format($sum_ijp,0,',','.')}} 
                </div>
            </div>
         <div class="panel panel-default" style="border-radius: 15px"   >
             <div class="panel-heading" style="border-radius: 15px 15px 0px 0px"  >
                    <strong><i class="glyphicon glyphicon-user"></i>  Jumlah Pengajuan direvisi <span class="label label-danger">{{$sum_revisi}} </span></strong>
                </div>
                <div class="panel-body">
                    <a  style="border-radius: 20px;width: 100%" class="btn btn-primary" href="/revisi" target="_blank"> <b>  {{$sum_revisi}} Pengajuan </b></a>
                </div>
            </div> 
         
           <div class="panel panel-default" style="border-radius: 15px"   >
             <div class="panel-heading" style="border-radius: 15px 15px 0px 0px"  >
                    <strong><i class="glyphicon glyphicon-inbox"></i>   Jumlah Pengajuan Posisi Direksi <span class="label label-danger"> {{$sum_direksi}} </span></strong>
                </div>
                <div class="panel-body"> 
                     <a href="/posisi-direksi" style="border-radius: 20px;width: 100%" class="btn btn-primary"   target="_blank"> <b>  {{$sum_direksi}} Pengajuan</b></a> 
                </div>
            </div>
         
        </section>  
      
    <div style="margin-left: 75px;margin-right: 5px "class="col-sm-6 col-md-5">
         <center><legend style="font-size: 22px;"><b>Chart Penjaminan </b></legend></center>
         <div style=" border-radius: 24px"class="card">
            <div class="card-header"> chart</div>
            <div class="card-body" style="height: 420px">
                <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                    <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                        <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                        <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                    </div>
                </div> <canvas id="chart-line" width="299" height="140" class="chartjs-render-monitor" style="display: block; width: 299px; height: 200px;"></canvas>
            </div>
        </div>
    </div> 
    
     <section class="col-lg-4 " > 
         <legend style="font-size: 22px;"><b>Grafik Penjaminan </b></legend>
   
        <div class="panel panel-default" style="border-radius: 15px"   >
             <div class="panel-heading" style="border-radius: 15px 15px 0px 0px"  >
                 <strong><i class="glyphicon glyphicon-calendar"></i>  Nominal Penjaminan</strong>
             </div>
             <div class="panel-body">
<!--               <h3 class="text-primary text-center">
    Morris js charts
  </h3>-->
  <div class"row">
       <div id="chart">
      </div>
  </div>
             </div>
         </div>
     </section>
   <hr>
   
       @endif
   
      
   <hr>
   <section class="col-lg-12">
       <ul  class="nav nav-tabs">
         @if (Auth::user()->level != 'direksi') <li ><a style="color: black"  class="label label-primary active " data-toggle="tab" href="#home">Pengajuan Baru @if($totalbaru>0)<span class="label label-danger">{{$totalbaru}}</span>@endif</a></li>@endif
         @if (Auth::user()->level != 'direksi')  <li><a style="color: black"  class="label label-primary" data-toggle="tab" href="#home1">Case by Case @if($totalcase+$totalcasebayar>0)<span class="label label-danger">{{$totalcase+$totalcasebayar}}</span>@endif</a></li>@endif
         @if (Auth::user()->level != 'direksi')<li><a style="color: black"   class="label label-primary" data-toggle="tab" href="#disetujui">Disetujui @if($totalsetuju)<span class="label label-danger">{{$totalsetuju}}</span>@endif</a></li>@endif
         @if (Auth::user()->level != 'direksi')      <li><a style="color: black"  class="label label-primary"  data-toggle="tab" href="#ditolak">Ditolak</a></li>@endif
        <li><a style="color: black"  class="label label-primary"  data-toggle="tab" href="#dicetak">Sertifikat Terbit</a></li>    
        <li><a style="color: black"  class="label label-primary"  data-toggle="tab" href="#sign">Sertifikat Penjaminan Sign</a></li>    
        <li><a style="color: black"  class="label label-primary"  data-toggle="tab" href="#signSb">Sertifikat Surety Bond Sign</a></li>    
        <li><a style="color: black"  class="label label-primary"  data-toggle="tab" href="#laporan">Rekap</a></li>
    </ul>
       
           
<div class="tab-content">
    @if (Auth::user()->level != 'direksi')
    <div id="home" class="tab-pane fade in active">
        <h2></h2>   
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <h2 align="center">PENGAJUAN PENJAMINAN KREDIT</h2>
                    <h2 style="color: #006666" align="center">BELUM VERIFIKASI</h2>
                </strong>
            </div>
            <div class="panel-body">
                <section  class="col-lg-13 connectedSortable">
                    <!-- Map box -->
                    <div class="box box-solid">
                        <table style="font-size: 11px" class="table table-bordered tabel">
                            <thead>
                                <tr style="background-color:#ffffff ;color: #006666">
                                    <th>No</th>                             
                                    <th>Nama Bank</th>
                                    <th>Total Pengajuan Belum Di Proses</th>
                                    <th>Action</th>                       
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($data as $datas)
                                <tr style="background-color:#ffffff ;color: #000000">  
                                    <td>{{$i}}</td>                           
                                    <td>{{$datas-> namabank}}</td>
                                    <td>{{$datas-> total}}</td>
                                    <td><a  style="margin: 5px;width: 80%; border-radius: 20px" class="btn btn-primary"  href="/belumproses/{{$datas-> idbank}}">View Detail</a></td>  
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
    <div id="signSb" class="tab-pane fade">
       <div class="panel panel-default">
            <div class="panel-heading">
            <strong>
                    <h2 align="center">PENGAJUAN SURETY BOND</h2>
                    <h2 style="color: red" align="center">SUDAH DI TANDA TANGANI</h2>
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
                                    <th>Nama Kontraktor</th>
                                    <th>Nomor Sertifikat</th>
                                    <th>Action</th>                       
                                </tr>
                            </thead>   
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($sppsb as $datas)
                                <tr style="background-color:#bdbdbd ;color: #000000">  
                                    <td>{{$i}}</td>                           
                                    <td>{{$datas->nama_kontraktor}}</td>
                                    <td>{{$datas-> no_jaminan}}</td>
                                    <!--<td><a target='_blank' href="/sertifikatSppsb/{{$datas-> id}}">View Sertifikat</a></td>-->  
                                    <td><a target='_blank' href="/verifikasi-doc-sertifikat-surety/{{$direksi->enkripsi($datas->id)}}">View Sertifikat</a></td>  
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
    <div id="sign" class="tab-pane fade">
       <div class="panel panel-default">
            <div class="panel-heading">
            <strong>
                    <h2 align="center">PENGAJUAN PENJAMINAN KREDIT </h2>
                    <h2 style="color: red" align="center">SUDAH DI TANDA TANGANI</h2>
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
                                @foreach($sign as $datas)
                                <tr style="background-color:#bdbdbd ;color: #000000">  
                                    <td>{{$i}}</td>                           
                                    <td>{{$datas-> namabank}}</td>
                                    <td>{{$datas-> total}}</td>
                                    <td><a target='_blank' href="/sertifikatSign/{{$datas-> idbank}}">View Detail</a></td>  
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
 
       
   </section> 
 

  
<br>
<br>
</div>
<ul class="nav nav-tabs">
<!--    <li>
        <button type="button" name="add_button" ng-click="addDataPenjaminan()" class="btn btn-primary">ADD PENJAMINAN</button>
    </li>  -->
</ul>


@endsection

