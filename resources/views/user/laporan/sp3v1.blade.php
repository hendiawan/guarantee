<html>
    <head>
        <style type="text/css">
            body{
                font-family: 'arial';
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
 
	return  $pecahkan[0].' '.$bulan[ (int)$pecahkan[1] ] .' '. $pecahkan[2]  ;
}

    ?>
    <center>
        <img  src="img/kop2018.jpg"class="img-responsive" width='100%'  alt="User Image">
        <br style="line-height:0.6;">
         <b style="font-size: 17px">SURAT PERSETUJUAN PRINSIP PENJAMINAN(SP3)</b><br style="line-height:0.6;">
        <u> <b style="font-size: 17px">Nomor : SPPP/{{strtoupper($sp3[0]['nosertifikat'])}}</h2></b>
          
    </center>
     <br style="line-height:0.6;">
    <p>
        Sesuai dengan Deklarasi dan atau Surat Permohonan Penjaminan yang diajukan oleh <b>{{strtoupper($sp3[0]['namabank'])}};</b>
        dengan ini <b>PT. JAMKRIDA NTB BERSAING</b> dengan alamat di Ruko 
        Bung Karno Jaya No. 11, Jl. Bung Karno, Cilinaya, Mataram; menyatakan setuju untuk memberikan
        penjaminan kepada Terjamin; sebagaimana data berikut :
    </p>
    <br>
    <b>I. IDENTITAS PENERIMA JAMINAN</b>
    <br>
     <table>
            <tr>
                <td>1.</td>
                <td>Nama</td>
                <td>:</td>
                <td>{{strtoupper($sp3[0]['namabank'])}}.</td>
            </tr>
            <tr>
                <td>2.</td>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ucwords(strtolower($sp3[0]['alamatbank']))}}.</td>
            </tr>
     </table>
     <br>
    <b>II. IDENTITAS TERJAMIN DAN DATA KREDIT</b>
    <br>
       @if($sp3[0]['jeniskredit']=='KONSUMTIF')
        <table>
            <tr>
                <td>1.</td>
                <td>Nama Terjamin</td>
                <td>:</td>
                <td>{{strtoupper($sp3[0]['nama'])}}.</td>
            </tr>
            <tr>
                <td>2.</td>
                <td> Alamat Terjamin</td>
                <td>:</td>
                <td>{{ucwords(strtolower($sp3[0]['alamat']))}}.</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Pekerjaan Terjamin</td>
                <td>:</td>
                <td>{{strtoupper($sp3[0]['pekerjaan'])}}.</td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Nomor KTP</td>
                <td>:</td>
                <td>{{strtoupper($sp3[0]['ktp'])}}.</td>
            </tr>
            <tr>
                <td>5.</td>
                <td>Tempat, Tanggal lahir/umur</td>
                <td>:</td>
                <td>{{ucwords(strtolower($sp3[0]['tempatlahir']))}}, {{tgl_indo(date('d-m-Y',strtotime($sp3[0]['tgllahir'])))}}/{{ucwords($sp3[0]['umur'])}}.</td>
            </tr>
            <tr>
                <td>6.</td>
                <td>Jumlah Kredit</td>
                <td>:</td>
                <td>Rp. {{number_format( $sp3[0]['plafon'], 2, ',', '.')}}.</td>
            </tr>
            <tr>
                <td>7.</td>
                <td>Jangka waktu kredit</td>
                <td>:</td>
                <td>{{$sp3[0]['masakredit']}} Bulan sejak tanggal {{tgl_indo(date('d-m-Y',strtotime($sp3[0]['tglrealisasi'])))}} s/d {{date('d-m-Y',strtotime($sp3[0]['tgljatuhtempo']))}}.</td>
            </tr>
            <tr>
                <td>8.</td>
                <td>Perjanjian kredit</td>
                <td>:</td>
                <td>Nomor : {{$sp3[0]['nopk']}} tanggal {{tgl_indo(date('d-m-Y',strtotime($sp3[0]['tglpk'])))}}.</td>
            </tr>
            <tr>
                <td>9.</td>
                <td>Jumlah Imbal Jasa Penjaminan</td></th>
                <td>:</td>
                <td>Rp. {{number_format( $sp3[0]['plafon'], 2, ',', '.')}} X {{$sp3[0]['rate']}} % = Rp. {{number_format( $sp3[0]['premi'], 2, ',', '.')}}.</td>

            </tr>
            
        </table>
      @else
        <table>
            
            <tr>
                <td>1.</td>
                <td>Nama Terjamin</td>
                <td>:</td>
                <td>{{strtoupper($sp3[0]['nama'])}}.</td>
            </tr>
            <tr>
                <td>2.</td>
                <td>Alamat Terjamin</td>
                <td>:</td>
                <td>{{ucwords(strtolower($sp3[0]['alamat']))}}.</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Tempat, Tanggal lahir/umur</td>
                <td>:</td>
                <td>{{ucwords(strtolower($sp3[0]['tempatlahir']))}}, {{tgl_indo(date('d-m-Y',strtotime($sp3[0]['tgllahir'])))}}/{{ucwords($sp3[0]['umur'])}}.</td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Nomor KTP</td>
                <td>:</td>
                <td>{{strtoupper($sp3[0]['ktp'])}}.</td>
            </tr>
            <tr>
                <td>5.</td>
                <td>Jenis Usaha Terjamin</td>
                <td>:</td>
                <td>{{strtoupper($sp3[0]['pekerjaan'])}}.</td>
            </tr>
            
            <tr>
                <td>6.</td>
                <td>Jumlah Kredit</td>
                <td>:</td>
                <td>Rp. {{number_format( $sp3[0]['plafon'], 2, ',', '.')}}.</td>
            </tr>
            <tr>
                <td>7.</td>
                <td>Jangka waktu kredit</td>
                <td>:</td>
                <td>{{$sp3[0]['masakredit']}} Bulan sejak tanggal {{tgl_indo(date('d-m-Y',strtotime($sp3[0]['tglrealisasi'])))}} s/d {{tgl_indo(date('d-m-Y',strtotime($sp3[0]['tgljatuhtempo'])))}}.</td>
            </tr>
            <tr>
                <td>8.</td>
                <td>Perjanjian kredit</td>
                <td>:</td>
                <td>Nomor :{{$sp3[0]['nopk']}} tanggal {{tgl_indo(date('d-m-Y',strtotime($sp3[0]['tglpk'])))}}.</td>
            </tr>
            <tr>
                <td>9.</td>
                <td>Jumlah Imbal Jasa Penjaminan</td></th>
                <td>:</td>
                <td>Rp. {{number_format( $sp3[0]['plafon'], 2, ',', '.')}} X {{$sp3[0]['rate']}} % = Rp. {{number_format( $sp3[0]['premi'], 2, ',', '.')}}.</td>
            </tr>
            
        </table>
      @endif
    
    <br>
    
    <b>III. KETENTUAN PENJAMINAN</b>
    <br>
     <table>
            <tr>
                <td>1.</td>
                <td>Penjaminan Kredit ini mengacu pada Perjanjian Kerjasama antara PT. Jamkrida NTB Bersaing dengan {{strtoupper($sp3[0]['namabank'])}}</td>
               
            </tr>
            <tr>
                <td>2.</td>
                <td>Resiko yang dijamin adalah @if($sp3[0]['jenispenjaminan']=='KREDIT DENGAN PEMBAYARAN MUSIMAN(PLAFOND)'){{$sp3[0]['jenispenjaminan']}} @ELSE {{' MACET KARENA MENINGGAL DUNIA'}} @ENDIF </td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Sharing Risk : PT. JNB  {{$sp3[0]['share']}} %; {{strtoupper($sp3[0]['namabank'])}} {{100-$sp3[0]['share']}} %</td>
            </tr>
     </table>
     <br>
    <p>
        SP3 ini sekaligus sebagai Nota Tagihan Jumlah Imbal Jasa Penjaminan (IJP). IJP tersebut harap disetorkan/dilimpahkan
        pada rekening kami di <b>{{strtoupper($sp3[0]['namabank'])}}</b>
    </p> 
    <p>SP3 ini tidak berlaku apablia Sertifikat Penjaminan telah diterbitkan</p>
    <p>SP3 ini berlaku selama 30(Tiga Puluh) hari terhitung sejak tanggal diterbitkannya.</p>
    <br>
    <p>
    @if($sp3[0]['tglterbit'])
    
        Diterbitkan di Mataram pada tanggal {{tgl_indo(date('d-m-Y',strtotime($sp3[0]['tglterbit'])))}}.
    @else
        Diterbitkan di Mataram pada tanggal {{tgl_indo(date('d-m-Y',strtotime($sp3[0]['tglanalisa'])))}}.

    @endif
    
    </p>

   
    <br>
    <p><b>PT. JAMKRIDA NTB BERSAING</b>
        
        </p>
    
      <p><b>(Penjamin)</b><br>
                <img  src="img/ttd.png"class="img-responsive" width='27%'  alt="User Image">

        </p>
    <p><b>INDRA MANTHICA</b></p>
    <p>Direktur Utama</p>
 
</body>
</html>

