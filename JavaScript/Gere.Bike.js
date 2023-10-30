$(document).ready(function() {
    $('.form-select').select2();
});
function validateFile() {
    const fileInput = document.getElementById('imagem');
    const file = fileInput.files[0];

    if (file) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (allowedTypes.includes(file.type)) {
            // O tipo de arquivo é permitido, pode prosseguir com o envio.
            // Aqui, você pode adicionar código para enviar o arquivo ou realizar outras ações.
        } else {
            alert('Tipo de arquivo não permitido. Apenas imagens JPEG, PNG e GIF são permitidas.');
            fileInput.value = ''; // Limpa o input de arquivo se o tipo não for permitido.
        }
    } else {
        alert('Selecione um arquivo para envio.');
    }
}