console.log("JavaScript carregado com sucesso!");
window.addEventListener('scroll', function () {
    const navbar = this.document.querySelector('.navbar');
    if (this.window.scrollY > 50) {
        navbar.classList.add('navbar-fixed');
    } else {
        navbar.classList.remove('navbar-fixed');
    }
});

const sobreNos = document.querySelector('.sobre-nos');
window.addEventListener('scroll', function () {
    const posicao = sobreNos.getBoundingClientRect().top;
    const tela = window.innerHeight;
    if (posicao < tela - 100) {
        sobreNos.classList.add('show');
    }
});

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

/* fade in */
const fadeElements = document.querySelectorAll('.fade-in');

window.addEventListener('scroll', () => {
    fadeElements.forEach(element => {
        const position = element.getBoundingClientRect().top;
        const windowHeight = window.innerHeight;

        if (position < windowHeight - 100) {
            element.classList.add('show');
        }
    });
});
