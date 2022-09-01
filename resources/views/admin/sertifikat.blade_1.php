<html>
    <head>
        <style type="text/css">
            body{
                font-family: 'Dejavu Sans';
                font-size: 12px;
            }
            .widget-content.pad20f {
                padding: 0 20px 20px;
            }
            h3{
                font-size: 18px;
                line-height: 20px;
                margin-bottom: 40px
            }
            p{
                margin: 0;
                padding: 0;
                text-align: justify;
            }
            table.data thead tr{
                background: #efefef;
                padding: 4px 0;
            }
            table.data tr td{
                font-size: 10px;
            }
        </style>
    </head>         
    <body>
    <center>
<!--        <img  src="img/kop2018.jpg"class="img-responsive" width='70%'  alt="User Image">-->
  <br>
        <h1>SERTIFIKAT PENJAMINAN</h1>
       
        <h1>KREDIT {{strtoupper($sertifikat['sertifikat'][0]['jeniskredit'])}}</h1>
      
        <h2>Nomor : {{strtoupper($sertifikat['sertifikat'][0]['kodesertifikat'])}}</h2>
        <br>
        <h4>Dengan ini PT. JAMKRIDA NTB BERSAING<br>
        Ruko Bung Karno Jaya No.11, Jl. Bungkarno, Mataram, NTB<br>
         Sebagai Pihak PENJAMIN menyatakan mengikatkan diri pada </h4>
        <h2>PENERIMA JAMINAN, yaitu</h2>
        <h2>{{strtoupper($sertifikat['sertifikat'][0]['namabank'])}}</h2>
        <h2>{{strtoupper($sertifikat['sertifikat'][0]['alamatbank'])}}</h2>
        <h4>Untuk membayar hutang dan atau kredit dari TERJAMIN yang<br>
           identitas, portofolio kredit imbal Jasa Penjaminan dan keterangan lainnya<br>
           sebagaimana tertera dalam lampiran sertifikat penjaminan ini.</h4>
        <br>
        <h4>TERM & CONDITION PENJAMINAN</h4>
        <h4>SESUAI DENGAN PERJANJIAN KERJASAMA</h4>
         
    </center>
   <table style="margin-left: 200px" >
        <tr>
            <th>Diterbitkan di </th>
            <th>:</th>
            <th>Mataram</th>   
        </tr>
        <tr>
            <th>Pada Tanggal</th>
            <th>:</th>
            <th>{{date('d-m-Y',strtotime($sertifikat['sertifikat'][0]['tglterbit']))}}</th>   
        </tr>

    </table>

    <br>
    <br>
    <br>
    <br>
    <table style="margin-left:200px" >
        <tr>
            <th><u>INDRA MANTHICA</u></th>

        </tr>
        <tr>
            <th>Direktur Utama</th>

        </tr>
    </table>
 
 <img src= "data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(100)->generate(md5(base64_encode($sertifikat['sertifikat'][0]['nosertifikat']))))}} ">
  
</body>
</html>

