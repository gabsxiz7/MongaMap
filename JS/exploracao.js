//inicialização do mapa
var map = L.map('map').setView([-24.0911, -46.6206], 13);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

const pontosTuristicos = [
    { coords: [-24.134243, -46.692596], nome: 'Plataforma de Pesca' },
    { coords: [-24.134406, -46.695230], nome: 'Parque Ecológico' },
    { coords: [-24.094984, -46.620291], nome: 'Paróquia Nossa Senhora Aparecida' },
    { coords: [-24.132455, -46.711498], nome: 'Praia Flórida Mirim' },
    { coords: [-24.09606, -46.62045], nome: 'Praça de Eventos Dudu Samba'},
    { coords: [-24.08973, -46.62292], nome: 'Poço das Antas'},
    { coords: [-24.09462, -46.61961], nome: 'Feira de Artesanato'},
    { coords: [-24.09119, -46.61684], nome: 'Morro da Padroeira'},
    { coords: [-24.13087, -46.68704], nome: 'Praia Agenor de Campos'},
    { coords: [-24.10203, -46.63637], nome: 'Centro Cultural Raul Cortez'}

];
pontosTuristicos.forEach(ponto => {
    L.marker(ponto.coords).addTo(map).bindPopup(ponto.nome);
});
//calcula as distâncias
function calcularDistancia() {
    const ponto1 = document.getElementById('ponto1').value.split(',');
    const ponto2 = document.getElementById('ponto2').value.split(',');

    const distancia = Math.sqrt(
        Math.pow(ponto1[0] - ponto2[0], 2) + Math.pow(ponto1[1] - ponto2[1], 2)
    );
    document.getElementById('resultado').textContent = `Distância aproximada: ${(distancia * 111).toFixed(2)} km`;
}
//botão compartilhar
function compartilhar() {
    alert('Link do planejamento copiado para a área de transferência!');
}