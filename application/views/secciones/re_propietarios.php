<div class="container">
    <div class="container text-center" id="ve_container">
        <h1>
            Propietarios
        </h1>
    </div>

    <button onclick="traer_catalogos()" class="btn btn-success" style="margin-bottom: 1vh">
        Agregar propietarios
    </button>

    <div class="container ve_container">
        <table id="tableV" data-url="<?= base_url()?>secciones/Propietarios/cargar_propietarios">

        </table>
    </div>

</div>

<div class="modal" data-backdrop="static" id="modalForm">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #1C314F;">
				<h4 class="modal-title" style="color: white;"  id="modalFormLabel">Agregar propietarios</h4>
			</div>
			<div class="modal-body" id="cb-datos-registro">
                <form action="<?php base_url();?>agregar_propietarios" id="frm_container" method="POST" data-parsley-validate="">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="num_serie"><span class="text-danger">*</span>Numero de serie</label>
                            <select class="form-control" id="num_serie" name="num_serie" onchange="datos_num_serie()" required>

                                <!-- <option value="0">
                                    Seleccione una opcion...
                                </option>
                                <?php
                                    foreach($vehiculos['vehiculos'] as $vehiculo){
                                        echo 
                                        '
                                            <option value="'.$vehiculo->id.'">
                                                '.$vehiculo->num_serie.'
                                            </option>
                                        ';
                                    }
                                ?> -->
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="dueno"><span class="text-danger">*</span>Dueño</label>
                            <select name="dueno" id="dueno" class="form-control" required>

                                <!-- <option value="0"><span class="text-danger">*</span>Seleccione un dueño</option>
                                <?php
                                    foreach($duenos['duenos'] as $du){
                                        echo '
                                            <option value="'.$du->id.'">'.$du->nombre.' '.$du->apellido_p.' '.$du->apellido_m.'</option>
                                        ';
                                    }
                                ?> -->
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                                    <label for="actual"><span class="text-danger">*</span>Actualmente es el dueño</label>
                                    <select name="actual" id="actual" class="form-control" onchange="habilitar_fecha()" required>
                                        <option value="0">No</option>    
                                        <option value="1">Si</option>
                                    </select>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="fecha_i"><span class="text-danger">*</span>Fecha de inicio</label>
                            <input type="date" name="fecha_i" id="fecha_i" class="form-control" data-parsley-max-hoy required>
                        </div>
                        <div class="form-group col-md-6">
                            <label id="fecha_t_l" for="fecha_t">Fecha de termino</label>
                            <input type="date" name="fecha_t" id="fecha_t" class="form-control" data-parsley-max-hoy>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <button type="submit" id="btn_duenos" class="btn btn-success" ><i class=" glyph-icon icon-save"></i> Registrar</button>
                        </div>
                    </div>
                </form>
			</div>
			<div class="modal-footer">
                
				<button id="btn_cancel" data-dismiss="modal" class="btn btn-danger" onclick ="cancelar()"><i class=" glyph-icon icon-times"></i> Cancelar</button>
			</div>
		</div>
	</div>
</div>

<div class="container text-center" id="ve_container">
    
</div>


<script> 
    let base_url = "<?= base_url()?>secciones/propietarios/";
    let tabla = $("#tableV");
    let variable;
    let datosTabla = 0;
    let columns = [
        {
            field: 'num_serie', title: 'Numero de serie'
        },
        {
            field: 'nombre', title: 'Nombre'
        },
        {
            field: 'apellido_p', title: 'Apellido paterno'
        },
        {
            field: 'apellido_m', title: 'Apellido materno'
        },
        {
            field: 'actual', title: 'Actual'
        },
        {
            field: 'fecha_inicio', title: 'Fecha de inicio'
        },
        {
            field: 'fecha_termino', title: 'Fecha de finalizacion'
        },
        {
            field: 'fecha_registro', title: 'Fecha de registro'
        },
        {
            field: 'id', title: 'Acciones', formatter: acciones, align: 'center'
        }

    ];
    traer_datos();

    function acciones(value, row, index){
        return `
        <button class="btn btn-round btn-azure" title="Editar" type="button" onclick="rellenar(`+row.id+`)">
                    <i class="glyph-icon icon-edit"></i>
        </button>
        <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminar(`+value+','+row.id+`)">
                    <i class="glyph-icon icon-trash"></i>
        </button>
        `
    }

    function traer_datos(){
        $.ajax({
            url: base_url + 'cargar_propietarios',
            method: 'POST',
            success: function(data){
                console.log(data);
                datosTabla = JSON.parse(data);
                llamar_tabla(datosTabla);
            }
        })
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
                console.log(data);
                json = JSON.parse(data);
                if(json.length > 0){
                    $('#actual').val(0);
                    $('#actual').attr('disabled', true);
                }else{
                    $('#actual').val(1);
                    $('#actual').attr('disabled', false);
                    $('#fecha_t').attr('disabled', true);
                }
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
        } else {
            fechaInicio.disabled = false;
            fechaTermino.disabled = false;
            fechaTermino.required = true;
            fechaLabelTermino.innerHTML = "<span class='text-danger'>*</span>Fecha de termino";
            // Desactivar la validación si no es dueño actual
            $('#fecha_i').parsley().reset();
        }
    }

    $(document).ready(function(){  
        $('#frm_container').parsley();

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
                  es: 'La fecha de inicio no puede ser posterior a hoy.'
                }
            });
        } 
        else {
            console.log("Parsley.js no está cargado.");
        }
    });

$('#frm_container').on('submit', function(e){
            e.preventDefault();
            
            if($('#frm_container').parsley().isValid()){
                registrar();
                $('#frm_container').parsley().reset();
            }
            
            
    });

    function traer_catalogos(vehiculos_id = null, duenos_id = null){
        $.ajax({
            method: "POST",
            url: base_url + "cargar_num_serie",
            success: function(data){
                json = JSON.parse(data);
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
                json = JSON.parse(data);
                if(json.length > 0){
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
            }
        })
        llamar_modal();
    }

    function rellenar(id){
        $.ajax({
            url: base_url + 'consultar_propietario',
            method: 'POST',
            data: {'id': id},
            success: function(datos){
                datos = JSON.parse(datos);
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
                
            }
        })
    }

    function cancelar(){
        document.getElementById('btn_cancel').innerHTML = `Cancelar`;
        document.getElementById('btn_duenos').innerHTML = 'Registrar';
        limpiar();
    }
    
    function registrar(){
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
                datosTabla = JSON.parse(data);
                tabla.bootstrapTable('refresh');
                document.getElementById('btn_duenos').innerHTML = 'Registrar';
                if(document.getElementById('btn_duenos').innerHTML == 'Actualizar'){
                    document.getElementById('btn_duenos').innerHTML = 'Registrar';
                }
                limpiar();
                
            }
        })
    }

    function eliminar(value, row){
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
                        data = JSON.parse(data);
                        if(data > 0){
                            tabla.bootstrapTable('refresh');
                            return;
                        }
                    }
                })
            }
        })
    }

    function limpiar(){
        document.getElementById('num_serie').value = "";
        document.getElementById('dueno').value = "";
        document.getElementById('actual').value = ""; 
        document.getElementById('fecha_i').value ="";
        document.getElementById('fecha_t').value = "";
    }

    function editar_titulo(){
        document.getElementById('modalFormLabel').innerHTML = 'Registrar vehiculos';
        llamar_modal();
    }

    function llamar_modal(){
        
        limpiar();
        $("#modalForm").modal('show');  
    }

    function llamar_tabla(data){
        tabla.bootstrapTable('destroy');
        tabla.bootstrapTable({
            pagination : true,
            data: data,
            columns: columns
        })
    }

</script>