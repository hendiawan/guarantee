@extends('layout.admin')
@section('content')
<body ng-app="Penjaminan" ng-controller="PenjaminanController">
     
                 <div  style=" border-top-style: solid;
                                    border-right-style: solid;
                                    border-bottom-style: solid;
                                    border-left-style: solid;
                                    border-width: 1px;
                                    border-color: #005888;
                                    border-radius: 20px;
                                    margin-left: 3%;
                                     margin-right: 3%;
                                    " 
                    class="panel panel-default">
           <div  style="border-radius: 20px;" class="panel-heading"> 
                        <strong><i class="glyphicon glyphicon-"></i>    <h2 align="center">REKAP PENJAMINAN</h2> </strong>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="/rekanan/register">
                            {{csrf_field()}}
                            <table>
                                <tr>
                                    <th style="width:40% ">Bank</th>
                                    <th style="width:30% ">Dari</th>
                                    <th style="width:20% ">Sampai</th> 
                                <tr> 
                                    <th>
                                        <select style="margin-right: 100px" id="pilihbank" required="" name="bank" class="form-control">
                                            <option value="">Pilih Bank</option>
                                            <option value="%">Semua Bank</option>                                                
                                            @foreach($bank as $data)
                                            <option value="{{$data->idbank}}">{{$data->namabank}}</option>                                                
                                            @endforeach 
                                        </select>
                                    </th>
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
                                            <td><button  type="submit" class="btn btn-danger">Filter</button></td>
                                        </div>
                                    </th>
                                </tr>                
                            </table>
                        </form>       
                    </div>
                </div>
               
            </div>
       <div  style=" border-top-style: solid;
                                    border-right-style: solid;
                                    border-bottom-style: solid;
                                    border-left-style: solid;
                                    border-width: 1px;
                                    border-color: #005888;
                                    border-radius: 20px;
                                    margin-left: 3%;
                                     margin-right: 3%;
                                    " 
                    class="panel panel-default">
           <div  style="border-radius: 20px;" class="panel-heading">
                <strong> 
                    <h2 style="color:red" align="center">DATA PENJAMINAN UNTUK REGISTRASI REASURANSI</h2>
                </strong>
            </div>
           <form method="post" name="save_reasuransi" action="{{url('/rekanan/save-reasuransi')}}" enctype="multipart/form-data" >

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
                                <?php
                                $i = 1;
                                $premi = 0;
                                $dis = 0;
                                $nett = 0;
                                ?>
                                 
                                @foreach($datareasuransi as $data)           
                                <tr style="background-color:#bdbdbd ;color: #000000">  
                                    <td>{{$i}}</td>
                                    <td>{{$data ->namabank}}</td>
                                    <td>{{$data ->total}}</td> 
                                            <td><a target="_blank" id="" class="export-data" href="/rekanan/register-detail/{{$data->idbank}}/{{$dari}}/{{$sampai}}">DETAIL</a></td>
                        
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
               
               {{csrf_field()}}
                </form> 
                    
        </div>
     
    
</body>
 
@endsection

 