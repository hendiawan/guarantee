<html>
    
    <?php
        
        use App\cetaks;
        use Illuminate\Support\Facades\Session;
    
        
    function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
 
	return  $pecahkan[0].' '.$bulan[ (int)$pecahkan[1] ] .' '. $pecahkan[2]  ;
}
 

    
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
		    bottom: 85px;
		    width: 100%;
		    left:25px;
		    right: -25px;
		}
        </style>
    </head>         
    <body >
    <center>
<!--        <img  src="img/kop2018.jpg" class="img-responsive" width='100%'  alt="User Image">-->
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br> 
  <h2>SERTIFIKAT PENJAMINAN KREDIT {{strtoupper($sertifikat[0]['jeniskredit'])}}<br>
  Nomor : {{strtoupper($sertifikat[0]['kodesertifikat'])}}</h2>
         
 <br style="line-height:0.3;">
            </center>
        <p align="justify" >Dengan ini   <b>PT.JAMKRIDA NTB BERSAING</b> dengan alamat di Ruko Bung Karno Jaya No.11, Jl. Bung Karno (Sayung), Cilinaya,
            Mataram, NTB Sebagai Pihak <b>Penjamin</b> menyatakan mengikatkan diri pada pihak <b>Penerima Jaminan</b>
            yaitu <b>{{strtoupper($sertifikat[0]['namabank'])}} dengan alamat di {{ucwords(strtolower($sertifikat[0]['alamatbank']))}}.</b>
           
          
        </p>
         <br style="line-height:0.4;">
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
                <td>{{ucwords(strtolower($sertifikat[0]['tempatlahir']))}}, {{tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tgllahir'])))}}/{{ucwords($sertifikat[0]['umur'])}}.</td>
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
                <td>{{$sertifikat[0]['masakredit']}} Bulan sejak tanggal {{tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglrealisasi'])))}} s/d {{date('d-m-Y',strtotime($sertifikat[0]['tgljatuhtempo']))}}.</td>
            </tr>
            <tr>
                <td>8.</td>
                <td>Perjanjian kredit</td>
                <td>:</td>
                <td>Nomor : {{$sertifikat[0]['nopk']}} tanggal {{tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglpk'])))}}.</td>
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
                <td>{{ucwords(strtolower($sertifikat[0]['tempatlahir']))}}, {{tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tgllahir'])))}}/{{ucwords($sertifikat[0]['umur'])}}.</td>
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
                <td>{{$sertifikat[0]['masakredit']}} Bulan sejak tanggal {{tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglrealisasi'])))}} s/d {{tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tgljatuhtempo'])))}}.</td>
            </tr>
            <tr>
                <td>8.</td>
                <td>Perjanjian kredit</td>
                <td>:</td>
                <td>Nomor :{{$sertifikat[0]['nopk']}} tanggal {{tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglpk'])))}}.</td>
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
           kredit; yaitu terhitung sejak tanggal {{tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglrealisasi'])))}} sampai dengan tanggal {{tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tgljatuhtempo'])))}}; dengan
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
            diajukan oleh Penerima Jaminan tanggal  {{tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglpengajuan'])))}}.
        </p>
<!--        <br>-->
 <br style="line-height:0.4;">

        <p>Diterbitkan di Mataram pada tanggal {{tgl_indo(date('d-m-Y',strtotime($sertifikat[0]['tglterbit'])))}}.</p>
        <br>
        <p><b>PT. JAMKRIDA NTB BERSAING</b>
            <!--<img style="position: absolute; z-index: 1;"  src= "data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(95)->merge('img/ttd.png', 0.35, true)->generate('https://testing.jamkridantb.com/verifikasi-tanda-tangan/'.md5(base64_encode($sertifikat[0]['nosertifikat']))))}} ">-->
        </p>

        <p><b>(Penjamin)</b></p>
        <p>
                <!--<img  src="img/ttd.png"class="img-responsive" width='34.5%'  alt="User Image">-->
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        </p>  
        <p><b>INDRA MANTHICA</b></p>
        <p style="position: absolute">Direktur Utama</p>
        <div id="footer">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr align="center" style="text-transform:uppercase">
                    <td width="45%"><span style="font-weight:bold;border-bottom:1px solid #000;padding:0 5px;"></span></td>
                    <td></td>
                    <td width="45%"><span style="font-weight:bold;border-bottom:1px solid #000;padding:0 5px;"></span></td>
                </tr>
                <tr align="center">	
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr align="center">
                    <td> </td>
                    <td> <img align='right' style="position: absolute; z-index: 1;"  src= "data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(120)->merge('img/jamkrida.png', 0.35, true)->generate('https://testing.jamkridantb.com/verifikasi-sertifikat-penjaminan/'.md5(base64_encode($sertifikat[0]['nosertifikat']))))}} "></td>
                    <td>Direktur Utama</td>
                </tr>
            </table>
            <p style="padding-top:0;font-size:9px;padding-left:30px;line-height:10px;">Service Charge Rp. </p>
        </div>
</body>
<!--<footer>
    Copyright &copy; <?php echo date("Y"); ?> 
</footer>-->
</html>
 






