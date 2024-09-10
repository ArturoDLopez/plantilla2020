function cerrar_modal(id){
    $('#'+id).modal('hide');
}

function mostrar_modal(id) {
    $('#'+id).modal('show');
}

function limpiar_modal(elementos){
    elementos.forEach(element => {
        document.getElementById(element).value = "";
    });
}

function notificar(texto, tipo) {

    texto = typeof texto !== 'undefined' ? texto : "--";
    tipo = typeof tipo !== 'undefined' ? tipo : "success";

    new Noty({
        type: tipo,
        theme: 'sunset',
        text: texto,
        timeout: 1500
    }).show();
}

function notificar_swal(titulo, texto, icono){
    Swal.fire({
        title: titulo,
        text: texto,
        icon: icono,
        confirmButtonText: 'Aceptar'
    });
}