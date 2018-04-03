<?php 
	include ('model/ob_lojas.php');
	include ('conexaoBanco.php');
	
	$ob_lojas = new OB_LOJAS;

	if(isset($_POST['SALVAR']))
	{
		$ob_lojas->nomeLoja = $ob_lojas->FillData("nomeLoja", '');
		$ob_lojas->endereco = $ob_lojas->FillData("enderecoLoja", '');
		$ob_lojas->bairro = $ob_lojas->FillData("bairroLoja", '');
		$ob_lojas->horarioFuncionamento = $ob_lojas->FillData("horarioLoja" ,'');
		$ob_lojas->telefone = $ob_lojas->FillData("telefoneLoja",'') ;
		$ob_lojas->emailLoja = $ob_lojas->FillData("emailLoja",'');
		$ob_lojas->pontoReferencia = $ob_lojas->FillData("pontoReferenciaLoja",'');
		$ob_lojas->supervisor = $ob_lojas->FillData("supervisorLoja",'');
		$ob_lojas->gerente = $ob_lojas->FillData("gerenteLoja",'');
		$ob_lojas->lider = $ob_lojas->FillData("liderLoja",'');
		$ob_lojas->disponibilidade = $ob_lojas->FillData("disponibilidadeLoja",'');

		if(!$ob_lojas->save())
		{	
			echo $ob_loja->msg; 
		}
	}

	if(isset($_POST['DELETAR']))
	{
		$campoLoja = $_POST['lojaDeleta'];
		$ob_lojas->delete($campoLoja);
	}

	if(isset($_POST['ALTERAR']))
	{
		$ob_lojas->nomeLoja = $ob_lojas->FillData("nomeLoja", '');
		$ob_lojas->endereco = $ob_lojas->FillData("enderecoLoja", '');
		$ob_lojas->bairro = $ob_lojas->FillData("bairroLoja", '');
		$ob_lojas->horarioFuncionamento = $ob_lojas->FillData("horarioLoja" ,'');
		$ob_lojas->telefone = $ob_lojas->FillData("telefoneLoja",'') ;
		$ob_lojas->emailLoja = $ob_lojas->FillData("emailLoja",'');
		$ob_lojas->pontoReferencia = $ob_lojas->FillData("pontoReferenciaLoja",'');
		$ob_lojas->supervisor = $ob_lojas->FillData("supervisorLoja",'');
		$ob_lojas->gerente = $ob_lojas->FillData("gerenteLoja",'');
		$ob_lojas->lider = $ob_lojas->FillData("liderLoja",'');
		$ob_lojas->disponibilidade = $ob_lojas->FillData("disponibilidadeLoja",'');

		if(!$ob_loja->update())
		{
			return true;
		}
	}

	include_once ('views/form_menuPrincipal.php');
?>
