<?php 

	header("Content-type: application/json");
	if(isset($_POST))
	{
		$conn = new mysqli("localhost", "root", "", "pac");

		if($conn->connect_error)
		{
			die("Erro na conexão.Erro " . $conn->connect_error);
		}

		$query = "select nome_usuario from usuario";

		if(!$conn->query($query))
		{
			die("Erro na query: " .$query . "Erro: " . $conn->error);
		}

		$result = $conn->query($query);

		$todosUsuarios = array();

		while($row = $result->fetch_assoc())
		{
			array_push($todosUsuarios, $row);
		}
		echo json_encode($todosUsuarios);
	}
?>