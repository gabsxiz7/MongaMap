<?php
include 'PHP/conexao.php';
session_start();

if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    echo "<script>alert('Acesso restrito: apenas administradores podem acessar esta página.'); window.location.href='index.php';</script>";
    exit();
}

// Processa o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nm_local'];
    $endereco = $_POST['nr_endereco_local'];
    $bairro = $_POST['nm_bairro_local'];

    $sql = "INSERT INTO tb_local (nm_local, nr_endereco_local, nm_bairro_local, qt_media_estrelas)
            VALUES ('$nome', $endereco, '$bairro', 0.0)";

    if (mysqli_query($conexao, $sql)) {
        $mensagem = "Ponto turístico cadastrado com sucesso!";
    } else {
        $mensagem = "Erro: " . mysqli_error($conexao);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Ponto Turístico</title>
    <link rel="stylesheet" href="CSS/navbar.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 100px auto;
            max-width: 600px;
            padding: 20px;
        }
        h2 {
            color: #004085;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .mensagem {
            margin-top: 20px;
            font-weight: bold;
            color: green;
        }
    </style>
</head>
<body>

<h2>Adicionar Ponto Turístico</h2>

<?php if (isset($mensagem)) echo "<p class='mensagem'>$mensagem</p>"; ?>

<form method="POST">
    <label>Nome do local:</label>
    <input type="text" name="nm_local" required>

    <label>Número do endereço:</label>
    <input type="number" name="nr_endereco_local" required>

    <label>Bairro:</label>
    <input type="text" name="nm_bairro_local" required>

    <button type="submit">Cadastrar Local</button>
</form>

</body>
</html>
