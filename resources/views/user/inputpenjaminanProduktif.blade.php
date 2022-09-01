@extends('layout.user')

@section('content')
<?php

use App\banks;

$kode = $kode + 1;
?>
<body>
    <br>
    <div class="container">
        
        <section  class="col-lg-12" >
              <div class="panel panel-default">
            <div class="panel-heading">
                <strong><i class="glyphicon glyphicon-alert"></i> Syarat dan kententuan pengajuan penjaminan</strong>
            </div>
            <div class="panel-body">             
                <b style="color: red">-Silahkan isi form yang ditandai(*)</b><br>
                <b style="color: red">-Data yang diberikan merupakan data sebenarnya(*)</b><br>
                <b style="color: red">-Apabila dikemudian hari ada perubahan data, silahkan hubungi PT.Jamkrida NTB Bersaing</b><br>
            </div>
            </div>
        </section> 
        
        <section  class="col-lg-12" >
            <div class="panel panel-default">
            <div class="panel-body">             
                <b style="color: black">KEPADA YTH.</b><br>
                <b style="color: black">DIREKTUR UTAMA PT. JAMKRIDA NTB BERSAING</b><br>
                <b style="color: black">DI TEMPAT. </b><br>
                <b style="color: black"></b><br>
                <b style="color: black">HAL : PERMOHONAN PENJAMINAN.</b><br>
                <br>
                <br> 
                <p style="color: black">
                    Dengan Hormat,<br>
                    Dengan ini kami mengajukan permohonan penjaminan kredit atas nama terjamin sesuai data berikut :
                </p>
            </div>
        </div>
        </section>
        
         <form action="/simpanPenjaminanProduktif" method="post"  id="formPenjaminan"  enctype="multipart/form-data" >
        <section class="col-lg-6" >
            <div class="panel panel-default" style="border-radius: 15px"   >
                <div class="panel-heading" style="background-color: #ffffff;  margin: 20px;border-radius: 7px 7px 7px 7px"  >
                 <h2><b>Form Terjamin</b></h2>
                     <h5>Untuk mengisi detail data terjamin</h5>
                </div>
                <div style="margin: 10px" class="panel-body">
                         <div  class="box-body">  
                            <div class="form-group">
                                <p>Nomor KTP <b style="color: red"> * </b></p>
                                <input minlength="16" required="" value="{{old('ktp')}}" class="form-control" id="ktp"   onkeypress="return  hanyaAngka(event, false)" name="ktp" placeholder="Nomor KTP"  maxlength="16" >
                                @if($errors->has('ktp'))
                                <p style="color: red"> {{ $errors-> first('ktp')}}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <p>Nama Terjamin <b style="color: red">* </b></p>
                                <input value="{{old('name')}}" class="form-control" id="name" name="name" placeholder="Name" type="text" >
                                @if($errors->has('name'))
                                <p style="color: red"> {{ $errors-> first('name')}}</p>
                                @endif
                            </div>   
                            <div class="form-group">
                                <p>No Telepon | Hp <b style="color: red"> * </b></p>
                                <input style="width: 50%" value="{{old('phone')}}"  required="" type="number" minlength="10" maxlength="15" class="form-control" id="phone" name="phone" placeholder="phone" type="text" >
                                @if($errors->has('phone'))
                                <p style="color: red"> {{ $errors-> first('phone')}}</p>
                                @endif
                            </div>   
                            <div class="form-group ">
                                <p>Alamat<b style="color: red">  isi sesuai KTP !* </b></p>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-home">
                                        </i>
                                    </div>
                                    <textarea  value="{{old('alamat')}}" id="alamat" required="" name="alamat"  type="text"  class="form-control" >{{old('alamat')}}</textarea> 
                                </div>
                                 <br>
                                <table id="DetailAlamat">
                                    <tr >
                                        <td>Desa/Kelurahan</td>
                                        <td>Kecamatan</td>
                                        <td>Kabupaten/Kota</td>
                                    </tr>
                                    <tr >
                                        <td><input  placeholder="Desa" style="width: 98%" value="{{old('desa')}}" required="" id="desa" name="desa" class="form-control"></td>  
                                        <td><input placeholder="Kecamatan"style="width: 98%" value="{{old('kecamatan')}}" required="" id="kecamatan" name="kecamatan" class="form-control"></td>
                                        <td><input placeholder="Kabupaten"  value="{{old('kabupaten')}}" required="" id="kabupaten" name="kabupaten" class="form-control"></td>
                                    </tr> 
                                </table>
                                @if($errors->has('alamat'))
                                <p style="color: red"> {{ $errors->first('alamat')}}</p>
                                @endif
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
                                                    <input required=""   value="{{old('tempatlahir')}}"   id="tempatlahir"  name="tempatlahir"  type="text" class="form-control" >
                                                </div>
                                                </td>
                                            <td> 
                                                <div style="margin:3px;"class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="glyphicon glyphicon-calendar">
                                                        </i>
                                                    </div>
                                                    <input  required="" value="{{old('tglLhr')}}"  onchange="hitungUmur()" id="tglLahir"  name="tglLhr"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask=""> 
                                                    <p id="errortgllahir"></p>
                                                    @if($errors->has('tglLhr'))
                                                    <p style="color: red"> {{ $errors->first('tglLhr')}}</p>
                                                    @endif
                                                </div>
                                                 </td>
                                        </tr>
                                    </table> 
                                </div> 
                            <div class="form-group">        
                                <input hidden="" value="baru" name="jenispengajuan"  id="jenispengajuan"   type="text" > 
                                @if (Session::has('jenisbank'))
                                <input hidden="" id="jenisbank" required="" value="{{Session::get('jenisbank') }}" class="form-control" id="kodepusat"    name="jenisbank" >                                  
                                @endif

                                @if (Session::has('kodepusat'))
                                <input hidden="" required="" value="{{Session::get('kodepusat') }}" class="form-control" id="kodepusat"    name="kodepusat" >                                  
                                @endif

                                @if (Session::has('idbank'))
                                <input hidden="" required="" value="{{Session::get('idbank') }}" class="form-control" id="idbank"    name="idbank" placeholder="ID Bank"  maxlength="16" >                                  
                                @endif
                            </div>
                            <div class="form-group">
                                <p>Umur</p>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-hourglass">
                                        </i>
                                    </div>
                                    <input required="" value="{{old('umur')}}" disabled="" class="form-control"  id="tampil1"  type="text">  
                                    <input hidden="" value="{{old('umur')}}"  name="umur"  id="tampil"  type="text">  
                                </div>
                            </div>

                            <div class="form-group">
                                 <p>Pekerjaan<b style="color: red"> * </b></p> 
                                <div class="icheck-greensea icheck-inline">
                                    <input disabled="" {{ old('jenis_pekerjaan')=='KARYAWAN' ? "checked" : "" }}   value="KARYAWAN" name="jenis_pekerjaan" required="" type="radio" id="radio-karyawan" />
                                    <label for="radio-karyawan">Karyawan</label> 
                                </div>
                                <div class="icheck-greensea icheck-inline">
                                    <input checked="" {{ old('jenis_pekerjaan')=='PENGUSAHA' ? "checked" : "" }}  value="PENGUSAHA" name="jenis_pekerjaan" required="" type="radio" id="radio-pengusaha" />
                                    <label for="radio-pengusaha">Pengusaha</label> 
                                </div>
                            </div>
                            <div class="form-group">
                                <p id="detailPekerjaan">Jenis Usaha<b style="color: red"> * </b></p>
                                <input placeholder="Contoh : Berjualan sembako dipasar, Ternak Sapi ,dll" value="{{old('pekerjaan')}}" required="" minlength="3" class="form-control" name="pekerjaan" id="pekerjaan">
                                @if($errors->has('pekerjaan'))
                                <p style="color: red"> {{ $errors->first('pekerjaan')}}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <p >Lama Usaha Berjalan<b style="color: red"> * </b></p>
                                <input placeholder="Menjelaskan usaha yang dimiliki sudah berjalan berapa lama" value="{{old('lama_usaha')}}" required="" minlength="3" class="form-control" name="lama_usaha" id="lama_usaha">
                                @if($errors->has('lama_usaha'))
                                <p style="color: red"> {{ $errors->first('lama_usaha')}}</p>
                                @endif
                            </div>
                            @if(session::get('level')=='Bntb')
                            <div class="form-group">
                                <label>NPWP<b style="color: red">( * )</b></label>
                                <input required="" value="{{old('npwp')}}" class="form-control" id="npwp"    name="npwp" placeholder="Nomor Pajak Wajib Pajak"  maxlength="25" data-inputmask="'alias': '00.000.000.0-000.000'" data-mask="" >
                                @if($errors->has('ktp'))
                                <p style="color: red"> {{ $errors-> first('npwp')}}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>SIUP<b style="color: red">( * )</b></label>
                                <input required="" value="{{old('siup')}}" class="form-control" id="siup"    name="siup" placeholder="SIUP"  maxlength="16" >
                                @if($errors->has('siup'))
                                <p style="color: red"> {{ $errors-> first('siup')}}</p>
                                @endif
                            </div>                    
                            @endif
                            <div class="form-group ">  
                                <label>Kode Registrasi</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-barcode">
                                        </i>
                                    </div>                                
                                    <input hidden="" value="{{'RGJNBSYS'.session::get('idbank').date('Ymdhis').$kode}}" name="kodepenjaminan"     type="text" >
                                    <input value="{{'RGJNBSYS'.session::get('idbank').date('Ymdhis').$kode}}" disabled="" id="kodepenjaminan"  type="text" class="form-control">
                                </div>
                            </div>
                            <label>Tanggal Registrasi</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time">
                                    </i>
                                </div>
                                <?php
                                date_default_timezone_set('Asia/Jakarta');
                                $pengajuan = date('d/m/Y');
                                ?>

                                <input hidden="" name="tglPengajuan" value='<?php echo $pengajuan ?>' type="text">
                                <input disabled=""  value='<?php echo $pengajuan ?>' type="text" class="form-control">
                            </div>
                        </div>
                </div>
            </div>
        </section> 
            
          <section class="col-lg-6" >
            <div class="panel panel-default" style="border-radius: 15px"   >
                    <div class="panel-heading" style="background-color:#ffffff;  margin: 20px;border-radius: 15px 15px 0px 0px"  >
                    <h2><b>Form Penjaminan</b></h2>
                     <h5>Untuk mengisi detail data penjaminan</h5>
                </div>
                <div style="margin:10px" class="panel-body">
                         <div class="box-body"> 
                        <div hidden="" id="SertifikatLama" class="form-group">
                            <label>Nomor Sertifikat Lama<b style="color: red">( * )</b></label>
                            <input hidden="" id="nosertifikat1"  name="nosertifikatlama">
                            <input disabled="" required="" class="form-control" id="nosertifikat"  placeholder="Nomor Sertifikat"  maxlength="30" >
                        </div>  
                        <div class="form-group">
                            <p>Skim Kredit<b style="color: red"> * </b></p> 
                           <div class="icheck-greensea icheck-inline">
                               <input disabled="" {{ old('kredit')=='KONSUMTIF' ? "checked" : "" }}   value="KONSUMTIF" name="kredit" required="" type="radio" id="radio-konsumtif" />
                               <label for="radio-konsumtif">Multiguna</label> 
                           </div>
                           <div class="icheck-greensea icheck-inline">
                               <input checked="" {{ old('kredit')=='PRODUKTIF' ? "checked" : "" }}  value="PRODUKTIF" name="kredit" required="" type="radio" id="radio-produktif" />
                               <label for="radio-produktif">Produktif</label> 
                           </div>
                       </div>
                             <div class="form-group ">
                            <p>Plafon Kredit<b style="color: red"> * </b></p>
                            <div class="input-group">                                        
                                <div class="input-group-addon">
                                    Rp.
                                </div>
                                <input placeholder="100.000.000,-" value="{{old('plafon')}}"  minlength="7" onchange="CekCase(this)" required="" id="plafon"  onkeyup="FormatCurrency(this)" class="form-control" name="plafon">
                             
                                @if($errors->has('plafon'))
                                <p style="color: red"> {{ $errors->first('plafon')}}</p>
                                @endif 
                            </div>
                               <p style="color: red" ><span id="msg_case"></span></p>
                               <input value="{{old('caseket')}}" hidden="" id="caseket"  class="form-control" name="caseket">
                            <div id="pesanPlafon"></div>
                        </div>
                       <div class="form-group">
                           <p id="detailPekerjaan">Tujuan Penggunaan Kredit<b style="color: red"> * </b></p>
                           <input placeholder="Silahkan deskripsikan alasan pengambilan kredit !" value="{{old('penggunaan')}}" required="" minlength="3" class="form-control" name="penggunaan" id="penggunaan">
                           @if($errors->has('penggunaan'))
                           <p style="color: red"> {{ $errors->first('penggunaan')}}</p>
                           @endif
                       </div>
                       
                        <div hidden="" id="PKLama" class="form-group">
                            <label> Nomor PK Lama<b style="color: red">( * )</b></label>
                            <input  hidden=""  class="form-control" id="pklamaHide"   name="pklama" placeholder="Nomor PK Lama"  maxlength="25" >  
                            <input  disabled=""  class="form-control" id="pklamaShow"    placeholder="Nomor PK Lama"  maxlength="25" >  
                        </div>
                       <div class="form-group" id="inputPK">
                            <p id="labelNoPK">No. Perjanjian Kredit<b style="color: red"> * </b></p>
                            <input value="{{old('nopk')}}" minlength="3" required="" class="form-control" id="nopk"  name="nopk" placeholder="Nomor PK"  maxlength="30" >
                            @if($errors->has('nopk'))
                            <p style="color: red"> {{ $errors->first('nopk')}}</p>
                            @endif
                        </div>

                        <div class="form-group " id="inputRealisasi"> 
                            <table>
                                <tr>
                                    <!--<td style="width: 51%"> <p id="labelTglPK">Tanggal Perjanjian Kredit <b style="color: red"> * </b></p></td>-->
                                    <td>    <p>Tanggal Realisasi<b style="color: red"> * </b></p></td>
                                </tr>
                                <tr>
<!--                                    <td> 
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-calendar">
                                                </i>
                                            </div>
                                            <input  value="{{old('tglpk')}}" required="" id="tglpk" name="tglpk"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">

                                        </div>
                                        @if($errors->has('tglpk'))
                                        <p style="color: red"> {{ $errors->first('tglpk')}}</p>
                                        @endif
                                    </td>-->
                                    <td>
                                        <div style="margin:5px" class="input-group " >
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-calendar">
                                                </i>
                                            </div>
                                            <input value="{{old('tglrealisasi',date('d-m-Y'))}}" required=""  id="tglrealisasi" name="tglrealisasi"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                                        </div>
                                        @if($errors->has('tglrealisasi'))
                                        <p style="color: red"> {{ $errors->first('tglrealisasi')}}</p>
                                        @endif
                                        <div id="msg_lebih"></div>
                                        <div id="msg_realisasi"></div> 
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
                                            <input   value="{{old('masakredit')}}" onchange="HitungUmurJatuhTempoFix()" onkeypress="return  hanyaAngka(event, false)" required="" name="masakredit"  id="masaKredit" type="text" class="form-control" >
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
                                            <input required=""  hidden="" value="{{old('tgljatuhtempo')}}" name="tgljatuhtempo"  id="tgljatuhtempo1" type="text" >
                                            <input required="" disabled=""  value="{{old('tgljatuhtempo')}}" class="form-control" maxlength="3"  id="tgljatuhtempo" type="text" >

                                        </div>
                                       
                                    </td>
                                </tr>
                            </table> 
                                          <p id="errorjatuhtempo"></p> 
                                        @if($errors->has('tgljatuhtempo'))
                                        <p style="color: red"> {{ $errors->first('tgljatuhtempo')}}</p>
                                        @endif
                        </div>
                                                      

                        <div class="form-group">
                            <p>Umur Terjamin Saat Jatuh Tempo</p>
                            <input  value="{{old('umurjatuhtempo')}}"  name="umurjatuhtempo" hidden="" class="form-control"  id="umurjatuhtempo1" >
                            <input value="{{old('umurjatuhtempo')}}"  required="" disabled=""  class="form-control"  id="umurjatuhtempo" >
                        </div>
                        <div id="pesanUmurJtauhTempo"></div>
                        @if(Session::get('kodepusat')=='5'||Session::get('kodepusat')=='57')
                        <div class="form-group ">
                            <label>Jenis Pengajuan Grace Periode ?</label><br>
                            <div class="radio icheck-primary">
                                <input id="JenisGracePeriodeYa" class="radio" type="radio" name="jnsGracePeriode" value="ya" /> 
                                <label for="JenisGracePeriodeYa">Ya</label>
                            </div>  
                            <div class="radio icheck-primary">
                                <input  checked="" id="JenisGracePeriodeTidak" class="radio" type="radio" name="jnsGracePeriode" value="tidak" />
                                <label for="JenisGracePeriodeTidak">Tidak</label>
                            </div> 
                        </div>

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

                        @endif
                         
                
                           <div class="form-group">
                            <p>Jenis Penjaminan<b style="color: red"> * </b></p> 
                           <div class="icheck-greensea icheck-inline">
                               <input class="detailSkimKredit"  {{ old('detailSkim')=='MACET' ? "checked" : "" }}   value="MACET" name="detailSkim" required="" type="radio" id="radio-macet" />
                               <label for="radio-macet">Macet</label> 
                           </div>
                           <div class="icheck-danger icheck-inline">
                               <input class="detailSkimKredit"  {{ old('detailSkim')=='JIWA' ? "checked" : "" }}  value="JIWA" name="detailSkim" required="" type="radio" id="radio-jiwa" />
                               <label for="radio-jiwa">Meninggal</label> 
                           </div>
                       </div>
                        
                        <div class="form-group">
                            <p>Detail Jenis Penjaminan <b style="color: red"> *</b></p>                            
                            <div id="Jenispilihan"></div>
                            <select required=""   id="JenisPnj" name="jenisPenjaminan" class="form-control">
                                <option value="">Pilih Detail Penjaminan</option>
                                <option  {{ old('jenisPenjaminan') ? "selected" : "" }} value="{{old('jenisPenjaminan')}}">{{old('jenisPenjaminan')}}</option>
                            </select>

                            @if($errors->has('jenisPenjaminan'))
                            <p style="color: red"> {{ $errors->first('jenisPenjaminan')}}</p>
                            @endif
                        </div>   
                        <div class="form-group hidden">
                           <p>Nilai Taksasi<b style="color: red"> * </b></p>
                           <input value="0" required=""   onkeyup="FormatCurrency(this)"  minlength="3" class="form-control" name="nilai_taksasi" id="nilai_taksasi">
                           @if($errors->has('penggunaan'))
                           <p style="color: red"> {{ $errors->first('nilai_taksasi')}}</p>
                           @endif
                       </div>
                             
                        <!--<div class="form-group">
                            <label>Jenis Penjaminan <b style="color: red">( * )</b></label>                            
                            <div id="Jenispilihan"></div>
                            <select required=""   id="JenisPnj"  class="form-control">
                                <option value="">Pilih Jenis Penjaminan</option>
                            </select>
                        
                            @if($errors->has('jenisPenjaminan'))
                            <p style="color: red"> {{ $errors->first('jenisPenjaminan')}}</p>
                            @endif
                        </div>  -->
                        <div class="checkbox icheck-primary">
                            <input required="" type="checkbox" id="primary" />
                            <label for="primary">SETUJU<b style="color: red"> * </b></label>
                        </div>  
                        <input hidden="" id="level" value="{{session::get('level')}}" />
                        <textarea  rows="6" style="color: red; text-align:justify" class="form-control" disabled="">Semua data yang diberikan sesuai dengan keadaan yang sebenarnya dan apabila di kemudian hari diketahui data yang diberikan tidak benar, maka PT. Jamkrida NTB Bersaing berhak membatalkan penjaminan ini dan PT. Jamkrida NTB Bersaing bebas dari kewajiban membayar apapun
                        </textarea> 
                        <div class="form-group">
                            <label>Pimpinan Cabang/Staff </label>                            
                            <input placeholder="Silahkan isi nama pimpinan cabang dan staff kredit" required="" value="{{session::get('nama')}}" class="form-control" name="pemohon">
                        </div>   
                        
                          <p>Lampiran Berkas Penjaminan</p>  
                            <div style="margin: 15px">
                                <div   class="form-group hidden " id="suratPernyataanSehat">
                                    <p> <b >Surat Pernyataan Kesehatan Debitur</b> |PDF|JPG|Max. 700Kb <b style="color: red">( * )</b> </p> 
                                    <input value="{{old('fileSuratSehat')}}" onchange="ValidateFileUpload(this)"  name="fileSuratSehat" id="fileSuratSehat"type="file" class="form-control"><br/>
            
                                    @if($errors->has('fileSuratSehat'))
                                            <script>
                                            $('#suratPernyataanSehat').removeClass('hidden');  
                                            $('#fileSuratSehat').prop('required',true);  
                                            </script>
                                    <p style="color: red"> {{ $errors->first('fileSuratSehat')}}</p>
                                    @endif
                                    <div id="ProgresSuratPernyataan" hidden="" class="progress">
                                        <div id="bar_sk" class="bar"></div >
                                        <div id="percent_sk" class="percent">0%</div >
                                    </div>
                                    <div id="status"></div> 
                                </div>
                      
                                <div   class="form-group hidden" id="CekKesehatanRs">
                                    <label>Upload Surat Keterangan Kesehatan |PDF|JPG|Max. 700Kb<b style="color: red">( * )</b></label> 
                                    <input onchange="ValidateFileUpload(this)"  name="fileSuratSehatRs" id="fileSuratSehatRs" type="file" class="form-control"><br/>
<!--                                   <script type="text/javascript">
                                    $('#fileSuratSehatRs').bind('change', function() {
                                        extensi = this.files[0].;
                                        alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                                    });
                                </script>-->
                                    @if($errors->has('fileSuratSehatRs')) 
                                            <script>
                                               $('#CekKesehatanRs').removeClass('hidden');
                                           </script>
                                    <p style="color: red"> {{ $errors->first('fileSuratSehatRs')}}</p>
                                    @endif
                                    <div id="ProgressSuratKeterangan" hidden="" class="progress">
                                        <div id="bar_rs" class="bar"></div >
                                        <div id="percent_rs" class="percent">0%</div >
                                    </div>
                                </div>    
                                <div class="form-group hidden" id="cekLab">                             
                                    <label>Upload Surat Hasil  Cek Lab |PDF|JPG|Max. 700Kb<b style="color: red">( * )</b></label>
                                    <input onchange="ValidateFileUpload(this)" name="fileCekLab" id="fileCekLab" type="file" class="form-control"><br/>
                                    @if($errors->has('fileCekLab'))
                                    <p style="color: red"> {{ $errors->first('fileCekLab')}}</p>
                                    <script>
                                        $('#CekKesehatan').removeAttr('hidden');
                                        $('#CekKesehatanRs').removeAttr('hidden');
                                    </script>
                                    @endif
                                    <div id="ProgressCekLab" hidden="" class="progress">
                                        <div id="bar_cl" class="bar"></div >
                                        <div id="percent_cl" class="percent">0%</div >
                                    </div> 
                                </div>
                                <div class="form-group hidden" id="cekGetaranJantung">                             
                                    <label>Upload Cek Getaran Jantung |PDF|JPG|Max. 700Kb<b style="color: red">( * )</b></label>
                                    <input onchange="ValidateFileUpload(this)" name="cekGetaranJantung"  id="fileGetaranJantung" type="file" class="form-control"><br/>
                                    @if($errors->has('cekGetaranJantung'))
                                    <p style="color: red"> {{ $errors->first('cekGetaranJantung')}}</p> 
                                    @endif
                                    <div id="ProgressCekLab" hidden="" class="progress">
                                        <div id="bar_cl" class="bar"></div >
                                        <div id="percent_cl" class="percent">0%</div >
                                    </div> 
                                </div>
                                 <div class="form-group hidden" id="cekKTP">                             
                                    <label>Upload KTP Terjamin + Pasangan |PDF|JPG|Max. 700Kb<b style="color: red">( * )</b></label>
                                    <input onchange="ValidateFileUpload(this)" name="cekKTP"  type="file" id="fileKtp"class="form-control"><br/>
                                    @if($errors->has('cekKTP'))
                                    <p style="color: red"> {{ $errors->first('cekKTP')}}</p> 
                                    @endif
                                    <div id="ProgressKTP" hidden="" class="progress">
                                        <div id="bar_KTP" class="bar"></div >
                                        <div id="percent_KTP" class="percent">0%</div >
                                    </div> 
                                </div>
                                 <div class="form-group hidden" id="cekUsaha">                             
                                    <label>Upload Foto Usaha|PDF|JPG|Max. 700Kb<b style="color: red">( * )</b></label>
                                    <input onchange="ValidateFileUpload(this)" name="cekUsaha"  type="file" id="fileUsaha" class="form-control"><br/>
                                    @if($errors->has('cekKTP'))
                                    <p style="color: red"> {{ $errors->first('cekUsaha')}}</p> 
                                    @endif
                                    <div id="ProgressUsaha" hidden="" class="progress">
                                        <div id="bar_usaha" class="bar"></div >
                                        <div id="percent_usaha" class="percent">0%</div >
                                    </div> 
                                </div>
                                 <div class="form-group hidden" id="cekSlik">                             
                                    <label>Upload  Hasil Pengecekan SLIK |PDF|JPG|Max. 700Kb<b style="color: red">( * )</b></label>
                                    <input onchange="ValidateFileUpload(this)" name="cekSlik"  type="file" id="fileSlik" class="form-control"><br/>
                                    @if($errors->has('cekSlik'))
                                    <p style="color: red"> {{ $errors->first('cekSlik')}}</p> 
                                    @endif
                                    <div id="ProgressSlik" hidden="" class="progress">
                                        <div id="bar_Slik" class="bar"></div >
                                        <div id="percent_Slik" class="percent">0%</div >
                                    </div> 
                                </div>
                                 <div class="form-group hidden" id="cekAnalisis">                             
                                    <label>Upload  Analisis Kelayakan Kredit|PDF|JPG|Max. 700Kb<b style="color: red">( * )</b></label>
                                    <input onchange="ValidateFileUpload(this)" name="cekAnalisis" id="fileAnalisis"  type="file" class="form-control"><br/>
                                    @if($errors->has('cekAnalisis'))
                                    <p style="color: red"> {{ $errors->first('cekAnalisis')}}</p> 
                                    @endif
                                    <div id="ProgressAnalisis" hidden="" class="progress">
                                        <div id="bar_Analisis" class="bar"></div >
                                        <div id="percent_Analisis" class="percent">0%</div >
                                    </div> 
                                </div>
                                 <div class="form-group hidden" id="cekTaksasi">                             
                                    <label>Upload  Hasil Taksasi Agunan |PDF|JPG|Max. 700Kb<b style="color: red">( * )</b></label>
                                    <input onchange="ValidateFileUpload(this)" name="cekTaksasi"  type="file" id="fileTaksasi" class="form-control"><br/>
                                    @if($errors->has('cekAnalisis'))
                                    <p style="color: red"> {{ $errors->first('cekTaksasi')}}</p> 
                                    @endif
                                    <div id="ProgressTaksasi" hidden="" class="progress">
                                        <div id="bar_Taksasi" class="bar"></div >
                                        <div id="percent_Taksasi" class="percent">0%</div >
                                    </div> 
                                </div>
                                 <div class="form-group hidden" id="cekSuratPersetujuanKredit">                             
                                    <label>Upload  Surat Persetujuan Kredit|PDF|JPG|Max. 700Kb<b style="color: red">( * )</b></label>
                                    <input onchange="ValidateFileUpload(this)" name="cekSuratPersetujuanKredit" id="fileSuratPersetujuanKredit"  type="file" class="form-control"><br/>
                                    @if($errors->has('cekSuratPersetujuanKredit'))
                                    <p style="color: red"> {{ $errors->first('cekSuratPersetujuanKredit')}}</p> 
                                    @endif
                                    <div id="ProgressSuratPersetujuanKredit" hidden="" class="progress">
                                        <div id="bar_SuratPersetujuanKredit" class="bar"></div >
                                        <div id="percent_SuratPersetujuanKredit" class="percent">0%</div >
                                    </div> 
                                </div>
                                 <div class="form-group hidden" id="cekDocRiwayatKredit">                             
                                    <label>Upload  Doc Riwayat Kredit|PDF|JPG|Max. 700Kb<b style="color: red">( * )</b></label>
                                    <input onchange="ValidateFileUpload(this)" name="cekRiwayatKredit" id="fileRiwayatKredit"  type="file" class="form-control"><br/>
                                    @if($errors->has('cekRiwayatKredit'))
                                    <p style="color: red"> {{ $errors->first('cekRiwayatKredit')}}</p> 
                                    @endif
                                    <div id="ProgressRiwayatKredit" hidden="" class="progress">
                                        <div id="bar_RiwayatKredit" class="bar"></div >
                                        <div id="percent_RiwayatKredit" class="percent">0%</div >
                                    </div> 
                                </div>
                            </div> 
                        </div>  
                        <br>
                     
                        <input value="{{old('persyaratan_id')}}" name="persyaratan_id" id="idPersyaratan" hidden=""  />
                        <button type="submit" id="simpan" class="btn btn-warning">Simpan</button>
                        {{csrf_field()}}
                    </div>
                </div>
            </div>
        </section>  
            </form>  
  
    </div>
    @include('user.modalKonfirmasi')
</body>

<script>
    $(document).ready(function () {

        var idbank = $('#idbank').val();
        $.ajax({
            url                 : "cekinputpenjaminan",
            method       : 'get',
            data              : 'idbank=' + idbank,
            dataType    : 'json',
            success: function (data) {
                if (data.jumlah) {
                    alert('Penginputan tidak bisa di lanjutkan, Silahkan selesaikan pembayaran untuk pengajuan sebelumnya!!!');
                    window.location.href = "bpr";
                }

            }
        })


        $('input:radio[name=jnsGracePeriode]').change(function () {
            if (this.value == 'ya')
            {
                var tglRealisasi = $('#tglrealisasi').val();
                $('#formGracePeriod').removeClass('hidden');
                $('#tglGrace').val(tglRealisasi);
            } else
            {
                $('#formGracePeriod').addClass('hidden');
            }

        });


    });

</script>
@endsection





