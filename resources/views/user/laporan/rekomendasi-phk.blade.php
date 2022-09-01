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
         <b style="font-size: 13px">LEMBAR ANALISA DAN REKOMENDASI PENJAMINAN KREDIT KONSUMTIF</b><br style="line-height:0.6;">     
    </center>
     
  <b>A. <u>Data Calon Terjamin</u></b>
  <br style="line-height:0.6;">
     <table>
            <tr>
                 <td width="250px"> Nama</td>
                <td>:</td> 
                <td >{{strtoupper($history[0]['nama'])}}.</td>
            </tr> 
            <tr>
                 <td width="150px"> Penggunaan Kredit</td>
                <td>:</td>
                <td >{{strtoupper($history[0]['penggunaan'])}}.</td>
            </tr>
<!--             <tr>
                <td>Tempat, Tanggal lahir/umur</td>
                <td>:</td>
                <td  width="250px">{{ucwords(strtolower($history[0]['tempatlahir']))}}, {{tgl_indo(date('d-m-Y',strtotime($history[0]['tgllahir'])))}}/{{ucwords($history[0]['umur'])}}.</td>
            </tr>-->
            <tr>
                <td width="150px">Plafon</td>
                <td>:</td>
                <td>Rp. {{number_format( $history[0]['plafon'], 2, ',', '.')}}.</td>
            </tr>
            
            <tr>
                <td>Jangka waktu kredit</td>
                <td>:</td>
                <td>{{$history[0]['masakredit']}} Bulan .</td>
            </tr>  
            <tr>
                <td>Suku Bunga</td>
                <td>:</td>
                <td>{{$history[0]['suku_bunga']}} % .</td>
            </tr>  
            <tr>
                <td>Angsuran Per Bulan</td>
                <td>:</td>
                <td>Rp. {{number_format( $history[0]['angsuran'], 2, ',', '.')}}.</td>
            </tr>  
             <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{$history[0]['pekerjaan']}}.</td>
            </tr>
             <tr>
                <td>Perusahaan / Instansi</td>
                <td>:</td>
                <td>{{$history[0]['nama_perusahaan']}}.</td>
            </tr>
             <tr>
                <td>Masa Kerja</td>
                <td>:</td>
                <td>{{$history[0]['masa_kerja']}}.</td>
            </tr>
             <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{$history[0]['jabatan']}}.</td>
            </tr>
             <tr>
                <td>Hasil SLIK</td>
                <td>:</td>
                  <td> {{$history[0]['pengecekan_slik']}}.</td>
            </tr>  
     </table> 
    <br style="line-height:0.6;">
    <b>B. <u> Analisa Pendapatan & Pengeluaran </u></b>
  <br style="line-height:0.6;">
        <table>
             <tr>
                <td width="250px">Pendapatan Pemohon</td>
                <td>:</td>
                <td>Rp. </td>
                <td align='right'>{{number_format( $history[0]['pendapatan_utama'], 2, ',', '.')}}.</td>
            </tr>
             <tr>
                <td width="250px">Pendapatan Lainnya</td>
                <td>:</td>
                <td>Rp. </td>
                <td align='right'>{{number_format( $history[0]['pendapatan_lainnya'], 2, ',', '.')}}.</td>
            </tr> 
             <tr>
                <td width="150px">Total Biaya Rumah Tangga</td>
                <td>:</td>
                    <td>Rp. </td>
                <td align='right'>{{number_format( $history[0]['biaya_rumah_tangga'], 2, ',', '.')}}.</td>
            </tr>
             <tr>
                <td width="150px">Angsuran Kredit di Tempat Lain</td>
                <td>:</td>
                    <td>Rp. </td>
                <td align='right'>{{number_format( $history[0]['angsuran_lainnya'], 2, ',', '.')}}.</td>
            </tr>
             <tr>
                <td width="150px">Angsuran Kredit yang diajukan</td>
                <td>:</td>
                    <td>Rp. </td>
                  <td align='right'><u>{{number_format( $history[0]['angsuran'], 2, ',', '.')}}.</u></td>
            </tr>
             <tr>
                <td width="150px"><b>Pendapatan Bersih</b></td>
                <td>:</td>
                 <td>Rp. </td>
                 <td align='right'><b>{{number_format( $history[0]['pendapatan_bersih'], 2, ',', '.')}}.</b></td>
            </tr>
        </table> 
       <br style="line-height:0.6;">
     <b>C.  <u>Data Jaminan </u></b>
     <br style="line-height:0.6;">
        <table>
            <tr>
                <td width="250px"> Jenis Dokumen Agunan</td>
                <td>:</td>
                <td> Sesuai Ketetuan Penerima Jaminan.</td>
            </tr> 
        </table>
     <b>D.  <u>Data Kesehatan </u></b>
     <br style="line-height:0.6;">
        <table>
            <tr>
                <td width="250px"> Catatan Kesehatan</td>
                <td>:</td>
                <td> {{$history[0]['analisa_kesehatan']}}</td>
            </tr> 
        </table>
       <b>E. <u> Rekomendasi </u></b>
     <br style="line-height:0.6;">
        <table>
            <tr>
                <td width="250px"> Jumlah Penjaminan</td>
                <td>:</td>
                <td >Rp. {{number_format( $history[0]['plafon']*$history[0]['penjaminan']/100, 2, ',', '.')}}.</td>
            </tr>
            <tr>
                <td>Jangka Waktu Penjaminan</td>
                <td>:</td>
                   <td ><b>{{$history[0]['masakredit'] }} Bulan</b></td>
            </tr>  
             <tr>
                <td>Angsuran Perbulan</td>
                <td>:</td>
                 <td>Rp. <b>{{number_format( $history[0]['angsuran'], 2, ',', '.')}}.</b></td>
            </tr>  
             <tr>
                <td>Jenis Penjaminan</td>
                <td>:</td>
                  <td> {{$history[0]['jenispenjaminan']}}.</td>
            </tr>  
             <tr>
                <td>Hasil SLIK</td>
                <td>:</td>
                  <td> {{$history[0]['pengecekan_slik']}}.</td>
            </tr>  
             <tr>
                <td>Kapasitas Bayar</td>
                <td>:</td>
                  <td> {{$history[0]['kapasitas']}}.</td>
            </tr>  
             <tr>
                <td>Gros IJP</td>
                <td>:</td>
                 <td>Rp. <b>{{number_format( $history[0]['premi'], 2, ',', '.')}}.</b></td>
            </tr>  
             <tr>
                <td>Fee Bank</td>
                <td>:</td>
                 <td>Rp. <b>{{number_format($history[0]['pot'], 2, ',', '.')}}.</b></td>
            </tr>  
             <tr>
                <td>Nett IJP</td>
                <td>:</td>
                 <td>Rp. <b>{{number_format($history[0]['nett'], 2, ',', '.')}}.</b></td>
            </tr>  
        </table>
   <br style="line-height:0.6;">
    <p>
        <table rules='none' border="1">
        <tr align="left">
            <td  colspan="2" width="347px">  
             {{$history[0]['hasil_akhir']}}
            </td>
            <td  colspan="2" width="347px">  
             {{$history[0]['rekomendasi_kabag']}}
            </td>
        </tr>
        <tr align="left">
            <td  colspan="2" height='80px' width="100%">  
        
            </td>
            <td  colspan="2" width="100%">  
          
            </td>
        </tr>
        <tr align="left">
            <td  colspan="2"  width="100%">  
                Muhammad Fuad
            </td>
            <td  colspan="2" width="100%">  
                Adi Irawan
            </td>
        </tr>
    </table> 
    </p>
     
    <br style="line-height:0.6;">  
    <p><b>F. Keputusan Direksi </b></p>
    <table rules='none' border="1">
        <tr >
            <td width="695px">   {{$history[0]['tanggapandir']}} </td> 
        </tr>
        <tr >
            <td height='80px'width="695px">   </td> 
        </tr>
        <tr>
            <td width="695px">Lalu Taufik Mulyajati</td> 
        </tr>
    </table>
</body>
</html>

