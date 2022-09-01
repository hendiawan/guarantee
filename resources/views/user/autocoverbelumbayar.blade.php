@extends('layout.user')
@section('content')


<body ng-app="Penjaminan" ng-controller="PenjaminanController">
 <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
<!--                <h2 align="center">PENGAJUAN PENJAMINAN KREDIT</h2>-->
                <h2 style="color: red" align="center">SILAHKAN MELAKUKAN PEROSES PEMBAYARAN UNTUK DATA DI BAWAH</h2>
            </strong>
        </div>
        <div class="panel-body">
             <table class="table table-hover"  style="font-size: 11px;border: 1px; border-color:  black" id="tabelpenjaminan"  >
                        <thead>
                            <tr style="background-color:#23527c ;color: #000000">
                                <th>No</th>
                                <th>Tgl Pengajuan</th>                           
<!--                                <th>No KTP</th>-->
                                <th>Nama</th>                        
                                <th>Umur</th>                     
                                <th>Jenis Kredit</th>
<!--                                <th>Realisasi</th>
                                <th>Tempo</th>                           -->
                                <th>Plafon</th>                                
<!--                                <th>Penjaminan</th>-->
                                <th>Rate</th>
                                <th>Gross IJP</th>                         
                                <th>Dis(Rp.)</th>
                                <th>Net IJP</th>
                                <th>Admin</th>
                                <th>Materai</th>
                                <th>Tot Bayar</th>
                                <th>Aging</th>
                                <th>Dok</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            

                            $i = 1;

                            function aging($tanggal) {
                                $tanggal1 = new DateTime($tanggal);
                                $tanggal2 = new DateTime();
                                return $aging = $tanggal2->diff($tanggal1)->format("%a");
                            }
                            ?>
                            @foreach($data as $datas)

                                
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tglpengajuan))}}</td>     
<!--                                <td>{{$datas -> ktp}}</td>-->
                                <td>{{$datas -> nama}}</td>
                                <td>{{$datas -> umur}}</td>                           
                                <td>{{$datas -> jeniskredit}}</td>
<!--                                <td>{{date('d-m-Y', strtotime($datas -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tgljatuhtempo))}}</td>                            -->
                                <td align="right">{{number_format($datas -> plafon, 2, ',', '.')}}</td>                                  
                                <td align="right">{{number_format($datas -> rate, 2, ',', '.')}}</td>                                  
                                <td align="right">{{number_format($datas -> premi, 2, ',', '.')}}</td>                                  
                                <td align="right">{{number_format($datas -> pot, 2, ',', '.')}}</td>                                  
                                <td align="right">{{number_format($datas -> nett, 2, ',', '.')}}</td>                                  
                                <td align="right">{{number_format($datas -> admin, 2, ',', '.')}}</td>                                  
                                <td align="right">{{number_format($datas -> materai, 2, ',', '.')}}</td>                                  
                                <td align="right">{{number_format($datas -> nett+$datas -> admin+$datas -> materai, 2, ',', '.')}}</td>                                  
                                <!--<td>{{$datas -> jenispenjaminan}}</td>-->
                                <td><b><p style="color: red;font-size: 15px">{{aging($datas -> tglpengajuan)}}</p></b>Hari</td>
                                <td>
                                    <a <?php
                                    if ($datas->files == '') {
                                        echo 'hidden=""';
                                        $hide = 'true';
                                    } else {
                                        $hide = '';
                                    }
                                    ?> href="files/suratsehat/{{$datas -> files}}">Download Surat Sehat</a>
                                    <a <?php
                                    if ($datas->files2 == '') {
                                        echo 'hidden=""';
                                    }
                                    ?> href="files/scanlab/{{$datas -> files2}}">Download Cek Lab</a>  
                                    <b style="color: red;"> <a href="" class="uploadsuratsehat" id="{{$datas -> idpenjaminan}}" style="color: red">Upload Surat Sehat</a></b></td>
                                <td>
                                    <div class=" btn-group-vertical">
                                     
                                        <a ng-hide="{{$hide}}" href="/prosesbayarauto/{{ Crypt::encrypt($datas -> nosertifikat)}}" class="btn btn-primary btn-xs">Bayar</a>
                                    </div>
                                </td>
                            </tr>
                            <?php $i++ ?>
                            @endforeach
                        </tbody>
                    </table>
        </div>
    </div>
    @include('user.modal')
</body>

@endsection


