<?php
session_start();
include 'conexao.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['erro' => 'Precisa estar logado']);
    exit();
}

if (!isset($data['comentario']) || !isset($data['reacao'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Dados inválidos']);
    exit();
}

$usuario = $_SESSION['id'];
$comentario = intval($data['comentario']);
$reacao = $data['reacao'];

// Segurança: só permite tipos válidos
$tipos_validos = ['like', 'dislike', 'smile'];
if (!in_array($reacao, $tipos_validos)) {
    http_response_code(400);
    echo json_encode(['erro' => 'Tipo de reação inválido']);
    exit();
}

// Permite apenas uma reação do usuário por comentário por tipo
$sql = "SELECT * FROM tb_reacao WHERE fk_cd_usuario = ? AND fk_cd_comentario = ? AND tp_reacao = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("iis", $usuario, $comentario, $reacao);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    // Já reagiu, remove (toggle)
    $sql = "DELETE FROM tb_reacao WHERE fk_cd_usuario = ? AND fk_cd_comentario = ? AND tp_reacao = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("iis", $usuario, $comentario, $reacao);
    $stmt->execute();
    $msg = "Reação removida";
} else {
    // Adiciona reação
    $sql = "INSERT INTO tb_reacao (fk_cd_usuario, fk_cd_comentario, tp_reacao) VALUES (?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("iis", $usuario, $comentario, $reacao);
    $stmt->execute();
    $msg = "Reação registrada";
}

// Conta total de cada reação
$sql = "SELECT tp_reacao, COUNT(*) as total FROM tb_reacao WHERE fk_cd_comentario = ? GROUP BY tp_reacao";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $comentario);
$stmt->execute();
$res = $stmt->get_result();

$totais = ['like' => 0, 'dislike' => 0, 'smile' => 0];
while ($row = $res->fetch_assoc()) {
    if (isset($row['tp_reacao']) && isset($row['total'])) {
        $totais[$row['tp_reacao']] = $row['total'];
    }
}

echo json_encode(['mensagem' => $msg, 'totais' => $totais]);
