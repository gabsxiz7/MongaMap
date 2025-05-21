<?php
include 'PHP/conexao.php';
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - MongaMap</title>
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="CSS/quiz.css">
    <!-- aqui você pode adicionar mais estilos se quiser -->
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
$id_local = $_GET['id'];

// Buscar quiz do local
$sqlQuiz = "SELECT * FROM tb_quiz WHERE fk_cd_local = $id_local LIMIT 1";
$resultQuiz = mysqli_query($conexao, $sqlQuiz);
$quiz = mysqli_fetch_assoc($resultQuiz);

// Buscar perguntas
$sqlPerguntas = "SELECT * FROM tb_pergunta WHERE fk_cd_quiz = {$quiz['cd_quiz']}";
$resultPerguntas = mysqli_query($conexao, $sqlPerguntas);

// Mostrar imagem
echo "<img src='";

if ($id_local == 1) {
    echo "IMG/paisagem.jpg";
} elseif ($id_local == 2) {
    echo "imagens/plataforma_pesca.jpg";
} else {
    echo "imagens/default.jpg";
}

echo "' alt='Imagem do Local' class='quiz-imagem'>";

?>

<div class="quiz-conteudo">
<?php
// Formulário
echo "<form method='POST' action='php/processa_quiz.php'>";
echo "<input type='hidden' name='id_local' value='$id_local'>";

echo "<h2>Quiz: {$quiz['nm_quiz']}</h2>";

while ($pergunta = mysqli_fetch_assoc($resultPerguntas)) {
    $respostas = [
        $pergunta['ds_resposta_correta'],
        $pergunta['ds_resposta_errada1'],
        $pergunta['ds_resposta_errada2'],
        $pergunta['ds_resposta_errada3']
    ];
    shuffle($respostas);

    echo "<div style='margin-bottom: 20px;'>";
    echo "<p><strong>{$pergunta['ds_pergunta']}</strong></p>";
    foreach ($respostas as $resposta) {
        echo "<label><input type='radio' name='resposta[{$pergunta['cd_pergunta']}]' value='$resposta'> $resposta</label><br>";
    }
    echo "</div>";
}

echo "<button type='submit' class='botao-enviar'>Enviar Respostas</button>";
echo "</form>";
?>
</div> <!-- fecha quiz-conteudo -->
</div> <!-- fecha quiz-container -->
</main>
</body>
</html>
