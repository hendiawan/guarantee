@extends('layout.admin')

@section('content')

    <div id="pengajuanbaru" class="tab-pane fade in active">
           <h3 align="center">LAPORAN PEJAMINAN KREDIT @if($jenis!='%'){{$jenis}}@endif</h3>
       
         <h3 align="center">(Periode {{date('d/m/Y',strtotime($dari))}} - {{date('d/m/Y',strtotime($sampai))}})</h3>
        <hr>
        <center>
        <table>
           <tr>
           <form method="post" action="cetaklaporanexceladmin">
               {{csrf_field()}}
                
               <input hidden="" name="bank" value="{{$bank}}">  
               <input hidden="" name="dari" value="{{$dari}}">  
               <input hidden="" name="sampai" value="{{$sampai}}">  
               <input hidden="" name="jenisKredit" value="{{$jenis}}"> 
               <input hidden="" name="jenislaporan" value="{{$app}}">
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
                                <th>BANK PENERIMA</th>  
                                <th>TOTAL PLAFON(Rp.)</th>
                                <th>TOTAL GROSS(Rp.)</th>
                                <th>TOTAL DISC(Rp.)</th>
                                <th>TOTAL NETT(Rp.)</th>
                                <th>TOTAL TERJAMIN</th> 
                                <th>ACTION</th>                           
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
                                <td>{{$datas->namabank}}</td>
                                <td align="right">{{number_format( $plafon=$datas->total_plafon, 2, ',', '.')}}</td>   
                                <td align="right">{{number_format( $gros=$datas ->total_premi, 2, ',', '.')}}</td>       
                                <td align="right">{{number_format( $disk=$datas ->total_pot, 2, ',', '.')}}</td>       
                                <td align="right">{{number_format( $nett=$datas ->total_nett, 2, ',', '.')}}</td>
                                <td align="center">{{$terjamin=$datas->total_terjamin}}</td>
                                <td align="center">
                                    <form method="post" action="detail_laporan_internal">
                                        {{csrf_field()}}
                                        <input hidden="" name="idbank" value="{{$datas->idbank}}">  
                                        <input hidden="" name="dari" value="{{date('Y/m/d',strtotime($dari))}}"> 
                                        <input hidden="" name="sampai" value="{{date('Y/m/d',strtotime($sampai))}}">  
                                        <input hidden="" name="jenislaporan" value="{{$app}}">
                                        <input hidden="" name="jenisKredit" value="{{$jenis}}">  
                                        <button type="submit" class="btn btn-danger btn-xs">  <span class="glyphicon glyphicon-print"></span>  Detail</button>                       
                                    </form> 
                                </td>
                            </tr>
                            
                             <?php 
                            $totalpenjaminan    =$totalpenjaminan+$plafon;
                            $totalgrossijp      =$totalgrossijp+$gros;
                            $totaldis           =$totaldis+$disk;
                            $totalnetijp        =$totalnetijp+$nett;
                            $totalterjamin      =$totalterjamin+$terjamin;
                            $i++ 
                             ?>
                            @endforeach
                            <tr style="background-color: #B0BEC5">
                                <td colspan="2">TOTAL</td> 
                                <td align='right'><b>{{number_format( $totalpenjaminan, 2, ',', '.')}}</b></td>
                                <td align='right'><b>{{number_format( $totalgrossijp, 2, ',', '.')}}</b></td>
                                <td align='right'><b>{{number_format( $totaldis, 2, ',', '.')}}</b></td>
                                <td align='right'><b>{{number_format( $totalnetijp, 2, ',', '.')}}</b></td>
                                <td align='center'><b>{{$totalterjamin}}</b></td>
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
     

 

