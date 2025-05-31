<?php
include 'php/conexao.php'; 
session_start();

if (!isset($_SESSION['id'])) {
    echo "<script> alert('Você não está logado!'); history.back(); </script>";
    exit();
}

$id = $_SESSION['id']; 


$sql = "SELECT 
            u.cd_usuario, 
            u.nm_usuario, 
            u.nm_email, 
            u.nr_telefone, 
            u.ds_descricao,
            u.nm_foto,
            p.nm_patente, 
            p.nr_parente 
        FROM tb_usuario u
        LEFT JOIN tb_patente p ON u.cd_usuario = p.fk_cd_usuario
        WHERE u.cd_usuario = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();
} else {
    echo "<script> alert('Usuário não encontrado!'); history.back(); </script>";
    exit();
}

$stmt->close();
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
            <li><a href="quiz.php?id=1">Quiz</a></li>
            <li><a href="gamificacao.php">Perfil</a></li>
            <li><a href="php/logout.php" class="btn-sair">Sair</a></li>
            <?php else: ?>
              
                <li><a href="cadastro.php" class="btn-cadastrar">Cadastre-se</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <header class="header">
        <h1>Gamificação</h1>
        <p>Explore os pontos turísticos de Mongaguá e acompanhe seu progresso.</p>
    </header>
       <main class="container-container">
           <!-- seção 1: informações do usuário -->
           <section class="card perfil">
           <h2>Minha Jornada 🎮</h2>

        <img id="fotoUsuario" src="IMG/<?php echo htmlspecialchars($usuario['nm_foto'] ?? 'icon.png'); ?>" alt="Avatar">

        <!-- Nome do usuário -->
        <h3>Usuário: <span id="nomeUsuario"><?php echo htmlspecialchars($usuario['nm_usuario']); ?></span></h3>

         <!-- Patente e pontuação -->
        <p id="nivelUsuario">Patente: <span style="color: white;"><?php echo htmlspecialchars($usuario['nm_patente'] ?? 'Sem patente'); ?></span></p>
        <p id="pontuacaoUsuario">Pontuação: <span style="color: white;"><?php echo htmlspecialchars($usuario['nr_parente'] ?? '0'); ?>⭐</span></p>

        <!--descrição -->
        <?php if (!empty($usuario['ds_descricao'])): ?>
        <div class="descricao-perfil">
        <p><?php echo nl2br(htmlspecialchars($usuario['ds_descricao'])); ?></p>
            </div>
       <?php endif; ?>
     </section>

        <!-- seção 2: Barra de Progresso -->
           <section class="card barra-progresso">
           <h3>Nível 1 🚀</h3>
           <progress value="0" max="5000"></progress>
        <p id="progressText">0 / 5000 pontos</p>
    </section>
        <!--conquistas Recentes -->
           <section class="card conquistas">
           <h3>Últimas Conquistas 🎉</h3>
        <ul id="listaConquistas">
          <!--conquistas aparece aq pelo js-->
        </ul>
    </section>
        <!-- missões-->
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
            <button onclick="marcarMapa(-24.134243, -46.692596)">Ver no Mapa</button>
        </div>
        <div class="ponto-turistico">
            <img src="IMG/parkeco.png" alt="Parque">
            <h3>Parque Ecológico</h3>
            <p>Contato direto com a natureza.</p>
            <button onclick="marcarMapa(-24.134406, -46.695230)">Ver no Mapa</button>
        </div>
        <div class="ponto-turistico">
            <img src="IMG/igrejamatriz.png" alt="Igreja Matriz">
            <h3>Igreja Matriz</h3>
            <p>Rica em história e arquitetura colonial.</p>
            <button onclick="marcarMapa(-24.094984, -46.620291)">Ver no Mapa</button>
        </a>
        </div>
        <div class="ponto-turistico">
            <img src="IMG/praiaflorida.png" alt="Praia Flórida Mirim">
            <h3>Praia Flórida Mirim</h3>
            <p>Praia de aguas limpas, ideal para famílias.</p>
            <button onclick="marcarMapa(-24.132455, -46.711498)">Ver no Mapa</button>
        </div>
        <div class="ponto-turistico">
            <img src="IMG/praça.dudu.png" alt="Praça Dudu Samba">
            <h3>Praça Dudu Samba</h3>
            <p>Famosa praça de eventos culturais.</p>
            <button onclick="marcarMapa(-24.09606, -46.62045)">Ver no Mapa</button>
        </div>
        <div class="ponto-turistico">
            <img src="IMG/poçoantas.png" alt="Poço das Antas">
            <h3>Poço das Antas</h3>
            <p>Área natural para relaxar e explorar.</p>
            <button onclick="marcarMapa(-24.08973, -46.62292)">Ver no Mapa</button>
        </a>
        </div>
        <div class="ponto-turistico">
            <img src="IMG/artesanato.png" alt="Feira de Artesanato">
            <h3>Feira de Artesanato</h3>
            <p>Feira de produtos locais e artesanais.</p>
            <button onclick="marcarMapa(-24.09462, -46.61961)">Ver no Mapa</button>
        </div>
          <div class="ponto-turistico">
            <img src="IMG/santa.png" alt="Morro da Padroeira">
            <h3>Morro da Padroeira</h3>
            <p>Vista panorâmica incrível da cidade.</p>
            <button onclick="marcarMapa(-24.09119, -46.61684)">Ver no Mapa</button>
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

