

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
            console.log('traer datos:',data);
            datosTabla = JSON.parse(data);
            llamar_tabla(tabla, datosTabla, columnas);
        }
    })
}

/* function rellenar(id){
    $.ajax({
        url: 'consultar_propietario',
        method: 'POST',
        data: {'id': id},
        success: function(datos){
            datos = JSON.parse(datos);
            console.log(datos);
            let fecha_inicio = new Date(datos.fecha_inicio);
            fecha_inicio = fecha_inicio.toISOString().split('T')[0];
            let fecha_termino_completa = datos.fecha_termino;
            console.log("datos.fecha_termino: ", fecha_termino_completa);
            let fecha_termino = datos.fecha_termino == null || datos.fecha_termino == "0000-00-00 00:00:00" ?  "" : new Date(datos.fecha_termino);
            console.log('Fehca de termino: ', fecha_termino);
            fecha_termino = fecha_termino != "" ? fecha_termino.toISOString().split('T')[0] : "";

            llamar_modal(id);
            document.getElementById('modalFormLabel').innerHTML = 'Editar propietario';
            document.getElementById('btn_duenos').innerHTML = 'Actualizar';
            document.getElementById('num_serie').value = datos.vehiculos_id;
            document.getElementById('dueno').value = datos.duenos_id;
            document.getElementById('actual').value = datos.actual; 
            document.getElementById('fecha_i').value = fecha_inicio;
            document.getElementById('fecha_t').value = fecha_termino;
            variable = id;
        }
    })
} */

function cancelar(btn1, btn2, elementos){
    btn1.innerHTML = `Cancelar`;
    btn2.innerHTML = 'Registrar';
    limpiar(elementos);
}

function registrar(url_primaria, url_secundaria, data, element, columnas, elementos){
    url = url_primaria;
    if(element.innerHTML == 'Actualizar'){
        url = url_secundaria;
    }
    $.ajax({
        url: url,
        method: 'POST',
        data: data,
        success: function(data){
            datosTabla = JSON.parse(data);
            llamar_tabla(tabla, datosTabla, columnas);
            element.innerHTML = 'Registrar';
            if(element.innerHTML == 'Actualizar'){
                element.innerHTML = 'Registrar';
            }
            limpiar(elementos);
            
        }
    })
}

function eliminar(row, url, columnas){
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
                success: function(data){
                    data = JSON.parse(data);
                    if(data.length > 0){
                        llamar_tabla(tabla, data, columnas);
                        return;
                    }
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

function llamar_tabla(tabla, data, columns){
    tabla.bootstrapTable('destroy');
    tabla.bootstrapTable({
        pagination : true,
        data: data,
        columns: columns
    })
}