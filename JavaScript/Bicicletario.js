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