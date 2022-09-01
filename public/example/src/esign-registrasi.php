
<?php

require_once('../../src/esign-cli.php');

$esign = new BSrE_Esign_Cli();

$result = $esign->register(
    $nik = '31102019', 
    $nama = 'user-dev', 
    $email = 'user.dev@bssn.go.id',
    $telp = '1234567890',
    $kota = 'Jakarta',
    $prov = 'DKI Jakarta',
    $nip = '23082019',
    $jabatan = 'Staff',
    $unit = 'BSrE',
    $ktp = '../spesimen/c.png',
    $rekomendasi = '../pdf/example.pdf',
    $visualisasi = '../spesimen/c.png'
);

print_r($result);