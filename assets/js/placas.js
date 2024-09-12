base_url += "secciones/placas/";
let tabla = $("#tableV");
let datosTabla = 0;
let columns = [
    {
        field: 'placa', title: 'Placa'
    },
    {
        field: 'fecha_registro', title: 'Fecha de registro'
    },
    {
        field: 'id', title: 'Acciones', formatter: acciones, align: 'center'
    }

];

$(document).ready(function(){
    $('#frm_placas').parsley();
    tabla.bootstrapTable({
        columns: columns,
        pagination: true,
        sidePagination: 'server',
        sizePage: "10",
        queryParams: function(params){
            return{
                limit: params.limit,
                offset: params.offset
            }
        }
    });
});

$('#frm_placas').on('submit', function(e){
    e.preventDefault();
    if($('#frm_placas').parsley().isValid()){
        registrar();
        $('#frm_placas').parsley().reset();
    }
})

function acciones(value, row, index){
    return `
    <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminar('${row.id}')">
                <i class="glyph-icon icon-trash"></i>
    </button>
    `
}

function eliminar(row){
    Swal.fire({
        title: 'Eliminar',
        text: 'Seguro que quieres eliminar este auto?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if(result.value){
            $.ajax({
                url: base_url + 'eliminar_placa',
                method: 'POST',
                data: {'id': row},
                success: function(data){
                    if(data.status == 'error'){
                        notificar(response.message, 'error');
                    }
                    else{
                        notificar('Placa eliminada correctamente', 'success');
                        tabla.bootstrapTable('refresh');
                    }
                },
                error: function(xhr, status, error){
                    notificar(xhr.responseJSON ? xhr.responseJSON.message : 'Ocurrió un error inesperado', 'error');
                }

            })
        }
    })
}

function registrar(){
    $('#frm_placas').parsley().reset();
    $.ajax({
        url: base_url + 'agregar_placa',
        method: 'POST',
        data: {'placa':document.getElementById('placa').value},
        success: function(data){        
            if(data.status == 'error'){
                notificar(response.message, 'error');
            }
            else{
                tabla.bootstrapTable('refresh');
                $('#frm_placas').parsley().reset();
                $('#placa').val("");
                notificar('Placa registrada correctamente', 'success');
                $('#frm_container').parsley().reset();
            }
        },
        error: function(xhr, status, error){
            notificar(xhr.responseJSON ? xhr.responseJSON.message : 'Ocurrió un error inesperado', 'error');
        }
    })
}

