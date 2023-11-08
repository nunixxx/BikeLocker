setTimeout(() => {
    const messageElement = document.getElementById("messageBox");
    if (messageElement) {
        messageElement.remove();
    }
}, 5000);

function mostrarPopupAntesDoEnvio() {
    document.getElementById("ConfDel").style.display = "block";
    // Impedir o envio padrão do formulário
    event.preventDefault();
}

function fecharPopup() {
    document.getElementById("ConfDel").style.display = "none";
}

document.getElementById("deletar").addEventListener("submit", function(event) {
    event.preventDefault(); // Impedir o envio padrão do formulário
    mostrarPopupAntesDoEnvio();
});

document.getElementById("enviarFormulario").addEventListener("click", function() {
    document.getElementById("deletar").submit(); // Envie o formulário após a confirmação
});