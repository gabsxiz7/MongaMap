<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['sucesso'=>false, 'erro'=>'Usuário não está logado']);
    exit;
}

$idUsuario = (int) $_SESSION['id'];
$idLocal   = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if (!$idLocal) {
    http_response_code(400);
    echo json_encode(['sucesso'=>false, 'erro'=>'Parâmetro id inválido']);
    exit;
}

// quantos pontos esse QR dá (você pode variar por local se quiser)
$pontosGanhos = 100;

require_once __DIR__ . '/conexao.php';

// 1) Busca patente atual
$sql  = "SELECT cd_patente, nr_parente FROM tb_patente WHERE fk_cd_usuario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    // Se não houver ainda, cria um registro inicial
    $sqlIns = "INSERT INTO tb_patente (nm_patente, nr_parente, fk_cd_usuario) VALUES (?, ?, ?)";
    $nivelInit = 'Iniciante';
    $stmt2 = $conexao->prepare($sqlIns);
    $stmt2->bind_param("sii", $nivelInit, $pontosGanhos, $idUsuario);
    $stmt2->execute();
    $novoTotal = $pontosGanhos;
    $cdPatente = $stmt2->insert_id;
} else {
    // Atualiza
    $row       = $res->fetch_assoc();
    $cdPatente = (int)$row['cd_patente'];
    $novoTotal = (int)$row['nr_parente'] + $pontosGanhos;
}

// 2) Define nome da patente pelo total de pontos
function getPatenteName(int $pt): string {
    if ($pt >= 5000)  return 'Mestre do Mapa';
    if ($pt >= 2000)  return 'Aventureiro';
    if ($pt >= 1000)  return 'Explorador';
    return 'Iniciante';
}
$novaPatente = getPatenteName($novoTotal);

// 3) Grava no banco
$sqlUpd = "UPDATE tb_patente 
           SET nr_parente = ?, nm_patente = ?
           WHERE cd_patente = ?";
$stmt3 = $conexao->prepare($sqlUpd);
$stmt3->bind_param("isi", $novoTotal, $novaPatente, $cdPatente);
$stmt3->execute();
$sqlVis = "
  INSERT IGNORE INTO tb_usuario_local (fk_usuario, fk_local, data_visita)
  VALUES (?, ?, NOW())
";
$stmtVis = $conexao->prepare($sqlVis);
$stmtVis->bind_param("ii", $idUsuario, $idLocal);
$stmtVis->execute();

// 3.5) Marcar missão como concluída se existir missão para esse local
$sqlMissao = "SELECT id_missao FROM tb_missao WHERE fk_local = ?";
$stmtMissao = $conexao->prepare($sqlMissao);
$stmtMissao->bind_param("i", $idLocal);
$stmtMissao->execute();
$resMissao = $stmtMissao->get_result();

if ($rowMissao = $resMissao->fetch_assoc()) {
    $idMissao = (int)$rowMissao['id_missao'];

    // Marca a missão como concluída para o usuário
    $sqlConcluir = "INSERT INTO tb_usuario_missao (fk_usuario, fk_missao, concluida, data_conclusao)
                    VALUES (?, ?, 1, NOW())
                    ON DUPLICATE KEY UPDATE concluida=1, data_conclusao=NOW()";
    $stmtConcluir = $conexao->prepare($sqlConcluir);
    $stmtConcluir->bind_param("ii", $idUsuario, $idMissao);
    $stmtConcluir->execute();
}

// 4) Retorna JSON
echo json_encode([
    'sucesso'      => true,
    'pontosGanhos' => $pontosGanhos,
    'total'        => $novoTotal,
    'patente'      => $novaPatente
]);
exit;
?>
