<?php
    include 'php/conexao.php';
    session_start();
    if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM tb_usuario WHERE nm_usuario = $name";
    $query = $conexao->query($sql);
    $resultado = $query->fetch_assoc();
    echo $resultado['nome']."! ";
    }else{
        echo "<script> alert('Você não está logado!'); history.back(); </script>"; 
    }
    ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamificação - MongaMap</title>
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="CSS/gamificacao.css">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.html" class="navbar-brand">
                <img src="IMG/logo.png" alt="Logo MongaMap" class="logo">
                Monga📍Map
            </a>
            <button class="menu-toggle" id="menuToggle" aria-label="Menu">
                <span class="menu-bar"></span>
                <span class="menu-bar"></span>
                <span class="menu-bar"></span>
            </button>
            <ul class="navbar-links" id="navbarLinks">
                <li><a href="index.html" class="active">Início</a></li>
                <li><a href="sobre.html">Sobre</a></li>
                <li><a href="conheca.html">Conheça</a></li>
                <li><a href="trofeus.html">Troféus</a></li>
                <li><a href="feedback.html">Feedback</a></li>
                <li><a href="qrcode.html">QR Code</a></li>
                <li><a href="cadastro.php" class="btn-cadastrar">Cadastre-se</a></li>
            </ul>
        </div>
    </nav>
    <header class="header">
        <h1>Gamificação</h1>
        <p>Explore os pontos turísticos de Mongaguá e acompanhe seu progresso.</p>
    </header>
    <!--secao do user-->
       <main class="container-container">
           <!-- seção 1: informações do usuário -->
           <section class="card perfil">
           <h2>Minha Jornada 🎮</h2>
           <img id="fotoUsuario" src="IMG/icon.png" alt="Avatar">
           <h3>Usuário: <strong id="nomeUsuario">BlackN444</strong></h3>
        <p id="nivelUsuario">Nível: Explorador</p>
        <p id="pontuacaoUsuario">Pontuação: 320 ⭐</p>
    </section>
        <!-- seção 2: Barra de Progresso -->
           <section class="card barra-progresso">
           <h3>Nível 2 🚀</h3>
           <progress value="320" max="5000"></progress>
        <p id="progressText">320 / 5000 pontos</p>
    </section>
        <!-- Seção 3: Conquistas Recentes -->
           <section class="card conquistas">
           <h3>Últimas Conquistas 🎉</h3>
        <ul id="listaConquistas">
          <!--conquistas aparece aq pelo js-->
        </ul>
    </section>
        <!-- seção 4: Missões-->
    <section class="card">
        <h3>Missões 📜</h3>
        <ul id="listaMissoes">
          <!--missões aparece aq pelo js-->
        </ul>
        <button class="btn-missoes" onclick="concluirMissao(0)">Concluir Missão 1</button>
        <button class="btn-missoes" onclick="concluirMissao(1)">Concluir Missão 2</button>
    </section>
    <!-- seção 5: Ranking de Usuários -->
    <section class="card ranking">
        <h3>Ranking 🏆</h3>
        <ol class="ranking-li">
            <li>🥇 Emerson - 1500 pontos</li>
            <li>🥈 Gui - 1350 pontos</li>
            <li>🥉 Thay - 1200 pontos</li>
        </ol>
    </section>
</main>
<section class="pontos-turisticos">
    <h2>Pontos Turísticos de Mongaguá</h2>
    <div class="grid-pontos">
        <div class="ponto-turistico">
            <img src="IMG/pesca.png" alt="Plataforma de Pesca">
            <h3>Plataforma de Pesca</h3>
            <p>Local incrível para pesca e lazer.</p>
            <button onclick="marcarMapa(-24.0911, -46.6218)">Ver no Mapa</button>
        </div>
        <div class="ponto-turistico">
            <img src="IMG/parkeco.png" alt="Parque">
            <h3>Parque Ecológico</h3>
            <p>Contato direto com a natureza.</p>
            <button onclick="marcarMapa(-24.0941, -46.6195)">Ver no Mapa</button>
        </div>
        <div class="ponto-turistico">
            <img src="IMG/igrejamatriz.png" alt="Igreja Matriz">
            <h3>Igreja Matriz</h3>
            <p>Rica em história e arquitetura colonial.</p>
            <button onclick="marcarMapa(-24.0920, -46.6233)">Ver no Mapa</button>
        </a>
        </div>
        <div class="ponto-turistico">
            <img src="IMG/praiaflorida.png" alt="Praia Flórida Mirim">
            <h3>Praia Flórida Mirim</h3>
            <p>Praia de aguas limpas, ideal para famílias.</p>
            <button onclick="marcarMapa(-24.0950, -46.6240)">Ver no Mapa</button>
        </div>
        <div class="ponto-turistico">
            <img src="IMG/praça.dudu.png" alt="Praça Dudu Samba">
            <h3>Praça Dudu Samba</h3>
            <p>Famosa praça de eventos culturais.</p>
            <button onclick="marcarMapa(-24.0975, -46.6210)">Ver no Mapa</button>
        </div>
        <div class="ponto-turistico">
            <img src="IMG/poçoantas.png" alt="Poço das Antas">
            <h3>Poço das Antas</h3>
            <p>Área natural para relaxar e explorar.</p>
            <button onclick="marcarMapa(-24.0935, -46.6225)">Ver no Mapa</button>
        </a>
        </div>
        <div class="ponto-turistico">
            <img src="IMG/artesanato.png" alt="Feira de Artesanato">
            <h3>Feira de Artesanato</h3>
            <p>Feira de produtos locais e artesanais.</p>
            <button onclick="marcarMapa(-24.0918, -46.6203)">Ver no Mapa</button>
        </div>
          <div class="ponto-turistico">
            <img src="IMG/santa.png" alt="Morro da Padroeira">
            <h3>Morro da Padroeira</h3>
            <p>Vista panorâmica incrível da cidade.</p>
            <button onclick="marcarMapa(-24.0890, -46.6180)">Ver no Mapa</button>
        </div>
    </div>
</section>
<!-- mapa -->
<section>
    <h2>Mapa de Pontos Turísticos</h2>
    <p id="coordenadas">Obtendo localização...</p>
    <div id="map"></div>
</section>
<style>
    /*estilo básico do mapa*/
    #map {
        height: 400px;
        width: 100%;
        margin-top: 20px;
        border-radius: 10px;
    }
</style>
    <footer class="footer">
        <p>&copy; 2025 MongaMap. Todos os direitos reservados.</p>
        <a href="#">Política de Privacidade</a> | <a href="#">Termos de Uso</a>
    </footer>
    <script src="JS/gamificacao.js"></script>
    <script src="JS/navbar.js"></script>
</html>
</head>
</body>
