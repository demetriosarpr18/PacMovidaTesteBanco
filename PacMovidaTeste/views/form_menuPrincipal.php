<?php
    session_start();                            //iniciando a sessão do usuário
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/x-icon" href="imagens/fav_icon.ico"/>

    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDk365X1obhUfRnxp7IBgVyB6qczIQuGa4&libraries=places"></script>

    <title>Buscar Loja</title>
<!--    Importação do estilo da interface -->
    <link rel="stylesheet" type="text/css" href="css/estiloTela.css" />

<!--    Importação do estilo do menu de opções-->
    <link rel="stylesheet" href="css/estilo-menu.css" />

    <!-- Caso a página seja recarregada após o submit, esse if faz com que o submit não aconteça de novo -->
    <?php 
        if(isset($_POST['SALVAR']) || isset($_POST['ALTERAR']) || isset($_POST['DELETAR']))
        {
            // echo"<meta http-equiv='refresh' content='0'>";
        }
    ?>
    

<!-- Importando a biblioteca via jsonp do ajax e a do bootStrap-->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Importando o estilo bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

      <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
    
    <script>

        $(document).ready(function () {
           $("#formularios").hide();

           $("#btnPesquisar").click(function () {
              $("#formularios").hide("slow");
              $("#formularios").show("slow");
           });

           $(window.location.href == 'http://localhost/pacMovida')
           {
                $(".msgStatus").show(1000).delay(5000).fadeOut();
           }
        });

        $(document).ready(function(){

            $(".sub-menu").hide();

            $(".botao-menu").click(function(){
                $(this).find(".sub-menu").toggle(500);
                $(this).siblings().find(".sub-menu").hide(500);
            });

        });


        
    </script>

</head>

<body>

<!-- PARA QUE O USUARIO CLIQUE FORA E O MENU LATERAL SUMA -->
<div id="areaForaMenuLateral" onclick="fecharMenuLateral()"></div>

<nav id="menu"> 
    <?php
        if(isset($_SESSION['id']))
        {
            echo '<p id="saudacao_usuario"> Olá, '. $_SESSION['nome_usuario'] . '</p>';
        }
        else
        {
            header("Location: views/form_login.php");
        }
    ?>

    <?php
        if($_SESSION['administrador'])          //o usuário logado é admintrador?
        {
            //se sim tem essas opções no menu lateral
            echo '
            <ul class="menu-lateral">
                <li class="botao-fechar"><a onclick="fecharMenuLateral()">&times;</a></li>
  
                <li class="botao-menu"><a href="lojas.php"><img src="imagens/cursor2.cur">Consultar</a></li>

                <li class="botao-menu"><a><img src="imagens/cursor2.cur">Adicionar</a>
                    <ul class="sub-menu">

                        <li><a data-toggle="modal" data-target="#adicionarUsuario"">
                            <img src="imagens/cursor2.cur">Usuário</a>
                        </li>

                        <li> <a data-toggle="modal" data-target="#adicionarLoja">
                            <img src="imagens/cursor2.cur">Loja</a> 
                        </li>

                    </ul>
                </li>
                
                <li class="botao-menu"><a><img src="imagens/cursor2.cur">Excluir</a>
                    <ul class="sub-menu">
                        <li> <a data-toggle="modal" data-target="#deletarUsuario">
                            <img src="imagens/cursor2.cur">Usuário</a>
                        </li>

                        <li> <a data-toggle="modal" data-target="#deletarLoja">
                            <img src="imagens/cursor2.cur">Loja</a> 
                        </li>
                    </ul>
                </li>
                
                <li class="botao-menu"><a><img src="imagens/cursor2.cur">Alterar</a>
                    <ul class="sub-menu">

                        <li><a data-toggle="modal" data-target="#alterarUsuario">
                            <img src="imagens/cursor2.cur">Usuário</a>
                        </li>

                        <li><a data-toggle="modal" data-target="#alterarLoja">
                            <img src="imagens/cursor2.cur">Loja</a>
                        </li>
                        
                    </ul>
                </li>

                <li class="botao-menu"><a href="views/form_login.php"><img src="imagens/cursor2.cur">Sair</a></li>
            </ul>';
        }
        if(!$_SESSION['administrador'])         //é um colobarador normal?
        {
            //somente poderá fazer consulta nas lojas
            echo 
              '<ul class="menu-lateral">
                <li class="botao-fechar"><a onclick="fecharMenuLateral()">&times;</a></li>
                <li class="botao-menu"><a href="">Consultar</a></li>
                <li class="botao-menu"><a href="views/form_login.php">Sair</a></li>
              </ul>';
        }
    ?>
</nav>
<?php 
    {
        if(isset($_POST))
        {
            if(@!is_null($ob_usuarios->status) && @$ob_usuarios->status == true)
            {
                echo
                '
                <div class="msgStatus">
                    <div class="alert alert-success">
                        <span>';
                        echo @$ob_usuarios->msg;

                    echo'
                        </span>
                    </div>
                </div>';
                @$ob_usuarios->status = null;
            }
            else if(@!is_null($ob_usuarios->statu) && @$ob_usuarios->status == false)
            {
                echo
                '
                <div class="msgStatus">
                    <div class="alert alert-danger">
                        <span id="msg">';
                        echo @$ob_usuarios->msg;
                    echo
                        '</span>
                    </div>
                </div>';
                @$ob_usuarios->status = null;
            }

            else if(@!is_null($ob_lojas->status) && @$ob_lojas->status == true)
            {
                echo
                '
                <div class="msgStatus">
                    <div class="alert alert-success">
                        <span>';
                        echo @$ob_lojas->msg;

                    echo'
                        </span>
                    </div>
                </div>';
                @$ob_lojas->status = null;
            }
            else if(@!is_null($ob_lojas->status) && @$ob_lojas->status == false)
            {
                echo
                '
                <div class="msgStatus">
                    <div class="alert alert-danger">
                        <span id="msg">';
                        echo @$ob_lojas->msg;
                    echo
                        '</span>
                    </div>
                </div>';
                @$ob_lojas->status = null;
            }
        }
    }
?>
<form method="post" action="javascript:enviarDados()">

        <header class="cabecalho-form">

            <div class="icon-menu">
                <i id="fabars" class="fa fa-bars" onclick="abrirMenuLateral()"></i>
                <span id="menuPrincipal" onclick="abrirMenuLateral()">Menu</span>
            </div>

            <!-- LOGO MOVIDA -->
            <figure class="logos">
                <img src="imagens/movida-logo.png" class="logo-movida">
                <img id="logo-pac" src="imagens/logo-pac-titulo.png" >
            </figure>   
            <!-- AREA PARA PESQUISA DA LOJA -->
            <div id="area-pesquisa">
                <select class="selectpicker" data-dropup-auto="false" data-size="1" data-live-search="true" data-width="80%" id="barraPesquisa" name="barraPesquisa">
                    <option data-hidden="true">Escolha uma loja</option>
                </select>

      <!--           <button class="btn btn-default dropdown-toggle" type="button" name="barraPesquisa" id="barraPesquisa" data-toggle="dropdown">
                    <span class="filter-option pull-left">Pesquise uma loja</span>
                    <span class="caret"></span>
                </button> -->
                
                <input type="submit" id="btnPesquisar" value="Pesquisar">
<!--                 <ul class="dropdown-menu" role="menu" id="dropDownMenu" aria-labelledby="barraPesquisa" name="barraPesquisa">
                    <input type="text" class="form-control" id="PesquisarLojaId" ng-model="searchTerm">
                </ul> -->
                <!--Auxilio para o a gente digitar o nome da loja -->
            </div>
        </header>
    <!-- AREA DAS INFORMAÇÔES DA LOJA -->
    <div id="formularios">
        <!-- INFORMAÇÕES A ESQUERDA -->
        <div id="inf-esquerda">
                <!--Informações do formulário da parte de retirada-->
            <table>
                <!-- Titutlo -->
                <th colspan="2"><h3 class="titulo-form">Dados retirada</h3></th>
                <!-- Endereço -->
                <tr>
                    <td valign="top"><label for="enderecoRet">Endereço:</label></td> <td><span id="enderecoRet" class="direita"></span></td>
                </tr>
                <!-- Bairro retirada -->
                <tr>
                    <td valign="top"><label for="bairroRet">Bairro:</label></td> <td><span id="bairroRet" class="direita"></span></td>
                </tr>
                <!-- Horário retirada -->
                <tr>
                    <td valign="top"><label for="horarioRet">Horário:</label></td> <td><span id="horarioRet" class="direita"></span></td>
                </tr>
                <!-- Telefone retirada -->
                <tr>
                    <td valign="top"><label for="telefoneRet">Telefone:</label></td> <td><span id="telefoneRet" class="direita"></span></td>
                </tr>
                <!-- Email da loja -->
                <tr>
                    <td valign="top"><label for="emailRet">Email:</label></td> <td><span id="emailRet" class="direita"></span></td>
                </tr>
                <!-- Ponto de referencia retirada -->
                <tr>
                    <td><label for="pontoReferenciaRet" id="refRet">Referencia:</label></td> 
                    <tr>
                        <td colspan="2"><textarea class="pontoReferenciasRet" readonly></textarea></td>
                    </tr>
                 </tr>
                 <!-- Google Maps -->
                <tr>
                    <td colspan="2" align="center"><div id="map-esquerda"></div></td>
                </tr>
            </table>
        </div>

        <!--INFORMAÇÕES NO CENTRO  -->
        <div id="inf-direita">

            <!--Informações do formulário da parte de devolução-->
            <table>
                <!-- Titulo -->
                <th colspan="2"><h3 class="titulo-form">Dados devolução</h3></th>
                <tr>
                    <td valign="top"><label for="enderecoDev">Endereço:</label></td> <td><span id="enderecoDev" class="direita"></span></td>
                </tr>

                <tr>
                    <td valign="top"><label for="bairroDev">Bairro:</label></td> <td><span id="bairroDev" class="direita"></span></td>
                </tr>

                <tr>
                    <td  valign="top"><label for="horarioDev">Horário:</label></td> <td><span id="horarioDev" class="direita"></span></td>
                </tr>

                <tr>
                    <td  valign="top"><label for="telefoneDev">Telefone:</label></td> <td><span id="telefoneDev" class="direita"></span></td>
                </tr>

                <tr>
                    <td  valign="top"><label for="emailDev">Email:</label></td> <td><span id="emailDev" class="direita"></span></td>
                </tr>


                <div id="referenciasDev">
                    <tr>
                        <td><label for="pontoReferenciaDev" id="refDev">Referencia:</label></td>
                    </tr>
                    <tr>
                        <td colspan="2"><textarea class="pontoReferenciasDev"></textarea></td>
                    </tr>
                </div>
                <tr>
                    <td colspan="2" align="center"><div id="map-direita"></div></td>
                </tr>
            </table>
        </div>

        <!--Descrição dos responsaveis da loja-->
        <div id="inf-responsaveis">

            <table>
                <!-- Titulo -->
                <th> <h3 class="titulo-form">Responsaveis Loja</h3></th>
                
                <!-- Supervisor -->
                <tr>
                    <td valign="top"><label for="supervisor">Supervisor:</label></td> 
                </tr>
                <tr>
                    <td><span id="supervisor"></span></td>
                </tr>
                <!-- Gerente Regional -->
                <tr>
                    <td valign="top"><label for="gerenteRegional">Regional:</label></td>
                </tr>
                <tr>
                    <td valign="top"><span id="gerenteRegional"></span></td>
                </tr>
                <!-- Lider da loja -->
                <tr>
                    <td><label for="Lider">Lider:</label></td>
                </tr>
                <tr>
                    <td><span id="lider"></span></td>
                </tr>
                <!-- Disponibilidade -->
                <tr>
                    <td><label for="disponibilidade">Disponibilidade:</label>
                </tr>
                <tr>
                    <td><span id="disponibilidade"></span></td>
                </tr>

            </table>
        </div>
    </div>
</form>
    
    <script>
        $(document).ready(function(){
            function abrir_subMenu()
            {
                $(".sub-menu").show(1000);
            }

            function fechar_subMenu()
            {
                $(".sub-menu").hide(1000);
            }
        });
    </script>

    <script>
        $(document).ready(function(){

            $("#menuPrincipal").click(function(e){
                e.stopPropagation();
            });

             $("#fabars").click(function(e){
                e.stopPropagation();
            });

            $("form").click(function(e){
                $("#menu").css("width", "0");
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            var barraPesquisa = document.getElementById("btnPesquisar");
            barraPesquisa.setAttribute("disabled", "");

            $(".cabecalho-form").hide(1).delay(1000).fadeIn();

            $.ajax({
                type: "POST",
                data: {filtraLoja: ""},
                url: "pegarNomeTodasLojas.php",
                dataType: "json",

                success: function(data)
                {
                    var select = document.getElementById("barraPesquisa");

                    for(k in data)
                    {

                        option = document.createElement("option");

                        option.value = data[k]["nome_loja"];
                        option.text = data[k]["nome_loja"];

                        select.appendChild(option);
                    }
                    
                },
                error: function(xhr, desc, err)
                {
                    console.log(xhr.responseText);
                    console.log("Detalhes: " + desc + "Erro: " + err);
                }
            });

            $(document.body).on('click','.dropdown-menu.inner.selectpicker li', function () {
                var  btnPesquisar = document.getElementById("btnPesquisar");    
                btnPesquisar.removeAttribute("disabled");
            });
        });
    </script>



</body>

    <?php 
        include_once('javaScript/displayDadosLoja.php');                                   //Adicionando as configurações para quando for feita uma 
                                                                                           //busca apararecer os dados no navegador 

        include_once('javaScript/menuLateral.php');                                        //Adicionando as informações do menu lateral 
        
        include_once('views/modal/form_AdicionarUsuario.php');                             //Inclui o modal de adicionar usuário
        include_once('views/modal/form_AdicionarLoja.php');                                //Inclui o modal de adicionar Loja

        include('views/modal/form_DeletarUsuario.php');                               //Inclui o modal de deletar um usuário
        include('views/modal/form_DeletarLoja.php');                                  //Inclui o modal de deletar Loja

        include_once('views/modal/form_AlterarUsuario.php');                               //Inclui o modal de alterar usuário
        include_once('views/modal/form_AlterarLoja.php');                                  //Inclui o modal de alteração da loja
    ?>  
</html>