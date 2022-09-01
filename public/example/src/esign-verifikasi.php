<?php

require_once('../../src/esign-cli.php');

$esign = new BSrE_Esign_Cli();

$hasil = $esign->verifikasi('../pdf/example_signed.pdf');

if(!$hasil) echo $esign->getError();
else 
    echo "<pre>";
    print_r($hasil);
    echo"</pre>";