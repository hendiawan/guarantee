@extends('layout.admin')
@section('content')
<body ng-app="Penjaminan" ng-controller="PenjaminanController">
      
         <div class="box box-solid">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><i class="glyphicon glyphicon-search"></i></strong>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="carisertifikat">
                            {{csrf_field()}}
                            <table>
                                <tr>
                                    <th>CARI BERDASARKAN</th>
                                    <th>DATA</th>        
                                </tr>
                                <tr>                    
                                   <th>
                                       <select required="" id="jenis" name="jenis" class="form-control">
                                            <option value="">Pilih</option>
<!--                                            <option value="nosertifikat">KODE PENGAJUAN</option>                                                
                                            <option value="kodebayar">KODE BAYAR</option>                                                -->
                                            <option value="kodesertifikat">NO SERTIFIKAT</option>            
                                            <option value="nama">NAMA TERJAMIN</option>    
                                         
                                        </select>
                                    </th>
                                    <th> 
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-edit">
                                                </i>
                                            </div>
                                            <input required="" value="{{old('data')}}"   id="data"  name="data"  type="text" class="form-control klickendorse" >
                                        </div>
                                    </th>
                                    <th>
                                        <br>
                                        <div class="input-group">
                                            <td><button  type="submit" class="btn btn-danger">Submit</button></td>
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <h2 align="center"> PENJAMINAN SURETY BOND</h2>
                    <h2 style="color:red" align="center">SUDAH TTD DIGITAL</h2>
                </strong>
            </div>
            <div class="panel-body">
                <section  class="col-lg-13 connectedSortable">
                    <!-- Map box -->
                    <div class="box box-solid">         
                        <table style="font-size: 11px" class="table table-bordered tabel">
                            <thead>
                                <tr style="background-color:#23527c ;color: #ffffff">
                                    <th>No</th>                             
                                    <th>Nama Kontraktor</th>
                                    <th>Nomor Sertifikat</th>
                                    <th>Action</th>                       
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($sppsb as $datas)
                                <tr style="background-color:#bdbdbd ;color: #000000">  
                                    <td>{{$i}}</td>                           
                                    <td>{{$datas->nama_kontraktor}}</td>
                                    <td>{{$datas-> no_jaminan}}</td>
                                    <td><a target='_blank' href="/sertifikatSppsb/{{$datas-> id}}">View Sertifikat</a></td>  
                                </tr>
                                <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>    

                    </div>
                </section>  
            </div>
        </div>
</body>
 
@endsection

 