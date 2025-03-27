<?php

include 'conexao.php';
session_start();

$email = $_POST['email'];
$password = $_POST['senha'];
$captcha = $_POST['g-recaptcha-response'];

// Verificar se o reCAPTCHA foi resolvido
if (!$captcha) {
    echo "<script> alert('⚠️ Confirme que você não é um robô!'); history.back(); </script>";
    exit;
}

// Validar reCAPTCHA com a API do Google
$secretKey = "6LeRF_oqAAAAAOtIYhuTAXzqEaPq5n5RQA39pgHS";
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha");
$responseKeys = json_decode($response, true);
 
if (!$responseKeys["success"]) {
    echo "<script> alert('❌ Falha na validação do CAPTCHA.'); history.back(); </script>";
    exit;
}

// Prepara a consulta SQL para evitar SQL Injection
$sql = "SELECT cd_usuario, nm_senha FROM tb_usuario WHERE nm_email = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result()->fetch_assoc();

<<<<<<< HEAD
if (!$resultado) {
    echo "<script> alert('❌ Usuário não encontrado!'); history.back(); </script>";
    exit;
=======
$email_banco = $resultado['nm_email'];
$senha_banco = $resultado['nm_senha'];

if ($resultado && $password == $resultado['nm_senha']) {
    session_start();
    $_SESSION['id'] = $resultado['cd_usuario'];
    header('location: ../inicio.php');
}else {
    echo "<script> alert('Usuario ou senha Invalida'); history.back(); </script>"; 
>>>>>>> 1d11af47a83da4dcabcbc5178a600adc856a13b3
}


// Verifica a senha de forma segura
if (password_verify($password, $resultado['nm_senha'])) {
    $_SESSION['id'] = $resultado['cd_usuario'];
    header('location: ../index.php');
    exit;
} else {
    echo "<script> alert('❌ Usuário ou senha inválida!'); history.back(); </script>";
    exit;
}

$stmt->close();
$conexao->close();
?>