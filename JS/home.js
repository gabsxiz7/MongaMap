//inicializa o mapa
var miniMap = L.map('mini-map').setView([-24.0911, -46.6206], 13);

// adiciona a camada do OpenStreetMap
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(miniMap);

//adiciona marcadores para pontos turísticos
const pontosTuristicos = [
    { coords: [-24.093180, -46.620378], nome: 'Etec Adolpho Berezin', descricao: 'Educação técnica de qualidade.' },
];

pontosTuristicos.forEach(ponto => {
    L.marker(ponto.coords).addTo(miniMap)
        .bindPopup(`<b>${ponto.nome}</b><br>${ponto.descricao}`);
});


