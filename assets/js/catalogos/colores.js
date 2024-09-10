base_url = base_url + "catalogos/colores/";
elementos = ["marca"];
let tabla = $('#tabla_colores');
let tabla2 = $('#ver_uso');
columnsColor = [
    {field: 'nom_color', title: 'Color'}, 
    {field: 'fecha_registro', title: 'Fecha de registro'}, 
    {field: 'id', title: 'Acciones', formatter: accionC, align: 'center'}
];
let columnsV = [
    {field: 'num_serie', title: 'Numero de serie'},
    {field: 'modelo', title: 'modelo'},
    {field: 'fecha_registro', title: 'Fecha de registro'},
];


$(document).ready(function(){
    $('#frm_container').parsley();
    tabla.bootstrapTable({
        columns: columnsColor,
        pageSize: 10,
        pageList: [10,20],
        pagination: true,
        sidePagination: 'server',
        queryParams: function(params){
            return{
                limit: params.limit,
                offset: params.offset
            }
        }
        
    })
});

$('#frm_container').on('submit', function(e){
    e.preventDefault();
    if($('#frm_container').parsley().isValid()){
        agregar();
        $('#frm_container').parsley().reset();
    }
})

function accionC(value, row, index){
    let boton = `
    <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminar('${btoa(row.id)}')">
                <i class="glyph-icon icon-trash"></i>
    </button>
    `;
    if(row.vehiculos_id != null){
        boton = `
        <button class="btn btn-round btn-info" title="Ver uso del color" type="button" onclick="ver('${btoa(row.id)}')">
                    <i class="glyph-icon icon-eye"></i>
        </button>
        <button class="btn btn-round btn-danger" title="Ver uso" disabled type="button" onclick="eliminar('${btoa(row.id)}')">
                    <i class="glyph-icon icon-trash"></i>
        </button>
    `;
    }

    return boton;
}

function ver(id){
    url = base_url + 'ver_vehiculos_colores';
    $.ajax({
        url: url,
        type: 'POST',
        data: {'id':atob(id)},
        success: function(data){
            json = data.data;
            if(json.length >= 0){
                $('#modalColores').modal('show');
                tabla2.bootstrapTable('destroy');
                tabla2.bootstrapTable({
                    columns: columnsV,
                    data: json
                });
            }
        },
        error: function(xhr, status, error){
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

function agregar(){
    url = base_url + "agregar_colores";
    let data = {
            'color': document.getElementById('color').value
        };
        
        $.ajax({
            type: 'POST',
            data: data,
            url: url,
            success: function (data){
                if(data.status === 'success'){
                    notificar(data.message, 'success');
                    tabla.bootstrapTable('refresh');
                    limpiar_modal(elementos);
                    cerrar_modal('modalForm');
                } else {
                    notificar(data.message, 'error');
                }
            },
            error: function(xhr, status, error){
                console.error('Error: ', error);
                Swal.fire({
                    title: 'Error',
                    text: xhr.responseJSON ? xhr.responseJSON.message : 'Ocurrió un error inesperado',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        })
}

function eliminar(id){
    let url = base_url + "eliminar_colores";

    Swal.fire({
        title: 'Eliminar',
        text: '¿Seguro que quieres eliminar este elemento?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if(result.isConfirmed){
            $.ajax({
                url: url,
                method: 'POST',
                data: {'id': atob(id)},  
                success: function(response){
                    if(response.status === 'success'){
                        notificar(response.message, 'success');
                        tabla.bootstrapTable('refresh');
                    } else {
                        notificar(response.message, 'error');
                    }
                },
                error: function(xhr, status, error){
                    notificar_swal('Error', xhr.responseJSON ? xhr.responseJSON.message : 'Ocurrió un error inesperado', 'error');
                }
            });
        }
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