<?php

require_once('../../src/esign-cli.php');

$esign = new BSrE_Esign_Cli();

$status = $esign->checkStatus('30122019'); //nik

if(!$status) echo $esign->getError();
else echo $status;