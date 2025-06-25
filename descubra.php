<?php 
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
  <title>Descubra</title>
  <link rel="icon" type="image/x-icon" href="IMG/pinomark1.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="CSS/navbar.css">
  <link rel="stylesheet" href="CSS/descubra.css">
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
    <!-- HEADER -->
    <header class="header">
        <h1>Descubra Mais</h1>
        <p>Explore novas histórias e compartilhe suas experiências incríveis!</p>
    </header>

    <main>

       <!-- SEÇÃO DE DEPOIMENTOS -->
<section class="depoimentos">
    <h2>
        <i class="fa-solid fa-users"></i>
        O que as pessoas estão dizendo?
    </h2>
    <div class="depoimentos-marquee">
        <div class="depoimentos-track">
            <?php
            include "PHP/conexao.php";
            $query = "SELECT d.mensagem, d.data_envio, u.nm_usuario, u.nm_foto
            FROM tb_depoimento d
            JOIN tb_usuario u ON d.cd_usuario = u.cd_usuario
            ORDER BY d.data_envio DESC";
            $result = mysqli_query($conexao, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='depoimento'>";
                    echo "<img src='IMG/" . htmlspecialchars($row['nm_foto']) . "' alt='Foto do usuário'>";
                    echo "<p>\"" . htmlspecialchars($row['mensagem']) . "\"</p>";
                    echo "<h4>- " . htmlspecialchars($row['nm_usuario']) . "</h4>";
                    echo "</div>";

                }
            } else {
                echo "<p>Ninguém deixou um depoimento ainda. Seja o primeiro!</p>";
            }
            ?>
        </div>
    </div>
</section>


      <!-- SEÇÃO DE EXPERIÊNCIAS VISUAIS -->
<section class="galeria">
    <h2>Experiências Visuais</h2>
    <div class="experiencia-grid">
        <?php
        include "PHP/conexao.php";
        $query = "SELECT * FROM tb_arquivos ORDER BY id_arquivo DESC";
        $result = mysqli_query($conexao, $query);

        if (!$result) {
            die("Erro na consulta SQL: " . mysqli_error($conexao));
        }

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='card-exp'>";
                echo "<img src='" . substr($row['path'], 3) . "' alt='Imagem de " . $row['nome_usuario'] . "'>";
                echo "<p>\"" . $row['descricao'] . "\"</p>";
                echo "<h4>- " . $row['nome_usuario'] . "</h4>";
                echo "</div>";
            }
        } else {
            echo "<p>Seja o primeiro a compartilhar uma experiência!</p>";
        }
        ?>
    </div>
</section>

        <!-- SEÇÃO DE FORMULÁRIO -->
        <section class="form-experiencia">
    <h2>Compartilhe sua experiência</h2>
    <form action="PHP/upload.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="id_local">Sobre qual local é sua experiência?</label>
        <select name="id_local" id="id_local" required>
            <option value="">Selecione o local</option>
            <option value="14">Plataforma de Pesca</option>
            <option value="15">Parque Ecológico</option>
            <option value="16">Feira de Artesanato</option>
            <!-- ...adicione todos os locais... -->
        </select>
    </div>
    <!-- ...restante do formulário... -->
    <div class="form-group">
        <input type="file" id="foto" name="fotos" accept="image/*">
        <span class="tooltip" data-tooltip="Selecione uma foto da sua experiência (opcional)">
            <i class="fa-solid fa-images"></i>
        </span>
    </div>
    <div class="form-group">
        <textarea name="descricao" id="mensagem" rows="3" placeholder="Conte sobre sua experiência..." required></textarea>
        <span class="tooltip" data-tooltip="Fale brevemente sobre o que você viveu!"> 
            <i class="fa-solid fa-comment-dots"></i>
        </span>
    </div>
    <button type="submit">Enviar Depoimento</button>
</form>
</section>
</main>
    <!-- FOOTER -->
    <footer class="footer">
        <p>&copy; 2025 MongaMap. Todos os direitos reservados.</p>
        <a href="#">Política de Privacidade</a> | <a href="#">Termos de Uso</a>
      </footer>

    <script src="JS/descubra.js"></script>
    <script src="JS/navbar.js"></script>

</body>
</html>