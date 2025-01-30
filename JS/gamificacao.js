let h2 = document.querySelector('h2');
let coordenadasElemento = document.getElementById("coordenadas");
var map;
//inicializa o mapa
function success(pos) {
    console.log(pos.coords.latitude, pos.coords.longitude);

    // Atualiza as coordenadas no <p> correto, sem mexer no <h2>
    coordenadasElemento.textContent = `Latitude: ${pos.coords.latitude.toFixed(6)}, Longitude: ${pos.coords.longitude.toFixed(6)}`;

    //criação ou atualização do mapa
    if (map === undefined) {
        map = L.map('map').setView([pos.coords.latitude, pos.coords.longitude], 13);
    } else {
        map.remove();
        map = L.map('map').setView([pos.coords.latitude, pos.coords.longitude], 13);
    }

    //tile layer
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    //marcador no ponto atual
    L.marker([pos.coords.latitude, pos.coords.longitude]).addTo(map)
        .bindPopup('Você está aqui!')
        .openPopup();

    //adicione mais marcadores dos pontos turísticos
    const pontosTuristicos = [
        { coords: [-24.134243, -46.692596], nome: 'Plataforma de Pesca', descricao: 'Local incrível para pesca e lazer.'},
        { coords: [-24.134406, -46.695230], nome: 'Parque Ecológico', descricao: 'Contato direto com a natureza.'},
        { coords: [-24.094984, -46.620291], nome: 'Paróquia Nossa Senhora Aparecida', descricao: 'Uma das construções mais antigas de Mongaguá.'},
        { coords:[-24.132455, -46.711498], nome: 'Praia Flórida Mirim', descricao: 'Praia de aguas limpas, ideal para famílias.'},
        { coords: [-24.09606, -46.62045], nome: 'Praça de Eventos Dudu Samba', descricao: 'Famosa praça de eventos culturais.'},
        { coords: [-24.08973, -46.62292], nome: 'Poço das Antas', descricao: 'Área natural para relaxar e explorar.'},
        { coords: [-24.09462, -46.61961], nome: 'Feira de Artesanato', descricao: 'Feira de produtos locais e artesanais.'},
        { coords: [-24.09119, -46.61684], nome: 'Morro da Padroeira', descricao: 'Vista panorâmica incrível da cidade.'},
        { coords: [-24.13087, -46.68704], nome: 'Praia Agenor de Campos', descricao: 'Praia estruturada com quiosques e atividades.'},
        { coords: [-24.10203, -46.63637], nome: 'Centro Cultural Raul Cortez', descricao: 'Tem seu nome em homenagem ao ator Raul Cortez e é o coração da cena cultural de Mongaguá.'}
    ];

    pontosTuristicos.forEach(ponto => {
        L.marker(ponto.coords).addTo(map)
            .bindPopup(`<b>${ponto.nome}</b><br>${ponto.descricao}`);
    });
}
//tratamento de erro
function error(err) {
    console.error(err);
    h2.textContent = 'Não foi possível obter sua localização.';
}

//solicita localização do usuário
navigator.geolocation.watchPosition(success, error, {
    enableHighAccuracy: true,
    timeout: 5000
});
function marcarMapa(latitude, longitude) {
//centraliza o mapa no ponto turístico
    map.setView([latitude, longitude], 16); 

// Adiciona um marcador no ponto selecionado   
    L.marker([latitude, longitude]).addTo(map)
        .bindPopup('<strong>Ponto Selecionado</strong>')
        .openPopup();
}

// Pequeno atraso para garantir que o mapa foi atualizado antes da rolagem
setTimeout(() => {
    let mapaElemento = document.getElementById("map");

// Verifica se o mapa existe e tem altura suficiente antes de rolar
    if (mapaElemento && mapaElemento.offsetHeight > 0) {
        // Aplica um scroll suave até o mapa
        window.scrollTo({
            top: mapaElemento.offsetTop - 100, // Ajuste para evitar sobreposição com a navbar
            behavior: "smooth"
        });
    }
}, 300); // 300ms para garantir que o mapa foi renderizado

// Definição dos dados do usuário
let usuario = {
    nome: "Gabs Linda",
    foto: "IMG/gabslinda.png",
    pontos: 320,
    nivel: "Explorador",
    conquistas: [
        { nome: "Visitou a Plataforma de Pesca", pontos: 50 },
        { nome: "Completou o desafio 'Explorador'", pontos: 100 }
    ],
    missoes: [
        { nome: "Visite 5 pontos turísticos", pontos: 100, concluida: false },
        { nome: "Compartilhe sua experiência", pontos: 50, concluida: false }
    ]
};

// Função para atualizar a exibição do usuário
function atualizarUsuario() {
    document.getElementById("nomeUsuario").textContent = usuario.nome;
    document.getElementById("fotoUsuario").src = usuario.foto;
    document.getElementById("pontuacaoUsuario").textContent = `Pontuação: ${usuario.pontos} ⭐`;

    // Atualiza o nível do usuário conforme a pontuação
    if (usuario.pontos >= 500) {
        usuario.nivel = "Mestre do Mapa";
    } else if (usuario.pontos >= 200) {
        usuario.nivel = "Explorador";
    } else {
        usuario.nivel = "Iniciante";
    }
    document.getElementById("nivelUsuario").textContent = `Nível: ${usuario.nivel}`;

    // Atualiza a barra de progresso
    let progressBar = document.querySelector(".barra-progresso progress");
    progressBar.value = usuario.pontos;
    progressBar.max = 500; // Define um máximo para progressão
    document.getElementById("progressText").textContent = `${usuario.pontos} / 500 pontos`;

    // Atualiza a seção de conquistas
    let listaConquistas = document.getElementById("listaConquistas");
    listaConquistas.innerHTML = "";
    usuario.conquistas.forEach(conquista => {
        let li = document.createElement("li");
        li.innerHTML = `🏆 ${conquista.nome} <strong>+${conquista.pontos} pontos</strong>`;
        listaConquistas.appendChild(li);
    });

    // Atualiza a seção de missões
    let listaMissoes = document.getElementById("listaMissoes");
    listaMissoes.innerHTML = "";
    usuario.missoes.forEach(missao => {
        let li = document.createElement("li");
        li.innerHTML = `${missao.concluida ? "✅" : "📜"} ${missao.nome} - <strong>+${missao.pontos} pontos</strong>`;
        listaMissoes.appendChild(li);
    });

    // Salva os dados no localStorage
    localStorage.setItem("usuario", JSON.stringify(usuario));
}

// Função para completar missões
function completarMissao(index) {
    if (!usuario.missoes[index].concluida) {
        usuario.pontos += usuario.missoes[index].pontos;
        usuario.missoes[index].concluida = true;
        usuario.conquistas.push({ nome: `Missão: ${usuario.missoes[index].nome}`, pontos: usuario.missoes[index].pontos });
        atualizarUsuario();
        alert(`Missão "${usuario.missoes[index].nome}" concluída!`);
    } else {
        alert("Esta missão já foi concluída.");
    }
}

// Verifica se há dados salvos no localStorage
if (localStorage.getItem("usuario")) {
    usuario = JSON.parse(localStorage.getItem("usuario"));
}

// Atualiza a interface com os dados do usuário ao carregar a página
atualizarUsuario();
