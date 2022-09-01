@extends('layout.admin')
@section('content')
<body ng-app="Penjaminan" ng-controller="PenjaminanController">
      
      <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><i class="glyphicon glyphicon-search"></i></strong>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="/rekanan/search">
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
    <div style="border-radius: 30px; margin-left: 20px;margin-right: 20px" class="panel panel-default">
            <div style="border-top-left-radius: 30px;border-top-right-radius:  30px;" class="panel-heading">
                <strong> 
                    <h2 style="color:#001f3f" align="center">DATA PENJAMINAN SUDAH TERDAFTAR REASURANSI</h2>
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
                                    <th>NAMA TERJAMIN</th> 
                                    <th>JANGKA WAKTU</th> 
                                    <th>PLAFON</th> 
                                    <th>TGL PENGAJUAN</th> 
                                    <th>NO SERTIFIKAT</th> 
                                    <th>REASURANSI</th> 
                                    <th>SHARE RISK</th> 
                                    <th>TGL PROSES</th> 
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
                                    <td>{{$data ->penjaminan->bank->namabank}}</td>
                                    <td>{{$data ->penjaminan->terjamin->nama}}</td>
                                    <td>{{$data ->penjaminan->masakredit}}</td>
                                    <td>{{ number_format($data ->penjaminan->plafon, 0, '.', ',')}}</td>
                                    <td>{{$data ->penjaminan->tglpengajuan}}</td>
                                    <td>{{$data ->penjaminan->sertifikat->kodesertifikat}}</td>
                                    <td>{{$data ->penjaminan->reasuransi->rekanan->nama_asuransi}}</td>
                                    <td>{{$data ->penjaminan->reasuransi->share_risk}} %</td>
                                    <td>{{$data ->tgl_proses}}</td> 
                                    <td>
                                        @if($data ->tgl_proses>date('Y-m-d h:i:s'))
                                        <a  href="/rekanan/reasuransi/{{$data->t_reasuransi_id}}" class="btn btn-info"for="validasiktp{{$data->idpenjaminan}}">Ubah</a>
                                        @endif
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
                      
                    </div>
                </section>  
            </div>  
        </div>
     
    
</body>
 
@endsection

 