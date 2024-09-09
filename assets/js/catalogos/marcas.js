base_url = base_url + 'catalogos/marcas/';
let tabla = $('#tabla_marcas');
let tabla2 = $('#ver_uso');
let columns = [
    {field: 'nom_marca', title: 'Marca'},
    {field: 'fecha_registro', title: 'Fecha de registro'},
    {field: 'id', title: 'Acciones', formatter: accion, align: 'center'}
];
let columnsV = [
    {field: 'num_serie', title: 'Número de serie'},
    {field: 'modelo', title: 'Modelo'},
    {field: 'fecha_registro', title: 'Fecha de registro'}
];

$(document).ready(function() {
    $('#frm_container').parsley();
    tabla.bootstrapTable({
        columns: columns,
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
        <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminar(${row.id})">
            <i class="glyph-icon icon-trash"></i>
        </button>
    `;
    if (row.vehiculos_id != null) {
        boton = `
        <button class="btn btn-round btn-info" title="La marca está en uso" type="button" onclick="ver(${row.id})">
            <i class="glyph-icon icon-eye"></i>
        </button>
        <button class="btn btn-round btn-danger" title="Eliminar" disabled type="button" onclick="eliminar(${row.id})">
            <i class="glyph-icon icon-trash"></i>
        </button>
    `;
    }
    return boton;
}

function ver(id) {
    let url = base_url + 'ver_vehiculos_marcas';
    $.ajax({
        url: url,
        type: 'POST',
        data: {'id': id},
        success: function(data) {
            let json = data.data;
            if (json.length >= 0) {
                $('#modalMarcas').modal('show');
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
    let url = base_url + "agregar_marcas";
    let data = {
        'marca': document.getElementById('marca').value
    };
    
    $.ajax({
        type: 'POST',
        data: data,
        url: url,
        success: function(data) {
            if (data.status === 'success') {
                notificar_swal('Registro exitoso', data.message, 'success');
                tabla.bootstrapTable('refresh');
            } else {
                notificar_swal('Error', data.message, 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error: ', error);
            Swal.fire({
                title: 'Error',
                text: xhr.responseJSON ? xhr.responseJSON.message : 'Ocurrió un error inesperado',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    });
}

function eliminar(id) {
    let url = base_url + "eliminar_marcas";

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
                success: function(data) {
                    if (data.status === 'success') {
                        notificar_swal('Eliminado', data.message, 'success');
                        tabla.bootstrapTable('refresh');
                    } else {
                        notificar_swal('Error', data.message, 'error');
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