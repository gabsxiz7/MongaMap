//inicialização do mapa
var map = L.map('map').setView([-24.0911, -46.6206], 13);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

const pontosTuristicos = [
    { coords: [-24.134216042883118, -46.69265213033479], nome: 'Plataforma de Pesca' },
    { coords: [-24.134516224770405, -46.695151685425], nome: 'Parque Ecológico' },
    { coords: [-24.095138463208592, -46.62037791866331], nome: 'Paróquia Nossa Senhora Aparecida' },
    { coords: [-24.132455, -46.711498], nome: 'Praia Flórida Mirim' },
    { coords: [-24.096386442762434, -46.62107197890569], nome: 'Praça de Eventos Dudu Samba'},
    { coords: [-24.08729494736329, -46.6238897572014], nome: 'Poço das Antas'},
    { coords: [-24.094795333617636, -46.619581244856235], nome: 'Feira de Artesanato'},
    { coords: [-24.091398678382347, -46.616823139729384], nome: 'Morro da Padroeira'},
    { coords: [-24.13087, -46.68704], nome: 'Praia Agenor de Campos'},
    { coords: [-24.10218063114339, -46.63634087856133], nome: 'Centro Cultural Raul Cortez'}

];
pontosTuristicos.forEach(ponto => {
    L.marker(ponto.coords).addTo(map).bindPopup(ponto.nome);
});
//calcula as distâncias
function calcularDistancia() {
    event.preventDefault();   //impede o recarregamento da página
    
    const ponto1 = document.getElementById('ponto1').value.split(',');
    const ponto2 = document.getElementById('ponto2').value.split(',');

    const distancia = Math.sqrt(
        Math.pow(ponto1[0] - ponto2[0], 2) + Math.pow(ponto1[1] - ponto2[1], 2)
    );
    document.getElementById('resultado').textContent = `Distância aproximada: ${(distancia * 111).toFixed(2)} km`;
}

//seleciona o botão de compartilhar
const compartilharBotao = document.getElementById('compartilhar-planejamento');

//evento de clique no botão
compartilharBotao.addEventListener('click', () => {
  //dados do planejamento para compartilhar
  const titulo = "Meu Planejamento de Viagem no MongaMap!";
  const texto = "Planejei uma rota incrível em Mongaguá. Confira os detalhes no site!";
  const url = "https://gabsxiz7.github.io/MongaMap/"; // Substitua pelo link real do site

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
