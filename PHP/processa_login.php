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
$sql = "SELECT cd_usuario, nm_usuario, ds_descricao, nm_foto, nm_senha, tipo_usuario FROM tb_usuario WHERE nm_email = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result()->fetch_assoc();

if (!$resultado) {
    echo "<script> alert('❌ Usuário não encontrado!'); history.back(); </script>";
    exit;
}


// Verifica a senha de forma segura
if (password_verify($password, $resultado['nm_senha'])) {
    $_SESSION['id'] = $resultado['cd_usuario'];
    $_SESSION['nome'] = $resultado['nm_usuario'];
    $_SESSION['descricao'] = $resultado['ds_descricao'];
    $_SESSION['foto'] = $resultado['nm_foto'];
    $_SESSION['tipo_usuario'] = $resultado['tipo_usuario'];

    
    
    header('location: ../index.php');
    exit;
} else {
    echo "<script> alert('❌ Usuário ou senha inválida!'); history.back(); </script>";
    exit;
}

$stmt->close();
$conexao->close();
?>

