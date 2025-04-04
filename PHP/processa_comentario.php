<?php

include 'conexao.php';

$descricao = $_POST['descricao'];


$insert = $conexao->query("INSERT INTO tb_comentario VALUES ('null, $descricao')") or
    die($conexao->error);

// Executar o Insert no Banco de Dados

if ($conexao -> query($sql)){
    echo "<script> alert('✔ Inserido com Sucesso!'); history.back(); </script>";
}

else{
    echo "Falha na Conexão com o Banco de Dados";
}

?>