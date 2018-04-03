<?php 
	include ('model/ob_lojas.php');
	include ('conexaoBanco.php');

	$ob_lojas = new OB_LOJAS;

	if(isset($_POST['SALVAR']))
	{
		$ob_lojas->nomeLoja = $ob_lojas->FillData("nomeLoja", '');
		$ob_lojas->endereco = $ob_lojas->FillData("enderecoLoja", '');
		$ob_lojas->enderecoDev = $ob_lojas->FillData("enderecoLojaDevolucao", '');
		$ob_lojas->bairro = $ob_lojas->FillData("bairroLoja", '');
		$ob_lojas->bairroDev = $ob_lojas->FillData("bairroLojaDevolucao", '');
		$ob_lojas->horarioFuncionamento = $ob_lojas->FillData("horarioLoja" ,'');
		$ob_lojas->telefone = $ob_lojas->FillData("telefoneLoja",'') ;
		$ob_lojas->emailLoja = $ob_lojas->FillData("emailLoja",'');
		$ob_lojas->pontoReferencia = $ob_lojas->FillData("pontoReferenciaLoja",'');
		$ob_lojas->lat = $ob_lojas->FillData("latitude", '');
		$ob_lojas->lng = $ob_lojas->FillData("longitude", '');
		$ob_lojas->latDev = $ob_lojas->FillData("latitudeDev", '');
		$ob_lojas->lngDev = $ob_lojas->FillData("longitudeDev", '');
		$ob_lojas->supervisor = $ob_lojas->FillData("supervisorLoja",'');
		$ob_lojas->gerente = $ob_lojas->FillData("gerenteLoja",'');
		$ob_lojas->lider = $ob_lojas->FillData("liderLoja",'');
		$ob_lojas->disponibilidade = $ob_lojas->FillData("disponibilidadeLoja",'');

		if(!$ob_lojas->save())
		{	
			echo $ob_lojas->msg; 
		}
	}

	if(isset($_POST['DELETAR']))
	{
		$campoLoja = $_POST['lojaDeleta'];
		$ob_lojas->delete($campoLoja);
	}

	if(isset($_POST['ALTERAR']))
	{
		$ob_lojas->nomeLoja = $ob_lojas->FillData("nome_loja_alterar", '');
		$ob_lojas->endereco = $ob_lojas->FillData("endereco_loja_alterar", '');
		$ob_lojas->enderecoDev = $ob_lojas->FillData("enderecoLojaDevolucaoAlter", '');
		$ob_lojas->bairro = $ob_lojas->FillData("bairro_loja_alterar", '');
		$ob_lojas->bairroDev = $ob_lojas->FillData("bairroLojaDevolucaoAlter", '');
		$ob_lojas->horarioFuncionamento = $ob_lojas->FillData("horario_loja_alterar" ,'');
		$ob_lojas->telefone = $ob_lojas->FillData("telefone_loja_alterar",'') ;
		$ob_lojas->emailLoja = $ob_lojas->FillData("email_loja_alterar",'');
		$ob_lojas->pontoReferencia = $ob_lojas->FillData("pontoReferencia_loja_alterar",'');
		$ob_lojas->lat = $ob_lojas->FillData("latMapAlterar", '');
		$ob_lojas->lng = $ob_lojas->FillData("lngMapAlterar", '');
		//Lat e longitude da loja de devolução caso haja
		$ob_lojas->latDev = $ob_lojas->FillData("latMapDevAlterar", '');
		$ob_lojas->lngDev = $ob_lojas->FillData("lngMapDevAlterar", '');

		$ob_lojas->supervisor = $ob_lojas->FillData("supervisor_loja_alterar",'');
		$ob_lojas->gerente = $ob_lojas->FillData("gerente_loja_alterar",'');
		$ob_lojas->lider = $ob_lojas->FillData("lider_loja_alterar",'');
		$ob_lojas->disponibilidade = $ob_lojas->FillData("disponibilidade_loja_alterar",'');

		if(!$ob_lojas->update())
		{
			return false;
		}
	}

	if(isset($_POST['CONSULTAR']))
	{
		$ob_lojas->consult();
	}

	include_once ('views/form_menuPrincipal.php');
?>