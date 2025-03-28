<?php 
include 'php/conexao.php';
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MongaMap - Cada Rota é uma Nova Descoberta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="CSS/home.css">
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body class="home-page">
  <nav class="navbar">
    <div class="navbar-container">
        <button class="menu-toggle" id="menuToggle" aria-label="Menu">
            <span class="menu-bar"></span>
            <span class="menu-bar"></span>
            <span class="menu-bar"></span>
        </button>
        <ul class="navbar-links" id="navbarLinks">
            <li><a href="gamificacao.php">Perfil</a></li>
            <li><a href="sobre.php">Sobre</a></li>
            <li><a href="conheca.php">Conheça</a></li>
            <li><a href="comentarios.php">Feedback</a></li>
            <li><a href="php/logout.php" class="btn-cadastrar">Sair</a></li>
            </ul>
        </div>
</nav>

    <!--------------SEÇÃO PRINCIPAL--------------->
    <section class="home">
      <div class="container">
        <div class="home-left">
          <a href="sobre.html">
          <img src="IMG/logo.png" alt="Logo Monga Map" class="logo-home">
          </a>
        </div>
        <div class="home-text">
          <h1>MongaMap: Cada Rota é uma Nova Descoberta</h1>
          <h2>Aprofunde-se em uma nova experiência sobre o turismo</h2>
        </div>
      </div>
    </section>    
      <!--CARROSSEL INICIAL-->
      <section class="carousel-container">
          <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
         <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
         <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
         <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
         <div class="carousel-item active">
            <img src="IMG/plataformapp.png" class="d-block w-100" alt="Descrição da Imagem 1">
            <div class="carousel-caption d-none d-md-block">
               <h5>Plataforma de Pesca</h5>
               <p>Visitada por inúmeros turistas e munícipes, o local é um dos cenários mais bonitos e encantadores do Brasil. Instalada na cidade em 1977, é a maior plataforma pesqueira em estrutura de concreto armado. Avançando 400 metros mar adentro, forma um “T” e se lança 86m para cada um dos lados.</p>
            </div>
         </div>
         <div class="carousel-item">
            <img src="IMG/raulcortez.png" class="d-block w-100" alt="Descrição da Imagem 2">
            <div class="carousel-caption d-none d-md-block">
               <h5>Centro Cultural Raul Cortez</h5>
               <p>O Centro Cultural Raul Cortez foi inaugurado em dezembro de 1996. Tem seu nome em homenagem ao ator Raul Cortez e é o coração da cena cultural de Mongaguá.</p>
            </div>
         </div>
         <div class="carousel-item">
            <img src="IMG/padroeira2.png" class="d-block w-100" alt="Descrição da Imagem 3">
            <div class="carousel-caption d-none d-md-block">
               <h5>Morro da Padroeira</h5>
               <p>Com mais de 15 metros de altura e cerca de 2,5 toneladas, instalada em uma trilha urbana feita em uma passarela de madeira com 150 metros de extensão. São 139 degraus em meio a mata nativa.</p>
            </div>   
         </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
         <span class="carousel-control-prev-icon" aria-hidden="true"></span>
         <span class="visually-hidden">Anterior</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
         <span class="carousel-control-next-icon" aria-hidden="true"></span>
         <span class="visually-hidden">Próximo</span>     
      </button>
   </div>
  </section>
  <!-- SEÇÃO DE DESTAQUES -->
<section class="destaques">
  <div class="card">
    <a href="exploração.html">
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
    <a href="descubra.html">
    <img src="IMG/antas.png" alt="Descubra">
      <div class="card-body">
      <h3>Descubra Mais</h3>
     <p>Explore novos lugares e viva experiências únicas com o MongaMap.</p>
  </div>
  </a>
</div>
</section>
<!--FAQ-->
<section class="faq">
  <h2>Perguntas Frequentes</h2>
  <div class="pergunta">
      <h3>Como funciona o MongaMap?</h3>
      <p>O MongaMap ajuda você a explorar os melhores pontos turísticos de Mongaguá com uma interface intuitiva e interativa.</p>
  </div>
  <div class="pergunta">
      <h3>É necessário se cadastrar?</h3>
      <p>Não, mas cadastrando-se, você pode acessar recursos exclusivos, como gamificação e personalização.</p>
  </div>
  <div class="pergunta">
    <h3>É necessário pagar para usar o MongaMap?</h3>
    <p>Não, o MongaMap é gratuito para todos.</p>
  </div>
  <div class="pergunta">
    <h3>Como funciona os pontos turísticos no mapa?</h3>
    <p>Você pode localizar os pontos turísticos no mapa interativo, clicar nos marcadores e obter mais informações sobre cada local.</p>
  </div>
  <div class="pergunta">
    <h3>Posso acessar o MongaMap pelo celular?</h3>
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
    <!-- bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="JS/home.js"></script>
    <script src="JS/navbar.js"></script>
</body>
</html>