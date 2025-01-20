let h2 = document.querySelector('h2');
var map;

function success(pos) {
    console.log(pos.coords.latitude, pos.coords.longitude);
    h2.textContent = `Latitude: ${pos.coords.latitude}, Longitude: ${pos.coords.longitude}`;
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

function error(err) {
    console.error(err);
    h2.textContent = 'Não foi possível obter sua localização.';
}

//solicita localização do usuário
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
function marcarMapa(latitude, longitude) {
    map.setView([latitude, longitude], 16); //centraliza o mapa no ponto turístico
    L.marker([latitude, longitude]).addTo(map)
        .bindPopup('<strong>Ponto Selecionado</strong>')
        .openPopup();
}



