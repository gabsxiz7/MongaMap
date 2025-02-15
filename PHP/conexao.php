<?php

    $dbHost = 'localhost';
    $dbUsername = 'gabs';
    $dbPassword = '';
    $Name = 'bd_mongamap';

    //Teste de Conectividade

    if($conexao->connect_errno)
    {
        echo "Erro";
    }

    else
    {
        echo "Conectado com Sucesso";
    }

?>