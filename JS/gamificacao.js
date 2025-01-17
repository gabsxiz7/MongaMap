let h2 = document.querySelector('h2');
var map;

function success(pos) {
    console.log(pos.coords.latitude, pos.coords.longitude);
    h2.textContent = `Latitude: ${pos.coords.latitude}, Longitude: ${pos.coords.longitude}`;

    // Criação ou atualização do mapa
    if (map === undefined) {
        map = L.map('map').setView([pos.coords.latitude, pos.coords.longitude], 13);
    } else {
        map.remove();
        map = L.map('map').setView([pos.coords.latitude, pos.coords.longitude], 13);
    }

    // Tile Layer
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Marcador no ponto atual
    L.marker([pos.coords.latitude, pos.coords.longitude]).addTo(map)
        .bindPopup('Você está aqui!')
        .openPopup();

    // Adicione mais marcadores dos pontos turísticos
    const pontosTuristicos = [
        { coords: [-24.0911, -46.6218], nome: 'Plataforma de Pesca', descricao: 'Local incrível para pesca e lazer.'},
        { coords: [-24.0941, -46.6195], nome: 'Parque Ecológico', descricao: 'Contato direto com a natureza.'},
        { coords: [-24.0920, -46.6233], nome: 'Igreja Matriz', descricao: 'Uma das construções mais antigas de Mongaguá.'},
        { coords:[-24.0950, -46.6240], nome: 'Praia Flórida Mirim', descricao: 'Praia de aguas limpas, ideal para famílias.'},
        { coords: [-24.0975, -46.6210], nome: 'Praça Dudu Samba', descricao: 'Famosa praça de eventos culturais.'},
        { coords: [-24.0935, -46.6225], nome: 'Poço das Antas', descricao: 'Área natural para relaxar e explorar.'},
        { coords: [-24.0918, -46.6203], nome: 'Feira de Artesanato', descricao: 'Feira de produtos locais e artesanais.'},
        { coords: [-24.0890, -46.6180], nome: 'Morro da Padroeira', descricao: 'Vista panorâmica incrível da cidade.'},
        { coords: [-24.0925, -46.6265], nome: 'Praia Agenor de Campos', descricao: 'Praia estruturada com quiosques e atividades.'}
    ];

    pontosTuristicos.forEach(ponto => {
        L.marker(ponto.coords).addTo(map)
            .bindPopup(`<b>${ponto.nome}</b><br>${ponto.descricao}`);
    });
}

function error(err) {
    console.error(err);
    h2.textContent = 'Não foi possível obter sua localização.';
}

// Solicita localização do usuário
navigator.geolocation.watchPosition(success, error, {
    enableHighAccuracy: true,
    timeout: 5000
});


const listaPontos = document.getElementById('lista-pontos');

pontosTuristicos.forEach(ponto => {
    const li = document.createElement('li');
    li.innerHTML = `<b>${ponto.nome}</b>: ${ponto.descricao}`;
    listaPontos.appendChild(li);
});

//teste
function marcarMapa(latitude, longitude) {
    map.setView([latitude, longitude], 16); // Centraliza o mapa no ponto turístico
    L.marker([latitude, longitude]).addTo(map)
        .bindPopup('<strong>Ponto Selecionado</strong>')
        .openPopup();
}

