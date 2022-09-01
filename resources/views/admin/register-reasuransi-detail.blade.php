@extends('layout.admin')
@section('content')
<body ng-app="Penjaminan" ng-controller="PenjaminanController">
     
               
       <div  style=" border-top-style: solid;
                                    border-right-style: solid;
                                    border-bottom-style: solid;
                                    border-left-style: solid;
                                    border-width: 1px;
                                    border-color: #005888;
                                    border-radius: 20px;
                                    margin-left: 3%;
                                     margin-right: 3%;
                                    " 
                    class="panel panel-default">
           <div  style="border-radius: 20px;" class="panel-heading">
                <strong> 
                    <h2 style="color:red" align="center">DATA PENJAMINAN UNTUK REGISTRASI REASURANSI</h2>
                </strong>
            </div>
           <form method="post" name="save_reasuransi" action="{{url('/rekanan/save-reasuransi')}}" enctype="multipart/form-data" >

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
                                    <th>PLAFON</th> 
                                    <th>TGL TERBIT</th> 
                                    <th>NO SERTIFIKAT</th>  
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
                                    <td>{{$data ->namabank}}</td>
                                    <td>{{$data ->nama}}</td>
                                    <td>{{number_format($data ->plafon,0)}}</td>
                                    <td>{{$data ->tglterbit}}</td>
                                    <td>{{$data ->kodesertifikat}}</td>
                                    
                                       <td>
                                        <div class="radio icheck-primary">
                                            <input   id="reas{{$data->idpenjaminan}}" class="radio ktp" type="checkbox" name="datareas[{{$data ->idpenjaminan}}]" value="{{$data ->idpenjaminan}}" /> 
                                            <label  for="reas{{$data->idpenjaminan}}">Proses</label>
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
               
                      <div  style=" border-top-style: solid;
                                    border-right-style: solid;
                                    border-bottom-style: solid;
                                    border-left-style: solid;
                                    border-width: 1px;
                                    border-color: #005888;
                                    border-radius: 20px;
                                    margin-left: 30%;
                                     margin-right: 30%;
                                    " 
                                    
                                    
                    class="panel panel-default">
                          <br>
                          <div style="margin-left: 30px;margin-right: 30px;">
                              <div class="form-group">
                                  <label>Pilih Asuransi/Broker Rekanan<b style="color: red">( * )</b></label>
                                  <select  id="pilihReasuransi" required="" name="id_reasuransi" class="form-control">
                                      <option value="">Pilih Rekanan</option> 
                                      @foreach($reasuransi as $data) 
                                      <option value="{{$data->id}}">{{$data->nama_asuransi}}</option>   
                                      //@if($data->id=='2') selected="" @else @endif  
                                      @endforeach 
                                  </select>    
                              </div>
                              <div class="form-group">
                                  <label>R/I Commision<b style="color: red">( * )</b></label>  
                                  <input  value="25"    style="border-radius: 30px;" required="" name="commision" id="poster" type="input" class="form-control"><br/>
                                  @if($errors->has('commision'))
                                  <p style="color: red"> {{ $errors->first('commision')}}</p>
                                  @endif   
                              </div>
<!--                              <div class="form-group">
                                  <label>Share yang ditawarkan </label>                            
                                  <input value="50"  style="border-radius: 30px;" required=""   class="form-control" name="share">
                              </div>-->


                              <div class="form-group">
                                  <input style="border-radius: 30px; width: 100%;" type="submit"  value="Simpan" id="simpan" class="btn btn-success btn-">
                              </div>   
                          </div>
                         
               </div>
                       
        
               
               {{csrf_field()}}
                </form> 
                    
        </div>
     
    
</body>
 
@endsection

 