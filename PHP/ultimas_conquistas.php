<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

if (!isset($_SESSION['id'])) {
  http_response_code(401);
  echo json_encode(['sucesso'=>false,'erro'=>'Não logado']);
  exit;
}

require __DIR__.'/conexao.php';
$id = (int)$_SESSION['id'];

// busca as últimas 5 visitas/comquistas
$sql = "
  SELECT l.nm_local AS nome, 100 AS pontos
  FROM tb_usuario_local ul
  JOIN tb_local l ON ul.fk_local = l.cd_local
  WHERE ul.fk_usuario = ?
  ORDER BY ul.data_visita DESC
  LIMIT 5
";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i",$id);
$stmt->execute();
$res = $stmt->get_result();

$conquistas = [];
while($row = $res->fetch_assoc()){
  $conquistas[] = [
    'nome'   => $row['nome'],
    'pontos' => $row['pontos']
  ];
}

echo json_encode(['sucesso'=>true,'conquistas'=>$conquistas]);
exit;
?>