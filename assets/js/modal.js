

function acciones(value, row, index){
    return `
    <button class="btn btn-round btn-azure" title="Editar" type="button" onclick="rellenar(`+row.id+`)">
                <i class="glyph-icon icon-edit"></i>
    </button>
    <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminar(`+row.id+`)">
                <i class="glyph-icon icon-trash"></i>
    </button>
    `
}

function traer_datos(url, columnas, tabla){
    $.ajax({
        url: url,
        method: 'POST',
        success: function(data){
            datosTabla = JSON.parse(data);
            llamar_tabla(tabla, datosTabla, columnas);
        }
    })
}

function cancelar(btn1, btn2, elementos){
    console.log("Cancelar real: ", btn1);
    document.getElementById(btn1).innerHTML = 'Registrar';
    document.getElementById(btn2).innerHTML = 'Cancelar';
    limpiar(elementos);
}

function registrar(url_primaria, url_secundaria, data, element, columnas, elementos, tabla){
    console.log(url_primaria, url_secundaria, data, element, columnas, elementos, tabla);
    url = url_primaria;
    if(element.innerHTML == 'Actualizar'){
        url = url_secundaria;
    }
    $.ajax({
        url: url,
        method: 'POST',
        data: data,
        success: function(data){
            element.innerHTML = 'Registrar';
            if(element.innerHTML == 'Actualizar'){
                element.innerHTML = 'Registrar';
            }
            limpiar(elementos);
            if(data.status == 'error'){
                notificar(data.message, 'error');
            }
            if(data.status == 'success'){
                notificar('Registro exitoso', 'success');
                tabla.bootstrapTable('refresh');
            }
        },
        error: function(xhr, status, error){
            notificar(xhr.responseJSON ? xhr.responseJSON.message : 'Ocurrió un error inesperado', 'error');
        }
    })
}

function eliminar(row, url, columnas, tabla){
    console.log('Row', row);
    Swal.fire({
        title: 'Eliminar',
        text: '¿Seguro que quieres eliminar este registro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if(result.value){
            $.ajax({
                url: url,
                method: 'POST',
                data: {'id': row},
                success: function(response){
                    if(response.status === 'success'){
                        notificar(response.message, 'success');
                        tabla.bootstrapTable('refresh');
                    } else {
                        notificar(response.message, 'error');
                    }
                },
                error: function(xhr, status, error){
                    notificar(xhr.responseJSON ? xhr.responseJSON.message : 'Ocurrió un error inesperado', 'error');
                }
            })
        }
    })
}

function limpiar(elementos){
    elementos.forEach(e => {
        document.getElementById(e).value = "";    
    });
}

function editar_titulo(id, label){
    document.getElementById(id).innerHTML = label;
    llamar_modal(id);
}

function llamar_modal(id, e){
    limpiar(e);
    $("#"+id).modal('show');  
}

function tabla_refresh(tabla){
    tabla.bootstrapTable('refresh');
}   

function llamar_tabla(tabla, data, columns){
    tabla.bootstrapTable('destroy');
    tabla.bootstrapTable({
        data: data,
        columns: columns
    })
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