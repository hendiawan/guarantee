@extends('layout.admin')
@section('content')
<body ng-app="Penjaminan" ng-controller="PenjaminanController">
      
        {{print_r($LabaRugi)}}
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <h2 align="center">SINGKRONISASI</h2>
                    <h2 style="color:red" align="center">DATA PENJAMINAN SUDAH TERBIT SERTIFIKAT</h2>
                </strong>
            </div>
            <div class="panel-body">
                <section  class="col-lg-13 connectedSortable">
                    <!-- Map box -->
                    <div class="box box-solid">         
                        <table id="tabelpembayaran" class=" table table-hover"  style="font-size: 11px; border: 1px; border-color:  black"    >
                            <thead>
                                <tr style="width: 30px; background-color:#23527c ;color: #000000">
                                    <th>NO</th>
                                    <th>NO SERTIFIKAT</th>   
                                    <th>TGL TERBIT</th>   
                                    <th>PENERIMA JAMINAN</th>   
                                    <th>NO KTP</th>
                                    <th>TERJAMIN</th>        
                                    <th>JENIS KREDIT</th>
                                    <th>PLAFON</th>
<!--                                 <th>UMUR</th>
                                    <th>PEKERJAAN</th>                              
                                    <th>NO PK</th>
                                    <th>MULAI TGL</th>
                                    <th>SAMPAI TGL</th>                           
                                    <th>JUMLAH</th>                                
                                   -->
    <!--                                <th>RATE IJP(%)</th>
                                    <th>JUMLAH IJP</th>
                                    <th>DISC(Rp)</th>
                                    <th>NET. IJP(Rp)</th>-->
                                    <th>DOKUMEN</th>                           
                                    <th>EXPORT</th>                           
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
                                @foreach($pengajuan as $data)           
                                <tr style="background-color:#bdbdbd ;color: #000000">  
                                    <td>{{$i}}</td>
                                    <td>{{$data -> kodesertifikat}}</td> 
                                    <td>{{date('d-m-Y', strtotime($data -> tglterbit))}}</td>    
                                    <td>{{$data -> namabank}}</td> 
                                    <td>{{$data -> ktp}}</td> 
                                    <td>{{$data -> nama}}</td>   
                                    <td>{{$data -> jeniskredit}}</td>
<!--                                    <td>{{$data -> umurjatuhtempo}}</td>                                                        
                                    <td>{{$data -> pekerjaan}}</td>
                                  
                                    <td>{{$data -> nopk}}</td>
                                    <td>{{date('d-m-Y', strtotime($data -> tglrealisasi))}}</td>                            
                                    <td>{{date('d-m-Y', strtotime($data -> tgljatuhtempo))}}</td>                            
                                    <td>{{$data -> masakredit}} Bln</td>-->
                                    <td>{{number_format($data -> plafon, 0, ',', '.')}}</td>
    <!--                                <td>{{$data ->rate}}</td>
                                    <td>{{number_format($data ->premi, 0, ',', '.')}}</td>
                                    <td>{{number_format($data ->pot, 0, ',', '.')}}</td>
                                    <td>{{number_format($data ->nett, 0, ',', '.')}}</td>-->
                                    <td>
                                        <div class=" btn-group-vertical">
                                            <li> <b> <a target="_blank "  href="cetaksuratpengajuanadmin/{{$data ->nosertifikat}}"  style="color: black">Cetak Surat Pengajuan</a></b></li>
                                            <li <?php if($data ->case=='Tidak'){echo 'hidden=""';} ?> > <b > <a style="color:black" target="_blank" href="/cetaksp3/{{$data ->nosertifikat}}">Cetak Surat Persetujuan Prinsip Penjaminan</a></b></li>
                                            <li>
                                                <b>
                                                    <a style="color: red" target="_blank " id="{{$data ->idpenjaminan}}" class="logcetaksertifikat"  href="/cetaksertifikat/{{$data ->nosertifikat}}" >Cetak Sertifikat</a> 
                                                </b>
                                            </li>
                                          
                                        </div>
                                    </td>
                                    <td>@if($data->export=='Y')<p style="color:green">SUDAH</p> @else <p style="color:red"><b>BELUM</b></p> @endif</td>
                                    <td><a id="{{$data->kodesertifikat}}" class="export-data" href="">EXPORT</a></td>


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
                    </div>
                </section>  
            </div>
        </div>
  
    <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <h2  align="center">DATA YANG SUDAH MASUK DALAM SEVER LOKAL</h2>
                    <h2 style="color:red" align="center">PERIODE {{strtoupper(date('M'))}} {{date('Y')}} </h2>
                </strong>
            </div>
            <div class="panel-body">
                <section  class="col-lg-13 connectedSortable">
                    <!-- Map box -->
                    <div class="box box-solid">         
                        <table class=" table table-hover tabel"  style="font-size: 11px; border: 1px; border-color:  black"    >
                            <thead>
                                <tr style="width: 30px; background-color:#23527c ;color: #000000">
                                    <th>NO TRANSAKSI</th>
                                    <th>PENERIMA JAMINAN</th>   
                                    <th>TERJAMIN</th>   
                                    <th>PRODUK</th>   
                                    <th>NO SERTIFIKAT</th>
                                    <th>TGL INPUT</th>        
                                    <th>TGL VER. KASI</th>        
                                    <th>TGL VER. KEUANGAN</th>        
                                    <th>PLAFOND</th>
                                    <th>RATE</th>
                                    <th>GROS IJP</th>
                                    <th>NETT IJP</th>
                                    <th>ACTION</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                               
                                @foreach($data_lokal as $data)           
                                <tr style="background-color:#bdbdbd ;color: #000000">  
                                    <td>{{$data -> no_transaksi}}</td>
                                    <td>{{$data -> nama_bank}}</td> 
                                    <td>{{$data -> nama_terjamin}}</td> 
                                    <td>{{$data -> kd_produk}}</td>
                                    <td>{{$data -> no_sertifikat}}</td>
                                    <td>{{date('d-m-Y',strtotime($data -> tanggal_daftar_terjamin))}}</td>
                                    <td>{{date('d-m-Y',strtotime($data -> tanggal_verifikasi_kasi))}}</td>
                                    <td>{{date('d-m-Y',strtotime($data -> tanggal_verifikasi_kasi))}}</td>
                                    <td>{{number_format($data -> nilai, 0, ',', '.')}}</td>
                                    <td>{{number_format($data->tarif_ijp, 3, ',', '.')}}</td>
                                    <td>{{number_format($data->total_ijp_kotor, 0, ',', '.')}}</td>
                                    <td>{{number_format($data ->total_ijp_bersih, 0, ',', '.')}}</td>
                                    <td><a href="" id="{{$data -> no_transaksi}}" name="{{$data -> kd_terjamin}}" class="hapus-penjaminan">DELETE</a></td>
                                </tr>
                                 
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </section>  
            </div>
        </div>
   
    <div class="modal fade modal-md data-export" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog" role="document">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <button style="color: red" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h2 style="color:#2d2d30" align="center">SINKRONISASI DATA PENJAMINAN</h2>

                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-12">
                            <span class="help-block"><small>TANGGAL VERIFIKASI KASI</small></span>
                            <input  class="form-control tanggal" name="tgl_verifikasi_kasi" id="tgl_verifikasi_kasi">
                        </div>
                        <div class="col-md-12">
                            <span class="help-block"><small>TANGGAL VERIFIKASI KEUANGAN</small></span>
                            <input  class="form-control tanggal" name="tgl_verifikasi_keu" id="tgl_verifikasi_keu">
                        </div>
                        <div class="col-md-12">
                            <span class="help-block"><small>PILIH MASTER KAS</small></span>
                            <select name="kd_kas" required="" id="kd_kas" class="form-control">
                                <option value="">Pilih Kas</option>
                                @foreach($kas as $bank)
                                <option value="{{$bank->kd_kas}}">{{$bank->no_rekening}}</option>
                                @endforeach
                            </select>
                        </div>
                         <div class="col-md-12">
                            <span class="help-block"><small>PENERIMA JAMINAN</small></span>
                            <input style="color:red" disabled="" class="form-control" name="penerima_jaminan" id="penerima_jaminan">
                        </div>
                        <div class="col-md-12">
                            <span class="help-block"><small>NOMOR SERTIFIKAT</small></span>
                            <input hidden="" name="nomor_sertifikat" id="nomor_sertifikat">
                            <input style="color:red" disabled="" class="form-control" name="nomor_sertifikat_view" id="nomor_sertifikat_view">
                        </div>
                        <div class="col-md-12">
                            <span class="help-block"><small>NAMA TERJAMIN</small></span>
                            <input style="color:red" disabled="" class="form-control" name="nama_terjamin" id="nama_terjamin">
                        </div>
                       
                        <div class="col-md-12">
                            <span class="help-block"><small>TANGGAL PENGAJUAN</small></span>
                            <input style="color:red;" disabled="" class="form-control" name="tanggal_pengajuan" id="tanggal_pengajuan">
                        </div>
                        <div class="col-md-12">
                            <span class="help-block"><small>TANGGAL TERBIT</small></span>
                            <input style="color:red;" disabled="" class="form-control" name="tanggal_terbit" id="tanggal_terbit">
                        </div>
                        
                    </div>
                </div>
                <div class="panel-footer text-center">
                    <button type="button" class="btn btn-grey" data-dismiss="modal"><i class="fa fa-close"></i> Keluar</button>
                    <button id="id_btn_simpan" type="submit" class="btn btn-blue export-data-simpan"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>
    
</body>
 
@endsection

 