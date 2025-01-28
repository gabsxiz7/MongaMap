// Seleciona o botão de menu e os links
const menuToggle = document.getElementById("menuToggle");
const navbarLinks = document.getElementById("navbarLinks");

// Garante que os elementos existem antes de adicionar eventos
if (menuToggle && navbarLinks) {
  // Alterna a visibilidade do menu ao clicar no botão sanduíche
  menuToggle.addEventListener("click", () => {
    navbarLinks.classList.toggle("show"); // Adiciona ou remove a classe 'show'
    menuToggle.classList.toggle("active"); // Adiciona ou remove a classe 'active' no botão
  });
}

// Configurações da navbar
document.addEventListener("DOMContentLoaded", () => {
  const navbar = document.querySelector(".navbar");
  if (navbar) {
    navbar.classList.add("navbar-transparent"); // Adiciona uma classe para estilos
  }
});

  