<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<div class="modal fade" id="adicionarUsuario">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<div class="modal-header">
				<h1 class="modal-title">Adicionar novo usuário</h1>
			</div>

			<div class="modal-body">
				<form id="form_adicionar_usuario" method="post" action="usuarios.php">

					<div id="msgUsuarioExistenteAdd" class="alert alert-danger">
						<strong>O usuário digitado já existe!</strong> Escolha outro nome!
					</div>

					<!-- Área de Nome e sobrenome -->
					<label for="nomeUsuarioId">Nome usuário</label> <input type="text" class="form-control" id="nomeUsuarioId" name="nomeUsuario" placeholder="Nome e sobrenome" required list="filtroUsuarioAdd">

					<legend id="preenchaLoja">Preencha com nome de um novo usuário</legend>

					<datalist id="filtroUsuarioAdd"></datalist>
					<div id="corpoFormAddUsuario">
						<!--área de email -->
						<label for="emailUsuarioId">Email</label><input type="email" class="form-control" id="emailUsuarioId" name="emailUsuario" placeholder="Email corporativo" required>

						<!-- Area de senha -->
						<label for="senhaUsuarioId">Senha</label> <input type="password" class="form-control" name="senhaUsuario" id="senhaUsuarioId" placeholder="Senha para login" required>

						<!--Caixa de radio para verificar se é um super usuário -->
						<fieldset>
							<legend>Tipo de usuário</legend>
							<input type="radio" name="tipoUsuario" id="admininistradorUsuarioId" value= "1" checked> <label for="administradorUsuarioId">Administrador</label> 
							<input type="radio" name="tipoUsuario" id="colaboradorUsuarioId" value="0"><label for="colaboradorUsuarioId">Colaborador</label> 
						</fieldset>



						<div class="modal-footer">
							<button type="button" class="btn btn secundary" data-dismiss="modal">Cancelar</button>
							<button type="submit" class="btn" name="SALVAR" id="adicionarUsuario">Adicionar</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<script>
	
	$(document).ready(function(){

		$("#corpoFormAddUsuario").hide();
		$("#msgUsuarioExistenteAdd").hide();

		$("#nomeUsuarioId").change(function(){
			var barra_usuario_add = $("#nomeUsuarioId").val();

			$.ajax({
				type: "GET",
				data:{barraPesquisa: barra_usuario_add},
				url: "pegarDadosUsuario.php",
				dataType: "json",

				success: function(response)
				{
					if(Array.isArray(response))
					{
						if((barra_usuario_add == "") || (barra_usuario_add ==  null))
						{
							$("#filtroUsuarioAdd").hide(700);
						}
						$("#corpoFormAddUsuario").hide(700);
						$("#msgUsuarioExistenteAdd").show(700);
					}
					else
					{
						console.log(barra_usuario_add);
						if((barra_usuario_add == "") || (barra_usuario_add ==  null))
						{
							$("#corpoFormAddUsuario").hide(700);
							$("#msgUsuarioExistenteAdd").hide(700);
						}
						else if((barra_usuario_add != "") || (barra_usuario_add !=  null))
						{
							$("#msgUsuarioExistenteAdd").hide(700);
							$("#corpoFormAddUsuario").show(700);
						}

					}
				},
				error: function(xhr, desc, err)
				{
					$("#erro_alterar").show(500);
					$("#form_Alterar").hide(1000);
					console.warn(xhr.responseText);
					console.log("Detalhes: " + desc + "nErro: " + err);
				}
			});
		});


		$.ajax({
			type: 'POST',
			url: 'pegarNomeTodosUsuarios.php',
			typeType: 'json',

			success: function(response)
			{
				console.log(response);

				var datalist = document.getElementById("filtroUsuarioAdd");

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