                                                  
<div id="modalSkPengangkatan" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/ajaxdata/tambah"  id="formUploads" method="post" enctype="multipart/form-data" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <label>Nama Terjamin</label>
                    <input disabled="" name="namaterjamin"   id="namaterjamin" class="form-control namaterjamin"><br/>
                    <span id="form_output"></span>
                    <label class="titleuploadsk"></label>
                    <input name="fileUploadSk" id="fileUploadSk" type="file" class="form-control"><br/>
                    <div class="progress">
                        <div class="bar"></div >
                        <div class="percent">0%</div >
                    </div>           
                </div>
                <div class="modal-footer">
                    <input hidden="" class="sertifikat" name="sertifikat" id="sertifikat" value="" />                    
                    <input type="submit" name="button_action" id="btn_upload" value="" class="btn btn-info btn_upload" />
                    <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                </div>
            </form>                                               
        </div>
    </div>
</div>
<div id="modalRiwayatKredit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/ajaxdata/tambah"  id="formUploads" method="post" enctype="multipart/form-data" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <label>Nama Terjamin</label>
                    <input disabled="" name="namaterjamin"   id="namaterjamin" class="form-control namaterjamin"><br/>
                    <span id="form_output"></span>
                    <label class="titleupload"></label>
                    <input name="fileUploadRiwayatKredit" id="fileRiwayatKredit" type="file" class="form-control"><br/>
                    <div class="progress">
                        <div class="bar"></div >
                        <div class="percent">0%</div >
                    </div>           
                </div>
                <div class="modal-footer">
                    <input hidden="" class="sertifikat" name="sertifikat" id="sertifikat" value="" />                    
                    <input type="submit" name="button_action" id="btn_upload" value="" class="btn btn-info btn_upload" />
                    <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                </div>
            </form>                                               
        </div>
    </div>
</div>
<div id="modalGetaranJantung" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/ajaxdata/tambah"  id="formUploads" method="post" enctype="multipart/form-data" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <label>Nama Terjamin</label>
                    <input disabled="" name="namaterjamin"   id="namaterjamin" class="form-control namaterjamin"><br/>
                    <span id="form_output"></span>
                    <label class="titleupload"></label>
                    <input name="fileUploadGetaranJantung" id="fileUploadGetaranJantung" type="file" class="form-control"><br/>
                    <div class="progress">
                        <div class="bar"></div >
                        <div class="percent">0%</div >
                    </div>           
                </div>
                <div class="modal-footer">
                    <input hidden="" class="sertifikat" name="sertifikat" id="sertifikat" value="" />                    
                    <input type="submit" name="button_action" id="btn_upload" value="" class="btn btn-info btn_upload" />
                    <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                </div>
            </form>                                               
        </div>
    </div>
</div>
<div id="modalPersetujuanKredit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/ajaxdata/tambah"  id="formUploads" method="post" enctype="multipart/form-data" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <label>Nama Terjamin</label>
                    <input disabled="" name="namaterjamin"   id="namaterjamin" class="form-control namaterjamin"><br/>
                    <span id="form_output"></span>
                    <label class="titleupload"></label>
                    <input name="fileUploadPersetujuanKredit" id="fileUploadPersetujuanKredit" type="file" class="form-control"><br/>
                    <div class="progress">
                        <div class="bar"></div >
                        <div class="percent">0%</div >
                    </div>           
                </div>
                <div class="modal-footer">
                    <input hidden="" class="sertifikat" name="sertifikat" id="sertifikat" value="" />                    
                    <input type="submit" name="button_action" id="btn_upload" value="" class="btn btn-info btn_upload" />
                    <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                </div>
            </form>                                               
        </div>
    </div>
</div>
<div id="modalTaksasi" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/ajaxdata/tambah"  id="formUploads" method="post" enctype="multipart/form-data" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <label>Nama Terjamin</label>
                    <input disabled="" name="namaterjamin"   id="namaterjamin" class="form-control namaterjamin"><br/>
                    <span id="form_output"></span>
                    <label class="titleupload"></label>
                    <input name="fileUploadTaksasi" id="fileUploadTaksasi" type="file" class="form-control"><br/>
                    <div class="progress">
                        <div class="bar"></div >
                        <div class="percent">0%</div >
                    </div>           
                </div>
                <div class="modal-footer">
                    <input hidden="" class="sertifikat" name="sertifikat" id="sertifikat" value="" />                    
                    <input type="submit" name="button_action" id="btn_upload" value="" class="btn btn-info btn_upload" />
                    <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                </div>
            </form>                                               
        </div>
    </div>
</div>
<div id="modalAnalisis" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/ajaxdata/tambah"  id="formUploads" method="post" enctype="multipart/form-data" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <label>Nama Terjamin</label>
                    <input disabled="" name="namaterjamin"   id="namaterjamin" class="form-control namaterjamin"><br/>
                    <span id="form_output"></span>
                    <label class="titleupload"></label>
                    <input name="fileUploadAnalisis" id="fileUploadAnalisis" type="file" class="form-control"><br/>
                    <div class="progress">
                        <div class="bar"></div >
                        <div class="percent">0%</div >
                    </div>           
                </div>
                <div class="modal-footer">
                    <input hidden="" class="sertifikat" name="sertifikat" id="sertifikat" value="" />                    
                    <input type="submit" name="button_action" id="btn_upload" value="" class="btn btn-info btn_upload" />
                    <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                </div>
            </form>                                               
        </div>
    </div>
</div>

                                                  
<div id="modalSlik" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/ajaxdata/tambah"  id="formUploads" method="post" enctype="multipart/form-data" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <label>Nama Terjamin</label>
                    <input disabled="" name="namaterjamin"   id="namaterjamin" class="form-control namaterjamin"><br/>
                    <span id="form_output"></span>
                    <label class="titleupload"></label>
                    <input name="fileUploadSlik" id="fileSlik"  type="file" class="form-control"><br/>
                    <div class="progress">
                        <div class="bar"></div >
                        <div class="percent">0%</div >
                    </div>           
                </div>
                <div class="modal-footer">
                    <input hidden="" class="sertifikat" name="sertifikat" id="sertifikat" value="" />                    
                    <input type="submit" name="button_action" id="btn_upload" value="" class="btn btn-info btn_upload" />
                    <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                </div>
            </form>                                               
        </div>
    </div>
</div>


<div id="modalUsaha" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/ajaxdata/tambah"  id="formUploads" method="post" enctype="multipart/form-data" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <label>Nama Terjamin</label>
                    <input disabled="" name="namaterjamin" clid="namaterjamin" class="form-control"><br/>
                    <span id="form_output"></span>
                    <label id="titleupload"></label>
                    <input name="fileUploadFotoUsaha" id="fileUsaha"  type="file"   class="form-control"><br/>
                    <div class="progress">
                        <div class="bar"></div >
                        <div class="percent">0%</div >
                    </div>           
                </div>
                <div class="modal-footer">
                    <input hidden="" class="sertifikat" name="sertifikat" id="sertifikat" value="" />                    
                    <input type="submit" name="button_action" id="btn_upload" value="" class="btn btn-info btn_upload" />
                    <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                </div>
            </form>                                               
        </div>
    </div>
</div>
<div id="modalUploadktp" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/ajaxdata/tambah"  id="formUploads" method="post" enctype="multipart/form-data" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <label>Nama Terjamin</label>
                    <input disabled="" name="namaterjamin" id="namaterjamin" class="form-control"><br/>
                    <span id="form_output"></span>
                    <label class="titleupload" id="titleupload"></label>
                    <input name="fileUploadktp" id="fileUploadktp" type="file" class="form-control namaterjamin"><br/>
                    <div class="progress">
                        <div class="bar"></div >
                        <div class="percent">0%</div >
                    </div>           
                </div>
                <div class="modal-footer">
                    <input hidden="" class="sertifikat" name="sertifikat" id="sertifikat" value="" />                    
                    <input type="submit" name="button_action" id="btn_upload" value="" class="btn btn-info btn_upload" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>                                               
        </div>
    </div>
</div>
<div id="modalUploadSuratSehat" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/ajaxdata/tambah"  id="formUploads" method="post" enctype="multipart/form-data" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <label>Nama Terjamin</label>
                    <input  disabled="" name="namaterjamin" id="namaterjamin" class="form-control namaterjamin"><br/>
                    <span id="form_output"></span>
                    <label id="titleupload" class="titleupload"></label>
                    <input  name="fileUploadSuratSehat" id="fileUploadSuratSehat" type="file" class="form-control fileUploadSuratSehat"><br/>
                    <div class="progress">
                        <div class="bar"></div >
                        <div class="percent">0%</div >
                    </div>           
                </div>
                <div class="modal-footer">
                    <input hidden=""   class="sertifikat" name="sertifikat" id="sertifikat" value="" />                    
                    <input type="submit" name="button_action" id="btn_upload_surat_sehat" value="" class="btn btn-info" />
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

            <form action="/ajaxdata/tambah"  id="formUploadScanLab" method="post" enctype="multipart/form-data" >
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
                <form method="POST"  action="{{url('pembayaranauto')}}"   enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">

                        <div class="form-group">
                            <label>Nama Terjamin</label>
                            <input disabled="" name="namaterjamin" id="namaterjaminbayar" class="form-control">
                        </div>                                
                        <div class="form-group">
                            <label>Kode Pembayaran</label>
                            <input id="kodebayar"  value=""      name="kodepembayaran"  type="text"  hidden="">
                            <input id="kodebayar1"  disabled="" required="" value=""  type="text" class="form-control" >
                        </div>                                
                        <input  name="nosertifikat" hidden="" required="" id="sertifikatbayar"  type="text" class="form-control" >

                        <div class="form-group ">
                            <label>Total IJP</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Rp.
                                </div>
                                <input   value="" id="nett" name="nett"  type="text"  hidden="">
                                <input disabled="" id="nett1" required="" value=""  type="text" class="form-control" >
                            </div> 
                        </div>
                        
                        <div class="form-group ">
                            <label>Biaya Admin</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Rp.
                                </div>
                                <input   value="" id="admin" name="nett"  type="text"  hidden="">
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
                                <input   value="" id="totalbayar" name="totalbayar"  type="text"  hidden="">
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
                                  
                <input hidden=""  name="action" value="update" />         
                <input hidden="" name="idpenjaminan" id="penjaminanid" value="" />          
                <input type="submit" name="button_action" id="button_actionBayar" value="" class="btn btn-info" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form> 
        </div>
    </div>
</div>
 

<div id="modalPenjaminan" class="modal fade" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content" >
            <form method="post" ng-submit="FormSimpanDataRate()">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@{{modalTitle}}</h4>
                </div>
                <div class="modal-body">                    

                    <div class="form-group">
                        <label>No KTP</label>
                        <input ng-model="ktp" value="{{old('ktp')}}" class="form-control" id="ktp"   onkeypress="return  hanyaAngka(event, false)" name="ktp" placeholder="Nomor KTP"  maxlength="16" >
                        @if($errors->has('ktp'))
                        <p style="color: red"> {{ $errors -> first('ktp')}}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Nama Terjamin</label>
                        <input ng-model="nama" value="{{old('ktp')}}" class="form-control" id="name" name="name" placeholder="Name" type="text" >
                        @if($errors->has('name'))
                        <p style="color: red"> {{ $errors -> first('name')}}</p>
                        @endif
                    </div>   
                    <div class="form-group">
                        <div class="form-group ">
                            <label>Tanggal Lahir</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time">
                                    </i>
                                </div>
                                <input ng-model="tgllahir" value="{{old('tglLhr')}}"  onchange="hitungUmur()" id="tglLahir"  name="tglLhr"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">

                            </div>
                            @if($errors->has('tglLhr'))
                            <p style="color: red"> {{ $errors -> first('tglLhr')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label>Umur</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-hourglass">
                                    </i>
                                </div>
                                <input ng-model="umur" value="{{old('umur')}}" disabled="" class="form-control" name="umur"  id="tampil1"  type="text">  
                                <input hidden="" name="umur"  id="tampil"  type="text">  
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label>Pekerjaan</label>
                            <select ng-model="pekerjaan" name="pekerjaan" class="form-control">
                                <option value="">Pilih Pekerjaan</option>
                                <option value="PNS">PNS</option>                                                
                                <option value="TNI">TNI</option>                                                
                                <option value="POLRI">POLRI</option>                                                
                                <option value="ANGGOTA DPR">ANGGOTA DPR</option>                                                
                                <option value="PETANI">PETANI</option>                                                
                                <option value="NELAYAN">NELAYAN</option>                                                
                                <option value="KARYAWAN SWASTA">KARYAWAN SWASTA</option>                                               
                                <option value="KARYAWAN BUMN">KARYAWAN BUMN</option>                                               
                                <option value="KARYAWAN BUMD">KARYAWAN BUMD</option>                                               
                                <option value="WIRASWASTA">SWASTA</option>                                               
                                <option value="WIRASWASTA">WIRASWASTA</option>                                               
                            </select>
                            @if($errors->has('pekerjaan'))
                            <p style="color: red"> {{ $errors -> first('pekerjaan')}}</p>
                            @endif

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label>Jenis Kredit</label>
                            <select ng-model="jeniskredit" name="kredit" class="form-control">
                                <option value="">Pilih Jenis</option>
                                <option value="PRODUKTIF">PRODUKTIF</option>                                                
                                <option value="KONSUMTIF">KONSUMTIF</option>                                               
                            </select>
                            @if($errors->has('kredit'))
                            <p style="color: red"> {{ $errors -> first('kredit')}}</p>
                            @endif

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group ">
                            <label>Alamat</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-map-marker">
                                    </i>
                                </div>
                                <input ng-model="alamat"  name="alamat"  type="text" class="form-control" >
                            </div>
                            @if($errors->has('alamat'))
                            <p style="color: red"> {{ $errors -> first('alamat')}}</p>
                            @endif
                        </div>
                    </div>
                    <h3 class="text-center">DATA PENJAMINAN</h3>
                    <div class="form-group">
                        <div class="form-group ">
                            <label>Tanggal Realisasi</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time">
                                    </i>
                                </div>
                                <input ng-model="tglrealisasi" disabled="" id="tglrealisasi" name="tglrealisasi"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                            </div>
                            @if($errors->has('tglrealisasi'))
                            <p style="color: red"> {{ $errors -> first('tglrealisasi')}}</p>
                            @endif
                            <div id="msg_realisasi"></div>
                        </div>
                    </div>
               <div class="form-group ">
                            <label>Masa Kredit [Bulan]</label>
                            <div class="input-group">
                                <input  onchange="hitungUmurJatuhTempo()" onkeypress="return  hanyaAngka(event, false)" required="" name="masakredit"  id="masaKredit" type="text" class="form-control" >
                                <div class="input-group-addon">
                                    Bulan
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label>Tanggal Jatuh Tempo<b style="color: red">( * )</b></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time">
                                    </i>
                                </div>
                                <input required=""  hidden=""  name="tgljatuhtempo"  id="tgljatuhtempo1" type="text" >
                                <input required="" disabled=""  class="form-control" maxlength="3"  id="tgljatuhtempo" type="text" >
                          
                            </div>
                            <p id="errorjatuhtempo"></p>
                            <br>

                            @if($errors->has('tgljatuhtempo'))
                            <p style="color: red"> {{ $errors->first('tgljatuhtempo')}}</p>
                            @endif
                        </div>

                    <div class="for-group">
                        <div class="form-group">
                            <label>Umur Terjamin Saat Jatuh Tempo</label><br>
                            <input name="umurjatuhtempo" hidden="" class="form-control"  id="umurjatuhtempo1" >
                            <input ng-model="umurjatuhtempo" disabled=""  class="form-control"  id="umurjatuhtempo" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label>No. Perjanjian Kredit</label>
                        <input ng-model="nopk" class="form-control"  onkeypress="return  hanyaAngka(event, false)" name="nopk" placeholder="Nomor PK"  maxlength="16" >
                        @if($errors->has('nopk'))
                        <p style="color: red"> {{ $errors -> first('nopk')}}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="form-group ">
                            <label>Tanggal Perjanjian Kredit</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time">
                                    </i>
                                </div>
                                <input ng-model="tglpk" name="tglpk"  type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">

                            </div>
                            @if($errors->has('tglpk'))
                            <p style="color: red"> {{ $errors -> first('tglpk')}}</p>
                            @endif

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label>Plafon Kredit Rp.</label><br>
                            <input ng-model="plafon" id="plafon"  onchange="CekPlafon()" onkeyup="FormatCurrency(this)" class="form-control" name="plafon">
                            <div id="pesanPlafon"></div>
                            @if($errors->has('plafon'))
                            <p style="color: red"> {{ $errors -> first('plafon')}}</p>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-group">
                            <label>Jenis Penjaminan</label>
                            <select ng-model="jenispenjaminan" name="jenisPenjaminan" class="form-control">
                                <option value="">Pilih Jenis</option>
                                <option value="JIWA">JIWA</option>                                                
                                <option value="MACET">MACET</option>                                                
                                <option value="JIWA DAN MACET">JIWA DAN MACET</option>                                                    

                            </select> 

                            @if($errors->has('jenisPenjaminan'))
                            <p style="color: red"> {{ $errors -> first('jenisPenjaminan')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group ">

                            <label>Tanggal Pengajuan</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-time">
                                    </i>
                                </div>
                                <?php
                                date_default_timezone_set('Asia/Jakarta');
                                $pengajuan = date('d/m/Y');
                                ?>
                                <input hidden="" name="tglPengajuan" value='<?php echo $pengajuan ?>' type="text">
                                <input disabled=""  value='<?php echo $pengajuan ?>' type="text" class="form-control">
                            </div>

                        </div>
                    </div>
                    {{csrf_field()}}

                </div>
                <div class="modal-footer">

                    <input type="hidden" name="hidden_id" value="@{{hidden_id}}" />
                    <input type="submit" name="submit" id="submit" class="btn btn-info" value="@{{submit_button}}" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

