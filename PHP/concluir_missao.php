<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require 'conexao.php';

if (!isset($_SESSION['id'], $_GET['id_missao'])) {
  echo json_encode(['sucesso'=>false, 'erro'=>'Dados faltando']);
  exit;
}

$idUser   = (int)$_SESSION['id'];
$idMissao = (int)$_GET['id_missao'];

// 1) Marca como concluída
$sql1 = "
  INSERT INTO tb_usuario_missao (fk_usuario,fk_missao,concluida,data_conclusao)
  VALUES (?,?,1,NOW())
  ON DUPLICATE KEY UPDATE
    concluida = 1,
    data_conclusao = NOW()
";
$stmt1 = $conexao->prepare($sql1);
$stmt1->bind_param("ii", $idUser, $idMissao);
$stmt1->execute();

// 2) Recupera pontos da missão
$sqlP = "SELECT pontos FROM tb_missao WHERE id_missao = ?";
$stmtP = $conexao->prepare($sqlP);
$stmtP->bind_param("i", $idMissao);
$stmtP->execute();
$resP = $stmtP->get_result()->fetch_assoc();
$pontos = (int)$resP['pontos'];

// 3) Atualiza pontuação do usuário
$sql2 = "
  UPDATE tb_patente p
  SET p.nr_parente = p.nr_parente + ?
  WHERE p.fk_cd_usuario = ?
";
$stmt2 = $conexao->prepare($sql2);
$stmt2->bind_param("ii", $pontos, $idUser);
$stmt2->execute();

echo json_encode([
  'sucesso'       => true,
  'pontosGanhados'=> $pontos
]);
?>
