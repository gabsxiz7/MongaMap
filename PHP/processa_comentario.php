<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['id'])) {
    echo "<script>alert('Você precisa estar logado para comentar!'); history.back();</script>";
    exit();
}

$comentario = $_POST['comentario'];
$usuarioId = $_SESSION['id'];
$localId = 1; // por enquanto, fixo. Depois você pode adaptar para ser dinâmico.

if (empty($comentario)) {
    echo "<script>alert('Por favor, escreva um comentário!'); history.back();</script>";
    exit();
}
// Lista de palavras proibidas
$palavras_proibidas = [
    'palavrão1', 'palavrão2', 'burro', 'idiota', 'otario', 'palavrão', 'kaua fdp', 'fdp', 'bundda', 'sexo', 'transar', 'fdp', 'fuder', 'vsf', 'arrombado', 'tudo fraco', 'krl', 'boyceta', 'buceta',
    'bosta', 'merda', 'horrível', 'odiei', 'ameaça', 'merdinha', 'prr', 'fdp', 'crl', 'horrível',
];

// Checa se o comentário contém alguma palavra proibida
foreach ($palavras_proibidas as $proibida) {
    if (stripos($comentario, $proibida) !== false) {
        echo "<script>alert('Seu comentário contém palavras não permitidas. Por favor, corrija.'); history.back();</script>";
        exit();
    }
}

$sql = "INSERT INTO tb_comentario (ds_comentario, fk_cd_usuario, fk_cd_local)
        VALUES (?, ?, ?)";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("sii", $comentario, $usuarioId, $localId);

if ($stmt->execute()) {
    echo "<script>alert('✔ Comentário enviado com sucesso!'); window.location.href = '../comentarios.php';</script>";
} else {
    echo "<script>alert('Erro ao enviar comentário.'); history.back();</script>";
}
?>
