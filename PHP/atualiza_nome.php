<?php
// php/atualiza_nome.php
session_start();
require_once __DIR__ . '/conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Você não está logado!'); window.location.href='../login.php';</script>";
    exit();
}

$idUsuario = (int)$_SESSION['id'];

// Verifica se o nome foi enviado
if (!isset($_POST['novoNome']) || trim($_POST['novoNome']) === '') {
    echo "<script>alert('Nome inválido.'); window.history.back();</script>";
    exit();
}

$novoNome = trim($_POST['novoNome']);
if (strlen($novoNome) < 3 || strlen($novoNome) > 50) {
    echo "<script>alert('O nome deve ter entre 3 e 50 caracteres.'); window.history.back();</script>";
    exit();
}

// Atualiza o nome no banco (campo nm_usuario em tb_usuario)
$sql  = "UPDATE tb_usuario SET nm_usuario = ? WHERE cd_usuario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("si", $novoNome, $idUsuario);

if ($stmt->execute()) {
    echo "<script>alert('Nome atualizado com sucesso!'); window.location.href='../gamificacao.php';</script>";
} else {
    echo "<script>alert('Erro ao atualizar nome no banco.'); window.history.back();</script>";
}

$stmt->close();
$conexao->close();
?>
