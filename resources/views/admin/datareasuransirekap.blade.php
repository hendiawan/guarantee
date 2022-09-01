@extends('layout.admin')
@section('content')
<body ng-app="Penjaminan" ng-controller="PenjaminanController">
      
    <div  style=" border-top-style: solid;
                                    border-right-style: solid;
                                    border-bottom-style: solid;
                                    border-left-style: solid;
                                    border-width: 1px;
                                    /*border-color: #005888;*/
                                    border-radius: 20px;
                                    margin-left: 20px;
                                     margin-right: 20px;
                                    " 
                    class="panel panel-default">
           <div  style="border-radius: 20px;" class="panel-heading"> 
                        <strong><i class="glyphicon glyphicon-"></i>    <h2 align="center">REKAP BERDASARKAN TGL PROSES</h2> </strong>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="/rekanan/rekap">
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
                                            <input required="" value="{{old('dari')}}"   id="dari"  name="dari"  type="text" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask="">
                                        </div>
                                    </th>

                                    <th> 
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-time">
                                                </i>
                                            </div>
                                            <input required="" value="{{old('sampai')}}"   id="sampai"  name="sampai"  type="text" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask="">
                                        </div>
                                    </th>
                                    <th>
                                        <br>
                                        <div class="input-group">
                                            <td><button  type="submit" class="btn btn-danger">Filter</button></td> 
                                            @if ($_SERVER['REQUEST_METHOD'] == 'POST')
                                            <td><a target="_BLANK" href="/rekanan/cetak-laporan-pdf/{{$_POST['bank']}}/{{$_POST['dari']}}/{{$_POST['sampai']}}" class="btn btn-warning">Cetak PDF</a></td>
                                            @endif
                                        </div>
                                    </th>
                                </tr>                
                            </table>
                        </form>       
                    </div>
                </div>  
    
    <div style="border-radius: 30px; margin-left: 20px;margin-right: 20px" class="panel panel-default">
            <div style="border-top-left-radius: 30px;border-top-right-radius:  30px;" class="panel-heading">
                <strong> 
                    <h2 style="color:#001f3f" align="center">DATA PENJAMINAN SUDAH TERDAFTAR REASURANSI</h2>
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
                                    <th>UMUR</th>  
                                    <th>PLAFON</th>
                                    <th>JANGKA WAKTU</th> 
                                    <th>TGL PENGAJUAN</th> 
                                    <th>NO SERTIFIKAT</th> 
                                    <th>REASURANSI</th> 
                                    <th>SHARE RISK</th> 
                                    <th>TGL PROSES</th> 
                                    <th>JENIS KREDIT</th> 
                                    <th>JENIS PENJAMINAN</th> 
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
                                    <td>{{$data ->penjaminan->terjamin->umur}}</td> 
                                    <td>{{ number_format($data ->penjaminan->plafon, 0, '.', ',')}}</td>
                                     <td>{{$data ->penjaminan->masakredit}}</td>
                                    <td>{{$data ->penjaminan->tglpengajuan}}</td>
                                    <td>{{$data ->penjaminan->sertifikat->kodesertifikat}}</td>
                                    <td>{{$data ->penjaminan->reasuransi->rekanan->nama_asuransi}}</td>
                                    <td>{{$data ->penjaminan->reasuransi->share_risk}} %</td>
                                    <td>{{$data ->tgl_proses}}</td> 
                                    <td>{{$data ->penjaminan->jeniskredit}}</td> 
                                    <td>{{$data ->penjaminan->jenispenjaminan}}</td> 
                                    <td>
                                        @if($data ->tgl_proses>date('Y-m-d h:i:s'))
                                        <a  href="/rekanan/reasuransi/{{$data->id}}" class="btn btn-info"for="validasiktp{{$data->id}}">Ubah</a>
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
               
               
               {{csrf_field()}}
                </form> 
                    
        </div>
     
    
</body>
 
@endsection

 