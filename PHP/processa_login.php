<?php

include 'conexao.php';

$email = $_POST['email'];
$password = $_POST['senha'];
 
$sql = "SELECT * FROM tb_usuario WHERE nm_email = '$email'";

$query = $conexao->query($sql);

$resultado = $query->fetch_assoc();

$email_banco = $resultado['email'];
$senha_banco = $resultado['senha'];

if ($email == $email_banco &&  $password == $senha_banco) {
    session_start();
    $_SESSION['id'] = $resultado['cd_usuario'];
    header('location: ../index.php');
}else {
    echo "<script> alert('Usuario ou senha Invalida'); history.back(); </script>"; 
}


?>