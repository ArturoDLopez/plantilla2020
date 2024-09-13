base_url += "secciones/propietarios/";
let arreglo_campos = ['num_serie', 'dueno', 'actual', 'fecha_i', 'fecha_t']
let tabla = $("#tableV");
let modal_id = "modalForm";
let variable;
let datosTabla = 0;

$(document).ready(function(){  
    $('#frm_container').parsley();
    tabla.bootstrapTable();

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

function acciones(value, row, index){
    return `
    <button class="btn btn-round btn-azure" title="Editar" type="button" onclick="rellenar('${row.id}')">
                <i class="glyph-icon icon-edit"></i>
    </button>
    <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminar_local('${row.id}')">
                <i class="glyph-icon icon-trash"></i>
    </button>
    `
}

function queryParams(params) {
    return {
        limit: params.limit,
        offset: params.offset
    };
}

function datos_num_serie(){
    var combo = document.getElementById("num_serie");
    var sel = combo.options[combo.selectedIndex].value;
    console.log("Selecionado: ", sel);
    $.ajax({
        url: base_url + 'datos_num_serie',
        method: 'POST',
        data: {'vehiculos_id': sel},
        success: function(data){
            json = data.data;
            if(json.length > 0){
                $('#actual').val(0);
                $('#actual').attr('disabled', true);
            }else{
                $('#actual').val(1);
                $('#actual').attr('disabled', false);
                $('#fecha_t').attr('disabled', true);
                $('#fecha_t').val("");
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

$('#frm_container').on('submit', function(e){
        e.preventDefault();
        
        if($('#frm_container').parsley().isValid()){
            registrar_local();
            $('#frm_container').parsley().reset();
        }
        
        
});

$("#fecha_i").on('change', function(){

})

function traer_catalogos(vehiculos_id = null, duenos_id = null){
    $.ajax({
        method: "POST",
        url: base_url + "cargar_num_serie",
        success: function(data){
            json = data.data;
            if(json.length > 0){
                let opciones;
                opciones = '<option value="" disabled="" selected="" hidden="">Selecciona un numero de serie...</option>';
                json.forEach(element => {
                    opciones += '<option value="'+element.id+'">'+element.num_serie+'</option>'
                });
                document.getElementById('num_serie').innerHTML = opciones;
                if(vehiculos_id != null){
                    document.getElementById('num_serie').value = vehiculos_id;
                }
            }
        }
    })
    $.ajax({
        method: "POST",
        url: base_url + "cargar_curp",
        success: function(data){
            
            json = data.data;
            
            if(data.status == 'success'){
                let opciones;
                opciones = '<option value="" disabled="" selected="" hidden="">Selecciona una curp...</option>';
                json.forEach(element => {
                    opciones += '<option value="'+element.id+'">'+element.curp+'</option>'
                });
                document.getElementById('dueno').innerHTML = opciones;
                
                if(duenos_id != null){
                    document.getElementById('dueno').value = duenos_id;
                }
            }
            else{
                notificar_swal('Error', 'No se pudo cargar la CURP', 'error');
            }
        },
        error: function(xhr, status, error){
            notificar_swal('Error', xhr.responseJSON ? xhr.responseJSON.message : 'Ocurrió un error inesperado', 'error');
        }
    })
    llamar_modal(modal_id, arreglo_campos);
}

function rellenar(id){
    $.ajax({
        url: base_url + 'consultar_propietario',
        method: 'POST',
        data: {'id': id},
        success: function(datos){
            datos = datos.data;
            console.log("Rellenar: ", datos);
            let fecha_inicio_completa = datos.fecha_inicio;
            let fecha_inicio =datos.fecha_inicio == null || datos.fecha_inicio == "0000-00-00 00:00:00" || datos.fecha_inicio == "" ?  "" : new Date(datos.fecha_inicio);
            fecha_inicio = fecha_inicio == "" ? "" : fecha_inicio.toISOString().split('T')[0];

            let fecha_termino_completa = datos.fecha_termino;
            console.log("datos.fecha_termino: ", fecha_termino_completa);
            let fecha_termino = datos.fecha_termino == null || datos.fecha_termino == "0000-00-00 00:00:00" || datos.fecha_termino == "" ?  "" : new Date(datos.fecha_termino);
            console.log('Fehca de termino: ', fecha_termino);
            fecha_termino = fecha_termino == "" ? "" : fecha_termino.toISOString().split('T')[0];

            
            traer_catalogos(datos.vehiculos_id, datos.duenos_id);
            
            document.getElementById('modalFormLabel').innerHTML = 'Editar propietario';
            document.getElementById('btn_duenos').innerHTML = 'Actualizar';
            document.getElementById('actual').value = datos.actual; 
            document.getElementById('fecha_i').value = fecha_inicio;
            document.getElementById('fecha_t').value = fecha_termino;
            variable = id;
            
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

function cancelar_local(){
    cancelar('btn_duenos', 'btn_cancel', arreglo_campos);
}

function registrar_local(){
    url = base_url + 'agregar_propietario';
    data = {'num_serie':document.getElementById('num_serie').value, 'dueno':document.getElementById('dueno').value, 'actual':document.getElementById('actual').value, 'fecha_i':document.getElementById('fecha_i').value, 'fecha_t':document.getElementById('fecha_t').value}
    if(document.getElementById('btn_duenos').innerHTML == 'Actualizar'){
        url = base_url + 'editar_propietario';
        data.id = variable;
    }
    $.ajax({
        url: url,
        method: 'POST',
        data: data,
        success: function(data){
            console.log(data);
            datosTabla = data.data
            if(data.status == 'error'){
                notificar(data.message, 'error');
                return;
            }
            notificar(data.message, 'success');
            tabla.bootstrapTable('refresh');
            document.getElementById('btn_duenos').innerHTML = 'Registrar';
            if(document.getElementById('btn_duenos').innerHTML == 'Actualizar'){
                document.getElementById('btn_duenos').innerHTML = 'Registrar';
            }
            limpiar_modal(arreglo_campos);
            cerrar_modal(modal_id);
            $('#frm_container').parsley().reset();
        },
        error: function(xhr, status, error){
            notificar_swal('Error', xhr.responseJSON ? xhr.responseJSON.message : 'Ocurrió un error inesperado', 'error');
        }
    })
}

function eliminar_local(row){
    console.log('Row', row);
    Swal.fire({
        title: 'Eliminar',
        text: 'Seguro que quieres eliminar a este propietario?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if(result.value){
            $.ajax({
                url: base_url + 'eliminar_propietario',
                method: 'POST',
                data: {'id': row},
                success: function(data){
                    if(data.status == 'error'){
                        notificar(response.message, 'error');
                    }
                    else{
                        notificar(data.message, 'success');
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
