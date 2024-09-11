

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
    document.getElementById(btn1).innerHTML = 'Registrar';
    document.getElementById(btn2).innerHTML = 'Cancelar';
    limpiar(elementos);
}

function registrar(url_primaria, url_secundaria, data, element, elementos, tabla, modal_id){
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
            
            if(data.status == 'error'){
                notificar(data.message, 'error');
            }
            if(data.status == 'success'){
                notificar(data.message, 'success');
                tabla.bootstrapTable('refresh');
                limpiar(elementos);
                cerrar_modal(modal_id);
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

