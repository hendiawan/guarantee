                                                  
<div id="modalTolak" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  method="post" enctype="multipart/form-data" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Terbitkan Tolakan</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <label>Alasan Penolakan</label>
                    <input hidden="" name="idTolakan" id="idTolakan">
                   <textarea   name="alasanTolak"  id="alasanTolak"  style="resize:none;width:100%;height:300px;" class="form-control"></textarea>  

                </div>
                <div class="modal-footer">  
                    <button  class="btn btn-danger terbitkanTolak"><i class="glyphicon glyphicon-check"></i> Terbitkan Tolakan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>Tutup</button>

                </div>
            </form>                                               
        </div>
    </div>
</div>
