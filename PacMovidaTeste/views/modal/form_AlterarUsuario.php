 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<div class="modal fade" id="alterarUsuario">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<div class="modal-header">
				<h1 class="modal-title">Alterar Usuário</h1>
			</div>

			<form action="usuarios.php" method="POST">
				<div class="modal-body">

					<div id="msgUsuarioExistenteAlter" class="alert alert-danger">
						<strong>O usuário digitado não existe!</strong> Digite um usuário existente!
					</div>

					<label>Digite o usuário a ser alterado</label>
				<input type="text" name="pesquisa_usuario_alterar" id="pesquisa_usuario_alterarID" class="form-control" list="filtroUsuariosAlter">
					<datalist id="filtroUsuariosAlter"> </datalist>

					<legend id="erro_alterar">Digite o nome do usuário para alteração</legend>

					<div id="form_Alterar">

						<input type="hidden" name="id_usuario_alterar" id="id_usuario_alterarID">

						<label>Nome do usuário</label><input type="text" class="form-control" id="nome_usuario_alterarID" name="nome_usuario_alterar">

						<label>Email do usuário</label> <input type="text" class="form-control" id="email_usuario_alterarID" name="email_usuario_alterar">

						<label>Senha do usuário</label><input type="text" class="form-control" id="senha_usuario_alterarID" name="senha_usuario_alterar">

						<legend>Tipo de usuário</legend>
						<input type="radio" id="usuario_tipo_administrador" name="tipo_login_alterar" value="1"><span>Administrador</span> &nbsp &nbsp<input type="radio" name="tipo_login_alterar" id="usuario_tipo_colaborador" value="0"><span>Colaborador</span>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn secundary" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn secundary" name="ALTERAR">Alterar</button>
				</div>

			</form>
		</div>
	</div>
</div>


<script>
	$(document).ready(function(){
		$("#form_Alterar").hide();
		$("#erro_alterar").show();
		$("#msgUsuarioExistenteAlter").hide(700);

		$("#pesquisa_usuario_alterarID").change(function(){

			var barra_alterar_usuario = $("#pesquisa_usuario_alterarID").val();

			if(($("#pesquisa_usuario_alterarID").val() != "") && ($("#pesquisa_usuario_alterarID").val() != null))
			{
				$.ajax({
					type: 'GET',
					url: 'pegarDadosUsuario.php',
					data: {barraPesquisa: barra_alterar_usuario},
					dataType: 'json',

					success: function(response)
					{
						if(barra_alterar_usuario != null || barra_alterar_usuario != "")
						{
							if(response != false)
							{
								console.log(response);
								$("#erro_alterar").hide(1000);
								$("#form_Alterar").hide(1000);
								$("#form_Alterar").show(500);
								$("#msgUsuarioExistenteAlter").hide(700);
								$("#id_usuario_alterarID").val(response[0].id_usuario);
								$("#nome_usuario_alterarID").val(response[0].nome_usuario);
								$("#email_usuario_alterarID").val(response[0].email_usuario);
								$("#senha_usuario_alterarID").val(response[0].senha_usuario);

								if(response[0].administrador == 0)				
								{
									$("#usuario_tipo_colaborador").attr('checked', true);
								}
								else if(response[0].administrador == 1)
								{
									$("#usuario_tipo_administrador").attr('checked', true);
								}
							}
							else if(response == false)
							{
								$("#msgUsuarioExistenteAlter").show(700);
								$("#erro_alterar").show(500);
								$("#form_Alterar").hide(1000);
							}
						}	
						else if(barra_alterar_usuario == null || barra_alterar_usuario == "")
						{
							$("#form_Alterar").hide(700);
							$("#erro_alterar").show(700);
							$("#msgUsuarioExistenteAlter").hide(700);
						}
					},
					error: function(xhr, desc, err)
					{
						console.warn(xhr.responseText);
						console.log("Detalhes: " + desc + "nErro: " + err);
					}
				});
			}
			else{
				$("#form_Alterar").hide(700);
				$("#erro_alterar").show(700);
				$("#msgUsuarioExistenteAlter").hide(700);
			}
		});
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

				var datalist = document.getElementById("filtroUsuariosAlter");

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
