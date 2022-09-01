@extends('layout.admin')

@section('content')

 
<body>
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
            <h2 align="center">DATA MASTER RATE </h2>
        </strong>
    </div>
    <div class="panel-body">
        <section  class="col-lg-13 connectedSortable">
       <div class="box box-solid"> 
        <div class="table-responsive" >

            <table id="tabelpembayaran" class="table table-bordered">
                <thead>
                    <tr>
                        <th>No </th>
                        <th>Nama Bank</th>
                        <th>Nama Rate</th>  
                        <th>Jns Penjaminan</th>
                        <th>Dari</th>
                        <th>Sampai</th>      
                        <th>Rate</th>
                        <!--<th>Edit</th>-->
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                     <?php $i=1;?>
                    @foreach($rate as $data)
                    <tr>  
                        <td>{{$i}}</td>
                        <td>{{$data->namabank}}</td>
                        <td>{{$data->namarate}}</td>
                        <td>{{$data->jnspnj}}</td>
                        <td>{{$data->dari}}</td>
                        <td>{{$data->sampai}}</td>
                        <td>{{$data->rate}}</td>
                        <td><button id="{{$data->idrate}}" type="button"  class="btn btn-danger btn-xs ubahrate">Ubah</button></td>
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
                        <select id="idbank" name="idbank"   class="form-control">
                            <option value="" >Pilih Bank</option>                                                                     
                            @foreach($bank as $data)                              
                            <option value="{{$data->idbank}}">{{$data-> namabank}}</option> 
                            @endforeach                     
                        </select>    
                    </div>          
                     <div  class=" form-group">
                        <label>Kategori</label><br>
                        <select id="idproduk" name="kategori"    class="form-control">
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
                        <input class="form-control" id="namarate"   name="namarate" placeholder="Nama Produk" type="text" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Dari [Bulan]</label>
                        <input class="form-control" id="dari"  name="daribulan"  placeholder="Dari" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Sampai [Bulan]</label>
                        <input class="form-control" id="sampai"    name="sampaibulan" placeholder="sampai" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Rate</label>
                        <input class="form-control" id="rate"   name="rate" placeholder="rate" type="text" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" id='hidden_id' name="hidden_id"   />
                    <input type="submit" name="submit" id="submit" class="btn btn-info"  />
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




