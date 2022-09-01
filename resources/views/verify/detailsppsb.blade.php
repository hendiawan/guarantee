<?php
use Carbon\Carbon;

?>
@extends('layouts.verify')

@section('content')
<div id="main" class="clearfix">
    <div class="topTabs">

        <div id="topTabs-container-home">
            <div class="topTabs-header clearfix">
                <div class="secInfo">
                    <h1 class="secTitle">Detail Penjaminan Surety Bond</h1>
                    <span class="secExtra">Nomor Sertifikat <strong>{{ $sppsb->no_jaminan }}</strong></span>
                 <span class="secExtra">Nilai Jaminan <strong>Rp.<span class="numeric">{{ $sppsb->nilai_jaminan }}</span></strong></span>
                 
                </div> <!-- /SecInfo -->

                <ul class="etabs tabs">
                    <li class="tab">
                        <a href="#tab1">
                            <span class="to-hide">
                                <i class="fa fa-newspaper-o"></i><br>Data SPPSB
                            </span>
                            <i class="fa icon-hidden fa-newspaper-o ttip" data-ttip="Data"></i>
                        </a>
                    </li>
                    
                </ul> <!-- /tabs -->
            </div><!-- /topTabs-header -->

            <div class="topTabsContent" style="padding-left:0;">
                @if(Session::has('msgupdate'))
                <div class="widget-content pad20">
                    <div class="alert alert-info">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="fa fa-info-circle"></i> {{ Session::get('msgupdate') }}
                    </div>
                </div>
                @endif
                @if($sppsb->status=='R')
                <div class="widget-content pad20">
                    <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="fa fa-warning"></i> CATATAN REVISI:</h4> {{ $history->remark }}
                    </div>
                </div>
                @endif
                @if($sppsb->status=='T')
                <div class="widget-content pad20">
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="fa fa-warning"></i> ALASAN PENOLAKAN:</h4> {{ $history->remark }}
                    </div>
                </div>
                @endif	
                <div id="tab1">					
                    <form id="sppsbForm" class="form-horizontal" action="{{ url('/sppsb-update') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $sppsb->id }}">		
                        <input type="hidden" name="no_registrasi" value="{{$sppsb->no_registrasi}}">	
                        <div class="widget-header">
                            <h3 class="widget-title">I. IDENTIFIKASI KONTRAKTOR (TERJAMIN)</h3>
                        </div>
                        <div class="widget-content pad20f">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Nama Kontraktor</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->nama_kontraktor }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Alamat Kontraktor</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->alamat_kontraktor }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Bidang Usaha</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->bidang_usaha }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Nama Direksi</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->direksi }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Jabatan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->jabatan_direksi }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Dokumen Pendukung</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">
                                        @foreach($dokPendukung as $dok)
                                        - {{ $dok }}<br/>
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>	
                        <div class="divider"></div>		
                        <div class="widget-header">
                            <h3 class="widget-title">II. IDENTIFIKASI PROYEK (PENERIMA JAMINAN)</h3>
                        </div>
                        <div class="widget-content pad20f">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Pemilik Proyek</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->pemilik_proyek }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Nama Pejabat</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->nama_pejabat }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Jabatan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->jabatan_pejabat }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Alamat</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->alamat }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Jenis Pekerjaan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->jenis_pekerjaan }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Jenis Dokumen</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->nama_dokumen }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>No Dokumen</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->no_dokumen }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Tanggal Dokumen</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ tgl_indo($sppsb->tgl_dokumen) }}</p>
                                </div>
                            </div>
                            @if ($sppsb->jenis_sppsb=='2')
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Uang Muka</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->fasilitas }}</p>
                                </div>
                            </div>
                            @if ($sppsb->fasilitas=='Ada Uang Muka')
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Persentase Uang Muka</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->persentase }}%</p>
                                </div>
                            </div>
                            @endif
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Termin</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->pembayaran }}</p>
                                </div>
                            </div>
                            @if ($sppsb->pembayaran=='Ada Termin')
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Jumlah Termin</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->jml_termin }}</p>
                                </div>
                            </div>
                            @endif
                            @endif
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Sumber Dana</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->sumber_dana }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Nilai Proyek</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">Rp.<span class="numeric">{{ $sppsb->nilai_proyek }}</span> (<code>{{ $nilaiProyek }} Rupiah</code>)</p>
                                </div>
                            </div>
                        </div>	
                        <div class="divider"></div>		
                        <div id="questions" class="widget-header">
                            <h3 class="widget-title">III. URAIAN PENJAMINAN</h3>
                        </div>
                        <div class="widget-content pad20f">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Janis Penjaminan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">
                                        @if($sppsb->jenis_sppsb=='1')
                                        JAMINAN PENAWARAN
                                        @endif
                                        @if($sppsb->jenis_sppsb=='2')
                                        JAMINAN PELAKSANAAN
                                        @endif
                                        @if($sppsb->jenis_sppsb=='3')
                                        JAMINAN UANG MUKA
                                        @endif
                                        @if($sppsb->jenis_sppsb=='4')
                                        JAMINAN PEMELIHARAAN
                                        @endif
                                        @if($sppsb->jenis_sppsb=='5')
                                        JAMINAN PEMBAYARAN
                                        @endif
                                        @if($sppsb->jenis_sppsb=='6')
                                        JAMINAN SANGGAH BANDING
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Nilai Jaminan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">Rp.<span class="numeric">{{ $sppsb->nilai_jaminan }}</span> (<code>{{ $nilaiJaminan }} Rupiah</code>)</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Jangka Waktu Proyek</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ tgl_indo($sppsb->waktu_mulai) }} <strong>s/d</strong> {{ tgl_indo($sppsb->waktu_selesai) }} (<code>{{ $sppsb->durasi }} Hari</code>)</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Rate IJP Proyek</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $rate }}%</p>
                                </div>
                            </div><div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Admin</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">Rp. <span class="numeric">{{ $feeAdmin }}</span> (<code>{{ucwords(terbilang($feeAdmin))}} Rupiah</code>)</p>
                                </div>
                            </div><div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Materai</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">Rp. <span class="numeric">{{ $materai }}</span> (<code>{{ucwords(terbilang($materai))}} Rupiah</code>)</p>
                                </div>
                            </div><div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Gross IJP</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">Rp. <span class="numeric">{{ $grossIjp }}</span> (<code>{{ucwords(terbilang($grossIjp))}} Rupiah</code>)</p>
                                </div>
                            </div><div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Total IJP</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">Rp. <span class="numeric">{{ $charge }}</span> (<code>{{ucwords(terbilang($charge))}} Rupiah</code>)</p>
                                </div>
                            </div><div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Rate Fee Agen</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $fee }}%</p>
                                </div>
                            </div><div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Fee Agen</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">Rp. <span class="numeric">{{ $feeAgen }}</span> (<code>{{ucwords(terbilang($feeAgen))}} Rupiah</code>)</p>
                                </div>
                            </div><div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Net IJP</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">Rp. <span class="numeric">{{ $charge-$feeAgen }}</span> (<code>{{ucwords(terbilang($charge-$feeAgen ))}} Rupiah</code>)</p>
                                </div>
                            </div>
                            @foreach($brgAgunan as $brg)
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Janis Agunan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $brg->type }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>No Dokumen Agunan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $brg->no }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Nama Pemilik</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $brg->nama }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Taksiran</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $brg->taksiran }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>	
                        
                        <hr/>
                        <div class="widget-content pad20f">		
                            @if(Auth::check())
                            @can('staff-access')
                            @if ($sppsb->status =='B' || $sppsb->status =='R')	
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <span class="custom-input">
                                        <input type="checkbox" id="checkRemark"><label for="checkRemark"> Form SPPSB Layak di proses</label>
                                    </span>
                                </div>
                            </div>						
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">

                                    <input id="sppsb_status" type="hidden" name="status" value="">
                                    <button id="proses" type="button" class="btn"><i class="fa fa-check"></i> PROSES</button>
                                    <a id="edit" href="{{ url('/sppsb-edit') }}/{{ $sppsb->id }}" class="btn btn-blue"><i class="fa fa-edit"></i> EDIT</a>
                                    <button id="revisi" type="button" class="btn btn-yellow"><i class="fa fa-edit"></i> REVISI</button>
                                    <button id="tolak" type="button" class="btn btn-red"><i class="fa fa-hand-stop-o"></i> TOLAK</button>
                                </div>
                            </div>

                            <!-- MODAL CHECK ALERT -->
                            <div class="modal fade remark-modal-md" role="dialog" aria-labelledby="mySmallModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="panel-title" id="gridSystemModalLabel"><i class="fa fa-edit"></i> Catatan</h4>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <textarea id="remark" class="form-control" name="remark" required></textarea>
                                                    <span class="help-block"><small>silahkan inputkan alasan penolakan/revisi dari SPPSB yang di maksud</small></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-footer text-center">
                                            <button type="button" class="btn btn-grey" data-dismiss="modal"><i class="fa fa-close"></i> Keluar</button>
                                            <button id="prosesRevisiTolak" type="submit" class="btn btn-blue"><i class="fa fa-save"></i> Proses</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endif 
                            @endcan
                            @can('agen-access')
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <a id="back" href="{{ url('/sppsb-sp3kbg-data-table') }}" class="btn btn-dark-grey"><i class="fa fa-undo"></i> KEMBALI</a>
                                    <a id="print" href="{{ url('/cetak-detail-sppsb') }}/{{ $sppsb->id }}" class="btn btn-lavender" target="blank"><i class="fa fa-print"></i> PRINT</a>
                                </div>
                                @if ($sppsb->status =='D' || $sppsb->status =='R')
                                <div class="col-sm-6 text-right">
                                    <a id="edit" href="{{ url('/sppsb-edit') }}/{{ $sppsb->id }}" class="btn btn-blue"><i class="fa fa-edit"></i> EDIT</a>
                                    <button id="kirim" type="button" class="btn btn-green" data-toggle="modal" data-target=".confirm-modal-sm"><i class="fa fa-upload"></i> KIRIM KE STAFF SURETY BOND</button>
                                </div>
                                @endif
                            </div>

                            @if ($sppsb->status =='D' || $sppsb->status =='R')
                            <!-- MODAL LOGOUT -->
                            <div class="modal fade confirm-modal-sm" role="dialog" aria-labelledby="mySmallModalLabel">
                                <div class="modal-dialog modal-sm" role="document">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="panel-title" id="gridSystemModalLabel"><i class="fa fa-question-circle"></i> Konfirmasi</h4>
                                        </div>
                                        <div class="panel-body">
                                            Apakah anda yakin data yang akan anda serahkan kepada staff surety bond sudah sesuai dan lengkap?
                                        </div>
                                        <div class="panel-footer">
                                            <input type="hidden" name="status" value="B">
                                            <button type="button" class="btn btn-grey" data-dismiss="modal"><i class="fa fa-close"></i> Tidak</button>
                                            <button id="proses" type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Ya</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endcan
                            @endif 
                        </div>    
                    </form>					                    	
                </div>
                <div id="tab2">
                    <div class="widget-content pad20f">	
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
