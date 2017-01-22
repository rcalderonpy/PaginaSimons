$(document).ready(function(){

    // Ajax solicita datos de entidad
    $('#rucent').on('blur', function(e){
        e.preventDefault();
        var ruc_entidad = $('#rucent').val();
        var url = "/contab/venta/entidad/"+ruc_entidad;

        $.post(url, function(data){
            console.log('se reciben los datos');
            console.log(data);
            var datos=data;
            if(datos['dv']!=null){
                $('#dv').attr({'value': datos['dv'], 'readonly':true, 'class':'inactivo' }).val(datos['dv']);
                $('#nombres').attr({'value': datos['nombre'],'readonly':true, 'class':'inactivo' }).val(datos['nombre']);
                // $('#ape1').attr({'value': datos['ape1'], 'readonly':true, 'class':'inactivo'});
            } else {
                $('#dv').attr({'value': '', 'readonly':false, 'class':'' }).val('');
                $('#nombres').attr({'value': '', 'readonly':false, 'class':'' }).val('');
                // $('#ape1').attr({'value': '', 'readonly':false, 'class':'' }).val('');
            }
        });
    });



});