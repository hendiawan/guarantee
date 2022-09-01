@extends('layout.admin')
@section('content')
 
<div style=" width: 800px;
     margin: 0 auto;
     " class="container" >
  
    <div class="row">
        <div class="col-md-12">
            @if (Session::has('pesan-reasuransi'))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('pesan-reasuransi') }}
            </div>
            @endif
          
          <div style="border-radius: 20px;" class="panel panel-default">
            <div  style="border-radius: 20px;" class="panel-heading">
                <strong><i class="glyphicon glyphicon-alert"></i> Form Input Facultative Offering</strong>
            </div>
             
        </div>
            <div  style=" border-top-style: solid;
                                    border-right-style: solid;
                                    border-bottom-style: solid;
                                    border-left-style: solid;
                                    border-width: 1px;
                                    border-color: #005888;
                                    border-radius: 20px;" 
                    class="panel panel-default">
             
                <div  style="border-radius: 30px;" class="panel-heading">
                    <strong>DATA TERJAMIN DAN REASURANSI</strong>
                </div>
                <div class="panel-body">                   
                    <form method="POST" id="formReasuransi" action="{{url('/rekanan/insert-reasuransi')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group"> 
                             <label>Nomor Sertifikat </label>                            
                             <input  style="border: none;box-sizing: border-box;width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  border-bottom: 2px solid red;"  required="" id="no_sertifikat"  name="no_sertifikat">
                             <br>
                             <div id="alert-sertifikat-failed" class="alert alert-danger alert-dismissable hidden">
                                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 
                                 Nomor sertifikat tidak valid, mohon cek kembali nomor sertifikat yang anda masukkan !!!
                             </div>
                             <div id="alert-sertifikat-success" class="alert alert-success alert-dismissable hidden">
                                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 
                                 Selamat, Nomor sertifikat  valid 
                             </div>
                             <div id="table-content"class="panel panel-default hidden">
                                 <table class="table table-dark">
                                     <thead>
                                         <tr> 
                                             <th scope="col">Nama Terjamin</th>
                                             <th scope="col"><p id="nama"></p></th>
                                           
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <tr> 
                                             <td>Bank</td>
                                             <td><p id="bank"></p></td> 
                                         </tr>
                                         <tr> 
                                             <td>Plafon</td>
                                             <td><p id="plafon"></p></td> 
                                         </tr>
                                         <tr> 
                                             <td>Periode Pertanggungan</td>
                                             <td><p id="periode"></p></td> 
                                         </tr>
                                     </tbody>
                                 </table>           
                             </div>           
                            </div> 
                        <div class="form-group">
                              <label>Pilih Asuransi/Broker Rekanan<b style="color: red">( * )</b></label>
                            <select  id="pilihReasuransi" required="" name="id_reasuransi" class="form-control">
                                <option value="">Pilih Rekanan</option>
                                <option value="%">Semua Rekanan</option>  
                                @foreach($reasuransi as $data) 
                                <option value="{{$data->id}}">{{$data->nama_asuransi}}</option>   
                                //@if($data->id=='2') selected="" @else @endif  
                                @endforeach 
                            </select>    
                        </div>
                            <div class="form-group">
                                <label>R/I Commision<b style="color: red">( * )</b></label>  
                                <input    style="border-radius: 30px;" required="" name="commision" id="poster" type="input" class="form-control"><br/>
                            @if($errors->has('commision'))
                            <p style="color: red"> {{ $errors->first('commision')}}</p>
                            @endif   
                            </div>
                            <div class="form-group">
                                <label>Share yang ditawarkan </label>                            
                                <input  style="border-radius: 30px;" required=""   class="form-control" name="share">
                            </div>
                              <input hidden="" name="penjaminan_id" id="penjaminan_id" type="input" class="form-control"><br/>
                              <input hidden="" name="ijp" id="ijp" type="input" class="form-control"><br/>
                              <input hidden=""  name="plafon" id="plafonSimpan" type="input" class="form-control"><br/>

                        <div class="form-group">
                            
                            <input style="border-radius: 30px; width: 100%;" type="submit"  value="Simpan" id="simpan" class="btn btn-success btn-">
                        </div>                      

                                </div>  
                     </div> 
                </div>
            </div>
        </div>
  
<script>
    
    $("#no_sertifikat").keyup(function(){
        var no_sertifikat =  $(this).val();
//                alert(no_sertifikat)
        $.ajax({
      
                url: "get-data-sertifikat?no_sertifikat="+no_sertifikat,
                method: 'get',
//                data: 'nomor=' + no_sertifikat,
                dataType: 'json',
                success: function (data) { 
                        console.dir(data);
                        $('#table-content').addClass('hidden');
                        if(data){
//                                  alert(data.nama);
                                  $('#table-content').removeClass('hidden');
                                  $('#alert-sertifikat-failed').addClass('hidden');
                                 $('#alert-sertifikat-success').removeClass('hidden');
                                  $('#penjaminan_id').val(data.idpenjaminan);
                                  $('#nama').text(data.nama);
                                  $('#bank').text(data.namabank);
                                  $('#ijp').val(data.premi);
                                  $('#plafonSimpan').val(data.plafon);
                                  $('#plafon').text(formatNumber(data.plafon));
                                  
                                var mulai = formatTanggal(data.tglrealisasi);
                                var akhir = formatTanggal(data.tgljatuhtempo);
                                  
                                  $('#periode').text(data.masakredit +" Bulan , "+mulai+" S/D "+akhir);
                                  $('#simpan').attr('disabled',false);
                        }else{
                                    $('#simpan').attr('disabled',true);
                                    $('#penjaminan_id').val();
                                    $('#ijp').clearFields();
                                    $('#plafonSimpan').clearFields();
                                    $('#alert-sertifikat-failed').removeClass('hidden');
                                    $('#alert-sertifikat-success').addClass('hidden');
                              
                        }
                  
        }
    })
    });

function formatTanggal (tgl){
       var today = new Date(tgl);
       var dd = today.getDate(); 
       var mm = today.getMonth()+1; 
       var yyyy = today.getFullYear();
                                  
       return  dd+'-'+mm+'-'+yyyy;
}

 $(function (){
   $('form').on('submit', function (e) {
    $(this).before("<center><img src='img/hourglass.gif' alt='loading...' /></center>").fadeOut();                   
   $('#customLoad').show();
 });

 });
 
   $("#pilihReasuransi").select2({
        placeholder: 'Sillahkan Perusahaan Reasuransi',
//        allowClear: true, 
        width: '100%'
    });
    
 
</script>

  
@endsection