 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<style>
	.esquerda-table
	{
		width: 100px;
		font-weight: bolder;
		background-color: orangered; 
		color: #fff;
		font-weight: bolder;
	}

	fieldset
	{
		width: 100%;
	}
	
	.tituloExcluirLoja
	{
		color: #fff;
		font-weight: bolder;
		background-color: orangered
	}

	.direita-table
	{
		background-color: orangered; 
		color: #fff;
		font-weight: bolder;
		padding: 2%;
	}

	#formDeletar
	{
		float:flex;
	}

	#map-deleta
	{
		width: 450px;
		height: 300px;
		float:right;
    	top: 0;
    	margin-left: 100px; 
    }

	#resumoDeleteLoja
	{
		width:50%;
		height: 100%;
		margin: 0;
		padding: 0;
	}

	#tableDeleteLoja
	{
		width: 300px;
		table-layout:fixed;
		word-wrap: break-word;
		padding: 0;
		border: lightgray;
		margin-top: 3%;
	}

</style>

<div class="modal fade" id="deletarLoja" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<div class="modal-header">
				<h1 class="modal-title">Deletar uma loja</h1>
			</div>
				<form id="formDeletar" method="POST" action="lojas.php">
					<div class="modal-body">

						<div class="alert alert-danger" id="erroLojaNaoExisteDel">
							<strong>A loja digitada não existe!</strong> Digite uma loja válida!
						</div>

						<label for="lojaDeletarId">Digite a loja a ser deletada</label><input type="text" class="form-control" name="lojaDeleta" id="lojaDeletarId" placeholder="Loja a ser deletada" list="fitroLojasDel">

						<datalist id="fitroLojasDel"></datalist>

						<legend id="erroLojaDelete">Preencha o campo com alguma loja</legend>
						<div id="resumoDeleteLoja">
							<table>
								<td colspan="2">
									<table id="tableDeleteLoja" border="1">
										<td class="tituloExcluirLoja" colspan="2" valign="center" align="center"><h2><img src="imagens/cursor2.cur">Resumo da loja</h2></td>
										<tr>
											<td class="esquerda-table" align="center" valign="center">Nome da Loja:</td> <td class="direita-table"><span name="nomeLoja" class="nomeLoja"></span></td>
										</tr>

										<tr>
											<td class="esquerda-table" align="center" valign="center"><label>Endereço Retirada: </label></td> <td class="direita-table"><span name="enderecoLoja" class="enderecoLoja"></span></td>
										</tr>

										<tr>
											<td class="esquerda-table" align="center" valign="center"><label>Bairro Retirada:</label></td> <td class="direita-table"><span name="bairroLoja" class="bairroLoja"></span></td>
										</tr>

										<tr>
											<td class="esquerda-table" align="center" valign="center"><label>Endereço Devolução: </label></td> <td class="direita-table"><span name="enderecoLojaDelDev" class="enderecoLojaDelDev"></span></td>
										</tr>

										<tr>
											<td class="esquerda-table" align="center" valign="center"><label>Bairro Devolução :</label></td> <td class="direita-table"><span name="bairroLojaDelDev" class="bairroLojaDelDev"></span></td>
										</tr>

										<tr>
											<td class="esquerda-table" align="center" valign="center"><label>Horário</label></td> <td class="direita-table"><span name="horarioLoja" class="horarioLoja"></span></td>
										</tr>

										<tr>
											<td class="esquerda-table" align="center" valign="center"><label>Email : </label></td> <td class="direita-table"><span name="emailLoja" class="emailLoja"></span></td>
										</tr>

										<tr>
											<td class="esquerda-table" align="center" valign="center"><label>Ponto Referencia: </label></td> <td class="direita-table"><span name="referenciaLoja" class="referenciaLoja"></span></td>
										</tr>

										<tr>
											<td class="esquerda-table" align="center" valign="center"><label>Supervisor: </label></td> <td class="direita-table"><span name="supervisorLoja" class="supervisorLoja"></span></td>
										</tr>

										<tr>
											<td class="esquerda-table" align="center" valign="center"><label>Gerente: </label></td> <td class="direita-table"><span name="gerenteLoja" class="gerenteLoja"></span></td>
										</tr>

										<tr>
											<td class="esquerda-table" align="center" valign="center"><label>Lider: </label></td> <td class="direita-table"><span name="liderLoja" class="liderLoja"></span></td>
										</tr>

										<tr>
											<td class="esquerda-table" align="center" valign="center"><label>Disponibilidade: </label></td> <td class="direita-table"><span name="disponibilidadeLoja" class="disponibilidadeLoja"></span></td>
										</tr>								
									</table>
								</td>
								<td><div id="map-deleta"></div></td>
							</table>							
						</div>
																				
					</div>

					<div class="modal-footer">
						<button type="button" id="btnCancelar" class="btn btn-secundary" data-dismiss="modal">Cancelar</button>
						<button type="submit" name="DELETAR" id="btnDeletar" class="btn btn-secundary">Deletar</button>
					</div>
				</form>
		</div>
	</div>
</div>

 <script>

 	$(document).ready(function(){
		var pesquisarLoja = $("#lojaDeletarId").val();
		$("#erroLojaNaoExisteDel").hide();

 		$.ajax({
 			type: "POST",
 			url: "pegarNomeTodasLojas.php",
 			data:  {filtraLoja: pesquisarLoja},
 			dataType: "json",

 			success: function(data)
 			{
		    	for(k in data)
		    	{
		    		var option = document.createElement("option");
		    		option.text = data[k]['nome_loja'];
		    		option.value = data[k]['nome_loja'];

		    		var select = document.getElementById("fitroLojasDel");

		    		select.appendChild(option);
		    	}

 			},
			error: function(xhr, desc, err)
			{
				console.log(xhr.responseText);
				console.log("Detalhes: " + desc + "Erro: " + err);
			}			

	    });

 		//Quando a página é carregada o resumo da loja fica invisivel
 		$("#resumoDeleteLoja").hide();
 		$("#erroLojaDelete").hide();
 		

		$("#erroLojaDelete").show(500);
		$("#resumoDeleteLoja").hide(1000);

		if($("#lojaDeletarId").val() == "" || $("#lojaDeletarId").val() == null)
			{
			$("#erroLojaDelete").show(500);
		}
		else
		{
			$("#resumoDeleteLoja").show(1000);
		}

		// $('#btnCancelar').click(function(){
		// 	$("#lojaDeletarId").val() = "";				//zera o campo de buscar a loja
		// 	$("#resumoDelete").hide(1000);					//esconde o resumo da loja
		// });	


 		$("#lojaDeletarId").change(function(){
 			$("#resumoDeleteLoja").hide(1000);
 			var barraDeletar = $("#lojaDeletarId").val();

 			if(barraDeletar != "")
 			{
 				$.ajax({
	 				type: 'GET',
	 				url: 'pegarDadosLoja.php',
	 				data: {barraPesquisa: barraDeletar},
	 				dataType: 'json',

	 				success: function(response)
	 				{
	 					console.log(response);
	 					if(response == false)
	 					{
							$("#erroLojaNaoExisteDel").show(700);
	 					}
	 					else if(response != false)
	 					{
	 					$("#erroLojaNaoExisteDel").hide(700);
	 					$("#erroLojaDelete").hide(500);
	 					$("#resumoDeleteLoja").show(700);

	 					$(".nomeLoja").html(response[0].nome_loja);
	  					$(".enderecoLoja").html(response[0].endereco);
						$(".bairroLoja").html(response[0].bairro);
						if(response[0].latDev != 0 && response[0].lngDev !=0)					//Loja de devolução diferente da de retirada?
						{
							$(".enderecoLojaDelDev").html(response[0].enderecoDev);				//coloca na página o endereço da devolução
							$(".bairroLojaDelDev").html(response[0].bairroDev);					//coloca na página o bairro da devolução
						}
						else if(response[0].latDev == 0 && response[0].lngDev == 0)				//Loja de devolução igual a de retirada?
						{
							$(".enderecoLojaDelDev").html(response[0].endereco);				//coloca na página o mesmo de retirada no endereço da devolução
							$(".bairroLojaDelDev").html(response[0].bairro);					//coloca na página o mesmo de retirada no bairro da devolução
						}

	 					$(".horarioLoja").html(response[0].horario);
	 					$(".emailLoja").html(response[0].email);
	 					$(".referenciaLoja").html(response[0].referencias);
	 					$(".supervisorLoja").html(response[0].supervisor);
	  					$(".gerenteLoja").html(response[0].gerente);
	   					$(".liderLoja").html(response[0].lider);
	   	 				$(".disponibilidadeLoja").html(response[0].disponibilidade);

	   	 				var mapDeleta = document.getElementById("map-deleta");

	   	                var options = {
		                    center: {lat: parseFloat(response[0].lat), lng: parseFloat(response[0].lng)},
		                    zoom: 18,
		                    mapTypeId: google.maps.MapTypeId.ROADMAP
	                	};

						var mapCampoDeleta = new google.maps.Map(mapDeleta, options);

	   	                var optionsMarker = {
		                    position: {lat: parseFloat(response[0].lat), lng: parseFloat(response[0].lng)},
		                    map: mapCampoDeleta
	                	};
						var MakerDeleta = new google.maps.Marker(optionsMarker);
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

	                	$("#erroLojaDelete").show(500);
	                	$("#resumoDeleteLoja").hide(1000);
	                }
            	});
 			}	
 			else if(barraDeletar == "")		
 			{
 				$("#erroLojaNaoExisteDel").hide(700);
 				$("#resumoDeleteLoja").hide(700);
 			}
 		});
 	});
 

 </script>
