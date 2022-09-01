@extends('layout.admin')
@section('content')
<body ng-app="Penjaminan" ng-controller="PenjaminanController">
    @if (Session::has('pesan'))
    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ Session::get('pesan') }}
    </div>
    @endif
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <h2 align="center">SINGKRONISASI</h2>
                    <h2 style="color:red" align="center">DATA PENJAMINAN SUDAH TERBIT SERTIFIKAT</h2>
                </strong>
            </div>
           <form method="post" name="save_export" action="{{url('save-export-web')}}" enctype="multipart/form-data" >

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
                              
                                @foreach($dataweb as $data=>$key)           
                                <tr style="background-color:#bdbdbd ;color: #000000">  
                                    <td>{{$i}}</td> 
                                    <td>{{$key['namabank']}}</td>
                                    <td>{{$key ['nama']}}</td>
                                    <td>{{$key ['ktp']}}</td>
                                    <td>{{$key ['tglpengajuan']}}</td>
                                    <td>{{$key ['kodesertifikat']}}</td>
                                    <td>{{$key ['tglterbit']}}</td>
                                    <td>
                                        <div class="radio icheck-primary">
                                            <input   id="validasiktp{{$key ['idpenjaminan']}}" class="radio ktp" type="checkbox" name="export[{{$key ['idpenjaminan']}}]" value="{{$key ['idpenjaminan']}}" /> 
                                            <label  for="validasiktp{{$key ['idpenjaminan']}}">EXPORT</label>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                                $premi = $premi + $key['premi'];
                                $dis = $dis + $key['pot'];
                                $nett = $nett + $key['nett'];
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

 