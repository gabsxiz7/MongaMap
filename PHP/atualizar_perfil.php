<?php
include 'conexao.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

$id = $_SESSION['id'];
$nome = $_POST['nome'];
$descricao = $_POST['descricao'];

$foto = $_FILES['foto'];
$nomeFoto = "";

//se tiver imagem nova enviada
if ($foto['error'] === 0 && $foto['size'] > 0) {
    $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);
    $nomeFoto = uniqid() . "." . $ext;
    move_uploaded_file($foto['tmp_name'], "../IMG/" . $nomeFoto);
}

//monta SQL com ou sem imagem
if ($nomeFoto) {
    $sql = "UPDATE tb_usuario SET nm_usuario=?, ds_descricao=?, nm_foto=? WHERE cd_usuario=?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssi", $nome, $descricao, $nomeFoto, $id);
} else {
    $sql = "UPDATE tb_usuario SET nm_usuario=?, ds_descricao=? WHERE cd_usuario=?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssi", $nome, $descricao, $id);
}

$stmt->execute();
$stmt->close();

header("Location: ../gamificacao.php");
exit();
?>
