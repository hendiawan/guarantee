@extends('layout.admin')
@section('content') 
<div class="container-fluid ">
<div class="panel panel-default">
    <div class="panel-heading">
        <strong><h2 align="center">PENGAJUAN PENJAMINAN KREDIT</h2></strong>
    </div>
    <div class="panel-body">
             <section  class="col-lg-13 connectedSortable">
        <!-- Map box -->
        <div class="box box-solid">         
           <table id="tabelpembayaran" class=" table table-hover"  style="font-size: 12px;  margin-left: -1%; border: 1px; border-color:  black"    >
                        <thead>
                            <tr style="width: 30px; background-color:#23527c ;color: #000000">
                                <th>No</th> 
                                <th>PENERIMA JAMINAN</th> 
                                <th>TGL PENGAJUAN</th> 
                                <th>PLAFON</th> 
                                <th>TERJAMIN</th>                      
                                <th>JENIS KREDIT</th>
                                <th>MULAI</th>
                                <th>AKHIR</th>                           
                                <th>LAMA(Bln)</th>              
                                <th>STATUS</th>                           
                                <th>AGING</th>                           
                                <th>CATATAN</th> 
                                <th>APPROV BY</th> 
                                <th>NETT IJP</th> 
                                <th>DOKUMEN</th> 
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
                                <td>{{$i}}</td>
                                <td>{{$datas -> namabank}}</td>   
                                <td><p style="color: red;font-size: 15px">{{date('d-m-Y', strtotime($datas -> tglpengajuan))}}</p></td>     
                                <td>{{number_format($datas->plafon, 0, '.', ',')}}</td>                                                       
                                <td>{{$datas -> nama}}</td>                                                        
                                <td>{{$datas -> jeniskredit}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tgljatuhtempo))}}</td>                            
                                <td>{{$datas -> masakredit}} Bulan</td>                                                       
                                <td>
                                    @if($datas -> app=='Revisi') 
                                    <span class="label label-warning"> <i class="glyphicon glyphicon-remove">&nbsp;{{$datas -> app}}</i>
                                    </span>
                                    @else
                                     <span class="label label-success"> <i class="glyphicon glyphicon-remove">&nbsp;{{$datas -> app}}</i>
                                    </span>
                                    @endif 
                                </td>
                                <td><b><p style="color: red;font-size: 15px">{{aging($datas -> tglpengajuan) }}</p></b>Hari</td>                    
                                <td>
                                      <div class="panel panel-heading">
                                         @if($datas->case=='Ya')
                                         {{$datas -> hasil_akhir}}
                                         @else
                                         {{$datas -> catatan}}
                                         @endif
                                         </div>
                                     </td> 
                                <td>{{$datas -> oleh}}</td>
                                <td>{{number_format($datas->nett, 0, '.', ',')}}</td>   
                                <td>
                                            <li  <?php if($datas ->case=='Ya'){echo 'hidden=""';} ?>> <b> <a  target="_blank " href="{{URL::asset('files/buktibayar')}}{{'/'.$datas->file}}"  style="color: blue">Download Bukti Bayar</a></b></li>
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
</div>
<br>
<br>
@endsection

 