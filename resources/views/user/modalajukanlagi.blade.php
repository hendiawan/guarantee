<div id="modalAjukankembali" class="modal fade" role="dialog">
      <div class="modal-dialog">
          <div class="modal-content ">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">DATA PENJAMINAN</h4>
        </div>
         
            
            <form action="/UpdatePenjaminanUser" method="post"  id="formPenjaminanUpdate1"  enctype="multipart/form-data" >
                <div class="panel-body">             
                    <div class="box-body col-sm-6">
                        <div class="box-body">
                            <h2>TERJAMIN</h2>
                            <hr color="#ff0000">                        
                            <div class="form-group">   
                                  <input hidden=""  class="form-control" id="idpenjaminan1"  name="idpenjaminan" >   
                                @if (Session::has('idbank'))
                                <input hidden="" required="" value="{{Session::get('idbank') }}" class="form-control" id="idbank1"    name="idbank" placeholder="ID Bank"  maxlength="16" >                                  
                                @endif
                            </div>
                            <div class="form-group">
                                <label>No KTP</label>
                                <input required="" value="{{old('ktp')}}" class="form-control" id="ktp1"   onkeypress="return  hanyaAngka(event, false)" name="ktp" placeholder="Nomor KTP"  maxlength="16" >
                                @if($errors->has('ktp'))
                                <p style="color: red"> {{ $errors-> first('ktp')}}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Nama Terjamin</label>
                                <input required="" value="{{old('ktp')}}" class="form-control" id="name1" name="name" placeholder="Name" type="text" >
                                @if($errors->has('name'))
                                <p style="color: red"> {{ $errors-> first('name')}}</p>
                                @endif
                            </div>   
                            <div class="form-group ">
                                <label>Tempat Lahir<b style="color: red">( * )</b></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-time">
                                        </i>
                                    </div>
                                    <input required=""     id="tempatlahir1"  name="tempatlahir"  type="text" class="form-control" >
                                </div>
                                
                            </div>
                            <div class="form-group ">
                                <label>Tanggal Lahir</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-time">
                                        </i>
                                    </div>
                                    <input required="" value="{{old('tglLhr')}}"  onchange="hitungUmur1()" id="tglLahir1"  name="tglLhr"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
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
                                    <input required="" value="{{old('umur')}}" disabled="" class="form-control" name="umur"  id="tampil12"  type="text">  
                                    <input hidden="" name="umur"  id="tampil2"  type="text">  
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Pekerjaan</label>
                                <select required="" name="kredit" id="jeniskredit1" class="form-control">
                                    <option value="">Pilih Jenis</option>
                                    <option value="PRODUKTIF">PENGUSAHA</option>                                                
                                    <option value="KONSUMTIF">KARYAWAN</option>                                               
                                </select>
                                @if($errors->has('kredit'))
                                <p style="color: red"> {{ $errors->first('kredit')}}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label id="detailPekerjaan1">Detail Pekerjaan</label>
                                <input required="" id="pekerjaan1" name="pekerjaan" class="form-control">
                               
                                @if($errors->has('pekerjaan'))
                                <p style="color: red"> {{ $errors->first('pekerjaan')}}</p>
                                @endif
                            </div>
                            <div class="form-group ">
                                <label>Alamat</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-map-marker">
                                        </i>
                                    </div>
                                    <textarea required="" id="alamat1" name="alamat"  type="text"  class="form-control" ></textarea>
                                </div>
                                @if($errors->has('alamat'))
                                <p style="color: red"> {{ $errors->first('alamat')}}</p>
                                @endif
                            </div>  
                            
                             
                        @if(session::get('level')=='Bntb')
                            <div class="form-group">
                                <label>NPWP</label>
                                <input required="" value="{{old('npwp')}}" class="form-control" id="npwp1"    name="npwp" placeholder="Nomor Pajak Wajib Pajak"  maxlength="25" >
                                @if($errors->has('ktp'))
                                <p style="color: red"> {{ $errors-> first('npwp')}}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>SIUP</label>
                                <input required="" value="{{old('siup')}}" class="form-control" id="siup1"    name="siup" placeholder="SIUP"  maxlength="16" >
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
                                <input required=""  id="tglrealisasi1" name="tglrealisasi"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                            </div>
                            @if($errors->has('tglrealisasi'))
                            <p style="color: red"> {{ $errors->first('tglrealisasi')}}</p>
                            @endif
                            <div id="msg_realisasi"></div>
                        </div>                          
                          <div class="form-group ">
                            <label>Masa Kredit [Bulan]</label>
                            <div class="input-group">
                                <input  onchange="hitungUmurJatuhTempo()" onkeypress="return  hanyaAngka(event, false)" required="" name="masakredit"  id="masaKredit12" type="text" class="form-control" >
                                <div class="input-group-addon">
                                    Bulan
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label>Tanggal Jatuh Tempo<b style="color: red">( * )</b></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time">
                                    </i>
                                </div>
                                <input hidden="" required=""  maxlength="3" name="tgljatuhtempo" id="tgljatuhtempo1" type="text" >
                                <input required="" disabled=""  class="form-control" maxlength="3"  id="tgljatuhtempo12" type="text" >
                          
                            </div>
                            <p id="errorjatuhtempo"></p>
                            <br>

                            @if($errors->has('tgljatuhtempo'))
                            <p style="color: red"> {{ $errors->first('tgljatuhtempo')}}</p>
                            @endif
                        </div> 
                        
                        <div class="form-group">
                            <label>Umur Terjamin Saat Jatuh Tempo</label><br>
                            <input name="umurjatuhtempo" hidden="" class="form-control"  id="umurjatuhtempo12" >
                            <input required="" disabled=""  class="form-control"  id="umurjatuhtempo2" >
                        </div>
                        <div id="pesanUmurJtauhTempo1"></div>

                        <div class="form-group">
                            <label>No. Perjanjian Kredit</label>
                            <input required="" class="form-control" id="nopk1"   name="nopk" placeholder="Nomor PK"  maxlength="16" >
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
                                <input required="" name="tglpk" id="tglpk1" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">

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
                                <input required="" id="plafon12"  onchange="CekPlafon1()" onmousemove="FormatCurrency(this)" onkeyup="FormatCurrency(this)" class="form-control" name="plafon">
                                <input hidden="" id="level1" value="{{session::get('level')}}" />

                                @if($errors->has('plafon'))
                                <p style="color: red"> {{ $errors->first('plafon')}}</p>
                                @endif

                            </div>
                            <div id="pesanPlafon1"></div>
                        </div>
                        
                        <input hidden="" id="caseket1"   class="form-control" name="caseket">

                        <div class="form-group">
                             <label>Jenis Penjaminan</label>                            
<!--                            <div id="Jenispilihan"></div>-->
                            <select  required="" name="jenisPenjaminan" id="jenis_penjaminan_ulang" class="form-control">
                                    <option value="">Pilih Jenis Penjaminan</option>
                                    @foreach($rate as $rates)
                                    <option value="{{$rates->namarate}}">{{$rates->namarate}}</option>                                               
                                    @endforeach
                            </select>
                        </div>  
                        <div class="form-group ">
                            <label>Tanggal Registrasi</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time">
                                    </i>
                                </div>
                                <input hidden="" name="nosertifikat" value="" id="nosertifikat"   type="text">
                                <input hidden="" name="approval" value="ulang"   type="text">
                                <input hidden="" id="tglpengajuan12" name="tglPengajuan"   type="text">
                                <input disabled=""  id="tglpengajuan2" type="text" class="form-control">
                            </div>
                        </div>
                      
                        <button type="submit" id="simpan1" class="btn btn-success">Proses</button>
                    </div>
                     
                        
                        {{csrf_field()}}
                     
            </form>  
        </div>
   
          </div>
       
</div>
</div>
  