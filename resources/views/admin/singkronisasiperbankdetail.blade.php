@extends('layout.admin')
@section('content')
<body ng-app="Penjaminan" ng-controller="PenjaminanController">
      
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <h2 align="center">SINGKRONISASI</h2>
                    <h2 style="color:red" align="center">DATA PENJAMINAN SUDAH TERBIT SERTIFIKAT</h2>
                </strong>
            </div>
           <form method="post" name="save_export" action="{{url('save-export')}}" enctype="multipart/form-data" >

            <div class="panel-body">
                <section  class="col-lg-13 connectedSortable">
                    <!-- Map box -->
                    <div class="box box-solid" id="centang">         
                        
                        <table id="tabelpembayaran" class=" table table-hover"  style="font-size: 11px; border: 1px; border-color:  black"    >
                            <thead>
                                <tr style="width: 30px; background-color:#23527c ;color: #000000">
                                    <th>NO</th>
                                    <th>PENERIMA JAMINAN</th> 
                                    <th>NAMA TERJAMIN</th> 
                                    <th>NIK</th> 
                                    <th>TGL PENGAJUAN</th> 
                                    <th>NO SERTIFIKAT</th> 
                                    <th>TGL TERBIT</th> 
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
                                @foreach($pengajuan as $data)           
                                <tr style="background-color:#bdbdbd ;color: #000000">  
                                    <td>{{$i}}</td>
                                    <td>{{$data ->namabank}}</td>
                                    <td>{{$data ->nama}}</td>
                                    <td>{{$data ->ktp}}</td>
                                    <td>{{$data ->tglpengajuan}}</td>
                                    <td>{{$data ->kodesertifikat}}</td>
                                    <td>{{$data ->tglterbit}}</td>
                                    <td>
                                        <div class="radio icheck-primary">
                                            <input   id="validasiktp{{$data->idpenjaminan}}" class="radio ktp" type="checkbox" name="export[{{$data ->idpenjaminan}}]" value="{{$data ->idpenjaminan}}" /> 
                                            <label  for="validasiktp{{$data->idpenjaminan}}">EXPORT</label>
                                        </div>
                                    </td>
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
                        
                        <div align="right" class="radio icheck-primary">
                            <input  id="cekall" class="checkbox cekall" type="checkbox" /> 
                            <label for="cekall">Pilih Semua</label>
                        </div>
                    </div>
                </section>  
            </div>
               
               <div style="margin: 12px" align="right" >
                                   <input type="submit" name="submit" id="action" value="Simpan" class="btn btn-info" />
               </div>
               
               {{csrf_field()}}
                </form> 
                    
        </div>
     
    
</body>
 
@endsection

 