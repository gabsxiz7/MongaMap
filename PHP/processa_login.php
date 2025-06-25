<?php
include 'conexao.php';
session_start();

$email = trim($_POST['email']);
$senhaRaw = $_POST['senha'];
$captcha = $_POST['g-recaptcha-response'];

//verificar se o reCAPTCHA foi resolvido
if (!$captcha) {
    echo "<script> alert('⚠️ Confirme que você não é um robô!'); history.back(); </script>";
    exit;
}

//validar reCAPTCHA com a API do Google localhost
//localhost--> $secretKey = "6LeRF_oqAAAAAOtIYhuTAXzqEaPq5n5RQA39pgHS";
//dominio--->
$secretKey = "6LdLBFUrAAAAAErCdKfYZNdve3UHDIeEFlyO4Rp7";

$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha");
$responseKeys = json_decode($response, true);
if (!$responseKeys["success"]) {
    echo "<script> alert('❌ Falha na validação do CAPTCHA.'); history.back(); </script>";
    exit;
}

//Buscar usuário pelo e-mail, obtendo senha e status de verificação
$stmt = $conexao->prepare("
    SELECT cd_usuario, nm_senha, verificado, nm_usuario, ds_descricao, nm_foto, tipo_usuario
      FROM tb_usuario
     WHERE nm_email = ?
     LIMIT 1
");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    // Não encontrou usuário com esse e-mail
    echo "<script>alert('Credenciais inválidas.'); history.back();</script>";
    exit;
}

// Vincula as colunas retornadas a variáveis
$stmt->bind_result(
    $idUsuario,
    $senhaHashBanco,
    $verificadoBanco,
    $nomeUsuario,
    $descricaoUsuario,
    $fotoUsuario,
    $tipoUsuario
);
$stmt->fetch();
$stmt->close();

//verificar se o e-mail já foi confirmado
if ($verificadoBanco == 0) {
    echo "<script>
            alert('Antes de entrar, confirme seu e-mail. Verifique a caixa de entrada.');
            window.location.href = '../cadastro.php';
          </script>";
    exit;
}

//validar a senha com password_verify
if (!password_verify($senhaRaw, $senhaHashBanco)) {
    echo "<script>alert('Credenciais inválidas.'); history.back();</script>";
    exit;
}

//se chegou aqui, tudo OK: cria a sessão com os dados necessários
$_SESSION['id']          = $idUsuario;
$_SESSION['email']       = $email;
$_SESSION['nome']        = $nomeUsuario;
$_SESSION['descricao']   = $descricaoUsuario;
$_SESSION['foto']        = $fotoUsuario;
$_SESSION['tipo_usuario']= $tipoUsuario;

//redireciona para a área interna (por exemplo, gamificacao.php)
header("Location: ../gamificacao.php");
exit;
?>

