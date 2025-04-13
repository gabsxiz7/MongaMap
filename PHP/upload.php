<?php 
//recebendo arquivo
include 'conexao.php';

$nome_usuario = $_POST['nome_usuario'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$arquivo = $_FILES['fotos'] ?? null;

if ($arquivo && $arquivo['error'] === UPLOAD_ERR_OK) {
    //envia imagem + insere na tb_arquivos
    $pasta = "../arquivos/";
    $nomeOriginal = $arquivo['name'];
    $novoNome = uniqid();
    $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));
    $caminhoCompleto = $pasta . $novoNome . "." . $extensao;

    $upload = move_uploaded_file($arquivo['tmp_name'], $caminhoCompleto);

    if ($upload) {
        $query = "INSERT INTO tb_arquivos (nome, path, nome_usuario, descricao)
                  VALUES ('$nomeOriginal', '$caminhoCompleto', '$nome_usuario', '$descricao')";
        $inserir = mysqli_query($conexao, $query);

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

} else {
    //salvando apenas depoimento sem imagem
    if (!empty($nome_usuario) && !empty($descricao)) {
        $query = "INSERT INTO tb_depoimento (nome_usuario, mensagem)
                  VALUES ('$nome_usuario', '$descricao')";
        $inserir = mysqli_query($conexao, $query);

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
}
?>
