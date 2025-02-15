<?php

//Conectando no Banco de Dados

include 'conexao.php';

//Receber os Dados do Formulário

$nome = $_POST['nome'];
$email = $_POST ['email'];
$telefone = $_POST ['telefone'];
$senha = $_POST ['senha'];

$sql = "INSERT INTO tb_user VALUES (null, '$nome', '$email', '$telefone', '$senha')";


//Executar o Insert no Banco de Dados

if ($conexao -> query($sql)){
    echo "<script> alert('✔ Inserido com Sucesso!'); document.location.href = '../index.html' </script>";
}

else{
    echo "Falha na Conexão com o Banco de Dados";
}

header('location: ../gamificacao.html');

?>