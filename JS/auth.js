const container = document.getElementById('container');
const loginButton = document.getElementById('login');
const registerButton = document.getElementById('register');

loginButton.addEventListener('click', () => {
    container.classList.remove('active');
});

registerButton.addEventListener('click', () => {
    container.classList.add('active');
});

/* impede erro no botão se a responsividade estiver ativada */
window.addEventListener("resize", function () {
    if (window.innerWidth <= 768) {
        container.classList.remove('active');
    }
});

document.getElementById('telefone').addEventListener('input', function (e) {
    var x = e.target.value.replace(/\D/g, '').match(/(\d{2})(\d{0,5})(\d{0,4})/); // Corrige a captura do DDD e os números
    if (x) {
      e.target.value = '(' + x[1] + ') ' + (x[2] ? x[2] : '') + (x[3] ? '-' + x[3] : ''); // Formatação final
    }
  });
  