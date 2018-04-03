<?php 
	CLASS OB_LOJAS
	{	
		// Declarando os atributos do objeto
		public $lojaId = '';																	//Número indetificador da loja
		public $nomeLoja = '';																	//Nome da loja 
		public $endereco = '';																	//Endereço em que a loja está
		public $enderecoDev = '';																//Endereço caso a devolução seja diferente da retirada
		public $bairro = '';																	//armazana o bairro da loja
		public $bairroDev = '';																	//bairro caso da devolução seja diferente da retirada
		public $horarioFuncionamento = '';														//Horário que a loja está aberta
		public $telefone = '';																	//Telefone da loja
		public $emailLoja = '';																	//Email da loja
		public $pontoReferencia = '';															//Lugares perto da loja
		public $lat;																			//Latitude da loja
		public $lng;																			//Longitude da loja
		public $latDev;																			//Latitude caso a localidade de devolução seja diferente
		public $lngDev;																			//Longitude caso a localidade da devoluçõa seja																									//diferente

		public $supervisor = '';																//Supervisor respónsavel pela loja
		public $gerente = '';																	//Gerente respónsavel pela loja
		public $lider = '';																		//Líder também respónsavel pela loja
		public $disponibilidade = '';															//Número do respónsavel pelas quantidade de veiculos da loja
		public $msg = '';																		//Mesangem de Erro ou Sucesso de uma ação (SAVE, DELETE, 																							  UPDATE, CONSULT)
		public $status = null;																	//Status da ação do usuário (TRUE= SUCESSO e FALSE=ERRO)


		//Método que verifica se todos os campos foram preenchidos corretamente do formulário
		//
		//Parâmentros:
		//
		//Entrada: nenhuma
		//SAÍDA: bool TRUE - todos os campos preenchidos corretamente
		//			  FALSE - algum campo preenchido errado
		function Check()																		
		{
			return true;
		}

		function FillData($var = '', $default = '')
		{
			if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				return $_POST[$var];
			}

			return $default;
		}

		//Salva uma nova loja no banco de dados
		//
		//Parâmentros:
		//
		//Entrada: nenhuma
		//Saída: TRUE - Dados inseridos com sucesso no banco de dados
		//		 FALSE - Erro na inserção da loja nos banco de dados
		function save()
		{	
			if(!$this->Check())																	//campos não completos?
			{
				return false;																	//retorna que algum campo não foi preenchido corretamento
			}

			$conn = new mysqli("localhost", "root", "", "pac");									//conecta com o banco de dados

			if($conn->connect_error)															//Conexão falhou?
			{
				die("Conexão falhou ". $conn->connect_error);
			}

			//query para inserir uma nova loja no banco de dados
			$query = sprintf("insert into loja values (default, '%s', '%s','%s', '%s','%s', '%s', '%s', '%s' ,'%s','%s', '%s',%f,%f, '%s', '%s','%s', '%s')",
							  $this->nomeLoja, $this->endereco, $this->enderecoDev, $this->bairro, $this->bairroDev,
							  $this->horarioFuncionamento, $this->telefone, $this->emailLoja, 
							  $this->pontoReferencia, $this->lat, $this->lng,
							  $this->latDev, $this->lngDev,
							  $this->supervisor, $this->gerente, $this->lider, $this->disponibilidade);

			if(!$conn->query($query))															//Inserção feita com sucesso?
			{																					//Se a inserção não houve sucesso ele volta erro
				$this->status = false;															//Fica o status como erro
				$this->msg = "Erro na conexão com o banco de dados";							//Explica o erro para o usuário
				echo("Error: " . $query . "<br>" . $conn->error);
				return false;																	//retorna que deu algum tipo de erro
			}
			$this->status = true;
			$this->msg = "Loja inserida com sucesso";											//Informa que a loja foi inserida com sucesso para o usuário
			return true;																		//retorna tudo ok							

		}//save()

		//Deleta uma loja do banco de dados
		//
		//Parâmetros:
		//
		//Entrada: string $nomeLoja - variavel que recebe o que foi escrito no caixa de texto do modal de deleção 
		//Saída: TRUE - Dados deletados com sucesso no banco de dados
		//		 FALSE - Erro na deleção da loja nos banco de dados
		function delete($nomeLoja)
		{
			if(!$this->Check())																	//campos não completos?
			{
				return false;																	//retorna que algum campo não foi preenchido corretamento
			}

			$conn = mysqli_connect("localhost", "root", "", "pac");								//conecta ao banco de dados

			if($conn->connect_error)															//Erro na conexão do banco de dados?
			{
				die("Conexão falhou " . $conn->connect_error);									//Fecha a conexão e mostra a mensagem de erro
				return false;																	//Retorna erro
			}
			
			$query = sprintf("delete from loja where nome_loja='%s'",$nomeLoja);				//query para excluir uma loja já existente

			if(!$conn->query($query))															//Erro na execução do delete do banco de dados?
			{
				$this->status = false;															//Deixa o status como erro
				$this->msg = "Houve um erro na execução do delete";								//Mostra a mensagem de erro de deleção
				return false;																	//Retorna que deu um erro
			}
			//Se não houve erro
			$this->status = true;																//Deixa o status como sucesso
			$this->msg = "Loja deletada feito com sucesso";										//Mostra a mensagem de deleção feita com sucesso
			return true;																		//Retorna que a deleção foi feita com sucesso

		}//delete()


		//Faz alguma alteração dos dados de uma loja já existente no banco de dados
		//
		//Parâmetros:
		//
		//Entrada: nenhuma
		//Saída: TRUE - Alteração de dados da loja feita com sucesso
		//		 FALSE - Erro na alteração dos dados dados da loja
		function update()
		{
			if(!$this->Check())
			{
				return false;																	//retorna que deu erro
			}

			$conn = new mysqli("localhost", "root" , "", "pac");								//Fazendo a conexão com o banco de dados

			if($conn->connect_error)															//Erro ao tentar se conectar ao banco de dados?
			{
				die("Conexão falhou " . $conn->connect_error);									//Fecha conexão e coloca o motivo do erro
			}



			//Query para fazer o update do usuário
			$query = sprintf("update loja set nome_loja = '%s', endereco = '%s',enderecoDev='%s' ,
							  bairro = '%s', bairroDev='%s',horario='%s', telefone='%s', email='%s', 
							  referencias='%s',lat=%f, lng=%f, latDev=%f, lngDev=%f,
							  supervisor='%s', gerente='%s', lider='%s', disponibilidade='%s'
							  where nome_loja = '%s';",
							$this->nomeLoja, $this->endereco, $this->enderecoDev, 
							$this->bairro, $this->bairroDev,$this->horarioFuncionamento, $this->telefone, $this->emailLoja, 
							$this->pontoReferencia, $this->lat, $this->lng, $this->latDev, $this->lngDev,
							$this->supervisor, $this->gerente, $this->lider, $this->disponibilidade,
							$this->nomeLoja);

			if(!$conn->query($query))															//Erro na execução da query?
			{
				$this->status = false;															//Fica o status como erro
				error_log("Query: " . $query . "<br>Erro: " . $conn->error);					//Exibe a mensagem para o usuário do erro
				return false;																	//retorna que deu um erro
			}
			$this->status = true;																//Fica o status como sucesso
			$this->msg = "Alteração da loja feita com sucesso";											//exibe a mensagem de sucesso para o usuário
			return true;																		//retorna que alteração foi feita com sucesso
		}//update


		//Faz uma consulta de uma loja no banco de dados
		//
		//Parâmetros:
		//
		//Entrada: nenhuma
		//Saída: TRUE - Consulta de dados da loja feita com sucesso
		//		 FALSE - Erro na consulta dos dados dados da loja
		function consult()
		{
			$conn = mysqli_connect("localhost", "root", "", "pac");								//Faz a conexão com o banco de dados

			$query = sprintf("select nome_loja from loja where 1");												//Executa a query de consulta 

			
			if($conn->connect_error)															//Erro na conexão com o banco de dados?
			{
				error_log("Conexão falhou ". $conn->connect_error);								//Fecha a conexão
				$this->status = false;															//Fica o status como erro
				$this->msg = "Erro na conexão com banco de dados";								//Mostra a mensagem de erro na conexão
				return false;																	//Retorna que deu problema na conexão
			}

			$resultado = mysqli_query($conn, $query);
			$resultadoLinhas = mysqli_num_rows($resultado);

			if($resultadoLinhas <= 0)															//loja não existe?
			{
				$this->status = false;															//Fica o status como erro
				$this->msg = "Loja não existe";													//mostra a mensagem que a loja não existe
				return false;																	//retorna que não retornou nenhuma loja
			}

			if(!$conn->query($query))															//Erro na consulta ao banco de dados?
			{	
				$this->status = false;															//Fica o status como erro
				$this->msg = "Houve um erro na execução do select";								//Exibe a mensagem de erro na query
				return false;																	//Retorna que houve erro
			}

			while($row = $resultado->fetch_assoc())
			{
				$todasLojas = array();

				array_push($todasLojas, $row["nome_loja"]);
			}

			$this->status = true;																//Fica o status como sucesso
			$this->msg = "Loja carregada com sucesso";											//Exibe mensagem de consulta feita com sucesso
		    return $todasLojas;																	//Retorna que deu tudo certo
																	
		}//consult()

		function listarLojas()
		{

		}

	}//class	
?>
