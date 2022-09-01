<html>
    
    <?php
        
        use App\cetaks;
        use Illuminate\Support\Facades\Session;
        use App\penjaminans;
        
    
    ?>
    <head>
        <style type="text/css">
            
            @font-face {
                /*font-family: 'calibri';*/
                font-weight: normal;
                font-style: normal;
                font-variant: normal;
/*                src: url({{ storage_path('fonts/yourfont.ttf') }})url('fonts/Calibri.ttf') format("truetype");*/
            }
            
            body{
                /*font-family: 'calibri';*/
                font-size: 13px;
                margin-left: 40px;
                margin-right: 35px;
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
    <body >
    <center>
        <img  src="img/kop2018.jpg" class="img-responsive" width='100%'  alt="User Image">
<!--  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>-->
  <h2>SERTIFIKAT PENJAMINAN PINJAMAN <br>
   ANGGOTA KOPERASI <br>
  Nomor : {{strtoupper($sertifikat[0]['kodesertifikat'])}}</h2>
       
 <br style="line-height:0.3;">
            </center>
        <p align="justify" >Dengan ini   <b>PT.JAMKRIDA NTB BERSAING</b> dengan alamat di Ruko Bung Karno Jaya No.11, Jl. Bung Karno (Sayung), Cilinaya,
            Mataram, NTB Sebagai Pihak <b>Penjamin</b> menyatakan mengikatkan diri pada pihak <b>Penerima Jaminan</b>
            yaitu <b>{{strtoupper($sertifikat[0]['namabank'])}} </b>yang beralamat di {{ucwords(strtolower($sertifikat[0]['alamatbank']))}}.

        </p>
         <br style="line-height:0.4;">
        <p>
            Pihak Penjamin setuju untuk memberikan penjaminan terhadap pinjaman dari Penerima Jaminan kepada
            pihak Terjamin sesuai data berikut :  
        </p>
        <br style="line-height:0.3;">
         
        <table>
            <tr>
                <td>1.</td>
                <td>Nama Terjamin</td>
                <td>:</td>
                <td>{{strtoupper($sertifikat[0]['nama'])}}.</td>
            </tr>
            <tr>
                <td>2.</td>
                <td> Alamat Terjamin</td>
                <td>:</td>
                <td>{{ucwords(strtolower($sertifikat[0]['alamat']))}}.</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Pekerjaan Terjamin</td>
                <td>:</td>
                <td>{{strtoupper($sertifikat[0]['pekerjaan'])}}.</td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Nomor KTP</td>
                <td>:</td>
                <td>{{strtoupper($sertifikat[0]['ktp'])}}.</td>
            </tr>
            <tr>
                <td>5.</td>
                <td>Tempat, Tanggal lahir/umur</td>
                <td>:</td>
                <td>{{ucwords(strtolower($sertifikat[0]['tempatlahir']))}}, {{penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tgllahir'])))}}/{{ucwords($sertifikat[0]['umur'])}}.</td>
            </tr>
            <tr>
                <td>6.</td>
                <td>Jumlah Pinjaman</td>
                <td>:</td>
                <td>Rp. {{number_format( $sertifikat[0]['plafon'], 2, ',', '.')}}.</td>
            </tr>
            <tr>
                <td>7.</td>
                <td>Jangka waktu Pinjaman</td>
                <td>:</td>
                <td>{{$sertifikat[0]['masakredit']}} Bulan sejak tanggal {{penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglrealisasi'])))}} s/d {{date('d-m-Y',strtotime($sertifikat[0]['tgljatuhtempo']))}}.</td>
                
            </tr>
            <tr>
                <td>8.</td>
                <td>Perjanjian Pinjaman</td>
                <td>:</td>
                <td>Nomor : {{$sertifikat[0]['nopk']}} tanggal {{penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglpk'])))}}.</td>
            
            </tr>
            <tr>
                <td>9.</td>
                <td>Jumlah Imbal Jasa Penjaminan</td></th>
                <td>:</td>
                <td>Rp. {{number_format( $sertifikat[0]['plafon'], 2, ',', '.')}} X {{$sertifikat[0]['rate']}} % = Rp. {{number_format( $sertifikat[0]['premi'], 2, ',', '.')}}.</td>

            </tr>
            
        </table> 
          
      
      <br style="line-height:0.2;">
        <p>
           Apabila pinjaman atas nama Terjamin tersebut macet karena Terjamin meninggal dunia;  atau sebab-sebab lain
           sesuai dengan kesepakatan antara Penerima Jaminan dan Penjamin; maka Pihak
           Penjamin akan membayar kepada Penerima Jaminan sesuai dengan jumlah yang disepakati antara Pihak
           Penjamin dan Pihak Penerima Jaminan sebagaimana yang tertuang dalam Perjanjian Kerja Sama antara 
           Pihak Penjamin dengan Pihak Penerima Jaminan Nomor :<b> {{$sertifikat[0]['pks']}}</b>  Tanggal: <b>{{penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglPks'])))}}</b> 
        </p>
<!--        <br>-->
 <br style="line-height:0.4;">
        <p>
           Jangka waktu berlakunya Sertifikat Penjaminan ini sama dengan jangka waktu berlakunya perjanjian
           pinjaman; yaitu terhitung sejak tanggal {{penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglrealisasi'])))}} sampai dengan tanggal {{penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tgljatuhtempo'])))}}; dengan
           ketentuan bahwa apabila Perjanjian Pinjaman mengalami perubahan; maka Sertifikat Penjaminan ini tidak
           berlaku (batal).
        </p>
<!--        <br>-->
 <br style="line-height:0.4;">

        <p>
            Hal-hal lain yang terkait dengan penjaminan ini, namun tidak diuraikan dalam Sertifikat Penjaminan ini;
            mengacu pada perjanjian kerjasama antara Penjamin dengan Penerima Jaminan.
        </p>
<!--        <br>-->
 <br style="line-height:0.4;">

        <p>
            Sertifikat penjaminan ini dibuat berdasarkan Deklarasi atau Surat Permohonan Penjaminan yang 
            diajukan oleh Penerima Jaminan Nomor : {{$sertifikat[0]['nosertifikat']}}  tanggal  {{penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglpengajuan'])))}}.
        </p>
<!--        <br>-->
 <br style="line-height:0.4;">

        <p>Diterbitkan di Mataram pada tanggal {{penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglterbit'])))}}.</p>
        <br>
        <p><b>PT. JAMKRIDA NTB BERSAING</b>
            <img align='right' style="position: absolute; z-index: 1;"  src= "data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(120)->merge('img/jamkrida.png', 0.35, true)->generate('https://testing.jamkridantb.com/verifikasi-sertifikat-penjaminan/'.md5(base64_encode($sertifikat[0]['nosertifikat']))))}} ">
            <!--<img style="position: absolute; z-index: 1;"  src= "data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(95)->merge('img/ttd.png', 0.35, true)->generate('https://testing.jamkridantb.com/verifikasi-tanda-tangan/'.md5(base64_encode($sertifikat[0]['nosertifikat']))))}} ">-->
        </p>

        <p><b>(Penjamin)</b></p>
        <p>
                <img  src="img/ttd.png"class="img-responsive" width='34.5%'  alt="User Image">
        </p>  
        <p><b>INDRA MANTHICA</b></p>
        <p style="position: absolute">Direktur Utama</p>

</body>
</html>
 






