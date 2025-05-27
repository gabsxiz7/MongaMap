<?php
include 'php/conexao.php';
session_start();

if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    echo "<script>alert('Acesso restrito: apenas administradores podem acessar esta página.'); window.location.href='index.php';</script>";
    exit();
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fk_cd_local = $_POST['fk_cd_local'];
    $pergunta = $_POST['ds_pergunta'];
    $correta = $_POST['ds_resposta_correta'];
    $errada1 = $_POST['ds_resposta_errada1'];
    $errada2 = $_POST['ds_resposta_errada2'];
    $errada3 = $_POST['ds_resposta_errada3'];

    $sql = "INSERT INTO tb_pergunta 
        (ds_pergunta, ds_resposta_correta, ds_resposta_errada1, ds_resposta_errada2, ds_resposta_errada3, fk_cd_local)
        VALUES ('$pergunta', '$correta', '$errada1', '$errada2', '$errada3', $fk_cd_local)";

    if (mysqli_query($conexao, $sql)) {
        echo "<script>alert('Pergunta adicionada com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao adicionar pergunta: " . mysqli_error($conexao) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Pergunta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px auto;
            max-width: 600px;
            padding: 20px;
        }
        h2 {
            color: #004085;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }
        input[type="text"], input[type="number"], textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            margin-top: 20px;
            padding: 10px 25px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<form method="POST">
    <h2>Adicionar Nova Pergunta</h2>
    <label>ID do Local:</label>
    <input type="number" name="fk_cd_local" required>

    <label>Pergunta:</label>
    <textarea name="ds_pergunta" required></textarea>

    <label>Resposta Correta:</label>
    <input type="text" name="ds_resposta_correta" required>

    <label>Resposta Errada 1:</label>
    <input type="text" name="ds_resposta_errada1" required>

    <label>Resposta Errada 2:</label>
    <input type="text" name="ds_resposta_errada2" required>

    <label>Resposta Errada 3:</label>
    <input type="text" name="ds_resposta_errada3" required>

    <button type="submit">Adicionar Pergunta</button>
</form>

</body>
</html>
