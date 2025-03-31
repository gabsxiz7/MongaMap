
<?php

//Conectando no Banco de Dados

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


//inserir usuário no banco de dados usando Prepared Statement
$sql = "INSERT INTO tb_usuario (nm_usuario, nm_email, nr_telefone, nm_senha) VALUES (?, ?, ?, ?)";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ssss", $nome, $email, $telefones, $senhaHash);


if ($stmt->execute()) {
    echo "<script> alert('✔ Cadastro realizado com sucesso!'); document.location.href = '../index.php'; </script>";
} else {

    echo "<script> alert('❌ Erro ao cadastrar.'); history.back(); </script>";
}

$stmt->close();
$conexao->close();
?>


<!--//evita sql Injection --- prepare() e bind_param()
evita erro ao acesar um usuario inexistente
compara senhas com seguranca utilizando password_verify()
criptografa senha com password_hash()*/