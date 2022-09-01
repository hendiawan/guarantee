@extends('layout.admin')
@section('content')


 
    <body ng-app="Penjaminan" ng-controller="PenjaminanController">
<div class="panel panel-default">
    <div class="panel-heading">
    <strong>
            <h2 align="center">PENGAJUAN PENJAMINAN KREDIT</h2>
            <h2 align="center" style="color:red">SUDAH DI SETUJUI</h2>
            <h2 align="center" style="color:red">BELUM TERBIT SERTIFIKAT</h2>
             
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
                                <th>PENERIMA JAMINAN</th> 
                                <th>NO KTP</th>
                                <th>TERJAMIN</th>                        
                                <th>TGL LAHIR</th>  
                                <th>TGL PENGAJUAN</th>                           
                                <th>TGL BAYAR</th>                           
                                <th>TGL VERIFIKASI</th>                           
                                <th>OLEH</th>  
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
                            @foreach($pengajuan as $datas)     
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{$datas->namabank}}</td>
                                <td>{{$datas->ktp}}</td>
                                <td>{{$datas->nama}}</td>
                                <td>{{date('d-m-Y', strtotime($datas->tgllahir))}}</td> 
                                <td>{{date('d-m-Y', strtotime($datas->tglpengajuan))}}</td>     
                                <td>{{date('d-m-Y', strtotime($datas->tglbayar))}}</td>     
                                <td>{{date('d-m-Y', strtotime($datas->tglanalisa))}}</td>     
                                <td>{{$datas->oleh}}</td>     
                          
                                  
                                <!--<td><a class="btn btn-primary btn-xs" href="/terbitkansertifikat/{{$datas ->nosertifikat}}">Terbitkan</a></td>-->                         
                                <td><a class="btn btn-primary btn-xs terbitkansertifikat" id="{{$datas ->idpenjaminan}}">Terbitkan</a></td>                         
                                                      

                            </tr>
                            <?php
                            $i++;
                            $premi = $premi + $datas->premi;
                            $dis = $dis + $datas->pot;
                            $nett = $nett + $datas->nett;
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
 
   
<br>
<br>

@if($i<2)

<script>
  alert('Silahkan  lanjut ke proses Cetak sertifikat');
                 window.location.href = "Cetaksertifikat";
</script>

@endif
 

@endsection

 