<?php
    session_start();                            //iniciando a sessão do usuário
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Página de busca</title>
<!--    Importação do estilo da interface -->
    <link rel="stylesheet" type="text/css" href="css/estiloTela.css" />

<!--    Importação do estilo do menu de opções-->
    <link rel="stylesheet" href="css/estilo-menu.css" />

    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAzcjbStpb2d2ug4oEKyzlY6tt_CYjBv70"></script>
    <script src="javaScript/js.js" ></script>

<!-- Importando a biblioteca via jsonp do ajax e a do bootStrap-->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    <script>

        $(document).ready(function () {
           $("#formularios").hide();

           $("#btnPesquisar").click(function () {
              $("#formularios").hide("slow");
              $("#formularios").show("slow");
           });
        });
    </script>

</head>

<body>

<nav id="menu">

    <figure id="logo-pac">
        <img src="imagens/logo-pac-titulo.png" />
    </figure>

    <?php
        if(isset($_SESSION['id']))
        {
            echo '<p id="saudacao_usuario"> Olá, '. $_SESSION['nome_usuario'] . '</p>';
        }
        else
        {
            echo "VoCÊ ERROU";
        }
    ?>

    <ul id="opcoes-menu">
        <li class="botao-menu"><a href="#">Consultar</a></li>
        <li class="botao-menu"><a href="#">Adicionar</a></li>
        <li class="botao-menu"><a href="#">Excluir</a></li>
        <li class="botao-menu"><a href="#">Alterar</a></li>
        <li class="botao-menu"><a href="#">Sair</a></li>
    </ul>
</nav>

<form method="post" action="javascript:enviarDados()">
        <header class="cabecalho-form">
            <!-- LOGO MOVIDA -->
            <figure id="logo-movida">
                <img src="imagens/movida-logo.png">
            </figure>   
            <!-- AREA PARA PESQUISA DA LOJA -->
            <div id="area-pesquisa">
                <input type="text" name="barraPesquisa" id="barraPesquisa" class="barraDeBusca" placeholder="Pesquise a loja" list="nomeLojas"/>
                <!--Auxilio para o a gente digitar o nome da loja -->
                <datalist id="nomeLojas">
                    <option value="porra"></option>
                    <option value="Guarulhos"></option>
                </datalist>
                <input type="submit" id="btnPesquisar" value="Pesquisar"/>
            </div>
        </header>
    <!-- AREA DAS INFORMAÇÔES DA LOJA -->
    <div id="formularios">
        <!-- INFORMAÇÕES A ESQUERDA -->
        <div id="inf-esquerda">
                <!--Informações do formulário da parte de retirada-->
                <h3 class="titulo-form">Dados retirada</h3>

                <label for="enderecoRet">Endereço:</label><span id="enderecoRet"></span><br>
                <label for="bairroRet">Bairro:</label><span id="bairroRet"></span><br>
                <label for="horarioRet">Horário:</label><span id="horarioRet"></span><br>
                <label for="telefoneRet">Telefone:</label><span id="telefoneRet"></span><br>
                <label for="emailRet">Email:</label><span id="emailRet"></span><br>

                <div id="referenciasRet">
                    <label>Referencia:</label><br><span class="pontoReferenciasRet"></span>
                </div>

                <div id="map-esquerda"></div>
        </div>

        <!--INFORMAÇÕES NO CENTRO  -->
        <div id="inf-direita">

            <!--Informações do formulário da parte de devolução-->
            <h3 class="titulo-form">Dados devolução</h3>
            <label for="enderecoDev">Endereço:</label>  <span id="enderecoDev"></span><br>
            <label for="bairroDev">Bairro:</label><span id="bairroDev"></span><br>
            <label for="horarioDev">Horário:</label><span id="horarioDev"></span><br>
            <label for="telefoneDev">Telefone:</label><span id="telefoneDev"></span><br>
            <label for="emailDev">Email:</label><span id="emailDev"></span><br>

            <div id="referenciasDev">
                <label for="pontoReferenciaDev">Referencia:</label><br><span class="pontoReferenciasDev"></span>
            </div>

            <div id="map-direita"></div>
        </div>

        <!--Descrição dos responsaveis da loja-->
        <div id="inf-responsaveis">
            <h3 class="titulo-form">Responsaveis Loja</h3>
            <label for="supervisor">Supervisor:</label><br><span id="supervisor"></span><br>
            <label for="gerenteRegional">Regional:</label><br><span id="gerenteRegional"></span><br>
            <label for="Lider">Lider:</label><br><span id="lider"></span><br>
            <label for="disponibilidade">Disponibilidade:</label><br><span id="disponibilidade"></span>
        </div>
    </div>
</form>

</body>

<script> 
    function enviarDados() {
        var barraPesquisa = $("#barraPesquisa").val();                               //pegando o conteúdo da barra de pesquisa
        $.ajax({
            type: 'GET',                                                            //tipo de solicitação enviada
            url: 'pegarDadosLoja.php',                                                   //para onde vamos enviar o que foi digitado na barra de pesquisa
            data: {barraPesquisa: barraPesquisa},                                    //o conteudo enviado
            dataType: 'json',                                                          //o tipo da informação de resposta

            success: function (response) {
                var infLoja = response;                                             //recebe todas as informações da loja em um array response
                console.log(infLoja);
                //coloca os dados nos inputs determinados
                //
                //Input de Retirada
                $("#enderecoRet").html(infLoja[0].endereco);
                $("#bairroRet").html(infLoja[0].bairro);
                $("#horarioRet").html(infLoja[0].horario);
                $("#telefoneRet").html(infLoja[0].telefone);
                $("#emailRet").html(infLoja[0].email);
                $(".pontoReferenciasRet").html(infLoja[0].referencias);

                //Devolução
                $("#enderecoDev").html(infLoja[0].endereco);
                $("#bairroDev").html(infLoja[0].bairro);
                $("#horarioDev").html(infLoja[0].horario);
                $("#telefoneDev").html(infLoja[0].telefone);
                $("#emailDev").html(infLoja[0].email);
                $(".pontoReferenciasDev").html(infLoja[0].referencias);

                $("#supervisor").html(infLoja[0].supervisor);
                $("#gerenteRegional").html(infLoja[0].gerente);
                $("#lider").html(infLoja[0].lider);
                $("#disponibilidade").html(infLoja[0].disponibilidade);

                $("#lat-direita").val(infLoja[0].lat);

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

</html>