<div id="validasiModal" class="modal fade " role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content ">
             <form method="post" id="validation_form">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <center> <h3 class="modal-title">Add Data</h3></center> 
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <input hidden="" id="modalid" >     
                    <table >  
                       <br/>

                        <tr> 
                            <th>        
                                Nomor KTP
                            </th>
                            <th>
                                <input style="width: 380px;background-color:bisque"   disabled="" id="ktp" class="form-control">
                            </th>
                            <th>
                                <div class="radio icheck-primary">
                                    <input checked="" id="validasiktp" class="radio ktp" type="radio" name="ktp" value="Ok" /> 
                                     <label for="validasiktp">SESUAI</label>
                                </div>
                            </th>       
<!--                            <th>
                                 <div class="radio icheck-danger">
                                     <input  id="validasiktp1" class="radio ktp" type="radio" name="ktp" value="Tolak" />
                                     <label for="validasiktp1">TIDAK</label>
                                </div>
                            </th>-->
                            
                        </tr>
                        <tr> 
                            <th>
                                Nama Terjamin
                            </th>
                            <th>
                                <input disabled="" id="nama" class="form-control">
                            </th>
                            <th>
                                 <div class="radio icheck-primary">
                                     <input checked="" id="validasinama" class="radio nama" type="radio" name="nama" value="Ok" /> 
                                     <label for="validasinama">SESUAI</label>
                                </div>     
                            </th>  
<!--                            <th>
                                <div class="radio icheck-danger">
                                     <input  id="validasinama1" class="radio nama" type="radio" name="nama" value="Tolak" />
                                     <label for="validasinama1">TIDAK</label>
                                </div>    
                            </th>    -->
                        </tr>
                        <tr> 
                            <th>
                               No Telepon
                            </th>
                            <th>
                                <input disabled="" id="phone" class="form-control">
                            </th>
                            <th>
                                 <div class="radio icheck-primary">
                                     <input checked="" id="phone" class="radio nama" type="radio" name="phone" value="Ok" /> 
                                     <label for="phone">SESUAI</label>
                                </div>     
                            </th>  
<!--                            <th>
                                <div class="radio icheck-danger">
                                     <input  id="validasinama1" class="radio nama" type="radio" name="nama" value="Tolak" />
                                     <label for="validasinama1">TIDAK</label>
                                </div>    
                            </th>    -->
                        </tr>
                        <tr> 
                            <th>
                                Pekerjaan
                            </th>
                            <th>
                                
                                <input style="background-color:bisque" disabled="" id="pekerjaan" class="form-control">
                            </th>
                            <th> 
                                 <div class="radio icheck-primary">
                                     <input checked="" id="validasipekerjaan1" class="radio" type="radio" name="pekerjaan" value="Ok" /> 
                                     <label for="validasipekerjaan1">SESUAI</label>
                                </div>  
                            </th>
                      
<!--                            <th>  
                                <div class="radio icheck-danger">
                                     <input  id="validasipekerjaan" class="radio" type="radio" name="pekerjaan" value="Tolak" />
                                     <label for="validasipekerjaan">TIDAK</label>
                                </div> 
                            </th>-->
                            
                        </tr>
                        <tr> 
                            <th>
                               Tanggal Lahir
                            </th>
                            <th>
                                <input disabled="" id="tgllahir" class="form-control">
                            </th>
                            <th>
                                <div class="radio icheck-primary">
                                    <input checked="" id="validasitgllahir" class="radio tgllahir" type="radio" name="tgllahir" value="Ok" /> 
                                     <label for="validasitgllahir">SESUAI</label>
                                </div>  
                            </th>
<!--                            <th>
                                <div class="radio icheck-danger">
                                <input id="validasitgllahir1" class="radio tgllahir" type="radio" name="tgllahir" value="Tolak" />
                                     <label for="validasitgllahir1">TIDAK</label>
                                </div>  
                            </th>-->
                        </tr> 
                        <tr> 
                            <th>
                                Umur Terjamin Saat jatuh tempo
                            </th>
                            <th>
                                <input style="background-color:bisque" disabled="" id="umur" class="form-control">
                            </th>
                            <th>  
                                <div class="radio icheck-primary">
                                    <input checked="" id="validasiumur" class="radio umur" type="radio" name="umur" value="Ok" /> 
                                     <label for="validasiumur">SESUAI</label>
                                </div>  
                            </th>
<!--                            <th>  
                                <div class="radio icheck-danger">
                                <input  id="validasiumur1" class="radio umur" type="radio" name="umur" value="Tolak" />
                                     <label for="validasiumur1">TIDAK</label>
                                </div>  
                            </th>-->
                             
                        </tr> 
                        <tr> 
                            <th>
                                Jenis Kredit
                            </th>
                            <th>
                                <input disabled="" id="jeniskredit" class="form-control">
                            </th>
                            
                            <th>    
                                 <div class="radio icheck-primary">
                                     <input checked="" id="validasijeniskredit1" class="radio jeniskredit" type="radio" name="jeniskredit" value="Ok" /> 
                                     <label for="validasijeniskredit1">SESUAI</label>
                                </div>  
                            </th>
<!--                            <th>    
                                <div class="radio icheck-danger">
                                <input  id="validasijeniskredit" class="radio jeniskredit" type="radio" name="jeniskredit" value="Tolak" />
                                     <label for="validasijeniskredit">TIDAK</label>
                                </div>  
                            </th>-->
                             
                        </tr>
                        <tr> 
                            <th>
                                Jenis Penjaminan
                            </th>
                            <th>
                                <textarea style="background-color:bisque"disabled="" id="jenispenjaminan" class="form-control"></textarea>
                            </th>
                            <th>
                                <div class="radio icheck-primary">
                                    <input checked="" id="validasijenijp" class="radio jenispenjaminan" type="radio" name="jenispenjaminan" value="Ok" /> 
                                    <label for="validasijenijp">SESUAI</label>
                                </div>  
                            </th>
<!--                            <th>
                                <div class="radio icheck-danger">
                                <input  id="validasijenijp1" class="radio jenispenjaminan" type="radio" name="jenispenjaminan" value="Tolak" />
                                     <label for="validasijenijp1">TIDAK</label>
                                </div>  
                            </th>-->
                           
                           
                        </tr>
                        <tr> 
                            <th>
                                <p id="nopkkonpensasi">No PK<p>
                            </th>
                            <th>
                                <input disabled="" id="nopk" class="form-control">
                            </th>
                            <th>
                                <div class="radio icheck-primary">
                                    <input checked="" id="validasinopk1" class="radio nopk" type="radio" name="nopk" value="Ok" /> 
                                     <label for="validasinopk1">SESUAI</label>
                                </div> 
                            </th>
<!--                            <th>
                                <div class="radio icheck-danger">
                                <input  id="validasinopk" class="radio jenispenjaminan" type="radio" name="nopk" value="Tolak" />
                                     <label for="validasinopk">TIDAK</label>
                                </div> 
                            </th>-->
                             
                        <tr> 
                            <th>
                                Periode Pertanggungan
                            </th>
                            <th>
                                <input style="background-color:bisque" disabled="" id="periode" class="form-control">
                            </th>
                            <th>  
                                <div class="radio icheck-primary">
                                    <input checked="" id="validasiperiode" class="radio  periode" type="radio" name="periode" value="Ok" /> 
                                     <label for="validasiperiode">SESUAI</label>
                                </div> 
                            </th>
<!--                            <th>  
                                <div class="radio icheck-danger">
                                <input id="validasiperiode1" class="radio periode" type="radio" name="periode" value="Tolak" />
                                     <label for="validasiperiode1">TIDAK</label>
                                </div> 
                            </th>-->
                           
                        </tr>
                         <tr> 
                            <th>
                                Masa Kredit
                            </th>
                            <th>
                                <input disabled="" id="masakredit" class="form-control">
                            </th>
                            <th> 
                                <div class="radio icheck-primary">
                                    <input checked="" id="validasimasaKredit1" class="radio  masaKredit" type="radio" name="masaKredit" value="Ok" /> 
                                     <label for="validasimasaKredit1">SESUAI</label>
                                </div> 
                            </th>
<!--                            <th> 
                                <div class="radio icheck-danger">
                                <input id="validasimasaKredit" class="radio masaKredit" type="radio" name="masaKredit" value="Tolak" />
                                     <label for="validasimasaKredit">TIDAK</label>
                                </div> 
                            </th>-->
                           
                        </tr>
                         <tr> 
                            <th>
                                Plafond
                            </th>
                            <th>
                                <input    style=" background-color:bisque;text-align: right; " disabled=""  id="plafon" class="form-control">
                            </th>
                            <th>
                                <div class="radio icheck-primary">
                                    <input checked="" id="validasiplafond1" class="radio  plafond" type="radio" name="plafon" value="Ok" /> 
                                     <label for="validasiplafond1">SESUAI</label>
                                </div> 
                            </th>
<!--                            <th>
                                <div class="radio icheck-danger">
                                <input id="validasiplafond" class="radio plafond" type="radio" name="plafon" value="Tolak" />
                                     <label for="validasiplafond">TIDAK</label>
                                </div> 
                            </th>-->
                             
                        </tr>
                        <tr> 
                            <th>
                              Rate
                            </th>
                            <th>
                                <input style=" text-align: right; "  disabled="" id="rate" class="form-control">
                            </th>
                            <th> 
                                <div class="radio icheck-primary">
                                <input checked="" id="validasirate" class="radio" type="radio" name="rate" value="Ok" /> 
                                     <label for="validasirate">SESUAI</label>
                                </div> 
                            </th>
<!--                            <th> 
                                <div class="radio icheck-danger">
                                    <input  id="validasirate1" class="radio" type="radio" name="rate" value="Tolak" />
                                     <label for="validasirate1">TIDAK</label>
                                </div> 
                            </th>-->
                             
                        </tr>
                        <tr> 
                            <th>
                             GROSS IJP
                            </th>
                            <th>
                                <input   style=" background-color:bisque; text-align: right; "  disabled="" id="ijp" class="form-control">
                            </th> 
                            
                            <th>    
                                <div class="radio icheck-primary">
                                <input  checked=""  id="validasiijp" class="radio" type="radio" name="ijp" value="Ok" /> 
                                     <label for="validasiijp">SESUAI</label>
                                </div> 
                            </th>
<!--                            <th>    
                                <div class="radio icheck-danger">
                                <input id="validasiijp1" class="radio" type="radio" name="ijp" value="Tolak" />
                                     <label for="validasiijp1">TIDAK</label>
                                </div> 
                            </th>-->
                             
                        </tr>
                       
                        <tr> 
                            <th>
                                Disc
                            </th>
                            <th>
                                <input style=" text-align: right; "   disabled=""  id="potongan" class="form-control">
                            </th>
                            <th>   
                                <div class="radio icheck-primary">
                                <input  checked=""  id="validasidiscount1" class="radio  potongan" type="radio" name="potongan" value="Ok" /> 
                                     <label for="validasidiscount1">SESUAI</label>
                                </div> 
                            </th>
                           
<!--                            <th>   
                                <div class="radio icheck-danger">
                                <input id="validasidiscount" class="radio potongan" type="radio" name="potongan" value="Tolak" />
                                     <label for="validasidiscount">TIDAK</label>
                                </div> 
                            </th>-->
                          
                        </tr>
                        <tr> 
                            <th>
                                <p style="color: red"><b>Nett IJP</b></p>
                            </th>
                            <th>
                                <input style=" background-color:bisque;text-align: right; "  disabled="" id="premi" class="form-control">
                            </th>
                            <th>
                                <div class="radio icheck-primary">
                                <input  checked=""  id="validasipremi" class="radio  premi" type="radio" name="premi" value="Ok" /> 
                                     <label for="validasipremi">SESUAI</label>
                                </div> 
                            </th>
                        
<!--                            <th>
                                <div class="radio icheck-danger">
                                <input id="validasipremi1" class="radio premi" type="radio" name="premi" value="Tolak" />
                                     <label for="validasipremi1">TIDAK</label>
                                </div> 
                            </th>-->
                          
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
                                 <p style="color: red">Total Bayar</p>
                            </th>
                            <th>
                               <input   style="background-color:bisque; text-align: right; "  disabled="" id="totalbayar" class="form-control">
                            </th>
                        </tr>
                        <tr> 
                            <th>
                                Bukti Bayar
                            </th>
                            <th>
                                <a id="pembayaran" href="" >Download</a>
                            </th>
                            <th> 
                                <div class="radio icheck-primary">
                                <input  checked="" id="validasibayar" class="radio bayar" type="radio" name="pembayaran" value="Ok" /> 
                                     <label for="validasibayar">SESUAI</label>
                                </div> 
                            </th> 
                        </tr>
                        <tr> 
                            <th>
                                Surat Pernyataan Sehat
                            </th>
                            <th>
                                <a id="kesehatan"  href="" >Download</a>
                                 
                            </th>
                            <th> 
                                <div class="radio icheck-primary">
                                    <input checked="" id="validasikesehatan" class="radio kesehatan" type="radio" name="kesehatan" value="Ok" /> 
                                     <label for="validasikesehatan">SESUAI</label>
                                </div> 
                            </th>
<!--                            <th> 
                                <div class="radio icheck-danger">
                                <input id="validasikesehatan1" class="radio kesehatan" type="radio" name="kesehatan" value="Tolak" />
                                     <label for="validasikesehatan1">TIDAK</label>
                                </div> 
                            </th>-->
                            
                        </tr>
                        <tr id="kesehatanrstable"> 
                            <th>
                                Surat Keterangan Sehat RS
                            </th>
                            <th>
                                <a id="kesehatanrs"  href="" target="output">Download</a>
                                 
                            </th>
                            <th> 
                                <div class="radio icheck-primary">
                                    <input checked="" id="validasikesehatanrs" class="radio kesehatanrs" type="radio" name="kesehatanrs" value="Ok" /> 
                                     <label for="validasikesehatanrs">SESUAI</label>
                                </div> 
                            </th>
<!--                            <th> 
                                <div class="radio icheck-danger">
                                <input id="validasikesehatan1" class="radio kesehatan" type="radio" name="kesehatan" value="Tolak" />
                                     <label for="validasikesehatan1">TIDAK</label>
                                </div> 
                            </th>-->
                            
                        </tr>
                        
                        <tr id="ceklabinput"> 
                            <th>
                                Surat Cek Lab
                            </th>
                            <th>
                                <a id="ceklab"   href=""   >Download</a>
                            </th>
                            <th> 
                                <div class="radio icheck-primary">
                                <input checked=""  id="validasiceklab"  class="radio ceklab" type="radio" name="ceklab" value="Ok" /> 
                                     <label for="validasiceklab">SESUAI</label>
                                </div> 
                            </th>
                        </tr>   
                        
                        <tr id="tblGrace" class="hidden">
                              <th>
                                <p>Grace Periode : </p>
                            </th>
                              <th>
                                  <p id="ketGracePeriode"></p>
                            </th>
                        </tr>
                            <th>
                                <p>ANALISA PENJAMINAN</p>
                            </th>
                            <th>
                            </th>
                            
                        </tr>
                        <tr> 
                             
                        </tr>
                    </table>
                    <br>
                    <textarea style="resize:true;height:120px;" value="" name="analisa" id="analisa" class="form-control"></textarea>
                    <br>   
                    
                    <div id="peringatan"></div>
                    <span id="form_output"></span>
                    <b>HISTORY APPROVAL</b>
                    <p id="notification"></p>
                    <br>
                    <br>
                    <p id="historyApproval"></p>
                </div>
                <div class="modal-footer">
                    <input hidden="" name="case" id="case" value="Tidak"/>  
                    <input hidden="" name="validasi" id="validasi"  value="autocover" />  
                    <input hidden="" name="idpenjaminan" id="idpenjaminan" value="" /> 
                    <button   class="btn btn-danger tolak"><i class="glyphicon glyphicon-stop"></i> Tolak</button>
                    <button   class="btn btn-warning revisi"><i class="glyphicon glyphicon-repeat"></i> Revisi</button>
                    <button  class="btn btn-success proses"><i class="glyphicon glyphicon-check"></i> Proses</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i></button>

                </div>
            </form>
        </div>
    </div>
</div>



