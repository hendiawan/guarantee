@extends('layout.admin')
@section('content')


<ul class="nav nav-tabs">
<!--    <li>
        <button type="button" name="add_button" ng-click="addDataPenjaminan()" class="btn btn-primary">ADD PENJAMINAN</button>
    </li>  -->
</ul>
<div class="container">
    
    
    <body ng-app="Penjaminan" ng-controller="PenjaminanController">
    <div class="panel panel-default">
    <div class="panel-heading">
        <strong>
            <h2 align="center">PENGAJUAN PENJAMINAN KREDIT CASE BY CASE</h2>
            <h2 align="center">SUDAH PROSES BAYAR</h2>
            <h2 align="center">{{$pengajuan[0]['namabank']}}</h2>
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
                                <th>TGL PENGAJUAN</th>                           
                                <th>TGL BAYAR</th>                      
                                <th>TERJAMIN</th>                      
                                <th>JNS KREDIT</th>               
                                <th>LAMA PENJAMINAN</th>                           
                                <th>PLAFON</th>                   
                                <th>AGING</th>             
                                <th>PROSES</th>                           
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $premi = 0;
                            $dis = 0;
                            $nett = 0;
                             function aging($tanggal) {
                                $tanggal1 = new DateTime($tanggal);
                                $tanggal2 = new DateTime();
                                return  $aging = $tanggal2->diff($tanggal1)->format("%a");
                            }
                            
                            ?>
                            @foreach($pengajuan as $data)
                           <?php
                           
                           if ($data -> tglbayar!=''){
                                $bayar=date('d-m-Y', strtotime($data -> tglbayar));
                                $kode=$data -> kodebayar;
                           }else{
                               $bayar='Belum Bayar';
                               $kode='Belum Bayar';
                           }
                            
                           ?>
                            <tr style="background-color:#bdbdbd ;color: #000000">  
                                <td>{{$i}}</td>
                                <td>{{date('d-m-Y', strtotime($data -> tglpengajuan))}}</td>    
                                <td>{{$bayar}}</td> 
                                <td>{{$data -> nama}}</td>                                                        
                                <td>{{$data -> jeniskredit}}</td>                          
                                <td>{{$data -> masakredit}} Bln</td>
                                <td>{{number_format($data -> plafon, 0, ',', '.')}}</td>
                              
                                <td><b><p style="color: red;font-size: 15px">{{aging($data -> tglpengajuan) }}</p></b>Hari</td>
                                                       
                                <td><a id="{{$data ->idpenjaminan}}" class="btn btn-xs btn-primary validasicase">Validasi</a></td>                         

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
    
    <div id="validasiCaseModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
             <form method="post" id="validation_form_bayar">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <span id="form_output"></span>
                    <input hidden="" id="modalid" >     
                    <table>                        
                         
                        <tr> 
                            <th>
                               Nama Terjamin
                            </th>
                            <th>
                                <input disabled="" id="nama" class="form-control">
                            </th>  
                        </tr>
                        <tr> 
                            <th>
                                IJP
                            </th>
                            <th>
                                <input disabled="" id="premi" class="form-control">
                            </th>  
                        </tr>
                        <tr> 
                            <th>
                               Dis
                            </th>
                            <th>
                                <input disabled="" id="potongan" class="form-control">
                            </th>  
                        </tr>
                        <tr> 
                            <th>
                                Nett IJP
                            </th>
                            <th>
                                <input disabled="" id="nett" class="form-control">
                            </th>  
                        </tr>
                        <tr> 
                            <th>
                                Biaya Admin
                            </th>
                            <th>
                                <input disabled="" id="admin" class="form-control">
                            </th>  
                        </tr>
                        <tr> 
                            <th>
                                Biaya Materai
                            </th>
                            <th>
                                <input disabled="" id="materai" class="form-control">
                            </th>  
                        </tr>
                        <tr> 
                            <th>
                                Total Bayar
                            </th>
                            <th>
                                <input disabled="" id="totalbayar" class="form-control">
                            </th>  
                        </tr>
                        <tr> 
                            <th>
                                Bukti Bayar
                            </th>
                            <th>
                                <a id="pembayaran" href="">Download</a>
                            </th>
                            <th>                        <input id="validasibayar" class="radio bayar" type="radio" name="pembayaran" value="Ok" /> 
                            </th>
                            <th>Ok &nbsp</th>
                            <th>                        <input id="validasibayar" class="radio bayar" type="radio" name="pembayaran" value="Tolak" />
                            </th>
                            <th>Tolak </th>
                        </tr>
                        <tr> 
                            <th>
                               Analisa Penjaminan
                            </th>
                            
                            <th>
                                <textarea name="analisa" id="analisa" class="form-control">
                           
                                </textarea>
                            </th> 
                        </tr>
                    </table>
                        
                    
                </div>
                <div class="modal-footer">
                    <input hidden="" name="validasi" id="validasi" value="casebycasebayar" />   
                    <input hidden="" name="idpenjaminan" id="idpenjaminan" value="" />                     
                    <input type="submit" name="submit" id="action" value="Add" class="btn btn-info" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body> 
</div>
  
<br>
<br>
@endsection

 