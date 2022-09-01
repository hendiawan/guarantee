@extends('layout.admin')
@section('content')

    @if (Session::has('pesan_sukses'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 
        <a href="/CetaksertifikatSignsb" style="color:red">{{ Session::get('pesan_sukses') }}</b> !!!</a>
    </div>
    @endif
	
   @if (Session::has('pesan_error'))
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        Error :  {{ Session::get('pesan_error') }}
    </div>
    @endif
    
<body ng-app="Penjaminan" ng-controller="PenjaminanController">
    
    
    <div class="box box-solid" >
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><i class="glyphicon glyphicon-search"></i></strong>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="/cari-sertifikat-signsb">
                            {{csrf_field()}}
                            <table  style="margin: 10px;"cellspacing="30">
                                <tr  style="margin-right: 10px">
                                    <th>CARI BERDASARKAN</th>
                                    <th>DATA</th>        
                                    <th></th>        
                                </tr>
                                <tr  style="margin-right: 30px">           
                                   <th>
                                       <select required="" id="jenis" name="jenis" class="form-control">
                                            <option value="">Pilih</option>
<!--                                        <option value="nosertifikat">KODE PENGAJUAN</option>                                                
                                            <option value="kodebayar">KODE BAYAR</option>                                                -->    
                                            <option value="nama">NAMA KONTRAKTOR</option>    
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
                                            <button style="height: 100%" type="submit"class="btn btn-danger">Submit</button>
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
        <strong>
        <h2 align="center">DATA PENGAJUAN PENJAMINAN SURETY BOND</h2>
        <h2 style="color: red" align="center">BELUM TANDA TANGAN DIGITAL</h2>
        </strong>
    </div>
    <div class="panel-body">
        <p style="color: red" align="center">Silahkan pilih dokumen yang akan ditandatangani !!!</p>
             <section  class="col-lg-13 connectedSortable">
        <!-- Map box -->
        <form method="post" id="FormTandaTanganDigital" action="{{url('PostSignSb')}}" enctype="multipart/form-data" >
        <div class="box box-solid" id="centang">
                <table id="tabelpembayaran" class=" table table-hover"  style="font-size: 11px;  border: 1px; border-color:  black"    >
                        <thead>
                            <tr style="width: 30px; background-color:#23527c ;color: #ffffff">
                                <th>No</th>
                                <th>Nomor Sertifikat</th>
                                <th>Nama Kontraktor</th>
                                <th>Tgl Input</th>                           
                                <th>Tgl Sertifikat</th>              
                                <th>Jns Jaminan</th>
<!--                            <th>Tgl Realisasi</th>
                                <th>Tgl Jth Tempo</th>                           -->
                                <th>Masa Berlaku</th>                           
                                <th>Nilai Penjaminan</th>                          
                                <th>Aging Sejak Terbit</th>                     
                                <th>Draft Sertifikat</th>     
                                <th>Action</th>                           
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = 1;
                            $premi = 0;
                            $dis = 0;
                            $nett = 0;
                         
                           function aging($tanggal) {
                                $tanggal1 = new DateTime($tanggal);
                                $tanggal2 = new DateTime();
                                return  $aging = $tanggal2->diff($tanggal1)->format("%a");
                            } 
                          @endphp
                            
                            @foreach($pengajuan as $data)
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{$data -> no_jaminan}}</td>
                                <td>{{$data -> nama_kontraktor}}</td> 
                                <td>{{date('d-m-Y', strtotime($data -> tgl_input))}}</td>    
                                <td>{{date('d-m-Y', strtotime($data -> tgl_cetak))}}</td>   
                                <td> 
                                   @if($data->jenis_sppsb=='1')
                                    JAMINAN PENAWARAN
                                    @endif
                                    @if($data->jenis_sppsb=='2')
                                    JAMINAN PELAKSANAAN
                                    @endif
                                    @if($data->jenis_sppsb=='3')
                                    JAMINAN UANG MUKA
                                    @endif
                                    @if($data->jenis_sppsb=='4')
                                    JAMINAN PEMELIHARAAN
                                    @endif
                                    @if($data->jenis_sppsb=='5')
                                    JAMINAN PEMBAYARAN
                                    @endif
                                    @if($data->jenis_sppsb=='6')
                                    JAMINAN SANGGAH BANDING
                                    @endif
                                
                                </td> 
                                <td>{{$data -> durasi}} Bln</td>
                                <td>{{number_format($data -> nilai_jaminan, 0, ',', '.')}}</td> 
                                <td><b><p style="color: red;font-size: 15px">{{aging($data -> tgl_cetak) }}</p></b>Hari</td>                    
                                 <td><a href="sertifikatSppsb/{{$data ->id}}"  style="color: black" target="_blank"><b><span class="glyphicon glyphicon-qrcode"></span></b> Preview</a></td>                  
                                <td>
                                    <div class="radio icheck-primary">
                                        <input style=" background: #ffffcc;
                                        outline:7px solid #ffffcc;"  id="validasipembayaran{{$data->id}}" class="radio cekpembayaran" type="checkbox" name="proses[{{$data ->id}}]" value="Ok" /> 
                                        <label for="validasipembayaran{{$data->id}}"><span class="glyphicon glyphicon-pencil"></span> Sign</label>
                                    </div>
                                </td>    
                            </tr> 
                            @php
                               $i++;
                            @endphp
                            @endforeach
                        </tbody>
                    </table> 
                <div align="right" class="radio icheck-primary">
                    <input  id="cekall" class="checkbox cekall" type="checkbox" name="pilihall" value="Ok" /> 
                    <label for="cekall"><b>Sign All</b></label>
                </div>
        </div>
		<div class="form-group">
		  <div class="col-sm-4">
		     <p><b>Masukkan NIK (*)<b><p>
			<input value="{{Auth::user()->nik}}"  placeholder="Masukkan NIK"  required="" style=" text-align: right; "  name="nik"  class="form-control"> 
			<br>
			<p><b>Masukkan Passphrase (*)<b><p>
			<input  type="password" placeholder="*******"  required="" style=" text-align: right; "  name="passphrase" id="passphreas_get" class="form-control"> 
			<br>
			<input type="submit"   name="submit" id="btn_sign" value="Proses" class="btn btn-info" />
		  </div>
       
		</div>
        
               {{csrf_field()}}
             </form>
       
    </section>  
    </div>
</div>
   @include('admin.cek.modalSign')
</body>   
<br>
<br>
@endsection

 

 