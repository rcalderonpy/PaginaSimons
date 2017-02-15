$(document).ready(function(){

    if($('.padre').height()<$(window).height()-70){
        $('.padre').height($(window).height()-70)
        console.log('Sí se altera la altura')
    } else {
        console.log('No se altera la altura')
    }

    // quita flash tras 2 segundos
    setTimeout(function() {
        $("#mensajeFlash").fadeOut(1500);
//				$("#mensajeFlash").slideUp(1500);
    },2000);

})