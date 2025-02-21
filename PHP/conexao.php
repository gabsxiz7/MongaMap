<?php

// Conectando no Banco de Dados

$servidor = 'localhost';
$usuario = 'root';
$senha = 'root';
$db = 'bd_mongamap';

$conexao = new mysqli($servidor, $usuario, $senha, $db);

if ($conexao ->connect_error){
    die('falha na conexão'. $conexao -> connect_error);
}
else{
    echo "✔ Conectado com Sucesso!";
}




?>