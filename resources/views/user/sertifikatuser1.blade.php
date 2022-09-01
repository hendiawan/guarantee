@extends('layout.user')
@section('content')
<body ng-app="Penjaminan" ng-controller="PenjaminanController">
    
    <div class="box box-solid" >
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><i class="glyphicon glyphicon-search"></i></strong>
                    </div>
                    <div class="panel-body">
                        <form id="form-cari" method="post" action="carisertifikatuser">
                            {{csrf_field()}}
                                    <table style="width: 100%">
                                <tr>
                                    <th>CARI BERDASARKAN</th>
                                    <th></th>        
                                    <th></th>        
                                </tr>
                                <tr>           
                                   <td>
                                       <select id="jenis-pencarian" style="width: 95%"required="" id="jenis" name="jenis" class="form-control">
                                            <option value="">Pilih</option>
<!--                                        <option value="nosertifikat">KODE PENGAJUAN</option>                                                
                                            <option value="kodebayar">KODE BAYAR</option>                                                -->    
                                            <option value="nama">NAMA TERJAMIN</option>    
                                            <option value="kodesertifikat">NO SERTIFIKAT</option> 
                                        </select>
                                    </td>
                                    <td> 
                                        <div  style="width: 95%" class="input-group">
                                            <input id="data-pencarian"  required="" value="{{old('data')}}"   id="data"  name="data"  type="text" class="form-control klickendorse" >
                                            <btn id='btn-cari'   type="submit" class="btn input-group-addon">
                                                <i class="glyphicon glyphicon-search">
                                                </i>
                                                                                            <!--<button style="height: 100%;border-radius: 20px" type="submit"class="btn btn-danger">Submit</button>-->

                                            </btn>
                                        </div>
                                    </td>
                                    <td>  
                                            <!--<button style="height: 100%;border-radius: 20px" type="submit"class="btn btn-danger">Submit</button>-->
                                    </td>
                                </tr>                
                            </table>
                        </form>       
                    </div>
                    <div class="panel-footer">
                        
                    </div>
                </div>
            </div>
        <div class="box box-solid">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><i class="glyphicon glyphicon-"></i>    <h2 align="center">REKAP SERTIFIKAT</h2> </strong>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="filter-sertifikat-by-date">
                            {{csrf_field()}}
                            <table style="width: 100%">
                                <tr> 
                                    <th style="width:20% ">Dari</th>
                                    <th style="width:20% ">Sampai</th>
                                    <th style="width:20% ">Jns Kredit</th> 
                                </tr>
                                <tr>  
                                    <td> 
                                        <input style="width:90%" required="" value="{{old('dari')}}"   id="dari"  name="dari"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                                    </td> 
                                    <td>
                                            <input  style="width:90%" required="" value="{{old('sampai')}}"   id="sampai"  name="sampai"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                                    </td> 
                                     
                                    <td>
                                        <select   style="width:90%" required="" name="jenisKredit" class="form-control">
                                            <option value="">Pilih Jenis</option>
                                            <option value="%">SEMUA</option>                                                
                                            <option value="PRODUKTIF">PRODUKTIF</option>                                                
                                            <option value="KONSUMTIF">KOMSUMTIF</option>                                                
                                        </select>
                                    </td>  
                                        <td>
                                            <button style="height: 100%" type="submit" class="btn btn-danger">Filter</button> 
                                        </td> 
                                </tr>                
                            </table>
                        </form>       
                    </div>
                    <div class="panel-footer">
                        
                    </div>
                </div>
               
            </div>
    <div class="panel panel-default" style="border-top-left-radius: 20px;border-top-right-radius: 20px">
            <div  style="border-top-left-radius: 20px;border-top-right-radius: 20px" class="panel-heading">
                <strong>
                    <h2 align="center">CETAK SERTIFIKAT PENJAMINAN</h2>
<!--                    <h2 style="color:red" align="center">SUDAH TERBIT SERTIFIKAT</h2>-->
                </strong>
            </div>
            <div  class="panel-body">
                <section  class="col-lg-13 connectedSortable">
                    <!-- Map box -->
                      <div class="box box-solid">         
                        <table id="tabelpembayaran" class=" table table-hover"  style="font-size: 11px; border: 1px; border-color:  black"    >
                            <thead>
                                <tr style="width: 30px; background-color:#23527c ;color: #000000">
                                    <th>NO</th>
                                    <!--<th>NO SERTIFIKAT</th>-->   
                                    <th>TGL TERBIT</th>   
                                    <th>PENERIMA JAMINAN</th>   
                                    <th>NO SERTIFIKAT</th>
                                    <th>TERJAMIN</th>        
                                    <th>JENIS KREDIT</th>
                                    <th>JENIS PENJAMINAN</th>
                                    <th>PLAFON</th>
                                    <th>NETT IJP</th>
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
                                    <!--<td>{{$data -> kodesertifikat}}</td>--> 
                                    <td>{{date('d-m-Y H:i:s', strtotime($data -> sertifikat->tglterbit))}}</td>
                                    <td>{{$data -> bank->namabank}}</td> 
                                    <td>{{$data -> sertifikat->kodesertifikat}}</td> 
                                    <td>{{$data -> terjamin->nama}}</td>   
                                    <td>{{$data -> jeniskredit}}</td>
                                    <td>{{$data -> jenispenjaminan}}</td>
<!--                             <td>{{$data -> umurjatuhtempo}}</td>                                                        
                                    <td>{{$data -> pekerjaan}}</td>
                                  
                                    <td>{{$data -> nopk}}</td>
                                    <td>{{date('d-m-Y', strtotime($data -> tglrealisasi))}}</td>                            
                                    <td>{{date('d-m-Y', strtotime($data -> tgljatuhtempo))}}</td>                            
                                    <td>{{$data -> masakredit}} Bln</td>-->
                                    <td>{{number_format($data -> plafon, 0, ',', '.')}}</td>
                                    <td>{{number_format($data -> nett, 0, ',', '.')}}</td>
 <!--                           <td>{{$data ->rate}}</td>
                                    <td>{{number_format($data ->premi, 0, ',', '.')}}</td>
                                    <td>{{number_format($data ->pot, 0, ',', '.')}}</td>
                                    <td>{{number_format($data ->nett, 0, ',', '.')}}</td>-->
                                    <td>
                                        <div class=" btn-group-vertical">
                                            <li> <b> @if($data ->pembayaran)<a target="_blank "  href="files/buktibayar/{{$data ->pembayaran->file}}"  style="color: blue">Download Bukti Bayar</a>@endif</b></li>
                                            <li> <b> <a target="_blank "  href="cetaksuratpengajuan/{{$data ->nosertifikat}}"  style="color: black">Cetak Surat Pengajuan</a></b></li>
                                            <li <?php if($data ->case=='Tidak'){echo 'hidden=""';} ?> > <b > <a style="color:black" target="_blank" href="/cetaksp3/{{$data ->nosertifikat}}">Cetak Surat Persetujuan Prinsip Penjaminan</a></b></li>
                                            <li <?php if($data ->case=='Tidak'){echo 'hidden=""';} ?> > <b > <a style="color:black" target="_blank" href="/cetakrekomendasi/{{$data ->nosertifikat}}">Cetak Rekomendasi</a></b></li>
                                            <li>
                                                <b>
                                                    <a style="color: red" target="_blank " id="{{$data ->idpenjaminan}}" class="logcetaksertifikat"  href="cetaksertifikat/{{$data ->nosertifikat}}" >Cetak Sertifikat</a> 
                                                </b>
                                            </li>
                                            <li <?php if ($data->kesehatan->files == '' ) {echo 'hidden=""';} ?>><a target="_blank" href="files/suratsehat/{{$data->kesehatan -> files}}"><b>Download Surat Sehat Terjamin</b></a></li>
                                            <li <?php if ($data->kesehatan->files3 == '' ) {echo 'hidden=""';;} ?> > <a target="_blank" href="files/suratsehatrs/{{$data->kesehatan -> files3}}"><b>Download Surat Sehat RS</a></b></li>
                                            <li <?php if ($data->kesehatan->files2 == '') { echo 'hidden=""';} ?>><a  target="_blank" href="files/scanlab/{{$data->kesehatan -> files2}}"><b>Download Dokumen Cek Lab</a></b></li>
                                         </div>
                                    </td> 
                                </tr>
                                <?php
                                $i++;
                                $premi   = $premi + $data->premi;
                                $dis         = $dis + $data->pot;
                                $nett       = $nett + $data->nett;
                                ?>
                                @endforeach
                            </tbody>
                        </table>
                          
                      Halaman:  <b>{{$pengajuan->currentPage()}}</b>. 
                      Data Perhalaman: <b>{{$pengajuan->perPage()}} </b>Data.
                      Jumlah Data Keseluruhan :<b> {{number_format($pengajuan->total(),0,',','.')}}</b>.
                      
                        {{$pengajuan->links()}}
                    </div>
                </section>  
            </div>
        </div>
  
   
  
</body>
 
 

@endsection
 