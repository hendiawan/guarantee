@extends('layout.admin')
@section('content')

<?php

use App\banks;

?>
<body>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><i class="glyphicon glyphicon-edit"></i>  Input</strong>
            </div>
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
                            <input required="" class="form-control" id="nopk"  onkeypress="return  hanyaAngka(event, false)" name="nopk" placeholder="Nomor PK"  maxlength="16" >
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
                            <select required=""   id="JenisPnj"  class="form-control">
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
</body>

@endsection



