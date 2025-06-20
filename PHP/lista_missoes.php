<?php
header('Content-Type: application/json; charset=utf-8');
session_start();
require 'conexao.php';

if (!isset($_SESSION['id'])) {
  echo json_encode(['erro'=>'Usuário não está logado']);
  exit;
}

$idUser = (int)$_SESSION['id'];

$sql = "
  SELECT
    m.id_missao,
    m.nm_missao,
    m.pontos,
    IFNULL(um.concluida,0) AS concluida
  FROM tb_missao m
  LEFT JOIN tb_usuario_missao um
    ON um.fk_missao = m.id_missao
   AND um.fk_usuario = ?
  ORDER BY m.id_missao
";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $idUser);
$stmt->execute();
$res = $stmt->get_result();

$missoes = [];
while ($r = $res->fetch_assoc()) {
  $missoes[] = [
    'id'        => (int)$r['id_missao'],
    'nome'      => $r['nm_missao'],
    'pontos'    => (int)$r['pontos'],
    'concluida' => (bool)$r['concluida']
  ];
}

echo json_encode(['sucesso'=>true,'missoes'=>$missoes]);
exit;
?>