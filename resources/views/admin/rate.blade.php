@extends('layout.admin')

@section('content')
<ul class="nav nav-tabs">
    <li>
        <button type="button" name="add_button" ng-click="addDataRate()" class="btn btn-primary">ADD RATE</button>
    </li>  
</ul>

 
<body ng-app="Rate" ng-controller="RateController">
    <div class="container">

        @if (Session::has('pesan'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('pesan') }}
        </div>
        @endif
         <div class="panel panel-default">
    <div class="panel-heading">
        <strong>
            <h2 align="center">DATA MASTER RATE</h2>
        </strong>
    </div>
    <div class="panel-body" ng-init="fetchDataRate()">
        <section  class="col-lg-13 connectedSortable">
            <div class="box box-solid">
                  
        <br />
    
        <br />
               
        <br />
        <div class="table-responsive" style="overflow-x: unset;">

            <table id="tabelpembayaran" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No </th>
                        <th>NAMA BANK</th>
                        <th>TOTAL SCHEMA</th>  
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                     <?php $i=1;?>
                    @foreach($rate as $data)
                    <tr>  
                        <td>{{$i}}</td>
                        <td>{{$data->namabank}}</td>
                        <td>{{$data->total}}</td>
                        <td><a href="detailrate/{{$data->idbank}}">Detail</a></td>
                    </tr>
                    <?php $i++;?>
                    @endforeach
                </tbody>
            </table>
        </div>

  
            </div>
        </section>  
    </div>
</div>
    </div>
   
    
    <div class="modal fade" tabindex="-1" role="dialog" id="modalRate">
    <div class="modal-dialog" role="document">
        <div class="modal-content" >
             
            <form  method="post" action="simpanrate">     
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@{{modalTitle}}</h4>
                </div>
                <div class="modal-body" (onClose)="select.clear()">                   
                    
                    <div  class=" form-group">
                        <label>Kode Bank</label><br>
                        <select id="idbank" name="idbank"   ng-model="idbank" class="form-control">
                            <option value="" >Pilih Bank</option>                                                                     
                            @foreach($bank as $data)                              
                            <option value="{{$data->idbank}}">{{$data-> namabank}}</option> 
                            @endforeach                     
                        </select>    
                    </div>          
                     <div  class=" form-group">
                        <label>Kategori</label><br>
                        <select id="idproduk" name="kategori"   ng-model="kategori" class="form-control">
                            <option value="" >Pilih Kategori</option>                                                                 
                            @foreach($produk as $data)                              
                            <option value="{{$data->idproduk}}">{{$data->kategori}}</option> 
                            @endforeach                          
                        </select>    
                    </div>
                    
                    <div class="form-group">
                        <label>Jenis Penjaminan</label>
                        <select name="jenispenjaminan" id="jenispenjaminan" class="form-control">
                            <option value="">Pilih jenis</option>
                            <option value="JIWA">JIWA</option>
                            <option value="MACET">MACET</option>
                            <option value="JIWA DAN MACET">JIWA DAN MACET</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input class="form-control" id="namarate" ng-model="namarate" name="namarate" placeholder="Nama Produk" type="text" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Dari [Bulan]</label>
                        <input class="form-control" id="dari" ng-model="dari" name="daribulan"  placeholder="Dari" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Sampai [Bulan]</label>
                        <input class="form-control" id="sampai" ng-model="sampai"  name="sampaibulan" placeholder="sampai" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Rate</label>
                        <input class="form-control" id="rate" ng-model="rate" name="rate" placeholder="rate" type="text" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" id='hidden_id' name="hidden_id" value="@{{hidden_id}}" />
                    <input type="submit" name="submit" id="submit" class="btn btn-info" value="@{{submit_button}}" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                 {{csrf_field()}}     
            </form>
        </div>
    </div>
</div>
</body>   
<br>
<br>
@endsection




