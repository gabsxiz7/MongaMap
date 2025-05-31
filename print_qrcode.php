<?php
// print_qrcode.php
include 'php/conexao.php';

echo '<h1>QR Codes para impressão</h1>';
echo '<p>Aponte o QR para: https://localhost/MongaMap/conheca.php?scan=&lt;id&gt;</p>';
echo '<div style="display:flex; flex-wrap:wrap; gap:20px;">';

$sql = "SELECT cd_local, nm_local FROM tb_local";
$res = $conexao->query($sql);

while($p = $res->fetch_assoc()):
    $id    = $p['cd_local'];
    $nome  = htmlspecialchars($p['nm_local']);
    // monta a URL que o QR irá codificar
    $dest = urlencode("http://localhost/MongaMap/conheca.php?scan=$id");
    // URL do Google Chart API
    $src  = "https://quickchart.io/qr?text={$dest}&size=200";
?>
    <div style="text-align:center;">
        <img src="<?= $src ?>" alt="QR <?= $nome ?>" /><br>
        <strong><?= $nome ?></strong><br>
        ID=<?= $id ?>
    </div>
<?php
endwhile;

echo '</div>';
