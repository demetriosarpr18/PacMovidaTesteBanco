<?php 
	header("Content-Type: application/json");
	if(isset($_POST))
	{
		$loja = $_POST['filtraLoja'];
		
		$conn = new mysqli("localhost", "root", "", "pac");

		if($conn->connect_error)
		{
			die("Conexão com o banco falhou: " . $conn->connect_error);
		}

		$query = sprintf("select nome_loja from loja", $loja);
		if(!$conn->query($query))
		{
			die("Erro na query: ". $query . ".Erro: ".$conn->error);	
		}	

		$result = $conn->query($query);

		$todasLojas = array();

		while($row = $result->fetch_assoc())
		{

			array_push($todasLojas, $row);
		}
		echo json_encode($todasLojas);
	}else
	{
		echo ("MERDA");
	}
?>