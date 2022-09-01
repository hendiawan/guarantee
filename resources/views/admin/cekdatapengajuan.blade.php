@extends('layout.admin')
@section('content')


<ul class="nav nav-tabs">
<!--    <li>
        <button type="button" name="add_button" ng-click="addDataPenjaminan()" class="btn btn-primary">ADD PENJAMINAN</button>
    </li>  -->
</ul>

<body ng-app="Penjaminan" ng-controller="PenjaminanController">
    <div class="panel panel-default">
    <div class="panel-heading">
        <strong>
           <h2 align="center">DATA PENGAJUAN PENJAMINAN KREDIT</h2>
           <h2 align="center">({{$pengajuan[0]['namabank']}})</h2>
           <h2 style="color: red" align="center">BELUM VERIFIKASI</h2>
        </strong>
    </div>
    <div class="panel-body">
             <section  class="col-lg-13 connectedSortable">
        <!-- Map box -->
        <form method="post" name="form_validasi_bayar" action="{{url('simpanvalidasi')}}" enctype="multipart/form-data" >
           
            <div class="box box-solid" id="centang">
                <table id="tabelpembayaran" class=" table table-hover"  style="font-size: 11px;   border: 1px; border-color:  black"    >
                        <thead>
                            <tr style="width: 30px; background-color:#23527c ;color: white">
                                <th>No</th>
                                <th>Kode Bayar</th>
                                <th>Tgl Pengajuan</th>                           
                                <th>Tgl Bayar</th>                      
                                <th>Nama</th>                      
                                <!--<th>Umur</th>-->                      
                                <!--<th>Jns Kredit</th>-->
<!--                                <th>Realisasi</th>
                                <th>Tempo</th>                           -->
                                <th>Masa Kredit</th>                           
                                <th>Plafon</th>                           
                                <th>Rate</th>                           
                                <th>Gross IJP</th>                           
                                <th>Disc(Rp.)</th>                           
                                <!--<th>Nett</th>-->                           
                                <th>Jenis Penjaminan</th>                           
<!--                                <th>Adm</th>                           
                                <th>Materai</th>                           -->
                                <th>Nett Bayar</th>                           
                                <th>Aging</th>                       
                                <th>Dokumen</th>                       
                                <th>Status Bayar</th>                       
<!--                                <th>Proses</th>                           -->
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
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{$data -> kodebayar}}</td>
                                <td>{{date('d-m-Y', strtotime($data -> tglpengajuan))}}</td>    
                                <td>{{$bayar}}</td> 
                                <td>
                                    <a  style="margin: 5px;width: 80%; border-radius: 2px" class="btn btn-primary">
                                        {{$data -> nama}}
                                    </a>
                                    <a  style="margin: 5px;width: 80%; border-radius: 2px" class="btn btn-primary">
                                        Umur : {{$data -> umur}}
                                    </a> 
                                </td>                                                        
                                <!--<td>{{$data -> umur}}</td>-->                                                        
                                <!--<td>{{$data -> jeniskredit}}</td>-->
<!--                                <td>{{date('d-m-Y', strtotime($data -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($data -> tgljatuhtempo))}}</td>                            -->
                                <td>{{$data -> masakredit}} Bln</td>
                                <td>{{number_format($data -> plafon, 0, ',', '.')}}</td>
                                <td>{{$data -> rate}}</td>
                                <td>{{number_format($data -> premi, 0, ',', '.')}}</td>
                                <td>{{number_format($data -> pot, 0, ',', '.')}}</td>
                                <!--<td>{{number_format($data -> nett, 0, ',', '.')}}</td>-->
                                <td>
                                    <a  style="margin: 5px;width: 90%; border-radius: 2px" class="btn btn-primary">
                                        {{$data -> jeniskredit}}
                                    </a>
                                    <a  style=" font-size: 10px;margin: 5px;width: 90%; border-radius: 2px" class="btn btn-danger">
                                         {{$data -> jenispenjaminan}}
                                    </a> 
                                </td>
                                <!--<td>{{number_format($data -> admin, 0, ',', '.')}}</td>-->
                                <!--<td>{{number_format($data -> materai, 0, ',', '.')}}</td>-->
                                <td><b style="color:red">{{number_format($data -> nett+$data -> admin+$data -> materai, 0, ',', '.')}}</b></td>
                                <td>
                                    <b>Pengajuan:<p style="color: red;font-size: 15px">{{aging($data -> tglpengajuan) }} Hari</p></b>
                                    <b>Realisasi:<p style="color: red;font-size: 15px">{{aging($data -> tglrealisasi) }} Hari</p></b>  
                                </td> 
                                <td>
                                    <div class=" btn-group-vertical" >
                                        
                                             <b> <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary" target="_blank "  href="{{url('cetaksuratpengajuanadmin').'/'.$data->nosertifikat}}"  style="color: black">Cetak Surat Pengajuan</a></b>

                                             <b>  
                                                    <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary"  target="_blank "  
                                                        href=" 
                                                         @if($data->url_penjaminan!=null)
                                                         @if($data->url_file_bayar!=null)
                                                              <?php echo '/'.$data ->url_file_bayar.$data->file?>
                                                            @else
                                                             <?php echo '/'.$data ->url_penjaminan.$data->file?>
                                                            @endif
                                                       @else
                                                              {{url('/files/buktibayar').'/'.$data->file}}
                                                        @endif  " 
                                                        style="color: blue">Download Bukti Bayar</a> 
                                             </b>
                                           
                                            <b<?php if ($data->files == '' ) {echo 'hidden=""';} ?>><a style="margin: 5px ;width: 90% ; border-radius: 20px"  class="btn btn-success" target="_blank" href="@if($data->url_penjaminan!=null)<?php echo url( $data->url_penjaminan.$data->files)?> @else{{url('files/suratsehat').'/'.$data->files}}@endif">Download Surat Sehat</a></b> 
                                            <b <?php if ($data->files3 == '' ) {echo 'hidden=""';;} ?>><a style="margin: 5px ;width: 90% ; border-radius: 20px"  class="btn btn-danger"target="_blank" href="@if($data->url_penjaminan!=null)<?php echo url( $data->url_penjaminan.$data->files3)?> @else{{url('files/suratsehatrs').'/'.$data->files3}}@endif">Download Surat Sehat RS</a></b>
                                        </div>
                                </td>
                                <td>
                                    <div class="radio icheck-primary">
                                        <input  id="validasipembayaran{{$data->idpenjaminan}}" class="radio cekpembayaran" type="checkbox" name="bayar[{{$data ->idpenjaminan}}]" value="Ok" /> 
                                        <label for="validasipembayaran{{$data->idpenjaminan}}">SESUAI</label>
                                    </div>
                                </td>
<!--                             <td><a id="{{$data ->idpenjaminan}}" class="btn btn-xs btn-primary klickvalidasi">VERFIKASI</a></td>                         -->

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
                    <input  id="cekall" class="checkbox cekall" type="checkbox" name="bayar[{{$data ->idpenjaminan}}]" value="Ok" /> 
                    <label for="cekall">Pilih Semua</label>
                </div>
        </div>
        <br>
        <table class=" table table-hover" >
            <thead>
                <tr>
                   <td>Total Gros IJP</td>
                   <td align="right">{{number_format($premi, 0, ',', '.')}}</td>
                </tr>
                <tr>
                   <td>Total Fee</td>
                    <td align="right">{{number_format($dis, 0, ',', '.')}}</td>
                </tr>
                <tr>
                   <td>Total Nett IJP</td>
                   <td align="right">{{number_format($nett, 0, ',', '.')}}</td>
                </tr>
            </thead>
            
        </table>
             
              <input type="submit" name="submit" id="action" value="Simpan" class="btn btn-info" />
               {{csrf_field()}}
             </form>
       
    </section>  
    </div>
</div>
  @include('admin.modal')
</body>   
<br>
<br>
@endsection

