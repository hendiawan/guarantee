@extends('layout.admin')

@section('content')

    <div id="pengajuanbaru" class="tab-pane fade in active">
           <h3 align="center">LAPORAN PEJAMINAN KREDIT @if($jenis!='%'){{$jenis}}@endif</h3>
           <h3 align="center">{{$namabank}}</h3>
       
         <h3 align="center">(Periode {{date('d/m/Y',strtotime($dari))}} - {{date('d/m/Y',strtotime($sampai))}})</h3>
        <hr>
        <center>
        <table>
           <tr>
           <form method="post" action="detail_laporan_internal_excel">
               {{csrf_field()}}
               <input hidden="" name="idbank" value="{{$bank}}">  
               <input hidden="" name="dari" value="{{date('Y/m/d',strtotime($dari))}}">  
               <input hidden="" name="sampai" value="{{date('Y/m/d',strtotime($sampai))}}">  
               <input hidden="" name="jenisKredit" value="{{$jenis}}"> 
               <input hidden="" name="namabank" value="{{$namabank}}"> 
               <input hidden="" name="jenislaporan" value="{{$jenislaporan}}"> 
               <button  type="submit" class="btn btn-danger btn-xs">  <span class="glyphicon glyphicon-print"></span>  Cetak EXCEL</button>                       
           </form> 
           </tr>
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
                                <th>NO</th>     
                                <th>NOMOR SERTIFIKAT</th>  
                                <th>NAMA TERJAMIN</th>
                                <th>TGL REALISASI</th>
                                <th>JATUH TEMPO</th>
                                <th>TGL TERBIT</th>
                                <th>PLAFON(Rp.)</th>
                                <th>RATE(%)</th>
                                <th>GROSS IJP(Rp.)</th> 
                                <th>DISCOUNT(Rp.)</th> 
                                <th>NETT IJP(Rp.)</th>                           
                          </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            $totalpenjaminan=0;
                            $totalgrossijp=0;
                            $totaldis=0;
                            $totalnetijp=0;
                            $totalterjamin=0; 
                            ?>
 
                            @foreach($data as $datas) 
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>  
                                <td>{{$datas->kodesertifikat}}</td>
                                <td>{{$datas->nama}}</td>
                                <td align="center">{{date('d-m-Y',strtotime($datas->tglrealisasi))}}</td>   
                                <td align="center">{{date('d-m-Y',strtotime($datas->tgljatuhtempo))}}</td>   
                                <td align="center">{{date('d-m-Y',strtotime($datas->tglterbit))}}</td>   
                                <td align="right">{{number_format($plafon=$datas->plafon, 2, ',', '.')}}</td>   
                                <td align="center">{{$datas->rate}}</td>   
                               <td align="right">{{number_format($gros=$datas->premi, 2, ',', '.')}}</td>   
                               <td align="right">{{number_format($pot=$datas->pot, 2, ',', '.')}}</td>   
                               <td align="right">{{number_format($nett=$datas->nett, 2, ',', '.')}}</td>   

                            </tr>
                            
                             <?php 
                            $totalpenjaminan    =$totalpenjaminan+$plafon;
                            $totalgrossijp      =$totalgrossijp+$gros;
                            $totaldis           =$totaldis+$pot;
                            $totalnetijp        =$totalnetijp+$nett;
                          
                            $i++ 
                             ?>
                            @endforeach
                            <tr style="background-color: #B0BEC5">
                                <td colspan="5">TOTAL</td> 
                                <td align='right'><b>{{number_format( $totalpenjaminan, 2, ',', '.')}}</b></td>
                                <td align='right'><b></b></td>
                                <td align='right'><b>{{number_format( $totalgrossijp, 2, ',', '.')}}</b></td>
                                <td align='right'><b>{{number_format( $totaldis, 2, ',', '.')}}</b></td>
                                <td align='right'><b>{{number_format( $totalnetijp, 2, ',', '.')}}</b></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </section>
        </body>                
    </div>
<br>
@endsection
     

 

