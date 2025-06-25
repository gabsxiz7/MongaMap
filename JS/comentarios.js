document.querySelectorAll('.btn-reacao').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const reacao = this.getAttribute('data-reacao');
        const comentario = this.closest('.comentario').getAttribute('data-id');
console.log({ reacao, comentario });
        fetch('PHP/registrar_reacao.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                reacao: reacao,
                comentario: comentario
            })
        })
        .then(res => res.json())
        .then(data => {
            // Atualiza contadores na interface
            if(data.totais) {
                const box = btn.closest('.reacoes');
                box.querySelector('[data-reacao="like"] .contagem').textContent = data.totais.like;
                box.querySelector('[data-reacao="dislike"] .contagem').textContent = data.totais.dislike;
                box.querySelector('[data-reacao="smile"] .contagem').textContent = data.totais.smile;
            }
            
            // Remove a classe 'ativo' de todos os botões do comentário
            const box = btn.closest('.reacoes');
            box.querySelectorAll('.btn-reacao').forEach(function(el) {
                el.classList.remove('ativo');
            });
            // Se não foi remoção (ou seja, agora existe a reação), adiciona a classe ao botão clicado
            if (data.mensagem === "Reação registrada") {
                btn.classList.add('ativo');
            }
        });
    });
});



document.getElementById('formComentario').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('adicionar_comentario.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            alert(data.mensagem);
            location.reload(); //recarrega para exibir o novo comentário
        });
});



document.querySelectorAll('.estrela').forEach((estrela, index) => {
    estrela.addEventListener('click', () => {
        const estrelas = index + 1;

        fetch('adicionar_avaliacao.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                ponto_turistico_id: 1, //substitua pelo ID correto
                estrelas: estrelas
            })
        })
            .then(response => response.json())
            .then(data => alert(data.mensagem));
    });
});
