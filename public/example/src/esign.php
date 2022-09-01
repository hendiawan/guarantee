<?php

require_once('../../src/esign-cli.php');


$esign = new BSrE_Esign_Cli();

$esign->setDocument('../pdf/example.pdf');

$esign->setDirOutput('/output', true);

//$esign->setSuffixFileName('');

$esign->setAppearance(
    $x = 43,
    $y = 28,
    $width = 550,
    $height = 130,
    $page = 1,
    $spesimen = '../spesimen/c.png',
    $qr = null
);

$hasil = $esign->sign(
    '30122019',   //nik
    '12345678'    //passphrase
);

if(!$hasil) echo $esign->getError();
else 'Proses tanda tangan berhasil';