@extends('layout.user')
@section('content')
<body ng-app="Penjaminan" ng-controller="PenjaminanController">
<div class=""> 
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong><i class="glyphicon glyphicon-menu-right"></i>Revisi Pengajuan</strong>
        </div>
        <div class="panel-body">
                 <table id="tabelpembayaran" class=" table table-hover"  style="font-size: 12px; border: 1px; border-color:  black"    >
                        <thead>
                            <tr style="width: 30px; background-color:#23527c ; color: #ffffff">
                                <th>NO</th> 
                                <th>TGL PENGAJUAN</th>                         
                                <th>TGL APPROVAL</th>                         
                                <th>NAMA</th>                      
<!--                                <th>JNS KREDIT</th>-->
<!--                                <th>MULAI TGL</th>
                                <th>SAMPAI TGL</th>                           -->
<!--                                <th>MASA KREDIT</th>                           -->
                                <th>PLAFON</th>
<!--                                <th>JNS PENJAMINAN</th> -->
<!--                                <th>STATUS</th>                           -->
                                <th>PEMOHON</th> 
                                <th>NET IJP</th> 
                                @if(Session::get('level')!='User')
                                    <th>DOKUMEN</th>   
                                    <th style="color: #ffffff">CATATAN</th>  
                                    <th>ACTION</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i                = 1;
                                $premi     = 0;
                                $dis            = 0;
                                $nett          = 0;    
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
<!--                                <td>{{date('d-m-Y', strtotime($datas -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tgljatuhtempo))}}</td>                            -->
<!--                                <td>{{$datas -> masakredit}} Bulan</td>-->
                                <td>{{number_format($datas -> plafon, 0, ',', '.')}}</td>
<!--                                <td>{{$datas -> jenispenjaminan}}</td>                           -->
                                <!--<td>@if($datas -> app=='Tolak') <span class="label label-danger"> <i class="glyphicon glyphicon-remove">&nbsp;{{$datas -> app}}</i></span>@endif </td>-->
                               <?php 
                                  $kalimat =$datas->nosertifikat;
                                  $posisi = strpos($kalimat,"RGJNBSYS");
                                    if ($posisi!== FALSE) 
                                    { 
                                             $hidden=''; 
                                    }
                                    else
                                    {
                                            if($datas->statusbayar==1){
                                                 $hidden=''; 
                                            }else{
                                                 $hidden='hidden=""';
                                            } 
                                    }  
                                ?> 
                                <td>{{$datas -> pemohon}}</td>
                                <td>{{number_format($datas -> nett, 0, ',', '.')}}</td>
                                @if(Session::get('level')!='User')
                               <td>
                                   @if ($datas->case=="Ya")
                                   <div> 
                                       <li <?php if ($datas->files == '' ) {echo 'hidden=""';} ?>><a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary"  target="_blank"  href="  @if($datas->url_penjaminan!=null) <?php echo url( $datas->url_penjaminan.$datas->files)?> @else files/suratsehat/{{$datas -> files}} @endif">Surat Sehat</a></li>
                                       <li> <b style="color: red"> <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary uploadsuratsehat"  href=""  id="{{$datas -> idpenjaminan}}" style="color: red">Upload Surat Sehat</a></b></li>
                                       <li <?php if ($datas->files3 == '' ) {echo 'hidden=""';$hide='true';}else{$hide='';} ?> > <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary"   target="_blank"  href="@if($datas->url_penjaminan!=null) <?php echo url( $datas->url_penjaminan.$datas->files3)?> @else files/suratsehatrs/{{$datas -> files3}} @endif">Ket. Sehat</a></li>
                                       <li <?php if ($datas->plafon<100000000) { echo 'hidden=""';} ?>> <b style="color: red;"> <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary uploadsuratsehatRs" href=""   id="{{$datas -> idpenjaminan}}" style="color: red">Upload Surat Sehat RS</a></b></li>
                                       <li <?php if ($datas->files2 == '') { echo 'hidden=""';} ?>><a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary"   target="_blank"  href="@if($datas->url_penjaminan!=null) <?php echo url( $datas->url_penjaminan.$datas->files2)?> @else files/scanlab/{{$datas -> files2}} @endif">Cek Lab</a></li>
                                       <li <?php if ($datas->plafon<200000000) { echo 'hidden=""';} ?>><b><a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary uploadscanlab"  href="" id="{{$datas -> idpenjaminan}}" style="color: green">Upload Scan Lab</a></b></li>
                                      @if($datas->statusbayar=='1')
                                        <li><a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary"   target="_blank"  href=" @if($datas->url_penjaminan!=null) <?php echo url( $datas->url_penjaminan.$datas->file)?> @else /files/buktibayar/{{$datas ->file}} @endif">Bukti Bayar</a></li>
                                       <li><b style="color: red"> <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary uploadbuktibayar" href=""  id="{{$datas->idpenjaminan}}" style="color: red">Upload Bukti Bayar</a></b> </li>
                                       @endif
                                   </div>
                                   @else
                                   <div>
                                       <li <?php if ($datas->files == '' ) {echo 'hidden=""';} ?>><a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary"  target="_blank"  href="  @if($datas->url_penjaminan!=null) <?php echo url( $datas->url_penjaminan.$datas->files)?> @else files/suratsehat/{{$datas -> files}} @endif">Surat Sehat</a></li>
                                       <li> <b style="color: red"> <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary uploadsuratsehat"  href=""  id="{{$datas -> idpenjaminan}}" style="color: red">Upload Surat Sehat</a></b></li>
                                       <li <?php if ($datas->files3 == '' ) {echo 'hidden=""';$hide='true';}else{$hide='';} ?> > <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary"   target="_blank"  href="@if($datas->url_penjaminan!=null) <?php echo url( $datas->url_penjaminan.$datas->files3)?> @else files/suratsehatrs/{{$datas -> files3}} @endif">Ket. Sehat</a></li>
                                       <li <?php if ($datas->plafon<100000000) { echo 'hidden=""';} ?>> <b style="color: red;"> <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary uploadsuratsehatRs" href=""   id="{{$datas -> idpenjaminan}}" style="color: red">Upload Surat Sehat RS</a></b></li>
                                       <li <?php if ($datas->files2 == '') { echo 'hidden=""';} ?>><a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary"   target="_blank"  href="@if($datas->url_penjaminan!=null) <?php echo url( $datas->url_penjaminan.$datas->files2)?> @else files/scanlab/{{$datas -> files2}} @endif">Cek Lab</a></li>
                                       <li <?php if ($datas->plafon<200000000) { echo 'hidden=""';} ?>><b><a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary uploadscanlab"  href="" id="{{$datas -> idpenjaminan}}" style="color: green">Upload Scan Lab</a></b></li>
                                       <li><a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary"   target="_blank"  href=" @if($datas->url_penjaminan!=null) <?php echo url( $datas->url_penjaminan.$datas->file)?> @else /files/buktibayar/{{$datas ->file}} @endif">Bukti Bayar</a></li>
                                       <li><b style="color: red"> <a  style="margin: 5px;width: 90%; border-radius: 20px" class="btn btn-primary uploadbuktibayar" href=""  id="{{$datas->idpenjaminan}}" style="color: red">Upload Bukti Bayar</a></b> </li>
                                    </div>
                                  @endif
                               </td>
                               <td>
                                   <div class="panel panel-heading">
                                       <b>
                                       @if($datas ->case=='Ya')
                                            @if($datas ->statusbayar=='1')
                                                {{$datas -> catatan}}
                                            @else
                                                 @if($datas->tanggapandir==null)
                                                 {{$datas -> hasil_akhir}}
                                                 @else
                                                 {{$datas -> tanggapandir}}
                                                 @endif
                                            @endif
                                        @else
                                                {{$datas -> catatan}}
                                        @endif
                                      </b>
                                   </div> 
                                </td>  
                                <td>
                                    <!--<button   data-toggle="tooltip" data-placement="top" title="ajukan lagi" id="{{$datas->idpenjaminan}}"  type="button" class="btn btn-warning ajukankembali"><a class="glyphicon glyphicon-refresh"></a> Ajukan Kembali</button>--> 
                                   <a href="/detailPenjaminanBank/{{$datas->idpenjaminan}}"class="btn btn-xs btn-danger ">DETAIL</a>
                                </td>  
                                @endif
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
@include('user.modalajukanlagi')
@include('user.modal')
</body>

@endsection
