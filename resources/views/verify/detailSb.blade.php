@php
    use App\Http\Controllers\DireksiController;
    $direksi = new DireksiController();
@endphp
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
  <p>NOMOR : <strong>{{$sertifikat->no_jaminan }}</strong></p>
</div>
  <div class="panel panel-default">
            <div class="panel-heading">
                <center>
                    <strong>DETAIL SERTIFIKAT SURETY BOND</strong> 
                    <strong></strong>
                </center>
            </div>
            

<div id="main" class="container-fluid">
    <div class="topTabs">

        <div id="topTabs-container-home">
            <div class="topTabsContent" style="padding-left:0;"> 
                  
                        <div class="widget-header">
                            <h3 class="widget-title">I. IDENTIFIKASI TERJAMIN</h3> 
                       </div>
                        <hr> 
                        <div class="widget-content pad20f">
                              <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Nama Kontraktor</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sertifikat->nama_kontraktor }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Alamat Kontraktor</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sertifikat->alamat_kontraktor }}</p>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Bidang Usaha</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sertifikat->bidang_usaha }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Nama Direksi</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sertifikat->direksi }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Jabatan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sertifikat->jabatan_direksi }}</p>
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
                                <label class="col-sm-3 control-label"><strong>Pemilik Proyek</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sertifikat->pemilik_proyek }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Nama Pejabat</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sertifikat->nama_pejabat }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Jabatan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sertifikat->jabatan_pejabat }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Alamat</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sertifikat->alamat }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Jenis Pekerjaan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sertifikat->jenis_pekerjaan }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Jenis Dokumen</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sertifikat->nama_dokumen }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>No Dokumen</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sertifikat->no_dokumen }}</p>
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
                                <label class="col-sm-3 control-label"><strong>Janis Penjaminan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">
                                        @if($sertifikat->jenis_sppsb=='1')
                                        JAMINAN PENAWARAN
                                        @endif
                                        @if($sertifikat->jenis_sppsb=='2')
                                        JAMINAN PELAKSANAAN
                                        @endif
                                        @if($sertifikat->jenis_sppsb=='3')
                                        JAMINAN UANG MUKA
                                        @endif
                                        @if($sertifikat->jenis_sppsb=='4')
                                        JAMINAN PEMELIHARAAN
                                        @endif
                                        @if($sertifikat->jenis_sppsb=='5')
                                        JAMINAN PEMBAYARAN
                                        @endif
                                        @if($sertifikat->jenis_sppsb=='6')
                                        JAMINAN SANGGAH BANDING
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Nilai Jaminan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">Rp.<span class="numeric">{{ number_format($sertifikat->nilai_jaminan ,0,'.',',')}}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Jangka Waktu Proyek</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $direksi->tgl_indo($sertifikat->waktu_mulai)}} <strong>s/d</strong> {{ $direksi->tgl_indo($sertifikat->waktu_selesai) }} (<code>{{ $sertifikat->durasi }} Hari</code>)</p>
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
