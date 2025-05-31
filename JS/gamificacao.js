let h2 = document.querySelector('h2');
let coordenadasElemento = document.getElementById("coordenadas");
var map;
var userMarker;

function carregarUsuarioDoBanco() {
    fetch("php/pegar_usuario.php")
        .then(response => response.json())
        .then(dados => {
            if (dados.sucesso) {
                usuario = {
                    id: dados.id,
                    foto: dados.foto || "IMG/icon.png",
                    pontos: dados.pontos || 0,
                    nivel: "",
                    conquistas: dados.conquistas || [],
                    missoes: gerarMissoes(dados.visitas || [])
                };
                atualizarUsuario();
            } else {
                console.error("Erro ao carregar usuário:", dados.erro);
            }
        })
        .catch(err => console.error("Erro de rede:", err));
}

function success(pos) {
    const latitude = pos.coords.latitude;
    const longitude = pos.coords.longitude;

    if (!map) {
        map = L.map('map').setView([-24.0911, -46.6206], 13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        userMarker = L.marker([latitude, longitude]).addTo(map)
            .bindPopup('📍 Você está aqui!')
            .openPopup();
    } else {
        userMarker.setLatLng([latitude, longitude]);
        map.setView([latitude, longitude], 13);
    }

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

        map.pontosTuristicosAdicionados = true;
    }
}

function error(err) {
    console.error(err);
    if (coordenadasElemento) coordenadasElemento.remove();
}

navigator.geolocation.watchPosition(success, error, {
    enableHighAccuracy: true,
    timeout: 10000,
    maximumAge: 0
});

function marcarMapa(latitude, longitude) {
    map.setView([latitude, longitude], 16);
    L.marker([latitude, longitude]).addTo(map)
        .bindPopup('<strong>Ponto Selecionado</strong>')
        .openPopup();
}

function calcularNivel(pontos) {
    if (pontos >= 5000) return "Mestre do Mapa";
    if (pontos >= 1000) return "Explorador Avançado";
    return "Explorador";
}

function atualizarUsuario() {
    document.getElementById("fotoUsuario").src = usuario.foto;
    document.getElementById("pontuacaoUsuario").textContent = `Pontuação: ${usuario.pontos} ⭐`;
    usuario.nivel = calcularNivel(usuario.pontos);
    document.getElementById("nivelUsuario").textContent = `Nível: ${usuario.nivel}`;

    let progressBar = document.querySelector(".barra-progresso progress");
    progressBar.value = usuario.pontos;
    progressBar.max = 5000;
    document.getElementById("progressText").textContent = `${usuario.pontos} / 5000 pontos`;

    let listaConquistas = document.getElementById("listaConquistas");
    listaConquistas.innerHTML = "";
    usuario.conquistas.forEach(conquista => {
        let li = document.createElement("li");
        li.innerHTML = `🏆 ${conquista.nome} <strong>+${conquista.pontos} pontos</strong>`;
        listaConquistas.appendChild(li);
    });

    let listaMissoes = document.getElementById("listaMissoes");
    listaMissoes.innerHTML = "";
    usuario.missoes.forEach((missao, index) => {
        let li = document.createElement("li");
        li.innerHTML = `${missao.concluida ? "✅" : "📜"} ${missao.nome} - <strong>+${missao.pontos} pontos</strong>`;
        if (!missao.concluida) {
            li.style.cursor = "pointer";
            li.style.color = "blue";
            li.addEventListener("click", () => concluirMissao(index));
        }
        listaMissoes.appendChild(li);
    });
}

function concluirMissao(index) {
    let missao = usuario.missoes[index];
    if (!missao.concluida) {
        missao.concluida = true;
        usuario.pontos += missao.pontos;
        usuario.conquistas.push({ nome: missao.nome, pontos: missao.pontos });
        atualizarUsuario();
        fetch("php/salvar_missao.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id_usuario: usuario.id, missao: missao.nome, pontos: missao.pontos })
        });
    }
}

function gerarMissoes(locaisNaoVisitados) {
    const missoes = [];
    if (locaisNaoVisitados.length > 0) {
        missoes.push({ nome: "Visite todos os pontos turísticos", pontos: 200, concluida: false });
    }
    return missoes;
}

let usuario = {
    foto: "IMG/icon.png",
    pontos: 0,
    nivel: "",
    conquistas: [],
    missoes: []
};
carregarUsuarioDoBanco();
