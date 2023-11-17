setTimeout(() => {
    const messageElement = document.getElementById("messageBox");
    if (messageElement) {
        messageElement.remove();
    }
}, 5000);
// ----------------------------------
function confirmarEnvio() {
    // Exibe um pop-up de confirmação
    return confirm("Deseja mesmo confirmar a ação?");
}

// -----------------------------------

function exibirImagemSelecionada() {
    var input = document.getElementById('imagem');
    var imagem = document.getElementById('imagemSelecionada');
    var divFoto = document.getElementById('fotoSelect');

    // Verifica se foi selecionado um arquivo
    if (input.files && input.files[0]) {
        var leitor = new FileReader();

        leitor.onload = function (e) {
            imagem.src = e.target.result;
            divFoto.style.display = 'inline-block'; // Exibe a imagem
        };

        leitor.readAsDataURL(input.files[0]);
    }
}
// -----------------------------------

// Função para apagar parâmetros GET da URL
function apagarParametrosGET() {
    // Obtém a URL atual
    var urlAtual = window.location.href;

    // Remove os parâmetros GET da URL
    var novaURL = urlAtual.split('?')[0];

    // Atualiza a URL no histórico sem recarregar a página
    window.history.pushState({}, document.title, novaURL);

    window.location.reload();
}

// Adiciona um ouvinte de evento ao botão
document.getElementById('limparURL').addEventListener('click', function() {
    apagarParametrosGET();
});