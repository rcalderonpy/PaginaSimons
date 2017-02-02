$(document).ready(function(){


    // -------------------- FUNCIONES GENERALES --------------------


    // -------------------- FUNCIONES ESPECÍFICAS --------------------



    $('#anul').on('checked', function(e){e.preventDefault();});
    
    var msg=$('#mod_periodo');
    msg.modal({backdrop:'static', show:false});

    // Botón Modal
    $('#mod-btn').on('click', function (e) {
        e.preventDefault();

    });

});