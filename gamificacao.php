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
// Ranking Top 3
$sqlRanking = "SELECT u.nm_usuario, p.nr_parente as pontos
    FROM tb_usuario u
    JOIN tb_patente p ON u.cd_usuario = p.fk_cd_usuario
    ORDER BY p.nr_parente DESC
    LIMIT 3";
$resRanking = $conexao->query($sqlRanking);
$top3 = [];
while ($r = $resRanking->fetch_assoc()) $top3[] = $r;

// Últimas conquistas = últimos pontos turísticos visitados
$sqlConquistas = "SELECT l.nm_local, ul.data_visita
    FROM tb_usuario_local ul
    JOIN tb_local l ON ul.fk_local = l.cd_local
    WHERE ul.fk_usuario = ?
    ORDER BY ul.data_visita DESC
    LIMIT 5";
$stmtConq = $conexao->prepare($sqlConquistas);
$stmtConq->bind_param("i", $id);
$stmtConq->execute();
$resConquistas = $stmtConq->get_result();

// Missões do usuário
$sqlMissoes ="SELECT m.id_missao, m.nm_missao, m.pontos, m.fk_local, um.concluida, um.data_conclusao
    FROM tb_missao m
    LEFT JOIN tb_usuario_missao um
      ON um.fk_missao = m.id_missao AND um.fk_usuario = ?
    ORDER BY m.id_missao";
$stmtMissao = $conexao->prepare($sqlMissoes);
if (!$stmtMissao) {
    die("Erro no prepare (Missões): " . $conexao->error);
}
$stmtMissao->bind_param("i", $id);
$stmtMissao->execute();
$resMissoes = $stmtMissao->get_result();
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

                <li><a href="index.php" class="active">Início</a></li>
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
        <h1>Gamificação</h1>
        <p>Explore os pontos turísticos de Mongaguá e acompanhe seu progresso.</p>
    </header>
       <main class="container-container">
           <!-- seção 1: informações do usuário -->
           <section class="card perfil">
           <h2>Minha Jornada 🎮</h2>

       <!--exibe a foto atual -->
  <div class="avatar-container">
    <img id="fotoUsuario" 
         src="IMG/<?php echo htmlspecialchars($usuario['nm_foto'] ?? 'icon.png'); ?>" 
         alt="Avatar">
  </div>

         <!-- Formulário para trocar foto -->
  <form action="php/atualiza_foto.php" method="post" enctype="multipart/form-data" class="form-foto">
    <!-- Input “invisível” apenas para pegar o arquivo -->
    <input type="file" name="novaFoto" id="inputNovaFoto" accept="image/*" required>
    <!-- Label estilizado que age como botão -->
    <label for="inputNovaFoto" class="btn-choose">
      Escolher Foto
    </label>
    <!-- Botão de envio estilizado -->
    <button type="submit" class="btn-upload">Atualizar Foto</button>
  </form>

       <!-- Nome atual + botão editar -->
<div class="nome-container">
  <span id="nomeUsuario"><?php echo htmlspecialchars($usuario['nm_usuario']); ?></span>
  <button type="button" class="btn-edit" onclick="toggleEditarNome()">✏️ Editar</button>
</div>

<!-- Formulário para alterar o nome (escondido por padrão) -->
<form action="php/atualiza_nome.php" method="post" class="form-nome" id="formEdicaoNome">
  <input type="text" name="novoNome" id="inputNovoNome" 
         value="<?php echo htmlspecialchars($usuario['nm_usuario']); ?>" 
         maxlength="50" required>
  <button type="submit" class="btn-salvar-nome">Salvar</button>
  <button type="button" class="btn-cancelar-nome" onclick="toggleEditarNome()">Cancelar</button>
</form>

  <p id="nivelUsuario">Patente: <span><?php echo htmlspecialchars($usuario['nm_patente'] ?? 'Sem patente'); ?></span></p>
  <p id="pontuacaoUsuario">Pontuação: <span><?php echo htmlspecialchars($usuario['nr_parente'] ?? '0'); ?> ⭐</span></p>
  <?php if (!empty($usuario['ds_descricao'])): ?>
    <div class="descricao-perfil">
      <p><?php echo nl2br(htmlspecialchars($usuario['ds_descricao'])); ?></p>
    </div>
  <?php endif; ?>
</section>

        <!--conquistas Recentes -->
          <section class="card conquistas">
    <h3>Últimas Conquistas 🎉</h3>
   <div class="conquistas-lista">
      <?php while($row = $resConquistas->fetch_assoc()): ?>
          <div class="conquista-item">
            <span>🏆 Visitou <b><?php echo htmlspecialchars($row['nm_local']); ?></b></span>
            <span class="conquista-data">
              (<?php echo date('d/m/Y', strtotime($row['data_visita'])); ?>)
            </span>
          </div>
      <?php endwhile; ?>
  </div>
</section>

       <!-- missões -->
<section class="card">
    <h3>Missões 📜</h3>
   <div id="listaMissoes" class="missoes-lista">
   <?php while($row = $resMissoes->fetch_assoc()): ?>
   <div class="missao-item <?php echo $row['concluida'] ? 'missao-concluida':'missao-nao-concluida'; ?>">
        <span class="missao-desc">
            <?php echo htmlspecialchars($row['nm_missao']); ?> (+<?php echo $row['pontos']; ?> pts)
        </span>
        <?php if ($row['concluida']): ?>
            <span class="missao-check">✔️</span>
        <?php else: ?>
            <form method="GET" action="conheca.php">
                <input type="hidden" name="local" value="<?php echo $row['fk_local']; ?>">
                <button class="btn-missoes" type="submit">Concluir</button>
            </form>
        <?php endif; ?>
    </div>
   <?php endwhile; ?>
</div>
</section>

    <!-- seção 5: Ranking de Usuários -->
    <section class="card ranking">
        <h3>Ranking 🏆</h3>
         <ol class="ranking-li">
          <?php 
            $medals = ['🥇','🥈','🥉'];
            foreach($top3 as $i => $user): 
          ?>
            <li>
               <?php
                  if ($i < 3) {
                  // Só medalha para o Top 3, sem número
                    echo $medals[$i] . " ";
                  } else {
                 // Numeração normal para os outros
          echo ($i+1) . "º ";
         }
          echo htmlspecialchars($user['nm_usuario']) . " - " . $user['pontos'] . " pontos";
        ?>
     </li>
    <?php endforeach; ?>
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
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="JS/navbar.js"></script>
     <script src="JS/gamificacao.js"></script>
     </body>
</html>



