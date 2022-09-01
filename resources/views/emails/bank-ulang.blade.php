<p>Dear Staf Penjaminan,</p>
<br>
<br>
<p>Ada pengajuan penjaminan yang dilakukan Pengajuan ulang!!</p>
<p>Silahkan kunjungi url berikut:<br>
<a href="https://penjaminan.jamkridantb.com/belumProsesAll" target="_blank">https://penjaminan.jamkridantb.com/belumProsesAll</a>
</p>
<p>DETAIL PENGAJUAN</p><BR>

<table style="font-size: 11px" class="table table-bordered">
    <thead>
        <tr style="background-color:#23527c ;color: #000000">
            <th>NO REGISTRASI</th>                             
            <th>NAMA BANK</th>
            <th>TERJAMIN</th>
            <th>NO KTP</th>
            <th>NO PK</th>
            <th>TGL PK</th>
            <th>PLAFON</th>
            <th>RATE</th>
            <th>IJP</th>
            <th>REALISASI</th>
            <th>JATUH TEMPO</th>
            <th>JENIS KREDIT</th>
            <th>JENIS PENJAMINAN</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $i = 1; ?>
        @foreach($data as $datas)
        <tr style="background-color:#bdbdbd ;color: #000000">  
            <td>{{$datas->nosertifikat}}</td>                           
            <td>{{$datas->namabank}}</td>
            <td>{{$datas->nama}}</td>
            <td>{{$datas->ktp}}</td>
            <td>{{$datas->nopk}}</td>
            <td>{{$datas->tglpk}}</td>
            <td>{{number_format( $datas -> plafon, 0, ',', '.')}}</td>
            <td>{{$datas->rate}}</td>
            <td>{{number_format( $datas -> premi, 0, ',', '.')}}</td>
            <td>{{$datas->tglrealisasi}}</td>
            <td>{{$datas->tgljatuhtempo}}</td>
            <td>{{$datas->jeniskredit}}</td>
            <td>{{$datas->jenispenjaminan}}</td>
        </tr>
        <?php $i++; ?>
        @endforeach
    </tbody>
</table>    

<br>
<p>Atas Perhatiannya Kami Ucapkan Terima Kasih</p>
<p>Salam</p>
<p>{{$data[0]['namabank']}}</p>
<p>{{$data[0]['pemohon']}}</p>