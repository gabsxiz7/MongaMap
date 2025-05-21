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
    echo "<a href='../quiz.php?id=$id_local'>Tentar novamente</a>";
}
?>
