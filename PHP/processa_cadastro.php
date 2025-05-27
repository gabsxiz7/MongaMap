<?php
//conectando no Banco de Dados
include 'conexao.php';
//Receber os Dados do Formulário

$nome = $_POST['nome'];
$email = $_POST ['email'];
$telefone = $_POST ['telefone'];
$senha = $_POST ['senha'];
$captcha = $_POST['g-recaptcha-response'];

$caractere = ["(", ")", "-", " "];
$telefones = str_replace($caractere, "", $telefone);


//só p verificar se o reCAPTCHA foi resolvido
if (!$captcha) {
    echo "<script> alert('⚠️ Confirme que você não é um robô!'); history.back(); </script>";
    exit;
}

//validar reCAPTCHA com a API do Google
$secretKey = "6LeRF_oqAAAAAOtIYhuTAXzqEaPq5n5RQA39pgHS";
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha");
$responseKeys = json_decode($response, true);

if (!$responseKeys["success"]) {
    echo "<script> alert('❌ Falha na validação do CAPTCHA.'); history.back(); </script>";
    exit;
}

//criptografar a senha antes de armazenar
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);


$tipo = 'usuario'; // define o tipo de usuário

$sql = "INSERT INTO tb_usuario (nm_usuario, nm_email, nr_telefone, nm_senha, tipo_usuario) 
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conexao->prepare($sql);

if (!$stmt) {
    die("Erro na preparação da query: " . $conexao->error);
}

$stmt->bind_param("sssss", $nome, $email, $telefones, $senhaHash, $tipo);



if ($stmt->execute()) {
    // Recupera o ID do usuário recém-cadastrado
    $id_usuario = $stmt->insert_id;

    // Inicia sessão e armazena dados na sessão
    session_start();
    $_SESSION['id'] = $id_usuario;
    $_SESSION['nome'] = $nome;
    $_SESSION['email'] = $email;

    // Redireciona para a home logado
    header("Location: ../index.php");
    exit();
}


$stmt->close();
$conexao->close();
?>


<!--//evita sql Injection --- prepare() e bind_param()
evita erro ao acesar um usuario inexistente
compara senhas com seguranca utilizando password_verify()
criptografa senha com password_hash()*/