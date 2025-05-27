<?php
include 'PHP/conexao.php';
session_start();

// Define o ponto turístico padrão (id = 1) caso nenhum seja passado na URL
$id_local = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Buscar nome do ponto turístico (opcional, para exibir no título do quiz)
$sqlLocal = "SELECT nm_local FROM tb_local WHERE cd_local = $id_local";
$resultLocal = mysqli_query($conexao, $sqlLocal);
$local = mysqli_fetch_assoc($resultLocal);

// Buscar a pergunta do local
$sqlPergunta = "SELECT * FROM tb_pergunta WHERE fk_cd_local = $id_local LIMIT 1";
$resultPergunta = mysqli_query($conexao, $sqlPergunta);
$pergunta = mysqli_fetch_assoc($resultPergunta);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - MongaMap</title>
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="CSS/quiz.css">
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
            <?php if (isset($_SESSION['id'])): ?> 
                <li><a href="quiz.php">Quiz</a></li>
                <li><a href="gamificacao.php">Perfil</a></li>
                <li><a href="php/logout.php" class="btn-sair">Sair</a></li>
            <?php else: ?>
                <li><a href="cadastro.php" class="btn-cadastrar">Cadastre-se</a></li>
            <?php endif; ?>
        </ul> 
    </div> 
</nav> 

<header class="header">
    <h1>Desafie seus conhecimentos</h1>
    <p>Responda o quiz sobre os pontos turísticos de Mongaguá e ganhe pontos!</p>
</header>

<main class="container">
<div class="quiz-container">

<?php
//buscar dados do local (incluindo imagem)
$sqlLocal = "SELECT nm_imagem_local FROM tb_local WHERE cd_local = $id_local";
$resultLocal = mysqli_query($conexao, $sqlLocal);
$dadosLocal = mysqli_fetch_assoc($resultLocal);

// Define imagem (usa imagem padrão se não tiver)
$imagem = $dadosLocal['nm_imagem_local'] ?? 'default.jpg';

echo "<img src='IMG/$imagem' alt='Imagem do Local' class='quiz-imagem'>";

?>

<div class="quiz-conteudo">
<?php
echo "<form method='POST' action='php/processa_quiz.php'>";
echo "<input type='hidden' name='id_local' value='$id_local'>";

// Título do quiz com nome do local
if ($local) {
    echo "<h2>Quiz: {$local['nm_local']}</h2>";
} else {
    echo "<h2>Quiz</h2>";
}

// Se houver pergunta
if ($pergunta) {
  $respostas = [
    $pergunta['ds_resposta_correta'],
    $pergunta['ds_resposta_errada1'],
    $pergunta['ds_resposta_errada2'],
    $pergunta['ds_resposta_errada3']
];

shuffle($respostas); // embaralha só as respostas

$letras = ['a', 'b', 'c', 'd'];

echo "<div style='margin-bottom: 20px;'>";
echo "<p><strong>{$pergunta['ds_pergunta']}</strong></p>";

foreach ($respostas as $index => $resposta) {
    $letra = $letras[$index];
    echo "<label><input type='radio' name='resposta[{$pergunta['cd_pergunta']}]' value='$resposta' required> <strong>{$letra})</strong> $resposta</label><br>";
}

    echo "</div>";
    echo "<button type='submit' class='botao-enviar'>Enviar Respostas</button>";
    echo "</form>";
} else {
    echo "<p>Nenhuma pergunta cadastrada para este ponto turístico ainda.</p>";
}
?>
</div> 
</div> 
</main>
<script src="JS/quiz.js"></script>
<footer class="footer">
  <p>&copy; 2025 MongaMap. Todos os direitos reservados.</p>
  <a href="#">Política de Privacidade</a> | <a href="#">Termos de Uso</a>
</footer>
</body>
</html>
