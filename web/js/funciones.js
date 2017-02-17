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
    function getIva10(valor, moneda){
        var decimales = 0;
        if(moneda!=1){decimales=2;}
        var iva = valor / 11;
        iva=iva.toFixed(decimales);
        return iva;
    }

    //Calcular IVA al 5%
    function getIva5(valor, moneda){
        var decimales = 0;
        if(moneda!=1){decimales=2;}
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

    //Rellenar campos de comprobantes
    function relleFac(campo, largo){
        var completo = '0000000000000000'+campo;
        return completo.substr(-largo, largo);
    }

    // selecciona el contenido del imput
    function selText(){
        $("input[type=text]").focus(function(){
            if(this.readOnly==false){
                this.select();
            } else {
                this.select(false);
            }
        });
    }
