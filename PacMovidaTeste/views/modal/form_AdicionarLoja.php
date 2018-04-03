 <style>
 	div.pac-container {
   		z-index: 1050;
}

	#map-adicionar-loja
	{
		width: 870px;
		transition: 0.5s ease-in;
		margin-top: 1%;
	}

	#mapAdicionarLojaDevolucao
	{
		width: 870px;
		transition: 0.5s ease-in;
	}

	#camp_add_sup_lojaAdd, #camp_add_ger_lojaAdd, #camp_add_lid_lojaAdd, #camp_add_dis_lojaAdd
	{
		margin-top:3%;
	}

	#camp_rm_sup_lojaAdd, #camp_rm_ger_lojaAdd, #camp_rm_lid_lojaAdd, #camp_rm_dis_lojaAdd
	{
		margin-top: 3%;
	}

</style>
 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script>

    	// Programação com a api do google maps (places)
        google.maps.event.addDomListener(window, 'load', function () {
            var places = new google.maps.places.Autocomplete(document.getElementById('enderecoLojaId'));
            google.maps.event.addListener(places, 'place_changed', function () {

	        	$('#map-adicionar-loja').css("height", "0");
	        	$('#map-adicionar-loja').css("height", "300px");

                var place = places.getPlace();
                var address = place.formatted_address;
                enderecoPartido = address.split("-");
                bairroPartido = enderecoPartido[1].split(',');
                console.log(enderecoPartido[0] + " " + enderecoPartido[1])
                $("#enderecoLojaId").val(enderecoPartido[0]);
                $("#bairroId").val(bairroPartido[0]);

                //Colocando a latitude no campo hidden de latitude
                var campoLat = document.getElementById("latitudeID");
                campoLat.value = place.geometry.location.lat();

                //Colocando a longitude no campo hidden de longitude
                var campoLog = document.getElementById("longitudeID");
                campoLog.value = place.geometry.location.lng();

                var campoBairro = document.getElementById("bairroId");

                var optionsMapAdd = {
                	center: {lat: place.geometry.location.lat(), lng: place.geometry.location.lng()},
                	zoom: 18,
                	mapTypeId: google.maps.MapTypeId.ROADMAP
                };

                var mapAdicionarLoja = document.getElementById("map-adicionar-loja");

                var mapAdicionar = new google.maps.Map(mapAdicionarLoja,optionsMapAdd); 

                window.setTimeout(function () {
				    google.maps.event.trigger(mapAdicionar, 'resize')
				}, 0);

                // Marker do mapa adicionar
				var MakerAdicionar = new google.maps.Marker({
					position: {lat: place.geometry.location.lat(), lng: place.geometry.location.lng()},
					map: mapAdicionar,
					draggable: true

				});

				   google.maps.event.addListener(MakerAdicionar, "dragend", function(event) { 
			          campoLat.value = event.latLng.lat(); 
			          campoLog.value = event.latLng.lng();
			       }); 

            });
        });





        $(document).ready(function(){
	        $('#map-adicionar-loja').css("height", "0");

	        $("#campoEnderecoDevolucaoAdd").hide();

	        $("#devolucaoDiferenteId").click(function(){
	        	if(document.getElementById("devolucaoDiferenteId").checked)
	        	{
	        		$("#campoEnderecoDevolucaoAdd").show(500);

	        		var AutocompleteLojaDevolucao = new google.maps.places.Autocomplete(document.getElementById("enderecoLojaDevolucaoId"));

	        			$("#enderecoLojaDevolucaoId").change(function(){
	        				if($("#enderecoLojaDevolucaoId").val() == "")
		        			{
		        				$("#mapAdicionarLojaDevolucao").css("height", "0px");
		        			}
	        			});


	        		google.maps.event.addListener(AutocompleteLojaDevolucao, 'place_changed', function(){

	        			var placeDevolucao = AutocompleteLojaDevolucao.getPlace();

	        			var addressDev = placeDevolucao.formatted_address;

	        			var enderecoPartidoDev = addressDev.split("-");
	        			console.log(enderecoPartidoDev);
	        			$("#enderecoLojaDevolucaoId").val(enderecoPartidoDev[0]);

	        			var bairroPartidoDev =  enderecoPartidoDev[1].split(",");
	        			console.log(bairroPartidoDev);
	        			$("#bairroLojaDevolucaoId").val(bairroPartidoDev[0]);

		        		var optionsMapAddDevolucao = {
		        			center: {lat: placeDevolucao.geometry.location.lat(), lng:placeDevolucao.geometry.location.lng()},
		        			zoom: 18,
		        			MapTypeId: google.maps.MapTypeId.ROADMAP
		        		};

		        		var mapAdicionarLojaDevolucao = new google.maps.Map(document.getElementById("mapAdicionarLojaDevolucao"),optionsMapAddDevolucao);

		        		$("#latatideDevId").val(placeDevolucao.geometry.location.lat());
		        		$("#longitudeDevId").val(placeDevolucao.geometry.location.lng());

		        		var MakerAdicionarDevolucao =  new google.maps.Marker({
		        			position: {lat: placeDevolucao.geometry.location.lat(), lng: placeDevolucao.geometry.location.lng()}, 
		        			map: mapAdicionarLojaDevolucao,
		        			draggable: true
		        		});

	        			$('#mapAdicionarLojaDevolucao').css("height", "0");
		        		$('#mapAdicionarLojaDevolucao').css("height", "300px")

		        		google.maps.event.addListener(MakerAdicionarDevolucao, "dragend", function(event){
		        			$("#latatideDevId").val(event.latLng.lat());
		        			$("#longitudeDevId").val(event.latLng.lng());

		        		});
	        		});
	        	}

	        	if(!(document.getElementById("devolucaoDiferenteId").checked))								//O check de devolução esta desmarcado?
		        {
		        	$("#campoEnderecoDevolucaoAdd").hide(500);												//Esconde o campo

		        	$("#enderecoLojaDevolucaoId").val("");													//Limpa o campo de endereço
		        	$("#bairroLojaDevolucaoId").val("");													//Limpa o campo de bairro
		        	$("#mapAdicionarLojaDevolucao").css("height", "0");										//Esconde o mapa
		        	$("#latatideDevId").val(0);																//Zera a latitude do mesmo
		        	$("#longitudeDevId").val(0);															//Zera a longitude do mesmo
		        }

	        });

        });	


    </script>

    <script>
    	$(document).ready(function(){
    		$("#bodyFormAddLoja").hide();
    		$("#erroLojaExisteAdd").hide(700);

			var pesquisarLoja = $("#nomeLojaId").val();
			
			$.ajax({
				type: "POST",
				url: "pegarNomeTodasLojas.php",
				data: {filtraLoja: ""},
				dataType: "json",

				success: function(data)
				{
			    	for(k in data)
			    	{
			    		var option = document.createElement("option");
			    		option.text = data[k]['nome_loja'];
			    		option.value = data[k]['nome_loja'];

			    		var select = document.getElementById("filtroLojasAdd");

			    		select.appendChild(option);
			    	}
				},
				error: function(xhr, desc, err)
				{
					console.log(xhr.responseText);
					console.log("Detalhes:" + xhr + "nErro: " + err);
				} 
				
			});


			$("#nomeLojaId").change(function(){

				var lojaNomeAdd = $("#nomeLojaId").val();

				$.ajax({
					type: "GET",
					url: "pegarDadosLoja.php",
					data: {barraPesquisa: lojaNomeAdd},
					dataType: "json",

					success: function(data)
					{	
						console.log(lojaNomeAdd);
						if(lojaNomeAdd != "")
						{
							if(data == false)
							{
								$("#erroLojaExisteAdd").hide(700);
								$("#bodyFormAddLoja").show(700);
							}
							else if(data != false)
							{
								$("#bodyFormAddLoja").hide(700);
								$("#erroLojaExisteAdd").show(700);
							}
						}
						else if (lojaNomeAdd == "")
						{
							$("#erroLojaExisteAdd").hide(700);
							$("#bodyFormAddLoja").hide(700);
						}

					},

					error: function(xhr, desc, err)
					{
						console.log(xhr.responseText);
						console.log("Detalhes: " + desc + "nErro: " + err);
					}

				});

			});
		});
    </script>

	<script>
		$(document).ready(function(){

			$("#btn_add_sup_lojaAdd").click(function(){

				cont_sup = $(".camp_sup_add").length + 1; 

				$("#camp_sup_addLoja").append(''+
					'<div class="camp_sup_add">'+
						'<div class="col-xs-6">'+
							'<label for="supervisorId">Nome</label><input type="text" class="form-control" name="nome_sup['+ cont_sup +'][nome_sup_add]" placeholder="Supervisor resposavel pela loja">'+
						'</div>'+
						'<div class="col-xs-5">'+
							'<label>Telefone</label><input type="text" name="tel_sup[' + cont_sup + '][tel_sup_add]" class="form-control" placeholder="Celular do supervisor">'+
						'</div>'+
						'<div id="camp_rm_sup_lojaAdd" class="col-xs-1">'+
							'<button class="btn btn-danger btn-sm btn-remove-phone" type="button"><span class="glyphicon glyphicon-remove"></span></button>'+
						'</div>'+
					'</div>'	
				);		

				$(document.body).on('click', '.btn-remove-phone', function(){
					$(this).closest(".camp_sup_add").remove();
				});
			});



			$("#btn_add_ger_lojaAdd").click(function(){

				var cont_ger = $(".camp_ger_add").length + 1; 

				$("#camp_ger_addLoja").append(''+
				'<div class="camp_ger_add">'+
					'<div class="col-xs-6">'+
						'<label for="supervisorId">Nome</label><input type="text" class="form-control" name="nome_ger['+ cont_ger +'][nome_ger_add]"  placeholder="Gerente resposavel pela loja">'+
					'</div>'+
					'<div class="col-xs-5">'+
						'<label>Telefone</label><input type="text" name="tel_ger[' + cont_ger + '][tel_ger_add]" class="form-control" placeholder="Celular do gerente">'+
					'</div>'+
					'<div id="camp_rm_ger_lojaAdd" class="col-xs-1">'+
						'<button class="btn btn-danger btn-sm btn-remove-phone" type="button"><span class="glyphicon glyphicon-remove"></span></button>'+
					'</div>'+
				'</div>'	
				);	

				$(document.body).on("click", '.btn-remove-phone', function(){
					$(this).closest(".camp_ger_add").remove();
				});	
			});

			$("#btn_add_lid_lojaAdd").click(function(){

				var cont_lid = $(".camp_lid_add").length + 1; 

				$("#camp_lid_addLoja").append(''+
				'<div class="camp_lid_add">'+
					'<div class="col-xs-6">'+
						'<label>Nome</label><input type="text" class="form-control" name="nome_lid['+ cont_lid +'][nome_lid_add]"  placeholder="Disponibilidade resposavel pela loja">'+
					'</div>'+
					'<div class="col-xs-5">'+
						'<label>Telefone</label><input type="text" name="tel_lid[' + cont_lid + '][tel_ger_add]" class="form-control" placeholder="Celular do lider">'+
					'</div>'+
					'<div id="camp_rm_lid_lojaAdd" class="col-xs-1">'+
						'<button class="btn btn-danger btn-sm btn-remove-phone" type="button"><span class="glyphicon glyphicon-remove"></span></button>'+
					'</div>'+
				'</div>'	
				);

				$(document.body).on("click", '.btn-remove-phone', function(){
					$(this).closest(".camp_lid_add").remove();
				});		
			});

			$("#btn_add_dis_lojaAdd").click(function(){

				var cont_dis = $(".camp_dis_add").length + 1; 

				$("#camp_dis_addLoja").append(''+
					'<div class="camp_dis_add">'+
						'<div class="col-xs-6">'+
							'<label>Nome</label><input type="text" class="form-control" name="nome_dis['+ cont_dis +'][nome_dis_add]"  placeholder="Disponibildiade resposavel pela loja">'+
						'</div>'+
						'<div class="col-xs-5">'+
							'<label>Telefone</label><input type="text" name="tel_dis[' + cont_dis + '][tel_dis_add]" class="form-control" placeholder="Celular do lider">'+
						'</div>'+
						'<div id="camp_rm_dis_lojaAdd" class="col-xs-1">'+
							'<button class="btn btn-danger btn-sm btn-remove-phone" type="button"><span class="glyphicon glyphicon-remove"></span></button>'+
						'</div>'+
					'</div>'	
				);

				$(document.body).on("click", '.btn-remove-phone', function(){
					$(this).closest(".camp_dis_add").remove();
				});		
			});

		});
	</script>
<div class="modal fade" id="adicionarLoja" role="dialog">
		<div class="modal-dialog modal-lg">			
			<div class="modal-content">

				<!-- Cabeçaho do modal de adicionar nova loja -->
				<div class="modal-header">
					<h1 class="modal-title">Adicionar nova loja</h1>
	 			</div>

	 			<!-- Corpo do modal -->
	 			<div class="modal-body">
	 				<form id="formAdicionarLoja" method="POST" action="lojas.php">

	 					<div class="alert alert-danger" id="erroLojaExisteAdd">
	 						<strong>A loja digitada já existe!</strong> Escolha outra loja!
	 					</div>

		 				<label for="nomeLojaId">Nome Loja</label><input type="text" class="form-control" name="nomeLoja" id="nomeLojaId" placeholder="Nome usado para a loja" required list="filtroLojasAdd" data-list='{"valueCompletion": true, "highlight": true}'><br>
	 					<datalist id="filtroLojasAdd">
		 				</datalist>

		 				<div id="bodyFormAddLoja">
			 				<label for="enderecoLojaId">Endereço</label><input type="text" class="form-control" name="enderecoLoja" id="enderecoLojaId" placeholder="Rua logradouro .." required>

			 				<!-- Mapa na aba de adicionar loja -->
			 				 <div id="map-adicionar-loja"></div><br>

			 				<label for="bairroId">Bairro</label><input type="text" class="form-control" name="bairroLoja" placeholder="Parque, Jardim .." id="bairroId" required><br>

			 				<label class="checkbox-inline"><input type="checkbox" name="devolucaoDiferente" id="devolucaoDiferenteId"> Endereço de devolução diferente</label><br><br>

			 				<div id="campoEnderecoDevolucaoAdd">
			 					<label for="enderecoLojaDevolucaoId">Endereço de devolução</label><input type="text" class="form-control" name="enderecoLojaDevolucao" id="enderecoLojaDevolucaoId" placeholder="Endereço de devolução do carro"><br>

			 					<div id="mapAdicionarLojaDevolucao"></div>

			 					<label for="bairroLojaDevolucaoId">Bairro de devolução</label><input type="text" class="form-control" name="bairroLojaDevolucao" id="bairroLojaDevolucaoId" placeholder="Bairro onde será devolvido o carro"><br>
			 				</div>
			 				
			 				<label for="horarioLojaId">Horário de Funcionamento</label><input class="form-control" type="text" name="horarioLoja" placeholder="Segunda a Domingo: 09h00 as 22h00" id="horarioLojaId" required> <br>
			 				<label for="telefoneId">Telefone</label><input type="text" class="form-control" data-mask="00/00/0000" maxlength="10" name="telefoneLoja" id="telefoneId" placeholder="(00) 00000-0000" required><br>
			 				<label for="emailLojaId">Email</label><input type="email" class="form-control" name="emailLoja" id="emailLojaId" placeholder="exemplo@movida.com.br" required><br>
			 				<label for="pontoReferenciaId">Ponto de referencia</label><textarea class="form-control" name="pontoReferenciaLoja" placeholder="Perto de algo" id="pontoReferenciaId"></textarea>

			 				<fieldset id="camp_sup_addLoja">
							 	<div class="camp_sup_add">
									<legend>Supervisor</legend>
									<div class="col-xs-6">
										<label for="supervisorId">Nome</label><input type="text" name="nome_sup[1][nome_sup_add]" class="form-control" name="supervisorLoja" id="supervisorId" placeholder="Supervisor resposavel pela loja" required>
									</div>
									<div class="col-xs-5">
										<label>Telefone</label><input type="text" name="tel_sup[1][tel_sup_add]" class="form-control" placeholder="Celular do supervisor">
									</div>
								</div>

								<div id="camp_add_sup_lojaAdd" class="col-xs-1">
									<button type="button" class="btn btn-warning btn-sm btn-add-phone" id="btn_add_sup_lojaAdd"><span class="glyphicon glyphicon-plus"></span></button>
								</div>
			 				</fieldset>

			 				<fieldset id="camp_ger_addLoja">

							 	<div class="camp_ger_add">
									<legend>Gerente</legend>
									
									<div class="col-xs-6">
										<label for="gerenteId">Nome</label><input type="text" class="form-control" name="nome_ger[1][nome_ger_add]" placeholder="Nome gerente responsavel pela loja" required>
									</div>

									<div class="col-xs-5">
										<label for="tel_ger_add">Telefone</label><input type="text" class="form-control" name="tel_ger[1][tel_ger_add]" placeholder="Celular do gerente">
									</div>

									<div id="camp_add_ger_lojaAdd" class="col-xs-1">
										<button type="button" class="btn btn-warning btn-sm btn-add-phone" id="btn_add_ger_lojaAdd"><span class="glyphicon glyphicon-plus"></span></button>
									</div>
								</div>
			 				</fieldset>
			 				
							<fieldset id="camp_lid_addLoja">
								<legend>Lider</legend>

								<div class="col-xs-6">
									<label for="liderId">Nome</label><input type="text" class="form-control" name="nome_lid[1][nome_lid_add]"  placeholder="Nome do lider responsavel pela loja" >
								</div>

								<div class="col-xs-5">
									<label for="tel_lid_add">Telefone</label><input type="text" class="form-control" name="tel_lid[1][tel_lid_add]" placeholder="Celular do lider">
								</div>
								
								
								<div id="camp_add_lid_lojaAdd" class="col-xs-1">
									<button type="button" class="btn btn-warning btn-sm btn-add-phone" id="btn_add_lid_lojaAdd"><span class="glyphicon glyphicon-plus"></span></button>
								</div>
							</fieldset>

							<fieldset id="camp_dis_addLoja">
							<legend>Disponibilidade</legend>

								<div class="col-xs-6">
									<label>Nome</label><input type="text" class="form-control" name="nome_dis[1][nome_dis_add]"  placeholder="Disponibilidade responsavel pela loja" required>
								</div>

								<div class="col-xs-5">
									<label>Telefone</label><input type="text" class="form-control" name="tel_dip[1][tel_dip_add]" placeholder="Celular da disponibilidade">
								</div>

								<div id="camp_add_dis_lojaAdd" class="col-xs-1">
									<button type="button" class="btn btn-warning btn-sm btn-add-phone" id="btn_add_dis_lojaAdd"><span class="glyphicon glyphicon-plus"></span></button>
								</div>
							</fieldset>
							<input type="hidden" class="form-control" name="latitude" id="latitudeID">
							<input type="hidden" class="form-control" name="longitude" id="longitudeID">

							<input type="hidden" class="form-control" name="latitudeDev" id="latatideDevId">
							<input type="hidden" class="form-control" name="longitudeDev" id="longitudeDevId">

				 			<!-- Rodapé do modal -->
				 			<div class="modal-footer">
				 				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				 				<button type="submit" name="SALVAR" id="btnAdicionar" class="btn">Adicionar</button>
				 			</div>	
				 		</div>

	 				</form>

	 			</div>

			</div>

		</div>
</div>




