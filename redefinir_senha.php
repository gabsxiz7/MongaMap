<?php
include 'php/conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $token = $_GET['token'] ?? '';
    $stmt = $conexao->prepare("SELECT cd_usuario, data_expiracao FROM tb_token_redefinicao WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $row = $result->fetch_assoc();
    if ($result->num_rows === 0 || strtotime($result->fetch_assoc()['data_expiracao']) < time()) {
        exit("Token inválido ou expirado.");
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha - MongaMap</title>
    <link rel="stylesheet" href="CSS/auth.css">
    <link rel="stylesheet" href="CSS/navbar.css">
</head>
<body>
    <div class="container">
        <h2>Redefinir Senha</h2>
        <form method="POST" action="redefinir_senha.php">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <label for="nova_senha">Nova Senha:</label>
            <input type="password" id="nova_senha" name="nova_senha" required>
            <br><br>
            <button type="submit">Atualizar Senha</button>
        </form>
    </div>
</body>
</html>
    <nav class="navbar">
      <div class="navbar-container">
        <a href="index.php" class="navbar-brand">
            <img src="IMG/logo.png" class="mongamap" />
        </a>
        <button class="menu-toggle" id="menuToggle" aria-label="Menu">
            <span class="menu-bar"></span>
            <span class="menu-bar"></span>
            <span class="menu-bar"></span>
        </button>
        <ul class="navbar-links" id="navbarLinks">
            <?php if(isset($_SESSION['id'])): ?>
                <li><a href="quiz.php?id=1">Quiz</a></li>
                <li><a href="gamificacao.php">Perfil</a></li>
                <li><a href="php/logout.php" class="btn-sair">Sair</a></li>
            <?php endif; ?>
            <li><a href="index.php">Início</a></li>
            <li><a href="sobre.php">Sobre</a></li>
            <li><a href="conheca.php">Conheça</a></li>
            <li><a href="comentarios.php">Feedback</a></li>
        </ul>
      </div>
    </nav> 
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