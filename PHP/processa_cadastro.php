
<?php

//Conectando no Banco de Dados

include 'conexao.php';

//Receber os Dados do Formulário

$nome = $_POST['nome'];
$email = $_POST ['email'];
$telefone = $_POST ['telefone'];
$senha = $_POST ['senha'];
$captcha = $_POST['g-recaptcha-response'];

$caracte = ["(",")","-"," "];
$telefones = str_replace($caracte, "", $telefone);


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


// Executar o Insert no Banco de Dados

$sql = "INSERT INTO tb_usuario VALUES (null, '$nome', '$email', '$telefones', '$senha')";

if ($conexao -> query($sql)){
    echo "<script> alert('✔ Cadastro realizado com Sucesso!'); document.location.href = '../inicio.php' </script>";
}

else{
    echo "<script> alert('❌ Erro ao cadastrar.'); history.back(); </script>";
}

?>