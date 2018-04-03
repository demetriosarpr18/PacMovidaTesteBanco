<?php
    include_once 'conexaoBanco.php';                                                                    //colocando minha conexão com o banco de dados no php para conseguir acessa-lo

    if(isset($_POST['nCaixaEmail']))
    {
        $email = mysqli_real_escape_string($conn,$_POST['nCaixaEmail']);                                 //pegando o email digitado pelo usuário
    }
    if(isset($_POST['nCaixaSenha']))
    {
        $senha = mysqli_real_escape_string($conn, $_POST['nCaixaSenha']);                                //pegando o email digitado pelo usuário
    }

    if(isset($email, $senha))                                                                            //recebeu o email e a senha?
    {
        $sql = "select * from usuario where email_usuario='$email' and senha_usuario='$senha'";          //sql para requesitar a linha na qual o emaail foi digitado
        $resultado = mysqli_query($conn, $sql);

        $verificaResultado = mysqli_num_rows($resultado);                                                //verifica se houve algum tipo de resultado          
        
        if($verificaResultado > 0)                                                                       //recebeu algum resultado?
        {
            session_start();                                                                             //inicia uma sessão do usuário que será logado

            $row = mysqli_fetch_assoc($resultado);                                                       //coloca todos os resultados em um array que será a row

            //pegando os dados do usuário e colocando em variaveis global
            $_SESSION['id'] = $row['id_usuario'];                                   
            $_SESSION['nome_usuario'] = $row['nome_usuario'];
            $_SESSION['administrador'] = $row['administrador'];

            header("Location: lojas.php");                                                           //vai para a tela de consultar
            exit();
       }
       else                                                                                              //email não cadastrado?    
       {
            header("Location: views/form_login.php?erro=true");                                           //se o email ou senha estiver errado volta para o login
            exit();
        }
    }
 
?>
