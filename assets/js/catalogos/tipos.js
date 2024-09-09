base_url = base_url + "catalogos/tipos/";
let tabla = $('#tabla_tipos');
let tabla2 = $('#ver_uso');

let columnsV = [
    { field: 'num_serie', title: 'Número de serie' },
    { field: 'modelo', title: 'Modelo' },
    { field: 'fecha_registro', title: 'Fecha de registro' }
];

$(document).ready(function() {
    $('#frm_container').parsley();
    tabla.bootstrapTable({
        pagination: true,
        sidePagination: 'server',
        pageSize: 10,
        queryParams: function(params) {
            return {
                limit: params.limit,
                offset: params.offset
            };
        }
    });
});

$('#frm_container').on('submit', function(e) {
    e.preventDefault();
    if ($('#frm_container').parsley().isValid()) {
        agregar();
        $('#frm_container').parsley().reset();
    }
});

function accion(value, row, index) {
    let boton = `
        <button class="btn btn-round btn-danger" title="Eliminar" onclick="eliminar(${row.id})">
            <i class="glyph-icon icon-trash"></i>
        </button>
    `;
    if (row.vehiculos_id != null) {
        boton = `
        <button class="btn btn-round btn-info" title="Ver uso del tipo" onclick="ver(${row.id})">
            <i class="glyph-icon icon-eye"></i>
        </button>
        <button class="btn btn-round btn-danger" disabled>
            <i class="glyph-icon icon-trash"></i>
        </button>
    `;
    }
    return boton;
}

function ver(id) {
    $.ajax({
        url: base_url + 'ver_vehiculos_tipos',
        type: 'POST',
        data: {'id': id},
        success: function(data) {
            let json = data.data;
            if (json.length > 0) {
                $('#modalTipos').modal('show');
                tabla2.bootstrapTable('destroy');
                tabla2.bootstrapTable({
                    columns: columnsV,
                    data: json
                });
            }
        },
        error: function(xhr, status, error) {
            notificar_swal('Error', xhr.responseJSON ? xhr.responseJSON.message : 'Ocurrió un error inesperado', 'error');
        }
    });
}

function agregar() {
    let url = base_url + "agregar_tipos";
    let data = { 'tipo': $('#tipo').val() };

    $.ajax({
        type: 'POST',
        data: data,
        url: url,
        success: function(response) {
            if (response == 0) {
                notificar_swal('Error', 'El tipo ya existe', 'warning');
            } else {
                notificar_swal('Éxito', 'Agregado correctamente', 'success');
                tabla.bootstrapTable('refresh');
            }
        },
        error: function(xhr, status, error) {
            notificar_swal('Error', xhr.responseJSON ? xhr.responseJSON.message : 'Ocurrió un error inesperado', 'error');
        }
    });
}

function eliminar(id) {
    let url = base_url + "eliminar_tipos";

    Swal.fire({
        title: 'Eliminar',
        text: '¿Seguro que quieres eliminar este elemento?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                method: 'POST',
                data: {'id': id},
                success: function(response) {
                    if (response != 0) {
                        notificar('Tipo eliminado correctamente', 'success');
                        tabla.bootstrapTable('refresh');
                    } else {
                        notificar('No se pudo eliminar el tipo', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    notificar_swal('Error', xhr.responseJSON ? xhr.responseJSON.message : 'Ocurrió un error inesperado', 'error');
                }
            });
        }
    });
}

function mostrar_modal() {
    $('#modalForm').modal('show');
}

function queryParams(params) {
    return {
        limit: params.limit,
        offset: params.offset
    };
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

function notificar_swal(titulo, texto, icono) {
    Swal.fire({
        title: titulo,
        text: texto,
        icon: icono,
        confirmButtonText: 'Aceptar'
    });
}
