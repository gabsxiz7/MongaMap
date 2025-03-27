<<<<<<< HEAD
<<?php 
 session_start();
=======
<?php 
include 'php/conexao.php';
session_start();
>>>>>>> 1d11af47a83da4dcabcbc5178a600adc856a13b3
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Descubra</title>
  <link rel="stylesheet" href="CSS/navbar.css">
  <link rel="stylesheet" href="CSS/descubra.css">
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
<<<<<<< HEAD
            <li><a href="index.php">Início</a></li>
            <li><a href="sobre.php">Sobre</a></li>
            <li><a href="conheca.php">Conheça</a></li>
            <li><a href="trofeus.php">Troféus</a></li>
            <li><a href="comentarios.php">Feedback</a></li>
    <?php if (isset($_SESSION['id'])):?> 
            <li><a href="gamificacao.php">Perfil</a></li>
            <li><a href="php/logout.php" class="btn-sair">Sair</a></li>
            <?php else: ?>
=======
            <li><a href="index.php" class="active">Início</a></li>
            <li><a href="sobre.php">Sobre</a></li>
            <li><a href="conheca.php">Conheça</a></li>
            <li><a href="comentarios.php">Feedback</a></li>
>>>>>>> 1d11af47a83da4dcabcbc5178a600adc856a13b3
            <li><a href="cadastro.php" class="btn-cadastrar">Cadastre-se</a></li>
            <?php endif; ?>
        </ul>
    </div>
  </nav>
    <!-- HEADER -->
    <header class="header">
        <h1>Descubra Mais</h1>
        <p>Explore novas histórias e compartilhe suas experiências incríveis!</p>
    </header>

    <main>

        <!-- SEÇÃO DE DEPOIMENTOS -->
        <section class="depoimentos">
            <h2>O que as pessoas estão dizendo?</h2>
            <div class="slider-container">
                <button class="prev-btn">&#10094;</button>
                <div class="slider">
                    <div class="depoimento">
                        <img src="IMG/icon.png" alt="Usuário 1">
                        <p>"A experiência foi incrível! Conheci lugares que nem imaginava!"</p>
                        <h4>- Jacinto Leite Aquino Pinto</h4>
                    </div>
                    <div class="depoimento">
                        <img src="IMG/icon.png" alt="Usuário 2">
                        <p>"O MongaMap tornou minha viagem muito mais especial."</p>
                        <h4>- Deide Costa</h4>
                    </div>
                    <div class="depoimento">
                        <img src="IMG/icon.png" alt="Usuário 3">
                        <p>"Descobri lugares incríveis usando o MongaMap!"</p>
                        <h4>- Kelly Inguissa</h4>
                    </div>
                    <div class="depoimento">
                        <img src="IMG/icon.png" alt="Usuario 4">
                        <p>"Amei demais os pontos turísticos."</p>
                        <h4>- Isadora Pinto</h4>
                    </div>
                    <div class="depoimento">
                        <img src="IMG/icon.png" alt="Usuario 5">
                        <p>"Achei os lugares zika."</p>
                        <h4>- Paula Ambeno</h4>
                    </div>
                </div>
                <button class="next-btn">&#10095;</button>
            </div>
        </section>

        <!-- SEÇÃO DE EXPERIÊNCIAS VISUAIS -->
        <section class="galeria">
            <h2>Experiências Visuais</h2>
            <div class="experiencia-container">
                <div class="grid" id="galeria-container">
                    <img src="IMG/poçoantas.png" alt="Lugar 1">
                    <img src="IMG/santa.mongagua.webp" alt="Lugar 2">
                    <img src="IMG/feira.png" alt="Lugar 3">
                    <img src="IMG/plataformapp.png" alt="Lugar 4">
                </div>
            </div>
        </section>

        <!-- SEÇÃO DE FORMULÁRIO -->
        <section class="form-experiencia">
            <h2>Compartilhe sua experiência</h2>
            <form action="PHP/upload.php" method="post" id="form-experiencia" enctype="multipart/form-data">
                <label for="nome">Seu Nome:</label>
                <input type="text" id="nome" placeholder="Digite seu nome" required>

                <label for="foto">Escolha uma Foto:</label>
                <input type="file" id="foto" name="fotos" accept="image/*" required>

                <label for="mensagem">Descreva sua experiência:</label>
                <textarea id="mensagem" rows="4" placeholder="Conte sobre sua experiência..." required></textarea>

                <button type="submit">Enviar Depoimento</button>
            </form>
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <p>&copy; 2025 MongaMap. Todos os direitos reservados.</p>
    </footer>

    <script src="JS/descubra.js"></script>
    <script src="JS/navbar.js"></script>

</body>
</html>