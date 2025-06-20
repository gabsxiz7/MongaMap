document.addEventListener('DOMContentLoaded', () => {
   console.log("🔥 gamificacao.js carregado e DOM pronto");
let map;               // usado em adicionarPontosTuristicos e success()
let qrScanner = null;  // usado em iniciarLeitorQRCode()
let userMarker = null;
let usuario = { id:null, foto:'IMG/icon.png', pontos:0, conquistas:[], missoes:[] };
const pontosTuristicos = [
  { id: 1, coords: [-24.134243, -46.692596], nome: 'Plataforma de Pesca',    descricao: 'Local incrível para pesca e lazer.' },
  { id: 2, coords: [-24.134406, -46.695230], nome: 'Parque Ecológico',       descricao: 'Contato direto com a natureza.' },
  { id: 3, coords: [-24.094984, -46.620291], nome: 'Paróquia Aparecida',     descricao: 'Marco religioso e histórico.' },
  { id: 4, coords: [-24.132455, -46.711498], nome: 'Praia Flórida Mirim',    descricao: 'Águas limpas, ideal para famílias.' },
  { id: 5, coords: [-24.096060, -46.620450], nome: 'Praça Dudu Samba',       descricao: 'Espaço cultural na orla.' },
  { id: 6, coords: [-24.089730, -46.622920], nome: 'Poço das Antas',         descricao: 'Cachoeiras e trilhas naturais.' },
  { id: 7, coords: [-24.094620, -46.619610], nome: 'Feira de Artesanato',    descricao: 'Produtos típicos locais.' },
  { id: 8, coords: [-24.091190, -46.616840], nome: 'Morro da Padroeira',     descricao: 'Vista panorâmica da cidade.' },
  { id: 9, coords: [-24.130870, -46.687040], nome: 'Praia Agenor de Campos', descricao: 'Quiosques e atividades de verão.' },
  { id:10, coords: [-24.102030, -46.636370], nome: 'Centro Cultural Raul Cortez', descricao: 'Cultura e teatro municipal.' }
];

// 2) Função para colocar marcadores no mapa
function adicionarPontosTuristicos() {
  pontosTuristicos.forEach(p => {
    L.marker(p.coords)
     .addTo(map)
     .bindPopup(`<b>${p.nome}</b><br>${p.descricao}`);
  });
}

 function success(pos) {
  const lat = pos.coords.latitude,
        lng = pos.coords.longitude;
        if (!map) {
    map = L.map('map').setView([lat, lng], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);
    userMarker = L.marker([lat,lng]).addTo(map).bindPopup('📍 Você está aqui!');
  } else{
    userMarker.setLatLng([lat, lng]);
      map.setView([lat, lng], 13);
  }
 if (!map.pontosTuristicosAdicionados) {
  adicionarPontosTuristicos();
  map.pontosTuristicosAdicionados = true;
  }
}
function error(err) {
  console.error('GeoLocation error:', err);
  document.getElementById('coordenadas')?.remove();
}

window.marcarMapa = (lat, lng) => {
  if (map) {
    map.setView([lat, lng], 16);
    L.marker([lat, lng]).addTo(map)
      .bindPopup('<strong>Ponto Selecionado</strong>')
      .openPopup();
  }
};
navigator.geolocation.watchPosition(success, error, {
  enableHighAccuracy: true,
  timeout: 10000,
  maximumAge: 0
});

// 4) Abre modal e dispara scanner
window.abrirModal = idx => {
  const p = pontosTuristicos[idx];
  document.getElementById('modal-title').textContent     = p.nome;
  document.getElementById('modal-description').innerHTML = p.descricao;
  document.getElementById('modal').style.display         = 'block';
  iniciarLeitorQRCode();
};
function iniciarLeitorQRCode() {
  if (qrScanner) { qrScanner.clear(); qrScanner = null; }
  qrScanner = new Html5QrcodeScanner('qr-reader', { fps:10, qrbox:250 });
  qrScanner.render(onScanSuccess, onScanError);
}
function onScanSuccess(decodedText) {
  // 1) descodifica qualquer url-encoded leftover
  let text = decodeURIComponent(decodedText.trim());
  let id = null;

  // 2) tenta extrair scan ou id via URL
  try {
    const url = new URL(text);
    id = url.searchParams.get('scan') || url.searchParams.get('id');
  } catch {
    // não é URL válida — cai no fallback abaixo
  }

  // 3) se ainda não encontrou, tenta extrair o número direto no texto
  if (!id) {
    const m = text.match(/(?:scan|id)=(\d+)/);
    if (m) id = m[1];
  }

  if (!id) {
    alert('❌ QR inválido');
    return;
  }

  // 4) chama o endpoint
  fetch(`php/credita_pontos.php?id=${id}`)
    .then(r => r.json())
    .then(json => {
      if (json.sucesso) {
        alert(`🎉 +${json.pontosGanhos} pontos! Total: ${json.total}`);
        window.location.href = 'gamificacao.php?recompensa=1';
      } else {
        alert('❌ ' + (json.erro || 'Falha ao creditar'));
      }
    })
    .catch(() => alert('❌ Erro de rede'));
}


function onScanError(err) {
  console.warn('Scan erro:', err);
}

function carregarUsuarioDoBanco() {
  console.log("📡 Disparando fetch para pegar_usuario.php");
  fetch("php/pegar_usuario.php", { credentials: 'same-origin' })
    .then(r => r.json())
    .then(dados => {
      console.log("↩️ resposta do servidor:", dados);
      if (!dados.sucesso) {
        console.error("❌ erro no servidor:", dados.erro);
        return;
      }
      // … preenche usuário e chama atualizarUsuario()
    })
    .catch(err => console.error("🚨 erro de fetch:", err));
}

function calcularNivel(p) {
  if (p >= 5000) return "Mestre do Mapa";
  if (p >= 2000) return "Aventureiro";
  if (p >= 1000) return "Explorador";
  return "Iniciante";
}

console.log("Chamou atualizarUsuario()", usuario.pontos);

function atualizarUsuario() {
  document.getElementById('fotoUsuario').src = usuario.foto;
  document.getElementById('pontuacaoUsuario').textContent = `${usuario.pontos} ⭐`;
  usuario.nivel = calcularNivel(usuario.pontos);
  document.getElementById('nivelUsuario').textContent = usuario.nivel;

  renderMissoesDinamicas();
  renderUltimasConquistas();
}
function gerarMissoes(visitas) {
  const todos = [1,2,3,4,5,6,7,8,9,10];
  const faltam = todos.filter(id => !visitas.includes(id));
  return faltam.length
    ? [{ id: 0, nome: `Visite ${faltam.length} ponto(s)`, pontos: 100 * faltam.length, concluida: false }]
    : [];
}
function renderMissoesDinamicas() {
  const ul = document.getElementById('listaMissoes');
  ul.innerHTML = '';
  usuario.missoes.forEach(m => {
    const li = document.createElement('li');
    li.textContent = `${m.nome} (+${m.pontos} pts)`;
    li.classList.add(m.concluida ? 'missao-concluida' : 'missao-nao-concluida');
    if (!m.concluida) {
      li.style.cursor = 'pointer';
      li.addEventListener('click', () => concluirMissaoDinamica(m));
    }
    ul.appendChild(li);
  });
}
function renderUltimasConquistas() {
  const ul = document.getElementById('listaConquistas');
  ul.innerHTML = '';
  usuario.conquistas.slice(0,5).forEach(c => {
    const li = document.createElement('li');
    li.innerHTML = `🏆 ${c.nome} <strong>+${c.pontos} pontos</strong>`;
    ul.appendChild(li);
  });
}
function concluirMissaoDinamica(m) {
  m.concluida = true;
  usuario.pontos += m.pontos;
  usuario.conquistas.unshift({ nome: m.nome, pontos: m.pontos });
  atualizarUsuario();
  fetch(`php/credita_pontos.php?id=${m.id}`);
}



  // upload de foto e edição de nome (mantidos)
  document.getElementById('inputNovaFoto').addEventListener('change', function() {
    const nomeArquivo = this.files[0]?.name || 'Nenhum arquivo escolhido';
    document.querySelector('.btn-choose').innerText = `Arquivo: ${nomeArquivo}`;
  });
  window.toggleEditarNome = () => {
    const form = document.getElementById('formEdicaoNome');
    form.style.display = form.style.display === 'flex' ? 'none' : 'flex';
    document.getElementById('inputNovoNome').focus();
  };

  // inicialização
  carregarUsuarioDoBanco();
  }); 
