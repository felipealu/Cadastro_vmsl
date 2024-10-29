<?php

    $dbHost = 'LocalHost';
    $dbUsername = 'root';
    $dbPassword = 'admin';
    $dbName = 'qrvila';

    $conexao = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);

    // if($conexao->connect_error)
    // {
    //     echo "Erro";
    // }  
    // else
    // {
    //     echo "Conexão efetuada com sucesso";
    // } 

?>
