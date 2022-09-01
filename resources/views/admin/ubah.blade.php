@extends('layout.admin')
@section('content')
<!--    @if (Session::has('pesan'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ Session::get('pesan') }}
    </div>
    @endif-->
 
<div class="box box-solid">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><i class="glyphicon glyphicon-search"></i></strong>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="cari-data-penjaminan">
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
                                            <td><button  type="submit" class="btn btn-danger">Submit</button></td>
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
        <strong><h2 align="center">DATA PENGAJUAN PENJAMINAN</h2></strong>
    </div>
    <div class="panel-body">
             <section  class="col-lg-13 connectedSortable">
        <!-- Map box -->
        <div class="box box-solid">         
           <table id="tabelpembayaran" class=" table table-hover"  style="font-size: 12px;  margin-left: -1%; border: 1px; border-color:  black"    >
                        <thead>
                            <tr style="width: 30px; background-color:#23527c ;color: #ffffff">
                                <th>No</th> 
                                <th>Kode Registrasi</th> 
                                <th>PENERIMA JAMINAN</th> 
                                <th>TGL PENGAJUAN</th> 
                                <th>PLAFON</th> 
                                <th>TERJAMIN</th>                      
                                <th>JENIS KREDIT</th>
                                <th>MULAI</th>
                                <th>AKHIR</th>                           
                                <th>MASA</th> 
                                <th>STATUS</th> 
                                <th>ACTION</th> 
                                <th>DOCUMENT</th> 
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
                                <td>{{$datas -> idpenjaminan}}</td>
                               <td>
                                   {{$datas -> nosertifikat}} 
                                @if($datas->app=='Cetak')
                                    {{$datas ->sertifikat-> kodesertifikat}}
                                @else
                                    <b>Belum Terbit</b>
                                @endif
                               </td>   
                                <td>{{$datas ->bank-> namabank}}</td>   
                                <td>{{date('d-m-Y', strtotime($datas -> tglpengajuan))}}</td>     
                                <td>{{number_format( $datas -> plafon, 0, ',', '.')}}</td>                                                        
                                <td>{{$datas ->terjamin-> nama}}</td>                                                        
                                <td>{{$datas -> jeniskredit}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tgljatuhtempo))}}</td>                            
                                <td>{{$datas -> masakredit}} Bln</td>                                                       
                                <td>{{strtoupper($datas -> app)}}</td>                                                       
                                <td>
                                   @if (session::get('level')=='Super')
                                        <div class=" btn-group-vertical">
                                            <button data-toggle="tooltip" data-placement="top" title="Lihat detail dan Ubah data" id="{{$datas->idpenjaminan}}"  type="button" class="btn btn-warning  admineditpenjaminan">Detail</button> 
                                            <button  data-toggle="tooltip" data-placement="top" title="Hapus data pengajuan"  id="{{$datas->idpenjaminan}}"   class="btn btn-danger  admindeletepenjaminan">Reject</button>
                                        </div>
                                   @else
                                            @if($datas -> app!='Cetak' && $datas -> app!='Lunas')
                                            <div class=" btn-group-vertical">
                                                <button data-toggle="tooltip" data-placement="top" title="Lihat detail dan Ubah data" id="{{$datas->idpenjaminan}}"  type="button" class="btn btn-warning  admineditpenjaminan">Detail</button> 
                                                <button  data-toggle="tooltip" data-placement="top" title="Hapus data pengajuan"  id="{{$datas->idpenjaminan}}"   class="btn btn-danger  admindeletepenjaminan">Reject</button>
                                            </div>
                                            @endif
                                   @endif
                                </td>
                              
                            </tr>
                            <?php
                            $i++;
                             
                            ?>
                            @endforeach
                        </tbody>
                    </table> 
            Halaman:  <b>{{$data->currentPage()}}</b>. 
            Data Perhalaman: <b>{{$data->perPage()}} </b>Data.
            Jumlah Data Keseluruhan :<b> {{number_format($data->total(),0,',','.')}}</b>. 
            {{$data->links()}}
        </div>
    </section>  
    </div>
</div>
    
  <div id="modalEditPenjaminan" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
           <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <center>
               <h3 class="modal-title">DATA PENJAMINAN</h3>
            </center>
        </div>
            <form action="UpdatePenjaminanAdmin" method="post"  id="formPenjaminanUpdate"  enctype="multipart/form-data" >
                <div class="panel-body">             
                    <div class="box-body col-sm-6">
                        <div class="box-body">
                            <h2>TERJAMIN</h2>
                            <hr color="#ff0000">                        
                            <div class="form-group">   
                                  <input hidden=""  class="form-control" id="idpenjaminan"  name="idpenjaminan" >    
                                  <input hidden=""  required=""   class="form-control" id="kodepusat"    name="kodepusat" placeholder="Kode Pusat Bank"  maxlength="16" >                                  
                                  <input  hidden=""  required=""  class="form-control" id="idbank"    name="idbank"  >     
                            </div>
                            <div class="form-group">
                                <label>No KTP</label>
                                <input required="" value="{{old('ktp')}}" class="form-control" id="ktp"   onkeypress="return  hanyaAngka(event, false)" name="ktp" placeholder="Nomor KTP"  maxlength="16" >
                                <!--<input hidden="" required=""  id="ktplama"   onkeypress="return  hanyaAngka(event, false)" name="ktplama" maxlength="16" >-->
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
                                <label>No Telepon | Hp <b style="color: red">( * )</b></label>
                                <input value="{{old('phone')}}"  required="" type="number" minlength="10" maxlength="15" class="form-control" id="phone" name="phone" placeholder="phone" type="text" >
                                @if($errors->has('phone'))
                                <p style="color: red"> {{ $errors-> first('phone')}}</p>
                                @endif
                            </div>   
                            <div class="form-group ">
                                <label>Tempat Lahir<b style="color: red">( * )</b></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-time">
                                        </i>
                                    </div>
                                    <input required=""     id="tempatlahir"  name="tempatlahir"  type="text" class="form-control" >
                                </div>
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
<!--                            <div class="form-group">
                                <label >Pekerjaan</label>
                                <select required="" name="kredit" id="jeniskredit" class="form-control">
                                    <option value="">Pilih Jenis</option>
                                    <option value="PRODUKTIF">PENGUSAHA</option>                                                
                                    <option value="KONSUMTIF">KARYAWAN</option>                                               
                                </select>
                                @if($errors->has('kredit'))
                                <p style="color: red"> {{ $errors->first('kredit')}}</p>
                                @endif
                            </div>-->
                            <div class="form-group">
                                 <p>Pekerjaan<b style="color: red"> * </b></p> 
                                <div class="icheck-greensea icheck-inline">
                                    <input {{ old('jenis_pekerjaan')=='KARYAWAN' ? "checked" : "" }}   value="KARYAWAN" name="jenis_pekerjaan" required="" type="radio" id="radio-karyawan" />
                                    <label for="radio-karyawan">Karyawan</label> 
                                </div>
                                <div class="icheck-greensea icheck-inline">
                                    <input {{ old('jenis_pekerjaan')=='PENGUSAHA' ? "checked" : "" }}  value="PENGUSAHA" name="jenis_pekerjaan" required="" type="radio" id="radio-pengusaha" />
                                    <label for="radio-pengusaha">Pengusaha</label> 
                                </div> 
                            </div>
                            <div class="form-group">
                                <label id="detailPekerjaan">Detail Pekerjaan</label>
                                <input id="detail_Pekerjaan" name="pekerjaan" class="form-control"> 
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
                        
                                
                        <div class="form-group">
                            <p>Skema Kredit<b style="color: red"> * </b></p> 
                           <div class="icheck-greensea icheck-inline">
                               <input {{ old('kredit')=='KONSUMTIF' ? "checked" : "" }}   value="KONSUMTIF" name="kredit" required="" type="radio" id="radio-konsumtif" />
                               <label for="radio-konsumtif">Konsumtif</label> 
                           </div>
                           <div class="icheck-greensea icheck-inline">
                               <input {{ old('kredit')=='PRODUKTIF' ? "checked" : "" }}  value="PRODUKTIF" name="kredit" required="" type="radio" id="radio-produktif" />
                               <label for="radio-produktif">Produktif</label> 
                           </div>
                       </div>
                        
                        <div class="form-group">
                                <label>Tujuan Penggunaan Kredit</label>
                                <input required="" value="{{old('penggunaan')}}" class="form-control" id="penggunaan"  name="penggunaan" placeholder="penggunaan kredit"  > 
                                @if($errors->has('penggunaan'))
                                <p style="color: red"> {{ $errors-> first('penggunaan')}}</p>
                                @endif
                        </div>

                        
                        <div class="form-group "> 
                            <label>Tanggal Realisasi</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time">
                                    </i>
                                </div>
                                <input   required=""  id="tglrealisasi" name="tglrealisasi"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                            </div>
                            @if($errors->has('tglrealisasi'))
                            <p style="color: red"> {{ $errors->first('tglrealisasi')}}</p>
                            @endif
                        </div>              
                            <div class="form-group ">
                            <label>Masa Kredit [Bulan]</label>
                            <div class="input-group">

<!--                                <input hidden="" id="masaKredit1" type="text">-->
                                <input onchange="hitungUmurJatuhTempo()" required="" id="masaKredit" name="masakredit"  type="text" class="form-control" >
                                <div class="input-group-addon">
                                    Bulan
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label>Tanggal Jatuh Tempo</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time">
                                    </i>
                                </div>
                                <input  required="" id="tgljatuhtempo" name="tgljatuhtempo"   onchange="hitungUmurJatuhTempo1()" id="tgljatuhtempo" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">

                            </div>
                            <br>

                            @if($errors->has('tgljatuhtempo'))
                            <p style="color: red"> {{ $errors->first('tgljatuhtempo')}}</p>
                            @endif
                        </div>                                
                    
                        <div class="form-group">
                            <label>Umur Terjamin Saat Jatuh Tempo</label><br>
                            <input name="umurjatuhtempo" hidden="" class="form-control"  id="umurjatuhtempo1" >
                            <input required="" disabled=""  class="form-control"  id="umurjatuhtempo" >
                        </div>
                        <div id="pesanUmurJtauhTempo"></div>

                        <div class="form-group">
                            <label>No. Perjanjian Kredit</label>
                            <input required="" class="form-control" id="nopk"   name="nopk" placeholder="Nomor PK"  maxlength="16" >
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
                                <input hidden="" id="level" value="{{session::get('level')}}" />

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
                                <input hidden="" id="proses" name="proses"  value="update" type="text">
                                <input hidden="" id="statusbayar" name="statusbayar"   type="text">
                                <input hidden="" id="tglpengajuan1" name="tglPengajuan"   type="text">
                                <input disabled=""  id="tglpengajuan" type="text" class="form-control">
                            </div>
                        </div>
                       
                        <button type="submit" id="simpan" class="btn btn-warning btnUpdateBank">Update</button>
                        {{csrf_field()}}
                    </div>
                </div>
            </form>  
        </div>
    </div>
</div>  
<br>
<br>
@endsection

 