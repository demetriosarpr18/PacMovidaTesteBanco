<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
<!--    Importação do estilo da interface -->
    <link rel="stylesheet" type="text/css" href="PacMovidaTeste/css/estiloTela.css" />

<!--    Importação do estilo do menu de opções-->
    <link rel="stylesheet" href="PacMovidaTeste/css/estilo-menu.css" />

    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAzcjbStpb2d2ug4oEKyzlY6tt_CYjBv70"></script>
    <script src="PacMovidaTeste/javaScript/js.js" ></script>

<!-- Importando a biblioteca via jsonp do ajax e a do bootStrap-->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script

</head>

<body>
    
    
<figure id="logo-pac">
    <img src="imagens/pac-logo.png" />
</figure>

<figure id="logo-movida">
    <img src="imagens/movida-logo.png">
</figure>

<nav id="menu">
    <ul id="opcoes-menu">
        <li class="botao-menu"><a href="#">Consultar</a></li>
        <li class="botao-menu"><a href="#">Adicionar</a></li>
        <li class="botao-menu"><a href="#">Excluir</a></li>
        <li class="botao-menu"><a href="#">Alterar</a></li>
        <li class="botao-menu"><a href="#">Sair</a></li>
    </ul>
</nav>

<div id="teste">
 <form name="teste" method="" action="testeConexao.php">
        <input type="submit" value="Testar Conexão" style="width: auto; height: auto; border: 5px groove #0ff; margin-left:500px"> 
    </form>
</div>

<form method="post" action="javascript:enviarDados()">
    <div id="area-pesquisa">
        <input type="text" name="barraPesquisa" id="barraPesquisa" class="barraDeBusca" placeholder="Digite a loja" list="nomeLojas"/>
        <!--Auxilio para o a gente digitar o nome da loja -->
        <datalist id="nomeLojas">

            <option value="porra"></option>
            <option value="Guarulhos"></option>

        </datalist>
        <input type="submit" value="Pesquisar" />
    </div>
    <div id="inf-esquerda">

        <!--Informações do formulário da parte de retirada-->
        <p><h3>Dados retirada</h3></p>
        <label for="enderecoRet">Endereço:</label><input  type="text" id="enderecoRet" value=""/><br>
        <label for="bairroRet">Bairro:</label><input type="text" id="bairroRet"/><br>
        <label for="horarioRet">Horário:</label><input type="text" id="horarioRet" /><br>
        <label for="telefoneRet">Telefone:</label><input type="text" id="telefoneRet" ><br>
        <label for="emailRet">Email:</label><input type="text" id="emailRet" ><br>

        <div id="referenciaLojaRet">
            <label for="pontoReferenciaRet">Referencia:</label><textarea id="pontoReferenciaRet"  name="namePontoReferenciaRet" cols="22" rows="4"></textarea>
        </div>

        <div id="map-esquerda">

        </div>
    </div>

    <div id="inf-direita">

        <!--Informações do formulário da parte de devolução-->
        <p><h3>Dados devolução</h3></p>
        <label for="enderecoDev">Endereço:</label><input type="text" id="enderecoDev" /><br>
        <label for="bairroDev">Bairro:</label><input type="text" id="bairroDev" /><br>
        <label for="horarioDev">Horário:</label><input type="text" id="horarioDev" /><br>
        <label for="telefoneDev">Telefone:</label><input type="text" id="telefoneDev" /><br>
        <label for="emailDev">Email:</label><input type="text" id="emailDev" /><br>

        <div id="referenciaLojaDev">
            <label for="pontoReferenciaDev">Referencia:</label><textarea id="pontoReferenciaDev" name="namePontoReferenciaDev"  cols="22" rows="4"></textarea>
        </div>
        <div id="map-direita"></div>
    </div>

    <!--Descrição dos responsaveis da loja-->
    <div id="inf-responsaveis">
        <p><h3>Responsaveis da Loja</h3></p>
        <label for="supervisor">Supervisor:</label><input type="text" id="supervisor" /><br>
        <label for="gerenteRegional">Gerente Regional:</label><input type="text" id="gerenteRegional"/ ><br>
        <label for="Lider">Lider:</label><input type="text" id="lider" /><br>
        <label for="disponibilidade">Disponibilidade</label><input type="text" id="disponibilidade">
    </div>
</form>

</body>

<script> 
    function enviarDados() {
        var barraPesquisa = $("#barraPesquisa").val();                               //pegando o conteúdo da barra de pesquisa
        $.ajax({
            type: 'GET',                                                            //tipo de solicitação enviada
            url: 'pegarDados.php',                                                   //para onde vamos enviar o que foi digitado na barra de pesquisa
            data: {barraPesquisa: barraPesquisa},                                    //o conteudo enviado
            dataType:'json',                                                          //o tipo da informação de resposta

            success: function (response) {
                var infLoja = response;                                             //recebe todas as informações da loja em um array response
                console.log(infLoja);
                //coloca os dados nos inputs determinados
                //
                //Input de Retirada
                $("#enderecoRet").val(infLoja[0].endereco);
                $("#bairroRet").val(infLoja[0].bairro);
                $("#horarioRet").val(infLoja[0].horario);
                $("#telefoneRet").val(infLoja[0].telefone);
                $("#emailRet").val(infLoja[0].email);
                $("#pontoReferenciaRet").text(infLoja[0].referencias);

                //Devolução
                $("#enderecoDev").val(infLoja[0].endereco);
                $("#bairroDev").val(infLoja[0].bairro);
                $("#horarioDev").val(infLoja[0].horario);
                $("#telefoneDev").val(infLoja[0].telefone);
                $("#emailDev").val(infLoja[0].email);
                $("#pontoReferenciaDev").text(infLoja[0].referencias);

                $("#supervisor").val(infLoja[0].supervisor);
                $("#gerenteRegional").val(infLoja[0].gerente);
                $("#lider").val(infLoja[0].lider);
                $("#disponibilidade").val(infLoja[0].disponibilidade);

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