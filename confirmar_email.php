<?php
session_start();
include 'PHP/conexao.php';

if (!isset($_GET['token'])) {
    $mensagem = "Requisição inválida.";
    $tipo     = "erro";
} else {
    $token = $_GET['token'];
    $stmt  = $conexao->prepare("
        SELECT cd_usuario, verificado
          FROM tb_usuario
         WHERE token_verificacao = ?
         LIMIT 1
    ");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $mensagem = "Token inválido ou usuário não encontrado.";
        $tipo     = "erro";
    } else {
        $stmt->bind_result($idUsuario, $verificadoBanco);
        $stmt->fetch();
        if ($verificadoBanco == 1) {
            $mensagem = "E-mail já confirmado anteriormente. Faça <a href='cadastro.php'>login</a>.";
            $tipo     = "info";
        } else {
            $up = $conexao->prepare("
                UPDATE tb_usuario
                   SET verificado = 1,
                       token_verificacao = NULL
                 WHERE cd_usuario = ?
            ");
            $up->bind_param("i", $idUsuario);
            if ($up->execute()) {
                $mensagem = "E-mail confirmado com sucesso! Agora você pode <a href='cadastro.php'>entrar</a>.";
                $tipo     = "sucesso";
            } else {
                $mensagem = "Erro ao confirmar e-mail. Tente novamente mais tarde.";
                $tipo     = "erro";
            }
        }
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Confirmação de E-mail – MongaMap</title>
  <link rel="icon" type="image/x-icon" href="IMG/pinomark1.png">
  <link rel="stylesheet" href="CSS/navbar.css"/>
  <link rel="stylesheet" href="CSS/confirmar.css"/>
</head>
<body>
  <!-- ================= Navbar ================= -->
  <nav class="navbar">
    <div class="navbar-container">
      <a href="index.php" class="navbar-brand">
        <img src="IMG/mglogo.png" alt="Logo MongaMap" class="mongamap" />
      </a>
      <button class="menu-toggle" id="menuToggle" aria-label="Menu">
        <span class="menu-bar"></span>
        <span class="menu-bar"></span>
        <span class="menu-bar"></span>
      </button>

      <ul class="navbar-links" id="navbarLinks">
        <li><a href="index.php" class="ativo">Início</a></li>
        <li><a href="sobre.php">Sobre</a></li>
        <li><a href="conheca.php">Conheça</a></li>
        <li><a href="comentarios.php">Feedback</a></li>
      </ul>
    </div>
  </nav>
  <!-- ========== Wrapper principal (precisa ter flex:1 no CSS) ========== -->
  <div class="main-content">
    <div class="confirm-container <?php echo $tipo; ?>">
      <h1>Confirmação de E-mail</h1>
      <p><?php echo $mensagem; ?></p>

      <?php if ($tipo === "sucesso"): ?>
        <a class="btn-login" href="cadastro.php">Ir para Login</a>
      <?php elseif ($tipo === "erro"): ?>
        <a class="btn-home" href="index.php">Voltar ao Início</a>
      <?php endif; ?>
    </div>
  </div>
  <!-- ========== Fim do Wrapper principal ========== -->

  <!-- ========== Footer fixado ao fim da página ========== -->
  <footer class="footer">
    <p>&copy; 2025 MongaMap. Todos os direitos reservados.</p>
    <a href="#">Política de Privacidade</a> | <a href="#">Termos de Uso</a>
  </footer>
  <!-- ========== Fim do Footer ========== -->

  <script src="JS/navbar.js"></script>
</body>
</html>
