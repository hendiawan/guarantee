<!DOCTYPE html>
<html>
    <head>
        <title>BUKTI PEMBAYARAN IJP</title>

    </head>
    <body>
        @foreach($data as $datas)
<!--         // <img  src="{{URL::asset('files/buktibayar/'.$datas->file)}}" >-->
<!--        <embed type="application/pdf" width="100%" height="600px"   src="{{URL::asset('files/buktibayar/'.$datas->file)}}" > </embed>-->
          <object  type="application/pdf" width="100%" height="1000px" data="{{URL::asset($datas->url_penjaminan.$datas->file)}}" >             
          </object>
        @endforeach

    </body>
</html>

  