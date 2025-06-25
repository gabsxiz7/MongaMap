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
    { coords: [-24.0935, -46.6225], nome: 'Poço das Antas'},
    { coords: [-24.09462, -46.61961], nome: 'Feira de Artesanato'},
    { coords: [-24.0890, -46.6180], nome: 'Morro da Padroeira'},
    { coords: [-24.13087, -46.68704], nome: 'Praia Agenor de Campos'},
    { coords: [-24.10203, -46.63637], nome: 'Centro Cultural Raul Cortez'}

];
pontosTuristicos.forEach(ponto => {
    L.marker(ponto.coords).addTo(map).bindPopup(ponto.nome);
});
//calcula as distâncias
function calcularDistancia() {
  // pega e converte
  const [latA, lonA] = document.getElementById('ponto1').value
                         .split(',')
                         .map(Number);
  const [latB, lonB] = document.getElementById('ponto2').value
                         .split(',')
                         .map(Number);

  // cria os LatLng
  const pA = L.latLng(latA, lonA);
  const pB = L.latLng(latB, lonB);

  // distância em metros
  const distanciaM = pA.distanceTo(pB);

  // formata pra usuário
  let texto;
  if (distanciaM < 1000) {
    texto = `Distância aproximada: ${distanciaM.toFixed(0)} m`;
  } else {
    texto = `Distância aproximada: ${(distanciaM/1000).toFixed(2)} km`;
  }

  document.getElementById('resultado').textContent = texto;
}

document.getElementById('calcular')
          .addEventListener('click', calcularDistancia);


//seleciona o botão de compartilhar
const compartilharBotao = document.getElementById('compartilhar-planejamento');

//evento de clique no botão
compartilharBotao.addEventListener('click', () => {
  //dados do planejamento para compartilhar
  const titulo = "Meu Planejamento de Viagem no MongaMap!";
  const texto = "Planejei uma rota incrível em Mongaguá. Confira os detalhes no site!";
  const url = "https://mongamap.com.br/exploracao.php"; // Substitua pelo link real do site

  //verifica se o navegador suporta a API de Web Share
  if (navigator.share) {
    navigator
      .share({
        title: titulo,
        text: texto,
        url: url,
      })
      .then(() => console.log("Compartilhamento realizado com sucesso!"))
      .catch((error) =>
        console.error("Erro ao compartilhar:", error)
      );
  } else {
    alert(
      "Infelizmente, o recurso de compartilhamento não é suportado neste navegador."
    );
  }
});
