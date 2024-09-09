base_url = base_url + 'catalogos/marcas/';
let tabla = $('#tabla_marcas');
let tabla2 = $('#ver_uso');
columns = [{
                field: 'nom_marca',
                title: 'marca'
            }, {
                field: 'fecha_registro',
                title: 'Fecha de registro'
            }, {
                field: 'id', title: 'Acciones', formatter: accion, align: 'center'
            }
];
let columnsV = [
    {
        field: 'num_serie', title: 'Numero de serie'
    },
    {
        field: 'modelo', title: 'modelo'
    },
    {
        field: 'fecha_registro', title: 'Fecha de registro'
    },

];


$(document).ready(function(){
    $('#frm_container').parsley();
    tabla.bootstrapTable({
        columns: columns,
        pagination: true,
        sidePagination: 'server',
        pageSize: 10,
        queryParams: function (params){
            return {
                offset: params.offset,
                limit: params.limit
            }
        }

    });
});


$('#frm_container').on('submit', function(e){
    e.preventDefault();
    if($('#frm_container').parsley().isValid()){
        agregar();
        $('#frm_container').parsley().reset();
    }
})

function accion(value, row, index){
    let boton = `
    <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminar(`+row.id+`)">
                <i class="glyph-icon icon-trash"></i>
    </button>
    `;
    if(row.vehiculos_id != null){
        boton = `
        <button class="btn btn-round btn-info" title="La marca esta en uso" type="button" onclick="ver(`+row.id+`)">
                    <i class="glyph-icon icon-eye"></i>
        </button>
        <button class="btn btn-round btn-danger" title="Ver uso" disabled type="button" onclick="eliminar(`+row.id+`)">
                    <i class="glyph-icon icon-trash"></i>
        </button>
    `;
    }

    return boton;
}

function ver(id){
    url = base_url + 'ver_vehiculos_marcas';
    $.ajax({
        url: url,
        type: 'POST',
        data: {'id':id},
        success: function(data){
            json = JSON.parse(data);
            if(json.length >= 0){
                $('#modalMarcas').modal('show');
                tabla2.bootstrapTable('destroy');
                tabla2.bootstrapTable({
                    columns: columnsV,
                    data: json
                });
            }
        }
    });
}

function agregar(){
    url =  base_url + "agregar_marcas";
    let data = {
            'marca': document.getElementById('marca').value
        };
        
        $.ajax({
            type: 'POST',
            data: data,
            url: url,
            success: function (data){
                if (data == 0){
                    Swal.fire({
                        title: 'Error',
                        text: 'El dato que intentas ingresar ya existe',
                        icon: 'warning',
                        confirmButtonText: 'Aceptar'
                    })
                }
                else{
                    Swal.fire({
                        title: 'Agregado correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar',        
                    })
                    tabla.bootstrapTable('refresh');
                }
                console.log('Datos en el success: ', data);
            }
        })
}

function eliminar(id, url){
    url =  base_url + "eliminar_marcas";

    Swal.fire({
        title: 'Eliminar',
        text: 'Seguro que quieres eliminar este elemento?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if(result.value){
            $.ajax({
            url: url,
            method: 'POST',
            data: {'id': id},
            success: function(data){
                if(data != 0){
                    tabla.bootstrapTable('refresh');
                }
            }
        })
        }
    });
}

function mostrar_modal(){
    $('#modalForm').modal('show');
}
