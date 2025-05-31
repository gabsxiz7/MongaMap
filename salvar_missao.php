// salvar_missao.php
<?php
include 'conexao.php';
session_start();

$dados = json_decode(file_get_contents("php://input"), true);
$id_usuario = $_SESSION['id'];
$nome_missao = $dados['missao'] ?? '';
$pontos = intval($dados['pontos'] ?? 0);

// Salva a conquista
$stmt = $conexao->prepare("INSERT INTO tb_conquista (nm_conquista, nr_pontos_conquista, fk_cd_usuario) VALUES (?, ?, ?)");
$stmt->bind_param("sii", $nome_missao, $pontos, $id_usuario);
$stmt->execute();

// Atualiza os pontos na tabela de patente
$stmt = $conexao->prepare("UPDATE tb_patente SET nr_parente = nr_parente + ? WHERE fk_cd_usuario = ?");
$stmt->bind_param("ii", $pontos, $id_usuario);
$stmt->execute();

echo json_encode(['sucesso' => true]);
?>
