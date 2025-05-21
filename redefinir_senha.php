<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $token = $_GET['token'] ?? '';
    $stmt = $conexao->prepare("SELECT cd_usuario, data_expiracao FROM tb_token_redefinicao WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0 || strtotime($result->fetch_assoc()['data_expiracao']) < time()) {
        exit("Token inválido ou expirado.");
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nova Senha - MongaMap</title>
    <link rel="stylesheet" href="CSS/auth.css">
</head>
<body class="page-cadastro">
    <div class="container">
        <form action="redefinir_senha.php" method="POST">
            <h1>Digite sua nova senha</h1>
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <input type="password" name="nova_senha" placeholder="Nova senha" required>
            <button type="submit">Salvar nova senha</button>
        </form>
    </div>
</body>
</html>
<?php
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $novaSenha = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT);

    $stmt = $conexao->prepare("SELECT cd_usuario FROM tb_token_redefinicao WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        exit("Token inválido.");
    }

    $cd_usuario = $result->fetch_assoc()['cd_usuario'];

    $stmt = $conexao->prepare("UPDATE tb_usuario SET nm_senha = ? WHERE cd_usuario = ?");
    $stmt->bind_param("si", $novaSenha, $cd_usuario);
    $stmt->execute();

    $stmt = $conexao->prepare("DELETE FROM tb_token_redefinicao WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();

    echo "<script>alert('Senha atualizada com sucesso!'); window.location.href = 'index.php';</script>";
}
?>