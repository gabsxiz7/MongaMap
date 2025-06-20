<?php
include 'PHP/conexao.php';
session_start();

$id_local = isset($_GET['id']) ? intval($_GET['id']) : 1;
$mensagem = "";
$proximo_local = $id_local + 1;

// Resetar sessão se chegou ao final
if (isset($_GET['reset']) && $_GET['reset'] == 1) {
    unset($_SESSION['pontos'], $_SESSION['total']);
    header("Location: quiz.php?id=14");
    exit();
}

// Buscar nome do ponto turístico e pergunta
$sqlLocal = "SELECT * FROM tb_local WHERE cd_local = $id_local";
$resultLocal = mysqli_query($conexao, $sqlLocal);
$local = mysqli_fetch_assoc($resultLocal);

$sqlPergunta = "SELECT * FROM tb_pergunta WHERE fk_cd_local = $id_local LIMIT 1";
$resultPergunta = mysqli_query($conexao, $sqlPergunta);
$pergunta = mysqli_fetch_assoc($resultPergunta);

if ($pergunta) {
    $alternativas = [
        'a' => $pergunta['ds_resposta_correta'],
        'b' => $pergunta['ds_resposta_errada1'],
        'c' => $pergunta['ds_resposta_errada2'],
        'd' => $pergunta['ds_resposta_errada3']
    ];

      // Embaralhar textos das alternativas mantendo letras fixas
    if (!isset($_SESSION['ordem_quiz'][$pergunta['cd_pergunta']])) {
        $textos = array_values($alternativas);
        shuffle($textos);
        $_SESSION['ordem_quiz'][$pergunta['cd_pergunta']] = $textos;
    }

    $textos_embaralhados = $_SESSION['ordem_quiz'][$pergunta['cd_pergunta']];
    $letras = ['a', 'b', 'c', 'd'];


   // Processar resposta
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $respostas = $_POST['resposta'] ?? [];
        $resposta_usuario = $respostas[$pergunta['cd_pergunta']] ?? null;

        $resposta_correta = $pergunta['ds_resposta_correta'];

        if (!isset($_SESSION['pontos'])) {
            $_SESSION['pontos'] = 0;
            $_SESSION['total'] = 0;
        }

        $_SESSION['total']++;

        if ($resposta_usuario === $resposta_correta) {
            $_SESSION['pontos']++;
        }

        $mensagem = "<h2>Resultado do Quiz</h2>
        <p>Você acertou <strong>{$_SESSION['pontos']}</strong> de <strong>{$_SESSION['total']}</strong> perguntas.</p>";

        $check = mysqli_query($conexao, "SELECT * FROM tb_pergunta WHERE fk_cd_local = $proximo_local");
        if (mysqli_num_rows($check) > 0) {
            $mensagem .= "<div style='margin-top: 20px;'><a class='botao-enviar' href='quiz.php?id=$proximo_local'>Próximo Quiz</a></div>";
        } else {
            $mensagem .= "<p>Você completou todos os quizzes!</p>
            <div style='margin-top: 20px;'><a class='botao-enviar' href='quiz.php?reset=1'>Recomeçar</a></div>";
        }
    }
}
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
if ($local && isset($local['nm_imagem_local']) && file_exists("IMG/" . $local['nm_imagem_local'])) {
    $imagem = $local['nm_imagem_local'];
} else {
    $imagem = 'default.jpg';
}
echo "<img src='IMG/$imagem' alt='Imagem do Local' class='quiz-imagem'>";
?>
<div class="quiz-conteudo">
<?php
     if (!empty($mensagem)) {
    echo $mensagem;
} elseif ($pergunta) {
    echo "<form method='POST'>";
    echo "<input type='hidden' name='id_local' value='$id_local'>";
    echo "<h2>Quiz: {$local['nm_local']}</h2>";
    echo "<div style='margin-bottom: 20px;'><p><strong>{$pergunta['ds_pergunta']}</strong></p>";

    foreach ($textos_embaralhados as $index => $texto) {
        $letra = $letras[$index];
        $resposta_usuario = $_POST['resposta'][$pergunta['cd_pergunta']] ?? null;
        $checked = ($texto === $resposta_usuario) ? 'checked' : '';
        $classe = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($texto === $pergunta['ds_resposta_correta']) {
                $classe = 'certa';
            } elseif ($texto === $resposta_usuario) {
                $classe = 'errada';
            }
        }
        echo "<label class='$classe'><input type='radio' name='resposta[{$pergunta['cd_pergunta']}]' value='$texto' $checked required> <strong>{$letra})</strong> $texto</label><br>";
    }

    echo "</div><button type='submit' class='botao-enviar'>Enviar Respostas</button></form>";
} else {
    echo "<p>Nenhuma pergunta cadastrada para este ponto turístico ainda.</p>";
}
?>
</div></div>
</main>

<script src="JS/quiz.js"></script>
<footer class="footer">
  <p>&copy; 2025 MongaMap. Todos os direitos reservados.</p>
  <a href="#">Política de Privacidade</a> | <a href="#">Termos de Uso</a>
</footer>
</body>
</html>
