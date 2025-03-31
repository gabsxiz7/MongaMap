<?php 
 session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Conheça - MongaMap</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/html5-qrcode"></script>
  <link rel="stylesheet" href="CSS/navbar.css">
  <link rel="stylesheet" href="CSS/conheca.css">
</head>
<body>
  <nav class="navbar">
    <div class="navbar-container">
        <a href="index.php" class="navbar-brand"></a>
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
            <li><a href="gamificacao.php">Perfil</a></li>
            <li><a href="php/logout.php" class="btn-sair">Sair</a></li>
            <?php else: ?>
            <li><a href="cadastro.php" class="btn-cadastrar">Cadastre-se</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
  <header class="header">
    <h1>Conheça os Pontos Turísticos de Mongaguá</h1>
    <p>Explore os lugares mais incríveis da cidade e descubra histórias fascinantes.</p>
  </header>
<!----------------CONTEÚDO---------------->
  <main>
    <section class="grid-container">
      <div class="grid-item" onclick="abrirModal(0)">
          <img src="IMG/pesca.png" alt="Plataforma de Pesca">
          <h2>Plataforma de Pesca</h2>
          <p>Fundada em 1979, a Plataforma de Pesca é um dos principais pontos turísticos de Mongaguá. Um lugar perfeito para pesca e lazer.</p>
      </div>
      <div class="grid-item" onclick="abrirModal(1)">
          <img src="IMG/parkeco.png" alt="Parque Ecológico">
          <h2>Parque Ecológico</h2>
          <p>Com muita história, o parque oferece contato direto com a natureza e diversas atividades recreativas.</p>
      </div>
      <div class="grid-item" onclick="abrirModal(2)">
          <img src="IMG/igrejamatriz.png" alt="Igreja Matriz">
          <h2>Paróquia Nossa Senhora Aparecida</h2>
          <p>Uma das construções mais antigas de Mongaguá, a Paróquia Nossa Senhora Aparecida é rica em história e arquitetura colonial.</p>
      </div>
      <div class="grid-item" onclick="abrirModal(3)">
          <img src="IMG/praiaflorida.png" alt="Praia Flórida Mirim">
          <h2>Praia Flórida Mirim</h2>
          <p>Uma praia de águas limpas e quentes, com ondas suaves, ideal para famílias com crianças.</p>
      </div>
      <div class="grid-item" onclick="abrirModal(4)">
          <img src="IMG/praça.dudu.png" alt="Praça Dudu Samba">
          <h2>Praça de Eventos Dudu Samba</h2>
          <p>Local onde ocorrem eventos culturais e de lazer, incluindo o famoso carnaval de Mongaguá.</p>
      </div>
      <div class="grid-item" onclick="abrirModal(5)">
          <img src="IMG/poçoantas.png" alt="Poço das Antas">
          <h2>Poço das Antas</h2>
          <p>Uma das construções mais antigas de Mongaguá, a Igreja Matriz é rica em história e arquitetura colonial.</p>
      </div>
      <div class="grid-item" onclick="abrirModal(6)">
          <img src="IMG/feira.png" alt="Feira de Artesanato">
          <h2>Feira de Artesanato do Centro</h2>
          <p>Um complexo com diversos quiosques que oferecem produtos artesanais locais.</p>
      </div>
      <div class="grid-item" onclick="abrirModal(7)">
          <img src="IMG/santa.mongagua.webp" alt="Morro da Padroeira">
          <h2>Morro da Padroeira</h2>
          <p>Oferece uma vista panorâmica da cidade e abriga a estátua de Nossa Senhora Aparecida, com 15 metros de altura.</p>
      </div>
      <div class="grid-item" onclick="abrirModal(8)">
          <img src="IMG/lemanjaagenor.png" alt="Praia Agenor de Campos">
          <h2>Praia Agenor de Campos</h2>
          <p>Praia bem estruturada com quiosques, coqueiros e uma feira de artesanato, além da estátua de Iemanjá.</p>
      </div>
      <div class="grid-item" onclick="abrirModal(9)">
        <img src="IMG/raulcortez.png" alt="Centro Cultural Raul Cortez">
        <h2>Centro Cultural Raul Cortez</h2>
        <p>Inaugurado em dezembro de 1996, o centro cultural homenageia o ator Raul Cortez e é o coração da cena cultural de Mongaguá.</p>
      </div>
      <!--adicionar mais cards-->
    </section>
  </main>
 <!----------- MODAL ------------>
<div id="modal" class="modal">
  <div class="modal-content">
      <span class="close">&times;</span>
      <h2 id="modal-title"></h2>
      <p id="modal-description"></p>

      <!------ MAPA ------->
      <div id="modal-map" style="height: 400px; margin-top: 20px; border-radius: 10px;"></div>

      <!------ SCANNER DE QR Code -------->
      <div id="qr-reader-container">
          <div class="qr-reader">
              <h2>📷 Leia seu <strong>QR Code aqui!</strong></h2>
              <p>Apontar a câmera do celular para o QR Code do ponto turístico.</p>

              <div id="qr-reader" class="qr-scanner"></div>
              <p id="qr-result"></p>

              <button id="btn-fechar-qr" class="btn-fechar">Fechar Scanner</button>
          </div>
      </div>
  </div>
</div>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
      <script src="JS/navbar.js"></script>
      <script src="JS/conheca.js"></script>

   <footer class="footer">
        <p>&copy; 2025 MongaMap. Todos os direitos reservados.</p>
        <a href="#">Política de Privacidade</a> | <a href="#">Termos de Uso</a>
      </footer>
      
</body>
</html>
