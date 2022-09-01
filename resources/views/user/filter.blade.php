
@extends('layout.user')
@section('content')

<style>
    table  th {
        color: white
    }
</style>

    <div id="pengajuanbaru" class="tab-pane fade in active">
        @if($jenis=='%')
           <h3 align="center">REKAP PEJAMINAN KREDIT </h3>
        @else
           <h3 align="center">REKAP PEJAMINAN KREDIT {{$jenis}}</h3>
        @endif
        
     
        <h5 align="center"><b>@if(isset($data[0]['namabank'])){{$data[0]['namabank']}}@endif</b></h5>
<!--        <h5 align="center"><b>@if(isset($data[0]['alamat'])){{$data[0]['alamat']}}@endif</b></h5>-->
        <h2 align="center">(Periode {{date('d/m/Y',strtotime($dari))}} - {{date('d/m/Y',strtotime($sampai))}})</h2>
        <hr>
        <center>
            <table>
            <tr>
            <form method="post" action="cetaklaporanpdf">
                {{csrf_field()}}
                <input hidden="" name="dari" value="{{$dari}}">  
                <input hidden="" name="sampai" value="{{$sampai}}">  
                <input hidden="" name="jenisKredit" value="{{$jenis}}"> 
                <input hidden="" name="jenislaporan" value="{{$app}}">
                <button  type="submit" class="btn btn-danger btn-xs">Cetak PDF <span class="glyphicon glyphicon-print"></span> </button>                       
            </form> 
           </tr>
<!--           <tr>
           <form method="post" action="cetaklaporanexcel">
               {{csrf_field()}}
               <input hidden="" name="dari" value="{{$dari}}">  
               <input hidden="" name="sampai" value="{{$sampai}}">  
               <input hidden="" name="jenisKredit" value="{{$jenis}}"> 
               <input hidden="" name="jenislaporan" value="{{$app}}">
               <button  type="submit" class="btn btn-danger btn-xs">  <span class="glyphicon glyphicon-print"></span>  Cetak EXCEL</button>                       
           </form> 
           </tr>-->
        </table>
        </center> 
        
        <hr>  
        <body ng-app="Penjaminan" ng-controller="PenjaminanController">
            <section  class="col-lg-13 connectedSortable">
                <!-- Map box -->
                <div class="box box-solid">
                    
                    <table class="table table-hover"  style="font-size: 11px;border: 1px; border-color:  black" >
                        <thead>
                            <tr style="background-color:#23527c ;color: #000000">
                                <th style="color:white">NO</th>
                                <th>PENGAJUAN</th>                           
                                <th>NO SERTIFIKAT</th>
                                 <th>NO PK</th>
                                <th>NAMA </th>                        
                                <th>JENIS </th>                        
                                <th>TGL LAHIR</th>                        
                                <th>UMUR</th>
                                <th>PEKERJAAN</th>
                                <th>TGL MULAI</th>
                                <th>SAMPAI TGL</th>                           
                                <th>JML</th>                                
                                <th align="center">PLAFON</th> 
                                <th>GROSS IJP</th>
                                <th>DISC</th>
                                <th>NETT</th>
                                <th>STATUS</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            $totalpenjaminan=0;
                            $totalgrossijp=0;
                            $totaldis=0;
                            $totalnetijp=0;
                            function aging($tanggal) {
                                $tanggal1 = new DateTime($tanggal);
                                $tanggal2 = new DateTime();
                                return  $aging = $tanggal2->diff($tanggal1)->format("%a");
                            }
                            ?>
                            @foreach($data as $datas)
                            
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{date('d-m-y', strtotime($datas->tglpengajuan))}}</td>     
                                <td>{{$datas->kodesertifikat}}</td>
                                <td>{{$datas->nopk}}</td>     
                                <td>{{$datas->terjamin->nama}}</td>
                                <td>{{$datas->jeniskredit}}</td>
                                <td>{{date('d-m-y', strtotime($datas->terjamin->tgllahir))}}</td> 
                                <td>{{$datas->terjamin->umur}}</td>
                                <td>{{strtoupper($datas->terjamin->pekerjaan)}}</td>
                                <td>{{date('d-m-y', strtotime($datas->tglrealisasi))}}</td> 
                                <td>{{date('d-m-y', strtotime($datas->tgljatuhtempo))}}</td> 
                                <td>{{$datas ->masakredit}}-Bln</td>     
                                <td  align="right">{{number_format( $datas ->plafon, 0, ',', '.')}}</td>     
                                <td align="right">{{number_format( $datas ->premi, 0, ',', '.')}}</td>       
                                <td align="right">{{number_format( $datas ->pot, 0, ',', '.')}}</td>       
                                <td align="right">{{number_format( $datas ->nett, 0, ',', '.')}}</td>  
                                <td>{{strtoupper($datas->app)}}</td>
                           
                            </tr>
                            
                            <?php 
                            $totalpenjaminan=$totalpenjaminan+$datas ->plafon;
                            $totalgrossijp=$totalgrossijp+$datas ->premi;
                            $totaldis=$totaldis+$datas ->pot;
                            $totalnetijp=$totalnetijp+$datas ->nett;
                            $i++ 
                             ?>
                            @endforeach
                            <tr>
                                <td>TOTAL</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>   
                                <td align='right'><b>{{number_format( $totalpenjaminan, 2, ',', '.')}}</b></td>
                                <td></td>
                                <td align='right'><b>{{number_format( $totalgrossijp, 2, ',', '.')}}</b></td>
                                <td align='right'><b>{{number_format( $totaldis, 2, ',', '.')}}</b></td>
                                <td align='right'><b>{{number_format( $totalnetijp, 2, ',', '.')}}</b></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </section>
        </body>                
    </div>
<br>
@endsection
