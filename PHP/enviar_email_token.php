<?php
include 'conexao.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$email = $_POST['email'];
$stmt = $conexao->prepare("SELECT cd_usuario FROM tb_usuario WHERE nm_email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('E-mail não encontrado.'); history.back();</script>";
    exit;
}

$usuario = $result->fetch_assoc();
$cd_usuario = $usuario['cd_usuario'];
$token = bin2hex(random_bytes(32));
$expiracao = date("Y-m-d H:i:s", strtotime("+1 hour"));

$stmt = $conexao->prepare("INSERT INTO tb_token_redefinicao (cd_usuario, token, data_expiracao) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $cd_usuario, $token, $expiracao);
$stmt->execute();

// CONFIGURAR PHPMailer
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'gabscostuda10@gmail.com'; // <-- seu email aqui
    $mail->Password = 'ckpplcrgwjjnskie';        // <-- senha de app aqui
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('gabscostuda10@gmail.com', 'MongaMap');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Redefinir Senha - MongaMap';
    $link = "http://localhost/MongaMap/php/redefinir_senha.php?token=$token";
    $mail->Body = "<p>Olá! Clique no link abaixo para redefinir sua senha:</p><a href='$link'>$link</a>";

    $mail->send();
    echo "<script>alert('Link enviado! Verifique seu e-mail.'); window.location.href = '../index.php';</script>";
} catch (Exception $e) {
    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
}
?>
