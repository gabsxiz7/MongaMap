<?php
// redefinir_senha.php
session_start();
include 'php/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // 1) Verifica se veio o token via GET
    $token = $_GET['token'] ?? '';
    if (empty($token)) {
        exit("Token não fornecido.");
    }

    // 2) Busca registro na tabela de tokens
    $stmt = $conexao->prepare("
        SELECT cd_usuario, data_expiracao 
          FROM tb_token_redefinicao 
         WHERE token = ? 
         LIMIT 1
    ");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        exit("Token inválido ou não encontrado.");
    }

    $row = $result->fetch_assoc();
    $expiresAt = strtotime($row['data_expiracao']);
    if ($expiresAt < time()) {
        exit("Token expirado.");
    }
    $stmt->close();
    ?>

    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Redefinir Senha – MongaMap</title>
      <link rel="stylesheet" href="CSS/redefinir.css" />
      <link rel="stylesheet" href="CSS/navbar.css" />
    </head>
    <body>
      <!-- Navbar (igual às outras páginas) -->
      <nav class="navbar">
        <div class="navbar-container">
          <a href="index.php" class="navbar-brand">
            <img src="IMG/mglogo.png" alt="MongaMap" class="mongamap" />
          </a>
          <button class="menu-toggle" id="menuToggle" aria-label="Menu">
            <span class="menu-bar"></span>
            <span class="menu-bar"></span>
            <span class="menu-bar"></span>
          </button>
          <ul class="navbar-links" id="navbarLinks">
            <?php if (isset($_SESSION['id'])): ?>
              <li><a href="quiz.php?id=14">Quiz</a></li>
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

      <!-- Conteúdo de redefinição -->
      <main class="main-content">
        <div class="reset-container">
          <h2>Redefinir Senha</h2>

          <!-- Formulário único -->
          <form id="formRedefinir" method="POST" action="redefinir_senha.php" novalidate>
            <!-- Token escondido -->
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>" />

            <!-- Campo Nova Senha -->
            <div class="form-group">
              <label for="nova_senha">Nova Senha:</label>
              <input
                type="password"
                id="nova_senha"
                name="nova_senha"
                minlength="8"
                placeholder="Digite sua nova senha"
                required
                pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&]).{8,}"
                title="Senha deve ter mínimo 8 caracteres, ao menos 1 letra minúscula, 1 letra maiúscula, 1 número e 1 caractere especial (@$!%*#?&)."
              />
              <!-- Texto explicando as regras -->
              <ul class="password-rules" id="passwordRules">
                <li id="ruleLength">Mínimo 8 caracteres</li>
                <li id="ruleLower">Ao menos 1 letra minúscula (<code>a–z</code>)</li>
                <li id="ruleUpper">Ao menos 1 letra maiúscula (<code>A–Z</code>)</li>
                <li id="ruleNumber">Ao menos 1 número (<code>0–9</code>)</li>
                <li id="ruleSpecial">Ao menos 1 caractere especial (<code>@ $ ! % * # ? &amp;</code>)</li>
              </ul>
            </div>

            <!-- Botão Atualizar Senha -->
            <button type="submit">Atualizar Senha</button>

            <!-- Link para voltar ao login -->
            <a href="cadastro.php" class="link-login">Voltar ao Login</a>
          </form>
        </div>
      </main>

      <!-- Footer -->
      <footer class="footer">
        <p>&copy; 2025 MongaMap. Todos os direitos reservados.</p>
        <a href="#">Política de Privacidade</a> | <a href="#">Termos de Uso</a>
      </footer>

      <!-- Scripts -->
      <script src="JS/navbar.js"></script>
      <script src="JS/redefinir.js"></script>
    </body>
    </html>

    <?php
    exit;
}

// Se chegou aqui, o método é POST → processa a atualização da senha
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) Recebe token e nova senha
    $token = $_POST['token'] ?? '';
    $novaSenhaRaw = $_POST['nova_senha'] ?? '';

    // 2) Validação no back-end (regra de complexidade)
    $senha = $novaSenhaRaw;
    $erros = [];

    if (strlen($senha) < 8) {
        $erros[] = "A senha deve ter no mínimo 8 caracteres.";
    }
    if (!preg_match('/[a-z]/', $senha)) {
        $erros[] = "A senha deve conter ao menos uma letra minúscula.";
    }
    if (!preg_match('/[A-Z]/', $senha)) {
        $erros[] = "A senha deve conter ao menos uma letra maiúscula.";
    }
    if (!preg_match('/\d/', $senha)) {
        $erros[] = "A senha deve conter ao menos um número.";
    }
    if (!preg_match('/[@$!%*#?&]/', $senha)) {
        $erros[] = "A senha deve conter ao menos um caractere especial (@$!%*#?&).";
    }

    if (!empty($erros)) {
        // Se houver erros, exibe-os e não prossegue
        echo "<!DOCTYPE html><html lang='pt-br'><head><meta charset='UTF-8'><title>Erro</title></head><body>";
        echo "<h3>Não foi possível atualizar a senha:</h3>";
        echo "<ul style='color: red;'>";
        foreach ($erros as $e) {
            echo "<li>" . htmlspecialchars($e) . "</li>";
        }
        echo "</ul>";
        echo "<p><a href='javascript:history.back()'>Voltar</a></p>";
        echo "</body></html>";
        exit;
    }

    if (empty($token)) {
        exit("Token ou senha não fornecidos.");
    }

    // 3) Busca usuário pelo token
    $stmt = $conexao->prepare("
        SELECT cd_usuario 
          FROM tb_token_redefinicao 
         WHERE token = ? 
         LIMIT 1
    ");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        exit("Token inválido ou já utilizado.");
    }

    $row = $result->fetch_assoc();
    $cd_usuario = $row['cd_usuario'];
    $stmt->close();

    // 4) Atualiza senha no usuário
    $novaSenhaHash = password_hash($novaSenhaRaw, PASSWORD_DEFAULT);
    $stmt = $conexao->prepare("
        UPDATE tb_usuario 
           SET nm_senha = ? 
         WHERE cd_usuario = ?
    ");
    $stmt->bind_param("si", $novaSenhaHash, $cd_usuario);
    $stmt->execute();
    $stmt->close();

    // 5) Remove o token da tabela para evitar reutilização
    $stmt = $conexao->prepare("
        DELETE FROM tb_token_redefinicao 
         WHERE token = ?
    ");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->close();

    // 6) Informa sucesso e redireciona ao login
    echo "<script>
            alert('Senha atualizada com sucesso! Faça login com sua nova senha.');
            window.location.href = 'cadastro.php';
          </script>";
    exit;
}

// Em qualquer outro caso:
exit("Método HTTP não suportado.");
?>
