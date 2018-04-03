<?php
	header("Content-Type: application/json");														//Header para indicar que o arquivo retorna um json
	$infoUsuario = array();																			//Cria um array para colocar os dados do usuário

	if(isset($_GET))																				//existe alguma requisição GET?
	{
		$barraPesquisaUsuario =  $_GET['barraPesquisa'];											//pegar o valor existente e armazenar na barraPesquisaUsuario
	}


	$conn = new mysqli("localhost", "root", "", "pac");												//faz a conexão com o banco pac

	if($conn->connect_error)																		//Erro ao tenta se conectar com o banco de dados
	{
		die("Erro ao tentar se conectar com o banco de dados " . $conn->connect_error);
	}
	
	$query = sprintf("select * from usuario where nome_usuario = '%s'", $barraPesquisaUsuario);		//query para buscar o usuário

	$resultUsuario = $conn->query($query);															//pega os resultados da query e atribui na variavel

	if($resultUsuario->num_rows > 0)																//Tem resultados retornados da query?
	{
		while($rowUsuario = $resultUsuario->fetch_assoc())											//atribui para a rowUsuario o valor de cada coluna
		{
			array_push($infoUsuario, $rowUsuario);													//Aloca cada valor da coluna retornado no array $infoUsuario
			echo json_encode($infoUsuario);															//retorna o array com os dados da colunas retornadas
		}
	}
	elseif ($resultUsuario->num_rows == 0) 															//Não houve retorno da query de busca do usuário?
	{															
		echo json_encode(false);																							//Informa que usuário digitado está cadastrado
	}
?>