function accionC(value, row, index){
    return `
    <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminar(`+row.id+`)">
                <i class="glyph-icon icon-trash"></i>
    </button>
    `;
}

function imprimir(columns)
{
    url = '<?= base_url(); ?>catalogos/colores/cargar_colores';
    $.ajax({
        url: url,
        type: 'POST',
        success: function(data){
            if(data != 0){
                llamar_tabla(data, columns);
            }
        }
    });
};

columnsColor = [{
                field: 'nom_color',
                title: 'Color'
            }, {
                field: 'fecha_registro',
                title: 'Fecha de registro'
            }, {
                field: 'id', title: 'Acciones', formatter: accionC, align: 'center'
            }
];

imprimir(columnsColor);

function agregar(){
    url = "<?= base_url(); ?>catalogos/colores/agregar_colores";
    let data = {
            'color': document.getElementById('color').value
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
    url = "<?= base_url(); ?>catalogos/colores/eliminar_colores";

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


let tabla = $('#tabla_colores');    

function llamar_tabla(datos, columns){
    datos = JSON.parse(datos);
    console.log("Datos: ", datos);
    if(datos.length == 0) {
        tabla.bootstrapTable('destroy');
        return
    }

    tabla.bootstrapTable('destroy');
    tabla.bootstrapTable({
        columns: columns,
        data: datos
    })
}

function mostrar_modal(){
    $('#modalForm').modal('show');
}