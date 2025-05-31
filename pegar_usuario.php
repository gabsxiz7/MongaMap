// pegar_usuario.php
<?php
include 'conexao.php';
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['sucesso' => false, 'erro' => 'Usuário não logado']);
    exit();
}

$id_usuario = $_SESSION['id'];

// Dados do usuário
$sql_usuario = "SELECT nm_foto FROM tb_usuario WHERE cd_usuario = ?";
$stmt = $conexao->prepare($sql_usuario);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result_usuario = $stmt->get_result();
$usuario = $result_usuario->fetch_assoc();

// Pontuação
$sql_pontos = "SELECT nr_parente AS pontos FROM tb_patente WHERE fk_cd_usuario = ?";
$stmt = $conexao->prepare($sql_pontos);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result_pontos = $stmt->get_result();
$pontos = $result_pontos->fetch_assoc()['pontos'] ?? 0;

// Conquistas
$sql_conquistas = "SELECT nm_conquista AS nome, nr_pontos_conquista AS pontos FROM tb_conquista WHERE fk_cd_usuario = ? ORDER BY cd_conquista DESC LIMIT 5";
$stmt = $conexao->prepare($sql_conquistas);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result_conquistas = $stmt->get_result();
$conquistas = [];
while ($row = $result_conquistas->fetch_assoc()) {
    $conquistas[] = $row;
}

// Visitas (simulação)
$visitas = []; // você pode popular com dados reais futuramente

echo json_encode([
    'sucesso' => true,
    'foto' => $usuario['nm_foto'],
    'pontos' => $pontos,
    'conquistas' => $conquistas,
    'visitas' => $visitas
]);

?>