base_url += "secciones/duenos/";
let elemento = document.getElementById('btn_duenos');
let modal_id = "modalForm";
let tabla = $("#tableV");
let arreglo_campos = ['curp', 'nombre', 'ap', 'am'];
let variable;
let datosTabla = 0;
let columns = [
    {field: 'curp', title: 'Curp'},
    {field: 'nombre', title: 'Nombre'},
    {field: 'apellido_p', title: 'Apellido paterno'},
    {field: 'apellido_m', title: 'Apellido materno'},
    {field: 'fecha_registro', title: 'Fecha de registro'},
    {field: 'id', title: 'Acciones', formatter: acciones, align: 'center'}
];

$(document).ready(function(){
    $('#frm_duenos').parsley();
    tabla.bootstrapTable();
});

$('#frm_duenos').on('submit', function(e){
    e.preventDefault();
    if($('#frm_duenos').parsley().isValid()){
        registrar_local();
        $('#frm_duenos').parsley().reset();
    }
})

function queryParams(params){
    return{
        limit: params.limit,
        offset: params.offset
    }
}

function acciones(value, row, index){
    return `
        <button class="btn btn-round btn-azure" title="Editar" type="button" onclick="rellenar(${row.id})">
            <i class="glyph-icon icon-edit"></i>
        </button>
        <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminar(${row.id}, '${base_url}eliminar_dueno', columns, tabla)">
            <i class="glyph-icon icon-trash"></i>
        </button>
    `;
}

function llamar(){
    llamar_modal(modal_id, arreglo_campos);
}

function rellenar(id){
    $.ajax({
        url: base_url + 'consultar_dueno',
        method: 'POST',
        data: {'id': id},
        success: function(datos){
            console.log('datos: ', datos);
            datos = datos.data;
            llamar_modal(modal_id, arreglo_campos);
            document.getElementById('modalFormLabel').innerHTML = 'Actualizar dueños';
            document.getElementById('btn_duenos').innerHTML = 'Actualizar';
            document.getElementById('curp').value = datos.curp;
            document.getElementById('nombre').value = datos.nombre;
            document.getElementById('ap').value = datos.apellido_p;
            document.getElementById('am').value = datos.apellido_m;
            variable = id;
        },
        error: function(xhr, status, error){
            notificar_swal('Error', xhr.responseJSON ? xhr.responseJSON.message : 'Ocurrió un error inesperado', 'error');
        }
    })
}

function registrar_local(){
    $('#frm_duenos').parsley().reset();
    datos = {
            'curp' : document.getElementById('curp').value,
            'nombre' : document.getElementById('nombre').value,
            'ap' : document.getElementById('ap').value,
            'am' : document.getElementById('am').value,
        }
    if(elemento.innerHTML == 'Registrar'){
        document.getElementById('modalFormLabel').innerHTML = 'registrar dueño';
    }
    else{
        datos.id = variable;
    }
    registrar(base_url + 'agregar_dueno', base_url + 'editar_dueno', datos, elemento, columns, arreglo_campos, tabla);
}

function cancelar_local(){
    $('#frm_duenos').parsley().reset();
    cancelar('btn_duenos', 'btn_cancel', arreglo_campos);
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