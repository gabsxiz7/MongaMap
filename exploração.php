<?php
include 'php/conexao.php'; 
 session_start();

 if (!isset($_SESSION['id'])) {
    echo "<script> alert('Você não está logado!'); history.back(); </script>";
    exit();
 }
 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exploração - Planejamento Simplificado</title>
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="CSS/exploração.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body class="body-page">
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
                <li><a href="index.php">Início</a></li>
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
        <h1>Planejamento Simplificado</h1>
        <p>Crie rotas personalizadas e visualize os melhores caminhos para explorar Mongaguá com praticidade.</p>
    </header>
    <!----------mapa interativo-------->
    <section class="map-section">
        <h2>Planeje sua Rota</h2>
        <div id="map"></div>
    </section>
    <!--rotas...-->
    <section>
        <h2>Rotas Sugeridas</h2>
        <ul class="rotas-sugeridas">
            <li><strong>Rota da Natureza:</strong> Parque Ecológico, Poço das Antas, Morro da Padroeira.</li>
            <li><strong>Rota Histórica:</strong> Igreja Matriz, Feira de Artesanato, Centro Cultural Raul Cortez.</li>
            <li><strong>Rota para Famílias:</strong> Praia Flórida Mirim, Praça Dudu Samba, Feira de Artesanato.</li>
        </ul>
    </section>
    <!--calcule...-->
    <section>
        <h2>Calcule a Distância</h2>
        <form>
            <label for="ponto1">Ponto de Partida:</label>
            <select id="ponto1">
                <option value="-24.134243, -46.692596">Plataforma de Pesca</option>
                <option value="-24.134406, -46.695230">Parque Ecológico</option>
                <option value="-24.094984, -46.620291">Igreja Matriz</option>
                <option value="-24.132455, -46.711498">Praia Flórida Mirim</option>
                <option value="-24.09606, -46.62045">Praça Dudu Samba</option>
                <option value="-24.0935, -46.6225">Poço das Antas</option>
                <option value="-24.09462, -46.61961">Feira de Artesanato</option>
                <option value="-24.13087, -46.68704">Praia Agenor de Campos</option>
                <option value="-24.10203, -46.63637">Centro Cultural Raul Cortez</option>
            </select>
            <label for="ponto2">Destino:</label>
            <select id="ponto2">
                <option value="-24.134406, -46.695230">Parque Ecológico</option>
                <option value="-24.134243, -46.692596">Plataforma de Pesca</option>
                <option value="-24.094984, -46.620291">Igreja Matriz</option>
                <option value="-24.132455, -46.711498">Praia Flórida Mirim</option>
                <option value="-24.09606, -46.62045">Praça Dudu Samba</option>
                <option value="-24.0935, -46.6225">Poço das Antas</option>
                <option value="-24.09462, -46.61961">Feira de Artesanato</option>
                <option value="-24.13087, -46.68704">Praia Agenor de Campos</option>
                <option value="-24.10203, -46.63637">Centro Cultural Raul Cortez</option>
            </select>
            <button type="button" id="calcular">Calcular</button>
        </form>
        <p id="resultado">Distância: --</p>
    </section>
    <!-- dicas...-->
    <section>
        <h2>Dicas para um bom planejamento</h2>
        <ul class="dicas-planejamento">
            <li>Verifique as condições climáticas antes de planejar sua rota.</li>
            <li>Evite horários de pico para aproveitar ao máximo cada ponto turístico.</li>
            <li>Leve água, protetor solar e use roupas confortáveis.</li>
            <li>Respeite as normas de cada local e preserve o meio ambiente.</li>
        </ul>
    </section>
    <!--botao p compartilhar-->
    <section>
        <h2>Compartilhe seu Planejamento</h2>
        <button id="compartilhar-planejamento">Compartilhar</button>
    </section>
    <footer class="footer">
        <p>&copy; 2025 MongaMap. Todos os direitos reservados.</p>
        <a href="#">Política de Privacidade</a> | <a href="#">Termos de Uso</a>
    </footer>
    <script src="JS/exploracao.js"></script>
    <script src="JS/navbar.js"></script>
</body>
</html>
