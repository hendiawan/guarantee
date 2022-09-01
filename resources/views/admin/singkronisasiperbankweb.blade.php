@extends('layout.admin')
@section('content')
<body ng-app="Penjaminan" ng-controller="PenjaminanController">
      
       <section  class="col-lg-13 connectedSortable">
            <!-- Map box -->
            <div class="box box-solid">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><i class="glyphicon glyphicon-"></i>    <h2 align="center">REKAP PENJAMINAN</h2> </strong>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="filter-sertifikat-web">
                            {{csrf_field()}}
                            <table>
                                <tr>
                                  
                                    <th style="width:20% ">Dari</th>
                                    <th style="width:20% ">Sampai</th>
                                  
                                </tr>
                                <tr> 
                                    
                                    <th> 
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-time">
                                                </i>
                                            </div>
                                            <input required="" value="{{old('dari')}}"   id="dari"  name="dari"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                                        </div>
                                    </th>

                                    <th> 
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-time">
                                                </i>
                                            </div>
                                            <input required="" value="{{old('sampai')}}"   id="sampai"  name="sampai"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                                        </div>
                                    </th>
                                   
                                    <th>
                                        <br>
                                        <div class="input-group">
                                            <td><button  type="submit" class="btn btn-danger btn-xs">Filter</button></td>
                                        </div>
                                    </th>
                                </tr>                
                            </table>
                        </form>       
                    </div>
                    <div class="panel-footer">
                        
                    </div>
                </div>
               
            </div>
            
        </section>
        <?php
                                $i      = 1;
                                $premi  = 0;
                                $dis    = 0;
                                $nett   = 0;
                                
                                if(isset($dari))
                                {
                                    $dari;
                                }
                                else
                                {
                                    $dari=date('Y-m-1');
                                }
                                
                                if(isset($sampai))
                                {
                                    $sampai;
                                }
                                else
                                {
                                    $hariini= date('Y-m-d');
                                    $sampai=date('Y-m-t');
                                }
                                        
                                
                                ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <h2 align="center">SINGKRONISASI</h2>
                    <h2 style="color:red" align="center">DATA PENJAMINAN SUDAH TERBIT SERTIFIKAT PERIODE {{date('d-m-Y',strtotime($dari))}} S/D {{date('d-m-Y',strtotime($sampai))}}</h2>
                </strong>
            </div>
            <div class="panel-body">
                <section  class="col-lg-13 connectedSortable">
                    <!-- Map box -->
                    <div class="box box-solid" id="centang">        
                        
                        <table id="tabelpembayaran" class=" table table-hover"  style="font-size: 11px; border: 1px; border-color:  black"    >
                            <thead>
                                <tr style="width: 30px; background-color:#23527c ;color: #000000">
                                    <th>NO</th>
                                    <th>PENERIMA JAMINAN</th> 
                                    <th>JUMLAH TERJAMIN</th> 
                                    <th>ACTION</th>                           

                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($pengajuan as $data=>$key)      
             
                                <tr style="background-color:#bdbdbd ;color: #000000">  
                                    <td>{{$i}}</td>
                                    <td>{{$key['namabank']}}</td>
                                    <td>{{$key['total']}}</td>
                                    <td><a target="_blank" id="" class="export-data" href="get-sertifikat-filter/{{$key['idbank']}}/{{$dari}}/{{$sampai}}">DETAIL</a></td>
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
     
    
</body>
 
@endsection

 