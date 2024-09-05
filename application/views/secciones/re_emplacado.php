<style>
    #ve_container{
        margin-top: 2vh;
    }

    #frm_container{
        margin-top: 2vh;
    }
</style>
<div class="container m-5 text-center" id="ve_container">
    <h1>
        Agregar emplacado
    </h1>
    
</div>
<div class="container ve_container">
    <div class="row mb-1">
        <button onclick="llamar()" class="btn btn-success justify-content-center m-2 p-2">
            Registrar nuevo emplacado
        </button>
    </div>
    
    <div class="row">
        
        <table id="tableV" data-url="<?= base_url()?>secciones/emplacado/cargar_emplacado">

        </table>
    </div>
</div>

<div class="modal" data-backdrop="static" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFormLabel">Agregar emplacado</h5>
      </div>
      <div class="modal-body">
        <form action="" id="frm_container" method="POST">
            <div class="row pt-4">

                
                <div class="form-group col-md-4">
                    <label for="num_serie">Numero de serie</label>
                    <select class="form-control" id="num_serie" name="num_serie" onchange="datos_num_serie()" required>
                       <!--  <?php
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
                    <label for="placa">Placas</label>
                    <select name="placa" id="placa" class="form-control" required>
                       
                    </select>
                </div>

                <div class="form-group col-md-4">
                            <label for="actual">Actualmente son las placas del vehiculo</label>
                            <select name="actual" id="actual" class="form-control" onchange="habilitar_fecha()" required>
                                <option value="0">No</option>    
                                <option value="1">Si</option>
                            </select>
                </div>
                
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="fecha_i">Fecha de inicio</label>
                    <input type="date" name="fecha_i" id="fecha_i" class="form-control" data-parsley-max-hoy required>
                </div>
                <div class="form-group col-md-6">
                    <label for="fecha_t">Fecha de termino</label>
                    <input type="date" name="fecha_t" id="fecha_t" class="form-control" data-parsley-max-hoy>
                </div>
            </div>

            <div class="row">
                <button type="input" id="btn_duenos" class="btn btn-success">Registrar</button>
            </div>
        </form>
      </div>
      <div class="modal-footer">    
        <button type="button" id="btn_cancel" class="btn btn-danger" data-dismiss="modal" onclick="cancelar_local()">Cancelar</button>

      </div>
    </div>
  </div>
</div>

<script src="../assets/js/modal.js">
    
</script>

<script>
    const habilitar_fecha = () =>{
        let actual = document.getElementById('actual').value;
        console.log('Actuual: ', actual);
        if(actual == 1){
            document.getElementById('fecha_t').setAttribute('disabled', true);
            document.getElementById('fecha_t').value = null;
        }else if(actual == 0){
            document.getElementById('fecha_t').removeAttribute('disabled', false);
        }
    }
</script>

<script>

    let base_url = "<?= base_url()?>secciones/emplacado/";
    let modal_id = "modalForm";
    let tabla = $("#tableV");
    let arreglo_campos = ['num_serie', 'placa', 'actual', 'fecha_i', 'fecha_t'];
    let variable;
    let datosTabla = 0;
    let columns = [
        {
            field: 'num_serie', title: 'Numero de serie'
        },
        {
            field: 'placa', title: 'Placas'
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

    traer_datos(base_url + 'cargar_emplacado', columns, tabla);

    function acciones(value, row, index){
        return `
            <button class="btn btn-round btn-azure" title="Editar" type="button" onclick="rellenar(${row.id})">
                <i class="glyph-icon icon-edit"></i>
            </button>
            <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminar_local(${row.id}, '${base_url}eliminar_emplacado', columns, tabla)">
                <i class="glyph-icon icon-trash"></i>
            </button>
        `;
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
                registrar_local()
                $('#frm_container').parsley().reset();
            }
            
            
    });

    

    function llamar(){
        $('#actual').attr('disabled', false);
        $.ajax({
            url: base_url + 'cargar_placas_sin_asignar',
            method: 'POST',
            success: function(datos){
                json = JSON.parse(datos);
                if(json.length > 0){
                    let opciones = '';
                    opciones = '<option value="" disabled="" selected="" hidden="">Selecciona unas placas..</option>';
                    json.forEach(element => {
                            console.log('placa: ', element.placa);
                            opciones += `<option value="`+element.id+`">`+element.placa+`</option>`
                        });
                    document.getElementById('placa').innerHTML = opciones
                    
                    console.log(opciones);
                }
                
            }
        });

        $.ajax({
            url: base_url + 'cargar_numero_serie',
            method: 'POST',
            success: function(datos){
                json = JSON.parse(datos);
                if(json.length > 0){
                    let opciones = '';
                    opciones = '<option value="" disabled="" selected="" hidden="">Selecciona un numero de serie...</option>';
                    json.forEach(element => {
                            opciones += `<option value="`+element.id+`">`+element.num_serie+`</option>`
                        });
                    document.getElementById('num_serie').innerHTML = opciones
                    
                    console.log(opciones);
                }
                
            }
        });
        
        llamar_modal(modal_id, arreglo_campos);
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

    let anterior_id;

    function rellenar(id){
        $('#actual').attr('disabled', false);
        $.ajax({
            url: base_url + 'consultar_emplacado',
            method: 'POST',
            data: {'id': id},
            success: function(datos){
                datos = JSON.parse(datos);

                let fecha_inicio_completa = datos.fecha_inicio;
                let fecha_inicio =datos.fecha_inicio == null || datos.fecha_inicio == "0000-00-00 00:00:00" || datos.fecha_inicio == "" ?  "" : new Date(datos.fecha_inicio);
                fecha_inicio = fecha_inicio == "" ? "" : fecha_inicio.toISOString().split('T')[0];

                let fecha_termino_completa = datos.fecha_termino;
                console.log("datos.fecha_termino: ", fecha_termino_completa);
                let fecha_termino = datos.fecha_termino == null || datos.fecha_termino == "0000-00-00 00:00:00" || datos.fecha_termino == "" ?  "" : new Date(datos.fecha_termino);
                console.log('Fehca de termino: ', fecha_termino);
                fecha_termino = fecha_termino == "" ? "" : fecha_termino.toISOString().split('T')[0];

                anterior_id = datos.placas_id;
                console.log('placas_id: ', datos.placas_id);
                $.ajax({
                    url: base_url + 'cargar_placas_sin_asignar_excepto',
                    method: 'POST',
                    data: {'id': datos.placas_id},
                    success: function(data){
                        json = JSON.parse(data);
                        if(json.length > 0){
                            let opciones = '';

                            json.forEach(element => {
                                opciones += `<option value="`+element.id+`">`+element.placa+`</option>`
                                //document.getElementById('placa').value = datos.placas_id;
                            });

                            document.getElementById('placa').innerHTML = opciones
                            document.getElementById('placa').value = datos.placas_id;
                            console.log(opciones);
                            
                        }
                        
                    }
                });

                $.ajax({
                    url: base_url + 'cargar_numero_serie',
                    method: 'POST',
                    success: function(data){
                        json = JSON.parse(data);
                        if(json.length > 0){
                            let opciones = '';

                            json.forEach(element => {
                                    opciones += `<option value="`+element.id+`">`+element.num_serie+`</option>`
                                });
                            document.getElementById('num_serie').innerHTML = opciones
                            document.getElementById('num_serie').value = datos.vehiculos_id;
                            
                            console.log(opciones);
                        }
                        
                    }
                });

                llamar_modal(modal_id, arreglo_campos);
                console.log('Datos placas: ', datos.placas_id);
                document.getElementById('modalFormLabel').innerHTML = 'Actualizar Emplacado';
                document.getElementById('btn_duenos').innerHTML = 'Actualizar';
                document.getElementById('num_serie').value = datos.vehiculos_id;
                //document.getElementById('placa').value = datos.placas_id;
                document.getElementById('actual').value = datos.actual; 
                document.getElementById('fecha_i').value = fecha_inicio;
                document.getElementById('fecha_t').value = fecha_termino;
                variable = id;
            }
        })
    }

    function registrar_local(){
        let elemento = document.getElementById('btn_duenos');
        $('#actual').attr('disabled', false);
        datos = {
                'num_serie' : document.getElementById('num_serie').value,
                'placa' : document.getElementById('placa').value,
                'actual' : document.getElementById('actual').value,
                'fecha_i' : document.getElementById('fecha_i').value,
                'fecha_t' : document.getElementById('fecha_t').value,
            }
        if(elemento.innerHTML == 'Registrar'){
            document.getElementById('modalFormLabel').innerHTML = 'Registrar Emplacado';
        }
        else{
            datos.id = variable;
            datos.anterior_id = anterior_id;
        }
        registrar(base_url + 'agregar_emplacado', base_url + 'editar_emplacado', datos, elemento, columns, arreglo_campos, tabla);
    }

    function eliminar_local(row, url, columnas, tabla){
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
                    url:base_url +  'consultar_emplacado',
                    method: 'POST',
                    data: {'id': row},
                    success: function(datos){
                        datos = JSON.parse(datos);
                        console.log("Donde: ", datos)
                            $.ajax({
                                url: url,
                                method: 'POST',
                                data: {'id': row, 'anterior_id' : datos.placas_id,},
                                success: function(data){
                                    data = JSON.parse(data);
                                    console.log('Datos al eliminar: ', data);
                                    if(data.length > 0){
                                        tabla.bootstrapTable('refresh');
                                        return;
                                    }
                                }
                            })
                        
                    }
                });

                
            }
        })
    }

    function cancelar_local(){
        cancelar('btn_duenos', 'btn_cancel', arreglo_campos);
    }

</script>