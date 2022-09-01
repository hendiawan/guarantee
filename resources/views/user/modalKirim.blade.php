                                                  
<div id="modalKirim" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="KirimCase"  method="post" enctype="multipart/form-data" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <label>Nama Terjamin</label>
                    <input disabled="" name="namaterjamin" id="NamaTerjamin" class="form-control"><br/>
                    
                    <label>Plafon Kredit</label>
                    <input disabled="" name="PlafonKredit" id="PlafonKredit" class="form-control"><br/>
                    
                                     
                </div>
                <div class="modal-footer">
                    <input hidden=""  name="case"  value="Ya" />                    
                    <input hidden=""   name="nosertifikat" id="nosertfikatcase" />                    
                    <input hidden=""   name="idpenjaminan" id="idpenjaminancase"  />                    
                    <input  type="submit" name="button_action" id="button_action" value="" class="btn btn-info" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>                                               
        </div>
    </div>
</div>
