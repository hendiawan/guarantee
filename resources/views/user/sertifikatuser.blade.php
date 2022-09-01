@extends('layout.user')
@section('content')
<body ng-app="Penjaminan" ng-controller="PenjaminanController">
      
         <div class="box box-solid">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><i class="glyphicon glyphicon-search"></i></strong>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="carisertifikatuser">
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
                                                         
                                            <option value="nama">NAMA TERJAMIN</option>    
                                            <option value="kodesertifikat">NO SERTIFIKAT</option> 
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
                                            <td><button  type="submit" class="btn btn-danger btn-xs">Submit</button></td>
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
                    <h2 align="center">PENGAJUAN PENJAMINAN KREDIT</h2>
                    <h2 style="color:red" align="center">SUDAH TERBIT SERTIFIKAT</h2>
                </strong>
            </div>
            <div class="panel-body">
                <section  class="col-lg-13 connectedSortable">
                    <!-- Map box -->
                    <div class="box box-solid">         
                        <table id="tabelpembayaran" class=" table table-hover"  style="font-size: 11px; border: 1px; border-color:  black"    >
                            <thead>
                                <tr style="width: 30px; background-color:#23527c ;color: #000000">
                                    <th>NO</th>
                                    <th>NO SERTIFIKAT</th>   
                                    <th>TGL TERBIT</th>   
                                    <th>PENERIMA JAMINAN</th>   
                                    <th>NO KTP</th>
                                    <th>TERJAMIN</th>        
                                    <th>JENIS KREDIT</th>
                                    <th>PLAFON</th>
<!--                                 <th>UMUR</th>
                                    <th>PEKERJAAN</th>                              
                                    <th>NO PK</th>
                                    <th>MULAI TGL</th>
                                    <th>SAMPAI TGL</th>                           
                                    <th>JUMLAH</th>                                
                                   -->
    <!--                                <th>RATE IJP(%)</th>
                                    <th>JUMLAH IJP</th>
                                    <th>DISC(Rp)</th>
                                    <th>NET. IJP(Rp)</th>-->
                                    <th>DOKUMEN</th>                           

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
                                    <td>{{$data -> kodesertifikat}}</td> 
                                    <td>{{date('d-m-Y', strtotime($data -> tglterbit))}}</td>    
                                    <td>{{$data -> namabank}}</td> 
                                    <td>{{$data -> ktp}}</td> 
                                    <td>{{$data -> nama}}</td>   
                                    <td>{{$data -> jeniskredit}}</td>
<!--                                    <td>{{$data -> umurjatuhtempo}}</td>                                                        
                                    <td>{{$data -> pekerjaan}}</td>
                                  
                                    <td>{{$data -> nopk}}</td>
                                    <td>{{date('d-m-Y', strtotime($data -> tglrealisasi))}}</td>                            
                                    <td>{{date('d-m-Y', strtotime($data -> tgljatuhtempo))}}</td>                            
                                    <td>{{$data -> masakredit}} Bln</td>-->
                                    <td>{{number_format($data -> plafon, 0, ',', '.')}}</td>
    <!--                                <td>{{$data ->rate}}</td>
                                    <td>{{number_format($data ->premi, 0, ',', '.')}}</td>
                                    <td>{{number_format($data ->pot, 0, ',', '.')}}</td>
                                    <td>{{number_format($data ->nett, 0, ',', '.')}}</td>-->
                                    <td>
                                       <div class=" btn-group-vertical">
                                           
                                          <li> <b> <a target="_blank "  href="cetaksuratpengajuan/{{$data ->nosertifikat}}"  style="color: black">Cetak Surat Pengajuan</a></b></li>
                                          <li <?php if($data ->case=='Tidak'){echo 'hidden=""';} ?> > <b > <a style="color:black" target="_blank" href="/cetaksp3/{{$data ->nosertifikat}}">Cetak Surat Persetujuan Prinsip Penjaminan</a></b></li>
                                          <li>
                                                <b>
                                                    <a style="color: red" target="_blank " id="{{$data ->idpenjaminan}}" class="logcetaksertifikat"  href="/cetakpdf/{{$data ->nosertifikat}}" >Cetak Sertifikat</a> 
                                                </b>
                                          </li>
<!--                                        <a class="btn btn-primary" href="/cetakpenjaminanpdf/{{$data ->nosertifikat}}">Cetak Daftar</a>-->
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


                    </div>
                </section>  
            </div>
        </div>
  
   
  
</body>
 
@endsection

 