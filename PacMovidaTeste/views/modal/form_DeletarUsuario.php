 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<style>
	#resumoDeleteUsuario
	{
		width: 50%;
	}
</style>

<div class="modal fade" id="deletarUsuario">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<!-- Cabeçalho do modal -->
			<div class="modal-header">
				<h1 class="modal-title">Deletar usuário</h1>
			</div>
			<form method="POST" action="usuarios.php">
				<!-- Corpo do modal -->
				<div class="modal-body">

					<div id="msgUsuarioExistenteDel" class="alert alert-danger">
						<strong>O usuário digitado não existe!</strong> Digite um usuário existente!
					</div>

					<label for="usuarioDeleteId">Digite o usuário a ser deletado</label> <input type="text" class="form-control" name="usuarioDelete" id="usuarioDeleteId" placeholder="Login do usuário" list="filtroUsuariosDel" required>

					<datalist id="filtroUsuariosDel"></datalist>

					<legend id="erro">Digite um usuário a ser deletado</legend>
					<div id="resumoDeleteUsuario">
						<!-- Tabela de resumo do delete do usuário -->
						<table>
								<th colspan="2"><h3>Resumo de delete do usuário</h3></th>
								<!-- Campo do nome do usuário -->
								<tr>
									<td colspan="1" valign="top"><label>Nome</label></td>  <td><span class="nome_usuarioID"></span></td>
								</tr>
								<!-- Campo do email do usuário -->
								<tr>
									<td colspan="1" valign="top"><label>Email</label> </td> <td><span class="email_usuarioID"></span></td>
								</tr>
								<!-- Campo de  senha do usuário -->
								<tr>
									<td colspan="1" valign="top"><label>Senha</label></td> <td><span class="senha_usuárioID"></span></td>
			 					</tr>
			 					<!-- Campo se o usuário é administrador -->
			 					<tr>
			 						<td colspan="1" valign="top"><label>Adminstrador</label></td> <td><span class="adminstrador_usuarioID"></span></td>
			 					</tr>
						</table>
					</div>
				<!-- Rodapé -->
					<div class="modal-footer">
						<button type="button" class="btn btn secundary" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn" id="btn_deletar_usuario" name="DELETAR">Deletar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>


<script>
	
	// O erro fica ativo para indicar que não tem nada pree
	$(document).ready(function(){
		$('#usuarioDeleteId').show();
		$('#resumoDeleteUsuario').hide();
		$("#msgUsuarioExistenteDel").hide();
	});
	// Quando o usuário sair do campo
	$('#usuarioDeleteId').change(function()
	{
		if(!($('#usuarioDeleteId').val() == "" || $('#usuarioDeleteId').val() == null))
		{
			$("#resumoDeleteUsuario").hide(1000);
			var barraDeletarUsuario = $('#usuarioDeleteId').val();										//Pega o valor do que foi digitado

			$.ajax({
				type: 'GET',
				url: 'pegarDadosUsuario.php',
				data: {barraPesquisa: barraDeletarUsuario},
				dataType: 'json',

				success: function(response)
				{		
					console.log(response);			
					$('#msgUsuarioExistenteDel').hide(700);
					$('#usuarioDeleteId').show(700);
					$("#resumoDeleteUsuario").hide(700);

					if(response != false)
					{
						
						$('#erro').hide(500);																//Esconde o erro
						$("#msgUsuarioExistenteDel").hide(700);
						$("#resumoDeleteUsuario").show(1000);												//Faz o efeito para mostrar o resumo do delete do usuário
						console.log(response);																//Mostrar no console o retorno do ajax retornado
						$("#erroLojaDelete").hide(500);
	 					$("#resumoDeleteUsuario").show(1000);

						$(".nome_usuarioID").html(response[0].nome_usuario);								//Printa o nome usuário do colaborador retornado
						$(".email_usuarioID").html(response[0].email_usuario);								//Printa o email do usuário retorado
						$(".senha_usuárioID").html(response[0].senha_usuario);								//Printa a senha do usuário retornado

						if(response[0].administrador == 1)													//O usuário é um administrador?			
						{
							$(".adminstrador_usuarioID").html("Administrador");								//Escreve no span que é um adm
						}
						else if(response[0].administrador == 0)												//O usuário é um colaborador normal?
						{
							$(".adminstrador_usuarioID").html("Colaborador");								//Escreve que o usuário é um colaborador
						}
					}
					else if(response == false)
					{
						console.log(response);
						$('#msgUsuarioExistenteDel').show(700);
						$("#resumoDeleteUsuario").hide(700);
						$('#erro').show(500);

					}

				},

            	error: function (xhr, desc, err) {
                /*
                 * Caso haja algum erro na chamada Ajax,
                 * o utilizador é alertado e serão enviados detalhes
                 * para a consola javascript que pode ser visualizada
                 * através das ferramentas de desenvolvedor do browser.
                 */
                	console.warn(xhr.responseText);
                	console.log("Detalhes: " + desc + "nErro:" + err);

					$('#erro').show(500);
					$('#resumoDeleteUsuario').hide(1000);
				}
			});
		}
		else if($('#usuarioDeleteId').val() == "" || $('#usuarioDeleteId').val() == null)
		{
			$('#erro').show(500);
			$('#resumoDeleteUsuario').hide(1000);
			$('#msgUsuarioExistenteDel').hide(700);
		}
	});
</script>


<script>
	$(document).ready(function(){

		$.ajax({
			type: 'POST',
			url: 'pegarNomeTodosUsuarios.php',
			typeType: 'json',

			success: function(response)
			{
				console.log(response);

				var datalist = document.getElementById("filtroUsuariosDel");

				for(var k in response)
				{
					var option = document.createElement("option");

					option.value = response[k]["nome_usuario"];
					option.text = response[k]["nome_usuario"];

					datalist.appendChild(option);
				}

			},
			error: function()
			{
				alert("DEU MERDA");
			}
		});

	});
</script>