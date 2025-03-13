<?php 


// Recebendo Arquivo

$arquivos = $_FILES['fotos'];

if (isset($_FILES['fotos'])) {

    $pasta = "../arquivos/";
    $NomedoArquivo = $arquivos['name'];
    $NovoNomedoArquivo = uniqid();
    $extensao = strtolower(pathinfo($NomedoArquivo, PATHINFO_EXTENSION));
    $path = $pasta . $NovoNomedoArquivo . "." . $extensao;
    $deu_certo = move_uploaded_file($arquivos['tmp_name'], $path);

if($deu_certo){
    include 'conexao.php';

   $insert = $conexao->query("INSERT INTO tb_arquivos (nome, path) VALUES('$NomedoArquivo', '$path')") or
    die($conexao->error);

    if($insert){
        echo"<script> alert('imagem inserida'); history.back();</script>";
    }
}
}else{
    echo "falha";
}



?>