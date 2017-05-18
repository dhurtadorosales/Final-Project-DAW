$(function () {
   main();
});

function main() {

    //Evento click sobre una fila de tabla
    $('.clickable-row').on('click', function(event) {
        //Añadimos la clase seleccionado
        $(this).addClass('seleccionado').siblings().removeClass('seleccionado');

        //Botones de fila visibles
        $(this).find('.btn').removeClass('btnOculto');
        $('.clickable-row').not(this).find('.btn').addClass('btnOculto');
    });
}