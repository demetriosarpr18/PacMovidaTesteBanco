 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<style>
	div.pac-container
	{
		z-index: 1050;
	}

	#mapAlterarLoja, #mapAdicionarLojaDevolucaoAlter
	{
		width: 870px;
		height: 300px; 
		margin-top: 2%;
	}
</style>


<div class="modal fade" id="alterarLoja">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<div class="modal-header">
				<h1 class="modal-title">Alteração de Loja</h1>
			</div>

			<form action="lojas.php" method="POST">

				<div class="modal-body">

					<div class="alert alert-danger" id="erroNaoLojaExisteAlter">
						<strong>A loja digitada não existe!</strong> Digite uma loja valida!
					</div>

					<label>Digite o nome da loja para alterar</label>
					<input type="text" name="campo_loja_alterar" id="campo_loja_alterarID" class="form-control" list="filtoLojasAlter"/>

					<datalist id="filtoLojasAlter"></datalist>

					<legend id="erro_alterar_loja">Digite uma loja valida para alterar</legend>

					<div id="form_loja_alterar">

						<label for="nomeLojaId">Nome Loja</label><input type="text" class="form-control" name="nome_loja_alterar" id="nomeLoja_alterarId" placeholder="Nome usado para a loja" required>

		 				<label for="enderecoLoja_alterarId">Endereço</label><input type="text" class="form-control" name="endereco_loja_alterar" id="enderecoLoja_alterarId" placeholder="Rua logradouro .." required>

		 				<div id="mapAlterarLoja"></div>

		 				<label for="bairro_alterarId">Bairro</label><input type="text" class="form-control" name="bairro_loja_alterar" placeholder="Parque, Jardim .." id="bairro_alterarId" required><br>

		 				<label class="checkbox-inline"><input type="checkbox" name="endereco_lojaDev_alterar" id="endereco_lojaDev_alterarId">Endereço de devolução diferente</label><br><br>

		 				<div id="campoEnderecoLojaDevolucaoAlterId">
		 					<label for="enderecoLojaDevolucaoAlterId">Endereço de devolução</label><input type="text" class="form-control" name="enderecoLojaDevolucaoAlter" id="enderecoLojaDevolucaoAlterId" placeholder="Rua de devolução ">

		 					<div id="mapAdicionarLojaDevolucaoAlter"></div>

		 					<label for="bairroLojaDevolucaoAlterId">Bairro de devolução</label><input type="text" class="form-control" name="bairroLojaDevolucaoAlter" id="bairroLojaDevolucaoAlterId" placeholder="Bairro de devolução"><br>
		 				</div> 

		 				<label for="horarioLoja_alterarId">Horário de Funcionamento</label><input class="form-control" type="text" name="horario_loja_alterar" placeholder="Segunda a Domingo: 09h00 as 22h00" id="horarioLoja_alterarId" required>

		 				<label for="telefone_alterarId">Telefone</label><input type="text" class="form-control" name="telefone_loja_alterar" data-mask = "(00) 0000-0000" id="telefone_alterarId" placeholder="(00) 00000-0000" required>

		 				<label for="emailLoja_alterarId">Email</label><input type="email" class="form-control" name="email_loja_alterar" id="emailLoja_alterarId" placeholder="exemplo@movida.com.br" required>

		 				<label for="pontoReferencia_alterarId">Ponto de referencia</label><textarea class="form-control" name="pontoReferencia_loja_alterar" placeholder="Perto de algo" id="pontoReferencia_alterarId"></textarea>

		 				<label for="supervisor_alterarId">Supervisor</label><input type="text" class="form-control" name="supervisor_loja_alterar" id="supervisor_alterarId" placeholder="Supervisor resposavel pela loja" required>

		 				<label for="gerente_alterarId">Gerente Reginal</label><input type="text" class="form-control" name="gerente_loja_alterar" id="gerente_alterarId" placeholder="Gerente responsavel pela loja" required>

						<label for="lider_alterarId">Lider</label><input type="text" class="form-control" name="lider_loja_alterar" id="lider_alterarId" placeholder="Lider responsavel pela loja" required>

						<label for="disponibilidade_alterarId">Disponibilidade</label><input type="text" class="form-control" name="disponibilidade_loja_alterar" id="disponibilidade_alterarId" placeholder="Disponibilidade responsavel pela loja" required>

						<input type="hidden" id="latMapAlterarId" name="latMapAlterar">	
						<input type="hidden" id="lngMapAlterarId" name="lngMapAlterar">

						<input type="hidden" name="latMapDevAlterar" id="latMapDevAlterarId">
						<input type="hidden" name="lngMapDevAlterar" id="lngMapDevAlterarId">
					</div>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn secundary" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn secundary" name="ALTERAR" id="btn_alterar_loja">Alterar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script >
	$(document).ready(function(){
		$.ajax({
			type: "POST",
			data: {filtraLoja: ""},
			url: "pegarNomeTodasLojas.php",
			dataType: "json",

			success: function(data)
		    {    				
		    	for(k in data)
		    	{
		    		var option = document.createElement("option");
		    		option.text = data[k]['nome_loja'];
		    		option.value = data[k]['nome_loja'];

		    		var select = document.getElementById("filtoLojasAlter");

		    		select.appendChild(option);
		    	}
			},

			error: function(xhr, desc, err)
			{
				console.log(xhr.responseText);
				console.log("Detalhes:" + desc + "Erro: " + err);
			}
	    });
	});
</script>

<script>
	
	$(document).ready(function(){
		$("#erroNaoLojaExisteAlter").hide();

		$("#form_loja_alterar").hide(500);

		$("#erro_alterar_loja").show(1000);

		google.maps.event.addDomListener(window,'load', function(){
 			var placesAlterar = new google.maps.places.Autocomplete(document.getElementById("enderecoLoja_alterarId"));

 			var placesAlterarDev = new google.maps.places.Autocomplete(document.getElementById("enderecoLojaDevolucaoAlterId"));
 			

 			// Caso o usuário queira mudar o endereço o mapa é atualizado
			google.maps.event.addListener(placesAlterar, 'place_changed', function(){

				placeAlter = placesAlterar.getPlace();

				$("#latMapAlterarId").val(placeAlter.geometry.location.lat());
				$("#lngMapAlterarId").val(placeAlter.geometry.location.lng());

				var andressAlter = placeAlter.formatted_address;

				var enderecoAlterSeparado = andressAlter.split("-");

				var bairroAlterSeparado =  enderecoAlterSeparado[0].split(",");
				console.log(bairroAlterSeparado);
				$("#enderecoLoja_alterarId").val(bairroAlterSeparado[0]);
				$("#bairro_alterarId").val(bairroAlterSeparado[1]);

				var optionsMapAlterar = {
					center: {lat: placeAlter.geometry.location.lat(), lng: placeAlter.geometry.location.lng()},
					MapTypeId: google.maps.MapTypeId.ROADMAP,
					zoom: 18
				}

				var mapAlterarLoja = new google.maps.Map(document.getElementById("mapAlterarLoja"),optionsMapAlterar);

				var mapMaker = new google.maps.Marker({
					position: {lat: placeAlter.geometry.location.lat(), lng: placeAlter.geometry.location.lng()},
					map: mapAlterarLoja
				});
			});

			google.maps.event.addListener(placesAlterarDev,"place_changed", function(){
				var placeDevAlter = placesAlterarDev.getPlace();

				var andressDeAlter = placeDevAlter.formatted_address;

				$("#latMapDevAlterarId").val(placeDevAlter.geometry.location.lat());
				$("#lngMapDevAlterarId").val(placeDevAlter.geometry.location.lng());

				var enderecoDevAlterarSeparado = andressDeAlter.split("-");

				var bairroDevAlterarSeparado = enderecoDevAlterarSeparado[1].split(",");
				console.log(bairroDevAlterarSeparado);

				$("#enderecoLojaDevolucaoAlterId").val(enderecoDevAlterarSeparado[0]);
				$("#bairroLojaDevolucaoAlterId").val(bairroDevAlterarSeparado[0]);

				var optionsMapAlterarDev = {
					center: {lat: placeDevAlter.geometry.location.lat(), lng: placeDevAlter.geometry.location.lng()},
					zoom: 18,
					MapTypeId: google.maps.MapTypeId.ROADMAP
				};
				var mapAlterarLojaDev = new google.maps.Map(document.getElementById("mapAdicionarLojaDevolucaoAlter"), optionsMapAlterarDev);

				var makerAlterMapDev = new google.maps.Marker({
					position: {lat: placeDevAlter.geometry.location.lat(), lng: placeDevAlter.geometry.location.lng()},
					map: mapAlterarLojaDev, 
					draggable: true
				});

				$("#mapAdicionarLojaDevolucaoAlter").css("height", "300");								//Mostra o mapa

				google.maps.event.addListener(makerAlterMapDev, "dragend", function(event){
					$("#latMapDevAlterarId").val(event.latLng.lat());
					$("#lngMapDevAlterarId").val(event.latLng.lng());
				});

			});

 		});

		$("#campo_loja_alterarID").change(function(){

			var barra_alterar_loja = $("#campo_loja_alterarID").val();

			$("#endereco_lojaDev_alterarId").change(function(){										//O checkbox de endereço diferente foi clicado?
				if(document.getElementById("endereco_lojaDev_alterarId").checked)					//O checkbox de endereço em outro local está marcado?
				{
					$("#campoEnderecoLojaDevolucaoAlterId").show(500);								//Mostre o campo de endereço em local diferente
				}
				else if(!(document.getElementById("endereco_lojaDev_alterarId").checked))			//O checkbox de endereço em outro local não está marcado?
				{
					$("#campoEnderecoLojaDevolucaoAlterId").hide(500);								//Esconde o campo de enderço em local diferente
					$("#enderecoLojaDevolucaoAlterId").val("");										//Limpa o campo de endereço de devolução
					$("#mapAdicionarLojaDevolucaoAlter").css("height", "0");						//Esconde o mapa
					$("#bairroLojaDevolucaoAlterId").val("");										//Limpa o campo de bairro de devolução
					$("#latMapDevAlterarId").val(0);												//Zera a latitude de devolução
					$("#lngMapDevAlterarId").val(0);												//Zera  longitude de devolução
				}
			});


			if( $("#campo_loja_alterarID").val() != "")
			{
				$.ajax({
					type: 'GET',
					url: 'pegarDadosLoja.php',
					data: {barraPesquisa: barra_alterar_loja},
					dataType: 'json',

					success: function(response)
					{
						console.log(response);

						if(response == false)
						{
							$("#form_loja_alterar").hide(500);
							$("#erro_alterar_loja").show(1000);
							$("#erroNaoLojaExisteAlter").show(700);
						}
						else if (response != false)
						{
							$("#nomeLoja_alterarId").val(response[0].nome_loja);
							$("#enderecoLoja_alterarId").val(response[0].endereco);
							$("#enderecoLojaDevolucaoAlterId").val(response[0].enderecoDev);
							$("#bairro_alterarId").val(response[0].bairro);
							$("#bairroLojaDevolucaoAlterId").val(response[0].bairroDev);
							$("#horarioLoja_alterarId").val(response[0].horario);
							$("#telefone_alterarId").val(response[0].telefone);
							$("#emailLoja_alterarId").val(response[0].email);
							$("#pontoReferencia_alterarId").val(response[0].referencias);
							$("#supervisor_alterarId").val(response[0].supervisor);
							$("#gerente_alterarId").val(response[0].gerente);
							$("#lider_alterarId").val(response[0].gerente);
							$("#disponibilidade_alterarId").val(response[0].disponibilidade);
							$("#latMapAlterarId").val(response[0].lat);
							$("#latMapDevAlterarId").val(response[0].latDev);
							$("#lngMapAlterarId").val(response[0].lng);
							$("#lngMapDevAlterarId").val(response[0].lngDev);

							// Configurações do mapa
							var latMapAlterar = document.getElementById("latMapAlterarId").value;
							var lngMapAlterar =document.getElementById("lngMapAlterarId").value;

							 var optionsMapAlterar = {
	 							center: {lat: parseFloat(latMapAlterar) ,lng: parseFloat(lngMapAlterar)},
	 							zoom: 18,
	 							mapTypeId: google.maps.MapTypeId.ROADMAP
	 						};

	 						var mapAlterarLoja = new google.maps.Map(document.getElementById("mapAlterarLoja"),optionsMapAlterar);

	 						var makerAlterMap = new google.maps.Marker({
	 							position: {lat: parseFloat(latMapAlterar) ,lng: parseFloat(lngMapAlterar)},
	 							map: mapAlterarLoja,
	 							draggable: true
	 						});



	 						google.maps.event.addListener(makerAlterMap, 'dragend', function(event){
								$("#latMapAlterarId").val(event.latLng.lat());
								$("#lngMapAlterarId").val(event.latLng.lng());
				 			});

				 			$("#erro_alterar_loja").hide(500);
							$("#form_loja_alterar").hide(500);
							$("#form_loja_alterar").show(1000);
							$("#erroNaoLojaExisteAlter").hide(700);
	 						
	 						if(response[0].latDev != 0 && response[0].lngDev != 0)								//Possui loja de devolução diferente?
	 						{
	 							document.getElementById("endereco_lojaDev_alterarId").checked = true;			//Mostra o campo de devolução diferente

	 							var optionsMapAlterarDev = {
	 								center: {lat: parseFloat(response[0].latDev), lng: parseFloat(response[0].lngDev)},
	 								zoom: 18,
	 								MapTypeId: google.maps.MapTypeId.ROADMAP
	 							};

	 							var mapAlterarLojaDev = new google.maps.Map(document.getElementById("mapAdicionarLojaDevolucaoAlter"), optionsMapAlterarDev);

	 							var makerAlterMapDev = new google.maps.Marker({
	 								position: {lat: parseFloat(response[0].latDev), lng: parseFloat(response[0].lngDev)},
	 								map: mapAlterarLojaDev,
	 								draggable: true
	 							});

	 							google.maps.event.addListener(makerAlterMapDev, "dragend", function(event){
									$("#latMapDevAlterarId").val(event.latLng.lat());
									$("#lngMapDevAlterarId").val(event.latLng.lng());
								});

	 							$("#campoEnderecoLojaDevolucaoAlterId").show(500);								//Mostre o campo de endereço em local diferente

	 						}
	 						else if(response[0].latDev == 0 && response[0].lngDev == 0)							//Possui a mesma loja de devolução?
	 						{	
	 							document.getElementById("endereco_lojaDev_alterarId").checked = false;			//Não mostra o campo de devolução diferente
	 							$("#campoEnderecoLojaDevolucaoAlterId").hide(500);								//Mostre o campo de endereço em local diferente
	 						}

	 						if(document.getElementById("endereco_lojaDev_alterarId").checked)					//O checkbox de endereço em outro local está marcado?
							{
								$("#mapAdicionarLojaDevolucaoAlter").css("height", "300");						//Mostra o mapa
							}
							else if(!(document.getElementById("endereco_lojaDev_alterarId").checked))			//O checkbox de endereço em outro local não está marcado?
							{	
								$("#mapAdicionarLojaDevolucaoAlter").css("height", "0");						//Esconde o mapa
							}
						}
					},

					error: function(xhr, desc, err)
					{
						$("#erro_alterar_loja").show(1000);
						$("#form_loja_alterar").hide(500);

						console.log(xhr.responseText);
						console.log("Detalhes: " + desc + "nError:" + err);
					}
				});
			}

			else if($("#campo_loja_alterarID").val() == "")
			{
				$("#erroNaoLojaExisteAlter").hide(700);
				$("#erro_alterar_loja").show(500);
				$("#form_loja_alterar").hide(1000);
			}
		});
	});
</script>