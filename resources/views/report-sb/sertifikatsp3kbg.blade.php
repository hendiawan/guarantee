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
    <body>
        <div id="wrapper" class="container">
            <div id="main" class="form-horizontal clearfix">
                <div class="widget-content pad20f">
                    <!--<div style="height:12px;"></div>-->
                    <div class="form-group">
                        <div class="col-sm-12">
                            	
                            <table width="100%" cellpadding="0" cellspacing="0" style="color:#FF8989;">
                                <tr>
                                    <td width="50%"><div style="font-size:20px;padding-left:100px;"><strong>ORIGINAL</strong></div></td>

                                    <td width="50%"><div align="right" style="font-size:20px;padding-right:40px;"><strong>No.{{ $sppsb->no_sertifikat}}</strong></div></td>
                                </tr>
                            </table>
                            <div style="height:0px;"></div>
                            <h3 align="center" style="font-size:18px;margin-bottom:0;">
                                <strong>SERTIFIKAT PERJANJIAN BANK GARANSI<br/>

                                    @if($sp3kbg->jenis_sp3kbg=='1')
                                    JAMINAN PENAWARAN
                                    @endif
                                    @if($sp3kbg->jenis_sp3kbg=='2')
                                    JAMINAN PELAKSANAAN
                                    @endif
                                    @if($sp3kbg->jenis_sp3kbg=='3')
                                    JAMINAN UANG MUKA
                                    @endif
                                    @if($sp3kbg->jenis_sp3kbg=='4')
                                    JAMINAN PEMELIHARAAN
                                    @endif
                                    @if($sp3kbg->jenis_sp3kbg=='5')
                                    JAMINAN PEMBAYARAN
                                    @endif
                                    @if($sp3kbg->jenis_sp3kbg=='6')
                                    JAMINAN SANGGAH BANDING
                                    @endif</strong></h3>
<!--                            <img align="right" src= "data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(90)->merge('images/jamkrida.png', 0.35, true)->generate('https://demo.jamkridantb.com/sb-detail/'.$direksi->enkripsi($sp3kbg->id)))}} ">
                            <br>
                            <br>
                            <br>
                            <br>-->
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr style="font-size:13px;">
                                    <td height="40px" width="50%"><div style="padding-left:5px;"><strong>Nomor: {{ $sp3kbg->no_jaminan}}</strong></div></td>
                                    <td align="right"><strong>Nilai Jaminan Rp. {{ number_format($sp3kbg->nilai_jaminan,2,",",".") }}</strong></td>
                                </tr>
                            </table>
                            <p>Direksi <strong>PT. JAMKRIDA NTB BERSAING Ruko Bung Karno Jaya No.11, Jl. Bung Karno - Cilinaya, Mataram, NTB</strong> bertindak untuk dan atas nama <strong>PT. JAMKRIDA NTB BERSAING</strong> berkedudukan di Jl. Langko No. 63, Mataram 
                                yang selanjutnya disebut <strong>PENJAMIN</strong>. </p><p>Bahwa atas permintaan dari <span class="text-uppercase"><strong>{{ $sp3kbg->nama_kontraktor }}</strong></span> Berkedudukan di 
                                <strong>{{ $sp3kbg->alamat_kontraktor }}</strong> yang selanjutnya disebut TERJAMIN guna memberikan jaminan kepada PENERIMA JAMINAN :</p>
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="15%"><span style="padding-left:5px">Nama</span></td>
                                    <td width="2%">:</td>
                                    <td align="left"><span class="text-uppercase">{{$bank->name}}</span></td>
                                </tr>
                                <tr>
                                    <td><span style="padding-left:5px;">Alamat</span></td>
                                    <td>:</td>
                                    <td align="left">{{$bank->address}}</td>
                                </tr>
                            </table>
                            <p style="padding-top:5px">Sertifikat Penjaminan Bank Garansi <strong>PELAKSANAAN</strong> ini diterbitkan oleh <strong>PENJAMIN</strong> sehubungan dengan akan diterbitkannya BANK GARANSI oleh 
                                <strong>PENERIMA JAMINAN</strong> untuk kepentingan TERJAMIN guna keperluan <strong>{{ $sp3kbg->jenis_pekerjaan }}</strong> berdasarkan 
                                Surat Penunjukan Penyediaan Barang/Jasa (SPPBJ) Nomor <strong>{{ $sp3kbg->no_dokumen }}</strong> tanggal {{ $direksi->tgl_indo($sp3kbg->tgl_dokumen) }} dengan harga kontrak 
                                Rp. {{ number_format($sp3kbg->nilai_proyek,2,",",".") }} ({{ucwords(terbilang($sp3kbg->nilai_proyek))}} Rupiah) yang berlaku dalam {{ $sp3kbg->durasi }} hari kalender 
                                terhitung sejak tanggal {{ $direksi->tgl_indo($sp3kbg->waktu_mulai) }} sampai dengan tanggal {{ $direksi->tgl_indo($sp3kbg->waktu_selesai) }} yang ditujukan kepada 
                                <span class="text-uppercase"><strong>{{ $sp3kbg->jabatan_pejabat }} {{ $sp3kbg->pemilik_proyek }}</strong>.</p>
                            <p>Bahwa apabila selama masa berlakunya Sertifikat Penjaminan ini TERJAMIN telah lalai atau terjadi wanprestasi sebagaimana yang ditentukan di dalam 
                                BANK GARANSI dimaksud sehingga terjadi pencairan BANK GARANSI, maka <strong>PENERIMA JAMINAN</strong> wajib terlebih dahulu memberitahukan kepada PENJAMINAN secara tertulis 
                                dengan disertai asli SERTIFIKAT PENJAMINAN BANK GARANSI dan bukti-bukti pencairan BANK GARANSI tersebut di atas dengan batas waktu pengajuan klaim selambat-lambatnya 
                                30 (tiga puluh) Hari Kalender sejak tanggal berakhirnya SERTIFIKAT PENJAMINAN BANK GARANSI.</p>
                            <p>Pembayaran sejumlah uang tersebut diatas dilaksanakan selambat-lambatnya 7 (tujuh) hari kalender sejak tanggal diterimanya Surat Klaim Penjaminan Bank Garansi dari Pihak Penerima Jaminan.</p>
                            <p>Bahwa Sertifikat Penjaminan ini dengan sendirinya tidak berlaku lagi apabila :</p>
                            <p>
                            <ol class="sertifikat-list" type="a">
                                <li><strong>TERJAMIN</strong> telah memenuhi kewajibannya sebagaimana yang telah disebutkan dalam BANK GARANSI yang bersangkutan, walaupun angka waktu berlakunya Sertifikat Penjaminan ini belum berakhir.</li>
                                <li>Jangka waktu untuk pengajuan klaim telah berakhir dan atau tidak adanya klaim dari <strong>PENERIMA JAMINAN</strong>.</li>
                                <li>Adanya pernyataan dari <strong>PENERIMA JAMINAN</strong> dan <strong>TERJAMIN</strong> yang menyatakan telah selesainya hal yang dijamin dalam BANK GARANSI tersebut yang dituangkan dalam 
                                    Surat Pernyataan bermaterai serta ditandatangani oleh kedua belah pihak.</li>
                            </ol>
                            </p>
                            <p>Menunjuk pada Pasal 1852 KUH Perdata dengan ini ditegaskan kembali bahwa Penjamin melepaskan hak-hak istimewanya untuk menuntut supaya 
                                harta benda pihak yang dijamin lebih dahulu disita dan dijual guna melunasi hutangnya sebagaimana dimaksud dalam Pasal 1831 KUH Perdata.</p><p>Sertifikat Penjaminan Bank Garansi ini 
                                merupakan bagian yang tak terpisahkan dari Perjanjian Penjaminan Bank Garansi Antara PT. JAMKRIDA NTB BERSAING dengan PT. Bank Pembangunan Daerah NTB Nomor : <img src="images/no-penjaminan.png" style="padding-left:10px;" />tanggal 4 Februari 2013 dan tidak dapat dipindahtangankan atau dijadikan jaminan kepada pihak lain.</p>
                            <p>Mataram, {{ $direksi->tgl_indo($sp3kbg->tgl_cetak) }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr align="left" valign="top">
                                    <td width="45%" height="150px">
                                        <div class="relative">
                                            <strong>PT. JAMKRIDA NTB BERSAING</strong>
                                            <div class="signed-image" >
                                                <br> 
                                                @if($sppsb->url_ttd!=null) 
                                               <img src= "data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(160)->merge('img/jamkrida.png', 0.35, true)->generate('https://penjaminan.jamkridantb.com/verifikasi-doc-sertifikat-surety/'.$direksi->enkripsi($sppsb->id)))}} ">
                                              <!--  <img src="img/direksi/{{$sppsb->url_ttd}}" class="img-responsive" width='65%' >-->
                                                @endif 
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <div id="footer">
<!--                              <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr align="left" style="text-transform:uppercase">
                                       <td width="45%"><span style="font-weight:bold;border-bottom:1px solid #000;padding:0 5px;">{{ strtoupper(Auth::user()->name) }}</span></td>
                                    </tr>
                                    <tr align="left">
                                       <td>{{ Auth::user()->jabatan}}</td>
                                    </tr>
                                </table> -->
                                <table style="margin-left:-20px" width="100%" cellpadding="0" cellspacing="0">
                                    <tr align="center" style="text-transform:uppercase"> 
                                        @if($sppsb->digitalSign!=1 )
                                             <td width="45%"><span style="font-weight:bold;border-bottom:1px solid #000;padding:0 5px;">{{ strtoupper(Auth::user()->name) }}</span></td>
                                        @else
                                             <td width="45%"><span style="font-weight:bold;border-bottom:1px solid #000;padding:0 5px;">{{ strtoupper($sppsb->usr_ttd) }}</span></td>
                                        @endif  
                                    </tr> 
                                    <tr align="center"> 
                                        @if($sppsb->digitalSign!=1 )
                                            <td>{{ Auth::user()->jabatan}}</td>
                                        @else
                                             <td>{{ $sppsb->usr_jabatan}}</td> 
                                        @endif
                                    </tr>
                                </table>
                                
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