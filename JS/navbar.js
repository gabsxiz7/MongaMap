// Seleciona o botão de menu e os links
const menuToggle = document.getElementById("menuToggle");
const navbarLinks = document.getElementById("navbarLinks");

// Alterna a visibilidade do menu ao clicar no botão sanduíche
menuToggle.addEventListener("click", () => {
    navbarLinks.classList.toggle("show"); // Adiciona ou remove a classe 'show'
});

//navbar
document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.querySelector(".navbar");
    navbar.style.background = "transparent"; // Força a transparência
    navbar.style.boxShadow = "none"; // Remove sombras
  });

  