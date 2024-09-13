

base_url += "secciones/robos/";
let modal_id = "modalForm";
let tabla = $("#tableV");
let arreglo_campos = ['num_serie', 'inp_placa', 'inp_dueno', 'descripcion', 'fecha_r'];
let variable;
let global;
let datosTabla = 0;
const columns = [
    {field: 'num_serie', title: 'Numero de serie'}, 
    {field: 'placa', title: 'Placas'}, 
    {field: 'nombre',title: 'Dueno nombre'}, 
    {field: 'apellido_p',title: 'Apellido paterno'}, 
    {field: 'descripcion',title: 'Descripcion'}, 
    {field: 'fecha',title: 'Fecha de robo'},
    {field: 'fecha_registro',title: 'Fecha de registro'},
    {field: 'id', title: 'Acciones', formatter: acciones, align: 'center'}
];

$('#frm_container').on('submit', function (e) {
    e.preventDefault();

    if ($('#frm_container').parsley().isValid()) {
        registrar_local();
        $('#frm_container').parsley().reset();
    }
});

$(document).ready(function () {
    $('#frm_container').parsley();
    tabla.bootstrapTable({
        columns: columns,
        pagination: true,
        sidePagination: 'server',
        paginationSize: '10',
        queryParams: function (params) {
            return {
                limit: params.limit,
                offset: params.offset
            }
        }
    });

    window.Parsley.addValidator('maxHoy', {
        validateString: function(value) {
            var hoy = new Date();
            if($('#actual').value = 1){
                var dia = ('0' + hoy.getDate()).slice(-2); // Siempre devuelve dos dígitos, por ejemplo 07 en lugar de 7
            } else {
                var dia = ('0' + (hoy.getDate() - 1)).slice(-2); // Siempre devuelve dos dígitos, por ejemplo 07 en lugar de 7
            }
            
            var mes = ('0' + (hoy.getMonth() + 1)).slice(-2);
            var anio = hoy.getFullYear(); // Devuelve el año actual
            var fechaHoy = anio + '-' + mes + '-' + dia; // Formato de fecha: AAAA-MM-DD

            return value <= fechaHoy; // Si la fecha es menor o igual a la fecha de hoy, es válida
        },
        messages: {
          es: 'La fecha no puede ser posterior a hoy.'
        }
    });
});

function acciones(value, row, index) {
    return `
    <button class="btn btn-round btn-azure" title="Editar" type="button" onclick="rellenar('${row.id}')">
        <i class="glyph-icon icon-edit"></i>
    </button>
    <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminar('${row.id}', '${base_url}eliminar_robo', columns, tabla)">
        <i class="glyph-icon icon-trash"></i>
    </button>
`;
}

function llamar() {
    $.ajax({
        url: base_url + 'cargar_num_serie',
        success: function (data) {
            
            if (data.status == 'success') {
                let opciones;
                opciones = '<option value="" disabled="" selected="" hidden="">Selecciona un numero de serie...</option>';
                data.data.forEach(element => {
                    opciones += '<option value="' + element.id + '">' + element.num_serie + '</option>';
                })
                document.getElementById('num_serie').innerHTML = opciones;
                llamar_modal(modal_id, arreglo_campos);
            }

        },
        error: function (xhr, status) {
            notificar_swal('Error', xhr.responseJSON ? xhr.responseJSON.message : 'Ocurrió un error inesperado', 'error');
        }
    })
    
}

function rellenar(id) {
    $.ajax({
        url: base_url + 'consultar_robo',
        method: 'POST',
        data: { 'id': id },
        success: function (datos) {
            if(datos.status == 'error'){
                return;
            }
            else{
                datos = datos.data;
                console.log("Desc:",datos.descripcion);
                
                let fecha = datos.fecha == null || datos.fecha == "0000-00-00 00:00:00" || datos.fecha == "" ?  "" : new Date(datos.fecha);
                llamar_modal(modal_id, arreglo_campos);
                $.ajax({
                    url: base_url + 'cargar_num_serie',
                    success: function (data) {
                        
                        if (data.status == 'success') {
                            let opciones;
                            opciones = '<option value="" disabled="" selected="" hidden="">Selecciona un numero de serie...</option>';
                            data.data.forEach(element => {
                                opciones += '<option value="' + element.id + '">' + element.num_serie + '</option>';
                            })
                            document.getElementById('num_serie').innerHTML = opciones;
                            document.getElementById('num_serie').value = datos.vehiculos_id;
                            buscar_datos(document.getElementById('num_serie').options[document.getElementById('num_serie').selectedIndex].text);
                        }
            
                    },
                    error: function (xhr, status) {
                        notificar_swal('Error', xhr.responseJSON ? xhr.responseJSON.message : 'Ocurrió un error inesperado', 'error');
                    }
                })
                fecha = fecha == "" ? "" : fecha.toISOString().split('T')[0];
                document.getElementById('modalFormLabel').innerHTML = 'Actualizar robo';
                document.getElementById('btn_duenos').innerHTML = 'Actualizar';
                
                document.getElementById('inp_placa').value = datos.placas_id;
                document.getElementById('inp_dueno').value = datos.duenos_id;
                document.getElementById('descripcion').placeholder = datos.descripcion;
                document.getElementById('fecha_r').value = fecha;
                variable = id;
                
            }
            
        },
        error: function (xhr, status, error) {
            notificar_swal('Error', xhr.responseJSON ? xhr.responseJSON.message : 'Ocurrió un error inesperado', 'error');
        }

    })
}

function buscar_datos(dato = false) {
    var combo = document.getElementById("num_serie");
    var json = {};
    var sel;
    if(!dato){
        sel = combo.options[combo.selectedIndex].text;
        json = {
            'serie': sel
        }
    } else{
        json = {
            'serie': dato
        }
    }
    
    $.ajax({
        url: base_url + 'buscar_datos',
        type: 'POST',
        data: json,
        success: function (data) {
            if (data == 'error') {
                notificar_swal('Error', 'Ocurrio un error inesperado', 'error');
                return;
            }
            console.log('datos crudos:', data);
            var json = data.data;
            global = json;
            console.log('json.parse', json);
            let placa = json.placa;
            let dueno = json.nombre + ' ' + json.apellido_p;
            document.getElementById('inp_placa').value = placa;
            document.getElementById('inp_dueno').value = dueno;
            validador_fecha(json.fecha_inicio);

        },
        error: function (xhr, status, error) {
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

function validador_fecha(fecha){
    window.Parsley.addValidator('menorAInicio', {
        validateString: function(value) {

            var fecha_de_inicio = fecha;
            console.log("Fecha de inicios: ", fecha_de_inicio);
            if(fecha_de_inicio != "" || fecha_de_inicio != null){
                fecha_de_inicio = new Date(fecha);
                var dia = ('0' + fecha_de_inicio.getDate()).slice(-2); // Siempre devuelve dos dígitos, por ejemplo 07 en lugar de 7
                var mes = ('0' + (fecha_de_inicio.getMonth() + 1)).slice(-2);
                var anio = fecha_de_inicio.getFullYear(); // Devuelve el año actual
                var fechaI = anio + '-' + mes + '-' + dia; // Formato de fecha: AAAA-MM-DD
                console.log('Dia: ' + dia + '.......    Mes: ' + mes + '....   anio: ' + anio + '....   Fecha I ' + fechaI + ' Valor: ' + value);
                return value >= fechaI;
            }
        },
        messages: {
          es: 'La fecha de termino no puede ser posterior a la fecha de inicio.'
        }
    });
}

function registrar_local() {
    let elemento = document.getElementById('btn_duenos');
    let datos = [];
    let num_serie = document.getElementById('num_serie').value;
    let placas_id = global.placa_id;
    let duenos_id = global.dueno_id;
    let descripcion = document.getElementById('descripcion').value;
    let fecha = document.getElementById('fecha_r').value;
    if (elemento.innerHTML == 'Registrar') {
        document.getElementById('modalFormLabel').innerHTML = 'Registrar Emplacado';
        datos = {
            'num_serie': num_serie,
            'placas_id': placas_id,
            'duenos_id': duenos_id,
            'descripcion': descripcion,
            'fecha_r': fecha
        }
    }
    else {
        datos = {
            'id': variable,
            'num_serie': num_serie,
            'placas_id': placas_id,
            'duenos_id': duenos_id,
            'descripcion': descripcion,
            'fecha_r': fecha
        }
    }
    registrar(base_url + 'agregar_robo', base_url + 'editar_robo', datos, elemento, arreglo_campos, tabla, modal_id);
}

function cancelar_local() {
    cancelar('btn_duenos', 'btn_cancel', arreglo_campos);
    $('#frm_container').parsley().reset();
}

