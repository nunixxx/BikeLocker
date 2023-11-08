$(document).ready(function() {
    $('.form-select').select2();
});
function validateFile() {
    const fileInput = document.getElementById('imagem');
    const file = fileInput.files[0];

    console.log(fileInput);
    
    if (file) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (allowedTypes.includes(file.type)) {
            console.log(file.type);
        } else {
            alert('Tipo de arquivo não permitido. Apenas imagens JPEG, PNG e GIF são permitidas.');
            fileInput.value = ''; // Limpa o input de arquivo se o tipo não for permitido.
        }
    }
}

function mostrarPopupAntesDoEnvio() {
    document.getElementById("ConfDel").style.display = "block";
    // Impedir o envio padrão do formulário
    event.preventDefault();
}

function fecharPopup() {
    document.getElementById("ConfDel").style.display = "none";
}

document.getElementById("deletar").addEventListener("DOMContentLoaded", function(event) {
    event.preventDefault(); // Impedir o envio padrão do formulário
    mostrarPopupAntesDoEnvio();
});

document.getElementById("enviarFormulario").addEventListener("click", function() {
    document.getElementById("deletar").submit(); // Envie o formulário após a confirmação
});
