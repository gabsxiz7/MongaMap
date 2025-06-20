<?php
session_start();
require_once __DIR__ . '/conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Você não está logado!'); window.location.href='../login.php';</script>";
    exit();
}

$idUsuario = (int)$_SESSION['id'];

// Verifica se veio arquivo no POST
if (!isset($_FILES['novaFoto']) || $_FILES['novaFoto']['error'] !== UPLOAD_ERR_OK) {
    echo "<script>alert('Erro ao enviar arquivo. Tente novamente.'); window.history.back();</script>";
    exit();
}

$foto = $_FILES['novaFoto'];

// Extensões permitidas
$extensoesPermitidas = ['jpg','jpeg','png','gif'];
$nomeOriginal = $foto['name'];
$ext = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));

if (!in_array($ext, $extensoesPermitidas)) {
    echo "<script>alert('Formato inválido. Envie JPG, PNG ou GIF.'); window.history.back();</script>";
    exit();
}

// Cria um nome único para evitar conflitos (ex: usuario5_1627384953.jpg)
$novoNome = 'usuario' . $idUsuario . '_' . time() . '.' . $ext;
$caminhoDestino = __DIR__ . '/../IMG/' . $novoNome;

// Move o arquivo para a pasta IMG/
if (!move_uploaded_file($foto['tmp_name'], $caminhoDestino)) {
    echo "<script>alert('Falha ao salvar a imagem.'); window.history.back();</script>";
    exit();
}

// Atualiza o nome da foto no banco (campo nm_foto em tb_usuario)
$sql  = "UPDATE tb_usuario SET nm_foto = ? WHERE cd_usuario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("si", $novoNome, $idUsuario);
if ($stmt->execute()) {
    // Se quiser apagar a foto antiga para não acumular, você pode:
    // 1) Buscar o nome antigo antes de atualizar, 2) unlink(__DIR__.'/../IMG/'.$nomeAntigo);
    echo "<script>alert('Foto atualizada com sucesso!'); window.location.href='../gamificacao.php';</script>";
} else {
    echo "<script>alert('Erro ao atualizar banco.'); window.history.back();</script>";
}

$stmt->close();
$conexao->close();
?>
