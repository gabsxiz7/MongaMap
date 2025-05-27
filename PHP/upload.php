<?php 
session_start();
//recebendo arquivo
include 'conexao.php';

$cd_usuario = $_SESSION['id'] ?? null;
$descricao = $_POST['descricao'] ?? '';
$arquivo = $_FILES['fotos'] ?? null;

    //envia imagem + insere na tb_arquivos
   if (isset($arquivo) && $arquivo['error'] === UPLOAD_ERR_OK) {
    $pasta = "../arquivos/";
    $nomeOriginal = $arquivo['name'];
    $novoNome = uniqid();
    $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));
    $caminhoCompleto = $pasta . $novoNome . "." . $extensao;

    $upload = move_uploaded_file($arquivo['tmp_name'], $caminhoCompleto);

    if ($upload) {
        //pega o nome do usuário para exibir no tb_arquivos
         $queryUsuario = "SELECT nm_usuario FROM tb_usuario WHERE cd_usuario = '$cd_usuario'";
        $resUsuario = mysqli_query($conexao, $queryUsuario);
        $dadosUsuario = mysqli_fetch_assoc($resUsuario);
        $nome_usuario = $dadosUsuario['nm_usuario'] ?? 'Desconhecido';

        $query = "INSERT INTO tb_arquivos (nome, path, nome_usuario, descricao)
                  VALUES ('$nomeOriginal', '$caminhoCompleto', '$nome_usuario', '$descricao')";
        mysqli_query($conexao, $query);

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
    //envio apenas de depoimento (sem imagem)
    } elseif ((!isset($arquivo) || $arquivo['error'] == 4) && !empty($cd_usuario) && !empty($descricao)) {
        $query = "INSERT INTO tb_depoimento (cd_usuario, mensagem)
                  VALUES ('$cd_usuario', '$descricao')";
        mysqli_query($conexao, $query);

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
?>
