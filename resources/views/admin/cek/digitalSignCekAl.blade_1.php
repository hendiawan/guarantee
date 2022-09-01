@extends('layout.admin')
@section('content')


<body ng-app="Penjaminan" ng-controller="PenjaminanController">
     <div class="panel panel-default">
    <div class="panel-heading">
        <strong>
        <h2 align="center">DATA PENGAJUAN PENJAMINAN KREDIT</h2>
        <h2 style="color: red" align="center">BELUM TANDA TANGAN DIGITAL</h2>
        </strong>
    </div>
    <div class="panel-body">
             <section  class="col-lg-13 connectedSortable">
        <!-- Map box -->
    <form method="post"  action="{{url('PostSign')}}" enctype="multipart/form-data" >
        <div class="box box-solid" id="centang">
                <table id="tabelpembayaran" class=" table table-hover"  style="font-size: 11px;  border: 1px; border-color:  black"    >
                        <thead>
                            <tr style="width: 30px; background-color:#23527c ;color: #ffffff">
                                <th>No</th>
                                <th>Nama Bank</th>
                                <th>Tgl Pengajuan</th>                           
                                <th>Tgl Bayar</th>                      
                                <th>Nama Terjamin</th>                      
                                <th>Jns Kredit</th>
<!--                            <th>Tgl Realisasi</th>
                                <th>Tgl Jth Tempo</th>                           -->
                                <th>Masa Kredit</th>                           
                                <th>Plafon</th>                          
                                <th>Aging</th>                     
                                <th>Doc.</th>       
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
                             
                            
                            
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                              
                                <td>{{$data -> namabank}}</td>  
                                <td>{{date('d-m-Y', strtotime($data -> tglpengajuan))}}</td>    
                                <td>{{$bayar}}</td> 
                                <td>{{$data -> nama}}</td>                                                        
                                <td>{{$data -> jeniskredit}}</td>
<!--                                <td>{{date('d-m-Y', strtotime($data -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($data -> tgljatuhtempo))}}</td>                            -->
                                <td>{{$data -> masakredit}} Bln</td>
                                <td>{{number_format($data -> plafon, 0, ',', '.')}}</td>
                               
                                <td><b><p style="color: red;font-size: 15px">{{aging($data -> tglpengajuan) }}</p></b>Hari</td>                    
                                <td><a href="cetaksuratpengajuanadmin/{{$data ->nosertifikat}}"  style="color: black"><b>Cetak Surat Pengajuan</b></a></td>                    
                                <td>
                                    <div class="radio icheck-primary">
                                        <input required=""  id="validasipembayaran{{$data->idpenjaminan}}" class="radio cekpembayaran" type="checkbox" name="proses[{{$data ->idpenjaminan}}]" value="Ok" /> 
                                        <label for="validasipembayaran{{$data->idpenjaminan}}">PROSES</label>
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
                    <label for="cekall">Pilih Semua</label>
                </div>
        </div>
        <!--<td><a id="{{$data->nosertifikat}}" class="btn btn-primary Sign">PROSES TTD</a></td>-->      
        <input type="submit" name="submit" id="action" value="Simpan" class="btn btn-info" />
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

 