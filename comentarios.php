<?php 
 session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentários - MongaMap</title>
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="CSS/comentarios.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="#" class="navbar-brand">
                <img src="IMG/mglogo.png" alt="Mini Logo" class="mongamap">
            </a>
            
            <button class="menu-toggle" id="menuToggle" aria-label="Menu">
                <span class="menu-bar"></span>
                <span class="menu-bar"></span>
                <span class="menu-bar"></span>
            </button>
            <ul class="navbar-links" id="navbarLinks">
                <li><a href="index.php" class="active">Início</a></li>
                <li><a href="sobre.php">Sobre</a></li>
                <li><a href="conheca.php">Conheça</a></li>
                <li><a href="comentarios.php">Feedback</a></li>

    <?php if (isset($_SESSION['id'])):?> 
            <li><a href="quiz.php?id=14">Quiz</a></li>
            <li><a href="gamificacao.php">Perfil</a></li>
            <li><a href="php/logout.php" class="btn-sair">Sair</a></li>
            <?php else: ?>
                <li><a href="cadastro.php" class="btn-cadastrar">Cadastre-se</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <header class="header">
        <h1>Avalie o MongaMap</h1>
        <p>Ajude-nos a melhorar sua experiência com o MongaMap.</p>
    </header>
    <main class="comentarios-container">
        <!------- FORMULÁRIO DE COMENTÁRIOS ------->
        <section class="comentarios-form">
            <h2>Deixe seu Comentário</h2>
            <form action="PHP/processa_comentario.php" method="POST">
                <div class="input-group">
                    <i class="fa fa-comment"></i>
                    <textarea id="comentario" name="comentario" placeholder="Escreva seu comentário aqui..." required></textarea>
                </div>
        
                <button type="submit" class="btn-enviar">
                    <i class="fa fa-paper-plane"></i> Enviar
                </button>
            </form>
        </section>
        <!------- SEÇÃO DE COMENTÁRIOS RECENTES ------->
        <section class="comentarios-lista">
    <h2>Comentários Recentes</h2>
    
    <?php
    include 'PHP/conexao.php';
    $sql = "SELECT c.ds_comentario, u.nm_usuario, c.cd_comentario
            FROM tb_comentario c
            JOIN tb_usuario u ON c.fk_cd_usuario = u.cd_usuario
            ORDER BY c.cd_comentario DESC
            LIMIT 10";

    $result = $conexao->query($sql);

    while ($linha = $result->fetch_assoc()) {
        echo '
        <div class="comentario">
            <div class="comentario-header">
                <strong>' . htmlspecialchars($linha['nm_usuario']) . '</strong>
                <span class="comentario-data">Agora mesmo</span>
            </div>
            <p>' . htmlspecialchars($linha['ds_comentario']) . '</p>
            <div class="reacoes">
                <span><i class="fa fa-thumbs-up"></i> 0</span>
                <span><i class="fa fa-thumbs-down"></i> 0</span>
                <span><i class="fa fa-smile"></i> 0</span>
            </div>
        </div>';
    }
         ?>
     </section>
</main>
    
    <footer class="footer">
        <p>&copy; 2025 MongaMap. Todos os direitos reservados.</p>
        <a href="#">Política de Privacidade</a> | <a href="#">Termos de Uso</a>
    </footer>
    <script src="JS/navbar.js"></script>
</body>
</html>
