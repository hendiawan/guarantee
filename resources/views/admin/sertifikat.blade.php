<html>
    
    <?php
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
 
	return  $pecahkan[0].'-'.$bulan[ (int)$pecahkan[1] ] .'-'. $pecahkan[2]  ;
}
 

    
    ?>
    <head>
        <style type="text/css">
            body{
                font-family: 'calibri';
                font-size: 13px;
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
        <img  src="img/kop2018.jpg"class="img-responsive" width='100%'  alt="User Image">
  <br>
  <h2>SERTIFIKAT PENJAMINAN KREDIT {{strtoupper($sertifikat['sertifikat'][0]['jeniskredit'])}}<br>
  Nomor : {{strtoupper($sertifikat['sertifikat'][0]['kodesertifikat'])}}</h2>
         
        <br>
            </center>
        <p align="justify" >Dengan ini   <b>PT.JAMKRIDA NTB BERSAING</b> dengan alamat di Ruko Bung Karno Jaya No.11, Jl. Bung Karno (Sayung), Cilinaya,
            Mataram, NTB Sebagai Pihak <b>Penjamin</b> menyatakan mengikatkan diri pada pihak <b>Penerima Jaminan</b>
            yaitu <b>{{strtoupper($sertifikat['sertifikat'][0]['namabank'])}}.</b>
            <br>       
              
            Pihak Penjamin setuju untuk memberikan penjaminan terhadap kredit dari Penerima Jaminan kepada
            pihak Terjamin sesuai data berikut :
        </p>
        <br>
       
        
         @if($sertifikat['sertifikat'][0]['jeniskredit']=='KONSUMTIF')
        <table>
            <tr>
                <td>1.</td>
                <td>Nama Terjamin</td>
                <td>:</td>
                <td>{{strtoupper($sertifikat['sertifikat'][0]['nama'])}}.</td>
            </tr>
            <tr>
                <td>2.</td>
                <td> Alamat Terjamin</td>
                <td>:</td>
                <td>{{ucwords(strtolower($sertifikat['sertifikat'][0]['alamat']))}}.</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Pekerjaan Terjamin</td>
                <td>:</td>
                <td>{{strtoupper($sertifikat['sertifikat'][0]['pekerjaan'])}}.</td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Nomor KTP</td>
                <td>:</td>
                <td>{{strtoupper($sertifikat['sertifikat'][0]['ktp'])}}.</td>
            </tr>
            <tr>
                <td>5.</td>
                <td>Tempat, Tanggal lahir/umur</td>
                <td>:</td>
                <td>{{ucwords(strtolower($sertifikat['sertifikat'][0]['tempatlahir']))}}, {{tgl_indo(date('d-m-Y',strtotime($sertifikat['sertifikat'][0]['tgllahir'])))}}/{{ucwords($sertifikat['sertifikat'][0]['umur'])}}.</td>
            </tr>
            <tr>
                <td>6.</td>
                <td>Jumlah Kredit</td>
                <td>:</td>
                <td>Rp. {{number_format( $sertifikat['sertifikat'][0]['plafon'], 2, ',', '.')}}.</td>
            </tr>
            <tr>
                <td>7.</td>
                <td>Jangka waktu kredit</td>
                <td>:</td>
                <td>{{$sertifikat['sertifikat'][0]['masakredit']}} Bulan sejak tanggal {{tgl_indo(date('d-m-Y',strtotime($sertifikat['sertifikat'][0]['tglrealisasi'])))}} s/d {{date('d-m-Y',strtotime($sertifikat['sertifikat'][0]['tgljatuhtempo']))}}.</td>
            </tr>
            <tr>
                <td>8.</td>
                <td>Perjanjian kredit</td>
                <td>:</td>
                <td>Nomor : {{$sertifikat['sertifikat'][0]['nopk']}} tanggal {{tgl_indo(date('d-m-Y',strtotime($sertifikat['sertifikat'][0]['tglpk'])))}}.</td>
            </tr>
            <tr>
                <td>9.</td>
                <td>Imbal Jasa Penjaminan</td></th>
                <td>:</td>
                <td>Rp. {{number_format( $sertifikat['sertifikat'][0]['plafon'], 2, ',', '.')}} X {{$sertifikat['sertifikat'][0]['rate']}} % = Rp. {{number_format( $sertifikat['sertifikat'][0]['premi'], 2, ',', '.')}}.</td>

            </tr>
            
        </table>
      @else
        <table>
            
            <tr>
                <td>1.</td>
                <td>Nama Terjamin</td>
                <td>:</td>
                <td>{{strtoupper($sertifikat['sertifikat'][0]['nama'])}}.</td>
            </tr>
            <tr>
                <td>2.</td>
                <td>Alamat Terjamin</td>
                <td>:</td>
                <td>{{ucwords(strtolower($sertifikat['sertifikat'][0]['alamat']))}}.</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Tempat, Tanggal lahir/umur</td>
                <td>:</td>
                <td>{{ucwords(strtolower($sertifikat['sertifikat'][0]['tempatlahir']))}}, {{tgl_indo(date('d-m-Y',strtotime($sertifikat['sertifikat'][0]['tgllahir'])))}}/{{ucwords($sertifikat['sertifikat'][0]['umur'])}}.</td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Nomor KTP</td>
                <td>:</td>
                <td>{{strtoupper($sertifikat['sertifikat'][0]['ktp'])}}.</td>
            </tr>
            <tr>
                <td>5.</td>
                <td>Jenis Usaha Terjamin</td>
                <td>:</td>
                <td>{{strtoupper($sertifikat['sertifikat'][0]['pekerjaan'])}}.</td>
            </tr>
            
            <tr>
                <td>6.</td>
                <td>Jumlah Kredit</td>
                <td>:</td>
                <td>Rp. {{number_format( $sertifikat['sertifikat'][0]['plafon'], 2, ',', '.')}}.</td>
            </tr>
            <tr>
                <td>7.</td>
                <td>Jangka waktu kredit</td>
                <td>:</td>
                <td>{{$sertifikat['sertifikat'][0]['masakredit']}} Bulan sejak tanggal {{tgl_indo(date('d-m-Y',strtotime($sertifikat['sertifikat'][0]['tglrealisasi'])))}} s/d {{tgl_indo(date('d-m-Y',strtotime($sertifikat['sertifikat'][0]['tgljatuhtempo'])))}}.</td>
            </tr>
            <tr>
                <td>8.</td>
                <td>Perjanjian kredit</td>
                <td>:</td>
                <td>Nomor :{{$sertifikat['sertifikat'][0]['nopk']}} tanggal {{tgl_indo(date('d-m-Y',strtotime($sertifikat['sertifikat'][0]['tglpk'])))}}.</td>
            </tr>
            <tr>
                <td>9.</td>
                <td>Imbal Jasa Penjaminan</td></th>
                <td>:</td>
                <td>Rp. {{number_format( $sertifikat['sertifikat'][0]['plafon'], 2, ',', '.')}} X {{$sertifikat['sertifikat'][0]['rate']}} % = Rp. {{number_format( $sertifikat['sertifikat'][0]['premi'], 2, ',', '.')}}.</td>
            </tr>
            
        </table>
      @endif
      
        <br>
        <p>
           Apabila kredit atas nama Terjamin tersebut macet; baik karena   @if($sertifikat['sertifikat'][0]['jeniskredit']=='KONSUMTIF') meninggal dunia @else kegagalan usaha  @endif atau sebab-sebab lain
           sesuai dengan yang disepakati antara Penjamin dan Penerima Jaminan; sedemikian rupa sehingga
           memenuhi persyaratan tentang kredit macet sebagaimana Peraturan Bank Indonesia; maka Pihak
           Penjamin akan membayar kepada Penerima Jaminan sesuai dengan jumlah yang disepakati antara Pihak
           Penjamin dan Pihak Penerima Jaminan sebagaimana yang tertuang dalam Perjanjian Kerja Sama antara 
           Pihak Penjamin dengan Pihak Penerima Jaminan.
        </p>
        <br>
        <p>
           Jangka waktu berlakunya Sertifikat Penjaminan ini sama dengan jangka waktu berlakunya perjanjian
           kredit; yaitu terhitung sejak tanggal {{tgl_indo(date('d-m-Y',strtotime($sertifikat['sertifikat'][0]['tglrealisasi'])))}} sampai dengan tanggal {{tgl_indo(date('d-m-Y',strtotime($sertifikat['sertifikat'][0]['tgljatuhtempo'])))}}; dengan
           ketentuan bahwa apabila Perjanjian Kredit mengalami perubahan; maka Sertifikat Penjaminan ini tidak
           berlaku.
        </p>
        <br>
        <p>
            Hal-hal lain yang terkait dengan penjaminan ini, namun tidak diuraikan dalam Sertifikat Penjaminan ini;
            mengacu pada perjanjian kerjasama antara Penjamin dengan Penerima Jaminan.
        </p>
        <br>
        <p>
            Sertifikat penjaminan ini dibuat berdasarkan Deklarasi atau Surat Permohonan Penjaminan yang 
            diajukan oleh Penerima Jaminan tanggal  {{tgl_indo(date('d-m-Y',strtotime($sertifikat['sertifikat'][0]['tglpengajuan'])))}}.
        </p>
        <br>
        <p>Diterbitkan di Mataram pada tanggal {{tgl_indo(date('d-m-Y',strtotime($sertifikat['sertifikat'][0]['tglterbit'])))}}.</p>
        <br>
        <p><b>PT. JAMKRIDA NTB BERSAING</b> <img align="right" src= "data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(100)->generate(md5(base64_encode($sertifikat['sertifikat'][0]['nosertifikat']))))}} ">
        </p>
        <p><b>(Penjamin)</b></p>
                <img  src="img/ttd.png"class="img-responsive" width='40%'  alt="User Image">

        </p>
    
    <p><b>INDRA MANTHICA</b></p>
    <p>Direktur Utama</p>
  
     
 
    
</body>
</html>








