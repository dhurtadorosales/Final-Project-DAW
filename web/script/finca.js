$(function () {
    //Se oculta el select arrendatario
    $('.form-group:eq(13)').hide();
    $('.form-group:eq(14)').hide();

    //Evento cambiar input participacion arrendatario
    $('#finca_partPropietario')
        .on('focus', function (event) {
            $('.form-group:eq(13)').show();
            $('.form-group:eq(14)').show();
        })
        .on('blur', function (event) {
            if ($(this).val() != 100) {
                $('#finca_partArrend').val(100 - $(this).val());
            }
            else {
                $('#finca_partArrend').val(0);
                $('.form-group:eq(13)').hide();
                $('.form-group:eq(14)').hide();
            }
        });
});

