@extends('layout.admin')
@section('content')


<div class="container">
    <body ng-app="Penjaminan" ng-controller="PenjaminanController">
<div class="panel panel-default">
    <div class="panel-heading">
        <strong>
            <h2 align="center">PENGAJUAN PENJAMINAN KREDIT</h2>
            <h2 align="center" style="color:red">SUDAH DI SETUJUI</h2>
            <h2 align="center">({{$pengajuan[0]['namabank']}})</h2>
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
                                <th>KODE PENGAJUAN</th>                           
                                <th>TGL PENGAJUAN</th>                           
                                <th>TGL VERIFIKASI</th>                      
                                <th>NAMA</th>                      
                                <th>TGL LAHIR</th>  
                                <th>UMUR</th>  
                                <th>JENIS KREDIT</th>  
                                <th>SERTIFIKAT</th>                                                   
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
                                <td>{{$data -> nosertifikat}}</t>
                                <td>{{date('d-m-Y', strtotime($data -> tglpengajuan))}}</td>    
                                <td>{{date('d-m-Y', strtotime($data -> tglanalisa))}}</td> 
                                <td>{{$data -> nama}}</td> 
                                <td>{{date('d-m-Y', strtotime($data -> tgllahir))}}</td> 
                                <td>{{$data -> umur}}</td>
                                <td>{{$data -> jeniskredit}}</td>
                                <!--<td><a class="btn btn-primary btn-xs" href="/terbitkansertifikat/{{$data ->nosertifikat}}">Terbitkan</a></td>-->                         
                                <td><a class="btn btn-primary btn-xs terbitkansertifikat" id="{{$data ->idpenjaminan}}">Terbitkan</a></td>                         

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
 @include('admin.modalsertifikat')
     
</body>
</div>
   
<br>
<br>
@endsection

 