
<br/>
<br/>
@extends('layout.bootstraplogin.index')

@section('content')

<div class="jumbotron text-center">
    <center>
        <!--<div style="background-image:url('img/jamkrida.png');background-repeat:no-repeat;position: relative "></div>-->
        <img src="/img/jamkrida.png"  height="15%" alt="User Image">
    </center>
  <h1>DETAIL SERTIFIKAT PENJAMINAN</h1>
  <p>NOMOR : <strong>{{$sertifikat->kodesertifikat }}</strong></p>
</div>
  <div class="panel panel-default">
            <div class="panel-heading">
                <center>
                    <strong>DETAIL SERTIFIKAT PENJAMINAN</strong> 
                    <strong></strong>
                </center>
            </div>
            

<div id="main" class="container-fluid">
    <div class="topTabs">

        <div id="topTabs-container-home">
            <div class="topTabsContent" style="padding-left:0;"> 
                <div id="tab1">					
                    <form id="sppsbForm" class="form-horizontal" action="{{ url('/sppsb-update') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $sertifikat->id }}">		
                        <input type="hidden" name="no_registrasi" value="{{$sertifikat->no_registrasi}}">	
                        <div class="widget-header">
                            <h3 class="widget-title">I. IDENTIFIKASI TERJAMIN</h3>
                        </div>
                        <hr>
                        <div class="widget-content pad20f">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>NIK</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sertifikat->ktp }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Nama Terjamin</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sertifikat->nama }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Tanggal Lahir</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ date('d-m-Y',strtotime($sertifikat->tgllahir)) }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Alamat Terjamin</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sertifikat->alamat }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Pekerjaan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sertifikat->pekerjaan }}</p>
                                </div>
                            </div> 
                             
                        </div>	
                        <div class="divider"></div>		
                        <div class="widget-header">
                            <h3 class="widget-title">II. IDENTIFIKASI PENERIMA JAMINAN</h3>
                        </div>
                         <hr>
                        <div class="widget-content pad20f">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>NAMA BANK</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sertifikat->namabank }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Alamat Bank</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sertifikat->alamatbank }}</p>
                                </div>
                            </div>
                        </div>	
                        <div class="divider"></div>		
                        <div id="questions" class="widget-header">
                            <h3 class="widget-title">III. URAIAN PENJAMINAN</h3>
                        </div>
                        <hr>
                        <div class="widget-content pad20f">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>No PK</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">
                                        {{$sertifikat->nopk}}
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Tanggal PK</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">
                                        {{date('d-m-Y',strtotime($sertifikat->tglpk))}}
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Jenis Penjaminan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">
                                        {{$sertifikat->jenispenjaminan}}
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Jenis Kredit</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">
                                        {{$sertifikat->jeniskredit}}
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Tanggal Pengajuan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static"> {{ date('d-m-Y',strtotime($sertifikat->tglpengajuan)) }}  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Tanggal Terbit</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static"> {{ date('d-m-Y',strtotime($sertifikat->tglterbit)) }}  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Plafon</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static"> Rp. {{number_format($sertifikat->plafon, 2, '.', ',')}} </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Jangka Waktu Penjaminan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ date('d-m-Y',strtotime($sertifikat->tglrealisasi))}} <strong>s/d</strong> {{ date('d-m-Y',strtotime($sertifikat->tgljatuhtempo)) }} <strong>( {{$sertifikat->masakredit}} Bulan)</strong></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Rate IJP</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sertifikat->rate }}%</p>
                                </div>
                            </div><div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Admin</strong></label>
                                <div class="col-sm-9">
                                     <p class="form-control-static"> Rp. {{number_format($sertifikat->admin, 2, '.', ',')}} </p>
                                </div>
                            </div><div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Materai</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static"> Rp. {{number_format($sertifikat->materai, 2, '.', ',')}} </p>
                                </div>
                            </div><div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Gross IJP</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static"> Rp. {{number_format($sertifikat->premi, 2, '.', ',')}} </p>
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong> Fee Bank</strong></label>
                                <div class="col-sm-9">
                                     <p class="form-control-static">{{number_format($sertifikat->dis, 2, '.', ',')}} %</p>
                                </div>
                            </div>
                             
                             <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Nett IJP</strong></label>
                                <div class="col-sm-9">
                                   <p class="form-control-static"> Rp. {{number_format($sertifikat->nett, 2, '.', ',')}} </p>
                                </div>
                            </div>
                           
                        </div>	
                        
                        <hr/>
                         
                    </form>					                    	
                </div>
                <div id="tab2">
                    <div class="widget-content pad20f">	
                        <center>
                              <p><strong>PT JAMKRIDA NTB BERSAING</strong></p>
                        </center>
                      
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>

 
 

@endsection
