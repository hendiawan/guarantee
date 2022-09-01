@extends('layout.user')
@section('content')


<body ng-app="Penjaminan" ng-controller="PenjaminanController">
<div class="panel panel-default">
        <div class="panel-heading">
            <strong><i class="glyphicon glyphicon-menu-right"></i> Pengajuan Penjaminan Sudah Dapat Cetak Sertifikat</strong>
        </div>
        <div class="panel-body">
              <table id="tabelSetuju" class=" table table-hover"  style="font-size: 12px;  margin-left: 0%; border: 1px; border-color:  black"    >
                        <thead>
                            <tr style="width: 30px; background-color:#23527c ;color: #000000">
                                <th>No</th>
                                <th>Kode Pengajuan</th>
                                <th>Pengajuan</th>                         
                                <th>Nama Terjamin</th>                      
                                <th>Jenis Kredit</th>
                                <th>Tgl Realisasi</th>
                                <th>Tgl Jatuh Tempo</th>                           
                                <th>Masa Kredit</th>                           
                                <th>Plafon</th> 
                                <th>Sertifikat</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            use App\penjaminans;
                            use Illuminate\Support\Facades\Session;
                            
                                    penjaminans::where('app', 'Cetak')
                                    ->where('statusbayar', 1)
                                    ->where('cek', '0')
                                    ->where('penjaminans.idbank', session::get('idbank'))
                                    ->update([
                                        'cek' => '1',
                                    ]);

                            $i = 1;
                            $premi = 0;
                            $dis = 0;
                            $nett = 0;                            
                             
                            ?>
                            @foreach($sertifikat as $datas)
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{$datas -> nosertifikat}}</td>                               
                                <td>{{date('d-m-Y', strtotime($datas -> tglpengajuan))}}</td>     
                                 
                                <td>{{$datas -> nama}}</td>                                                        
                                <td>{{$datas -> jeniskredit}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tgljatuhtempo))}}</td>                            
                                <td>{{$datas -> masakredit}} Bulan</td>
                                <td>{{number_format($datas -> plafon, 0, ',', '.')}}</td>
                                <td><a target="_blank"href="/cetakpdf/{{$datas ->nosertifikat}}"><span class="label label-success"> <i class="glyphicon glyphicon-print"></i> Cetak</span></td> 
                              </tr>
                            <?php
                            $i++;
                             
                            ?>
                            @endforeach
                        </tbody>
                    </table>
        </div>
    </div>
</body>

@endsection
