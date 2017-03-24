$(document).ready(function(){

    //Agrega js de funciones generales
    $.getScript("/js/funciones.js");

    var detalleglobal = [];

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
            $('#renta').addClass('inactivo');
            detalleglobal=[];

        } else {
            $('#gravado10').removeClass('inactivo');
            $('#gravado5').removeClass('inactivo');
            $('#exento').removeClass('inactivo');
            $('#codCta').removeClass('inactivo');
            $('#cuenta').removeClass('inactivo');
            $('#renta').removeClass('inactivo');
            $('#total_comprobante').removeClass('inactivo');
            $('#comentario').text('');
        }
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
        camposControl();
    });

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

    // -------------------- EVENTOS --------------------


    // selecciona el contenido del imput
    selText();
    // $("input[type=text]").focus(function(){
    //     // this.select();
    // });


    // BOTON GUARDAR
    // $('#btn_guardar').on('click', function(e){
    //     e.preventDefault();
    //     if(valor($('#diferencia'))!=0){
    //         alert('Comprobante No Balancea!!!')
    //     } else {
    //         $('#formu_vta').submit();
    //     }
    // });



    $('#anul').on('checked', function(e){e.preventDefault();});

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
        anularVenta(true);
        msg.modal('hide');
    });

    // Modal Anular - Botón Cancelar
    $('#modal_cancelar').on('click', function(){
        $('#chklabel').text('Anular?');
        $('#anul').prop({'checked':false});
        anularVenta(false);
        msg.modal('hide');
    });

    // BOTON AGREGAR LÍNEA
    $("#add_linea").on('click', function(){
        // validaciones carga
        var codigo=$('#codCta').val();
        var cuenta=$('#cuenta').val();
        var g10=$('#gravado10').val()-valor($('#iva10'));
        var iva10=$('#iva10').val();
        var g5=$('#gravado5').val()-valor($('#iva5'));
        var iva5=$('#iva5').val();
        var exe=$('#exento').val();
        var afecta = $('#renta').val();
        var sumanum = g10+g5+exe;

        if(codigo!='' && cuenta!='' && sumanum >0){
            var suma_venta=valor($('#gravado10'))+valor($('#gravado5'))+valor($('#exento'));
            var suma_iva=valor($('#iva10'))+valor($('#iva5'));

            var nuevaFila=
                "<tr id='fila'>"+
                "<td class='text-center'>"+$('#codCta').val()+"</td> " +
                "<td>"+$('#cuenta').val()+"</td> " +
                "<td class='text-right'>"+ $.number(suma_venta) +"</td> " +
                "<td class='text-right'>"+$.number(suma_iva) +"</td> " +
                "<td>"+exe+"</td> " +
                "<td class='text-center' id='borrar_linea'><span class='glyphicon glyphicon-remove text-danger'></span></td>" +
                "</tr>";
            $("#tabla tbody").append(nuevaFila);
            detalleglobal.push({'id':0, 'codigo':codigo, 'cuenta':cuenta, 'g10':g10, 'g5':g5, 'iva10':iva10, 'iva5':iva5, 'exe':exe, 'afecta':afecta});
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
        var codigo=$(this).parent().children()[0].textContent;
        var monto = $(this).parent().children()[2].textContent
        // console.log('Código = '+codigo+'; Monto='+monto);
        // console.log(detalleglobal);

        // elimina datos de detalleglobal
        detalleglobal.splice($.inArray(codigo, detalleglobal),1);
        // console.log(detalleglobal);

        // elimina datos de la tabla
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


    // coloca separador de miles a todos los campos con la clase .numero
    $('.numero').number( true, 2, '.', ',');


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


        console.log(detalle);

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

    // AJAX RECUPERAR VENTA PARA EDITAR

    // $('#brand').on('click', function(e){

        // e.preventDefault();

        // --- DATOS CABECERA ---
        var ruta = window.location.pathname.split("/");
        var formulario = ruta[2];
        var estado = ruta[7];
        if(formulario=='venta' && estado=='edit'){
            console.log(ruta);
            var id_venta = ruta[6];
            console.log(estado);

            $.post("/contab/venta/recuperar_venta/"+id_venta, function(data){
                // console.log('datos almacenados');
                console.log(data);

                // RELLENAR EL FORMULARIO - CABECERA
                $('#rucent').val(data['ruc']);
                $('#dv').val(data['dv']);
                $('#nombres').val(data['cliente']);
                $('#nsuc').val(data['nsuc']);
                $('#npe').val(data['npe']);
                $('#ncomp').val(data['ncomp']);
                $('#timbrado').val(data['timbrado']);
                $('#condicion').val(data['condicion']);
                $('#moneda').val(data['moneda']);
                $('#cotiz').val(data['cotiz']);
                $('#anul').prop('checked', data['anul']);
                if(data['anul']==true){$('#chklabel').text('Anulado')};
                $('#comentario').val(data['comentario']);

                // RELLENAR EL FORMULARIO - DETALLE
                detalleglobal=data['detalle'];
                var suma_total = 0;
                $.each(detalleglobal, function(i){
                    console.log(detalleglobal[i]);
                    var suma_venta= parseFloat(detalleglobal[i]['g10'])+ parseFloat(detalleglobal[i]['g5'])+ parseFloat(detalleglobal[i]['iva10'])+ parseFloat(detalleglobal[i]['iva5'])+ parseFloat(detalleglobal[i]['exe']);
                    var suma_iva= parseFloat(detalleglobal[i]['iva10'])+ parseFloat(detalleglobal[i]['iva5']);
                    suma_total+=suma_venta;

                    var nuevaFila=
                        "<tr id='fila_"+i+"'>"+
                        "<td class='text-center'>"+detalleglobal[i]['codigo']+"</td> " + //codigo
                        "<td>"+detalleglobal[i]['cuenta']+"</td> " + //cuenta
                        "<td class='text-right numero'>"+ $.number(suma_venta, 0, ',') +"</td> " + //total
                        "<td class='text-right numero'>"+ $.number(suma_iva) +"</td> " +
                        "<td>"+ detalleglobal[i]['afecta']+"</td> " +
                        "<td class='text-center' id='borrar_linea'><span class='glyphicon glyphicon-remove text-danger'></span></td>" +
                        "</tr>";
                    $("#tabla tbody").append(nuevaFila);
                })

                $('#total_comprobante').val(suma_total);
                $('#cargado').val(suma_total);
                $('#diferencia').val(0);



            });
        }

    // });

});