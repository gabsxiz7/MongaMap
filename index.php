<?php 
 session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MongaMap - Cada Rota é uma Nova Descoberta</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="CSS/home.css">
    <link rel="stylesheet" href="CSS/style.css">
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
            <li><a href="index.php" class="ativo">Início</a></li>
            <li><a href="sobre.php" class="ativo">Sobre</a></li>
            <li><a href="conheca.php" class="ativo">Conheça</a></li>
            <li><a href="comentarios.php" class="ativo">Feedback</a></li>

    <?php if (isset($_SESSION['id'])):?>   
            <li><a href="quiz.php?id=1">Quiz</a></li>
            <li><a href="gamificacao.php">Perfil</a></li>
           
            <!---login para dms acessar--->
        <?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin'): ?>
            <li><a href="adicionar_pergunta.php">Adicionar Pergunta</a></li>
            <li><a href="adicionar_local.php">Adicionar Local</a></li>
        <?php endif; ?>

         <li><a href="php/logout.php" class="btn-sair">Sair</a></li>
            <?php else: ?>
            <li><a href="cadastro.php" class="btn-cadastrar">Cadastre-se</a></li>
            <?php endif; ?>
            </ul>
        </div>
</nav>
    <!--------------SEÇÃO PRINCIPAL--------------->
    <section class="home">
      <div class="container">
        <div class="home-left">
          <a href="sobre.php">
          <img src="IMG/logo.png" alt="Logo Monga Map" class="logo-home">
          </a>
        </div>
        <div class="home-text">
          <h1>MongaMap: Cada Rota é uma Nova Descoberta</h1>
          <h2>Aprofunde-se em uma nova experiência sobre o turismo</h2>
        </div>
      </div>
    </section>    
      <!-- Vídeo de abertura -->
  <section id="videoContainer" class="video-container">
    <video
      id="introVideo"
      width="100%"
      autoplay
      muted
      playsinline
    >
      <source src="VIDEO/plataforma.video.mp4" type="video/mp4" />
      Seu navegador não suporta vídeo HTML5.
    </video>
    <!-- overlay de texto -->
  <div class="video-overlay">
    <h1>Mongaguá</h1>
  </div>
  </section>
      <!--CARROSSEL INICIAL-->
      <section class="carousel-container" style="display: none;">
  <div class="custom-carousel">
    <div class="carousel-slides">
      <div class="slide active">
        <img src="IMG/plataformapp.png" alt="Plataforma de Pesca">
        <div class="caption">
          <h5>Plataforma de Pesca</h5>
          <p>Visitada por inúmeros turistas e munícipes, é um dos cenários mais bonitos e encantadores do Brasil...</p>
        </div>
      </div>
      <div class="slide">
        <img src="IMG/raulcortez.png" alt="Centro Cultural Raul Cortez">
        <div class="caption">
          <h5>Centro Cultural Raul Cortez</h5>
          <p>Inaugurado em 1996, é o coração da cena cultural de Mongaguá.</p>
        </div>
      </div>
      <div class="slide">
        <img src="IMG/padroeira2.png" alt="Morro da Padroeira">
        <div class="caption">
          <h5>Morro da Padroeira</h5>
          <p>Com 139 degraus e 15 metros de altura, proporciona uma vista incrível da cidade.</p>
        </div>
      </div>
    </div>

    <button class="prev">&#10094;</button>
    <button class="next">&#10095;</button>
  </div>
</section>

  <!-- SEÇÃO DE DESTAQUES -->
<section class="destaques">
  <div class="card">
    <a href="exploração.php">
    <img src="IMG/santa.png" alt="Exploração">
    <div class="card-body">
    <h3>Exploração Fácil</h3>
    <p>Descubra os melhores pontos turísticos de Mongaguá com poucos cliques.</p>
  </div>
</a>
</div>
  <div class="card">
    <a href="gamificacao.php">
    <img src="IMG/praiaflorida.png" alt="Gamificação">
    <div class="card-body">
    <h3>Gamificação</h3>
    <p>Ganhe pontos enquanto explora, suba de nível e desbloqueie recompensas.</p>
  </div>
  </a>
</div>
  <div class="card">
    <a href="descubra.php">
    <img src="IMG/antas.png" alt="Descubra">
      <div class="card-body">
      <h3>Descubra Mais</h3>
     <p>Explore novos lugares e viva experiências únicas com o MongaMap.</p>
  </div>
  </a>
</div>
</section>

</div>
<!--FAQ-->
<section class="faq">
  <h2><i class="fas fa-comments"></i> Perguntas Frequentes</h2>
  <div class="pergunta">
      <h3><i class="fas fa-question-circle"></i>Como funciona o MongaMap?</h3>
      <p>O MongaMap ajuda você a explorar os melhores pontos turísticos de Mongaguá com uma interface intuitiva e interativa.</p>
  </div>
  <div class="pergunta">
      <h3><i class="fas fa-question-circle"></i>É necessário se cadastrar?</h3>
      <p>Não, mas cadastrando-se, você pode acessar recursos exclusivos, como gamificação e personalização.</p>
  </div>
  <div class="pergunta">
    <h3><i class="fas fa-question-circle"></i>É necessário pagar para usar o MongaMap?</h3>
    <p>Não, o MongaMap é gratuito para todos.</p>
  </div>
  <div class="pergunta">
    <h3><i class="fas fa-question-circle"></i>Como funciona os pontos turísticos no mapa?</h3>
    <p>Você pode localizar os pontos turísticos no mapa interativo, clicar nos marcadores e obter mais informações sobre cada local.</p>
  </div>
  <div class="pergunta">
    <h3><i class="fas fa-question-circle"></i>Posso acessar o MongaMap pelo celular?</h3>
    <p>Sim, o MongaMap é otimizado para dispositivos móveis. Você pode acessar o site pelo navegador do seu celular sem nenhum problema.</p>
  </div>
</section>
<!--CONTATO-->
<section class="mini-mapa">
  <h2>Encontre-nos</h2>
  <p>Mongaguá, São Paulo, Brasil</p>
  <div id="mini-map"></div>
</section>
<!--ESTATÍSTICAS-->
<section class="estatisticas">
  <div class="item">
    <h3>500+</h3>
    <p>Usuários Registrados</p>
</div>
<div class="item">
    <h3>30+</h3>
    <p>Pontos Turísticos</p>
</div>
<div class="item">
    <h3>1,000+</h3>
    <p>Visitas Mensais</p>
</div>
</section>
<footer class="footer">
  <p>&copy; 2025 MongaMap. Todos os direitos reservados.</p>
  <a href="#">Política de Privacidade</a> | <a href="#">Termos de Uso</a>
</footer>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="JS/home.js"></script>
    <script src="JS/navbar.js"></script>
</body>
</html>