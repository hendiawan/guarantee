<html>
    <head>
        <style type="text/css">
            body{
                font-family: 'arial';
                font-size: 11px;
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
    <p>Dengan Hormat,</p>
     <br style="line-height:0.6;">
    <p>
        Memperhatikan surat dari  <b>{{strtoupper($sp3[0]['namabank'])}}; tanggal: {{date('d-m-y',strtotime($sp3[0]['tglpengajuan']))}}</b>, setelah mempelajari dan menganalisis permohonan Penjaminan Kredit dimaksud, 
        maka bersama ini disampaikan hal-hal sebagai berikut :
    </p>
    <br>
    <b>I. Berdasarkan pertimbangan yang cukup, pada prinsipnya PT. Jamkrida NTB Bersaing selaku Penjamin
        dapat menyetujui permohonan Penjaminan Kredit dengan ketentuan sebagai berikut :</b>
    <br>  
    <table>
            <tr>
                <td></td>
                <td>Nama Terjamin</td>
                <td>:</td>
                <td>{{strtoupper($sp3[0]['nama'])}}.</td>
            </tr>
            <tr>
                <td></td>
                <td> Alamat Terjamin</td>
                <td>:</td>
                <td>{{ucwords(strtolower($sp3[0]['alamat']))}}.</td>
            </tr>
            <tr> 
                <td></td>
                <td> Penerima Jaminan</td>
                <td>:</td>
                <td>{{strtoupper($sp3[0]['namabank'])}}.</td>
            </tr>
            <tr> 
                <td></td>
                <td>Alamat Penerima Jaminan</td>
                <td>:</td>
                <td>{{strtoupper($sp3[0]['alamatbank'])}}.</td>
            </tr>  
            <tr>
                <td></td>
                <td>Jumlah Kredit</td>
                <td>:</td>
                <td>Rp. {{number_format( $sp3[0]['plafon'], 2, ',', '.')}}.</td>
            </tr>
            <tr>
                <td></td>
                <td>Jumlah Penjaminan</td>
                <td>:</td>
                <td>Rp. {{number_format( $sp3[0]['plafon']*$sp3[0]['penjaminan']/100, 2, ',', '.')}}.</td>
            </tr>
            <tr>
                <td></td>
                <td>Skim Kredit</td>
                <td>:</td>
                <td>{{$sp3[0]['jeniskredit']}}.</td>
            </tr>
            <tr>
                <td></td>
                <td>Penggunaan Kredit</td>
                <td>:</td>
                <td>{{$sp3[0]['penggunaan']}}.</td>
            </tr>
            <tr>
                <td></td>
                <td>Jangka waktu kredit</td>
                <td>:</td>
                <td>{{$sp3[0]['masakredit']}} Bulan</td>
            </tr>
            <tr>
                <td></td>
                <td>Rate IJP</td>
                <td>:</td>
                <td>{{$sp3[0]['rate']}} %.</td>
            </tr>
            <tr>
                <td></td>
                <td>Jumlah Imbal Jasa Penjaminan</td></th>
                <td>:</td>
                <td>Rp. {{number_format( $sp3[0]['plafon'], 2, ',', '.')}} X {{$sp3[0]['rate']}} % = Rp. {{number_format( $sp3[0]['premi'], 2, ',', '.')}}.</td>

            </tr>
            
        </table> 
    <br>
    
    <b>II.  Pelaksanaan Penjaminan Kredit dimaksud memenuhi ketentuan dan persyaratan sebagai berikut :</b>
    <br>
     <table>
            <tr>
                <td></td>
                <td>Pelaksanaan Penjaminan Kredit memenuhi ketentuan dan persyaratan yang tercantum pada Perjanjian Kerja sama antara PT Jamkrida NTB Bersaing dengan 
                    {{strtoupper($sp3[0]['namabank'])}} tentang Pemjaminan Kredit</td>
               
            </tr>
            <tr>
                <td></td>
                <td>Seluruh persyaratan Kredit yang diberlakukan oleh Penerima Jaminan kepada Terjamin sebagaimana tetuang dalam Surat Persetujuan Pemberian Kredit, serta Perjanjian Kredit yang menyertainya, maka secara otomatis menjadi persyaratan dalam Penjaminan Kredit ini.</td>
            </tr>
            <tr>
                <td></td>
                <td>Penjaminan Kredit ini hanya berlaku untuk Skim Kredit {{ $sp3[0]['jenispenjaminan']}} dengan tujuan penggunaan Kredit untuk {{$sp3[0]['penggunaan']}}</td>
            </tr>
            <tr>
                <td></td>
                <td>Sharing Risk : PT. JNB  {{$sp3[0]['share']}} %; {{strtoupper($sp3[0]['namabank'])}} {{100-$sp3[0]['share']}} %</td>
            </tr>
            <tr>
                <td></td>
                <td>Risiko yang dijamin oleh Penjamin adalah jumlah kerugian Penerima Jaminan yang disebabkan oleh kegagalan Terjamin sebagai penerima Kredit dalam memenuhi kewajiban finansialnya sesuai yang diperjanjikan.</td>
            </tr>
     </table>
     <br>
     
     <b>III. Penjaminan berlaku efektif terhitung sejak pencairan Kredit kepada Terjamin, Imbal Jasa Penjaminan (IJP) telah dibayarkan/disetorkan kepada Penjamin melalui Rekening Bank yang ada di Penerima Jaminan dengan nomor: ………………….dan telah diterbitkanya Sertifkat Penjaminan</b>
     <br>
     <br>
     <b>IV. Penjamin akan menerbitkan Sertifikat Penjaminan apabila Penerima Jaminan mengajukan Permohonan Penerbitan Sertifikat Penjaminan melalui Aplikasi Penjaminan Kredit dengan melampirkan/mengupload bukti pembayaran Imbal Jasa Penjaminan (IJP) yang sudah disetorkan ke Rekening Penjamin.</b>
    <p>
     Surat Persetujuan Prinsip Penjaminan (SP3) berlaku selama 30 (tiga puluh) hari kerja sejak tanggal diterbitkanya, apabila sampai dengan batas waktu yang telah ditetapkan, Penerima Jaminan belum memberikan tanggapan persetujuannya, maka SP3 ini menjadi batal dengan sendirinya.
    </p>
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
    <p><b>LALU TAUFIK MULYAJATI</b></p>
    <p>Direktur</p>
 
</body>
</html>

