<?php

    //conexão com o Oracle
    $conexao = oci_connect('movidasup', 'supadmin', 'localhost/xe');

    if (!$conexao) {
    $erro = oci_error();
    trigger_error(htmlentities($erro['message'], ENT_QUOTES), E_USER_ERROR);
    exit;
    }
    
    else{
        echo'Conexão bem sucedida!!!';
    }

    $stid = oci_parse($conexao, 'SELECT * FROM Cliente');
    oci_execute($stid);

    while (($row = oci_fetch_array($stid)) != false) {
        // Use the uppercase column names for the associative array indices
        echo "<br><br>";
        echo $row[0]."<br>";
        echo $row[1]."<br>"; //Seria melhor um for... porém criei só para teste
    }

    oci_free_statement($stid);
    oci_close($conexao);
