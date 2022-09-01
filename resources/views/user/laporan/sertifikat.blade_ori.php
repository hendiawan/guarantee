<html>
    
    <?php
        
        use App\cetaks;
        use Illuminate\Support\Facades\Session;
        use App\Http\Controllers\DireksiController;
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
            
               #footer {
		    position: fixed;
		    bottom: 77px;
		    left:30px;
		    right: -30px;
		}
                hr { 
                    display: block;
                    margin-top: 75em;
                    margin-bottom: 0.5em;
                    margin-left: 3em;
                    margin-right: 2.5em;
                    border-style: inset;
                    border-width: 0.8px;
                    position: fixed;
                } 
        </style>
    </head>         
    <body >
    <center>
        <img  src="img/kop2018.jpg" class="img-responsive" width='100%'  alt="User Image">
        <!--<hr>-->
        <!--  <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br> -->  
        <br style="line-height:0.6;">
        <b style="font-size: 17px">SERTIFIKAT PENJAMINAN KREDIT {{strtoupper($sertifikat[0]['jeniskredit'])}}</b> <br style="line-height:0.3;">
        <b style="font-size: 17px">Nomor : {{strtoupper($sertifikat[0]['kodesertifikat'])}}</b>
    </center>
    <br style="line-height:0.6;">
        <p align="justify" >Dengan ini   <b>PT.JAMKRIDA NTB BERSAING</b> dengan alamat di Ruko Bung Karno Jaya No.11, Jl. Bung Karno (Sayung), Cilinaya,
            Mataram, NTB Sebagai Pihak <b>Penjamin</b> menyatakan mengikatkan diri pada pihak <b>Penerima Jaminan</b>
            yaitu <b>{{strtoupper($sertifikat[0]['namabank'])}} dengan alamat di {{ucwords(strtolower($sertifikat[0]['alamatbank']))}}.</b>
           
        </p>
         <br style="line-height:0.3;">
         
        <p>
            Pihak Penjamin setuju untuk memberikan penjaminan terhadap kredit dari Penerima Jaminan kepada
            pihak Terjamin sesuai data berikut :  
        </p>
        <br style="line-height:0.3;">
         @if($sertifikat[0]['jeniskredit']=='KONSUMTIF')
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
                <td>{{ucwords(strtolower($sertifikat[0]['tempatlahir']))}}, {{ penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tgllahir'])))}}.</td>
            </tr>
            <tr>
                <td>6.</td>
                <td>Jumlah Kredit</td>
                <td>:</td>
                <td>Rp. {{number_format( $sertifikat[0]['plafon'], 2, ',', '.')}}.</td>
            </tr>
            <tr>
                <td>7.</td>
                <td>Jangka waktu kredit</td>
                <td>:</td>
                <td>{{$sertifikat[0]['masakredit']}} Bulan sejak tanggal {{penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglrealisasi'])))}} s/d {{date('d-m-Y',strtotime($sertifikat[0]['tgljatuhtempo']))}}.</td>
            </tr>
            <tr>
                <td>8.</td>
                <td>Perjanjian kredit</td>
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
      @else
        <table>
            
            <tr>
                <td>1.</td>
                <td>Nama Terjamin</td>
                <td>:</td>
                <td>{{strtoupper($sertifikat[0]['nama'])}}.</td>
            </tr>
            <tr>
                <td>2.</td>
                <td>Alamat Terjamin</td>
                <td>:</td>
                <td>{{ucwords(strtolower($sertifikat[0]['alamat']))}}.</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Tempat, Tanggal lahir/umur</td>
                <td>:</td>
                <td>{{ucwords(strtolower($sertifikat[0]['tempatlahir']))}}, {{penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tgllahir'])))}}/{{ucwords($sertifikat[0]['umur'])}}.</td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Nomor KTP</td>
                <td>:</td>
                <td>{{strtoupper($sertifikat[0]['ktp'])}}.</td>
            </tr>
            <tr>
                <td>5.</td>
                <td>Jenis Usaha Terjamin</td>
                <td>:</td>
                <td>{{strtoupper($sertifikat[0]['pekerjaan'])}}.</td>
            </tr>
            
            <tr>
                <td>6.</td>
                <td>Jumlah Kredit</td>
                <td>:</td>
                <td>Rp. {{number_format( $sertifikat[0]['plafon'], 2, ',', '.')}}.</td>
            </tr>
            <tr>
                <td>7.</td>
                <td>Jangka waktu kredit</td>
                <td>:</td>
                <td>{{$sertifikat[0]['masakredit']}} Bulan sejak tanggal {{penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglrealisasi'])))}} s/d {{penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tgljatuhtempo'])))}}.</td>
            </tr>
            <tr>
                <td>8.</td>
                <td>Perjanjian kredit</td>
                <td>:</td>
                <td>Nomor :{{$sertifikat[0]['nopk']}} tanggal {{penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglpk'])))}}.</td>
            </tr>
            <tr>
                <td>9.</td>
                <td>Jumlah Imbal Jasa Penjaminan</td></th>
                <td>:</td>
                <td>Rp. {{number_format( $sertifikat[0]['plafon'], 2, ',', '.')}} X {{$sertifikat[0]['rate']}} % = Rp. {{number_format( $sertifikat[0]['premi'], 2, ',', '.')}}.</td>
            </tr>
            
        </table>
      @endif
      
      <br style="line-height:0.2;">
        <p>
           Apabila kredit atas nama Terjamin tersebut macet; baik karena   @if($sertifikat[0]['jeniskredit']=='KONSUMTIF') meninggal dunia @else kegagalan usaha  @endif atau sebab-sebab lain
           sesuai dengan yang disepakati antara Penjamin dan Penerima Jaminan; sedemikian rupa sehingga
           memenuhi persyaratan tentang kredit macet sebagaimana Peraturan Otoritas Jasa Keuangan; maka Pihak
           Penjamin akan membayar kepada Penerima Jaminan sesuai dengan jumlah yang disepakati antara Pihak
           Penjamin dan Pihak Penerima Jaminan sebagaimana yang tertuang dalam Perjanjian Kerja Sama antara 
           Pihak Penjamin dengan Pihak Penerima Jaminan.
        </p>
<!--        <br>-->
 <br style="line-height:0.4;">
        <p>
           Jangka waktu berlakunya Sertifikat Penjaminan ini sama dengan jangka waktu berlakunya perjanjian
           kredit; yaitu terhitung sejak tanggal {{penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglrealisasi'])))}} sampai dengan tanggal {{penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tgljatuhtempo'])))}}; dengan
           ketentuan bahwa apabila Perjanjian Kredit mengalami perubahan; maka Sertifikat Penjaminan ini tidak
           berlaku.
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
            diajukan oleh Penerima Jaminan tanggal  {{penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglpengajuan'])))}}.
        </p>
<!--        <br>-->
 <br style="line-height:0.4;">

        <p>Diterbitkan di Mataram pada tanggal {{penjaminans::tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglterbit'])))}}.</p>
        <br style="line-height:0.2;">
        <p><b>PT. JAMKRIDA NTB BERSAING</b>
            <!--<img style="position: absolute; z-index: 1;"  src= "data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(95)->merge('img/ttd.png', 0.35, true)->generate('https://testing.jamkridantb.com/verifikasi-tanda-tangan/'.md5(base64_encode($sertifikat[0]['nosertifikat']))))}} ">-->
        </p>

        <p><b>(Penjamin)</b></p>
        <p>
                <img  src="img/ttd.png"class="img-responsive" width='34.5%'  alt="User Image">
<!--        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>-->
        </p>  
        <p><b>INDRA MANTHICA</b></p>
        <p style="position: absolute">Direktur Utama</p>
      
        <!--<br>-->
        
        <hr>
        <div id="footer">
                <p style="padding-left:8px; font-size:11px;">CATATAN</p>
                <br>
                <p style="padding-left:8px; font-size:10px;">UU ITE No. 11 Tahun 2008 Pasal 5 ayat 1</p>
                <p style="padding-left:8px; font-size:10px;">"<i>Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetaknya merupakan alat bukti hukum yang sah</i>"</p>
                <p style="padding-left:8px; font-size:10px;">Dokumen ini telah ditandatangani secara elektronik menggunakan <b>sertifikat elektronik</b> yang diterbitkan <b>BSrE</b></p>
                <p style="padding-left:8px; font-size:10px;">Dokumen ini dapat dibuktikan keasliannya dengan cara melakukan scan QrCode</p>
                <p style="padding-left:8px; font-size:10px;">Atau kunjungi halaman Web : </p>
                <p style="padding-left:8px; font-size:10px;">Https://testing.jamkridantb.com/verifikasi-sertifikat-penjaminan/{{md5(base64_encode($sertifikat[0]['nosertifikat']))}}</p>
                <img align='right' style="padding-top:-135px; float:right; margin:60px; z-index: 1;"  src= "data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(90)->merge('img/jamkrida.png', 0.35, true)->generate('https://testing.jamkridantb.com/verifikasi-sertifikat-penjaminan/'.md5(base64_encode($sertifikat[0]['nosertifikat']))))}} ">
            </div>
</body>

</html>
 






