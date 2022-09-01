<?php
ob_clean();

?>
<!DOCTYPE html>
<html>
    
    <head>
  
        <meta charset="UTF-8">
        <title>SURAT PERNYATAAN KESEHATAN TERJAMIN</title>

    </head>
    <body>
        
        @foreach($data as $datas)
        <!--<embed src="{{URL::asset('files/suratsehat/'.$datas->files)}} "  type="application/pdf" width="100%" height="600px" />--> 
        <!--<iframe src=" " ></iframe>-->
        <div>
            <!--<object  type="application/pdf" width="100%" height="600px" data="{{URL::asset('files/suratsehatrs/'.$datas->files3)}}" >-->
            <object  type="application/pdf" width="100%" height="1000px" data="{{URL::asset($datas->url_penjaminan.$datas->files3)}}" >
                   
            </object>
        </div>
       
        @endforeach

    </body>
</html>

