document.addEventListener("DOMContentLoaded", function () {
    // Slider de Depoimentos
    const sliderDepoimentos = document.querySelector(".slider");
    const depoimentos = document.querySelectorAll(".depoimento");
    const prevBtn = document.querySelector(".prev-btn");
    const nextBtn = document.querySelector(".next-btn");

    let indexDepoimentos = 0;
    const totalDepoimentos = depoimentos.length;

    function showDepoimentos() {
        sliderDepoimentos.style.transform = `translateX(-${indexDepoimentos * 100}%)`;
    }

    nextBtn.addEventListener("click", function () {
        indexDepoimentos = (indexDepoimentos + 1) % totalDepoimentos;
        showDepoimentos();
    });

    prevBtn.addEventListener("click", function () {
        indexDepoimentos = (indexDepoimentos - 1 + totalDepoimentos) % totalDepoimentos;
        showDepoimentos();
    });

    setInterval(() => {
        indexDepoimentos = (indexDepoimentos + 1) % totalDepoimentos;
        showDepoimentos();
    }, 5000);


    // Slider de Experiências Visuais
    const sliderExperiencias = document.querySelector(".grid");
    const experiencias = document.querySelectorAll(".grid img");

    let indexExperiencias = 0;
    const totalExperiencias = experiencias.length;

    function showExperiencias() {
        sliderExperiencias.style.transform = `translateX(-${indexExperiencias * 100}%)`;
    }

    setInterval(() => {
        indexExperiencias = (indexExperiencias + 1) % totalExperiencias;
        showExperiencias();
    }, 4000);
});
