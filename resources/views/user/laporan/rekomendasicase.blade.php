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
         <b style="font-size: 13px">REKOMENDASI HASIL PENILAIAN PERMOHONAN PENJAMINAN</b><br style="line-height:0.6;">
       <b style="font-size: 13px">TIDAK LANGSUNG SECARA CASE BY CASE ATAS NAMA {{strtoupper($history[0]['nama'])}}<br style="line-height:0.6;">
       <b style="font-size: 13px">DARI  {{strtoupper($history[0]['namabank'])}}<br style="line-height:0.6;">
       <b style="font-size: 13px">Nomor : JNB/REKOMENDASI/{{strtoupper($history[0]['nosertifikat'])}}</b>
          
    </center>
     <br style="line-height:0.6;">
        KEPADA YTH.<br>
        DIREKTUR UTAMA<br>
        PT. JAMKRIDA NTB BERSAING<br>
        DI TEMPAT.<br>
       <br>
   
          Dengan Hormat,
          <br>
        
    <p> 
       Berdasarkan permohonan penjaminan dari   {{strtoupper($history[0]['namabank'])}}  melalui {{strtoupper($history[0]['nosertifikat'])}} 
       setelah dilakukan kajian dan diteliti, berikut dapat disampaikan hasil analisa sebagai berikut : 
    </p>
   <br style="line-height:0.6;">
    <b>1. Pekerjaan Calon Terjamin</b>
  <br style="line-height:0.6;">
     <table>
            <tr>
                  <td width="150px"> Nama</td>
                <td>:</td>
                <td >{{strtoupper($history[0]['nama'])}}.</td>
            </tr>
             <tr>
                <td>Tempat, Tanggal lahir/umur</td>
                <td>:</td>
                <td  width="250px">{{ucwords(strtolower($history[0]['tempatlahir']))}}, {{tgl_indo(date('d-m-Y',strtotime($history[0]['tgllahir'])))}}/{{ucwords($history[0]['umur'])}}.</td>
            </tr>
             <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{$history[0]['pekerjaan']}}.</td>
            </tr>
     </table>
 <br style="line-height:0.6;">
     <p>
              <table rules='none' border="1">
        <tr align="justify">
            <td  colspan="2" width="695px">         {{$history[0]['analisa_pekerjaan']}}.  </td>
        </tr>
    </table>
  
     </p>
    <br style="line-height:0.6;">
    <b>2. Umur Dan Fasilitas Kredit</b>
  <br style="line-height:0.6;">
        <table>
            <tr>
                <td width="150px">   Plafond</td>
                <td>:</td>
                <td>Rp. {{number_format( $history[0]['plafon'], 2, ',', '.')}}.</td>
            </tr>
            <tr>
                <td>Jangka waktu kredit</td>
                <td>:</td>
                <td>{{$history[0]['masakredit']}} Bulan .</td>
            </tr>  
        </table>
 <br style="line-height:0.6;">
    <p>
       <table rules='none' border="1">
        <tr align="justify">
              <td  colspan="2" width="695px"> {{$history[0]['analisa_umur']}}</td>
        </tr>
    </table>
    
    </p>
<br style="line-height:0.6;">
       <b>3. Data Kesehatan Calon Terjamin</b>
     <br style="line-height:0.6;">
        <table>
            <tr>
                  <td width="150px"> Gula Darah</td>
                <td>:</td>
                <td> {{$history[0]['guladarah']}}.</td>
            </tr>
            <tr>
                <td>Kolesterol</td>
                <td>:</td>
                <td> {{$history[0]['kolesterol']}}.</td>
            </tr>  
             <tr>
                <td>Tensi</td>
                <td>:</td>
                <td>{{$history[0]['tensi']}}.</td>
            </tr>  
            @if($history[0]['tekanan_jantung']!=null)
            <tr>
                <td>Tekanan Jantung</td>
                <td>:</td>
                <td>{{$history[0]['tekanan_jantung']}}.</td>
            </tr> 
            @endif
        </table>
   <br style="line-height:0.6;">
    <p>
        <table rules='none' border="1">
        <tr align="justify">
            <td  colspan="2" width="695px"> 
             
                @if($history[0]['hasil_akhir']==null)
                {{$history[0]['catatan']}} 
                @else
                {{$history[0]['analisa_kesehatan']}}
                @endif
            
            </td>
        </tr>
    </table>
       
    </p>
    <br>
    <p>
        {{$history[0]['hasil_akhir']}} 
    </p>
 
<br style="line-height:0.6;">  
    <p>
        <b>Demikian kami sampaikan mohon keuptusan Bapak, termakasih.</b><br>
        Hormat Saya,
        </p>
    <br>
    <br>
    <br>
    <br>
       
<!--                <img  src="img/ttd.png"class="img-responsive" width='27%'  alt="User Image">-->

        </p>
    <p><b>Adi Irawan Saputra</b></p>
    <p>(Kabag Penjaminan)</p>
    <br style="line-height:0.6;">  
    <p><b>Keputusan Direksi : </b></p>
    <table rules='none' border="1">
        <tr >
            <td style="height:75px;"  width="695px">   {{$history[0]['tanggapandir']}} </td> 
        </tr>
        <tr>
            <td style="height:75px;" width="695px"></td> 
        </tr>
    </table>
</body>
</html>

