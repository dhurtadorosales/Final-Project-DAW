$(function () {
    //Por defecto
    $('.form-group:eq(3)').show();
    $('.form-group:eq(4)').hide();


    $('#envasado').on('click', function (event) {
        if ($('#envasado').is(':checked')) {
            $('.form-group:eq(3)').show();
            $('.form-group:eq(4)').hide();
        }
        else {
            $('.form-group:eq(3)').hide();
            $('.form-group:eq(4)').show();
        }
    });

    $('#granel').on('click', function (event) {
        if ($('#granel').is(':checked')) {
            $('.form-group:eq(4)').show();
            $('.form-group:eq(3)').hide();
        }
        else {
            $('.form-group:eq(4)').hide();
            $('.form-group:eq(3)').show();
        }
    });

});

