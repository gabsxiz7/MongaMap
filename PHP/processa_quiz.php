<?php
include 'conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $respostas = isset($_POST['resposta']) ? $_POST['resposta'] : [];
    $pontos = 0;
    $total = count($respostas);

    foreach ($respostas as $idPergunta => $respostaUsuario) {
        $sql = "SELECT ds_resposta_correta FROM tb_pergunta WHERE cd_pergunta = $idPergunta";
        $resultado = mysqli_query($conexao, $sql);
        $linha = mysqli_fetch_assoc($resultado);

        if ($linha['ds_resposta_correta'] == $respostaUsuario) {
            $pontos++;
        }
    }

    echo "<h2>Resultado do Quiz</h2>";
    echo "<p>Você acertou <strong>$pontos</strong> de <strong>$total</strong> perguntas.</p>";

    $id_local = isset($_POST['id_local']) ? $_POST['id_local'] : 1;
    $proximo_local = $id_local + 1;
    echo "<a href='../quiz.php?id=$id_local'>Tentar novamente</a>";
}
/// Verifica se existe pergunta no próximo local
$check = mysqli_query($conexao, "SELECT * FROM tb_pergunta WHERE fk_cd_local = $proximo_local");

if (mysqli_num_rows($check) > 0) {
    echo "<a href='../quiz.php?id=$proximo_local'>Ir para o próximo quiz</a>";
} else {
    echo "<p>Você completou todos os quizzes disponíveis!</p>";
    echo "<a href='../quiz.php?id=1'>Voltar para o início</a>";
}
?>
