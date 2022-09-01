@extends('layout.admin')

@section('content')

<body>
    <div class="container">
         <div ng-app="Penjaminan" ng-controller="PenjaminanController" >
        <div class="box-body col-sm-10">
            <div class="box-body">
                <h3>FORM PENGAJUAN PENJAMINAN</h3>
                <h3 >DATA TERJAMIN</h3>
                <hr color="#ff0000">
                <form  method="post" action="/simpanpenjaminan">
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
                    <div class="form-group">
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
                                <p style="color: red"> {{ $errors-> first('tglLhr')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
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
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label>Pekerjaan</label>
                            <select required="" name="pekerjaan" class="form-control">
                                <option value="">Pilih Pekerjaan</option>
                                <option value="PNS">PNS</option>                                                
                                <option value="PETANI">PETANI</option>                                                
                                <option value="NELAYAN">NELAYAN</option>                                                
                                <option value="KARYAWAN SWASTA">KARYAWAN SWASTA</option>                                               
                                <option value="KARYAWAN BUMN">KARYAWAN BUMN</option>                                               
                                <option value="KARYAWAN BUMD">KARYAWAN BUMD</option>                                               
                                <option value="WIRASWASTA">WIRASWASTA</option>                                               
                            </select>
                            @if($errors->has('pekerjaan'))
                            <p style="color: red"> {{ $errors-> first('pekerjaan')}}</p>
                            @endif

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label>Jenis Kredit</label>
                            <select required="" name="kredit" class="form-control">
                                <option value="">Pilih Jenis</option>
                                <option value="PRODUKTIF">PRODUKTIF</option>                                                
                                <option value="KONSUMTIF">KONSUMTIF</option>                                               
                            </select>
                            @if($errors->has('kredit'))
                            <p style="color: red"> {{ $errors-> first('kredit')}}</p>
                            @endif

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group ">
                            <label>Alamat</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-map-marker">
                                    </i>
                                </div>
                                <input required=""  name="alamat"  type="text" class="form-control" >
                            </div>
                            @if($errors->has('alamat'))
                            <p style="color: red"> {{ $errors-> first('alamat')}}</p>
                            @endif
                        </div>
                    </div>
                    <h3 class="text-center">DATA PENJAMINAN</h3>
                    <div class="form-group">
                        <div class="form-group ">
                            <label>Tanggal Realisasi</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time">
                                    </i>
                                </div>
                                <input required="" disabled="" id="tglrealisasi" name="tglrealisasi"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                            </div>
                            @if($errors->has('tglrealisasi'))
                            <p style="color: red"> {{ $errors-> first('tglrealisasi')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group ">
                            <label>Tanggal Jatuh Tempo</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time">
                                    </i>
                                </div>
                                <input required="" disabled="" name="tgljatuhtempo"   onchange="hitungUmurJatuhTempo()" id="tgljatuhtempo" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">

                            </div>
                            @if($errors->has('tgljatuhtempo'))
                            <p style="color: red"> {{ $errors-> first('tgljatuhtempo')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group ">
                            <label>Masa Kredit [Bulan]</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time">
                                    </i>
                                </div>
                                <input hidden="" name="masakredit" id="masaKredit1" type="text">
                                <input required="" disabled="" id="masaKredit" type="text" class="form-control" >
                            </div>
                        </div>
                    </div>

                    <div class="for-group">
                        <div class="form-group">
                            <label>Umur Terjamin Saat Jatuh Tempo</label><br>
                            <input name="umurjatuhtempo" hidden="" class="form-control"  id="umurjatuhtempo1" >
                            <input required="" disabled=""  class="form-control"  id="umurjatuhtempo" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label>No. Perjanjian Kredit</label>
                        <input required="" class="form-control"  onkeypress="return  hanyaAngka(event, false)" name="nopk" placeholder="Nomor PK"  maxlength="16" >
                        @if($errors->has('nopk'))
                        <p style="color: red"> {{ $errors-> first('nopk')}}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="form-group ">
                            <label>Tanggal Perjanjian Kredit</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time">
                                    </i>
                                </div>
                                <input required="" name="tglpk"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">

                            </div>
                            @if($errors->has('tglpk'))
                            <p style="color: red"> {{ $errors-> first('tglpk')}}</p>
                            @endif

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label>Plafon Kredit Rp.</label><br>
                            <input required="" id="plafon"  onchange="CekPlafon()" onkeyup="FormatCurrency(this)" class="form-control" name="plafon">
                            <div id="pesanPlafon"></div>
                            @if($errors->has('plafon'))
                            <p style="color: red"> {{ $errors-> first('plafon')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label>Jenis Penjaminan</label>                            
                            <select required="" name="jenisPenjaminan" class="form-control">                               
                                <option value="">Pilih Jenis</option>
                                @foreach($rate as $data)
                                <option value="{{$data->namarate}}">{{$data->namarate}}</option>  
                                @endforeach                                                                               
                            </select> 

                            @if($errors->has('jenisPenjaminan'))
                            <p style="color: red"> {{ $errors-> first('jenisPenjaminan')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group ">
                            <label>Tanggal Pengajuan</label>
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
                    <button type="submit" class="btn btn-warning btn-xs">Simpan</button>
                    {{csrf_field()}}
                </form>                   
            </div>

        </div>
    </div>
    </div>
   
</body>

@endsection



