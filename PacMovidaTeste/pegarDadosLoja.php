<?php

    $infoLoja = array();                                                        //para armazenar as informações da loja

    if(isset($_GET['barraPesquisa']))
    {
        $loja = $_GET["barraPesquisa"];                                         //recebe via ajax o que foi digitado pelo método POST
    }else
    {
        echo json_encode(array('status' => 'erro'));                            //retornar erro se não recebeu nada
    }

    $conn = new mysqli("localhost", "root" , "", "pac");                        //abre a conexão com o banco de dados


    if($conn->connect_error)                                                    //erro ao abrir o banco?
    {
        die("Connection failed: " . $conn->connect_error);                      //encerra e mostra o erro
    }

    $result = $conn->query("select * from loja where nome_loja='$loja'");       // pega os dados da determinada loja digitada e coloca em um resultado

    if($result->num_rows > 0)                                                   //algum dado retornado?
    {

        while($row = $result->fetch_assoc())
        {
            array_push($infoLoja, $row);                                        //coloca cada coluna retornada no array;
        }

    }
    else
    {
        echo false;                                                             //Não teve retorno do banco de dados
    }

    echo json_encode($infoLoja);                                                //envia o array para o lado do cliente

?>
