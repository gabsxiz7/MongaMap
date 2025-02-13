//pensando o que adicionar aqui..
document.addEventListener("DOMContentLoaded", function () {
    const teamMembers = document.querySelectorAll(".team-member");

    function checkScroll() {
        teamMembers.forEach((member) => {
            const memberPosition = member.getBoundingClientRect().top;
            const screenHeight = window.innerHeight;

            if (memberPosition < screenHeight - 100) {
                member.classList.add("show");
            }
        });
    }

    window.addEventListener("scroll", checkScroll);
    checkScroll(); // Garante que os elementos visíveis ao carregar já apareçam
});
