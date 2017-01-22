$(document).ready(function(){

    if($('.padre').height()<$(window).height()-70){
        $('.padre').height($(window).height()-70)
        console.log('Sí se altera la altura')
    } else {
        console.log('No se altera la altura')
    }

})