export function notificar(texto, tipo) {
    texto = typeof texto !== 'undefined' ? texto : "--";
    tipo = typeof tipo !== 'undefined' ? tipo : "success";

    new Noty({
        type: tipo,
        theme: 'sunset',
        text: texto,
        timeout: 1500
    }).show();
}