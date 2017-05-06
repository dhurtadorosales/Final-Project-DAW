$(function () {
   main();
});

function main() {
    //Desplegar menús al hacer hover
    $('.desplegable').hover(function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(200);
    }, function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(200);
    });

    //Capturar título
    $('.logotipo h3:eq(1)').html($('title').text());
}