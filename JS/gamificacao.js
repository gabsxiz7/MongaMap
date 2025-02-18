let h2 = document.querySelector('h2');
let coordenadasElemento = document.getElementById("coordenadas");
var map;
var userMarker; // Variável global para o marcador do usuário

// Inicializa o mapa
function success(pos) {
    console.log("📍 Nova localização recebida:");
    console.log("Latitude:", pos.coords.latitude);
    console.log("Longitude:", pos.coords.longitude);
    console.log("Precisão (metros):", pos.coords.accuracy);

    const latitude = pos.coords.latitude;
    const longitude = pos.coords.longitude;

    // Atualiza as coordenadas na <p> correto
    coordenadasElemento.textContent = `Latitude: ${latitude.toFixed(6)}, Longitude: ${longitude.toFixed(6)}`;

    if (!map) {
        //se o mapa ainda não foi criado, cria agora
        map = L.map('map').setView([latitude, longitude], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        //adiciona o marcador inicial
        userMarker = L.marker([latitude, longitude]).addTo(map)
            .bindPopup('📍 Você está aqui!')
            .openPopup();
    } else {
        // Apenas move o marcador para a nova posição
        userMarker.setLatLng([latitude, longitude]);
        map.setView([latitude, longitude], 13);
    }

    // Adiciona os pontos turísticos apenas uma vez
    if (!map.pontosTuristicosAdicionados) {
        const pontosTuristicos = [
            { coords: [-24.134243, -46.692596], nome: 'Plataforma de Pesca', descricao: 'Local incrível para pesca e lazer.' },
            { coords: [-24.134406, -46.695230], nome: 'Parque Ecológico', descricao: 'Contato direto com a natureza.' },
            { coords: [-24.094984, -46.620291], nome: 'Paróquia Nossa Senhora Aparecida', descricao: 'Uma das construções mais antigas de Mongaguá.' },
            { coords: [-24.132455, -46.711498], nome: 'Praia Flórida Mirim', descricao: 'Praia de águas limpas, ideal para famílias.' },
            { coords: [-24.09606, -46.62045], nome: 'Praça de Eventos Dudu Samba', descricao: 'Famosa praça de eventos culturais.' },
            { coords: [-24.08973, -46.62292], nome: 'Poço das Antas', descricao: 'Área natural para relaxar e explorar.' },
            { coords: [-24.09462, -46.61961], nome: 'Feira de Artesanato', descricao: 'Feira de produtos locais e artesanais.' },
            { coords: [-24.09119, -46.61684], nome: 'Morro da Padroeira', descricao: 'Vista panorâmica incrível da cidade.' },
            { coords: [-24.13087, -46.68704], nome: 'Praia Agenor de Campos', descricao: 'Praia estruturada com quiosques e atividades.' },
            { coords: [-24.10203, -46.63637], nome: 'Centro Cultural Raul Cortez', descricao: 'Tem seu nome em homenagem ao ator Raul Cortez e é o coração da cena cultural de Mongaguá.' }
        ];

        pontosTuristicos.forEach(ponto => {
            L.marker(ponto.coords).addTo(map)
                .bindPopup(`<b>${ponto.nome}</b><br>${ponto.descricao}`);
        });

        map.pontosTuristicosAdicionados = true; // Evita adicionar múltiplas vezes
    }
}

// Tratamento de erro
function error(err) {
    console.error(err);
    h2.textContent = 'Não foi possível obter sua localização.';
}

// Solicita localização do usuário
navigator.geolocation.getCurrentPosition(success, error, {
    enableHighAccuracy: true,
    timeout: 10000, // Tempo máximo para resposta (10s)
    maximumAge: 0   // Força atualização e evita cache antigo
});

// Função para marcar pontos turísticos no mapa
function marcarMapa(latitude, longitude) {
    map.setView([latitude, longitude], 16); // Centraliza o mapa no ponto turístico
    L.marker([latitude, longitude]).addTo(map)
        .bindPopup('<strong>Ponto Selecionado</strong>')
        .openPopup();
}

// Pequeno atraso para garantir que o mapa foi atualizado antes da rolagem
setTimeout(() => {
    let mapaElemento = document.getElementById("map");

    if (mapaElemento && mapaElemento.offsetHeight > 0) {
        window.scrollTo({
            top: mapaElemento.offsetTop - 100,
            behavior: "smooth"
        });
    }
}, 300);

// Dados do usuário
let usuario = {
    nome: "BlackN444",
    foto: "IMG/icon.png",
    pontos: 320,
    nivel: "Explorador",
    conquistas: [
        { nome: "Visitou a Plataforma de Pesca", pontos: 50 },
        {nome: "Visitou o Parque Ecológico A Tribuna", pontos: 50},
        {nome: "Visitou a Paróquia Nossa Senhora Aparecida", pontos: 50},
        { nome: "Completou o desafio 'Explorador'", pontos: 100 }
    ],
    missoes: [
        { nome: "Visite 5 pontos turísticos", pontos: 100, concluida: true },
        { nome: "Compartilhe sua experiência", pontos: 50, concluida: false },
    ]
};

// Atualiza a exibição do usuário
function atualizarUsuario() {
    document.getElementById("nomeUsuario").textContent = usuario.nome;
    document.getElementById("fotoUsuario").src = usuario.foto;
    document.getElementById("pontuacaoUsuario").textContent = `Pontuação: ${usuario.pontos} ⭐`;

    //atualiza o nivel do usuario de acordo cm a pontuacao
    if (usuario.pontos >= 5000) {
        usuario.nivel = "Mestre do Mapa";
    } else if (usuario.pontos >= 200) {
        usuario.nivel = "Explorador";
    } else {
        usuario.nivel = "Iniciante";
    }
    document.getElementById("nivelUsuario").textContent = `Nível: ${usuario.nivel}`;

    //atualiza a barra de progresso
    let progressBar = document.querySelector(".barra-progresso progress");
    progressBar.value = usuario.pontos;
    progressBar.max = 5000;
    document.getElementById("progressText").textContent = `${usuario.pontos} / 5000 pontos`;
    
    //atualiza a lista de conquistas
    let listaConquistas = document.getElementById("listaConquistas");
    listaConquistas.innerHTML = "";
    usuario.conquistas.forEach(conquista => {
        let li = document.createElement("li");
        li.innerHTML = `🏆 ${conquista.nome} <strong>+${conquista.pontos} pontos</strong>`;
        listaConquistas.appendChild(li);
    });
    
    //atualiza lista de missoes cm eventos de clique
    let listaMissoes = document.getElementById("listaMissoes");
    listaMissoes.innerHTML = "";

    usuario.missoes.forEach((missao, index) => {
        let li = document.createElement("li");
        li.innerHTML = `${missao.concluida ? "✅" : "📜"} ${missao.nome} - <strong>+${missao.pontos} pontos</strong>`;
        
        if (!missao.concluida) {
            li.style.cursor = "pointer";
            li.style.color = "blue"; // Indica que é clicável
            
            li.addEventListener("click", function () {
                concluirMissao(index);
            });
        }
        
        listaMissoes.appendChild(li);
    });
    //salva os dados atualizados no localStorage
    localStorage.setItem("usuario", JSON.stringify(usuario));
}

//função para concluir uma missão
function concluirMissao(index) {
    console.log("Clicou na missão:", index); //testando p ve c ta funcionando o click
    let missao = usuario.missoes[index];

    if (!missao.concluida) {
        missao.concluida = true;  //aqui marca a missao como concluida
        usuario.pontos += missao.pontos;

        //adiciona a missão às conquistas
        usuario.conquistas.push({
            nome: missao.nome,
            pontos: missao.pontos
        });

        console.log("Missão concluída:", missao); //testando se a missão foi atualizada certo
        console.log("Usuário atualizado:", usuario.pontos);

      //importante: re-salvar o objt atualizado no localStorage
      usuario.missoes[index] = missao; //esta linha é pra garantir q o objt no array seja atualizado corretamente
       localStorage.setItem("usuario", JSON.stringify(usuario));
        
        atualizarUsuario(); //atualiza a tela

        //força a atualizar a tela
        setTimeout(() => {
            location.reload();
        }, 500);
    }
}
// Verifica se há dados salvos no localStorage
if (localStorage.getItem("usuario")) {
    usuario = JSON.parse(localStorage.getItem("usuario"));

    usuario.missoes = usuario.missoes.map(missao => ({
        ...missao,
        concluida: missao.concluida || false //c nao existir é p definir false
    }));

    //salva de volta no localStorage para corrigir os dados
    localStorage.setItem("Usuario", JSON.stringify(usuario));
}


//qr code
document.addEventListener("DOMContentLoaded", function () {
    let usuario = JSON.parse(localStorage.getItem("usuario")) || {
        nome: "Usuário",
        pontos: 0,
        conquistas: []
    };

    document.getElementById("nomeUsuario").textContent = usuario.nome;
    document.getElementById("pontuacaoUsuario").textContent = `Pontuação: ${usuario.pontos} ⭐`;

    let listaConquistas = document.getElementById("listaConquistas");
    listaConquistas.innerHTML = "";

    usuario.conquistas.forEach(conquista => {
        let li = document.createElement("li");
        li.innerHTML = `🏆 ${conquista.nome} <strong>+${conquista.pontos} pontos</strong>`;
        listaConquistas.appendChild(li);
    });

    // Verifica se veio da página de QR Code
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get("recompensa") === "1") {
        alert("🎊 Você recebeu uma nova recompensa pelo QR Code!");
    }
});

