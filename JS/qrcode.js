document.addEventListener("DOMContentLoaded", function () {
    function onScanSuccess(decodedText) {
        document.getElementById("resultado").innerHTML = `✅ QR Code Detectado: ${decodedText}`;

        // Verifica se o QR code pertence ao MongaMap
        if (decodedText.includes("MongaMap")) {
            alert("🎉 Parabéns! Você encontrou um QR Code válido e ganhou pontos!");

            // Atualiza a pontuação e recompensa no localStorage
            let usuario = JSON.parse(localStorage.getItem("usuario")) || {
                nome: "Usuário",
                pontos: 0,
                conquistas: []
            };

            let pontosGanhados = 100; // Define quantos pontos o usuário ganha
            usuario.pontos += pontosGanhados;

            // Adiciona a conquista
            usuario.conquistas.push({
                nome: `QR Code escaneado em ${new Date().toLocaleDateString()}`,
                pontos: pontosGanhados
            });

            // Salva no localStorage
            localStorage.setItem("usuario", JSON.stringify(usuario));

            // Redireciona o usuário para a página de gamificação
            setTimeout(() => {
                window.location.href = "gamificacao.html?recompensa=1";
            }, 2000);
        } else {
            alert("❌ QR Code inválido. Tente outro.");
        }
    }

    function onScanError(errorMessage) {
        console.warn(`Erro no scan: ${errorMessage}`);
    }

    let scanner = new Html5QrcodeScanner("qr-reader", { fps: 10, qrbox: 250 });
    scanner.render(onScanSuccess, onScanError);
});
