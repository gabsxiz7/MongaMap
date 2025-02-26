document.addEventListener("DOMContentLoaded", function () {
    const slider = document.querySelector(".slider");
    const slides = document.querySelectorAll(".depoimento");
    const prevBtn = document.querySelector(".prev-btn");
    const nextBtn = document.querySelector(".next-btn");
    const form = document.getElementById("form-experiencia");
    const galeriaContainer = document.getElementById("galeria-container");

    let index = 0;

    function showSlide() {
        slider.style.transform = `translateX(${-index * 100}%)`;
    }

    nextBtn.addEventListener("click", function () {
        index = (index + 1) % slides.length;
        showSlide();
    });

    prevBtn.addEventListener("click", function () {
        index = (index - 1 + slides.length) % slides.length;
        showSlide();
    });

    // Adicionar nova experiência ao enviar o formulário
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const nome = document.getElementById("nome").value;
        const mensagem = document.getElementById("mensagem").value;

        const novoDepoimento = document.createElement("div");
        novoDepoimento.classList.add("depoimento");
        novoDepoimento.innerHTML = `<p>"${mensagem}"</p><h4>- ${nome}</h4>`;
        
        slider.appendChild(novoDepoimento);
    });
});
