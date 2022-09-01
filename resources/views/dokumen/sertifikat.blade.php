
<!DOCTYPE html>
<html> 
    <head>  
    <meta charset="UTF-8">
        <title>SERTIFIKAT PENJAMINAN</title>
        <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function(e) {
          $('iframe').attr('src',"{{action('VerifyController@showDocumentKredit',['key'=>$sertifikat->verify])}}");
        });
        </script>
 </head>  
    <body oncontextmenu="return false;" onkeydown="return false;" onmousedown="return false;">
        <iframe  style="width:100%; height:800px;" src="" />
    </body>
    
    
</html>

