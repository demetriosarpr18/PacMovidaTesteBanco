<?php
	include('model/ob_usuarios.php');													//inclui a classe dos usuários

	$ob_usuarios = new OB_USUARIOS;														//Instancia um nome usuário

	if(isset($_POST['SALVAR']))															//Usuário está inserindo um novo usuário?
	{	
		$ob_usuarios->nomeUsuario = $ob_usuarios->FillData("nomeUsuario", "");			//Preenche o nome do usuário
		$ob_usuarios->emailUsuario = $ob_usuarios->FillData("emailUsuario");			//Preenche o email do usuário
		$ob_usuarios->senhaUsuario = $ob_usuarios->FillData("senhaUsuario");			//Preencge a senha do usuário
		$ob_usuarios->tipoUsuario = $ob_usuarios->FillData("tipoUsuario");				//Preenche o tipo do usuário (Administrador = 1 / Colaborador = 0) 
		if(!$ob_usuarios->check())														//Todos os campos foram preenchidos corretamente?
		{
			return false;																//Retornar que deu erro	
		}

		if(!$ob_usuarios->save())														//Erro ao tentar salvar usuário?
		{
			return false;																//Retornar que deu erro ao tentar salvar o usuário
		}
	}

	if(isset($_POST['DELETAR']))
	{
		$ob_usuarios->nomeUsuario = $ob_usuarios->FillData("usuarioDelete");
		if(!$ob_usuarios->delete($ob_usuarios->nomeUsuario))							//Delete deu errado?
		{
			return false;																//Retorna que deu algo de errado na exclusão do usuário
		}
	}


	if(isset($_POST['ALTERAR']))														//Recebeu uma alteração
	{
		$ob_usuarios->idUsuario = $ob_usuarios->FillData("id_usuario_alterar");			//Preenche o id do usuário		
		$ob_usuarios->nomeUsuario = $ob_usuarios->FillData("nome_usuario_alterar", "");	//Preenche o nome do usuário
		$ob_usuarios->emailUsuario = $ob_usuarios->FillData("email_usuario_alterar");	//Preenche o email do usuário
		$ob_usuarios->senhaUsuario = $ob_usuarios->FillData("senha_usuario_alterar");	//Preencge a senha do usuário
		$ob_usuarios->tipoUsuario = $ob_usuarios->FillData("tipo_login_alterar");		//Preenche o tipo do usuário (Administrador = 1 / Colaborador = 0) 
		if(!$ob_usuarios->update())														//Erro ao realizar o update?
		{
			include_once('views/form_menuPrincipal.php');										//Include o formulário principal
		}
	}
	include_once('views/form_menuPrincipal.php');										//Include o formulário principal
?>	