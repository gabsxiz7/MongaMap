    // Gera uma cor aleatória em formato hexadecimal
    function corAleatoria() {
        const letras = '0123456789ABCDEF';
        let cor = '#';
        for (let i = 0; i < 6; i++) {
            cor += letras[Math.floor(Math.random() * 16)];
        }
        return cor;
    }
if (window.location.search.includes('parabens=1')) {
    alert('Parabéns! Você ganhou pontos pelo quiz!');
}

    // Aplica ao fundo do body
    document.body.style.backgroundColor = corAleatoria();


