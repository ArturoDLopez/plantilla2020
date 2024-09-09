base_url = base_url + "secciones/vehiculos";
let modal_id = "modalForm";
let tabla = $("#tableV");
let arreglo_campos = ['num_serie', 'marca', 'modelo', 'color', 'tipo'];
let variable;
let datosTabla = 0;
let elemento = document.getElementById('btn_duenos');
let columns = [
    { field: 'num_serie', title: 'Número de serie' },
    { field: 'nom_marca', title: 'Marca' },
    { field: 'modelo', title: 'Modelo' },
    { field: 'nom_tipo', title: 'Tipo' },
    { field: 'nom_color', title: 'Color' },
    { field: 'fecha_registro', title: 'Fecha de registro' },
    { field: 'id', title: 'Acciones', formatter: acciones, align: 'center' }
];

$(document).ready(function(){
    $('#frm_container').parsley();
    tabla.bootstrapTable({
        url: base_url + '/cargar_vehiculos',
        method: 'get',
        pagination: true,
        sidePagination: 'server',
        pageSize: 10,
        pageList: [10, 25, 50, 100],
        queryParams: function (params) {
            return {
                offset: params.offset,
                limit: params.limit
            };
        },
        responseHandler: function (res) {
            return {
                total: res.total,
                rows: res.rows
            };
        },
        columns: columns
    });
});

$('#frm_container').on('submit', function(e){
    e.preventDefault();
    if($('#frm_container').parsley().isValid()){
        registrar_local();
        $('#frm_container').parsley().reset();
    }
});

function acciones(value, row, index){
    return `
        <button class="btn btn-round btn-azure" title="Editar" type="button" onclick="rellenar('${row.id}')">
            <i class="glyph-icon icon-edit"></i>
        </button>
        <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminar('${row.id}', '${base_url}/eliminar_auto', columns, tabla)">
            <i class="glyph-icon icon-trash"></i>
        </button>
    `;
}

function llamar(){
    $.ajax({
        url: base_url + '/cargar_marcas',
        method: 'POST',
        success: function(data){
            let json = data;
            if(json.status === "success" && json.data.length > 0){
                let opciones = '<option disabled="" selected="" hidden="">Seleccione una marca...</option>';
                json.data.forEach(element => {
                    opciones += `<option value="${element.id}">${element.nom_marca}</option>`;
                });
                document.getElementById('marca').innerHTML = opciones;
            }
        }
    });

    $.ajax({
        url: base_url + '/cargar_colores',
        method: 'POST',
        success: function(data){
            if(data.status === "success" && data.data.length > 0){
                let opciones = '<option disabled="" selected="" hidden="">Seleccione un color...</option>';
                data.data.forEach(element => {
                    opciones += `<option value="${element.id}">${element.nom_color}</option>`;
                });
                document.getElementById('color').innerHTML = opciones;
            }
        }
    });

    $.ajax({
        url: base_url + '/cargar_tipos',
        method: 'POST',
        success: function(data){
            json = data.data;
            if(data.status === "success" && json.length > 0){
                let opciones = '<option disabled="" selected="" hidden="">Seleccione un tipo...</option>';
                json.forEach(element => {
                    opciones += `<option value="${element.id}">${element.nom_tipo}</option>`;
                });
                document.getElementById('tipo').innerHTML = opciones;
            }
        }
    });

    llamar_modal(modal_id, arreglo_campos);
}

function rellenar(id){
    $.ajax({
        url: base_url + '/consultar_auto',
        method: 'POST',
        data: { 'id': id },
        success: function(response){
            if(response.status === "success"){
                datos = response.data;
                llamar();
                document.getElementById('modalFormLabel').innerHTML = 'Actualizar vehículos';
                document.getElementById('btn_duenos').innerHTML = 'Actualizar';
                document.getElementById('num_serie').value = datos.num_serie;
                document.getElementById('marca').value = datos.marcas_id;
                document.getElementById('modelo').value = datos.modelo; 
                document.getElementById('color').value = datos.colores_id;
                document.getElementById('tipo').value = datos.tipo_id;
                variable = id;
            } else {
                notificar_swal('Error', 'No se pudo obtener los datos del vehículo', 'error');
            }
        },
        error: function(){
            notificar_swal('Error', 'Ocurrió un error inesperado', 'error');
        }
    });
}

function registrar_local(){
    $('#frm_container').parsley().reset();
    let datos = {
        'num_serie': document.getElementById('num_serie').value,
        'marca': document.getElementById('marca').value,
        'modelo': document.getElementById('modelo').value,
        'color': document.getElementById('color').value,
        'tipo': document.getElementById('tipo').value
    };
    let url = base_url + '/agregar_vehiculos';
    if(elemento.innerHTML === 'Actualizar'){
        url = base_url + '/editar_auto';
        datos.id = variable;
    }
    $.ajax({
        url: url,
        method: 'POST',
        data: datos,
        success: function(response){
            elemento.innerHTML = 'Registrar';
            if(response.status === "success"){
                limpiar(arreglo_campos);
                Swal.fire({
                    title: 'Éxito',
                    text: 'Registro agregado/actualizado correctamente',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
                tabla.bootstrapTable('refresh');
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'El dato que intentas ingresar ya existe',
                    icon: 'warning',
                    confirmButtonText: 'Aceptar'
                });
            }
        },
        error: function(xhr){
            notificar_swal('Error', xhr.responseJSON ? xhr.responseJSON.message : 'Ocurrió un error inesperado', 'error');
        }
    });
}

function cancelar_local(){
    $('#frm_container').parsley().reset();
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
