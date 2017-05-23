$(function () {
    //Se oculta el select arrendatario
    if ($('#finca_modificar_partPropietario').val() == 100) {
        $('.form-group:eq(5)').hide();
        $('.form-group:eq(6)').hide();
    }

    //Evento cambiar input participacion arrendatario
    $('#finca_modificar_partPropietario')
        .on('focus', function (event) {
            //if ($(this).val() != 100) {
                $('.form-group:eq(5)').show();
                $('.form-group:eq(6)').show();
            //}
        })
        .on('blur', function (event) {
            if ($(this).val() != 100) {
                $('#finca_modificar_partArrend').val(100 - $(this).val());
            }
            else {
                $('#finca_modificar_partArrend').val(0);
                $('.form-group:eq(5)').hide();
                $('.form-group:eq(6)').hide();
            }
        });
});

