<?php 
session_start();
include 'conexao.php';

$cd_usuario = $_SESSION['id'] ?? null;
$descricao = $_POST['descricao'] ?? '';
$id_local = $_POST['id_local'] ?? null;
$arquivo = $_FILES['fotos'] ?? null;

// Adicione para evitar SQL injection:
$cd_usuario = mysqli_real_escape_string($conexao, $cd_usuario);
$descricao = mysqli_real_escape_string($conexao, $descricao);
$id_local = mysqli_real_escape_string($conexao, $id_local);

if (isset($arquivo) && $arquivo['error'] === UPLOAD_ERR_OK) {
    $pasta = "../arquivos/";
    $nomeOriginal = $arquivo['name'];
    $novoNome = uniqid();
    $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));
    $caminhoCompleto = $pasta . $novoNome . "." . $extensao;

    $upload = move_uploaded_file($arquivo['tmp_name'], $caminhoCompleto);

    if ($upload) {
        $queryUsuario = "SELECT nm_usuario FROM tb_usuario WHERE cd_usuario = '$cd_usuario'";
        $resUsuario = mysqli_query($conexao, $queryUsuario);
        $dadosUsuario = mysqli_fetch_assoc($resUsuario);
        $nome_usuario = $dadosUsuario['nm_usuario'] ?? 'Desconhecido';

        $query = "INSERT INTO tb_arquivos (nome, path, nome_usuario, descricao)
                  VALUES ('$nomeOriginal', '$caminhoCompleto', '$nome_usuario', '$descricao')";
        mysqli_query($conexao, $query);

        // Agora marca missão de depoimento como concluída:
        if (!empty($id_local)) {
            marcarMissaoDepoimento($conexao, $cd_usuario, $id_local);
        }

        echo "<script>
            alert('Imagem e experiência salvas com sucesso!');
            window.location.href = '../descubra.php';
        </script>";
        exit();
    } else {
        echo "<script>
            alert('Erro ao mover o arquivo para a pasta.');
            window.location.href = '../descubra.php';
        </script>";
        exit();
    }
} elseif ((!isset($arquivo) || $arquivo['error'] == 4) && !empty($cd_usuario) && !empty($descricao)) {
    // Depoimento sem imagem
    $query = "INSERT INTO tb_depoimento (cd_usuario, mensagem)
              VALUES ('$cd_usuario', '$descricao')";
    mysqli_query($conexao, $query);

    // Marca missão de depoimento como concluída:
    if (!empty($id_local)) {
        marcarMissaoDepoimento($conexao, $cd_usuario, $id_local);
    }

    echo "<script>
        alert('Depoimento enviado com sucesso!');
        window.location.href = '../descubra.php';
    </script>";
    exit();

} else {
    echo "<script>
        alert('Por favor, preencha todos os campos.');
        window.location.href = '../descubra.php';
    </script>";
    exit();
}

// FUNÇÃO PARA MARCAR MISSÃO DE DEPOIMENTO COMO CONCLUÍDA
function marcarMissaoDepoimento($conexao, $cd_usuario, $id_local) {
    // Busca missão do tipo "depoimento" para o local
    $sqlMissaoDepo = "SELECT id_missao, pontos FROM tb_missao WHERE fk_local = '$id_local' AND nm_missao LIKE '%depoimento%'";
    $resMissaoDepo = mysqli_query($conexao, $sqlMissaoDepo);
    if ($missaoDepo = mysqli_fetch_assoc($resMissaoDepo)) {
        $idMissaoDepo = $missaoDepo['id_missao'];
        $pontos = (int)$missaoDepo['pontos'];

        // Marca missão concluída
        $sqlConcluirDepo = "
            INSERT INTO tb_usuario_missao (fk_usuario, fk_missao, concluida, data_conclusao)
            VALUES ('$cd_usuario', '$idMissaoDepo', 1, NOW())
            ON DUPLICATE KEY UPDATE concluida=1, data_conclusao=NOW()
        ";
        mysqli_query($conexao, $sqlConcluirDepo);

        // Atualiza pontuação
        $sqlUpdatePatente = "
            UPDATE tb_patente SET nr_parente = nr_parente + $pontos WHERE fk_cd_usuario = '$cd_usuario'
        ";
        mysqli_query($conexao, $sqlUpdatePatente);
    }
}
?>
