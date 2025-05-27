<?php 
 session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login e Cadastro - MongaMap</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="CSS/auth.css">
    <link rel="stylesheet" href="CSS/navbar.css">
</head>
<body class="page-cadastro">
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.html" class="navbar-brand">
                <img src="IMG/mglogo.png" alt="Mini Logo" class="mongamap">
            </a>
            <button class="menu-toggle" id="menuToggle" aria-label="Menu">
                <span class="menu-bar"></span>
                <span class="menu-bar"></span>
                <span class="menu-bar"></span>
            </button>
            <ul class="navbar-links" id="navbarLinks">
    <?php
            if (isset($_SESSION['id'])) {
         // c o usuário estiver logado
            echo '
            <li><a href="quiz.php?id=1">Quiz</a></li>
            <li><a href="gamificacao.php">Perfil</a></li>
            <li><a href="php/logout.php" class="btn-sair">Sair</a></li>
            ';
            }
    ?>
                <li><a href="index.php">Início</a></li>
                <li><a href="sobre.php" class="active">Sobre</a></li>
                <li><a href="conheca.php">Conheça</a></li>
                <li><a href="comentarios.php">Feedback</a></li>

            </ul>
        </div>
    </nav>
    <div class="navbar-container"></div>
    <main>
    <div class="container" id="container">
        <!---------FORMULÁRIO DE CADASTRO----------->
        <div class="form-container sign-up">
            <form action="php/processa_cadastro.php" method="POST">
                <h1>Criar Conta</h1>
                <input type="text" placeholder="Nome" name="nome" required>
                <input type="email" placeholder="Email" name="email" required>
                <input type="text" placeholder="(13) 99999-9999" id="telefone" name="telefone" required>
                <input type="password" placeholder="Senha" name="senha" required>

                   <!-- reCAPTCHA -->
        <div class="g-recaptcha" data-sitekey="6LeRF_oqAAAAALag1sMQ1Xuouq_X9DRsj-EUYkiP"></div>

                <button type="submit">Cadastre-se</button>
            </form>
        </div>
        <!-------FORMULÁRIO DE LOGIN---------->
        <div class="form-container sign-in">
            <form action="php/processa_login.php" method="POST">
                <h1>Entrar</h1>
                <input type="email" placeholder="Email" name="email" required>
                <input type="password" placeholder="Senha" name="senha" required>
                <a href="esqueci_senha.php">Esqueceu sua senha?</a>

                  <!-- reCAPTCHA -->
                <div class="recaptcha-container">
                  <div class="g-recaptcha" data-sitekey="6LeRF_oqAAAAALag1sMQ1Xuouq_X9DRsj-EUYkiP"></div>
                </div>
          
                <button type="submit">Entrar</button>
            </form>
        </div>
        <!----------PAÍNEIS---------->
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <img src="IMG/logo.png" alt="Logo MongaMap" class="logo-panel">
                    <h1>Olá, amigo!</h1>
                    <p>Cadastre-se para acessar todos os recursos do site</p>
                    <button class="hidden" id="login">Entrar</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <div class="logo-container">
                        <img src="IMG/logo.png" alt="Logo MongaMap" class="logo-logo">
                    </div>
                    <h1>Bem-vindo de volta!</h1>
                    <p>Insira seus dados pessoais para continuar navegando em nosso site
                    </p>
                    <button type="submit" class="hidden" id="register">Cadastrar</button>
                </div>
            </div>
        </div>
    </div>
    </main>
    <!-- script do google reCAPTCHA--->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="JS/auth.js"></script>
    <script src="JS/navbar.js"></script>
    <footer class="footer">
        <p>&copy; 2025 MongaMap. Todos os direitos reservados.</p>
        <a href="#">Política de Privacidade</a> | <a href="#">Termos de Uso</a>
      </footer>
</body>
</html>
