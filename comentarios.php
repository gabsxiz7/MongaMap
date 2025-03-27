<<<<<<< HEAD
<<?php 
 session_start();
?>
=======
<?php 
include 'php/conexao.php';
session_start();
?>

>>>>>>> 1d11af47a83da4dcabcbc5178a600adc856a13b3
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
            <a href="index.html" class="navbar-brand"></a>
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
<<<<<<< HEAD
    <?php if (isset($_SESSION['id'])):?> 
            <li><a href="gamificacao.php">Perfil</a></li>
            <li><a href="php/logout.php" class="btn-sair">Sair</a></li>
            <?php else: ?>
=======

>>>>>>> 1d11af47a83da4dcabcbc5178a600adc856a13b3
                <li><a href="cadastro.php" class="btn-cadastrar">Cadastre-se</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <header class="header">
        <h1>Compartilhe Sua Experiência</h1>
        <p>Deixe seu comentário sobre os pontos turísticos e ajude outros visitantes a descobrir mais!</p>
    </header>
    <main class="comentarios-container">
        <!------- FORMULÁRIO DE COMENTÁRIOS ------->
        <section class="comentarios-form">
            <h2>Deixe seu Comentário</h2>
            <form>
                <div class="input-group">
                    <i class="fa fa-user"></i>
                    <input type="text" id="usuario" name="usuario" placeholder="Seu nome" required>
                </div>
        
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
            
            <div class="comentario">
                <div class="comentario-header">
                    <strong>Pedro Antônio</strong>
                    <span class="comentario-data">08/02/2025</span>
                </div>
                <p>Adorei a visita ao Parque Ecológico! A natureza é incrível e o ambiente muito bem cuidado.</p>
                <div class="reacoes">
                    <span><i class="fa fa-thumbs-up"></i> 15</span>
                    <span><i class="fa fa-thumbs-down"></i> 2</span>
                    <span><i class="fa fa-smile"></i> 5</span>
                </div>
            </div>
    
            <div class="comentario">
                <div class="comentario-header">
                    <strong>Emerson</strong>
                    <span class="comentario-data">07/02/2025</span>
                </div>
                <p>A plataforma de pesca é um lugar maravilhoso! Ideal para relaxar e aproveitar a vista do mar.</p>
                <div class="reacoes">
                    <span><i class="fa fa-thumbs-up"></i> 12</span>
                    <span><i class="fa fa-thumbs-down"></i> 1</span>
                    <span><i class="fa fa-smile"></i> 8</span>
                </div>
            </div>
    
            <!----------- Adicione mais comentários aqui ----------->
        </section>
    </main>
    
    <footer class="footer">
        <p>&copy; 2025 MongaMap. Todos os direitos reservados.</p>
        <a href="#">Política de Privacidade</a> | <a href="#">Termos de Uso</a>
    </footer>
    <script src="JS/navbar.js"></script>
</body>
</html>
