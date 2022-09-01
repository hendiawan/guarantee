@extends('layout.admin')
@section('content')


<body ng-app="Penjaminan" ng-controller="PenjaminanController">
     <div class="panel panel-default">
    <div class="panel-heading">
        <strong>
        <h2 align="center">Proses Tanda Tangan Digital Sertifikat</h2> 
        </strong>
    </div>
    <div class="panel-body">
             <section  class="col-lg-13 connectedSortable">
        <!-- Map box -->
        <form method="post" id="FormTandaTanganDigital" action="{{url('PostSingleSign')}}" enctype="multipart/form-data" >

         <label>Upload File PDF yang akan di tandatangani <b style="color: red">( * )</b></label>
         <input name="file_ttd" id="poster" type="file" class="form-control"><br/>
        <p><b>Masukkan Passphrase<b><p>
        <input required="" style=" text-align: right; "  name="passphrase" id="passphreas_get" class="form-control">
        <br>
        <input type="submit"   name="submit" id="action" value="Proses" class="btn btn-info" />
               {{csrf_field()}}
             </form>
       
    </section>  
    </div>
</div>
</body>   
<br>
<br>
@endsection

 