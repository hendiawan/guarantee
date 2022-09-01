@extends('layout.admin')
@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
        <strong><h2 align="center">DATA PENGAJUAN DITOLAK</h2></strong>
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
								<th>CATATAN</th>
							    <th>AGING</th>                
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

					   function aging($tanggal) {
													$tanggal1 = new DateTime($tanggal);
													$tanggal2 = new DateTime();
													return  $aging = $tanggal2->diff($tanggal1)->format("%a");
												}
																			
                             
                            ?>
                            @foreach($pengajuan as $datas)
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
                                <td>{{$datas -> catatan}}</td> 
                                <td><b><p style="color: red;font-size: 15px">{{aging($datas -> tglpengajuan) }}</p></b>Hari</td>   
                                <td>
                                    <div class=" btn-group-vertical">
                                        <button  data-toggle="tooltip" data-placement="top" title="Hapus data pengajuan"  id="{{$datas->idpenjaminan}}"   class="btn btn-danger  admindeletepenjaminan">Reject</button>
                                    </div>
                                </td>
                                <td>
                        <li  <?php
                        if ($datas->case == 'Ya') {
                            echo 'hidden=""';
                        }
                        ?>> <b> <a  target="_blank " href="{{URL::asset('files/buktibayar')}}{{'/'.$datas->file}}"  style="color: blue">Download Bukti Bayar</a></b></li>
                        <li> <b> <a target="_blank "  href="{{URL::asset('cetaksuratpengajuanadmin')}}{{'/'.$datas ->nosertifikat}}"  style="color: black">Cetak Surat Pengajuan</a></b></li>
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
 
<br>
<br>
@endsection

 