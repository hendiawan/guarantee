<?php

//insert.php

include('../database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$error = '';
$message = '';
$validation_error = '';
$first_name = '';
$last_name = '';

if ($form_data->action == 'fetch_single_data_rate') {
    $query = "SELECT * FROM rate inner join banks on rate.idbank=banks.idbank where rate.idrate='" . $form_data->id . "'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        
        $output['idrate']   = $row['idrate'];
        $output['namabank'] = $row['namabank'];
        $output['namarate'] = $row['namarate'];
        $output['idbank']   = $row['idbank'];
        $output['dari']     = $row['dari'];
        $output['sampai']   = $row['sampai'];
        $output['rate']     = $row['rate'];
    }
} elseif ($form_data->action == "Delete") {
    $query = "
	DELETE FROM rate WHERE idrate='" . $form_data->id . "'
	";
    $statement = $connect->prepare($query);
    if ($statement->execute()) {
        $output['message'] = 'Data Rate Deleted';
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
        $dari = $form_data->daribulan;
    }

    if (empty($form_data->sampaibulan)) {
        $error[] = 'Sampai is Required';
    } else {
        $sampai = $form_data->sampaibulan;
    }

    if (empty($form_data->rate)) {
        $error[] = 'Rate is Required';
    } else {
        $rate = $form_data->rate;
    }
    if (empty($form_data->kategori)) {
        $error[] = 'kategori is Required';
    } else {
        $kategori = $form_data->kategori;
    }
    if (empty($form_data->jenis)) {
        $error[] = 'kategori is Required';
    } else {
        $jeniskategori = $form_data->jeniskategori;
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
				(idbank,
                                namarate,
                                dari,
                                sampai,
                                kategori,
                                jensikategori,
                                rate) 
                                
                                VALUES 
                                
				(:id_bank,
                                :nama_rate,
                                :dari,
                                :sampai,
                                :kategori,
                                :jeniskategori,
                                :rate)
			";
            
            $statement = $connect->prepare($query);
            if ($statement->execute($data)) {
                $message = 'Data Rate Inserted';
            }
            
        }
        if ($form_data->action == 'Edit') {
            
            $data=array(
                ':id_bank' => $id_bank,
                ':nama_rate' => $nama_rate,
                ':dari' => $dari,
                ':sampai' => $sampai,
                ':rate' => $rate,
                ':id' => $form_data->id,
            );
            $query = " UPDATE rate SET 
                idbank=:id_bank,
                namarate=:nama_rate,
                dari=:dari,
                sampai=:sampai,
                rate=:rate
                WHERE idrate=:id";

            $statement = $connect->prepare($query);
            if ($statement->execute($data)) {
                $message = 'Data Rate Edited';
            }else{
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