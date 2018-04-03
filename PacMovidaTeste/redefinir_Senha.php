<?php
	
	if(isset($_POST))																			//Há alguma requisição POST?
	{
		$emailEsqueci = $_POST['emailEsqueciSenha'];											//Se houver, armazenar o valor preenchido na caixa do email
		if(!empty($emailEsqueci))																//Usuário deixou em branco o campo de email?
		{	
			echo false;																			//Retornar que deu erro
		}

		$conn = new mysqli("localhost", "root", "", "pac");										//Conecta no banco de dados

		if($conn->connect_error)																//Problema na conexão?
		{
			die("Problema na conexão com o banco de dados " . $conn->connect_error);			//Expoe o erro ao usuário
		}

		$query = sprintf("select email_usuario from usuario where email_usuario = '%s'", $emailEsqueci);	 	//Query para buscar se o email existe no banco de dados

		if(!$conn->query($query))																//Deu erro na query de busca?
		{
			echo ("Query:" . $query . "<br>Erro: " . $conn->error);								//Mostra para o usuário o erro que deu
		}

		$result = $conn->query($query);															//Faz a query para buscar se há email cadastrado

		if($result->num_rows > 0)																//Houve resultados voltados, ou seja email existe??
		{	


			header("Location: views/form_login.php?erroEmailEsqueci=false");
		}

		else if($result->num_rows == 0)
		{
			header("Location: views/form_login.php?erroEmailEsqueci=true");
		}

	}

?>