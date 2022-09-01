@extends('layout.admin')
@section('content')
<body ng-app="Penjaminan" ng-controller="PenjaminanController">
    <div class="container-fluid">
               <div class="box box-solid">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><i class="glyphicon glyphicon-search"></i></strong>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="carisertifikat">
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
<!--                                            <option value="nosertifikat">KODE PENGAJUAN</option>                                                
                                            <option value="kodebayar">KODE BAYAR</option>                                                -->
                                            <option value="kodesertifikat">NO SERTIFIKAT</option>            
                                            <option value="nama">NAMA TERJAMIN</option>    
                                         
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
                <strong>
                    <h2 align="center">PENGAJUAN PENJAMINAN KREDIT</h2>
                    <h2 style="color:red" align="center">CETAK SERTIFIKAT</h2>
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
                                    <!--<th>NO SERTIFIKAT</th>-->   
                                    <th>TGL TERBIT</th>   
                                    <th>PENERIMA JAMINAN</th>   
                                    <th>NO SERTIFIKAT</th>
                                    <th>TERJAMIN</th>        
                                    <th>JENIS KREDIT</th>
                                    <th>JENIS PENJAMINAN</th>
                                    <th>PLAFON</th>
                                    <th>NETT IJP</th>
                                    <th>REASURANSI</th>
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
                                    <!--<td>{{$data -> kodesertifikat}}</td>--> 
                                    <td>{{date('d-m-Y H:i:s', strtotime($data -> sertifikat->tglterbit))}}</td>
                                    <td>@if($data ->bank){{$data -> bank->namabank}}@else {{$data -> namabank}}@endif</td> 
                                    <td>{{$data -> sertifikat->kodesertifikat}}</td> 
                                    <td>{{$data -> terjamin->nama}}</td>   
                                    <td>{{$data -> jeniskredit}}</td>
                                    <td>{{$data -> jenispenjaminan}}</td>
<!--                                    <td>{{$data -> umurjatuhtempo}}</td>                                                        
                                    <td>{{$data -> pekerjaan}}</td>
                                  
                                    <td>{{$data -> nopk}}</td>
                                    <td>{{date('d-m-Y', strtotime($data -> tglrealisasi))}}</td>                            
                                    <td>{{date('d-m-Y', strtotime($data -> tgljatuhtempo))}}</td>                            
                                    <td>{{$data -> masakredit}} Bln</td>-->
                                    <td>{{number_format($data -> plafon, 0, ',', '.')}}</td>
                                    <td>{{number_format($data -> nett, 0, ',', '.')}}</td>
                                     <td> @if($data ->reasuransi){{$data -> reasuransi->rekanan->nama_asuransi}}@endif</td>
    <!--                                <td>{{$data ->rate}}</td>
                                    <td>{{number_format($data ->premi, 0, ',', '.')}}</td>
                                    <td>{{number_format($data ->pot, 0, ',', '.')}}</td>
                                    <td>{{number_format($data ->nett, 0, ',', '.')}}</td>-->
                                    <td>
                                        <div class=" btn-group-vertical">
                                            <li> <b> 
                                                    @if($data ->pembayaran)
                                                    <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary"  target="_blank "  
                                                        href="
                                                         @if($data->url_penjaminan!=null)
                                                         @if($data->pembayaran->url_file_bayar!=null)
                                                              <?php echo '/'.$data->pembayaran ->url_file_bayar.$data ->pembayaran->file?>
                                                            @else
                                                             <?php echo '/'.$data ->url_penjaminan.$data->pembayaran ->file?>
                                                            @endif
                                                       @else
                                                              {{url('/files/buktibayar').'/'.$data->pembayaran->file}}
                                                        @endif  " 
                                                        style="color: blue">Download Bukti Bayar</a>
                                                  @endif</b>
                                            </li>
                                            <li> <b><a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary"  target="_blank "  href="cetaksuratpengajuanadmin/{{$data ->nosertifikat}}"  style="color: black">Cetak Surat Pengajuan</a></b></li>
                                            <li <?php if($data ->case=='Tidak'){echo 'hidden=""';} ?> > <b > <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary"  style="color:black" target="_blank" href="/cetaksp3/{{$data ->nosertifikat}}">Cetak Surat Persetujuan Prinsip Penjaminan</a></b></li>
                                            <li <?php if($data ->case=='Tidak'){echo 'hidden=""';} ?> > <b > <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary"  style="color:black" target="_blank" href="/cetakrekomendasi/{{$data ->nosertifikat}}">Cetak Rekomendasi</a></b></li>
                                            <li>
                                                <b>
                                                 <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary" target="_blank " id="{{$data ->idpenjaminan}}" class="logcetaksertifikat"  href="cetaksertifikat/{{$data ->nosertifikat}}" >Cetak Sertifikat</a> 
                                                </b>
                                            </li>
                                            <li <?php if ($data->kesehatan->files == '' ) {echo 'hidden=""';} ?>><a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary"  target="_blank" href="@if($data->url_penjaminan!=null)<?php echo $data -> url_penjaminan.'/'.$data ->kesehatan-> files ?>@else files/suratsehat/{{$data->kesehatan -> files}} @endif"><b>Download Surat Sehat Terjamin</b></a></li>
                                  
                                       <li <?php if ($data->kesehatan->files3 == '' ) {echo 'hidden=""';;} ?> ><a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary"  target="_blank" href="@if ($data->url_penjaminan!=null)<?php echo $data ->url_penjaminan.'/'.$data ->kesehatan-> files3?>@else files/suratsehatrs/{{$data->kesehatan -> files3}} @endif"><b>Download Surat Sehat RS</a></b></li>
                                       <li <?php if ($data->kesehatan->files2 == '') { echo 'hidden=""';} ?>><a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary"   target="_blank" href="<?php if($data->url_penjaminan!='') {echo $data ->url_penjaminan.'/'.$data ->kesehatan-> files2;} else {echo 'files/scanlab/'.$data->kesehatan -> files2; }?>"><b>Download Dokumen Cek Lab </a></b></li>
                                       
                                          
                                        </div>
                                    </td>                         


                                </tr>
                                <?php
                                $i++;
                                $premi   = $premi + $data->premi;
                                $dis         = $dis + $data->pot;
                                $nett       = $nett + $data->nett;
                                ?>
                                @endforeach
                            </tbody>
                        </table>
                      Halaman:  <b>{{$pengajuan->currentPage()}}</b>. 
                      Data Perhalaman: <b>{{$pengajuan->perPage()}} </b>Data.
                      Jumlah Data Keseluruhan :<b> {{number_format($pengajuan->total(),0,',','.')}}</b>.
                      
                        {{$pengajuan->links()}}
                    </div>
                </section>  
            </div>
        </div>
        
    </div>
  
</body>
 
@endsection

 