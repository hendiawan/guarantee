<html>
    
    <?php
        
        use App\cetaks;
        use Illuminate\Support\Facades\Session;
        use App\penjaminans;
        
    
    ?>
    <head>
       <style type="text/css">

            body{
                /*font-family: 'calibry';*/
                /*font-family: 'Helvetica';*/
                font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; 
                letter-spacing: 0.2px;
                padding: 0 35px 0 25px;
            }
            ol li, table tr, p{
                 font-size: 12px;
                font-weight: lighter;
                text-align: justify;
                line-height: 12px;
                padding-top: -3px;
            }
            ol li{
                padding-bottom: 4px;
            }
            ol.sertifikat-list, ol.sertifikat-list li ol {
                padding-left: 10px;
            }
            ol.sertifikat-list li {
                padding-left: 10px;
                margin-bottom: 0px;
            }
            ol.sertifikat-list li ol li{
                margin-bottom: 0;
            }
            .relative {
                position: relative;
            }
            .signed-image{
                position: absolute;
                top: 25px;
                left: 0;
                width: 320px;
            }
            .signed-image img{

            }

            h3{
                line-height: 0;
            }
            #footer {
                /*		    position: fixed;*/
                bottom: 85px;
                width: 100%;
                left:25px;
                right: -25px;
            }
            #catatan{
                position: fixed;
                bottom: 77px;
                left:30px;
                right: -30px;
                margin: 10px;
            }
            #catatan p {
                font-family: 'calibry';
                line-height: 3px;
                padding-top: -3px;
            }
            #catatan img { 
                 padding-top:-96px; float:right; margin:1px; z-index: 1;
                   
            }
            @page { size: 595pt 841pt; }
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
  <b style="font-size: 16px">SERTIFIKAT PENJAMINAN PINJAMAN</b> <br style="line-height:0.3;">
  <b style="font-size: 16px">ANGGOTA KOPERASI</b> <br style="line-height:0.3;">
  <b style="font-size: 16px">Nomor : {{strtoupper($sertifikat[0]['kodesertifikat'])}}</b> 
  
    </center>
        <p align="justify" >Dengan ini   <b>PT.JAMKRIDA NTB BERSAING</b> dengan alamat di Ruko Bung Karno Jaya No.11, Jl. Bung Karno (Sayung), Cilinaya,
            Mataram, NTB Sebagai Pihak <b>Penjamin</b> menyatakan mengikatkan diri pada pihak <b>Penerima Jaminan</b>
            yaitu <b>{{strtoupper($sertifikat[0]['namabank'])}} </b>yang beralamat di {{ucwords(strtolower($sertifikat[0]['alamatbank']))}}.

        </p> 
        <p>
            Pihak Penjamin setuju untuk memberikan penjaminan terhadap pinjaman dari Penerima Jaminan kepada
            pihak Terjamin sesuai data berikut :  
        </p>
        
         
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
                <td align="left">Tempat, Tanggal lahir/umur</td>
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
        <p>
           Apabila pinjaman atas nama Terjamin tersebut macet karena Terjamin meninggal dunia;  atau sebab-sebab lain
           sesuai dengan kesepakatan antara Penerima Jaminan dan Penjamin; maka Pihak
           Penjamin akan membayar kepada Penerima Jaminan sesuai dengan jumlah yang disepakati antara Pihak
           Penjamin dan Pihak Penerima Jaminan sebagaimana yang tertuang dalam Perjanjian Kerja Sama antara 
           Pihak Penjamin dengan Pihak Penerima Jaminan Nomor :<b> {{$sertifikat[0]['pks']}}</b>  Tanggal: <b>{{penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglPks'])))}}</b> 
        </p>
<!--        <br>--> 
        <p>
           Jangka waktu berlakunya Sertifikat Penjaminan ini sama dengan jangka waktu berlakunya perjanjian
           pinjaman; yaitu terhitung sejak tanggal {{penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglrealisasi'])))}} sampai dengan tanggal {{penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tgljatuhtempo'])))}}; dengan
           ketentuan bahwa apabila Perjanjian Pinjaman mengalami perubahan; maka Sertifikat Penjaminan ini tidak
           berlaku (batal).
        </p>
<!--        <br>--> 

        <p>
            Hal-hal lain yang terkait dengan penjaminan ini, namun tidak diuraikan dalam Sertifikat Penjaminan ini;
            mengacu pada perjanjian kerjasama antara Penjamin dengan Penerima Jaminan.
        </p>
<!--        <br>--> 

        <p>
            Sertifikat penjaminan ini dibuat berdasarkan Deklarasi atau Surat Permohonan Penjaminan yang 
            diajukan oleh Penerima Jaminan Nomor : {{$sertifikat[0]['nosertifikat']}}  tanggal  {{penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglpengajuan'])))}}.
        </p>
<!--        <br>--> 

        <p>Diterbitkan di Mataram pada tanggal {{penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglterbit'])))}}.</p>
      
           <table width="100%" cellpadding="0" cellspacing="0">
            <tr align="left" valign="top">
               <td width="45%" height="180px">
                    <div class="relative">
                        <strong>PT. JAMKRIDA NTB BERSAING<br>PENJAMIN</strong>
                        <div class="signed-image" >
<!--                            <br> -->
                              <img src="img/direksi/{{$sertifikat[0]['url_ttd']}}" class="img-responsive" width='65%' >
                            <!--<img  src="img/direksi/ttd_indra.jpg"class="img-responsive" width='65%'  >-->
                        </div>
                </td> 
            </tr>
        </table>
<div id="footer">
     <table width="100%" cellpadding="0" cellspacing="0">
            <tr align="left" valign="top"> 
                      @if ($sertifikat[0]['digitalSign']==1) 
                       <td width="45%" style="text-transform:uppercase">
                                {{$sertifikat[0]['name']}}
                       </td> 
                       @else
                       <td width="45%" style="text-transform:uppercase">
                           <span style="font-weight:bold;border-bottom:1px solid #000;padding:0 4px;"> INDRA MANTHICA</span>
                        </td>  
                       @endif 
            </tr>
            <tr>
                
                  @if ($sertifikat[0]['digitalSign']==1) 
                      <td>
                           <span style="border-bottom:0px solid #000;padding:0 4px;">{{$sertifikat[0]['jabatan']}}</span>
                      </td> 
                    @else
                       <td>
                          <span style="border-bottom:0px solid #000;padding:0 4px;">  Direktur Utama</span>
                       </td> 
                    @endif  
            </tr>
        </table>
   
</div> 
        
       <div id="wrapper" class="container">
    <div id="main" class="form-horizontal clearfix">
        <div class="widget-content pad20f">
            <div class="form-group">
                <div class="col-sm-12"> 
                    <div id="catatan">
                        <hr  style="margin-left:-15px;width: 100%" >   
                        <b style="padding-left:8px; font-size:11px;">CATATAN</b> 
                        <p style="padding-left:8px; font-size:10px;">UU ITE No. 11 Tahun 2008 Pasal 5 ayat 1</p>
                        <p style="padding-left:8px; font-size:10px;">"<i>Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetaknya merupakan alat bukti hukum yang sah</i>"</p>
                        <p style="padding-left:8px; font-size:10px;">Dokumen ini telah ditandatangani secara elektronik menggunakan <b>sertifikat elektronik</b> yang diterbitkan <b>BSrE</b></p>
                        <p style="padding-left:8px; font-size:10px;">Dokumen ini dapat dibuktikan keasliannya dengan cara melakukan scan QrCode</p>
                        <p style="padding-left:8px; font-size:10px;">Atau kunjungi halaman Web : </p>
                        <p style="padding-left:8px; font-size:10px;">Https://penjaminan.jamkridantb.com/verifikasi-doc-sertifikat-penjaminan/{{md5(base64_encode($sertifikat[0]['nosertifikat']))}}</p> 
                        <img      src= "data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(101)->merge('img/jamkrida.png', 0.35, true)->generate('https://jamkridantb.com/verifikasi-doc-sertifikat-penjaminan/'.md5(base64_encode($sertifikat[0]['nosertifikat']))))}} ">
                    </div>
                </div>   
            </div>   
        </div>
    </div>
</div>

</body>
</html>
 






