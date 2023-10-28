$(document).ready(function() {
    $('.form-select').select2();
});
function updateBikeOptions() {
    const selectedCpf = $("#cpf").val();
    const bikeIdSelect = $("#bike_id");

    bikeIdSelect.empty();

    // Adicione a opção padrão
    bikeIdSelect.append($('<option>', {
        value: "",
        text: "ID"
    }));

    if (selectedCpf) {
        // Chame o PHP para buscar as bicicletas com base no CPF
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "../../Controller/Bicicletario.controller.php", // Substitua pelo caminho do seu script PHP
            data: { acao: 'selectedCpf' , cpf: selectedCpf },
            success: function(response) {

                console.log(response);
                // Parse a resposta JSON do PHP
                // const bikes = JSON.parse(response);
                const bikes = response;

                console.log(bikes);
                
                // Adicione as bicicletas como opções em "bike_id"
                bikes.forEach(function(bike) {
                    bikeIdSelect.append(`<option value="${bike.id}"> ${bike.name}</option>`);
                });
            }
        });
    }
}

