$(function () {
   main();
});

function main() {

    var path;
    var nif;
    var nombre;

    //Evento click sobre una fila de tabla
    $('.clickable-row').on('click', function(event) {
        //Añadimos la clase seleccionado
        $(this).addClass('seleccionado').siblings().removeClass('seleccionado');



        //Botones de fila visibles
        $(this).find('.btn').removeClass('btnOculto');
        $('.clickable-row').not(this).find('.btn').addClass('btnOculto');

        //Ruta
       /* nif = $(this).find('td:eq(0)').html();
        nombre = $(this).find('td:eq(1)').html();
        path = "{{ path('confirmar_empleados_eliminar', {'nif' : " + nif + "}) }}";

        $('form').attr('action', path);
        $('.modal-title').html(nombre);
 */

    });
}