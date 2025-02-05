//seleciona o botão de menu e os links
const menuToggle = document.getElementById("menuToggle");
const navbarLinks = document.getElementById("navbarLinks");

//garante que os elementos existem antes de adicionar eventos
if (menuToggle && navbarLinks) {
  //alterna a visibilidade do menu ao clicar no botão sanduíche
  menuToggle.addEventListener("click", () => {
    navbarLinks.classList.toggle("show"); //adiciona ou remove a classe 'show'
    menuToggle.classList.toggle("active"); //adiciona ou remove a classe 'active' no botão
  });
}

//configurações da navbar
document.addEventListener("DOMContentLoaded", () => {
  const navbar = document.querySelector(".navbar");
  if (navbar) {
    navbar.classList.add("navbar-transparent"); //adiciona uma classe para estilos
  }
});

  