base_url += "secciones/emplacado/";
let elemento = document.getElementById('btn_duenos');
let modal_id = "modalForm";
let tabla = $("#tableV");
let arreglo_campos = ['num_serie', 'placa', 'actual', 'fecha_i', 'fecha_t'];
let variable;
let datosTabla = 0;
let columns = [
    { field: 'num_serie', title: 'Numero de serie' },
    { field: 'placa', title: 'Placas' },
    { field: 'actual', title: 'Actual' },
    { field: 'fecha_inicio', title: 'Fecha de inicio' },
    { field: 'fecha_termino', title: 'Fecha de finalizacion' },
    { field: 'fecha_registro', title: 'Fecha de registro' },
    { field: 'id', title: 'Acciones', formatter: acciones, align: 'center' }
];

$(document).ready(function(){
    $('#frm_container').parsley();
    tabla.bootstrapTable({
        columns: columns,
        pagination: true,
        sidePagination: 'server',
        paginationSize: 10,
        queryParams: queryParams
    });
    if (window.Parsley) {
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

        window.Parsley.addValidator('menorAInicio', {
            validateString: function(value) {

                var fecha_de_inicio = document.getElementById('fecha_i').value;
                console.log("Fecha de inicios: ", fecha_de_inicio);
                if(fecha_de_inicio != "" || fecha_de_inicio != null){
                    fecha_de_inicio = new Date(document.getElementById('fecha_i').value);
                    var dia = ('0' + fecha_de_inicio.getDate()).slice(-2); // Siempre devuelve dos dígitos, por ejemplo 07 en lugar de 7
                    var mes = ('0' + (fecha_de_inicio.getMonth() + 1)).slice(-2);
                    var anio = fecha_de_inicio.getFullYear(); // Devuelve el año actual
                    var fechaI = anio + '-' + mes + '-' + dia; // Formato de fecha: AAAA-MM-DD
                    console.log('Dia: ' + dia + '.......    Mes: ' + mes + '....   anio: ' + anio + '....   Fecha I ' + fechaI);
                    return value >= fechaI;
                }
            },
            messages: {
              es: 'La fecha de termino no puede ser posterior a la fecha de inicio.'
            }
        });
    } 
    else {
        console.log("Parsley.js no está cargado.");
    }
});

$('#frm_container').on('submit', function(e){
    e.preventDefault();
    if ($('#frm_container').parsley().isValid()) {
        registrar_local();
        $('#frm_container').parsley().reset();
    }
});

function queryParams(params) {
    return {
        limit: params.limit,
        offset: params.offset
    };
}

function acciones(value, row, index) {
    return `
        <button class="btn btn-round btn-azure" title="Editar" type="button" onclick="rellenar('${row.id}')">
            <i class="glyph-icon icon-edit"></i>
        </button>
        <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminar('${row.id}')">
            <i class="glyph-icon icon-trash"></i>
        </button>
    `;
}

function llamar() {
    $('#actual').attr('disabled', false);
    cargarOpciones('cargar_placas_sin_asignar', 'placa');
    cargarOpciones('cargar_numero_serie', 'num_serie');
    llamar_modal(modal_id, arreglo_campos);
    
}

function cargarOpciones(url, elementoId) {
    $.ajax({
        url: base_url + url,
        method: 'POST',
        success: function(datos) {
            let opciones = '<option value="" disabled="" selected="" hidden="">Selecciona una opción...</option>';
            let json = datos.data;
            json.forEach(element => {
                opciones += `<option value="${element.id}">${element.placa || element.num_serie}</option>`;
            });
            document.getElementById(elementoId).innerHTML = opciones;
        }
    });
}

function datos_num_serie() {
    let sel = document.getElementById("num_serie").value;
    $.ajax({
        url: base_url + 'datos_num_serie',
        method: 'POST',
        data: { 'vehiculos_id': sel },
        success: function(data) {
            
            let json = data.data;
            console.log(json);
            if (json.length > 0) {
                let actual;
                json.forEach(element => {
                    if(element.actual == 1){
                        actual = true;
                    }
                });
                if(actual){
                    $('#actual').val(0).attr('disabled', true);
                    $('#fecha_t').attr('disabled', false);
                }
                
            } else {
                $('#actual').val(1).attr('disabled', false);
                $('#fecha_t').attr('disabled', true);
                $('#fecha_t').val("");
            }
        }
    });
}

function habilitar_fecha() {
    var actual = document.getElementById("actual").value;
    var fechaInicio = document.getElementById("fecha_i");
    var fechaTermino = document.getElementById("fecha_t");
    var fechaLabelTermino = document.getElementById("fecha_t_l");

    if (actual == "1") {
        fechaInicio.disabled = false;
        fechaTermino.disabled = true;
        fechaTermino.required = false;
        fechaLabelTermino.innerHTML = "Fecha de termino";
        $('#fecha_i').parsley().validate();
        $('#fecha_t').val("");
    } else {
        fechaInicio.disabled = false;
        fechaTermino.disabled = false;
        fechaTermino.required = true;
        fechaLabelTermino.innerHTML = "<span class='text-danger'>*</span>Fecha de termino";
        // Desactivar la validación si no es dueño actual
        $('#fecha_i').parsley().reset();
    }
}


function rellenar(id){
    $('#actual').attr('disabled', false);
    $.ajax({
        url: base_url + 'consultar_emplacado',
        method: 'POST',
        data: {'id': id},
        success: function(datos){
            datos = datos.data;
            let fecha_inicio = datos.fecha_inicio && datos.fecha_inicio !== "0000-00-00 00:00:00" ? new Date(datos.fecha_inicio).toISOString().split('T')[0] : "";
            let fecha_termino = datos.fecha_termino && datos.fecha_termino !== "0000-00-00 00:00:00" ? new Date(datos.fecha_termino).toISOString().split('T')[0] : "";

            anterior_id = datos.placas_id;

            $.ajax({
                url: base_url + 'cargar_placas_sin_asignar_excepto',
                method: 'POST',
                data: {'id': datos.placas_id},
                success: function(data){
                    json = data.data;
                    if(json.length > 0){
                        let opciones = json.map(element => `<option value="${element.id}">${element.placa}</option>`).join('');
                        document.getElementById('placa').innerHTML = opciones;
                        document.getElementById('placa').value = datos.placas_id;
                    }
                }
            });

            $.ajax({
                url: base_url + 'cargar_numero_serie',
                method: 'POST',
                success: function(data){
                    json = data.data;
                    if(json.length > 0){
                        let opciones = json.map(element => `<option value="${element.id}">${element.num_serie}</option>`).join('');
                        document.getElementById('num_serie').innerHTML = opciones;
                        document.getElementById('num_serie').value = datos.vehiculos_id;
                    }
                }
            });

            llamar_modal(modal_id, arreglo_campos);
            document.getElementById('modalFormLabel').innerHTML = 'Actualizar Emplacado';
            document.getElementById('btn_duenos').innerHTML = 'Actualizar';
            document.getElementById('num_serie').value = datos.vehiculos_id;
            document.getElementById('actual').value = datos.actual; 
            document.getElementById('fecha_i').value = fecha_inicio;
            document.getElementById('fecha_t').value = fecha_termino;
            variable = id;
        },
        error: function(xhr, status, error){
            notificar_swal('Error', xhr.responseJSON ? xhr.responseJSON.message : 'Ocurrió un error inesperado', 'error');
        }
    });
}


function registrar_local() {
    $('#frm_container').parsley().reset();
    let datos = {
        'num_serie': $('#num_serie').val(),
        'placa': $('#placa').val(),
        'actual': $('#actual').val(),
        'fecha_i': $('#fecha_i').val(),
        'fecha_t': $('#fecha_t').val()
    };
    let url = elemento.innerHTML === 'Registrar' ? base_url + 'agregar_emplacado' : base_url + 'editar_emplacado';
    if (elemento.innerHTML !== 'Registrar') {
        datos.id = variable;
        datos.anterior_id = anterior_id;
    }
    registrar(url, base_url + 'editar_emplacado', datos, elemento, arreglo_campos, tabla);
}

function eliminar(row) {
    Swal.fire({
        title: 'Eliminar',
        text: '¿Seguro que quieres eliminar este registro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: base_url + 'consultar_emplacado',
                method: 'POST',
                data: { 'id': row },
                success: function(datos) {
                    let data = datos.data;
                    $.ajax({
                        url: base_url + 'eliminar_emplacado',
                        method: 'POST',
                        data: { 'id': row, 'anterior_id': data.placas_id },
                        success: function(response) {
                            if (response.status === 'success') {
                                notificar(response.message, 'success');
                                tabla.bootstrapTable('refresh');
                            } else {
                                notificar(response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            notificar(xhr.responseJSON ? xhr.responseJSON.message : 'Ocurrió un error inesperado', 'error');
                        }
                    });
                }
            });
        }
    });
}

function cancelar_local() {
    $('#frm_container').parsley().reset();
    cancelar('btn_duenos', 'btn_cancel', arreglo_campos);
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

function registrar(url_primaria, url_secundaria, data, element, elementos, tabla) {
    url = element.innerHTML === 'Actualizar' ? url_secundaria : url_primaria;
    $.ajax({
        url: url,
        method: 'POST',
        data: data,
        success: function(data) {
            element.innerHTML = 'Registrar';
            if (data.status === 'success') {
                notificar('Registro exitoso', 'success');
                tabla.bootstrapTable('refresh');
                cerrar_modal(modal_id);
                limpiar_modal(elementos);
            } else {
                notificar(data.message, 'error');
            }
        },
        error: function(xhr) {
            notificar(xhr.responseJSON ? xhr.responseJSON.message : 'Ocurrió un error inesperado', 'error');
        }
    });
}

function cancelar(btn1, btn2, elementos) {
    document.getElementById(btn1).innerHTML = 'Registrar';
    document.getElementById(btn2).innerHTML = 'Cancelar';
    limpiar_modal(elementos);
}
