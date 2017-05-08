$(function () {
   main();
});

function main() {

    $('tbody tr').on('mouseover', function() {
        $(this).find('td:eq(5)').show();
    }).on('mouseleave', function () {
        $(this).find('td:eq(5)').hide();
    });

    $('.eliminar').on('click', function () {

    })
}