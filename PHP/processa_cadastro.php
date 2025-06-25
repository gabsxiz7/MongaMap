<?php
session_start();
include 'conexao.php';
//ENVIA O E-MAIL DE CONFIRMAÇÃO COM PHPMailer
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//RECEBE DADOS DO FORMULÁRIO
$nome     = trim($_POST['nome']);
$email    = trim($_POST['email']);
$telefone = trim($_POST['telefone']);
$senhaRaw = $_POST['senha'] ?? '';
$captcha  = $_POST['g-recaptcha-response'];

// Define o regex exatamente igual ao pattern
$regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&]).{8,}$/';
if (!preg_match($regex, $senhaRaw)) {
    echo "<script>
            alert('A senha deve ter no mínimo 8 caracteres, incluindo 1 maiúscula, 1 minúscula, 1 número e 1 símbolo.');
            window.history.back();
          </script>";
    exit;
}

$senhaHash = password_hash($senhaRaw, PASSWORD_DEFAULT);

//NORMALIZA O TELEFONE
$caractere = ["(", ")", "-", " "];
$telefones = str_replace($caractere, "", $telefone);

//VERIFICAÇÃO DO reCAPTCHA
if (!$captcha) {
    echo "<script> alert('⚠️ Confirme que você não é um robô!'); history.back(); </script>";
    exit;
}
//localhost----> 
//$secretKey = "6LeRF_oqAAAAAOtIYhuTAXzqEaPq5n5RQA39pgHS";

//dominio--->
$secretKey = "6LdLBFUrAAAAAErCdKfYZNdve3UHDIeEFlyO4Rp7";

$response      = file_get_contents(
    "https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$captcha}"
);
$responseKeys = json_decode($response, true);
if (!$responseKeys["success"]) {
    echo "<script> alert('❌ Falha na validação do CAPTCHA.'); history.back(); </script>";
    exit;
}

//PREPARA A CONSULTA PARA EVITAR DUPLICIDADE DE E-MAIL
$stmtValida = $conexao->prepare("SELECT cd_usuario FROM tb_usuario WHERE nm_email = ?");
$stmtValida->bind_param("s", $email);
$stmtValida->execute();
$stmtValida->store_result();
if ($stmtValida->num_rows > 0) {
    echo "<script>alert('Este e-mail já está cadastrado.'); history.back();</script>";
    exit;
}
$stmtValida->close();

//GERA HASH DA SENHA E O TOKEN DE VERIFICAÇÃO
$senhaHash     = password_hash($senhaRaw, PASSWORD_DEFAULT);
$tokenVerifica = bin2hex(random_bytes(16)); // ex: 32 chars hex
$tipo          = 'usuario';               // tipo de usuário

//INSERE NO BANCO (agora incluindo verificado e token_verificacao)
$sql = "
  INSERT INTO tb_usuario 
    (nm_usuario, nm_email, nr_telefone, nm_senha, tipo_usuario, verificado, token_verificacao) 
  VALUES 
    (?, ?, ?, ?, ?, 0, ?)
";
$stmt = $conexao->prepare($sql);
if (!$stmt) {
    die("Erro na preparação da query: " . $conexao->error);
}
$stmt->bind_param(
    "ssssss", 
    $nome, 
    $email, 
    $telefones, 
    $senhaHash, 
    $tipo, 
    $tokenVerifica
);

if (!$stmt->execute()) {
    die("Erro ao inserir usuário: " . $stmt->error);
}

//RECUPERA O ID GERADO (caso precise usar depois)
$id_usuario = $stmt->insert_id;
$stmt->close();

//MONTA O LINK DE CONFIRMAÇÃO (apontando para o confirmacion_email.php)
//localhost--->$linkConfirmacao = "http://localhost/MongaMap/confirmar_email.php?token={$tokenVerifica}";

//dominio
$linkConfirmacao = "https://mongamap.com.br/confirmar_email.php?token={$tokenVerifica}";

//var_dump($linkConfirmacao); 
//exit;

$mail = new PHPMailer(true);

try {
    // --- CONFIGURAÇÃO SMTP (exemplo com Gmail) ---
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'contato.equipe8bits@gmail.com';        // seu Gmail
    $mail->Password = 'spnj tgaw quag rwfc';               // senha de app, se tiver 2FA
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('contato.equipe8bits@gmail.com', 'MongaMap');
    $mail->addAddress($email, $nome);
    $mail->isHTML(true);
    $mail->Subject = 'Confirme seu cadastro no MongaMap';
    $mail->Body = "
        <p>Olá, <strong>{$nome}</strong>!</p>
        <p>Obrigado por se cadastrar no MongaMap. Para ativar sua conta, clique no link abaixo:</p>
        <p><a href='{$linkConfirmacao}'>Confirmar meu e-mail</a></p>
        <p>Se não foi você que se cadastrou, ignore esta mensagem.</p>
    ";

    $mail->send();

    //Avisa o usuário para confirmar o e-mail
    echo "<script>
            alert('Cadastro efetuado! Verifique seu e-mail para confirmar a conta.');
            window.location.href = '../cadastro.php';
          </script>";
    exit;

} catch (Exception $e) {
    echo "<script>
            alert('Erro ao enviar e-mail de confirmação: {$mail->ErrorInfo}');
            history.back();
          </script>";
    exit;
}

// Fecha conexão (opcional; o script já saiu antes)
$conexao->close();
?>
