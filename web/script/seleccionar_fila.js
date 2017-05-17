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

    $(".desplegable").hide();

    if((screen.width>=992) && (screen.height>=768)){
        $("#usuario").mouseenter(function() {
            $(".desplegable").show();
        }).mouseleave(function() {
            $(".desplegable").hide();
        });

        $(".desplegable").mouseenter(function() {
            $(".desplegable").show();
        }).mouseleave(function() {
            $(".desplegable").hide();
        });
    }
    else{
        $("#usuario").click(function() {
            $(".desplegable").toggle();
        });
    }

    $('select').select2()({
        theme: "bootstrap"
    });
}