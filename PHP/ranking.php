<?php
include 'conexao.php';
$sql = "SELECT u.nm_usuario, p.nr_parente as pontos 
        FROM tb_usuario u
        JOIN tb_patente p ON u.cd_usuario = p.fk_cd_usuario
        ORDER BY p.nr_parente DESC LIMIT 10";
$res = $conexao->query($sql);
$ranking = [];
while ($r = $res->fetch_assoc()) $ranking[] = $r;

// Array de medalhas para os três primeiros
$medals = ["🥇", "🥈", "🥉"];
?>

<!-- Card de Ranking Bonito -->
<section class="ranking-home">
  <h2><i class="fa-solid fa-trophy"></i> Ranking dos Exploradores</h2>
  <div class="ranking-scroll">
    <ol>
      <?php foreach($ranking as $i => $user): ?>
        <li class="rank-<?php echo $i+1; ?>">
          <span class="pos">
            <?php echo ($i+1) . "º"; ?>
            <?php if ($i < 3) echo ' <span class="medal">'.$medals[$i].'</span>'; ?>
          </span>
          <span class="nome"><?php echo htmlspecialchars($user['nm_usuario']); ?></span>
          <span class="pts"><?php echo $user['pontos']; ?> pontos</span>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
