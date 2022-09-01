<div id="SignModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="PostSign" method="post" id="SignDireksi">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <center>
                         <h4 class="modal-title">Add Data</h4>
                   </center>
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
                                
                                <input disabled="" id="pekerjaan" class="form-control">
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
                            <th>
                                Masukkan Passphreass
                            </th>
                            <th>
                                <input required="" style=" text-align: right; "  name="passpreas" id="passpreas" class="form-control">
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



