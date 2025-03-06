//inicializa o mapa
var miniMap = L.map('mini-map').setView([-24.12206, -46.67868], 15); //ajuste no nível de zoom

//adiciona a camada do OpenStreetMap
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(miniMap);

//adiciona o marcador fixo
const pontoTuristico = {
    coords: [-24.12206, -46.67868], 
    nome: 'Etec Adolpho Berezin', 
    descricao: 'Educação técnica de qualidade.'
};

const marcador = L.marker(pontoTuristico.coords).addTo(miniMap)
    .bindPopup(`<b>${pontoTuristico.nome}</b><br>${pontoTuristico.descricao}`)
    .openPopup(); //mantém o popup aberto

//função para centralizar o mapa automaticamente quando a seção do mapa for visível
function centralizarMapa() {
    const mapaSection = document.getElementById('mini-map');
    const bounding = mapaSection.getBoundingClientRect();

    if (bounding.top < window.innerHeight && bounding.bottom >= 0) {
        miniMap.setView(pontoTuristico.coords, 17); // Centraliza o mapa e ajusta o zoom
    }
}

//adiciona um evento de rolagem para verificar quando o usuário chega ao mapa
window.addEventListener('scroll', centralizarMapa);
