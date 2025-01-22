  // Adicione aqui scripts personalizados para manipulação dinâmica na página inicial
  document.addEventListener('DOMContentLoaded', () => {
    console.log('Página inicial carregada!');
    // Exemplo: Adicionar um evento de clique no botão de cadastro
    const cadastroBtn = document.querySelector('.btn-primary');
    if (cadastroBtn) {
        cadastroBtn.addEventListener('click', () => {
            alert('Você será redirecionado para a página de cadastro!');
        });
    }
});