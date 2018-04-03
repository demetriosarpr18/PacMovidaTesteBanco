<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name= viewport content="width=device-width, initial-scale=1.0">
    <title>Login PAC</title>
    <link rel="stylesheet" href="css/estilo-login.css" />
</head>
<body>
    
    <div class="container-login">


        <form id="formLogin" method="post" action="validarLogin.php">
            <div id="imagens">
                <img id="movida-logo" src="imagens/movida-logo.png" alt="Logo da Movida Aluguel de Carros"/>
                <img id="pac-logo" src="imagens/logo-pac-titulo.png" alt="Logo do Pac - Plataforma de Apoio ao Colaborador"/><br>
            </div>
                <?php
                    if(isset($_GET['erro']))
                    {
                        echo '<span id="msgErro">Email ou Senha errada</span>';
                    }
                ?>
            <div class="input-form">
                <input type="email" name="nCaixaEmail"  id="caixaEmail" required="required"  placeholder="Email"/><br>
                <input type="password" name="nCaixaSenha" id="caixaSenha" required="required" placeholder="Senha"/>
                <p><input type="submit" id="btnLogin" value="Login"/></p>
            </div>
        </form>

    </div>
</body>
</html>