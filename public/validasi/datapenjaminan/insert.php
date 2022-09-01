<?php

//insert.php

include('../database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$error = '';
$message = '';
$validation_error = '';
$first_name = '';
$last_name = '';

if ($form_data->action == 'fetch_single_data_penjaminan') {
    $query = "SELECT * from penjaminans where idpenjaminan='" . $form_data->id . "'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output['ktp'] = $row['ktp'];
        $output['nama'] = $row['nama'];
        $output['tgllahir'] = date('d/m/Y', strtotime($row['tgllahir']));
        $output['umur'] = $row['umur'];
        $output['pekerjaan'] = $row['pekerjaan'];
        $output['jeniskredit'] = $row['jeniskredit'];
        $output['alamat'] = $row['alamat'];
        $output['tglrealisasi'] = date('d/m/Y', strtotime($row['tglrealisasi']));
        $output['tgljatuhtempo'] = date('d/m/Y', strtotime($row['tgljatuhtempo']));
        $output['nopk'] = $row['nopk'];
        $output['tglpk'] = date('d/m/Y', strtotime($row['tglpk']));
        $output['plafon'] = $row['plafon'];
        $output['jenispenjaminan'] = $row['jenispenjaminan'];
        $output['tglpengajuan'] = date('d/m/Y', strtotime($row['tglpengajuan']));
        $output['masakredit'] = $row['masakredit'];
        $output['umurjatuhtempo'] = $row['umurjatuhtempo'];
    }
} elseif ($form_data->action == "Delete") {
    $query = "
	DELETE FROM penjaminans WHERE idpenjaminan='" . $form_data->id . "'
	";
    $query1 = "
	DELETE FROM kesehatan WHERE idpenjaminan='" . $form_data->id . "'
	";
    $statement1 = $connect->prepare($query1);
    $statement = $connect->prepare($query);
    
    
    
    if ($statement->execute()||$statement1->execute()) {
         $data = $connect->prepare("SELECT * FROM kesehatan where idpenjaminan='$form_data->id' ");
         $data->execute();
         $tampil = $data->fetch() ;
         $filekesehatan=$tampil['files'];
         unlink('public/files/suratsehat/' .$filekesehatan);         
    }
    
} else {
    if (empty($form_data->idbank)) {
        $error[] = 'Nama Bank is Required';
    } else {
        $id_bank = $form_data->idbank;
    }

    if (empty($form_data->namarate)) {
        $error[] = 'Nama Produk is Required';
    } else {
        $nama_rate = $form_data->namarate;
    }

    if (empty($form_data->dari)) {
        $error[] = 'Dari is Required';
    } else {
        $dari = $form_data->dari;
    }

    if (empty($form_data->sampai)) {
        $error[] = 'Sampai is Required';
    } else {
        $sampai = $form_data->sampai;
    }

    if (empty($form_data->rate)) {
        $error[] = 'Rate is Required';
    } else {
        $rate = $form_data->rate;
    }

    if (empty($error)) {


        if ($form_data->action == 'Insert') {
            $data = array(
                ':id_bank' => $id_bank,
                ':nama_rate' => $nama_rate,
                ':dari' => $dari,
                ':sampai' => $sampai,
                ':rate' => $rate,
            );
            $query = "      INSERT INTO rate 
				(idbank,namarate,dari,sampai,rate) VALUES 
				(:id_bank,:nama_rate,:dari,:sampai,:rate)
			";
            $statement = $connect->prepare($query);
            if ($statement->execute($data)) {
                $message = 'Data Rate Inserted';
            }
        }
        if ($form_data->action == 'Edit') {

            $data = array(
                ':id_bank' => $id_bank,
                ':nama_rate' => $nama_rate,
                ':dari' => $dari,
                ':sampai' => $sampai,
                ':rate' => $rate,
                ':id' => $form_data->id,
            );
            $query = " UPDATE rate SET idbank=:id_bank,namarate=:nama_rate,dari=:dari,sampai=:sampai,rate=:rate
			WHERE idrate=:id";

            $statement = $connect->prepare($query);
            if ($statement->execute($data)) {
                $message = 'Data Rate Edited';
            } else {
                $message = 'Gagal';
            }
        }
    } else {
        $validation_error = implode(", ", $error);
    }

    $output = array(
        'error' => $validation_error,
        'message' => $message
    );
}



echo json_encode($output);
?>