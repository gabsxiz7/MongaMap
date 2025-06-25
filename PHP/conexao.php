<?php

// Conectando no Banco de Dados

$servidor = $_SERVER['HTTP_HOST'] =='localhost' ? 'localhost' : 'mysql.mongamap.com.br';
$usuario = $_SERVER['HTTP_HOST'] == 'localhost' ? 'root': 'mongamap';
$senha = $_SERVER['HTTP_HOST'] == 'localhost' ? '': 'TccProjetoEtec2025';
$db = $_SERVER['HTTP_HOST'] == 'localhost' ? 'bd_mongamap' : 'mongamap';


//$servidor = 'mysql.mongamap.com.br';
//$usuario = 'mongamap';
//$senha = 'TccProjetoEtec2025';
//$db = 'mongamap';

$conexao = new mysqli($servidor, $usuario, $senha, $db);
$conexao->set_charset("utf8mb4"); 

//verifica erro
if ($conexao->connect_error) {
    die("Erro ao conectar com o banco de dados: " . $conexao->connect_error);
}

?>