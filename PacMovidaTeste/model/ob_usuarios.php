<?php
	
	//Classe que trata de todas as operações com banco de dados
	class OB_USUARIOS
	{

		public $idUsuario = 0;																		//Indentificador do usuário
		public $nomeUsuario = '';																	//Nome do usuário
		public $emailUsuario = '';																	//Email do usuário
		public $senhaUsuario = '';																	//Senha do usuário
		public $tipoUsuario = true;																	//Tipo usuário (Administrator ou Colaborador)
		public $msg = '';																			//Mensagem para informar o status das ações do usuário																						(Salvo com sucesso, Falha....)
		public $status = null;																		//Status retorno (TRUE - deu certo False - ERRO)


		//Método para verificar se todos os campos foram digitados
		//
		//Parâmetros: nada
		//Entrada: nada
		//Saída: bool TRUE - todas as informações foram preenchidas de forma correta
		//			  FALSE - alguma informações preenchida de forma errada
		function check()
		{
			return true;
		}

		//Método para verificar qual o tipo de solicitação enviada
		//
		//Parâmetros:
		//
		//Entrada: string var - campo preenchido pelo usuário
		//		   String default - caso não tenha achado nenhum tipo de solicitação
		function fillData($var = '', $default = '')
		{		
			if($_SERVER['REQUEST_METHOD'] == 'POST')												//O formulário foi enviado via POST?
			{
				return $_POST[$var];																//retorar post do campo
			}

			return $default;																		//Se não retorna vazio 
		}

		//Função para salvar um novo usuário no banco de dados
		//
		//Parâmetros:
		//
		//Entrada: nada
		//Saída: bool TRUE - inserção do novo usuário OK
		//			  FALSE - erro na inserção do novo usuário
		function save()
		{
			if(!$this->check())																		//Todas as informações foram preenchidas de forma errada?
			{
				return false;																		//Volta informando que houve erro
			}

			$conn = mysqli_connect("localhost", "root", "" , "pac");								//Faz a conexão com o banco de dados pacMovida

			$query = sprintf("insert into usuario values(default, '%s', '%s','%s' ,%d)",			//query para incluir os dados do novo usuário no banco
							$this->nomeUsuario, $this->emailUsuario,
							$this->senhaUsuario,$this->tipoUsuario);

			if($conn->connect_error)																//Falha na conexão do banco de dados?
			{
				$this->status = false;																//Coloca o status que deu erro
				$this->msg = "Erro na conexão com o banco de dados";								//Mostra mensagem de erro para o usuário
				error_log("Conexão falhou: ". $conn->connect_error,0);								//Retorna que deu erro na query
			}

			if(!$conn->query($query))															 	//Erro na query de inserção?
			{
				$this->status = false;																//Coloca o status que deu erro
				$this->msg = "Erro na conexão com o banco de dados";								//Mostra mensagem de erro para o usuário
				error_log("Error ". $query . " " . $conn->error,0);									//Retorna erro na query
			}

			$this->status = true;																	//Coloca o status de retorno como sucesso
			$this->msg = "Usuário salvo com sucesso";												//Informa que o usuário foi salvo para o usuário
			//Todo o processo feita com sucesso
			return true;																			//Retornar que deu tudo certo


		}//save()

		//Metodo para deletar um usuário já existente do banco de dados
		//
		//Parâmetros:
		//
		//Entrada: nada
		//Saída: bool TRUE - delete de um usuário já existente com SUCESSO
		//	  		  FALSE - erro ao tentar deletar o usuário 
		function delete($usuarioDeletar)
		{
			if(!$this->check())																		//Algum campo preenchido de forma errada?
			{
				return false;																		//Retorar que deu algo de errado
			}

			$conn = new mysqli("localhost", "root", "", "pac");										//conecta com o banco de dados local

			if($conn->connect_error)																//Erro na conexão do banco de dados?
			{
				die("Erro na conexão para o delete do usuário " . $conn->connect_error);			//Indica erro na conexão com banco de dados
			}

			$query = sprintf("delete from usuario where nome_usuario='%s'", $usuarioDeletar);		//Monta a query para realizar a exclusão do usuário

			if(!$conn->query($query))																//Query errada?
			{
				return false;																		//Retorna erro na query de exclusão do usuário
			}

			$this->status = true;																	//Coloca o status de retorno como sucesso
			$this->msg = "Usuário deletado com sucesso";											//Informa que o usuário foi deletado para o usuário
			return true;																			//retorna que a exclusão foi feita com sucesso


		}//delete()

		//Método para fazer uma consulta de um usuário em um banco de dados
		//
		//Parâmetros:
		//
		//Entrada: nada
		//Saída: bool TRUE - consulta do usuário feita com sucesso
		//			  FALSE - erro na consulta do usuário
		function consult()
		{

		}//consult()

		//Método para fazer o update em algum dado do usuário no banco de dados
		//
		//Parâmetros:
		//
		//Entrada: nada
		//Saída: bool TRUE - update feito com sucesso
		//			  FALSE - erro em fazer o update do usuário
		function update()
		{
			$conn = new mysqli("localhost", "root", "", "pac");										//Conexão com o banco de dados

			if($conn->connect_error)
			{
				die ("Erro ao tentar se conectar " + $conn->connect_error);							//Mostrar o erro para o usuário
			}

			//Query para realizar as mundanças do usuário
			$query = sprintf("update usuario set nome_usuario = '%s', email_usuario = '%s',			
					 senha_usuario = '%s', administrador = %d where id_usuario = %d",
					 $this->nomeUsuario, $this->emailUsuario, $this->senhaUsuario, $this->tipoUsuario, $this->idUsuario);
			
			if(!$conn->query($query))																//Houve erro na query de alteração de usuário?
			{
				$this->status = false;																//Coloca o status do retorna como erro
				$this->msg = "Erro na alteração do usuário";										//Informa o usuário que deu erro
				error_log("Erro na query: " .$query . "Error: " . $conn->error,0);					//Mostra o erro que deu na query 
				return false;																				
			}
			$this->status = true;																	//Coloca o status de retorno como sucesso
			$this->msg = "Usuário alterado com sucesso";											//Informa que o usuário foi alterado para o usuário
			return true;																			//Retornar que deu tudo certo
		}//update()
	}
?>