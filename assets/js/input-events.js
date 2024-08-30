/**
 * Valida la entrada solamente de caracteres numericos
 * 
 * @param event e 
 * @param string vaL
 */
function solo_numeros(e, val) {

    var unicode = e.charCode ? e.charCode : e.keyCode;
        //console.info(unicode); return;

    var especiales = [];

    if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {

        especiales = [8, 9, 37, 38, 39, 40, 13, 46, 35, 36, 65, 116];

    }

    if (unicode != 8) {

        if ((unicode < 48 || unicode > 57) && ! existe_elemento(especiales, unicode)) {

            e.returnValue = false;
            return false;

        }

    }

    return true;
}

/**
 * Valida la entrada solamente de caracteres numericos cuando se pega directamente la informacion en el campo
 * 
 * @param event e 
 * @param string val
 */
function solo_numeros_pegar(e, val) {

    var regex = /^[0-9]+$/;
    var numStr = val;
    var text = '';

    if (navigator.appName == 'Microsoft Internet Explorer') {

        text = window.clipboardData.getData('text');

    } else {

        text = (e.originalEvent || e || window).clipboardData.getData('text/plain');

    }
        //console.info(text); return;

    if ( ! (regex.test(text) && regex.test(numStr + text))) {

        return false;

    }

    return true;
}

function existe_elemento(arreglo, valor) {

    var existe = false;
    for (var indice in arreglo) {

        if (arreglo[indice] == valor) {

            existe = true;
            break;

        }

    }

    return existe;

}