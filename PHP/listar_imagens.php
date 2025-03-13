<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Imagens</title>
</head>
<body>
<h1>Lista de Arquivos</h1>
    <table border="1" cellpadding="10">
        <thead>
            <th>Imagem</th>
            <th>Arquivo</th>
            <th>Data de Envio</th>
        </thead>
        <tbody>
            <?php
            include 'conexao.php';
            $sql_query = $conexao->query("SELECT * FROM tb_arquivos");
            while($arquivo = $sql_query->fetch_assoc()) {
            ?>
            <tr>
                <td><img height="50" src="<?php echo $arquivo['path']; ?>" alt=""></td>
                <td><a target="_blank" href="<?php echo $arquivo['path']; ?>"><?php echo $arquivo['nome']; ?></a></td>
                <td><?php echo date("d/m/Y H:i", strtotime($arquivo['data_upload'])); ?></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>
</html>