 <div id="validasiCaseBelumBayarModal" class="modal fade" role="dialog">
     <div class="modal-dialog">
        <div class="modal-content">
             <form method="post" id="validation_form_case">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}

                    <input hidden="" id="modalid" >     
                    <table>                        
                         <tr> 
                            <th>        
                                Nomor KTP
                            </th>
                            <th>
                                <input disabled="" id="ktp" class="form-control">
                            </th>
                            <th>
                                <div class="radio icheck-primary">
                                     <input id="validasiktp" class="radio ktp" type="radio" name="ktp" value="Ok" /> 
                                     <label for="validasiktp">SESUAI</label>
                                </div>
                            </th>       
                            <th>
                                 <div class="radio icheck-danger">
                                     <input  id="validasiktp1" class="radio ktp" type="radio" name="ktp" value="Tolak" />
                                     <label for="validasiktp1">TIDAK</label>
                                </div>
                            </th>
                            
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
                                     <input id="validasinama" class="radio nama" type="radio" name="nama"  value="Ok" /> 
                                     <label for="validasinama">SESUAI</label>
                                </div>     
                            </th>  
                            <th>
                                <div class="radio icheck-danger">
                                     <input  id="validasinama1" class="radio nama" type="radio" name="nama" value="Tolak" />
                                     <label for="validasinama1">TIDAK</label>
                                </div>    
                            </th>    
                        </tr>
                        <tr> 
                            <th>
                                Pekerjaan
                            </th>
                            <th>
                              <textarea style="resize:none;width:100%;height:100px;"   disabled="" id="pekerjaan" class="form-control"></textarea>   
                            </th>
                            <th> 
                                 <div class="radio icheck-primary">
                                     <input id="validasipekerjaan1" class="radio" type="radio" name="pekerjaan" value="Ok" /> 
                                     <label for="validasipekerjaan1">SESUAI</label>
                                </div>  
                            </th>
                      
                            <th>  
                                <div class="radio icheck-danger">
                                     <input  id="validasipekerjaan" class="radio" type="radio" name="pekerjaan" value="Tolak" />
                                     <label for="validasipekerjaan">TIDAK</label>
                                </div> 
                            </th>
                            
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
                                <input id="validasitgllahir" class="radio tgllahir" type="radio" name="tgllahir" value="Ok" /> 
                                     <label for="validasitgllahir">SESUAI</label>
                                </div>  
                            </th>
                            <th>
                                <div class="radio icheck-danger">
                                <input id="validasitgllahir1" class="radio tgllahir" type="radio" name="tgllahir" value="Tolak" />
                                     <label for="validasitgllahir1">TIDAK</label>
                                </div>  
                            </th>
                        </tr> 
                        <tr> 
                            <th>
                                Umur Terjamin Saat jatuh tempo
                            </th>
                            <th>
                                <input disabled="" id="umur" class="form-control">
                            </th>
                            <th>  
                                <div class="radio icheck-primary">
                                <input id="validasiumur" class="radio umur" type="radio" name="umur" value="Ok" /> 
                                     <label for="validasiumur">SESUAI</label>
                                </div>  
                            </th>
                            <th>  
                                <div class="radio icheck-danger">
                                <input  id="validasiumur1" class="radio umur" type="radio" name="umur" value="Tolak" />
                                     <label for="validasiumur1">TIDAK</label>
                                </div>  
                            </th>
                             
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
                                <input id="validasijeniskredit1" class="radio jeniskredit" type="radio" name="jeniskredit" value="Ok" /> 
                                     <label for="validasijeniskredit1">SESUAI</label>
                                </div>  
                            </th>
                            <th>    
                                <div class="radio icheck-danger">
                                <input  id="validasijeniskredit" class="radio jeniskredit" type="radio" name="jeniskredit" value="Tolak" />
                                     <label for="validasijeniskredit">TIDAK</label>
                                </div>  
                            </th>
                             
                        </tr>
                        <tr> 
                            <th>
                                Jenis Penjaminan
                            </th>
                            <th>
                            <textarea style="background-color:bisque"disabled="" id="jenispenjaminan" class="form-control"></textarea>

                                <!--<input disabled="" id="jenispenjaminan" class="form-control">-->
                            </th>
                            <th>
                                <div class="radio icheck-primary">
                                <input id="validasijenijp" class="radio jenispenjaminan" type="radio" name="jenispenjaminan" value="Ok" /> 
                                     <label for="validasijenijp">SESUAI</label>
                                </div>  
                            </th>
                            <th>
                                <div class="radio icheck-danger">
                                    <input   id="validasijenijp1" class="radio jenispenjaminan" type="radio" name="jenispenjaminan" value="Tolak" />
                                     <label for="validasijenijp1">TIDAK</label>
                                </div>  
                            </th>
                           
                           
                        </tr>
                        <tr hidden="">
                            <th>
                                No PK
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
                            <th>
                                <div class="radio icheck-danger">
                                <input  id="validasinopk" class="radio jenispenjaminan" type="radio" name="nopk" value="Tolak" />
                                     <label for="validasinopk">TIDAK</label>
                                </div> 
                            </th>
                        </tr> 
                        <tr hidden=""> 
                            <th>
                                Periode Pertanggungan
                            </th>
                            <th>
                                <input disabled="" id="periode" class="form-control">
                            </th>
                            <th>  
                                <div class="radio icheck-primary">
                                    <input checked="" id="validasiperiode" class="radio  periode" type="radio" name="periode" value="Ok" /> 
                                     <label for="validasiperiode">SESUAI</label>
                                </div> 
                            </th>
                            <th>  
                                <div class="radio icheck-danger">
                                <input id="validasiperiode1" class="radio periode" type="radio" name="periode" value="Tolak" />
                                     <label for="validasiperiode1">TIDAK</label>
                                </div> 
                            </th>
                           
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
                                <input id="validasimasaKredit1" class="radio  masaKredit" type="radio" name="masaKredit" value="Ok" /> 
                                     <label for="validasimasaKredit1">SESUAI</label>
                                </div> 
                            </th>
                            <th> 
                                <div class="radio icheck-danger">
                                <input id="validasimasaKredit" class="radio masaKredit" type="radio" name="masaKredit" value="Tolak" />
                                     <label for="validasimasaKredit">TIDAK</label>
                                </div> 
                            </th>
                           
                        </tr>
                         <tr> 
                            <th>
                                Plafond(Rp.)
                            </th>
                            <th>
                                <input style=" text-align: right; " disabled=""  id="plafon" class="form-control">
                            </th>
                            <th>
                                <div class="radio icheck-primary">
                                <input id="validasiplafond1" class="radio  plafond" type="radio" name="plafon" value="Ok" /> 
                                     <label for="validasiplafond1">SESUAI</label>
                                </div> 
                            </th>
                            <th>
                                <div class="radio icheck-danger">
                                <input id="validasiplafond" class="radio plafond" type="radio" name="plafon" value="Tolak" />
                                     <label for="validasiplafond">TIDAK</label>
                                </div> 
                            </th>
                             
                        </tr>
                        <tr> 
                            <th>
                              Rate(%)
                            </th>
                            <th>
                                <input style="background-color:#ce8483" name="rate" style=" text-align: right; "    id="ratecase" class="form-control">
                            </th>
                            <th> 
                                <div class="radio icheck-primary">
                                    <input   id="validasirate" class="radio" type="radio" name="rate" value="Ok" /> 
                                    <label for="validasirate">SESUAI</label>
                                </div> 
                            </th>
                            <th> 
                                <div class="radio icheck-danger">
                                <input id="validasirate1" class="radio" type="radio" name="rate" value="Tolak" />
                                     <label for="validasirate1">TIDAK</label>
                                </div> 
                            </th>
                             
                        </tr>
                        <tr> 
                            <th>
                             GROSS IJP(Rp.)
                            </th>
                            <th>
                                <input hidden="" style=" text-align: right; " id="ijp1" class="form-control">
                                <input style=" text-align: right; "  disabled="" id="ijp" class="form-control">
                            </th> 
                            
                            <th>    
                                <div class="radio icheck-primary">
                                    <input id="validasiijp" class="radio" type="radio" name="ijp" value="Ok" /> 
                                     <label for="validasiijp">SESUAI</label>
                                </div> 
                            </th>
                            <th>    
                                <div class="radio icheck-danger">
                                <input id="validasiijp1" class="radio" type="radio" name="ijp" value="Tolak" />
                                     <label for="validasiijp1">TIDAK</label>
                                </div> 
                            </th>
                             
                        </tr>
                       
                        <tr> 
                            <th>
                                Disc(Rp.)
                            </th>
                            <th>
                                <input hidden="" style=" text-align: right; "      id="potongan1" class="form-control">
                                <input style=" text-align: right; "   disabled=""  id="potongan" class="form-control">
                            </th>
                            <th>   
                                <div class="radio icheck-primary">
                                    <input  id="validasidiscount1" class="radio  potongan" type="radio" name="potongan" value="Ok" /> 
                                    <label for="validasidiscount1">SESUAI</label>
                                </div> 
                            </th>
                           
                            <th>   
                                <div class="radio icheck-danger">
                                <input id="validasidiscount" class="radio potongan" type="radio" name="potongan" value="Tolak" />
                                     <label for="validasidiscount">TIDAK</label>
                                </div> 
                            </th>
                          
                        </tr>
                        <tr> 
                            <th>
                                Nett IJP(Rp.)
                            </th>
                            <th>
                                <input hidden="" style=" text-align: right; "  id="premi1" class="form-control">
                                <input style=" text-align: right; "  disabled="" id="premi" class="form-control">
                            </th>
                            <th>
                                <div class="radio icheck-primary">
                                    <input id="validasipremi" class="radio  premi" type="radio" name="premi" value="Ok" /> 
                                     <label for="validasipremi">SESUAI</label>
                                </div> 
                            </th>
                        
                            <th>
                                <div class="radio icheck-danger">
                                <input id="validasipremi1" class="radio premi" type="radio" name="premi" value="Tolak" />
                                     <label for="validasipremi1">TIDAK</label>
                                </div> 
                            </th>
                          
                        </tr>
                        <tr> 
                            <th>
                                Surat Keterangan Sehat
                            </th>
                            <th>
                                <a target="_blank"  id="kesehatan" href="">Download</a>
                                 
                            </th>
                            <th> 
                                <div class="radio icheck-primary">
                                <input id="validasikesehatan" class="radio kesehatan" type="radio" name="kesehatan" value="Ok" /> 
                                     <label for="validasikesehatan">SESUAI</label>
                                </div> 
                            </th>
                            <th> 
                                <div class="radio icheck-danger">
                                <input id="validasikesehatan1" class="radio kesehatan" type="radio" name="kesehatan" value="Tolak" />
                                     <label for="validasikesehatan1">TIDAK</label>
                                </div> 
                            </th>
                            
                        </tr>
                        <tr> 
                            <th>
                                Surat Keterangan Sehat Dari Rs
                            </th>
                            <th>
                                <a target="_blank" id="kesehatanrs" href="">Download</a>
                                 
                            </th>
                            <th> 
                                <div class="radio icheck-primary">
                                <input id="validasikesehatanrs" class="radio kesehatan" type="radio" name="kesehatanrs" value="Ok" /> 
                                     <label for="validasikesehatanrs">SESUAI</label>
                                </div> 
                            </th>
                            <th> 
                                <div class="radio icheck-danger">
                                <input id="validasikesehatanrs1" class="radio kesehatan" type="radio" name="kesehatanrs" value="Tolak" />
                                     <label for="validasikesehatanrs1">TIDAK</label>
                                </div> 
                            </th>
                            
                        </tr>
                        
                        <tr id="ceklabinput"> 
                            <th>
                                Surat Cek Lab
                            </th>
                            <th>
                                <a target="_blank" id="ceklab" href="">Download</a>
                            </th>
                            <th> 
                                <div class="radio icheck-primary">
                                <input id="validasiceklab"  class="radio ceklab" type="radio" name="ceklab" value="Ok" /> 
                                     <label for="validasiceklab">SESUAI</label>
                                </div> 
                            </th>
                            <th> 
                                <div class="radio icheck-danger">
                                <input id="validasiceklab1"  class="radio ceklab" type="radio" name="ceklab" value="Tolak" />
                                     <label for="validasiceklab1">TIDAK</label>
                                </div> 
                            </th>
                        </tr>   
                        
                        
                        <tr id="pembayaraninput"> 
                            <th>
                               Bukti Bayar
                            </th>
                            <th>
                             
                                <a target="_blank" id="pembayaran" href="">Download</a>
                            </th>
                            <th> 
                                <div class="radio icheck-primary">
                                <input id="validasipembayaran"  class="radio buktibayar" type="radio" name="pembayaran" value="Ok" /> 
                                     <label for="validasipembayaran">SESUAI</label>
                                </div> 
                            </th>
                            <th> 
                                <div class="radio icheck-danger">
                                    <input  id="validasipembayaran1"  class="radio buktibayar" type="radio" name="pembayaran" value="Tolak" />
                                     <label for="validasipembayaran1">TIDAK</label>
                                </div> 
                            </th>
                            
                        </tr>                       
                        
                        <tr> 
                            <th>
                                
                           
                            </th>
                            <th>
                            </th>
                        </tr>
                       
                    </table>
                    <br>
                    
                    <div id="FormAnalisa">
                    <p><b>Analisa Pekerjaan</b></p>
                    <textarea style="resize:none;width:100%;height:300px;"  name="analisa" id="analisa" class="form-control"></textarea>  
                    <p><b>Analisa Umur dan Fasilitas Kredit</b></p>
                    <textarea style="resize:none;width:100%;height:300px;"  name="analisaUmur" id="analisaUmur" class="form-control"></textarea>  
                    <br>
                    <p><b>DATA KESEHATAN</b></p>
                    <p>Tekanan Darah</p>
                    <input  id="TekananDarah" name="TekananDarah" class="form-control">
                    <p>Gula Darah</p>
                    <input  id="GulaDarah" name="GulaDarah" class="form-control">
                    <p>Kolesterol</p>
                    <input  id="Kolesterol" name="Kolesterol" class="form-control">
                    <p>Tekanan Jantung</p>
                    <input  id="Tekananjantung" name="Tekananjantung" class="form-control">
                    <p><b>Analisa Kesehatan</b></p>
                    <textarea style="resize:none;width:100%;height:300px;"  name="analisaKesehatan" id="analisaKesehatan" class="form-control"></textarea>  
                    <br>
                    <p><b>Hasil Akhir & Rekomendasi</b></p>
                    <textarea style="resize:none;width:100%;height:300px;"  name="hasilakhir" id="hasilakhir" class="form-control"></textarea>  
                    <br>
                    </div>
                    <div id="FormCatatanPembayaran">
                      <p><b>Catatan Pembayaran</b></p>
                      <textarea style="resize:none;width:100%;height:300px;"  name="catatanPembayaran" id="catatanPembayaran" class="form-control"></textarea>  
                    </div>
                    <b>HISTORY APPROVAL</b>
                    <br>
                    <br>
                    <p id="historyApproval"></p>
                </div>
                 <div class="modal-footer">
                      <span id="form_output"></span> 
                 </div>
                
                <div class="modal-footer">
                    <input hidden="" name="case" id="case" value="Ya" />  
                    <input hidden="" name="cek_pembayaran" id="cek_pembayaran"/>                     
                    <input hidden="" name="validasi" id="validasi"  value="casebycase" />                     
                    <input hidden="" name="idpenjaminan" id="idpenjaminan" value="" />                     
                    <!--<input  type="submit" name="submit" id="action" value="Proses" class="btn btn-info" />-->
                    <button   class="btn btn-danger tolakCase"><i class="glyphicon glyphicon-stop"></i> Tolak</button>
                    <button   class="btn btn-warning revisiCase"><i class="glyphicon glyphicon-repeat"></i> Revisi</button>
                    <button   class="btn btn-success prosesCase"><i class="glyphicon glyphicon-check"></i> Proses</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>