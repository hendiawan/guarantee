<div id="modalsertifikat" class="modal fade" role="dialog">
  
    <div class="modal-dialog">
        <div class="modal-content">
             <form method="post" id="sertifikat_form">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title">TERBITKAN SERTIFIKAT</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <span id="form_output"></span>
                    <input hidden="" id="modalid" >     
                    <table style="width: 100%"> 
                        <tr> 
                            <th>
                                <p>NO. SERTIFIKAT</p>
                            </th>
                            <th>
                                <input style="background-color: #ce8483"  id="sertifikat" class="form-control">
                                <input hidden="" style="background-color: #ce8483"  id="registrasi" class="form-control">
                            </th>
                            
                        </tr>
                        <tr> 
                            <th>
                                PENERIMA JAMINAN
                            </th>
                            <th>
                                <input disabled="" id="namabank" class="form-control">
                            </th>
                            
                        </tr>
                        <tr> 
                            <th>
                              NOMOR KTP
                            </th>
                            <th>
                                <input disabled="" id="ktp" class="form-control">
                            </th>
                            
                        </tr>
                        <tr> 
                            <th>
                                TERJAMIN
                            </th>
                            <th>
                                <input disabled="" id="nama" class="form-control">
                            </th>
                             
                        </tr>
                        <tr> 
                            <th>
                                PEKERJAAN
                            </th>
                            <th>
                                <input disabled="" id="pekerjaan" class="form-control">
                            </th>
                             
                        </tr>
                        <tr> 
                            <th>
                               TGL LAHIR
                            </th>
                            <th>
                                <input disabled="" id="tgllahir" class="form-control">
                            </th>
                           
                        </tr> 
                        <tr> 
                            <th>
                               UMUR SAAT JATUH TEMPO
                            </th>
                            <th>
                                <input disabled="" id="umur" class="form-control">
                            </th>
                            
                        </tr> 
                        <tr> 
                            <th>
                               JENIS KREDIT
                            </th>
                            <th>
                                <input disabled="" id="jeniskredit" class="form-control">
                            </th>
                            
                        </tr>
                        <tr> 
                            <th>
                                JENIS PENJAMINAN
                            </th>
                            <th>
                                <input disabled="" id="jenispenjaminan" class="form-control">
                            </th>
                            
                        </tr>
                        <tr> 
                            <th>
                               NO PK
                            </th>
                            <th>
                                <input disabled="" id="nopk" class="form-control">
                            </th>
                            
                        </tr>
                        <tr> 
                            <th>
                              PERIODE
                            </th>
                            <th>
                                <input disabled="" id="periode" class="form-control">
                            </th>
                            
                        </tr>
                         <tr> 
                            <th>
                             LAMA KREDIT
                            </th>
                            <th>
                                <input disabled="" id="masakredit" class="form-control">
                            </th>
                            
                        </tr>
                         <tr> 
                            <th>
                               PLAFOND
                            </th>
                            <th>
                                <input style="text-align: right" disabled=""  id="plafon" class="form-control">
                            </th>
                            
                        </tr>
                        <tr> 
                            <th>
                              RATE
                            </th>
                            <th>
                                <input style="text-align: right" disabled="" id="rate" class="form-control">
                            </th>
                            
                        </tr>
                        <tr> 
                            <th>
                              Gross IJP
                            </th>
                            <th>
                                <input style="text-align: right" disabled="" id="ijp" class="form-control">
                            </th> 
                        </tr>
                       
                        <tr> 
                            <th>
                                DIS(Rp.)
                            </th>
                            <th>
                                <input style="text-align: right" disabled=""  id="potongan" class="form-control">
                            </th>
                            
                        </tr>
                        <tr> 
                            <th>
                               Nett IJP
                            </th>
                            <th>
                                <input style="text-align: right" disabled="" id="premi" class="form-control">
                            </th>
                            
                            
                        </tr>
                        <tr> 
                            <th>
                              ADMINISTRASI
                            </th>
                            <th>
                               <input style="text-align: right" disabled="" id="admin" class="form-control">
                            </th>
                        </tr>
                         <tr> 
                            <th>
                             MATERAI
                            </th>
                            <th>
                               <input  style="text-align: right"disabled="" id="materai" class="form-control">
                            </th>
                        </tr>
                         <tr> 
                            <th>
                              TOTAL BAYAR
                            </th>
                            <th>
                               <input style="text-align: right" disabled="" id="totalbayar" class="form-control">
                            </th>
                        </tr>
                        
                        <tr> 
                             
                        </tr>
                    </table>
                        
                    
                </div>
                <div class="modal-footer">
                    <input hidden name="validasi" id="validasi"  value="autocover" />  
                    <input hidden="" name="idpenjaminan" id="idpenjaminan" value="" />                     
                    <input  type="submit" name="submit" id="btn-terbitkan" value="Terbitkan "class="btn btn-info" />
                    <button autofocus type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
     
</div>
</div>