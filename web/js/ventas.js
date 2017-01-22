$(document).ready(function(){

    // selecciona el contenido del imput

    $("input[type=text]").focus(function(){
        this.select();
    });


    // BOTON GUARDAR
    $('#btn_guardar').on('click', function(e){
        e.preventDefault();
        if(valor($('#diferencia'))!=0){
            alert('Comprobante No Balancea!!!')
        } else {
            $('#formu_vta').submit();
        }

    });

    function camposControl(){
        // Control de carga
        $('#cargado').val(SumarColumna('tabla', 2));
        $('#diferencia').val($('#total_comprobante').val()-$('#cargado').val());
        if($('#diferencia').val()!=0){
            $('#diferencia').addClass('error');
        } else {
            $('#diferencia').removeClass('error');
        }
    }

    function limpiarDetalle(){
        $('#codCta').val('');
        $('#cuenta').val('');
        $('#gravado10').val($('#diferencia').val());
        $('#gravado5').val('0');
        $('#iva10').val('0');
        $('#iva5').val('0');
        $('#exento').val('0');
    }

    // BOTON AGREGAR LÍNEA
    $("#add_linea").on('click', function(){
        var suma_venta=valor($('#gravado10'))+valor($('#gravado5'))+valor($('#exento'));
        var suma_iva=valor($('#iva10'))+valor($('#iva5'));
        // alert(suma_venta);

        var nuevaFila=
            "<tr>"+
                "<td class='text-center'>"+$('#codCta').val()+"</td> " +
                "<td>"+$('#cuenta').val()+"</td> " +
                "<td class='text-right'>"+ $.number(suma_venta) +"</td> " +
                "<td class='text-right'>"+$.number(suma_iva) +"</td> " +
                "<td>"+"Col 1"+"</td> " +
                "<td class='text-center' id='borrar_linea'><span class='glyphicon glyphicon-remove text-danger'></span></td>" +
            "</tr>";
        $("#tabla tbody").append(nuevaFila);
        nuevaFila="";
        camposControl();
        limpiarDetalle();
        $('#codCta').focus();

    });

    // BOTON BORRAR LÍNEA
    $("tbody").on('click', "#borrar_linea", function(){
        $(this).parent().remove();
    });

    //Pasar de texto a numero
    function valor(objeto){
        var input=objeto;
        return parseFloat(input.val());
    }

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

    //validación total comprobante
    $('#total_comprobante').on('blur', function (e) {
        e.preventDefault();
        if($(this).val()==0){
            this.focus();
            $(this).addClass('error');
            console.log('el comprobante = 0');
        } else {
            $(this).removeClass('error');
            $('#gravado10').val($(this).val())
        }
    });

   // Cálculos de inputs
    $('#formu_vta input').on('blur', function(){
        var iva10 = getIva10( valor($('#gravado10')) );
        var iva5 = getIva5( valor($('#gravado5')) );
        var g10 = $('#gravado10').val()-iva10;
        var g5 = $('#gravado5').val()-iva5;
        var exe = $('#exento').val()


        $('#iva10').val(iva10);
        $('#iva5').val(iva5);

        // Control de carga
        camposControl();
        // $('#cargado').val(SumarColumna('tabla', 2));
        // $('#diferencia').val($('#total_comprobante').val()-$('#cargado').val());
        // if($('#diferencia').val()!=0){
        //     $('#diferencia').addClass('error');
        // } else {
        //     $('#diferencia').removeClass('error');
        // }

        //Valores almacenados
        // $('#g10').val(g10);
        // $('#g5').val(g5);
        // $('#exe').val(exe);
        // $('#al_iva10').val(iva10);
        // $('#al_iva5').val(iva5);

    });

    $('.numero').number( true, 0 );

    //total cargado
    function SumarColumna(grilla, columna) {
        var resultVal = 0;
        var texto='';

        $("#" + grilla + " tbody tr").each(
            function() {

                var celdaValor = $(this).find('td:eq(' + columna + ')');

                if (celdaValor.val() != null){
                    texto=celdaValor.html().replace('.','').replace('.','').replace('.','').replace('.','').replace('.','');
                    resultVal += parseFloat(texto);
                }

            } //function

        )
        return resultVal;
        console.log(resultVal);

        // $("#" + grilla + " tbody tr:last td:eq(" + columna + ")").html(resultVal.toFixed(2).toString().replace('.',','));
    }

    $('#add_btn').on('click', function(){
        $('#espacio').html("<button type='button' class='btn btn-xs btn-danger' id='nuevo_boton'>Boton</button>");
    });

    $('#detalle').on('click', '#nuevo_boton', function () {
        alert('hola prueba boton');
    })
});