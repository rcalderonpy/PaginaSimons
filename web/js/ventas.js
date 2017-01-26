$(document).ready(function(){

    var detalleglobal = [];

    // -------------------- FUNCIONES GENERALES --------------------

    //Pasar de texto a numero
    function valor(objeto){
        var input=objeto;
        return parseFloat(input.val());
    }

    //Se carga el valor del 'id' del elemento y devuelve ('#nombre_id').val();
    function valorId(nombre){
        var selector = $("#"+ nombre ).val();
        return selector;
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
        // console.log(resultVal);
        return resultVal;
    }

    // -------------------- FUNCIONES ESPECÍFICAS --------------------

    // Función Anular
    function anularVenta(estado){
        if(estado==true){
            $('#gravado10').addClass('inactivo');
            $('#gravado5').addClass('inactivo');
            $('#exento').addClass('inactivo');
            $('#codCta').addClass('inactivo').val('');
            $('#cuenta').addClass('inactivo').val('');
            $('#total_comprobante').addClass('inactivo');
            $('.numero').val('0');
            $('#comentario').text('Comprobante Anulado');
            detalleglobal=[];

        } else {
            $('#gravado10').removeClass('inactivo');
            $('#gravado5').removeClass('inactivo');
            $('#exento').removeClass('inactivo');
            $('#codCta').removeClass('inactivo');
            $('#cuenta').removeClass('inactivo');
            $('#total_comprobante').removeClass('inactivo');
            $('#comentario').text('');
        }
    }
    //
    // Agrega Valores a los campos Total Cargado y Diferencia
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

    // Limpia el detalle
    function limpiarDetalle(){
        $('#codCta').val('');
        $('#cuenta').val('');
        $('#gravado10').val($('#diferencia').val());
        $('#gravado5').val('0');
        $('#iva10').val('0');
        $('#iva5').val('0');
        $('#exento').val('0');
    }

    // Limpia la cabecera
    function limpiarCabecera(){
        $('#tipo_comp').val('1');
        $('#dia').val('1');
        $('#rucent').val('');
        $('#nsuc').val('');
        $('#npe').val('');
        $('#ncomp').val('');
        $('#timbrado').val('');
        $('#condicion').val('0');
        $('#moneda').val('1');
        $('#cotiz').val('0');
        $('#anul').prop('checked', false);
        $('#comentario').val('');
    }

    // --- DATOS CABECERA ---
    var ruta = window.location.pathname.split("/");
    var idcliente = ruta[3];
    var tipo_comp=valorId('tipo_comp');
    var dia=valorId('dia');
    var mes = ruta[4];
    var ano = ruta[5];
    var rucent=$('#rucent').val();
    var nsuc=valorId('nsuc');
    var npe=valorId('npe');
    var ncomp=valorId('ncomp');
    var timbrado=valorId('timbrado');
    var condicion=valorId('condicion');
    var moneda=valorId('moneda');
    var cotiz=valorId('cotiz');
    var anul=$("#anul").prop('checked');
    var comentario=valorId('comentario');

    // -------------------- EVENTOS --------------------


    // selecciona el contenido del imput
    $("input[type=text]").focus(function(){
        this.select();
    });


    // BOTON GUARDAR
    // $('#btn_guardar').on('click', function(e){
    //     e.preventDefault();
    //     if(valor($('#diferencia'))!=0){
    //         alert('Comprobante No Balancea!!!')
    //     } else {
    //         $('#formu_vta').submit();
    //     }
    // });



    var msg=$('#modAnular');
    msg.modal({backdrop:'static', show:false});

    // Boton Anular
    $('#anul').on('click', function(e){
        e.preventDefault();
        msg.modal('show');
        console.log('se muestra el modal');

        // if(this.checked){
        //     $('#chklabel').text('Anulado');
        // } else {
        //     $('#chklabel').text('Anular?');
        // }
        // var estado = this.checked;
        // anularVenta(estado);
    });

    // Modal Anular - Botón Anular
    $('#modal_anular').on('click', function(){
        $('#chklabel').text('Anulado');
        $('#anul').prop({'checked':true});
        msg.modal('hide');
    });

    // Modal Anular - Botón Anular
    $('#modal_cancelar').on('click', function(){
        $('#chklabel').text('Anular?');
        $('#anul').prop({'checked':false});
        msg.modal('hide');
    });

    // BOTON AGREGAR LÍNEA
    $("#add_linea").on('click', function(){
        // validaciones carga
        var codigo=$('#codCta').val();
        var cuenta=$('#cuenta').val();
        var g10=$('#gravado10').val();
        var iva10=$('#iva10').val();
        var g5=$('#gravado5').val();
        var iva5=$('#iva5').val();
        var exe=$('#exento').val();
        var afecta = $('#renta').val();
        var sumanum = g10+g5+exe;

        if(codigo!='' && cuenta!='' && sumanum >0){
            var suma_venta=valor($('#gravado10'))+valor($('#gravado5'))+valor($('#exento'));
            var suma_iva=valor($('#iva10'))+valor($('#iva5'));

            var nuevaFila=
                "<tr>"+
                "<td class='text-center'>"+$('#codCta').val()+"</td> " +
                "<td>"+$('#cuenta').val()+"</td> " +
                "<td class='text-right'>"+ $.number(suma_venta) +"</td> " +
                "<td class='text-right'>"+$.number(suma_iva) +"</td> " +
                "<td>"+exe+"</td> " +
                "<td class='text-center' id='borrar_linea'><span class='glyphicon glyphicon-remove text-danger'></span></td>" +
                "</tr>";
            $("#tabla tbody").append(nuevaFila);
            detalleglobal.push({'codigo':codigo, 'cuenta':cuenta, 'g10':g10, 'g5':g5, 'iva10':iva10, 'iva5':iva5, 'exe':exe, 'afecta':afecta});
            // console.log(detalleglobal);
            camposControl();
            limpiarDetalle();
            nuevaFila="";

            // Balancea Comprobante
            if($('#diferencia').val()==0){
                alert('desea Guardar comprobante?');
            } else {
                $('#codCta').focus();
            }
        } else {
            alert('Complete todos los campos');
            $('#codCta').focus();
        }
    });

    // BOTON BORRAR LÍNEA
    $("tbody").on('click', "#borrar_linea", function(){
        $(this).parent().remove();
        camposControl();
        limpiarDetalle();
        $('#codCta').focus();
    });

    //validación total comprobante
    $('#total_comprobante').on('blur', function (e) {
        e.preventDefault();
        if($(this).val()==0){
            this.focus();
            $(this).addClass('error');
            // console.log('el comprobante = 0');
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
        camposControl();
    });

    // coloca separador de miles a todos los campos con la clase .numero
    $('.numero').number( true, 0 );


    // Ajax solicita datos de Cuenta Contable
    $('#codCta').on('blur', function(e){

        e.preventDefault();
        var codCta = $('#codCta').val();
        if(codCta!=''){
            var url = "/contab/venta/cuenta/"+codCta;
        } else {
            var url = "/contab/venta/cuenta";
        }

        $.post(url, function(data){
            // console.log('se reciben los datos');
            // console.log(data);
            var datos=data;
            if(datos['cuenta']!=null){
                $('#cuenta').attr({'value': datos['cuenta'],'readonly':true, 'class':'inactivo' }).val(datos['cuenta']);
            } else {
                $('#cuenta').attr({'value': '','readonly':false, 'class':'' }).val('');
            }
        });
    });

    // AJAX GUARDAR VENTAS
    $('#btn_guardar').on('click', function(e){

        e.preventDefault();

        // --- DATOS CABECERA ---
        var ruta = window.location.pathname.split("/");
        var idcliente = ruta[3];
        var tipo_comp=valorId('tipo_comp');
        var dia=valorId('dia');
        var mes = ruta[4];
        var ano = ruta[5];
        var rucent=$('#rucent').val();
        var nsuc=valorId('nsuc');
        var npe=valorId('npe');
        var ncomp=valorId('ncomp');
        var timbrado=valorId('timbrado');
        var condicion=valorId('condicion');
        var moneda=valorId('moneda');
        var cotiz=valorId('cotiz');
        var anul=$("#anul").prop('checked');
        var comentario=valorId('comentario');
        var detalle = detalleglobal;


        console.log('Detalle = '+detalle);

        //PARÁMETROS QUE SE VAN A ENVIAR PARA GUARDAR CABECERA
        var parametros = {
            'tipo_comp': tipo_comp,
            'idcliente': idcliente,
            'dia': dia,
            'mes': mes,
            'ano': ano,
            'rucent':rucent,
            'nsuc':nsuc,
            'npe':npe,
            'ncomp':ncomp,
            'timbrado':timbrado,
            'condicion':condicion,
            'moneda':moneda,
            'cotiz':cotiz,
            'anul':anul,
            'comentario':comentario,
            'detalle':detalle
        };
        // console.log(parametros);

        $.post("/contab/venta/guardar_venta", parametros, function(data){
            // console.log('datos almacenados');
            console.log(data);
            limpiarCabecera();
            window.location.reload(true);
            $('#dia').focus();
            detalleglobal=[];
        });

    });
});