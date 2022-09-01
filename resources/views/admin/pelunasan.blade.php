@extends('layout.admin')
@section('content')


 
    @if (Session::has('pesan'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ Session::get('pesan') }}
    </div>
    @endif
 
      <div class="box box-solid">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><i class="glyphicon glyphicon-search"></i></strong>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="caridatapelunasan">
                            {{csrf_field()}}
                            <table>
                                <tr>
                                    <th>CARI BERDASARKAN</th>
                                    <th>DATA</th>        
                                </tr>
                                <tr>                    
                                   <th>
                                       <select required="" id="jenis" name="jenis" class="form-control">
                                            <option value="">Pilih</option>             
                                            <option value="nama">NAMA TERJAMIN</option>    
                                            <option value="kodesertifikat">NO SERTIFIKAT</option> 
                                        </select>
                                    </th>
                                    <th> 
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-edit">
                                                </i>
                                            </div>
                                            <input required="" value="{{old('data')}}"   id="data"  name="data"  type="text" class="form-control klickendorse" >
                                        </div>
                                    </th>
                                    <th>
                                        <br>
                                        <div class="input-group">
                                            <td><button  type="submit" class="btn btn-danger btn-xs">Submit</button></td>
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
<div class="panel panel-default">
    <div class="panel-heading">
        <strong><h2 align="center">DATA PENJAMINAN</h2></strong>
    </div>
    <div class="panel-body">
             <section  class="col-lg-13 connectedSortable">
        <!-- Map box -->
        <div class="box box-solid">         
           <table id="tabelpembayaran" class=" table table-hover"  style="font-size: 12px;  margin-left: -1%; border: 1px; border-color:  black"    >
                        <thead>
                            <tr style="width: 30px; background-color:#23527c ;color: #000000">
                                <th>No</th> 
                                <th>NOMOR SERTIFIKAT</th> 
                                <th>PENERIMA JAMINAN</th> 
                                <th>TGL PENGAJUAN</th> 
                                <th>PLAFON</th> 
                                <th>TERJAMIN</th>                      
                                <th>NO KTP</th>                      
                                <th>JENIS KREDIT</th>
                                <th>MULAI</th>
                                <th>AKHIR</th>                           
                                <th>MASA</th> 
                                <th>STATUS</th> 
                                <th>ACTION</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                             
                            $i = 1;
                            $premi = 0;
                            $dis = 0;
                            $nett = 0;                            
                             
                            ?>
                            @foreach($data as $datas)
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{$datas -> kodesertifikat}}</td>   
                                <td>{{$datas -> namabank}}</td>   
                                <td>{{date('d-m-Y', strtotime($datas -> tglpengajuan))}}</td>     
                                <td>{{number_format( $datas -> plafon, 0, ',', '.')}}</td>                                                        
                                <td>{{$datas -> nama}}</td>                                                        
                                <td>{{$datas -> ktp}}</td>                                                        
                                <td>{{$datas -> jeniskredit}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tgljatuhtempo))}}</td>                            
                                <td>{{$datas -> masakredit}} Bln</td>                                                       
                                <td>{{strtoupper($datas -> app)}}</td>                                                       
                               <td>
                                    <div class=" btn-group-vertical">
                                        <button data-toggle="tooltip" data-placement="top" title="Proses Pelunasan Kredit" id="{{$datas->idpenjaminan}}"  type="button" class="btn btn-success btn-xs tombolpelunasan">Pelunasan</button> 
                                    </div>
                                </td>
                            </tr>
                            <?php
                            $i++;
                             
                            ?>
                            @endforeach
                        </tbody>
                    </table>
        </div>
    </section>  
    </div>
</div>
    
     <div id="modalpelunasan" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">UBAH DATA PENJAMINAN</h4>
                    </div>
                    <form action="prosespelunasan" method="post"  id="formPenjaminanUpdate"  enctype="multipart/form-data" >
                        <div class="panel-body">             
                            <div class="box-body col-sm-6">
                                <div class="box-body">
                                    <h2>TERJAMIN</h2>
                                    <hr color="#ff0000">   
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
                                    <div class="form-group">   
                                        <input hidden=""  class="form-control" id="idpenjaminan"  name="idpenjaminan" >   
                                        <input hidden="" class="form-control" id="level"  name="level" >   
                                        <input hidden="" required=""   class="form-control" id="idbank"    name="idbank" placeholder="ID Bank"  maxlength="16" >                                  

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
                            <div class="form-group">
                                <label>Pekerjaan</label>
                                <select required="" name="kredit" id="jeniskredit" class="form-control">
                                    <option value="">Pilih Jenis</option>
                                    <option value="PRODUKTIF">PENGUSAHA</option>                                                
                                    <option value="KONSUMTIF">KARYAWAN</option>                                               
                                </select>
                                @if($errors->has('kredit'))
                                <p style="color: red"> {{ $errors->first('kredit')}}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Detail Pekerjaan</label>
                                <input id="pekerjaan" name="pekerjaan" class="form-control">
                               
                                @if($errors->has('pekerjaan'))
                                <p style="color: red"> {{ $errors->first('pekerjaan')}}</p>
                                @endif
                            </div>
                            
                            <div id="bntb">
                                <div class="form-group">
                                    <label>NPWP</label>
                                    <input  value="{{old('npwp')}}" class="form-control" id="npwp"    name="npwp" placeholder="Nomor Pajak Wajib Pajak"  maxlength="25" >
                                    @if($errors->has('ktp'))
                                    <p style="color: red"> {{ $errors-> first('npwp')}}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>SIUP</label>
                                    <input  value="{{old('siup')}}" class="form-control" id="siup"    name="siup" placeholder="SIUP"  maxlength="16" >
                                    @if($errors->has('siup'))
                                    <p style="color: red"> {{ $errors-> first('siup')}}</p>
                                    @endif
                                </div>
                            </div>
                                </div>
                    </div>

                    <div class="box-body col-sm-6">
                        <h2>PENJAMINAN</h2>
                        <hr>
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
                        <input hidden="" id="caseket"   class="form-control" name="caseket">

                        <div class="form-group">
                            <label>Jenis Penjaminan</label>                            
                            <div id="Jenispilihan"></div>
                            <select required="" name="jenisPenjaminan"   id="JenisPnj"  class="form-control">
                                <option value="">Pilih Jenis Penjaminan</option>
                            </select>
                            @if($errors->has('jenisPenjaminan'))
                            <p style="color: red"> {{ $errors->first('jenisPenjaminan')}}</p>
                            @endif
                        </div>     
                        <div class="form-group">
                            <label style="color:red">Proses Pelunasan</label>
                                <select required="" name="kredit" id="jeniskredit" class="form-control">
                                    <option value="">Pilih Pelunasan</option>
                                    <option value="PRODUKTIF">LUNAS</option>                                                
                                                                                  
                                </select>
                                @if($errors->has('kredit'))
                                <p style="color: red"> {{ $errors->first('kredit')}}</p>
                                @endif
                            </div>
<!--                         <div class="form-group ">
                            <label>CATATAN PERUBAHAN DATA</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-tasks">
                                    </i>
                                </div>
                                <textarea id="catatan" name="catatan" required="" class="form-control"></textarea>
                                    </div>
                                </div>-->


                                
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="simpan" class="btn btn-warning btn-xs">Proses</button>
                            {{csrf_field()}}    
                        </div>
                    </form> 
                    
                </div>
            </div>
        </div>
 

   
<br>
<br>
@endsection

 