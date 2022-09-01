<html>
    <head>
        <style type="text/css">
            body{
                /*font-family: 'calibri';*/
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
	$pecahkan = explode(' ', $tanggal);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
 
	return  $pecahkan[0].' '.$bulan[ (int)$pecahkan[1] ] .' '. $pecahkan[2]  ;
}
 
     if ($suratpengajuan[0]['nama_perubahan'])
            {$nama_bank=$suratpengajuan[0]['nama_perubahan'];}
       else
            {$nama_bank=$suratpengajuan[0]['namabank'];}
    
    ?>
    <center>
        @if($suratpengajuan[0]['logobank']!=null)
      <img  src="img/{{$suratpengajuan[0]['logobank']}}"class="img-responsive" width='{{$suratpengajuan[0]['sizelogo']}}%'  alt="User Image">
      @endif
        <br>
<!--        <h1>SURAT PERMOHONAN PENJAMINAN</h1>-->
 
        <br>
    </center>
    <p style="text-align:right">
    {{ucwords(strtolower($suratpengajuan[0]['kota']))}}, {{tgl_indo(date('d m Y',strtotime($suratpengajuan[0]['tglpengajuan'])))}}.
    </p>
    <p>
        <b>
        KEPADA YTH.<br>
        DIREKTUR UTAMA<br>
        PT. JAMKRIDA NTB BERSAING<br>
        DI TEMPAT.<br>
        <br>
        <br>
        <br>
        @if ($suratpengajuan[0]['jenispengajuan']=='kompensasi')
        HAL : SURAT PERMOHONAN KOMPENSASI PENJAMINAN KREDIT.
        @else
        HAL : SURAT PERMOHONAN PENJAMINAN KREDIT {{$suratpengajuan[0]['jeniskredit']}}.
        @endif
        
        </b>
    </p>
    <br>
    <br>
    
     @if ($suratpengajuan[0]['jenispengajuan']=='kompensasi')
       
    <p>
       Dengan Hormat,<br>
       Dengan ini kami mengajukan permohonan Kompensasi Penjaminan Kredit atas nama Terjamin sesuai data berikut :
    </p>
    <br>
      @if($suratpengajuan[0]['jeniskredit']=='KONSUMTIF')
        <table>
            <tr>
                <td>1.</td>
                <td>Nomor PK Lama</td>
                <td>:</td>
                <td>{{ucwords(strtoupper($suratpengajuan[0]['pklama']))}}.</td>
            </tr>
            <tr>
                <td>2.</td>
                <td>Nama Terjamin</td>
                <td>:</td>
                <td>{{ucwords(strtoupper($suratpengajuan[0]['nama']))}}.</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Alamat Terjamin</td>
                <td>:</td>
                <td>{{ucwords(strtolower($suratpengajuan[0]['alamat']))}}.</td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Pekerjaan Terjamin</td>
                <td>:</td>
                <td>{{ucwords(strtoupper($suratpengajuan[0]['pekerjaan']))}}.</td>
            </tr>
            <tr>
                <td>5.</td>
                <td>Nomor KTP</td>
                <td>:</td>
                <td>{{ucwords(strtolower($suratpengajuan[0]['ktp']))}}</td>
            </tr>
            <tr>
                <td>6.</td>
                <td>Tempat, Tanggal lahir/umur</td>
                <td>:</td>
                <td>{{ucwords(strtolower($suratpengajuan[0]['tempatlahir']))}}, {{tgl_indo(date('d m Y',strtotime($suratpengajuan[0]['tgllahir'])))}}/{{ucwords(strtolower($suratpengajuan[0]['umur']))}}.</td>
            </tr>
            <tr>
                 <td>7.</td>
                <td>Perusahaan / Instansi</td>
                <td>:</td>
                <td>{{$history[0]['nama_perusahaan']}}.</td>
            </tr>
             <tr>
                  <td>8.</td>
                <td>Masa Kerja</td>
                <td>:</td>
                <td>{{$history[0]['masa_kerja']}}.</td>
            </tr>
             <tr>
                  <td>9.</td>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{$history[0]['jabatan']}}.</td>
            </tr>
            <tr>
                <td>10.</td>
                <td>Jumlah Kredit</td>
                <td>:</td>
                <td>Rp.  {{number_format( $suratpengajuan[0]['plafon'], 2, ',', '.')}}</td>
            </tr>
            <tr>
                <td>11.</td>
                <td>Jangka waktu kredit</td>
                <td>:</td>
                <td>{{$suratpengajuan[0]['masakredit']}} Bulan sejak tanggal {{tgl_indo(date('d m Y',strtotime($suratpengajuan[0]['tglrealisasi'])))}} s/d {{tgl_indo(date('d m Y',strtotime($suratpengajuan[0]['tgljatuhtempo'])))}}.</td>
            </tr>
            <tr>
                <td>9.</td>
                <td>Adendum Perjanjian kredit</td>
                <td>:</td>
                <td>Nomor : {{$suratpengajuan[0]['nopk']}} tanggal {{tgl_indo(date('d m Y',strtotime($suratpengajuan[0]['tglpk'])))}}.</td>
            </tr>
            <tr>
                <td>10.</td>
                <td>Jumlah Imbal Jasa Penjaminan</td></th>
                <td>:</td>
                <td>Rp. {{number_format( $suratpengajuan[0]['plafon'], 0, ',', '.')}} X {{$suratpengajuan[0]['rate']}} % = Rp. {{number_format( $suratpengajuan[0]['premi'], 2, ',', '.')}}.</td>
            </tr>
            
        </table>
        @else
        <table>
            <tr>
                <td>1.</td>
                <td>Nomor PK Lama</td>
                <td>:</td>
                <td>{{ucwords(strtoupper($suratpengajuan[0]['pklama']))}}.</td>
            </tr>
            <tr>
                <td>2.</td>
                <td>Nama Terjamin</td>
                <td>:</td>
                <td>{{ucwords(strtoupper($suratpengajuan[0]['nama']))}}.</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Alamat Terjamin</td>
                <td>:</td>
                <td>{{ucwords(strtolower($suratpengajuan[0]['alamat']))}}.</td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Tempat, Tanggal lahir/umur</td>
                <td>:</td>
                <td>{{ucwords(strtolower($suratpengajuan[0]['tempatlahir']))}}, {{tgl_indo(date('d m Y',strtotime($suratpengajuan[0]['tgllahir'])))}}/{{ucwords(strtolower($suratpengajuan[0]['umur']))}}.</td>
            </tr>
            <tr>
                <td>5.</td>
                <td>Nomor KTP</td>
                <td>:</td>
                <td>{{ucwords(strtolower($suratpengajuan[0]['ktp']))}}.</td>
            </tr>
            <tr>
                <td>6.</td>
                <td>Jenis Usaha Terjamin</td>
                <td>:</td>
                <td>{{ucwords(strtoupper($suratpengajuan[0]['pekerjaan']))}}.</td>
            </tr> 
             <tr>
                 <td>7.</td>
                <td>Lama Usaha</td>
                <td>:</td>
                <td>{{$history[0]['lama_usaha']}}.</td>
            </tr>
             <tr>
                 <td>8.</td>
                <td>Perusahaan / Instansi</td>
                <td>:</td>
                <td>{{$suratpengajuan[0]['nama_perusahaan']}}.</td>
            </tr>
             <tr>
                  <td>9.</td>
                <td>Masa Kerja</td>
                <td>:</td>
                <td>{{$suratpengajuan[0]['lama_usaha']}}.</td>
            </tr>
             <tr>
                  <td>10.</td>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{$suratpengajuan[0]['jabatan']}}.</td>
            </tr>
            <tr>
                <td>11.</td>
                <td>Jumlah Kredit</td>
                <td>:</td>
                <td>Rp. {{number_format( $suratpengajuan[0]['plafon'], 2, ',', '.')}}.</td>
            </tr>
            <tr>
                <td>12.</td>
                <td>Jangka waktu kredit</td>
                <td>:</td>
                <td>{{$suratpengajuan[0]['masakredit']}} Bulan sejak tanggal {{tgl_indo(date('d m Y',strtotime($suratpengajuan[0]['tglrealisasi'])))}} s/d {{tgl_indo(date('d m Y',strtotime($suratpengajuan[0]['tgljatuhtempo'])))}}.</td>
            </tr>
            <tr>
                <td>13.</td>
                <td>Adendum Perjanjian kredit</td>
                <td>:</td>
                <td>Nomor :{{$suratpengajuan[0]['nopk']}} tanggal {{tgl_indo(date('d m Y',strtotime($suratpengajuan[0]['tglpk'])))}}.</td>
            </tr>
            <tr>
                <td>14.</td>
                <td>Jumlah Imbal Jasa Penjaminan</td></th>
                <td>:</td>
                <td>Rp. {{number_format( $suratpengajuan[0]['plafon'], 0, ',', '.')}} X {{$suratpengajuan[0]['rate']}} % = Rp. {{number_format( $suratpengajuan[0]['premi'], 2, ',', '.')}}.</td>
            </tr>
            
        </table>
        @endif
    <br>
    <p>
     Dengan adanya surat permohonan kompensasi ini, maka penjaminan sebelumnya dengan nomor sertifikat : <b>{{$suratpengajuan[0]['sertifikatlama']}}</b> dinyatakan <b>tidak berlaku</b>.<br>
     Demikian surat permohonan ini kami ajukan agar dapat diproses dan diterbitkan sertifikat baru.</b>
    </p>
     @else
    <p>
       Dengan Hormat,<br>
       Dengan ini kami mengajukan permohonan penjaminan kredit atas nama Terjamin sesuai data berikut :
    </p>
    <br>
      @if($suratpengajuan[0]['jeniskredit']=='KONSUMTIF')
        <table>
            
            <tr>
                <td>1.</td>
                <td>Nama Terjamin</td>
                <td>:</td>
                <td>{{ucwords(strtoupper($suratpengajuan[0]['nama']))}}.</td>
            </tr>
            <tr>
                <td>2.</td>
                <td>Alamat Terjamin</td>
                <td>:</td>
                <td>{{ucwords(strtolower($suratpengajuan[0]['alamat']))}}.</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Pekerjaan Terjamin</td>
                <td>:</td>
                <td>{{ucwords(strtoupper($suratpengajuan[0]['pekerjaan']))}}.</td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Nomor KTP</td>
                <td>:</td>
                <td>{{ucwords(strtolower($suratpengajuan[0]['ktp']))}}</td>
            </tr>
            <tr>
                <td>5.</td>
                <td>Tempat, Tanggal lahir/umur</td>
                <td>:</td>
                <td>{{ucwords(strtolower($suratpengajuan[0]['tempatlahir']))}}, {{tgl_indo(date('d m Y',strtotime($suratpengajuan[0]['tgllahir'])))}}/{{ucwords(strtolower($suratpengajuan[0]['umur']))}}</td>
            </tr>
            <tr>
                <td>6.</td>
                <td>Jumlah Kredit</td>
                <td>:</td>
                <td>Rp.  {{number_format( $suratpengajuan[0]['plafon'], 2, ',', '.')}}</td>
            </tr>
               <tr>
                 <td>7.</td>
                <td>Perusahaan / Instansi</td>
                <td>:</td>
                <td>{{$suratpengajuan[0]['nama_perusahaan']}}.</td>
            </tr>
             <tr>
                  <td>8.</td>
                <td>Masa Kerja</td>
                <td>:</td>
                <td>{{$suratpengajuan[0]['masa_kerja']}}.</td>
            </tr>
             <tr>
                  <td>9.</td>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{$suratpengajuan[0]['jabatan']}}.</td>
            </tr>
            <tr>
                <td>10.</td>
                <td>Jangka waktu kredit</td>
                <td>:</td>
                <td>{{$suratpengajuan[0]['masakredit']}} Bulan sejak tanggal {{tgl_indo(date('d m Y',strtotime($suratpengajuan[0]['tglrealisasi'])))}} s/d {{tgl_indo(date('d m Y',strtotime($suratpengajuan[0]['tgljatuhtempo'])))}}</td>
            </tr>
            <tr>
                <td>11.</td>
                <td>Perjanjian kredit</td>
                <td>:</td>
                <td>Nomor : {{$suratpengajuan[0]['nopk']}} tanggal {{tgl_indo(date('d m Y',strtotime($suratpengajuan[0]['tglpk'])))}}.</td>
            </tr>
            <tr>
                <td>12.</td>
                <td>Jumlah Imbal Jasa Penjaminan</td></th>
                <td>:</td>
                <td>Rp. {{number_format( $suratpengajuan[0]['plafon'], 0, ',', '.')}} X {{$suratpengajuan[0]['rate']}} % = Rp. {{number_format( $suratpengajuan[0]['premi'], 2, ',', '.')}}.</td>

            </tr>
            
        </table>
        @else
        <table>
            
            <tr>
                <td>1.</td>
                <td>Nama Terjamin</td>
                <td>:</td>
                <td>{{ucwords(strtoupper($suratpengajuan[0]['nama']))}}.</td>
            </tr>
            <tr>
                <td>2.</td>
                <td>Alamat Terjamin</td>
                <td>:</td>
                <td>{{ucwords(strtolower($suratpengajuan[0]['alamat']))}}.</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Tempat, Tanggal lahir/umur</td>
                <td>:</td>
                <td>{{ucwords(strtolower($suratpengajuan[0]['tempatlahir']))}}, {{tgl_indo(date('d m Y',strtotime($suratpengajuan[0]['tgllahir'])))}}/{{ucwords(strtolower($suratpengajuan[0]['umur']))}}.</td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Nomor KTP</td>
                <td>:</td>
                <td>{{ucwords(strtolower($suratpengajuan[0]['ktp']))}}.</td>
            </tr>
            <tr>
                <td>5.</td>
                <td>Jenis Usaha Terjamin</td>
                <td>:</td>
                <td>{{ucwords(strtoupper($suratpengajuan[0]['pekerjaan']))}}.</td>
            </tr>
            <tr>
                <td>6.</td>
                <td>Lama Usaha </td>
                <td>:</td>
                <td>{{ucwords(strtoupper($suratpengajuan[0]['lama_usaha']))}}.</td>
            </tr>
            
            <tr>
                <td>7.</td>
                <td>Jumlah Kredit</td>
                <td>:</td>
                <td>Rp. {{number_format( $suratpengajuan[0]['plafon'], 2, ',', '.')}}.</td>
            </tr>
            <tr>
                <td>8.</td>
                <td>Jangka waktu kredit</td>
                <td>:</td>
                <td>{{$suratpengajuan[0]['masakredit']}} Bulan sejak tanggal {{tgl_indo(date('d m Y',strtotime($suratpengajuan[0]['tglrealisasi'])))}} s/d {{tgl_indo(date('d m Y',strtotime($suratpengajuan[0]['tgljatuhtempo'])))}}.</td>
            </tr>
            <tr>
                <td>9.</td>
                <td>Perjanjian kredit</td>
                <td>:</td>
                <td>Nomor :{{$suratpengajuan[0]['nopk']}} tanggal {{tgl_indo(date('d m Y',strtotime($suratpengajuan[0]['tglpk'])))}}.</td>
            </tr>
            <tr>
                <td>10.</td>
                <td>Jumlah Imbal Jasa Penjaminan</td></th>
                <td>:</td>
                <td>Rp. {{number_format( $suratpengajuan[0]['plafon'], 0, ',', '.')}} X {{$suratpengajuan[0]['rate']}} % = Rp. {{number_format( $suratpengajuan[0]['premi'], 2, ',', '.')}}.</td>
            </tr>
            
        </table>
        @endif
    <br>
    <p>
     Demikian surat permohonan ini kami ajukan agar dapat diproses sebagaimana mestinya.</b>
    </p>
     @endif
    <br> 
    <br>
    <p><b>{{ucwords(strtoupper($nama_bank))}}</b></p> 
    <br>
    <br> 
    @if($suratpengajuan[0]['ttd']!=null)
    <img  src="img/{{$suratpengajuan[0]['ttd']}}"class="img-responsive" width='{{$suratpengajuan[0]['sizettd']}}%'  alt="User Image">
    @endif 
    <p><b>{{ucwords(strtoupper($suratpengajuan[0]['pemohon']))}}</b></p>
    <p>Pincab/Staff</p> 
</body>
</html>

