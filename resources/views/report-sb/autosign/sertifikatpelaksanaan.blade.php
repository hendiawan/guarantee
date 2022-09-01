<!DOCTYPE html>
@php
use App\Http\Controllers\DireksiController;
$direksi = new DireksiController();
@endphp

<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Cetak Sertifikat Surety Bond</title>
        <style type="text/css">
		@font-face {
            font-family: "calibri";           
            src: url("fonts/Calibri.ttf") format("truetype");
            font-weight: normal;
            font-style: normal;

        }  
            body{
                /*font-family: 'calibri';*/
                /*font-family: 'Helvetica';*/
			    /*font-family: calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; */
				font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; 
                letter-spacing: 0.2px;
                padding: 0 35px 0 25px;
            }
            ol li, table tr, p{
                font-size: 12px;
                font-weight: lighter;
                text-align: justify;
                line-height: 12px;
                padding-top: 1.3px;
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
                font-family: 'Times New Romans';
                line-height: 3px;
                padding-top: -3px;
            }
            #catatan img { 
                 padding-top:-96px; float:right; margin:1px; z-index: 1;
                   
            }
            @page { size: 595pt 841pt; }
        </style>
    </head>
    <body>
        <div id="wrapper" class="container">
            <div id="main" class="form-horizontal clearfix">
                <div class="widget-content pad20f">
                    <div style="height:40px;"></div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <table width="100%" cellpadding="0" cellspacing="0" style="color:#FF8989;">
                                <tr>
                                            <td width="50%"><div style="font-size:20px;padding-left:100px;"> <strong>ORIGINAL </strong></div></td>
                                   
                                            <td width="50%"><div align="right" style="font-size:20px;padding-right:40px;"><strong>No.{{ $sppsb->no_sertifikat}}</strong></div></td>
                                </tr>
                            </table>
                            <div style="height:20px;"></div>
                            <div style="height:8px">
                                <h3 align="center" style="font-size:20px;"><strong>JAMINAN PELAKSANAAN</strong></h3>
                                <!--<img align="right" src= "data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(122.9)->merge('img/jamkrida.png', 0.35, true)->generate('https://demo.jamkridantb.com/sb-detail/'.$direksi->enkripsi($sppsb->id)))}} ">-->
                            </div> 
<!--                            <br>
                            <br>
                            <br>
                            <br>
                            <br>	-->
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr style="font-size:14px;">
                                    <td height="40px" width="50%"><div style="padding-left:5px;"><strong>Nomor: {{ $sppsb->no_jaminan}}</strong></div></td>
                                    <td align="right"><strong>Nilai Jaminan Rp. {{ $nilaiJaminanFormat}}</strong></td>
                                </tr>
                            </table>
                            <ol class="sertifikat-list">
                                <li class="text-justify">Dengan ini dinyatakan bahwa kami <span class="text-uppercase"><strong>{{ $sppsb->nama_kontraktor }}</strong></span>
                                    {{ $sppsb->alamat_kontraktor }} sebagai PENYEDIA, selanjutnya disebut <strong>TERJAMIN</strong> dan 
                                    <strong>PT. JAMKRIDA NTB BERSAING Ruko Bung Karno Jaya No.11, Jl. Bung Karno - Cilinaya, Mataram, NTB</strong> sebagai <strong>PENJAMIN</strong>, selanjutnya disebut 
                                    <strong>PENJAMIN</strong>, bertanggung jawab dan dengan tegas terikat pada <span class="text-uppercase"><strong>{{ $sppsb->jabatan_pejabat }} {{ $sppsb->pemilik_proyek }} {{ $sppsb->alamat }}</strong></span> 
                                    sebagai <strong>PEMILIK PEKERJAAN</strong>, selanjutnya disebut sebagai <strong>PENERIMA JAMINAN</strong> atas
                                    uang sejumlah Rp. {{ $nilaiJaminanFormat}} ({{ $nilaiJaminan }} Rupiah ).
                                </li>
                                <li class="text-justify">Maka kami, <strong>TERJAMIN</strong> dan <strong>PENJAMIN</strong> dengan ini mengikatkan diri 
                                    untuk melakukan pembayaran jumlah tersebut di atas dengan baik dan benar, bilamana <strong>TERJAMIN</strong> tidak 
                                    memenuhi kewajibannya sebagaimana ditetapkan dalam <strong>{{ $sppsb->nama_dokumen }}</strong> No.: <strong>{{ $sppsb->no_dokumen }}</strong> 
                                    tanggal {{ $direksi->tgl_indo($sppsb->tgl_dokumen) }} untuk pelaksanaan <strong>{{ $sppsb->jenis_pekerjaan }}</strong> yang diselenggarakan oleh
                                    <strong>PENERIMA JAMINAN</strong>
                                </li>
                                <li class="text-justify">Surat jaminan ini berlaku selama {{ $sppsb->durasi }} ( {{$selisih}} ) hari kalender dan efektif mulai tanggal {{ $direksi->tgl_indo($sppsb->waktu_mulai) }} sampai dengan
                                    tanggal {{ $direksi->tgl_indo($sppsb->waktu_selesai) }}.							
                                </li>
                                <li class="text-justify">Jaminan ini berlaku apabila :
                                    <ol type="a">
                                        <li>TERJAMIN tidak menyelesaikan pekerjaan tersebut pada waktunya dengan baik dan benar sesuai dengan ketentuan dalam kontrak</li>
                                        <li>Pemutusan kontrak akibat kesalahan TERJAMIN</li>
                                    </ol>
                                </li>
                                <li class="text-justify"><strong>PENJAMIN</strong> akan membayar kepada <strong>PENERIMA JAMINAN</strong> sejumlah nilai jaminan tersebut di atas dalam
                                    waktu paling lambat 14 ( Empat Belas ) hari kerja <strong>tanpa syarat (unconditional)</strong> setelah menerima tuntutan
                                    penagihan secara tertulis dari <strong>PENERIMA JAMINAN</strong> berdasarkan keputusan <strong>PENERIMA JAMINAN</strong> mengenai
                                    pengenaan sanksi akibat <strong>TERJAMIN</strong> cidera janji/wan prestasi.
                                </li>
                                <li class="text-justify">Menunjuk pasal 1832 KUH Perdata, dengan ini ditegaskan kembali bahwa <strong>PENJAMIN</strong> melepaskan hak-hak
                                    istimewanya untuk menuntut supaya harta benda <strong>TERJAMIN</strong> lebih dahulu disita dan dijual guna melunasi
                                    hutang-hutangnya sebagaimana dimaksud dalam pasal 1831 KUH Perdata.
                                </li>
                                <li class="text-justify">Tuntutan pencairan terhadap <strong>TERJAMIN</strong> berdasarkan jaminan ini harus sudah diajukan selambat-lambatnya
                                    dalam waktu 30 ( Tiga Puluh ) hari kalender sesudah berakhirnya masa laku jaminan ini.
                                </li>
                            </ol>						
                            <p style="padding-top:0; padding-left:5px;line-height:10px;">Dikeluarkan di Mataram pada tanggal {{ $direksi->tgl_indo($sppsb->tgl_cetak) }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr align="center" valign="top">
                                    <td width="45%" style="text-transform:uppercase"><strong>{{ $sppsb->nama_kontraktor }}<br/>TERJAMIN</strong></td>
                                    <td></td>
                                    <td width="45%" height="150px">
                                        <div class="relative">
                                            <strong>PT. JAMKRIDA NTB BERSAING<br>PENJAMIN</strong>
                                            <br>
                                            <div class="signed-image" >
                                                <br>  
                                              <img src= "data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(160)->merge('img/jamkrida.png', 0.35, true)->generate('https://penjaminan.jamkridantb.com/verifikasi-doc-sertifikat-surety/'.$direksi->enkripsi($sppsb->id)))}} ">
                                              <!--  <img src="img/direksi/{{$sppsb->url_ttd}}" class="img-responsive" width='65%' >-->
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            
                            <div id="footer">
                                <table style="margin-left:-20px" width="100%" cellpadding="0" cellspacing="0">
                                    <tr align="center" style="text-transform:uppercase">
                                        <td width="45%"><span style="font-weight:bold;border-bottom:1px solid #000;padding:0 5px;">{{ $sppsb->direksi }}</span></td>
                                        <td></td>
                                        @if($sppsb->digitalSign!=1 )
                                            <td width="45%"><span style="font-weight:bold;border-bottom:1px solid #000;padding:0 5px;">{{ $userttd['usr_ttd'] }}</span></td>
                                        @else
                                             <td width="45%"><span style="font-weight:bold;border-bottom:1px solid #000;padding:0 5px;">{{ $userttd['usr_ttd'] }}</span></td>
                                        @endif 
                    
                                    </tr>
                                    <tr align="center">	
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr align="center">
                                        <td>{{ $sppsb->jabatan_direksi }}</td>   <!--jabatan dari pejabat kontraktor--> 
                                        <td></td>
                                         @if($sppsb->digitalSign!=1 )
                                            <td>{{  $userttd['jabatan'] }}</td>    <!--Jabatan yang bertandatangan-->
                                        @else
                                            <td>{{  $userttd['usr_ttd'] }}</td> 
                                        @endif
                                    </tr>
                                </table>
                                <p style="padding-top:0;font-size:9px;padding-left:30px;line-height:10px;">Service Charge Rp. {{ $charge }}</p>
                            </div>
                     
                            <div id="catatan">
                                 <hr  style="margin-left:-15px;width: 100%" >   
                                <b style="padding-left:8px; font-size:11px;">CATATAN</b> 
                                <p style="padding-left:8px; font-size:10px;">UU ITE No. 11 Tahun 2008 Pasal 5 ayat 1</p>
                                <p style="padding-left:8px; font-size:10px;">"<i>Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetaknya merupakan alat bukti hukum yang sah</i>"</p>
                                <p style="padding-left:8px; font-size:10px;">Dokumen ini telah ditandatangani secara elektronik menggunakan <b>sertifikat elektronik</b> yang diterbitkan <b>BSrE</b></p>
                                <p style="padding-left:8px; font-size:10px;">Dokumen ini dapat dibuktikan keasliannya dengan cara melakukan scan QrCode</p>
                                <p style="padding-left:8px; font-size:10px;">Atau kunjungi halaman Web : </p>
                                <p style="padding-left:8px; font-size:10px;">Https://penjaminan.jamkridantb.com/verifikasi-doc-sertifikat-surety/{{$direksi->enkripsi($sppsb->id)}}</p>
                                 <img src= "data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(101)->merge('img/jamkrida.png', 0.35, true)->generate('https://penjaminan.jamkridantb.com/verifikasi-doc-sertifikat-surety/'.$direksi->enkripsi($sppsb->id)))}} ">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>