<?php

//fetch_data.php

include('../database_connection.php');

$query = "SELECT * FROM rate inner join banks on rate.idbank=banks.idbank ORDER BY rate.idrate";
$statement = $connect->prepare($query);
if($statement->execute())
{
	while($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		$data[] = $row;
	}

	echo json_encode($data);
}

?>