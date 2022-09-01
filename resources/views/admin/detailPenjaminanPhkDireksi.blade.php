@extends('layout.admin')
@section('content')

<body>
    <form action="/post/validasi/konsumtif"  method="post" id="validation_form">
        <div class="container"> 
        <section class="col-lg-6" >
            <div class="panel panel-default" style="border-radius: 15px"   >
                <div class="panel-heading" style="background-color: #ffffff;  margin: 20px;border-radius: 7px 7px 7px 7px"  >
                 <h2><b>Detail Terjamin</b></h2> 
                     <h5>{{$penjaminan->namabank}}</h5>
                </div>
                <div style="margin: 10px" class="panel-body">
                         <div  class="box-body"> 
                            <!--<hr color="#ff0000">-->  
                            <div class="form-group">
                                <p>Nomor KTP <b style="color: red"> * </b></p> 
                                <input readonly="" minlength="16" required="" value="{{$penjaminan->ktp}}" class="form-control" id="ktp"   onkeypress="return  hanyaAngka(event, false)" name="ktp" placeholder="Nomor KTP"  maxlength="16" >
                                <input hidden="" required="" value="{{$penjaminan->idpenjaminan}}" class="form-control" id="idPenjaminan"   name="idpenjaminan" placeholder="Nomor KTP"  maxlength="16" >
                                <input hidden="" required="" value="{{$penjaminan->case}}" class="form-control" id="caseket"   name="caseket" placeholder="keterangan case by case"  maxlength="16" >
                                <input hidden="" required="" value="{{$penjaminan->statusbayar}}" class="form-control" id="statusbayar"   name="statusbayar" placeholder="keterangan status bayar"  maxlength="16" >
                            </div>
                            <div class="form-group">
                                <p>Nama Terjamin <b style="color: red">* </b></p>
                                <input  readonly=""  value="{{$penjaminan->nama}}" class="form-control" id="name" name="name" placeholder="Name" type="text" > 
                            </div>   
                            <div class="form-group">
                                <p>No Telepon | Hp <b style="color: red"> * </b></p>
                                <input  readonly=""  style="width: 50%" value="{{$penjaminan->phone}}"  required="" type="number" minlength="10" maxlength="15" class="form-control" id="phone" name="phone" placeholder="phone" type="text" >
                               
                            </div>   
                            <div class="form-group ">
                                <p>Alamat</p>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-home">
                                        </i>
                                    </div>
                                    <textarea  readonly=""   value="" id="alamat" required="" name="alamat"  type="text"  class="form-control" >{{$penjaminan->alamat}}</textarea> 
                                </div>
                                 <br> 
                            </div> 
                            
                               <div class="form-group "> 
                                    <table>
                                        <tr>
                                            <td style="width: 35%">Tempat Lahir</td>
                                            <td>Tgl Lahir</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="glyphicon glyphicon-map-marker">
                                                        </i>
                                                    </div>
                                                    <input   readonly="" required=""   value="{{$penjaminan->tempatlahir}}"   id="tempatlahir"  name="tempatlahir"  type="text" class="form-control" >
                                                </div>
                                                </td>
                                            <td> 
                                                <div style="margin:3px;"class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="glyphicon glyphicon-calendar">
                                                        </i>
                                                    </div>
                                                    <input   readonly=""  required="" value="{{date('d-m-Y',strtotime($penjaminan->tgllahir))}}"  name="tglLhr"  type="text" class="form-control" > 
                                                  
                                                </div>
                                                 </td>
                                        </tr>
                                    </table> 
                                </div> 
                            
                            <div class="form-group">
                                <p>Umur</p>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-hourglass">
                                        </i>
                                    </div>
                                    <input  readonly=""  value="{{$penjaminan->umur}}" disabled="" class="form-control"   type="text">  
                                   
                                </div>
                            </div>

                            <div class="form-group">
                                 <p>Pekerjaan<b style="color: red"> * </b></p> 
                                <div class="icheck-greensea icheck-inline">
                                    <input  {{ old('jenis_pekerjaan')=='KARYAWAN' ? "checked" : "" }} @if($penjaminan->jenis_pekerjaan=='KARYAWAN')  checked="" @else disabled=""  @endif  value="KARYAWAN" name="jenis_pekerjaan" required="" type="radio" id="radio-karyawan" />
                                    <label for="radio-karyawan">Karyawan</label> 
                                </div>
                                <div class="icheck-greensea icheck-inline">
                                    <input {{ old('jenis_pekerjaan')=='PENGUSAHA' ? "checked" : "" }}  @if($penjaminan->jenis_pekerjaan=='PENGUSAHA') checked="" @else disabled=""  @endif  value="PENGUSAHA" name="jenis_pekerjaan" required="" type="radio" id="radio-pengusaha" />
                                    <label for="radio-pengusaha">Pengusaha</label> 
                                </div>
                            </div>
                            <div class="form-group">
                                <p id="detailPekerjaan">Nama Perusahaan/Instansi<b style="color: red"> * </b></p>
                                <input  readonly=""  value="{{$penjaminan->nama_perusahaan}}" required="" minlength="3" class="form-control" name="pekerjaan" id="pekerjaan">
                            </div> 
                            <div class="form-group">
                                <p id="detailjabatan">Jabatan<b style="color: red"> * </b></p>
                                <input  readonly=""  value="{{$penjaminan->jabatan}}" required="" minlength="3" class="form-control" name="jabatan" id="jabatan">
                            </div> 
                            <div class="form-group">
                                <p id="masakerja">Masa Kerja<b style="color: red"> * </b></p>
                                <input  readonly=""  value="{{$penjaminan->masa_kerja}}" required="" minlength="3" class="form-control" name="masakerja" id="masakerja">
                            </div> 
                            <div class="form-group ">  
                                <label>Kode Registrasi</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-barcode">
                                        </i>
                                    </div>     
                                    <input  value="{{$penjaminan->nosertifikat}}" disabled="" id="kodepenjaminan"  type="text" class="form-control">
                                </div>
                            </div>
                            <label>Tanggal Registrasi</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time">
                                    </i>
                                </div> 
                                <input  readonly=""  disabled=""  value='{{date('d-m-Y',strtotime($penjaminan->tglpengajuan))}}' type="text" class="form-control">
                            </div>
                        </div>
                </div>
            </div>
        </section>  
        <section class="col-lg-6" >
            <div class="panel panel-default" style="border-radius: 15px"   >
                    <div class="panel-heading" style="background-color:#ffffff;  margin: 20px;border-radius: 15px 15px 0px 0px"  >
                    <h2><b>Detail Penjaminan</b></h2>
                     <h5>{{$penjaminan->namabank}}</h5>
                </div>
                <div style="margin:10px" class="panel-body">
                         <div class="box-body"> 
                    
                        <div class="form-group">
                            <p>Skema Kredit<b style="color: red"> * </b></p> 
                           <div class="icheck-greensea icheck-inline">
                               <input {{ old('kredit')=='KONSUMTIF' ? "checked" : "" }}  @if($penjaminan->jeniskredit=='KONSUMTIF') checked="" @else disabled="" @endif  value="KONSUMTIF" name="kredit" required="" type="radio" id="radio-konsumtif" />
                               <label for="radio-konsumtif">Konsumtif</label> 
                           </div>
                           <div class="icheck-greensea icheck-inline">
                               <input {{ old('kredit')=='PRODUKTIF' ? "checked" : "" }} @if($penjaminan->jeniskredit=='PRODUKTIF') checked="" @else disabled="" @endif  value="PRODUKTIF" name="kredit" required="" type="radio" id="radio-produktif" />
                               <label for="radio-produktif">Produktif</label> 
                           </div>
                       </div>
                       <div class="form-group">
                           <p id="detailPekerjaan">Tujuan Penggunaan Kredit<b style="color: red"> * </b></p>
                           <input readonly="" value="{{$penjaminan->penggunaan}}" required="" minlength="3" class="form-control" name="penggunaan" > 
                       </div>
                           
                        <div class="form-group">
                            <p id="labelNoPK">No. Perjanjian Kredit<b style="color: red"> * </b></p>
                            <input readonly="" value="{{$penjaminan->nopk}}" minlength="3" required="" class="form-control" id="nopk"  name="nopk" placeholder="Nomor PK"  maxlength="30" >
                        </div>

                        <div class="form-group "> 
                            <table>
                                <tr>
                                    <td style="width: 51%"> <p id="labelTglPK">Tanggal Perjanjian Kredit <b style="color: red"> * </b></p></td>
                                    <td>    <p>Tanggal Realisasi<b style="color: red"> * </b></p></td>
                                </tr>
                                <tr>
                                    <td> 
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-calendar">
                                                </i>
                                            </div>
                                            <input readonly="" value="{{date('d/m/Y',strtotime($penjaminan->tglpk))}}" required=""  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                                        </div>
                                        @if($errors->has('tglpk'))
                                        <p style="color: red"> {{ $errors->first('tglpk')}}</p>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="margin:5px" class="input-group">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-calendar">
                                                </i>
                                            </div>
                                           <input readonly="" value="{{date('d/m/Y',strtotime($penjaminan->tglrealisasi))}}" required=""  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                                        </div> 
                                    </td>
                                </tr>
                            </table> 
                        </div> 
                        <div class="form-group "> 
                            <table>
                                <tr>
                                    <td> <p>Masa Kredit [Bulan]</p></td>
                                    <td> <p>Tanggal Jatuh Tempo<b style="color: red"> * </b></p></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div style="margin-right:5px"  class="input-group">
                                            <input  readonly=""  value="{{$penjaminan->masakredit}}" onchange="hitungUmurJatuhTempo()" onkeypress="return  hanyaAngka(event, false)" required="" name="masakredit"  id="masaKredit" type="text" class="form-control" >
                                            <div style="width: 70%"class="input-group-addon">
                                                Bulan
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-calendar">
                                                </i>
                                            </div>
                                                <input readonly="" value="{{date('d/m/Y',strtotime($penjaminan->tgljatuhtempo))}}" required=""  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                                        </div>
                                       
                                    </td>
                                </tr>
                            </table>  
                        </div>
                        <div class="form-group">
                            <p>Umur Terjamin Saat Jatuh Tempo</p> 
                            <input value="{{$penjaminan->umurjatuhtempo}}"  required="" readonly=""  class="form-control"  id="umurjatuhtempo" >
                        </div> 
                       
                        <div class="form-group ">
                            <p>Plafon Kredit<b style="color: red"> * </b></p>
                            <div class="input-group">                                        
                                <div class="input-group-addon">
                                    Rp.
                                </div>
                                <input  readonly="" placeholder="100.000.000,-" value="{{number_format($penjaminan->plafon, 2, '.', ',')}}"  minlength="7" required="" id="plafon"   onchange="FormatCurrency(this)" class="form-control" name="plafon">
                             </div>
                        </div>
                        
                                   <div class="form-group ">
                            <p>IJP<b style="color: red"> * </b></p>
                            <div class="input-group">                                        
                                <div class="input-group-addon">
                                    Rp.
                                </div>
                                <input  readonly="" placeholder="100.000.000,-" value="{{number_format($penjaminan->nett, 2, '.', ',')}}"  minlength="7" required="" id="ijp"   onchange="FormatCurrency(this)" class="form-control" name="ijp">
                             </div>
                        </div>
                             
                        <div class="form-group">
                            <p>Jenis Penjaminan <b style="color: red"> *</b></p>         
                            <input readonly="" value="{{$penjaminan->jenispenjaminan}}" class="form-control" name="jenisPenjaminan"> 
                        </div>   
                        <div class="form-group">
                            <label>Pimpinan Cabang/Staff </label>                            
                            <input readonly="" value="{{$penjaminan->pemohon}}" class="form-control" name="pemohon">
                        </div>   
                             
                                    <p><b>Lampiran File</b></p>
                          <div class="panel panel-default" style="border-radius: 10px"   > 
                            <div style="margin: 15px">
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
                                             if ($penjaminan ->doc_surat_pernyataan_sehat=='No'){ $showDocSehat = "hide" ; }else {if($penjaminan -> files){$showDocSehat = "" ;}else{$showDocSehat = "hide" ;}}
                                             if ($penjaminan ->doc_surat_keterangan_sehat=='No'){ $showDocSehatrs = "hide" ; }else {if($penjaminan -> files3!=""){$showDocSehatrs = "" ;}else{$showDocSehatrs = "hide" ;}}
                                             if ($penjaminan ->doc_cek_lab=='No'){ $showDocLab= "hide" ; }else {if($penjaminan -> files2!=""){$showDocLab = "" ;}else{$showDocLab = "hide" ;}}
                                             if ($penjaminan ->doc_getaran_jantung=='No'){ $showDocJantung = "hide" ; }else {if($penjaminan -> getaran_jantung!=""){$showDocJantung = "" ;}else{$showDocJantung = "hide" ;}}
                                             if ($penjaminan ->doc_ktp=='No'){ $showktp = "hide" ; }else {if($penjaminan ->foto_ktp!=""){$showktp = "" ;}else{$showktp = "hide" ;}}
                                             if ($penjaminan ->doc_foto_usaha=='No'){ $showfotousaha = "hide" ; }else {if($penjaminan ->foto_usaha!=""){$showfotousaha = "" ;}else{$showfotousaha = "hide" ;}}
                                             if ($penjaminan ->doc_slik=='No'){ $showslik = "hide" ; }else {if($penjaminan ->hasil_slik!=""){$showslik = "" ;}else{$showslik = "hide" ;}}
                                             if ($penjaminan ->doc_analisa_kelayakan=='No'){ $showDocAnalisa= "hide" ; }else {if($penjaminan ->analisis_kelayakan!=""){$showDocAnalisa = "" ;}else{$showDocAnalisa = "hide" ;}}
                                             if ($penjaminan ->doc_taksasi=='No'){ $showDocTaksasi= "hide" ; }else {if($penjaminan ->doc_taksasi!=""){$showDocTaksasi = "" ;}else{$showDocTaksasi = "hide" ;}}
                                             if ($penjaminan ->doc_persetujuan_kredit=='No'){ $showDocPersetujuanKredit = "hide" ; }else {if($penjaminan ->surat_persetujuan_kredit!=""){$showDocPersetujuanKredit = "" ;}else{$showDocPersetujuanKredit = "hide" ;}}
                                             if ($penjaminan ->doc_riwayat_kredit=='No'){ $showDocRiwayatKredit = "hide" ; }else {if($penjaminan ->surat_riwayat_kredit!=""){$showDocRiwayatKredit = "" ;}else{$showDocRiwayatKredit = "hide" ;}} 
                                             if ($penjaminan ->doc_sk=='No'){ $showDocSk = "hide" ; }else {if($penjaminan ->sk_pengangkatan!=""){$showDocSk = "" ;}else{$showDocSk = "hide" ;}} 
                                             if($penjaminan->file!=""){$showbuktibayar="";}else{$showbuktibayar="hide";}
                                    @endphp
                                <table class="ftable">
                                        <tr class="{{$showDocSehat}}">  
                                            <td></td>
                                            <td style="width: 100%"><b>Surat Sehat </b></td>
                                            <td><a style="color:black; border-radius:6px; border-color: #cccccc"  class="btn" target="_BLANK"  href="@if($penjaminan->url_penjaminan!=null)<?php echo '/'. $penjaminan -> url_penjaminan.$penjaminan -> files?>@else files/suratsehat/{{$penjaminan ->files}} @endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <!--<td><a style="color:black; margin: 1px; border-radius:6px; border-color: #cccccc"  id="{{$penjaminan -> idpenjaminan}}"  class="btn uploadsuratsehat"  > <i class="glyphicon glyphicon-open"></i></a></td>--> 
                                        </tr>
                                        <tr class="{{$showDocSehatrs}}"> 
                                             <td></td>
                                            <td><b>Surat Sehat Dari RS</b></td>
                                            <td><a style="color:black;border-color: #cccccc"   class="btn " target="_BLANK" href="@if($penjaminan->url_penjaminan!=null)<?php echo '/'. $penjaminan -> url_penjaminan.$penjaminan -> files3 ?>@else files/suratsehatrs/{{$penjaminan ->files3}} @endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <!--<td><a  style="color:black; margin: 1px; border-color: #cccccc" id="{{$penjaminan -> idpenjaminan}}"  class="btn uploadsuratsehatRs"  > <i class="glyphicon glyphicon-open"></i></a></td>--> 
                                        </tr>
                                        <tr class="{{$showDocLab}}"> 
                                             <td></td>
                                            <td><b>Hasil Cek Lab</b></td>
                                            <td><a style="color:black;border-color: #cccccc"  class="btn" targettarget="_blank" href="@if($penjaminan->url_penjaminan!=null)<?php echo '/'. $penjaminan -> url_penjaminan.$penjaminan -> files2?>@else files/scanlab/{{$penjaminan->files2}} @endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <!--<td><a  style="color:black; margin: 1px;border-color: #cccccc"  id="{{$penjaminan -> idpenjaminan}}"  class="btn  uploadscanlab"  > <i class="glyphicon glyphicon-open"></i></a></td>--> 
                                        </tr>
                                        <tr class="{{$showDocJantung}}"> 
                                             <td></td>
                                            <td><b>Dokumen Getaran Jantung</b></td>
                                            <td><a style="color:black;border-color: #cccccc"  class="btn" targettarget="_blank" href="@if($penjaminan->url_penjaminan!=null)<?php echo'/'.  $penjaminan -> url_penjaminan.$penjaminan -> getaran_jantung?>@endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <!--<td><a  style="color:black; margin: 1px;border-color: #cccccc"  id="{{$penjaminan -> idpenjaminan}}"  class="btn  uploadGetaranJantung"  > <i class="glyphicon glyphicon-open"></i></a></td>--> 
                                        </tr>
                                        <tr class="{{$showktp}}"> 
                                             <td></td>
                                            <td><b>KTP Terjamin + Pasangan</b></td>
                                            <td><a style="color:black;border-color: #cccccc"  class="btn" targettarget="_blank" href="@if($penjaminan->url_penjaminan!=null)<?php echo '/'.  $penjaminan -> url_penjaminan.$penjaminan ->foto_ktp?>@endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <!--<td><a  style="color:black; margin: 1px;border-color: #cccccc"  id="{{$penjaminan -> idpenjaminan}}"  class="btn  uploadktp"  > <i class="glyphicon glyphicon-open"></i></a></td>--> 
                                        </tr>
                                        <tr class="{{$showfotousaha}}"> 
                                             <td></td>
                                            <td><b>Foto Usaha</b></td>
                                            <td><a style="color:black;border-color: #cccccc"  class="btn" targettarget="_blank" href="@if($penjaminan->url_penjaminan!=null)<?php echo '/'.  $penjaminan -> url_penjaminan.$penjaminan ->foto_usaha?> @endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <!--<td><a  style="color:black; margin: 1px;border-color: #cccccc"  id="{{$penjaminan -> idpenjaminan}}"  class="btn  uploadFotoUsaha"  > <i class="glyphicon glyphicon-open"></i></a></td>--> 
                                        </tr>
                                        <tr class="{{$showslik}}"> 
                                             <td></td>
                                            <td><b>Hasil SLIK</b></td>
                                            <td><a style="color:black;border-color: #cccccc"  class="btn" targettarget="_blank" href="@if($penjaminan->url_penjaminan!=null)<?php echo '/'.  $penjaminan -> url_penjaminan.$penjaminan ->hasil_slik?> @endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <!--<td><a  style="color:black; margin: 1px;border-color: #cccccc"  id="{{$penjaminan -> idpenjaminan}}"  class="btn  uploadHasilSlik"  > <i class="glyphicon glyphicon-open"></i></a></td>--> 
                                        </tr>
                                       <tr class="{{$showDocAnalisa}}"> 
                                             <td></td>
                                            <td><b>Analisis Kelayakan</b></td>
                                            <td><a style="color:black;border-color: #cccccc"  class="btn" targettarget="_blank" href="@if($penjaminan->url_penjaminan!=null)<?php echo '/'.  $penjaminan -> url_penjaminan.$penjaminan ->analisis_kelayakan?> @endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <!--<td><a  style="color:black; margin: 1px;border-color: #cccccc"  id="{{$penjaminan -> idpenjaminan}}"  class="btn  uploadAnalisis"  > <i class="glyphicon glyphicon-open"></i></a></td>--> 
                                        </tr> 
                                         <tr class="{{$showDocTaksasi}}"> 
                                             <td></td>
                                            <td><b>Hasil Taksasi Agunan</b></td>
                                            <td><a style="color:black;border-color: #cccccc"  class="btn" targettarget="_blank" href="@if($penjaminan->url_penjaminan!=null)<?php echo '/'. $penjaminan -> url_penjaminan.$penjaminan ->taksasi_agunan?> @endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <!--<td><a  style="color:black; margin: 1px;border-color: #cccccc"  id="{{$penjaminan -> idpenjaminan}}"  class="btn  uploadTaksasi"  > <i class="glyphicon glyphicon-open"></i></a></td>--> 
                                        <tr class="{{$showDocPersetujuanKredit}}">  
                                             <td></td>
                                            <td><b>Surat Persetujuan Kredit</b></td>
                                            <td><a style="color:black;border-color: #cccccc"  class="btn" target="_blank" href="@if($penjaminan->url_penjaminan!=null)<?php echo '/'.  $penjaminan -> url_penjaminan.$penjaminan ->surat_persetujuan_kredit?> @endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <!--<td><a  style="color:black; margin: 1px;border-color: #cccccc"  id="{{$penjaminan -> idpenjaminan}}"  class="btn  uploadPersetujuanKredit"  > <i class="glyphicon glyphicon-open"></i></a></td>--> 
                                        </tr>
                                        <tr class="{{$showDocRiwayatKredit}}">  
                                             <td></td>
                                            <td><b>Doc Riwayat Kredit</b></td>
                                            <td><a style="color:black;border-color: #cccccc"  class="btn" target="_blank" href="@if($penjaminan->url_penjaminan!=null)<?php echo '/'.  $penjaminan -> url_penjaminan.$penjaminan ->surat_riwayat_kredit?> @endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <!--<td><a  style="color:black; margin: 1px;border-color: #cccccc"  id="{{$penjaminan -> idpenjaminan}}"  class="btn  uploadRiwayatKredit"  > <i class="glyphicon glyphicon-open"></i></a></td>--> 
                                        </tr>
                                        <tr class="{{$showDocSk}}">  
                                             <td></td>
                                            <td><b>Doc SK Pengangkatan</b></td>
                                            <td><a style="color:black;border-color: #cccccc"  class="btn" target="_blank" href="@if($penjaminan->url_penjaminan!=null)<?php echo '/'.  $penjaminan -> url_penjaminan.$penjaminan ->sk_pengangkatan?> @endif"> <i class="glyphicon glyphicon-save"></i></a></td>
                                            <!--<td><a  style="color:black; margin: 1px;border-color: #cccccc"  id="{{$penjaminan -> idpenjaminan}}"  class="btn  uploadDocSk"  > <i class="glyphicon glyphicon-open"></i></a></td>--> 
                                        </tr>
                                        <tr> 
                                            <td></td>
                                            <td><b>Print  Pengajuan</b></td>
                                            <td><a  style="color:black; margin: 1px;border-color: #cccccc"class="btn"  target="_BLANK" href="/cetaksuratpengajuan/{{$penjaminan ->nosertifikat}}"> <i class="glyphicon glyphicon-print"></i></a></td>
                                            <td></td> 
                                        </tr>
                                          @if($penjaminan->statusbayar==1)
                                          <tr class="{{$showbuktibayar}}">
                                            <td></td>
                                            <td><b>Bukti Bayar </b></td>
                                             <td align="right"><a style="color:black; border-radius:6px; border-color: #cccccc"  class="btn" target="_BLANK"  href="
                                                                 
                                                                  @if($penjaminan->url_penjaminan!=null)
                                                                             @if($penjaminan->url_file_bayar!=null)
                                                                               <?php echo '/'.$penjaminan ->url_file_bayar.$penjaminan ->file?>
                                                                             @else
                                                                              <?php echo '/'.$penjaminan ->url_penjaminan.$penjaminan ->file?>
                                                                             @endif
                                                                        @else
                                                                               {{url('/files/buktibayar').'/'.$penjaminan->file}}
                                                                         @endif  
                                                                 "><i class="glyphicon glyphicon-save"></i></a>
                                            </td> 
                                            <td><a  style="color:black; margin: 1px;border-color: #cccccc"  id="{{$penjaminan -> idpenjaminan}}"  class="btn  uploadbuktibayar"  > <i class="glyphicon glyphicon-open"></i></a></td> 
                                        </tr>
                                        @endif
                                    </table>  
                            </div>   
                            </div>   
                                           
                                           
                            <div class="form-group"> 
                                <label>History Approval</label>                            
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Analisa</th>
                                            <th scope="col">Approval</th>
                                            <th scope="col">Tgl</th>
                                            <th scope="col">User</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i=1 @endphp
                                        @foreach($historyApproval as $data)
                                        <tr>
                                            <th scope="row">{{$i}}</th>
                                            <td>{{$data->analisa}}</td>
                                            <td>{{$data->approval}}</td>
                                            <td>{{$data->tgl_analisa}}</td>
                                            <td>{{$data->name}}</td>
                                        </tr>
                                        @php $i++ @endphp
                                        @endforeach
                                    </tbody>
                                </table> 
                            </div> 
                        </div>  
                        <br>  
                           @if($penjaminan->case=='Ya')
                         <div class="form-group">
                              <p>Suku Bunga Perbulan (%)</p>
                              <input readonly="" type="number" placeholder="1%"  value="{{old('sukuBunga',$penjaminan->suku_bunga)}}"  id="sukuBunga" name="sukuBunga" class="form-control">
                                   @if($errors->has('sukuBunga'))
                                  <p style="color: red"> {{ $errors-> first('sukuBunga')}}</p>
                                  @endif
                       </div>
                         <div class="form-group">
                              <p>Angsuran Perbulan (Rp.)</p>
                              <input readonly="" onkeyup="FormatCurrency(this)"  placeholder="100.000.000,-"  value="{{old('angsuran',format_number($penjaminan->angsuran))}}"  id="sukuBunga" name="angsuran" class="form-control">
                                   @if($errors->has('angsuran'))
                                  <p style="color: red"> {{ $errors-> first('angsuran')}}</p>
                                  @endif
                       </div>
                         <div class="form-group">
                            <p>Hasil Pengecekan Slik<b style="color: red"> * </b></p> 
                            <select name="pengecekanSlik" required="" class="form-control">
                                <option value="">Silihkan Pilih Hasil Pengecekan</option>
                                <option @if($penjaminan->pengecekan_slik=="kol1") selected="" @endif  @if(old('pengecekanSlik')=='kol1') selected="" @endif   value="kol1">Kredit Lancar (Kol 1)</option>
                                <option  @if($penjaminan->pengecekan_slik=="kol2") selected="" @endif  @if(old('pengecekanSlik')=='kol2') selected="" @endif  value="kol2">Kredit Dalam Perhatian Khusus (Kol 2)</option>
                                <option @if($penjaminan->pengecekan_slik=="kol3") selected="" @endif  @if(old('pengecekanSlik')=='kol3') selected="" @endif  value="kol3">Kredit Tidak Lancar (Kol 3)</option>
                                <option @if($penjaminan->pengecekan_slik=="kol4") selected="" @endif  @if(old('pengecekanSlik')=='kol4') selected="" @endif  value="kol4">Kredit Diragukan (Kol 4)</option>
                                <option @if($penjaminan->pengecekan_slik=="kol5") selected="" @endif  @if(old('pengecekanSlik')=='kol5') selected="" @endif  value="kol5">Kredit Macet (Kol 5)</option>
                            </select>
                           
                               @if($errors->has('pengecekanSlik'))
                                  <p style="color: red"> {{ $errors-> first('pengecekanSlik')}}</p>
                                  @endif
                       </div>
                        <div class="form-group">
                               <p><b>ANALISA PENDAPATAN DAN PENGELUARAN</b></p> 
                               <p><b>Pendapatan</b></p>
                               <hr>
                               <p>Pendapatan Pemohon</p>
                               <input readonly="" placeholder="100.000.000,-"  value="{{old('pendaptanPemohon',format_number($penjaminan->pendapatan_utama))}}"  onkeyup="FormatCurrency(this)"  id="pendapatanPemohon" name="pendapatanPemohon" class="form-control"> 
                   
                               @if($errors->has('pendapatanPemohon'))
                                  <p style="color: red"> {{ $errors-> first('pendapatanPemohon')}}</p>
                                  @endif
                               <p>Pendapatan Lainnya</p>
                               <input readonly=""  placeholder="100.000.000,-"  value="{{old('pendapatanLainnya',format_number($penjaminan->pendapatan_lainnya))}}"  onkeyup="FormatCurrency(this)"  id="pendapatanLainnya" name="pendapatanLainnya" class="form-control"> 
                               @if($errors->has('pendapatanPemohon'))
                                  <p style="color: red"> {{ $errors-> first('pendapatanPemohon')}}</p>
                                @endif 
                                 <p><b>Pengeluaran</b></p>
                               <hr>
                               <p>Total Biaya Rumah Tangga</p>
                               <input readonly=""  placeholder="100.000.000,-"   value="{{old('biayaRumahTangga',format_number($penjaminan->biaya_rumah_tangga))}}" onkeyup="FormatCurrency(this)"   id="biayaRumahTangga" name="biayaRumahTangga" class="form-control">
                                 @if($errors->has('biayaRumahTangga'))
                                  <p style="color: red"> {{ $errors-> first('biayaRumahTangga')}}</p>
                                  @endif 
                                 <p>Angsuran Kredit di Tempat Lain</p>
                                 <input readonly=""  placeholder="100.000.000,-"  onkeyup="FormatCurrency(this)"  value="{{old('angsuranKreditTempatLain',format_number($penjaminan->angsuran_lainnya))}}"    id="angsuranKreditTempatLain" name="angsuranKreditTempatLain" class="form-control">
                                   @if($errors->has('angsuranKreditTempatLain'))
                                  <p style="color: red"> {{ $errors-> first('angsuranKreditTempatLain')}}</p>
                                  @endif
                                  <p>Pendaptan Bersih  <b id="labaRugi"></b></p>
                                  <input  readonly="" style="color: #9b59b6" placeholder="100.000.000,-" value="{{old('pendaptanBersih',format_number($penjaminan->pendapatan_bersih))}}"    id="pendapatanBersih" name="pendapatanBersih" class="form-control">

                        </div>   
                            <div class="form-group">
                             
                                <p>Kapasitas Bayar<b style="color: red"> * </b></p> 
                                <div class="radio icheck-primary">
                                    <input  @if($penjaminan->kapasitas=="memenuhi") checked="" @endif    {{old('kapasitas')=='memenuhi' ? 'checked=""' : "" }}   placeholder="100.000.000,-"    id="memenuhi" class="radio" type="radio" name="kapasitas" value="memenuhi" /> 
                                    <label  for="memenuhi">Memenuhi</label>
                                </div>
                                <div class="radio icheck-primary">
                                    <input @if($penjaminan->kapasitas=="tidakMemenuhi") checked="" @endif  {{old('kapasitas')=='tidakMemenuhi' ? 'checked=""' : "" }}    id="tidakMemenuhi" class="radio" type="radio" name="kapasitas" value="tidakMemenuhi" /> 
                                    <label  for="tidakMemenuhi">Tidak Memenuhi</label>
                                </div> 
                                @if($errors->has('kapasitas'))
                                  <p style="color: red"> {{ $errors-> first('kapasitas')}}</p>
                                  @endif
                           </div>  
                           @endif
                          @if($penjaminan->case=='Ya' and $penjaminan->jeniskredit=='KONSUMTIF')
                           <div class="form-group">
                                <p><b>Catatan Kesehatan</b></p>
                                <textarea readonly="" required="" style="resize:none;width:100%;height:100px;"  name="analisaKesehatan" id="analisaKesehatan" class="form-control">{{old('analisaKesehatan',$penjaminan->analisa_kesehatan)}}</textarea>  
                                   @if($errors->has('analisaKesehatan'))
                                  <p style="color: red"> {{ $errors-> first('analisaKesehatan')}}</p>
                                  @endif 
                         </div> 
                         @endif
                            <div class="form-group">
                                <label>Analisa Staf Penjaminan</label>                            
                                <textarea readonly="" required="" style="resize:true;height:120px;" value="" name="hasilakhir" id="hasilakhir" class="form-control">{{old('hasilakhir',$penjaminan->hasil_akhir)}}</textarea>
                                @if($errors->has('hasilakhir'))
                                <p style="color: red"> {{ $errors-> first('hasilakhir')}}</p>
                                @endif
                            </div>  
                           <div class="form-group">
                                <label>Rekomendasi Kabag</label>                            
                                <textarea readonly="" required="" style="resize:true;height:120px;" value="" name="rekomendasiKabag" id="analisaKabag" class="form-control">{{old('rekomendasiKabag',$penjaminan->rekomendasi_kabag)}}</textarea>
                                @if($errors->has('rekomendasiKabag'))
                                <p style="color: red"> {{ $errors-> first('rekomendasiKabag')}}</p>
                                @endif
                            </div> 
                           <div class="form-group">
                                <label>Keputusan Direksi</label>                            
                                <textarea  required="" style="resize:true;height:120px;" value="" name="keputusanDireksi" id="keputusanDireksi" class="form-control">{{old('keputusanDireksi',$penjaminan->keputusan_direksi)}}</textarea>
                                @if($errors->has('keputusanDireksi'))
                                <p style="color: red"> {{ $errors-> first('keputusanDireksi')}}</p>
                                @endif
                            </div> 
                         <div class="form-group">
                         <p>Approval<b style="color: red"> * </b></p>  
                                     
                        <div class="icheck-greensea icheck-inline">
                            <input required="" {{old('approval')=='Setuju' ? 'checked=""' : "" }}   value="CaseSetuju"  name="approval" required="" type="radio" id="radio-setuju" />
                            <label for="radio-setuju">Setuju</label> 
                        </div>  
                            <div class="icheck-greensea icheck-inline">
                                 <input required="" {{old('approval')=='kabag' ? 'checked=""' : "" }}   value="kabag"  name="approval" required="" type="radio" id="radio-kabag" />
                                 <label for="radio-kabag">Kembalikan ke Kabag</label> 
                             </div>
<!--                                        <div class="icheck-warning icheck-inline"> 
                              <input  required=""  {{old('approval')=='AnalisPenjaminan' ? 'checked=""' : ""  }}  value="AnalisPenjaminan"  name="approval" required="" type="radio" id="radio-analis" />
                              <label for="radio-analis">Kembalikan Ke Staf</label> 
                          </div>-->

                             @if($errors->has('approval'))
                                <p style="color: red"> {{ $errors-> first('approval')}}</p>
                            @endif
                       </div>
                        
<!--                        <a   class="btn btn-danger tolak"><i class="glyphicon glyphicon-stop"></i> Tolak</a>
                        <a   class="btn btn-warning revisi"><i class="glyphicon glyphicon-repeat"></i> Revisi</a>-->
                        <a   class="btn btn-success prosesValidasi"><i class="glyphicon glyphicon-check"></i> Proses</a>
                        {{csrf_field()}}
                    </div>
                </div>
            </div>
    </form>
  
    @include('user.modalKonfirmasi')
</body>
 
@endsection





