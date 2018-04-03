
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name= viewport content="width=device-width, initial-scale=1.0">
    <title>Login PAC</title>
    <!-- Estilo padrão da página de login -->
    <link rel="stylesheet" href="../css/estilo-login.css" />

    <!-- Scripts e css do bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Adicionando o fav icon da página -->
    <link rel="shortcut icon" href="../imagens/fav_icon.png">

    <script>
        
        $(document).ready(function(){
            //Se a página for recadado?
            if(performance.navigation.type == 1)                                                
            {
                window.location.href = "http://localhost/Projeto-Movida-/pacMovida/views/form_login.php";
            }
             //Página não tem nenhuma requisição de login ou esqueci minha senha?
            if(window.location.href === "http://localhost/Projeto-Movida-/pacMovida/views/form_login.php")     
            {
                $(".input-form").show();
                $("#campoEsqueciSenha").hide();
            }

            //Página fez uma requisição de esqueci minha senha e foi digitado um email valido?
            else if(window.location.href === "http://localhost/Projeto-Movida-/pacMovida/views/form_login.php?erroEmailEsqueci=false")
            {
                $(".input-form").hide();
                $("#campoEsqueciSenha").show();
            }

            //Página fez uma requisição de esqueci minha senha e NÃO foi digitado um email valido?
            else if(window.location.href === "http://localhost/Projeto-Movida-/pacMovida/views/form_login.php?erroEmailEsqueci=true")
            {
                $(".input-form").hide();
                $("#campoEsqueciSenha").show();
            }

            //Usuário tentou logar e digitou a senha ou o email de forma errada?
            else if(window.location.href === "http://localhost/Projeto-Movida-/pacMovida/views/form_login.php?erro=true" ||window.location.href === "http://localhost/pacMovida/views/form_login.php?erro=false")
            {
                $(".input-form").show();
                $("#campoEsqueciSenha").hide();
            }

            //Usuário clicou no paragrágo de esquci minha senha
            $("#esqueciSenha").click(function(){
                $(".input-form").hide(500);
                $("#campoEsqueciSenha").show(1000);
            });

            // Usuário clicou no botão de voltar
            $("#btnVoltarLoginID").click(function(){
                $("#campoEsqueciSenha").hide(500);
                $(".input-form").show(1000);
                $(".alert").hide(500);
            });

        });

    </script>
</head>
<body>
    
    <div class="container-login">


        <form id="formLogin" method="post" action="../validarLogin.php">
            <div id="imagens">
                <img id="movida-logo" src="../imagens/movida-logo.png" alt="Logo da Movida Aluguel de Carros"/>
                <img id="pac-logo" src="../imagens/logo-pac-titulo.png" alt="Logo do Pac - Plataforma de Apoio ao Colaborador"/><br>
            </div>
     
            <div class="input-form">
                <?php
                    if(isset($_GET['erro']))
                    {
                        echo '<span id="msgErro">Email ou Senha errada</span>';
                    }
                ?>
                <input type="email" name="nCaixaEmail"  id="caixaEmail" required="required"  placeholder="Email"/><br>
                <input type="password" name="nCaixaSenha" id="caixaSenha" required="required" placeholder="Senha"/>
                <p><input type="submit" id="btnLogin" value="Login"/></p>
                <p id="esqueciSenha">Esqueceu sua senha?</p>
            </div>
        </form>

        <div id="campoEsqueciSenha">
            <form id="esqueciMinhaSenha" method="POST" action="../redefinir_Senha.php">
                <div class="container-esqueci-senha">
                    <?php 
                        //Existe uma requisição de esqueci senha?
                        if(isset($_GET['erroEmailEsqueci']))                                                     
                        {
                            $validarErro = $_GET['erroEmailEsqueci'];

                             //Digitou um email não existente?
                            if($validarErro == 'true')                                                          
                            {
                                echo '<div class="alert alert-danger">
                                        <strong>Falha!</strong> Email digitado não existe
                                     </div>';
                            }
                            if($validarErro == 'false')
                            {
                                echo '<div class="alert alert-success">                            
                                        <strong>Sucesso!</strong>Um email foi enviado para você com sua senha
                                      </div>';
                            }
                        }

                    ?>

                    <h2 id="tituloEsqueci">Esqueceu sua senha?</h2>
                    <p><input type="email" id="emailEsqueciSenhaID" name="emailEsqueciSenha" placeholder="Digite o email cadastrado" required></p>
                    <input type="submit" id="btnEsqueciSenhaID" class="btnEsqueciSenha" name="btnEsqueci" value="Enviar email" required>
                    <button type="button" id="btnVoltarLoginID" name="btnVoltarLogin">Voltar</button>
                </div>
            </form>
        </div>
    </div>
</body>



</html>