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
