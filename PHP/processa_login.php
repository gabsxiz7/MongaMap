<?php

include 'conexao.php';

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

//verifica no banco de dados
$sql = "SELECT * FROM tb_usuario WHERE nm_email = '$email'";
$query = $conexao->query($sql);
$resultado = $query->fetch_assoc();

$email_banco = $resultado['nm_email'];
$senha_banco = $resultado['nm_senha'];

if ($resultado && $password == $resultado['nm_senha']) {
    session_start();
    $_SESSION['id'] = $resultado['cd_usuario'];
    header('location: ../index.php');
}else {
    echo "<script> alert('Usuario ou senha Invalida'); history.back(); </script>"; 
}


?>