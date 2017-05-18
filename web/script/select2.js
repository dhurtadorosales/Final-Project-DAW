$(".desplegable2").hide();

if((screen.width>=992) && (screen.height>=768)){
    $("#usuario").mouseenter(function() {
        $(".desplegable2").show();
    }).mouseleave(function() {
        $(".desplegable2").hide();
    });

    $(".desplegable2").mouseenter(function() {
        $(".desplegable2").show();
    }).mouseleave(function() {
        $(".desplegable2").hide();
    });
}
else{
    $("#usuario").click(function() {
        $(".desplegable2").toggle();
    });
}

$('select').select2()({
    theme: "bootstrap"
});