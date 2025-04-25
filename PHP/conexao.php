<?php

// Conectando no Banco de Dados

$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$db = 'bd_mongamap';

$conexao = new mysqli($servidor, $usuario, $senha, $db);

//verifica erro
if ($conexao->connect_error) {
    die("Erro ao conectar com o banco de dados: " . $conexao->connect_error);
}

?>