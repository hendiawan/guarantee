@extends('layout.user')
@section('content')


<body ng-app="Penjaminan" ng-controller="PenjaminanController">
<div class="">
    
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong><i class="glyphicon glyphicon-menu-right"></i> Pengajuan Di Tolak</strong>
        </div>
        <div class="panel-body">
                 <table id="tabelpembayaran" class=" table table-hover"  style="font-size: 12px; border: 1px; border-color:  black"    >
                        <thead>
                            <tr style="width: 30px; background-color:#23527c ;color: #000000">
                                <th>NO</th> 
                                <th>TGL PENGAJUAN</th>                         
                                <th>TGL APPROVAL</th>                         
                                <th>NAMA</th>                      
<!--                                <th>JNS KREDIT</th>-->
                                <th>MULAI TGL</th>
                                <th>SAMPAI TGL</th>                           
<!--                                <th>MASA KREDIT</th>                           -->
                                <th>PLAFON</th>
<!--                                <th>JNS PENJAMINAN</th> -->
                                <th>STATUS</th>                           
                                <!--<th>CATATAN</th>-->  
                                <th>PEMOHON</th> 
                                <th>NET IJP</th> 
                                <th>ALASAN TOLAK</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $premi = 0;
                            $dis = 0;
                            $nett = 0;    
                            ?>
                            @foreach($ditolak as $datas)
                            <?php
                          
                            if($datas -> tglanalisa==null){
                                $tglanalisa=$datas -> tglpengajuan;
                            }else{
                                $tglanalisa=$datas -> tglanalisa;
                            }
                            ?>
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tglpengajuan))}}</td> 
                                <td>{{date('d-m-Y', strtotime($tglanalisa))}}</td> 
                                <td>{{$datas -> nama}}</td>                                                        
<!--                                <td>{{$datas -> jeniskredit}}</td>-->
                                <td>{{date('d-m-Y', strtotime($datas -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tgljatuhtempo))}}</td>                            
<!--                                <td>{{$datas -> masakredit}} Bulan</td>-->
                                <td>{{number_format($datas -> plafon, 0, ',', '.')}}</td>
<!--                                <td>{{$datas -> jenispenjaminan}}</td>                           -->
                                <td>@if($datas -> app=='Tolak') <span class="label label-danger"> <i class="glyphicon glyphicon-remove">&nbsp;{{$datas -> app}}</i></span>@endif </td>
                                
                                <td>{{$datas -> pemohon}}</td>
                                <td>{{number_format($datas -> nett, 0, ',', '.')}}</td>
                                <td>{{$datas -> catatan}}</td>
 
                            </tr>
                            <?php
                            $i++;
                             
                            ?>
                            @endforeach
                        </tbody>
                    </table>
        </div>
    </div>
</div>
    
 
</body>

@endsection
