<?php
header('Content-Type: application/json; charset=utf-8');
session_start();
require_once 'conexao.php';

if (!isset($_SESSION['id'])) {
  echo json_encode([
    'sucesso' => false,
    'erro'    => 'Usuário não logado'
  ]);
  exit;
}
$id_usuario = (int) $_SESSION['id'];

// 1) FOTO
$sql = "SELECT nm_foto FROM tb_usuario WHERE cd_usuario = ?";
$stmt = $conexao->prepare($sql);
if (!$stmt) { echo json_encode(['sucesso'=>false,'erro'=>$conexao->error]); exit; }
$stmt->bind_param("i",$id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// 2) PONTOS
$sql = "SELECT nr_parente AS pontos FROM tb_patente WHERE fk_cd_usuario = ?";
$stmt = $conexao->prepare($sql);
if (!$stmt) { echo json_encode(['sucesso'=>false,'erro'=>$conexao->error]); exit; }
$stmt->bind_param("i",$id);
$stmt->execute();
$pts = $stmt->get_result()->fetch_assoc()['pontos'] ?? 0;

// 3) CONQUISTAS
$sql = "SELECT nm_conquista AS nome, nr_pontos_conquista AS pontos
        FROM tb_conquista
        WHERE fk_cd_usuario = ?
        ORDER BY cd_conquista DESC LIMIT 5";
$stmt = $conexao->prepare($sql);
if (!$stmt) { echo json_encode(['sucesso'=>false,'erro'=>$conexao->error]); exit; }
$stmt->bind_param("i",$id);                  // <-- **Esquecer esse bind era o bug**
$stmt->execute();
$res = $stmt->get_result();
$conqs = [];
while($r = $res->fetch_assoc()) $conqs[] = $r;

// 4) VISITAS
$sql = "SELECT fk_local FROM tb_usuario_local WHERE fk_usuario = ?";
$stmt = $conexao->prepare($sql);
if (!$stmt) { echo json_encode(['sucesso'=>false,'erro'=>$conexao->error]); exit; }
$stmt->bind_param("i",$id);
$stmt->execute();
$res = $stmt->get_result();
$vis = [];
while($r = $res->fetch_assoc()) $vis[] = (int)$r['fk_local'];

echo json_encode([
  'sucesso'    => true,
  'id'         => $id_usuario,
  'foto'       => $user['nm_foto'],
  'pontos'     => $pts,
  'conquistas' => $conqs,
  'visitas'    => $vis
]);
exit;
