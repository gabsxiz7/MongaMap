<?php
<<<<<<< HEAD
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
=======
include 'php/conexao.php';
session_start();
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM tb_usuario WHERE cd_usuario = $id";
    $query = $conexao->query($sql);
    $resultado = $query->fetch_assoc();
} else {
    echo "<script> alert('Você não está logado!'); history.back(); </script>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

>>>>>>> 1d11af47a83da4dcabcbc5178a600adc856a13b3
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamificação - MongaMap</title>
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="CSS/gamificacao.css">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<<<<<<< HEAD
=======

>>>>>>> 1d11af47a83da4dcabcbc5178a600adc856a13b3
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
                <li><a href="index.php" class="active">Início</a></li>
                <li><a href="sobre.php">Sobre</a></li>
                <li><a href="conheca.php">Conheça</a></li>
                <li><a href="feedback.php">Feedback</a></li>
    <?php if (isset($_SESSION['id'])):?> 
            <li><a href="gamificacao.php">Perfil</a></li>
            <li><a href="php/logout.php" class="btn-sair">Sair</a></li>
            <?php else: ?>
              
                <li><a href="cadastro.php" class="btn-cadastrar">Cadastre-se</a></li>
                <?php endif; ?>
=======
                <li><a href="inicio.php" class="active">Início</a></li>
                <li><a href="sobre.php">Sobre</a></li>
                <li><a href="conheca.php">Conheça</a></li>
                <li><a href="comentarios.php">Feedback</a></li>
                <li><a href="php/logout.php" class="btn-cadastrar">Sair</a></li>
>>>>>>> 1d11af47a83da4dcabcbc5178a600adc856a13b3
            </ul>
        </div>
    </nav>
    <header class="header">
        <h1>Gamificação</h1>
        <p>Explore os pontos turísticos de Mongaguá e acompanhe seu progresso.</p>
    </header>
    <!--secao do user-->
<<<<<<< HEAD
       <main class="container-container">
           <!-- seção 1: informações do usuário -->
           <section class="card perfil">
           <h2>Minha Jornada 🎮</h2>
           <img id="fotoUsuario" src="IMG/icon.png" alt="Avatar">
           <h3>Usuário: <strong id="nomeUsuario"><?php echo htmlspecialchars($usuario['nm_usuario']);?></strong></h3>
        <p id="nivelUsuario">Patente: <?php echo htmlspecialchars($usuario['nm_patente'] ?? 'Sem patente');?></p>
        <p id="pontuacaoUsuario">Parente:<?php echo htmlspecialchars($usuario['nr_parente'] ?? '0');?></p>
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
=======
    <main class="container-container">
        <!-- seção 1: informações do usuário -->
        <section class="card perfil">
            <h2>Minha Jornada 🎮</h2>
            <img id="fotoUsuario" src="IMG/icon.png" alt="Perfil" accept="image/*">
            <h3>Usuário: <strong id="nomeUsuario">Usuário</strong></h3>
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
>>>>>>> 1d11af47a83da4dcabcbc5178a600adc856a13b3
    <footer class="footer">
        <p>&copy; 2025 MongaMap. Todos os direitos reservados.</p>
        <a href="#">Política de Privacidade</a> | <a href="#">Termos de Uso</a>
    </footer>
    <script src="JS/gamificacao.js"></script>
    <script src="JS/navbar.js"></script>
<<<<<<< HEAD
</html>
</head>
</body>
=======

</html>
</head>
</body>
>>>>>>> 1d11af47a83da4dcabcbc5178a600adc856a13b3
