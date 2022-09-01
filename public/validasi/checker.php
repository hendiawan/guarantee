
<?php


 
$connect = new PDO("mysql:host=localhost;dbname=penjaminan", "root", "");
function formatUang($uang) {

    return number_format($uang, 0, '.', ',');
}

function AmbilTanggal($tgl) {

    $data = explode("/", $tgl);
    $isi = "$data[2]-$data[1]-$data[0]";
    $tgl = date('Y-m-d', strtotime($isi));

    $tanggal = $tgl . '00:00:00';
    return $ArrayDataTanggal = new DateTime($tanggal);
}

function CekSelisih($tgl, $tgl1) {

    $selisih = $tgl->diff($tgl1);
//gabungkan
    echo $selisih->y . ' Tahun :' . $selisih->m . ' Bulan :' . $selisih->d . ' Hari';
}

function GabungNilai($nilai) {

    $pecah = explode(",", $nilai);
    return implode("", $pecah);
}

if (isset($_POST['tgl'])) {

    $tgl = filter_input(INPUT_POST, 'tgl');
    $tanggalLahir = AmbilTanggal($tgl);
    $TanggalSekarang = new DateTime();
    $selisih = $TanggalSekarang->diff($tanggalLahir);
    
    $data = [
        'Tahun' => $selisih->y, 
        'Bulan' => $selisih->m, 
        'Hari'  => $selisih->d,
     ];
    
    echo json_encode($data);
   
    
} else if (isset($_POST['tempo']) and isset($_POST['lahir'])) {
    
    $idbank             = $_POST['idbank'];
    $tanggalLahir       = $_POST['lahir'];
    $tanggalJatuhTempo  = $_POST['tempo'];
    $tglLahir           = AmbilTanggal($tanggalLahir);
    $tglJatuhTmpo       = AmbilTanggal($tanggalJatuhTempo);
    $selisih            = $tglLahir->diff($tglJatuhTmpo);
    
    $data = $connect->prepare("SELECT * FROM users where idbank='$idbank' ");
    $data->execute();
    $tampil = $data->fetch() ;

    $data = [
        'Tahun' => $selisih->y, 
        'Bulan' => $selisih->m, 
        'Hari'  => $selisih->d,
        'level' => $tampil['level']];
    
    echo json_encode($data);
    
} else if (isset($_POST['plafon'])) {
    $palfon = GabungNilai($_POST['plafon']);
 
    $data=[
       'plafon' =>$palfon,
       'level' =>$_POST['level'],
   ];
   echo json_encode($data);

} else if (isset($_POST['realisasi'])) {

    $tanggalRealisasi = $_POST['realisasi'];
    $tanggalJatuhTempo = $_POST['tempo'];
    $tglRealisasi = AmbilTanggal($tanggalRealisasi);
    $tglJatuhTmpo = AmbilTanggal($tanggalJatuhTempo);
    $selisih = $tglRealisasi->diff($tglJatuhTmpo);
//gabungkan
 
    
     $data = [
        'Tahun' => $selisih->y, 
        'Bulan' => $selisih->m, 
        'Hari'  => $selisih->d,
     ];
    
    echo json_encode($data);

//    $selisihhari = $tglJatuhTmpo->diff($tglRealisasi)->format("%a");
//
//   echo  $selisihhari;



    
} else if (isset($_POST['bulan'])) {

 

    $idbank = $_POST['idbank'];
    $bulan = $_POST['bulan'];
    $jumlahUang = $_POST['plafon'];
    $jeniskredit = $_POST['jeniskredit'];


    $query = "SELECT * FROM rate "
            . " inner join banks on banks.idbank=rate.idbank"
            . " inner join produks on produks.idproduk=rate.idproduk"
            . " where '$bulan'>=rate.dari and '$bulan'<=rate.sampai"
            . " and banks.idbank='$idbank'"
            . " and produks.jeniskategori='$jeniskredit'"
            . "";

    $statement = $connect->prepare($query);

    if ($statement->execute())
    {
        $i = 0;
        echo "<select  required id='jenisPenjaminan' name='jenisPenjaminan' class='form-control'>";
        echo "<option value=''>Pilih Jenis Penjaminan</option>";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) 
        {
            
            $data[] = $row;
            $namarate[] = $data[$i]['namarate'];
            $rate[]  = $data[$i]['rate'];
            $premi[] = GabungNilai($jumlahUang) * ($rate[$i] / 100);
            
            if($premi[$i]<$data[$i]['minijp'])
            {
               $premi[$i]=$data[$i]['minijp'];
            }
            
            $dis[] = $data[$i]['dis'];
            $potongan[] = ($data[$i]['dis'] / 100) * $premi[$i];
            $nett[] = $premi[$i] - $potongan[$i];
            echo"<option value='" . $namarate[$i] . "|" .$rate[$i] . "|" . $dis[$i] . "|" . $potongan[$i] . "|" . $nett[$i] ."|". $premi[$i]. "'>" . $namarate[$i] . " </td>|" . $bulan . " Bln | Rp. " . $jumlahUang . "| RATE :" . $rate[$i] . "%  | IJP : " . formatUang($premi[$i]) . " | DIS : " . $dis[$i] . " % | POT. : " . formatUang($potongan[$i]) . "| NETT: " . formatUang($nett[$i]) . " </option>";
            
            $i++;
        }
        echo "</select>";
    }
    
} else if (isset($_POST['premi'])) {

    include('./database_connection.php');

    $bulan = $_POST['premi'];
    $jumlahUang = $_POST['jumlahUang'];
    $idbank = $_POST['idbank'];

    $query = "SELECT * FROM rate inner join banks on banks.idbank=rate.idbank where '$bulan'>=rate.dari and '$bulan'<=rate.sampai and banks.idbank='$idbank' ";

    $statement = $connect->prepare($query);
 
    
    if ($statement->execute()) {
        $i = 0;
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        echo json_encode($data);
    }
}
?>