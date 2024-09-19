
let tabla = $('#tablaB');
let tablaRobos = $("#tablaR");
let modalRobos = $('#modalForm');
let tablaPdf = $('#tablaPdf');
let columns = [
    { field: 'num_serie', title: 'Numero de serie'}, 
    {field: 'nom_marca',title: 'Marca'}, 
    {field: 'modelo',title: 'Modelo'}, 
    {field: 'nom_tipo',title: 'Tipo'}, 
    {field: 'nom_color',title: 'Color'}, 
    {field: 'placa',title: 'Placas actual', formatter: placas}, 
    {field: 'nombre',title: 'Propietario actual', formatter: propietarios},
    {field: 'ro_id', title: 'Reporte de robos', formatter: acciones, align: 'center'}, 
    {field: 'fecha_registro', title: 'Fecha de registro'},
    {field: 'excel', title: 'Acciones', formatter: btn_descargar, align: 'center' }
];

var columnspdf = [
    { field: 'num_serie', title: 'Numero de serie'}, 
    {field: 'nom_marca',title: 'Marca'}, 
    {field: 'modelo',title: 'Modelo'}, 
    {field: 'nom_tipo',title: 'Tipo'}, 
    {field: 'nom_color',title: 'Color'}, 
    {field: 'placa',title: 'Placas actual', formatter: placas}, 
    {field: 'nombre',title: 'Propietario actual', formatter: propietarios}, 
    {field: 'fecha_registro', title: 'Fecha de registro'},
];

let columnsRobos = [
    {field: 'placa', title: 'Placas'}, 
    {field: 'descripcion',title: 'Descripcion'}, 
    {field: 'fecha',title: 'Fecha de robo'},
    {field: 'fecha_registro',title: 'Fecha de registro'},
];

let columnsPro = [
    
    {field: 'nombre', title: 'Propietarios'}, 
    {field: 'fecha_inicio',title: 'Fecha de inicio'}, 
    {field: 'fecha_termino',title: 'Fecha de termino'},
    {field: 'fecha_registro',title: 'Fecha de registro'},
    {field: 'actual',title: 'Actual'},
];

let columnsPla = [
    
    {field: 'placa', title: 'Placas'}, 
    {field: 'fecha_inicio',title: 'Fecha de inicio'}, 
    {field: 'fecha_termino',title: 'Fecha de termino'},
    {field: 'fecha_registro',title: 'Fecha de registro'},
    {field: 'actual',title: 'Actual'},
];

function propietarios(value, row, index){
    var n = parseInt(row.numero_duenos)
    if(n > 1){
        return `
            ${row.nombre}
            <button class="btn btn-round btn-info" title="Ver historico de duenos" onclick="ver_duenos('${row.ve_id}')">
                <i class="glyph-icon icon-info"></i>
            </button>
        `;
    }

    if(n == 1){
        return `${row.nombre}`;
    }

    return 'No tiene dueño asiganado';
}

function placas(value, row, index){
    let n_placas = parseInt(row.numero_placas)
    if(n_placas > 1){
        return `
            ${row.placa}
            <button class="btn btn-round btn-info" title="Ver historico de placas" onclick="ver_placas('${row.ve_id}')">
                <i class="glyph-icon icon-info"></i>
            </button>
        `;
    }

    if(n_placas == 1){
        return `${row.placa}`;
    }

    return 'No tiene placas asignados';
}

function btn_descargar(value, row, index){
    return `
    <button class="btn btn-round btn-blue-alt" title="Descargar informacion del vehiculo en exel" onclick="descargar('${row.num_serie}', '${row.ve_id}')">
        <i class="glyph-icon icon-file-excel-o"></i>
    </button>
    <button class="btn btn-round btn-blue-alt" title="Descargar informacion del vehiculo en pdf" onclick="printPDF('${row.num_serie}', '${row.ve_id}')">
        <i class="glyph-icon icon-file-pdf-o"></i>
    </button>
`;
}

var descargar = async (num_serie, vehiculo_id) => {
    var formData = new FormData();
    formData.append('num_serie', num_serie);
    formData.append('vehiculo_id', vehiculo_id);

    console.log(formData);

    let response = await fetch('exportar_excel', {
        method: 'POST',
        mode: 'no-cors',
        body: formData,
        headers: { 'Content-Type': 'application/json' }
    });
    if (response.status === 200) {
        let data = await response;
        console.log(data);
 
        let blob = await data.blob();
        let objectUrl = URL.createObjectURL(blob);
        let a = document.createElement('a');
 
        a.href = objectUrl;
        a.download = 'Reporte_control_patrimonial_licencias.xlsx';
        a.click();
        swal.close();
    }
}


var printPDF = async (num_serie, vehiculo_id) => {

    var datosTabla = tablaPdf.html();
    var formData = new FormData();
    formData.append('num_serie', num_serie);
    formData.append('vehiculo_id', vehiculo_id);
    formData.append('tablaVehiculo', datosTabla);

    console.log(formData);

    let response = await fetch('printPDF', {
        method: 'POST',
        mode: 'no-cors',
        body: formData,
        headers: { 'Content-Type': 'application/json' }
    });
    if (response.status === 200) {
        let data = await response;
        console.log(data);
 
        let blob = await data.blob();
        let objectUrl = URL.createObjectURL(blob);
        let a = document.createElement('a');
 
        a.href = objectUrl;
        a.download = 'Reporte del vehiculo '+num_serie+'.pdf';
        a.click();
        swal.close();
    }
}
/* function descargar(){
    console.log('Descargar');
    $.ajax({
        method: 'POST',
        url: 'exportar_excel',
        success: function(data){
            console.log(data)
            let blob = data.blob();
            let objectUrl = URL.createObjectURL(blob);
            let a = document.createElement('a');
    
            a.href = objectUrl;
            a.download = 'Reporte_control_patrimonial_licencias.xlsx';
            a.click();
        }
        
    });
    
} */

function acciones(value, row, index){
    if(row.ro_id != null){
        return `
            <button class="btn btn-round btn-info" title="Ver detalle de robos" onclick="ver_robos('${row.ve_id}')">
                <i class="glyph-icon icon-info"></i>
            </button>
        `;
    }
    return 'No se encontraros reportes de robo';
    
}

function ver_robos(id){
    
    $.ajax({
        url: 'traer_robos',
        data: {'ve_id':id},
        method: 'POST',
        success: function(data){
            console.log(data);
            if(data != null){
                $('#modalForm').modal('show');
                tablaRobos.bootstrapTable('destroy');
                tablaRobos.bootstrapTable({
                    columns: columnsRobos,
                    data: data
                });
            }
        },
        error: function(rhx){
            Swal.fire({
                text: rhx.responseJSON.msj,
                icon: 'error',
                title: 'Error al buscar robos',
                confirmButtonText: 'Aceptar'
            })
        }
    })

    console.log("Hay que buscar robos");
}

function ver_duenos(id){
    
    $.ajax({
        url: 'traer_duenos',
        data: {'ve_id':id},
        method: 'POST',
        success: function(data){
            console.log(data);
            if(data != null){
                $('#modalForm').modal('show');
                tablaRobos.bootstrapTable('destroy');
                tablaRobos.bootstrapTable({
                    columns: columnsPro,
                    data: data
                });
            }
        },
        error: function(rhx){
            Swal.fire({
                text: rhx.responseJSON.msj,
                icon: 'error',
                title: 'Error al buscar robos',
                confirmButtonText: 'Aceptar'
            })
        }
    })

    console.log("Hay que buscar robos");
}

function ver_placas(id){
    
    $.ajax({
        url: 'traer_placas',
        data: {'ve_id':id},
        method: 'POST',
        success: function(data){
            console.log(data);
            if(data != null){
                $('#modalForm').modal('show');
                tablaRobos.bootstrapTable('destroy');
                tablaRobos.bootstrapTable({
                    columns: columnsPla,
                    data: data
                });
            }
        },
        error: function(rhx){
            Swal.fire({
                text: rhx.responseJSON.msj,
                icon: 'error',
                title: 'Error al buscar robos',
                confirmButtonText: 'Aceptar'
            })
        }
    })

    console.log("Hay que buscar robos");
}

function buscar(){
    let value = document.getElementById('inp_placa').value;

    let json = {
        'placa': value
    }

    $.ajax({
        url: 'buscar_vehiculo_ajax',
        type: 'POST',
        data: json,
        success: function(data){
            let json = JSON.parse(data);
            tablaPdf.bootstrapTable({
                columns: columnspdf,
                data: json
            })
            llamar_tabla(json, value);
        },
        error: function (xhr){
            Swal.fire({
                title: 'Error',
                text: xhr.responseJSON ? xhr.responseJSON.msj : 'Ocurrió un error inesperado',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    })
}

function llamar_tabla(datos, p){
    if(datos.length == 0) {
        Swal.fire({
            title: 'Datos no encontrados',
            text: 'La placa "' + p + '" no ha sido registrada en el sistema o no tiene vehiculos asignados',
            icon: 'warning',
            confirmButtonText: 'Aceptar'
        })
        tabla.bootstrapTable('destroy');
        document.getElementById('ve_h1').innerHTML = "";
        return
    }

    console.log('llamar tabla', datos);
    tabla.bootstrapTable({
        columns: columns,
        data: datos
    })
    document.getElementById('ve_h1').innerHTML = "Vehiculo encontrado";
   //si esta inicializada
    if (tabla.bootstrapTable('getData').length === 0) {
        tabla.bootstrapTable({
            columns: columns,
            data: datos
        });
    } else {
        // actualiza los datos solo si esta inicializada
        tabla.bootstrapTable('load', datos);
    }
}
