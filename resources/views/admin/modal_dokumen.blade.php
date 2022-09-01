<div id="modalUploadSuratSehat" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action=""  id="formUpload" method="post" enctype="multipart/form-data" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <label>Nama Terjamin</label>
                    <input disabled="" name="namaterjamin" id="namaterjamin" class="form-control"><br/>
                    <span id="form_output"></span>
                    <label id="titleupload"></label>
                    <input name="fileUpload" id="fileUpload" type="file" class="form-control"><br/>
                    <div class="progress">
                        <div class="bar"></div >
                        <div class="percent">0%</div >
                    </div>           
                </div>
                <div class="modal-footer">
                    <input  class="sertifikat"  name="sertifikat" id="sertifikat" value="" />                    
                    <input type="submit" name="button_action" id="btn_upload_surat_sehat"   class="btn btn-info" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>                                               
        </div>
    </div>
</div>



<div id="modalUploadRs" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action=""  id="formUploadRs" method="post" enctype="multipart/form-data" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}                    
                    <label>Nama Terjamin</label>
                    <input disabled="" name="namaterjamin" id="namaterjaminRs" class="form-control"><br/>
                    
                    <label id="titleuploadRs"></label>
                    <input name="fileUploadRs" id="fileUploadRs" type="file" class="form-control"><br/>
                    <div class="progress">
                        <div class="bar"></div >
                        <div class="percent">0%</div >
                    </div>           
                </div>
                <div class="modal-footer">
                    <input hidden="" name="sertifikat" id="sertifikatRs" value="" />                    
                    <input type="submit" name="button_action" id="button_actionRs" value="" class="btn btn-info" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modalUploadSuratScanlab" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action=""  id="formUploadScanLab" method="post" enctype="multipart/form-data" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}                    
                    <label>Nama Terjamin</label>
                    <input disabled="" name="namaterjamin" id="namaterjamin1" class="form-control"><br/>
                    <span id="form_output"></span>
                    <label id="titleupload1"></label>
                    <input name="fileUploadScanLab" id="fileUploadScanLab" type="file" class="form-control"><br/>
                    <div class="progress">
                        <div class="bar"></div >
                        <div class="percent">0%</div >
                    </div>           
                </div>
                <div class="modal-footer">
                    <input hidden="" name="sertifikat" id="sertifikat1" value="" />                    
                    <input type="submit" name="button_action1" id="button_action1" value="" class="btn btn-info" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalUploadPembayaran" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Data</h4>
            </div>
            <div class="modal-body">
                <form method="POST"  action="{{url('pembayaranauto')}}"  id="formPembayaranUlangss" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">

                        <div class="form-group">
                            <label>Nama Terjamin</label>
                            <input disabled="" name="namaterjamin" id="namaterjaminbayar" class="form-control">
                        </div>                                
                        <div class="form-group">
                            <label>Kode Pembayaran</label>
                            <input id="kodebayar"  value=""      name="kodepembayaran"  type="text" hidden="" >
                            <input id="kodebayar1"  disabled="" required="" value=""  type="text" class="form-control" >
                        </div>                                
                        <input  name="nosertifikat" hidden="" required="" id="sertifikatbayar"  type="text" class="form-control" >

                        <div class="form-group ">
                            <label>Total IJP</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Rp.
                                </div>
                                <input  hidden=""   value="" id="nett" name="nett"  type="text"  >
                                <input disabled="" id="nett1" required="" value=""  type="text" class="form-control" >
                            </div> 
                        </div>
                        
                        <div class="form-group ">
                            <label>Biaya Admin</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Rp.
                                </div>
                                <input    value="" id="admin" name="nett"  type="text"  hidden="">
                                <input disabled="" id="admin1" required="" value=""  type="text" class="form-control" >
                            </div> 
                        </div>
                        
                        <div class="form-group ">
                            <label>Biaya Materai</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Rp.
                                </div>
                                <input   value="" id="materai" name="materai"  type="text"  hidden="">
                                <input disabled="" id="materai1" required="" value=""  type="text" class="form-control" >
                            </div> 
                        </div>
                        
                        <div class="form-group ">
                            <label>Total Bayar</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Rp.
                                </div>
                                <input  hidden=""  value="" id="totalbayar_adm" name="totalbayar"  type="text"  >
                                <input disabled="" id="totalbayar1" required="" value=""  type="text" class="form-control" >
                            </div> 
                        </div>

                        <div class="form-group ">
                            <label>Tanggal Bayar</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time">
                                    </i>
                                </div>

                                <input required="" value="<?php echo date('Y/m/d') ?>"  name="tglbayar"  type="text"  hidden="">
                                <input disabled="" required="" value="<?php echo date('Y/m/d') ?>"    type="text" class="form-control"  >

                            </div>

                            @if($errors->has('bayar'))
                            <p style="color: red"> {{ $errors -> first('bayar')}}</p>
                            @endif
                        </div>
                        <label>Upload Bukti Bayar</label>
                        <input name="filePembayaran" id="poster" type="file" class="form-control"><br/>
                        @if($errors->has('file'))
                        <p style="color: red"> {{ $errors -> first('filePembayaran')}}</p>
                        @endif
                        <div class="progress">
                            <div class="bar"></div >
                            <div class="percent">0%</div >
                        </div>
                     
                    </div>

            </div>


            <div class="modal-footer">
                                     <input  name="idpenjaminan" id="penjaminanid"  />
                <input hidden=""  name="action" value="update" />  
                <input type="submit" name="button_action" id="button_actionBayar" value="" class="btn btn-info" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form> 
        </div>
    </div>
</div>
 