<div id="validasiModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
             <form method="post" id="validation_form_direksi">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                 
                      <input hidden="" id="modalid" >
                    <table style="width: 95%">  
                       <br/>
                        <tr> 
                            <th>        
                                Nomor KTP
                            </th>
                            <th>
                                <input disabled=""  id="ktp" class="form-control">
                            </th> 
                        </tr>
                        
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
                                Pekerjaan
                            </th>
                            <th>
                              <textarea style="resize:none;width:100%;height:100px;"   disabled="" id="pekerjaan" class="form-control"></textarea>   
                            </th>
                            
                        </tr>
                        <tr> 
                            <th>
                               Tanggal Lahir
                            </th>
                            <th>
                                <input disabled="" id="tgllahir" class="form-control">
                            </th>
 
                        </tr> 
                        <tr> 
                            <th>
                                Umur Terjamin Saat jatuh tempo
                            </th>
                            <th>
                                <input disabled="" id="umur" class="form-control">
                            </th>
 
                             
                        </tr> 
                        <tr> 
                            <th>
                                Jenis Kredit
                            </th>
                            <th>
                                <input disabled="" id="jeniskredit" class="form-control">
                            </th>
                        </tr>
                        <tr> 
                            <th>
                                Jenis Penjaminan
                            </th>
                            <th>
                                <input disabled="" id="jenispenjaminan" class="form-control">
                            </th>
                        </tr>
                      
                            <th>
                                <p id="nopkkonpensasi">No PK<p>
                            </th>
                            <th>
                                <input disabled="" id="nopk" class="form-control">
                            </th>
<!--                        <tr> 
                            <th>
                                Periode Pertanggungan
                            </th>
                            <th>
                                <input disabled="" id="periode" class="form-control">
                            </th>
                        </tr>-->
                         <tr> 
                            <th>
                                Masa Kredit
                            </th>
                            <th>
                                <input disabled="" id="masakredit" class="form-control">
                            </th>
                        </tr>
                         <tr> 
                            <th>
                                Plafond
                            </th>
                            <th>
                                <input style=" text-align: right; " disabled=""  id="plafon" class="form-control">
                            </th>
                             
                        </tr>
                        <tr> 
                            <th>
                              Rate
                            </th>
                            <th>
                                <input style=" text-align: right; "  disabled="" id="rate" class="form-control">
                            </th>
                        </tr>
                        <tr> 
                            <th>
                             GROSS IJP
                            </th>
                            <th>
                                <input style=" text-align: right; "  disabled="" id="ijp" class="form-control">
                            </th> 
                        </tr>
                       
                        <tr> 
                            <th>
                                Disc
                            </th>
                            <th>
                                <input style=" text-align: right; "   disabled=""  id="potongan" class="form-control">
                            </th>
                          
                        </tr>
                        <tr> 
                            <th>
                                Nett IJP
                            </th>
                            <th>
                                <input style=" text-align: right; "  disabled="" id="premi" class="form-control">
                            </th>
                        </tr>
                        <tr> 
                            <th>
                                Biaya Admin
                            </th>
                            <th>
                               <input style=" text-align: right; "  disabled="" id="admin" class="form-control">
                            </th>
                        </tr>
                        <tr> 
                            <th>
                                Biaya Materai
                            </th>
                            <th>
                               <input style=" text-align: right; "  disabled="" id="materai" class="form-control">
                            </th>
                        </tr>
                        <tr> 
                            <th>
                                Total Bayar
                            </th>
                            <th>
                               <input style=" text-align: right; "  disabled="" id="totalbayar" class="form-control">
                            </th>
                        </tr>
                        <tr>
                            
                        </tr>
                         <tr> 
                            <th>
                                Surat Keterangan Sehat
                            </th>
                            <th>
                                 <i class="glyphicon glyphicon-download"> </i>  <a id="kesehatan" href="">Download</a>
                                 
                            </th>
                            
                        </tr>
                        <tr> 
                            <th>
                                Surat Keterangan Sehat Dari Rs
                            </th>
                            <th>
                                <i class="glyphicon glyphicon-download"> </i>  <a id="kesehatanrs" href="">Download</a>
                                 
                            </th>
                           
                            
                        </tr>
                        <tr id="ceklabinput"> 
                            <th>
                                Surat Cek Lab
                            </th>
                            <th>
                                <i class="glyphicon glyphicon-download"> </i> <a id="ceklab" href="">Download</a>
                            </th>
                            
                            
                        </tr>     
                    </table>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong>  
                                <h2 align="center">ANALISA DAN REKOMENDASI PENJAMINAN</h2>
                            </strong>
                        </div>
                    </div>
                    <table>
                        <tr> 
                            <th style="color:red">
                               
                            </th>
                        </tr>
                        <tr> 
                            <th>
                                <i class="glyphicon glyphicon-user"> </i> <p>Petugas</p>
                            </th>
                            <th>
                               <input style=" text-align: right; "  disabled="" id="petugas" class="form-control">
                            </th> 
                        </tr>
                        
                        <tr> 
                            <th>
                               <i class="glyphicon glyphicon-asterisk"> </i> <p>Analisa Pekerjaan</p>
                            </th>
                            <th>
                                 <textarea disabled=""  style="resize:none;width:100%;height:300px;"  name="analisa" id="analisa" class="form-control"></textarea>  
                            </th>
                        </tr>
                        <tr> 
                            <th>
                               <i class="glyphicon glyphicon-time"> </i> <p>Analisa Umur</p>
                            </th>
                            <th>
                                 <textarea disabled=""   name="analisaUmur"  id="analisaUmur"  style="resize:none;width:100%;height:300px;"  name="analisaUmur" id="analisaUmur" class="form-control"></textarea>  
                            </th>
                        </tr>
                         <tr> 
                            <th>
                               <i class="glyphicon glyphicon-book"> </i> <p>DATA KESEHATAN </p>
             
                            </th>
                            
                        </tr>
                        <tr>
                            <th>
                             Tensi
                            </th>
                            <th>
                              <input disabled=""  style="width: 60%"  id="Tensi" name="Tensi" class="form-control">
  
                            </th>

                        </tr>
                        <tr>
                            <th>
                                      
                                Glukosa 
                            </th>
                            <th>
                                <input disabled=""  style="width: 60%"   id="Glukosa"  class="form-control">

                            </th>
                        </tr>
                        <tr>
                            <th>
                                Kolesterol 
                            </th>
                            <th>
                              <input disabled="" style="width: 60%"  id="kolesterol" class="form-control">
                            </th>
                        </tr>
                        <tr>
                            <th>
                              
                                Jantung 
                            </th>
                            <th>
                                <input style="width: 60%" disabled=""  id="Jantung" class="form-control">
 
                            </th>

                        </tr>
                        <tr>
                            <th>
                                Analisa Kesehatan
                       
                            </th>
                            <th>
                                 <textarea disabled=""  style="resize:none;width:100%;height:300px;"  name="analisaKesehatan" id="analisaKesehatan" class="form-control"></textarea>  
    
                            </th>
                        </tr>
                        <tr>
                            <th>
                                Rekomendasi
                       
                            </th>
                            <th>
                                 <textarea disabled=""  style="resize:none;width:100%;height:300px;"  name="rekomendasi" id="rekomendasi" class="form-control"></textarea>  
    
                            </th>
                        </tr>
                         <br>
               
                  
                        <tr> 
                            <th>
                               <i class="glyphicon glyphicon-pencil"> </i>  <p>Tanggapan Direksi</p>
                            </th>
                            <th>
                               
                                <textarea required="" style="resize:none;width:400px;height:300px;"  name="tanggapan" id="tangapan" class="form-control"></textarea>
                            </th>
                        </tr>
                        <tr> 
                            <th>
                                <p>APPROVAL</p>
                            </th>
                            <th>
                                 <select id="approval" required="" name="approval" class="form-control">
                                    <option value="">Pilih Approval</option>
                                    <option value="SETUJU">SETUJU</option>                                                
                                    <option value="TOLAK">TOLAK</option>                                               
                                </select>
                            </th>
                        </tr>
                        
                    </table>
                        
                    
                </div>
                <span id="form_output"></span>
                <div class="modal-footer">
                    <input hidden name="validasi" id="validasi"  value="autocover" />  
                    <input hidden="" name="idpenjaminan" id="idpenjaminan" value="" />                     
                    <input id="proses" type="submit" name="submit" id="setuju" value="PROSES" class="btn btn-info" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>



