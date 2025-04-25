<?php
include 'PHP/conexao.php';
session_start();

$id_local = $_GET['id']; // Ex: quiz.php?id=1

// Buscar quiz do local
$sqlQuiz = "SELECT * FROM tb_quiz WHERE fk_cd_local = $id_local LIMIT 1";
$resultQuiz = mysqli_query($conexao, $sqlQuiz);
$quiz = mysqli_fetch_assoc($resultQuiz);

// Buscar perguntas
$sqlPerguntas = "SELECT * FROM tb_pergunta WHERE fk_cd_quiz = {$quiz['cd_quiz']}";
$resultPerguntas = mysqli_query($conexao, $sqlPerguntas);

echo "<h2>Quiz: {$quiz['nm_quiz']}</h2>";

while ($pergunta = mysqli_fetch_assoc($resultPerguntas)) {
    $respostas = [
        $pergunta['ds_resposta_correta'],
        $pergunta['ds_resposta_errada1'],
        $pergunta['ds_resposta_errada2'],
        $pergunta['ds_resposta_errada3']
    ];
    shuffle($respostas); // Embaralhar as respostas

    echo "<form method='POST'>";
    echo "<p><strong>{$pergunta['ds_pergunta']}</strong></p>";
    foreach ($respostas as $resposta) {
        echo "<input type='radio' name='resposta[{$pergunta['cd_pergunta']}]' value='$resposta'> $resposta<br>";
    }
    echo "<br>";
}
echo "<button type='submit'>Enviar Respostas</button>";
echo "</form>";
?>