@extends('layout.admin')

@section('content')
<div class="container">
   
    <body>
        <div ng-app="Penjaminan" class="container" ng-controller="PenjaminanController" >
            <div class="box-body col-sm-10">
                <div class="box-body">
                    @if (Session::has('pesan'))
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ Session::get('pesan') }}
                    </div>
                    @endif
                    <div class="box box-solid">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <strong><i class="glyphicon glyphicon-pencil"></i>  <h3 class="text-center">FORM INPUT DATA BANK</h3></strong>
                            </div>
                            <div class="panel-body">
                                <form  method="post" action="simpandatabank">                    
                                    <div class="form-group">
                                        <label>Nama Bank</label>
                                        <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
                                    </div> 
                                    <div class="form-group">
                                        <label>Kode Cabang</label>
                                        <input class="form-control" id="kodecabang" name="kodecabang" placeholder="Masukkan kode cabang" type="text" required>
                                    </div>   
                                    <div class="form-group">
                                        <label>No Telp Bank</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-phone-alt">
                                                </i>
                                            </div>
                                            <input class="form-control" id="telp" name="telp" placeholder="Telp" type="text" required>
                                        </div>
                                    </div>                                            
                                    <div class="form-group">
                                        <div class="form-group ">
                                            <label>Alamat Bank</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="glyphicon glyphicon-map-marker">
                                                    </i>
                                                </div>
                                                <textarea id="alamat"  name="alamat"  type="text" class="form-control" ></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-group ">
                                            <label>Min IJP</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="glyphicon glyphicon-plus">
                                                    </i>
                                                </div>
                                                <input  id="minijp" name="minijp"  type="text" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group ">
                                            <label>Discount (%)</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="glyphicon glyphicon-pencil">
                                                    </i>
                                                </div>
                                                <input maxlength="3" name="discount" id="dis"  class="form-control" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-group ">
                                            <label>Nilai Share Penjaminan(%)</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="glyphicon glyphicon-barcode">
                                                    </i>
                                                </div>
                                                <input name="share"   id="share" maxlength="3"  type="text" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Biaya Admin</label>
                                        <input class="form-control" id="admin" name="admin" placeholder="Masukkan biaya admin" type="text" required>
                                    </div>   
                                    <div class="form-group">
                                        <label>Biaya Materai</label>
                                        <input class="form-control" id="materai" name="materai" placeholder="Masukkan biaya materai" type="text" required>
                                    </div>   
                                  
                                    <input hidden="" id="action" name="action" value="simpan">
                                    <input hidden="" id="idbank" name="idbank" >
                                    <button type="submit" class="btn btn-warning btn-xs">Simpan</button>
                                    {{csrf_field()}}
                                </form>       
                            </div>
                            <div class="panel-footer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <strong>
            <h2 align="center">DATA MASTER BANK</h2>
        </strong>
    </div>
    <div class="panel-body">
        <section  class="col-lg-13 connectedSortable">
            <div class="box box-solid">
                <table style="font-size: 11px" class="table table-bordered">
                    <thead>
                        <tr style="background-color:#23527c ;color: #000000">
                            <th>NO</th>                             
                            <th>NAMA BANK</th>
                            <th>NO TELP</th>
                            <th>ALAMAT</th>
                            <th>ACTION</th>                       
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach($bank as $datas)
                        <tr style="background-color:#bdbdbd ;color: #000000">  
                            <td>{{$i}}</td>                           
                            <td>{{$datas-> namabank}}</td>
                            <td>{{$datas-> telp}}</td>
                            <td>{{$datas-> alamatbank}}</td>
                            <td><a class="btn btn-xs updatebank" id="{{$datas-> idbank}}">update</a></td>  
                        </tr>
                        <?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>    
            </div>
        </section>  
    </div>
</div>
@endsection


