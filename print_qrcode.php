<?php
include 'PHP/conexao.php';
echo '<h1>QR Codes para impressão</h1>';
echo '<div style="display:flex; flex-wrap:wrap; gap:20px">';
$sql = "SELECT cd_local, nm_local FROM tb_local";
$res = $conexao->query($sql);
while($p = $res->fetch_assoc()):
  $id   = $p['cd_local'];
  $nome = htmlspecialchars($p['nm_local']);
  // URL que vai no QR
  $dest = ("http://mongamap.com.br/conheca.php?scan=$id");
  // QuickChart
  $src  = "https://quickchart.io/qr?text=" . urlencode($dest) . "&size=200";;
?>
  <div style="text-align:center;">
    <img src="<?=$src?>" alt="QR <?=$nome?>" /><br>
    <strong><?=$nome?></strong><br>
    ID=<?=$id?>
  </div>
<?php endwhile;
echo '</div>';
