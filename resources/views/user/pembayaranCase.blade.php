@extends('layout.user')

@section('content')

<br>
@if (Session::has('pesan'))
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{ Session::get('pesan') }}
</div>
@endif
<div class="panel panel-default">
        <div class="panel-heading">
            <strong><i class="glyphicon glyphicon-shopping-cart"></i>  Detail Transaksi Pembayaran</strong>
        </div>
        <div class="panel-body">             
            <div class="box-body col-sm-12">
                <div class="box-body">
                    <table class="table table-hover"   style="font-size: 11px;border: 1px; border-color:  black"  >
                        <thead>
                            <tr style="background-color:#23527c ;color: #000000">
                                <th>No</th>
                                <th>No PK</th>
                                <th>Tgl. Pengajuan</th>                           
<!--                                <th>No KTP</th>-->
                                <th>Terjamin</th>                      
                                <th>Jenis Kredit</th>
                                <th>Realisasi</th>
                                <th>Tempo</th>                           
                                <th>Masa Kredit</th>                           
                                <th>Plafon</th>
                                <th>Penjaminan</th>                           
                                <th>Rate</th>                           
                                <th>Gross IJP</th>                           
                                <th>Discount(%)</th>                           
                                <th>Potongan(Rp.)</th>                           
                                <th>Nett IJP</th>                           
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $premi = 0;
                            $dis = 0;
                            $nett = 0;
                            ?>
                            @foreach($data as $datas)
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{$datas -> nopk}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tglpengajuan))}}</td>     
<!--                                <td>{{$datas -> ktp}}</td>-->
                                <td>{{$datas -> nama}}</td>                                                        
                                <td>{{$datas -> jeniskredit}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tglrealisasi))}}</td>
                                <td>{{date('d-m-Y', strtotime($datas -> tgljatuhtempo))}}</td>                            
                                <td>{{$datas -> masakredit}} Bulan</td>
                                <td>{{number_format($datas -> plafon, 0, ',', '.')}}</td>
                                <td>{{$datas -> jenispenjaminan}}</td>                         
                                <td>{{$datas -> rate}}</td>                         
                                <td>{{number_format($datas -> premi, 0, ',', '.')}}</td>                         
                                <td>{{$datas -> dis}}</td>                         
                                <td>{{number_format($datas -> pot, 0, ',', '.')}}</td>                         
                                <td>{{number_format($datas -> nett, 0, ',', '.')}}</td>                         
                            </tr>
                            <?php
                            $i++;
                            $premi = $premi + $datas->premi;
                            $dis = $dis + $datas->pot;
                            $nett = $nett + $datas->nett;
                            ?>
                            @endforeach
                        </tbody>
                      
                    </table><br>
                    <table class="table">
                        <tr>
                            <th>Jumlah IJP(Rp.) </th>                        
                           
                            <td align="right" ><?php echo number_format($premi, 0, '.', ',') ?> </td>
                        </tr>
                        <tr  align="right">
                            <th>Fee Base Incame Bank (Rp.) &nbsp</th>  
                          
                            <td align='right'> <?php echo number_format($dis, 0, '.', ',') ?> </td>
                        </tr>
                        <tr  align="right">
                            <th>Nett IJP (Rp.)</th>   
                            
                            <td align="right" ><?php echo number_format($nett, 0, '.', ',') ?></td>
                        </tr>
                        <tr>
                            <th>Biaya Administrasi (Rp.)</th>     
                            
                            <td align="right" ><?php echo number_format($data[0]['admin'], 0, '.', ',') ?></td>
                        </tr>
                        
                        <tr>
                            <th>Biaya Materai (Rp.)</th>  
                            <td align="right" > <?php echo number_format($data[0]['materai'], 0, '.', ',') ?></td>
                        </tr>
                        
                        

                         <tr style="color:red" >
                            <th>Total Bayar (Rp.)</th> 
                            <td align="right" > <input  disabled="" class="form-control" id="totalbayar" value="<?php echo number_format($totalbayar=$nett+$data[0]['admin']+$data[0]['materai'], 0, '.', ',') ?>"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong><i class="glyphicon glyphicon-shopping-cart"></i>  Input Data Pembayaran</strong>
        </div>
        <div class="panel-body">             
            <div class="box-body col-sm-12">
                <div class="box-body">
                    <form method="POST"  action="{{url('pembayarancase')}}"  id="formPembayaranXXX" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">

                            <div class="form-group">
                                <label>KODE PEMBAYARAN</label>
                                <input   value="{{ session::get('idbank')}}"      name="idbank"  type="text"  hidden="">
                                <input   value="{{$datas -> idpenjaminan}}"      name="idpenjaminan"  type="text"  hidden="">
                                <input   value="<?php echo session::get('idbank') . date('Ymd') . $kode + 1 ?>"      name="kodepembayaran"  type="text"  hidden="">
                                <input   disabled="" required="" value="<?php echo session::get('idbank') . date('Ymd') . $kode + 1 ?>"  type="text" class="form-control" >
                            </div>                                
                            <input hidden=""  name="nosertifikat"  required="" value="<?php echo $datas -> nosertifikat ?>"  type="text" class="form-control" >

                            <div class="form-group ">
                                <label>TOTAL  BAYAR</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        Rp.
                                    </div>
                                    <input hidden="" value='{{number_format($datas -> nett, 0, '.', ',')}}'  required=""  onkeyup="FormatCurrency(this)"   id="totaltf"   name="totalbayar"  type="text" >
                                    <input disabled="" value='{{number_format($datas -> nett, 0, '.', ',')}}'  required=""  class="form-control" onkeyup="FormatCurrency(this)"    name=""  type="text" >
                                 </div>
                                @if($errors->has('bayar'))
                                <p style="color: red"> {{ $errors->first('bayar')}}</p>
                                @endif
                            </div>

                            <div class="form-group ">
                                <label>TANGGAL PROSES BAYAR</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-time">
                                        </i>
                                    </div>
                                    <input required="" value="<?php echo date('Y/m/d') ?>"  name="tglbayar"  type="text"  hidden="">
                                    <input disabled="" required="" value="<?php echo date('Y/m/d') ?>"  type="text" class="form-control">
                                </div>
                                @if($errors->has('bayar'))
                                <p style="color: red"> {{ $errors->first('bayar')}}</p>
                                @endif
                            </div>
                            <div class="form-group ">
                                <label>MASA KREDIT</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-time">
                                        </i>
                                    </div>
                                    <input required="" value="{{$datas -> masakredit}}"  name="masakredit" id="masakredit" type="text"  hidden="">
                                    <input disabled="" required="" value="{{$datas -> masakredit}} Bulan" type="text" class="form-control">
                                </div>
                                @if($errors->has('bayar'))
                                <p style="color: red"> {{ $errors->first('bayar')}}</p>
                                @endif
                            </div>
                            
                           <div class="form-group ">
                            <label>Nomor PK<b style="color: red">( * )</b></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-time">
                                        </i>
                                    </div>
                                    <input required=""  id="NoPK" name="NoPK"  type="text" class="form-control" >
                                </div>
                                @if($errors->has('tglrealisasi'))
                                <p style="color: red"> {{ $errors->first('tglrealisasi')}}</p>
                                @endif
                                <div id="msg_realisasi"></div>
                            </div> 
                            
                            <div class="form-group ">
                            <label>Tanggal Realisasi<b style="color: red">( * )</b></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-time">
                                        </i>
                                    </div>
                                    <input onchange="CekJatuhTempoCase()" value="{{old('tglrealisasi')}}" required=""  id="tglrealisasicase" name="tglrealisasi"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                                </div>
                                @if($errors->has('tglrealisasi'))
                                <p style="color: red"> {{ $errors->first('tglrealisasi')}}</p>
                                @endif
                                <div id="msg_realisasi"></div>
                            </div> 
                            
                             <div class="form-group ">
                            <label>Tanggal Jatuh Tempo<b style="color: red">( * )</b></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-time">
                                        </i>
                                    </div>
                                    <input hidden=""  value="" required=""  name="TglJatuhTempo"  type="text" class=" TglJatuhTempo" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                                    <input disabled="" value="" required=""  id="TglJatuhTempo"  type="text" class="form-control TglJatuhTempo" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                                </div>
                                @if($errors->has('tglrealisasi'))
                                <p style="color: red"> {{ $errors->first('tglrealisasi')}}</p>
                                @endif
                                <div id="msg_realisasi"></div>
                            </div>
                            
                            <label style="color:red">UPLOAD BUKTI BAYAR |PDF|JPG| Max. 700kb</label>
                            <input name="filePembayaran" id="poster" type="file" class="form-control"><br/>
                            @if($errors->has('file'))
                            <p style="color: red"> {{ $errors->first('filePembayaran')}}</p>
                            @endif
                            <div class="progress">
                                <div class="bar"></div >
                                <div class="percent">0%</div >
                            </div>
                            <input type="submit" id="prosesbayar" value="Proses" class="btn btn-success">
                        </div>
                    </form>    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection



