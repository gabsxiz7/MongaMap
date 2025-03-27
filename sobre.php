<<?php 
 session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós - MongaMap</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="CSS/sobre.css">
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body class="sobre-page">    
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.html" class="navbar-brand"></a>
            <button class="menu-toggle" id="menuToggle" aria-label="Menu">
                <span class="menu-bar"></span>
                <span class="menu-bar"></span>
                <span class="menu-bar"></span>
            </button>
            <ul class="navbar-links" id="navbarLinks">
                <li><a href="index.php">Início</a></li>
                <li><a href="sobre.php">Sobre</a></li>
                <li><a href="conheca.php">Conheça</a></li>
                <li><a href="comentarios.php">Feedback</a></li>
    <?php if (isset($_SESSION['id'])):?> 
            <li><a href="gamificacao.php">Perfil</a></li>
            <li><a href="php/logout.php" class="btn-sair">Sair</a></li>
            <?php else: ?>
                <li><a href="cadastro.php" class="btn-cadastrar">Cadastre-se</a></li>
              <?php endif; ?>
            </ul>
        </div>
    </nav>
        <!------------SEÇÃOZINHA SOBRE NOIS------------>
        <header class="header">
         <h1>Sobre nós</h1>
        </header>
           <section class="sobre-nos fade-in">
        <div class="container">
            <div class="sobre-nos-detalhes">
                <div class="detalhe">
                    <h2><i class="fas fa-users"></i> Nossa Missão</h2>
                    <p>MongaMap é uma iniciativa da Equipe 8-BITS para promover o turismo e a descoberta de Mongaguá através de uma experiência interativa e gamificada. Nossa equipe tem como missão trazer inovação ao setor turístico, utilizando tecnologia para criar experiências únicas.</p>
                </div>
                <div class="detalhe">
                    <h2><i class="fas fa-handshake"></i> Nosso Compromisso</h2>
                    <p>A equipe 8-BITS acredita na importância de fortalecer o turismo local, destacando os principais pontos turísticos de Mongaguá e engajando os visitantes por meio de uma plataforma intuitiva e moderna. Nosso objetivo é incentivar o turismo sustentável e acessível para todos.</p>
                </div>
            </div>
            <div class="sobre-nos-detalhes">
                <div class="detalhe">
                    <h2><i class="fas fa-bullseye"></i> Objetivo</h2>
                    <p>O projeto MongaMap tem como objetivo promover a visibilidade dos pontos turísticos de Mongaguá e criar uma experiência inovadora e criativa para turistas e moradores da cidade. Com o intuito de melhorar o turismo local, nosso projeto transforma a visitação aos pontos turísticos em uma experiência interativa e gamificada. Utilizando tecnologia e jogo como ferramentas principais, MongaMap incentiva as pessoas a conhecerem os pontos turísticos e suas histórias de uma maneira mais divertida podendo ganhar recompensas por suas interações, realizar desafios e completar missões.</p>
                </div>
                <div class="detalhe">
                    <h2><i class="fas fa-lightbulb"></i> Como Surgiu</h2>
                    <p>A ideia do MongaMap surgiu da necessidade de explorar novas formas de entretenimento e promover maior visibilidade às atrações turísticas locais. Mongaguá, com sua riqueza em atrações históricas, culturais e naturais, possui um grande potencial para atrair visitantes. Para tornar a experiência mais atrativa e interativa, a gamificação foi escolhida como solução. Essa abordagem estimula a curiosidade e a interação dos visitantes de maneira inovadora e divertida, além de beneficiar o comércio local.</p>
                </div>
            </div>
        <!--SEÇÃO DA EQUIPE-->
            <section class="team">
                <h2>Nosso Time</h2>
                <div class="team-container">
                 <div class="team-member">
                   <img src="IMG/icon.png" alt="Membro 1">
                    <h3>Emerson</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus ut nam quibusdam tempora cupiditate voluptatem atque odit quia facilis necessitatibus ab sequi voluptate impedit, fugiat, sint voluptatibus officia earum minus.</p>
                </div>
                <div class="team-member">
                   <img src="IMG/icon.png" alt="membro 2">
                    <h3>Emily</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis aliquam ad pariatur magni quae sapiente in? Harum possimus nemo, voluptatum nobis autem neque sunt exercitationem totam in, atque soluta aliquam.</p>
                </div>
                <div class="team-member">
                    <img src="IMG/icon.png" alt="membro 3">
                    <h3>Gabriella</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo nobis aliquam similique, architecto eum, beatae ratione consequatur, blanditiis fuga vel dolorum culpa sequi nostrum veniam alias commodi voluptas expedita facilis!</p>
                </div>
                <div class="team-member">
                    <img src="IMG/icon.png" alt="membro4">
                    <h3>Guilherme</h3>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Laudantium quia eligendi debitis accusamus voluptates iusto vitae delectus doloremque in, fugit molestias. Mollitia beatae, praesentium laudantium voluptate iste enim commodi atque.</p>
                </div>
                <div class="team-member">
                    <img src="IMG/icon.png" alt="membro5">
                    <h3>Thayane</h3>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Amet, consequatur quidem accusantium soluta dolor, necessitatibus fugit quisquam doloribus aliquam sapiente deleniti illum omnis! Dolor veritatis modi inventore dolorem, iste rem.</p>
                </div>
                </div>
            </section>
        <!---SEÇÃO, VISAO, MISSAO E VALORES-->
            <section class="missao-visao-valores">
                <div class="container">
                   <h2>Missão, Visão e Valores</h2>
                    <div class="mvv-detalhes">
                   <!-- missão -->
                        <div class="mvv-item">
                            <h3><i class="fas fa-bullseye"></i> Missão</h3>
                            <p>Nossa missão é promover o turismo sustentável e acessível em Mongaguá, destacando suas belezas naturais e culturais através de uma experiência interativa e gamificada.</p>
                        </div>
                   <!-- visão -->
                        <div class="mvv-item">
                            <h3><i class="fas fa-eye"></i> Visão</h3>
                            <p>Ser reconhecido como a principal plataforma de turismo interativo, inspirando visitantes a explorar e valorizar os pontos turísticos locais.</p>
                        </div>
                        <!-- valores -->
                        <div class="mvv-item">
                            <h3><i class="fas fa-heart"></i> Valores</h3>
                            <ul>
                                <li>Inovação</li>
                                <li>Compromisso com o Turismo Sustentável</li>
                                <li>Valorização da Cultura Local</li>
                                <li>Experiência do Usuário</li>
                               </ul>
                            </div>
                        </div>
                    </div>
                </section>
            <!--link saiba mais e icon da equipe-->
                    <div class="sobre-nos-item">
                       <a href="contato.html" class="link-saiba-mais">
                        Saiba Mais
                        <img src="IMG/equipe.png" alt="Ícone da equipe" class="icon-saiba-mais">
                    </a>
                </div>
        </section>
            <footer class="footer">
                <p>&copy; 2025 MongaMap. Todos os direitos reservados.</p>
                    <a href="#">Política de Privacidade</a> | <a href="#">Termos de Uso</a>
                      </footer>
        <script src="JS/sobre.js"></script>
        <script src="JS/navbar.js"></script>
</body>
</html>
