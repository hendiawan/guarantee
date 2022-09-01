@extends('layout.admin')
@section('content')

    @if (Session::has('pesan_sukses'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 
		 <a href="/CetaksertifikatSign" style="color:red"><b> {{ Session::get('pesan_sukses') }}</b> </a>
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
                        <form method="post" action="/cari-sertifikat-sign">
                            {{csrf_field()}}
                            <table  style="margin: 10px;"cellspacing="30">
                                <tr  style="margin-right: 10px">
                                    <th></th>
                                    <th></th>        
                                    <th></th>        
                                </tr>
                                <tr  style="margin-right: 30px">           
                                   <th>
                                       <select required="" id="jenis" name="jenis" class="form-control">
                                            <option value="">Pilih</option>
<!--                                        <option value="nosertifikat">KODE PENGAJUAN</option>                                                
                                            <option value="kodebayar">KODE BAYAR</option>                                                -->    
                                            <option value="nama">Nama terjamin</option>    
                                            <option value="kodesertifikat">No sertifikat</option> 
                                        </select>
                                    </th>
                                    <th> 
                                        <div style="margin: 10px" class="input-group">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-search">
                                                </i>
                                            </div>
                                            <input placeholder="Search data..." required="" value="{{old('data')}}"   id="data"  name="data"  type="text" class="form-control klickendorse" >
                                        </div>
                                    </th>
                                    <th>  
                                            <button style="border-radius: 20px; height: 100% ;background-color: #006666;margin: 3px" type="submit"class="btn btn-primary">Submit</button>
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
        <h2 align="left">DATA  PENJAMINAN KREDIT</h2> 
        </strong>
    </div>
    <div class="panel-body">
<!--        <a  class="btn btn-primary "   align="center">Silahkan pilih dokumen yang akan ditandatangani !!!</a>-->
             <section  class="col-lg-13 connectedSortable">
        <!-- Map box -->
        <form method="post" id="FormTandaTanganDigital" action="{{url('PostSign')}}" enctype="multipart/form-data" >
        <div class="box box-solid" id="centang">
                <table id="tabelpembayaran" class=" table table-hover"  style="font-size: 12px;  border: 1px; border-color:  black"    >
                    <thead>
                        <tr style="width: 30px; height: 60px; background-color:#ffffff ;color: #003333">
                            <th>No</th>
                            <th>Nomor Sertifikat</th>
                            <th>Nama Bank</th>
                            <!--<th>Nama Terjamin</th>--> 
                            <!--<th>Tgl Pengajuan</th>-->                           
                            <th>Tgl Terbit</th>     
                            <th>Jns Kredit</th>
<!--                      <th>Tgl Realisasi</th>
                            <th>Tgl Jth Tempo</th>                           -->
                            <th>Masa Kredit</th>                           
                            <th>Plafon</th>                          
                            <th>Aging Sejak Terbit</th>                     
                            <th>Draft Sertifikat</th>     
                            <th>Action</th>                           
                        </tr>
                    </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $premi = 0;
                            $dis = 0;
                            $nett = 0;
                             function aging($tanggal) {
                                $tanggal1 = new DateTime($tanggal);
                                $tanggal2 = new DateTime();
                                return  $aging = $tanggal2->diff($tanggal1)->format("%a");
                            }
                            
                            ?>
                            
                            @foreach($pengajuan as $data)
                           <?php
                           
                           if ($data -> tglbayar!=''){
                                $bayar=date('d-m-Y', strtotime($data -> tglbayar));
                                $kode=$data -> kodebayar;
                           }else{
                               $bayar='Belum Bayar';
                               $kode='Belum Bayar';
                           }
                            
                           ?>
                            <tr style="background-color:#fffff;color: #000000">  
                                <td>{{$i}}</td>
                                <td>
                                    <i class="glyphicon glyphicon-ok-sign"></i> {{$data -> kodesertifikat}} <br>
                                    <i class="glyphicon glyphicon-home"></i> {{$data -> namabank}} 
                                </td>
                                <td> 
                                    <i class="glyphicon glyphicon-user"></i>  {{$data -> nama}} <br>
                                    Tgl Pengajuan : {{date('d-m-Y', strtotime($data -> tglpengajuan))}}
                                </td>  
                                <!--<td></td>-->    
                                <td><i class="glyphicon glyphicon-calendar"></i>{{date('d-m-Y', strtotime($data -> tglterbit))}}</td>  
                                <td>{{$data -> jeniskredit}}</td>
<!--                                <td>{{date('d-m-Y', strtotime($data -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($data -> tgljatuhtempo))}}</td>                            -->
                                <td><i class="glyphicon glyphicon-arrow-right"></i> {{$data -> masakredit}} Bln</td>
                                <td>{{number_format($data -> plafon, 0, ',', '.')}}</td> 
                                <td><b><p style="color: red;font-size: 15px">{{aging($data -> tglterbit) }}</p></b>Hari</td>                    
                                <td><a href="cetaksertifikat/{{$data ->nosertifikat}}"  style="color: black" target="_blank"><b><span class="glyphicon glyphicon-qrcode"></span></b> Preview</a></td>                  
                                <td>
                                    <div class="radio icheck-primary">
                                        <input style=" background: #ffffcc;  outline:7px solid #ffffcc;"  id="validasipembayaran{{$data->idpenjaminan}}" class="radio cekpembayaran" type="checkbox" name="proses[{{$data ->idpenjaminan}}]" value="Ok" /> 
                                        <label   for="validasipembayaran{{$data->idpenjaminan}}"><span style="border-radius: 20px;width: 95%;background-color: #006666"   class="btn btn-primary  glyphicon-pencil" > Sign</span></label>
                                    </div>
                                </td>  
                            </tr>
                            <?php
                            $i++;
                            $premi = $premi + $data->premi;
                            $dis = $dis + $data->pot;
                            $nett = $nett + $data->nett; 
                            ?>
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
                                    <input value="{{Auth::user()->nik}}"placeholder="Masukkan NIK"  required="" style=" text-align: right; "  name="nik"  class="form-control"> 
                                    <br>
                                <p><b>Masukkan Passphrase (*)<b><p>
                                                <input  type="password" placeholder="*******"  required="" style=" text-align: right; "  name="passphrase" id="passphreas_get" class="form-control"> 
                                                <br>
                                                <input style="background-color: #003333" type="submit"   name="submit" id="btn_sign" value="Proses" class="btn btn-info" />
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

 

 