//emojis de reação
const emojis = document.querySelectorAll('.emoji');
emojis.forEach((emoji) => {
    emoji.addEventListener('click', () => {
        alert(`Você reagiu com ${emoji.getAttribute('data-emoji')}`);
        //enviar a reação para o backend
    });
});


//estrelas de avaliacao
const estrelas = document.querySelectorAll('.estrela');
estrelas.forEach((estrela, index) => {
    estrela.addEventListener('click', () => {
        estrelas.forEach((e, i) => {
            if (i <= index) {
                e.classList.add('active');
            } else {
                e.classList.remove('active');
            }
        });
        alert(`Você avaliou com ${index + 1} estrelas!`);
        //enviar a avaliacao para o backend
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
