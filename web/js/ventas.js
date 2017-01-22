$(document).ready(function(){

    // selecciona el contenido del imput

    $("input[type=text]").focus(function(){
        this.select();
    });

    // BOTON GUARDAR
    $('#btn_guardar').on('click', function(e){
        e.preventDefault();
        $('#formu_vta').submit();

    });

    //Pasar de texto a numero
    function valor(objeto){
        var input=objeto;
        return parseFloat(input.val());
    };

    //Calcular IVA al 10%
    function getIva10(valor, decimales){
        var iva = valor / 11;
        iva=iva.toFixed(decimales);
        return iva;
    }

    //Calcular IVA al 5%
    function getIva5(valor, decimales){
        var iva = valor / 21;
        iva=iva.toFixed(decimales);
        return iva;
    }

   // Cálculos de inputs
    $('#formu_vta input').on('blur', function(){
        var iva10 = getIva10( valor($('#gravado10')) );
        var iva5 = getIva5( valor($('#gravado5')) );
        var g10 = $('#gravado10').val()-iva10;
        var g5 = $('#gravado5').val()-iva5;
        var exe = $('#exento').val()


        $('#iva10').val(iva10);
        $('#iva5').val(iva5);

        $('#g10').val(g10);
        $('#g5').val(g5);
        $('#exe').val(exe);

        $('#al_iva10').val(iva10);
        $('#al_iva5').val(iva5);

    });



});