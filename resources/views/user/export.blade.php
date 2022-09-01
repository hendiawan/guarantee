@extends('layout.user')
@section('content')

<div class="container">
    
    @if (Session::has('idbank'))
    <input hidden=""  value="{{Session::get('idbank') }}" class="form-control" id="idbank"    name="idbank" placeholder="ID Bank"  maxlength="16" >                                  
    @endif
    <div class="row">
        <div class="col-md-12">
            @if (Session::has('pesan'))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('pesan') }}
            </div>
            @endif
          
            <div class="panel panel-default">
            <div class="panel-heading">
                <strong><i class="glyphicon glyphicon-edit"></i>SYARAT DAN KETENTUAN</strong>
            </div>
            <div class="panel-body">   
                <hr>
                <b>SYARAT</b><br>
                <hr>
                <b style="color: red">-Data yang diberikan merupakan data sebenarnya</b><br>
                <b style="color: red">-Apabila dikemudian hari ada perubahan data, silahkan hubungi PT.Jamkrida NTB Bersaing</b><br>
             
                <hr>
                <b>KETENTUAN</b><br>
                <hr>
                <b style="color: red">-Silahkan isi File Excel sesuai format berikut, <a href="{{$bank->excel_jiwa}}">Download</a></b><br>
                <b style="color: red">-Kemudian pilih <i style="color:blue">Jenis Kredit</i> dan <i style="color:blue"> Jenis Penjaminan</i> </b><br>
                <b style="color: red">-Selanjutnya Upload File Excel yang sudah diisi seblumnya</b><br>
                <b style="color: red">-Centang pernyataan <i style="color:blue">SETUJU</i> dengan ketentuan PT. Jamkrida NTB Bersaing</b><br>
                <b style="color: red">-Langkah terakhir yaitu tekan tombol  <i style="color:blue">Simpan</i>, tunggu semua data berhasil di import hingga anda  dialihkan ke menu awal aplikasi</b><br>
                
            </div>
        </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong><i class="glyphicon glyphicon-menu-right"></i>IMPORT DATA DARI FILE EXCEL</strong>
                </div>
                <div class="panel-body">                   
                    <form method="POST" id="formxxxx" action="{{url('importpenjaminan')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            @if(Session::has('kodepusat'))
                            <input hidden="" required="" value="{{Session::get('kodepusat') }}" class="form-control" id="kodepusat"    name="kodepusat" >                                  
                            @endif 
                             <label>Upload File Excel <b style="color: red">( * )</b></label>
                            <input name="file" id="poster" type="file" class="form-control"><br/>
                            @if($errors->has('file'))
                            <p style="color: red"> {{ $errors->first('file')}}</p>
                            @endif
                            <div class="progress">
                                <div class="bar"></div >
                                <div class="percent">0%</div >
                            </div>
                            <div class="checkbox icheck-primary">
                                <input required="" type="checkbox" id="primary" />
                                <label for="primary">SETUJU<b style="color: red">( * )</b></label>
                            </div>  
                            <textarea rows="3" style="color: red" class="form-control" disabled="">Semua data yang diberikan sesuai dengan keadaan yang sebenarnya dan apabila di kemudian hari diketahui data yang diberikan tidak benar,maka penjaminan ini batal secara hukum.
                            </textarea>  
                            <br>
                            <div class="form-group">
                                <label>Pemohon </label>                            
                                <input required="" value="{{session::get('nama')}}" class="form-control" name="pemohon">
                            </div>  
                            <input type="submit"  value="Simpan" class="btn btn-success">
                        </div>
                    </form>    
                </div>
            </div>
        </div>
    </div>
<script>
$(document).ready(function() {
    var idbank = $('#idbank').val();
    $.ajax({
        url: "cekinputpenjaminan",
        method: 'get',
        data: 'idbank=' + idbank,
        dataType: 'json',
        success: function (data) {
            if (data.jumlah>0) {
                alert('Penginputan tidak bisa di lanjutkan, Silahkan selesaikan pembayaran untuk pengajuan sebelumnya!!!');
                 window.location.href = "bpr";
            }  

        }
    })
});

 $(function (){
   $('form').on('submit', function (e) {
    $(this).before("<center><img src='img/hourglass.gif' alt='loading...' /></center>").fadeOut();                   
   $('#customLoad').show();
 });

 });
 
</script>

  
@endsection