<?php
include 'php/conexao.php';
session_start();

//verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fk_cd_quiz = $_POST['fk_cd_quiz'];
    $pergunta = $_POST['ds_pergunta'];
    $correta = $_POST['ds_resposta_correta'];
    $errada1 = $_POST['ds_resposta_errada1'];
    $errada2 = $_POST['ds_resposta_errada2'];
    $errada3 = $_POST['ds_resposta_errada3'];

    $sql = "INSERT INTO tb_pergunta 
        (ds_pergunta, ds_resposta_correta, ds_resposta_errada1, ds_resposta_errada2, ds_resposta_errada3, fk_cd_quiz)
        VALUES ('$pergunta', '$correta', '$errada1', '$errada2', '$errada3', $fk_cd_quiz)";
    
    if (mysqli_query($conexao, $sql)) {
        echo "<script>alert('Pergunta adicionada com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao adicionar pergunta.');</script>";
    }
}
?>
<form method="POST">
    <h2>Adicionar Nova Pergunta</h2>
    <label>ID do Quiz:</label>
    <input type="number" name="fk_cd_quiz" required><br><br>

    <label>Pergunta:</label><br>
    <textarea name="ds_pergunta" required></textarea><br><br>

    <label>Resposta Correta:</label><br>
    <input type="text" name="ds_resposta_correta" required><br><br>

    <label>Resposta Errada 1:</label><br>
    <input type="text" name="ds_resposta_errada1" required><br><br>

    <label>Resposta Errada 2:</label><br>
    <input type="text" name="ds_resposta_errada2" required><br><br>

    <label>Resposta Errada 3:</label><br>
    <input type="text" name="ds_resposta_errada3" required><br><br>

    <button type="submit">Adicionar Pergunta</button>
</form>
