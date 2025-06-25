<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha - MongaMap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="IMG/pinomark1.png">
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="CSS/esqueci_senha.css">
</head>
<body class="page-cadastro">

<!-- NAVBAR -->
<nav class="navbar">
    <div class="navbar-container">
        <a href="index.php" class="navbar-brand">
            <img src="IMG/mglogo.png" alt="Mini Logo" class="mongamap">
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
                <li><a href="PHP/logout.php" class="btn-sair">Sair</a></li>
            <?php endif; ?>
            <li><a href="index.php">Início</a></li>
            <li><a href="sobre.php">Sobre</a></li>
            <li><a href="conheca.php">Conheça</a></li>
            <li><a href="comentarios.php">Feedback</a></li>
        </ul>
    </div>
</nav>

<!-- CONTEÚDO PRINCIPAL -->
<main>
    <div class="container-recuperar">
        <form action="PHP/enviar_email_token.php" method="POST" class="form-recuperar">
            <h1 class="titulo-recuperar">Recuperar Senha</h1>
            <input type="email" name="email" class="input-recuperar" placeholder="Digite seu e-mail" required>
            <button type="submit" class="botao-recuperar">ENVIAR LINK DE REDEFINIÇÃO</button>
        </form>
    </div>
</main>

<!-- FOOTER -->
<footer class="footer">
    <p>&copy; 2025 MongaMap. Todos os direitos reservados.</p>
    <a href="#">Política de Privacidade</a> | <a href="#">Termos de Uso</a>
</footer>

<!-- SCRIPTS -->
<script src="JS/navbar.js"></script>

</body>
</html>
