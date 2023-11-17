$(document).ready(function() {
    $('.form-select').select2();
});
function updateBikeOptions() {
    const selectedCpf = $("#cpf").val();
    const bikeIdSelect = $("#bike_id");
    const cor = $("#cor").val();

    bikeIdSelect.empty();

    // Adicione a opção padrão
    bikeIdSelect.append($('<option>', {
        value: "",
        text: "ID"
    }));
    console.log(selectedCpf);
    if (selectedCpf) {
        // Chame o PHP para buscar as bicicletas com base no CPF
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: `../../Controller/BicicletarioJs.controller.php?acao=selectedCpf&cpf=${selectedCpf}`,
            data: { cor: cor, id: bikeIdSelect.val(), cpf: selectedCpf },
            success: function(data) {

                
                console.log(data);

                const bikes = data;

                console.log(bikes);
                
                // Adicione as bicicletas como opções em "bike_id"
                bikes.forEach(function(bike) {
                    console.log(bike);
                    bikeIdSelect.append(`<option value="${bike.id}"> ${bike.id}</option>`);
                });
            }
        });
    }
}

function updateImageOptions() {
    const selectedCpf = $("#cpf").val();
    const bikeIdSelect = $("#bike_id");
    const cor = $("#cor").val();
    var divFoto = document.getElementById('fotoSelect');

    divFoto.style.display = 'block';

    // Use AJAX para chamar o script PHP que retorna os IDs das bicicletas vinculadas ao CPF
    // Exemplo com jQuery para simplicidade, mas você pode usar XMLHttpRequest se preferir
    $.ajax({
        url: `../../Controller/BicicletarioJs.controller.php?acao=selectedCpf&cpf=${selectedCpf}`,
        dataType: 'json',
        type: 'POST',
        data: { cor: cor, id: bikeIdSelect.val(), cpf: selectedCpf },
        success: function(data) {
            console.log(data);
        // 'response' deve conter a array com os IDs das bicicletas
        const bikeData = data;
        
        console.log(bikeData);

        $("#fotoSelect").empty();
        
        bikeData.forEach(function(bike) {
            console.log(bike.id);
                var imagePath = "../../Arquivos/" + bike.id + ".png";
                var imgElement = $("<img style='width:100px;'>").attr("src", imagePath).attr("alt", "Bicicleta " + bike.id).attr("title", bike.id);
                $("#fotoSelect").append( imgElement);
            });
        },
        error: function(error) {
        console.error('Erro ao obter os IDs das bicicletas: ' + error);
        }
    });
}
