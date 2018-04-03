<script> 
    function enviarDados() {

        var barraPesquisa = $("#barraPesquisa").val();                               //pegando o conteúdo da barra de pesquisa


        $.ajax({
            type: 'GET',                                                                 //tipo de solicitação enviada
            url: 'pegarDadosLoja.php',                                                   //para onde vamos enviar o que foi digitado na barra de pesquisa
            data: {barraPesquisa: barraPesquisa},                                        //o conteudo enviado
            dataType: 'json',                                                            //o tipo da informação de resposta

            success: function (response) {
                var infLoja = response;                                                  //recebe todas as informações da loja em um array response
                console.log(infLoja);
                //coloca os dados nos inputs determinados
                //
                //Input de Retirada
                $("#enderecoRet").html(infLoja[0].endereco);
                $("#bairroRet").html(infLoja[0].bairro);
                $("#horarioRet").html(infLoja[0].horario);
                $("#telefoneRet").html(infLoja[0].telefone);
                $("#emailRet").html(infLoja[0].email);
                $(".pontoReferenciasRet").text(infLoja[0].referencias);

                //Devolução
                $("#horarioDev").html(infLoja[0].horario);
                $("#telefoneDev").html(infLoja[0].telefone);
                $("#emailDev").html(infLoja[0].email);
                $(".pontoReferenciasDev").html(infLoja[0].referencias);

                $("#supervisor").html(infLoja[0].supervisor);
                $("#gerenteRegional").html(infLoja[0].gerente);
                $("#lider").html(infLoja[0].lider);
                $("#disponibilidade").html(infLoja[0].disponibilidade);


                var options = {
                    center: {lat: parseFloat(infLoja[0].lat), lng: parseFloat(infLoja[0].lng)},
                    zoom: 18,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };

                var mapDivEsquerda = document.getElementById("map-esquerda");

                var mapEsquerda = new google.maps.Map(mapDivEsquerda, options);

                var markEsquerda = new google.maps.Marker({
                    position: {lat:parseFloat(infLoja[0].lat), lng:parseFloat(infLoja[0].lng)},
                    map: mapEsquerda
                });

                if(infLoja[0].latDev == 0 || infLoja[0].lngDev == 0)                                   //Loja de devolução é a mesma de retirada?
                {
                    $("#enderecoDev").html(infLoja[0].endereco);
                    $("#bairroDev").html(infLoja[0].bairro);
                    var mapDivDireita = document.getElementById("map-direita");
                    var mapDireita = new google.maps.Map(mapDivDireita, options);

                    var markerDireita = new google.maps.Marker({
                        position:{ lat:parseFloat(infLoja[0].lat), lng:parseFloat(infLoja[0].lng)},
                        map: mapDireita
                    });
                }
                else if(infLoja[0].latDev != 0 && infLoja[0].lngDev != 0)                             //Loja de devolução diferente da de retirada?
                {    
                    $("#enderecoDev").html(infLoja[0].enderecoDev);
                    $("#bairroDev").html(infLoja[0].bairroDev);
                    var mapDivDireita = document.getElementById("map-direita");
                    var optionsDireita = {
                        center: {lat: parseFloat(infLoja[0].latDev) , lng: parseFloat(infLoja[0].lngDev)},
                        zoom: 18,
                        MapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    var mapDireita = new google.maps.Map(mapDivDireita, optionsDireita);

                    var markerDivDireita = new google.maps.Marker({
                        position: {lat:parseFloat(infLoja[0].latDev) , lng: parseFloat(infLoja[0].lngDev)},
                        map: mapDireita
                    });
                }
            },
            error: function (xhr, desc, err) {
                /*
                 * Caso haja algum erro na chamada Ajax,
                 * o utilizador é alertado e serão enviados detalhes
                 * para a consola javascript que pode ser visualizada
                 * através das ferramentas de desenvolvedor do browser.
                 */
                alert('Uups! Ocorreu algum erro!');
                console.warn(xhr.responseText);
                console.log("Detalhes: " + desc + "nErro:" + err);
            }
        });
    }

</script>