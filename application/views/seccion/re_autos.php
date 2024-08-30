
<div class="container">
    <div class="container m-5 text-center" id="ve_container">
        <h1>
            Vehiculos
        </h1>
    </div>

    <div class="container ve_container ">
        <div class="row mb-1">
            <button onclick="llamar()" class="btn btn-success justify-content-center m-2 p-2">
                Registrar nuevo vehiculo
            </button>
        </div>
        
        <div class="row">
            
            <table id="tableV">

            </table>
        </div>
    </div>
</div>

<div class="modal" data-backdrop="static" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFormLabel">Agregar vehiculos</h5>
      </div>
      <div class="modal-body">
        <form action="" id="frm_container" method="POST">
            <div class="row pt-4">

                <div class="form-group col-md-4">
                    <label for="num_serie">Numero de serie</label>
                    <input type="text" class="form-control" id="num_serie" name="num_serie">
                </div>
                
                <div class="form-group col-md-4">
                    <label for="marca">Marca</label>
                    <select class="form-control" id="marca" name="marca">
                        <option value="0">
                            Seleccione una opcion...
                        </option>
                        <?php
                            foreach($marcas['marcas'] as $marca){
                                echo 
                                '
                                    <option value="'.$marca->id.'">
                                        '.$marca->nom_marca.'
                                    </option>
                                ';
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="modelo">Modelo</label>
                    <input type="text" class="form-control" id="modelo" name="modelo">
                </div>
                
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="color">Color</label>
                    <select class="form-control" name="color" id="color">
                        <option value="0">Selecciona una opcion</option>
                        <?php
                            foreach($colores['colores'] as $color):
                        ?>
                            <option value="<?php echo $color->id; ?>">
                                <?php echo $color->nom_color; ?>
                            </option>
                        <?php 
                            endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="marca">Tipo</label>
                    <select class="form-control" id="tipo" name="tipo">
                        <option value="0">
                            Seleccione una opcion...
                        </option>
                        <?php
                            foreach($tipos['tipos'] as $tipo){
                                echo 
                                '
                                    <option value="'.$tipo->id.'">
                                        '.$tipo->nom_tipo.'
                                    </option>
                                ';
                            }
                        ?>
                    </select>
                </div>
            </div>
            

        </form>
      </div>
      <div class="modal-footer">
        <div class="col-md-1">
            <button type="button" id="btn_duenos" onclick="registrar()" class="btn btn-success" data-dismiss="modal">Registrar</button>
        </div>
                        
        <button type="button" id="btn_cancel" class="btn btn-danger" data-dismiss="modal" onclick="cancelar_local()">Cerrar</button>

      </div>
    </div>
  </div>
</div>

<script src="../assets/js/modal.js">
    
</script>

<script>

    let modal_id = "modalForm";
    let tabla = $("#tableV");
    let arreglo_campos = ['num_serie', 'marca', 'modelo', 'color', 'tipo'];
    let variable;
    let datosTabla = 0;
    let columns = [
        {
            field: 'num_serie', title: 'Numero de serie'
        },
        {
            field: 'nom_marca', title: 'Marca'
        },
        {
            field: 'modelo', title: 'modelo'
        },
        {
            field: 'nom_tipo', title: 'Tipo'
        },
        {
            field: 'nom_color', title: 'Color'
        },
        {
            field: 'fecha_registro', title: 'Fecha de registro'
        },
        {
            field: 'id', title: 'Acciones', formatter: acciones, align: 'center'
        }

    ];
    
    traer_datos('cargar_autos', columns, tabla);

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

    function llamar(){
        llamar_modal(modal_id, arreglo_campos);
    }

    function rellenar(id){
        $.ajax({
            url: 'consultar_auto',
            method: 'POST',
            data: {'id': id},
            success: function(datos){
                datos = JSON.parse(datos);
                console.log(datos);
                llamar_modal(modal_id, arreglo_campos);
                document.getElementById('modalFormLabel').innerHTML = 'Actualizar vehiculos';
                document.getElementById('btn_duenos').innerHTML = 'Actualizar';
                document.getElementById('num_serie').value = datos.num_serie;
                document.getElementById('marca').value = datos.marcas_id;
                document.getElementById('modelo').value = datos.modelo; 
                document.getElementById('color').value = datos.colores_id;
                document.getElementById('tipo').value = datos.tipo_id;
                variable = id;
            }
        })
    }

    function cancelar_local(){
        cancelar('btn_duenos', 'btn_cancel', elementos);
    }

/*     function traer_datos(){
        $.ajax({
            url: 'cargar_autos',
            method: 'POST',
            success: function(data){
                console.log(data);
                datosTabla = JSON.parse(data);
                llamar_tabla(datosTabla);
            }
        })
    } */

    /* function rellenar(id){
        $.ajax({
            url: 'consultar_auto',
            method: 'POST',
            data: {'id': id},
            success: function(datos){
                datos = JSON.parse(datos);
                console.log(datos);
                llamar_modal();
                document.getElementById('modalFormLabel').innerHTML = 'Actualizar vehiculos';
                document.getElementById('btn_duenos').innerHTML = 'Actualizar';
                document.getElementById('num_serie').value = datos.num_serie;
                document.getElementById('marca').value = datos.marcas_id;
                document.getElementById('modelo').value = datos.modelo; 
                document.getElementById('color').value = datos.colores_id;
                document.getElementById('tipo').value = datos.tipo_id;
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
        url = 'agregar_vehiculos'
        datos = {
            'num_serie' : document.getElementById('num_serie').value,
            'marca' : document.getElementById('marca').value,
            'modelo' : document.getElementById('modelo').value,
            'color' : document.getElementById('color').value,
            'tipo' : document.getElementById('tipo').value,
        }
        if(document.getElementById('btn_duenos').innerHTML == 'Actualizar'){
            url = 'editar_auto';
            datos = {
                'id': variable,
                'num_serie' : document.getElementById('num_serie').value,
                'marca' : document.getElementById('marca').value,
                'modelo' : document.getElementById('modelo').value,
                'color' : document.getElementById('color').value,
                'tipo' : document.getElementById('tipo').value,
            }
        }

        $.ajax({
            url: url,
            method: 'POST',
            data: datos,
            success: function(data){
                console.log('La data: ', data);
                if(data == 0){
                    Swal.fire({
                            title: 'Error',
                            text: 'El dato que intentas ingresar ya existe',
                            icon: 'warning',
                            confirmButtonText: 'Aceptar'
                        })
                }
                else{
                    console.log(data);
                    datosTabla = JSON.parse(data);
                    llamar_tabla(datosTabla);
                    document.getElementById('btn_duenos').innerHTML = 'Registrar';
                    if(document.getElementById('btn_duenos').innerHTML == 'Actualizar'){
                        document.getElementById('btn_duenos').innerHTML = 'Registrar';
                    }
                    limpiar();
                }
            }
        })
    }

    function eliminar(value, row){
        console.log('Row', row);
        Swal.fire({
            title: 'Eliminar',
            text: 'Seguro que quieres eliminar este auto?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if(result.value){
                $.ajax({
                    url: 'eliminar_auto',
                    method: 'POST',
                    data: {'id': row},
                    success: function(data){
                        console.log('success: ', data)
                        console.log('datos tabla length: ',datosTabla.length);
                        if(data > 0){
                            for(var i = 0; i<datosTabla.length; i++){
                                console.log('datos: ', datosTabla[i]);
                                if(datosTabla[i].id == row){
                                    datosTabla.splice(i, 1);
                                }
                            }
                            tabla.bootstrapTable('removeAll');
                            tabla.bootstrapTable('append', datosTabla);
                            return;
                        }
                    }

                })
            }
        })
    } */

    /* function limpiar(){
        document.getElementById('num_serie').value = "";
        document.getElementById('marca').value = "";
        document.getElementById('modelo').value = "";
        document.getElementById('color').value = "";
        document.getElementById('tipo').value = "";
    } */
/* 
    function editar_titulo(){
        document.getElementById('modalFormLabel').innerHTML = 'Registrar vehiculos';
        llamar_modal();
    }
 */
    
    

</script>

<!-- 
<script>

    let tabla = $("#tableV");
    let variable;
    let datosTabla = 0;
    let columns = [
        {
            field: 'num_serie', title: 'Numero de serie'
        },
        {
            field: 'nom_marca', title: 'Marca'
        },
        {
            field: 'modelo', title: 'modelo'
        },
        {
            field: 'nom_tipo', title: 'Tipo'
        },
        {
            field: 'nom_color', title: 'Color'
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
            url: 'cargar_autos',
            method: 'POST',
            success: function(data){
                console.log(data);
                datosTabla = JSON.parse(data);
                llamar_tabla(datosTabla);
            }
        })
    }

    function rellenar(id){
        $.ajax({
            url: 'consultar_auto',
            method: 'POST',
            data: {'id': id},
            success: function(datos){
                datos = JSON.parse(datos);
                console.log(datos);
                llamar_modal();
                document.getElementById('modalFormLabel').innerHTML = 'Actualizar vehiculos';
                document.getElementById('btn_duenos').innerHTML = 'Actualizar';
                document.getElementById('num_serie').value = datos.num_serie;
                document.getElementById('marca').value = datos.marcas_id;
                document.getElementById('modelo').value = datos.modelo; 
                document.getElementById('color').value = datos.colores_id;
                document.getElementById('tipo').value = datos.tipo_id;
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
        url = 'agregar_vehiculos'
        datos = {
            'num_serie' : document.getElementById('num_serie').value,
            'marca' : document.getElementById('marca').value,
            'modelo' : document.getElementById('modelo').value,
            'color' : document.getElementById('color').value,
            'tipo' : document.getElementById('tipo').value,
        }
        if(document.getElementById('btn_duenos').innerHTML == 'Actualizar'){
            url = 'editar_auto';
            datos = {
                'id': variable,
                'num_serie' : document.getElementById('num_serie').value,
                'marca' : document.getElementById('marca').value,
                'modelo' : document.getElementById('modelo').value,
                'color' : document.getElementById('color').value,
                'tipo' : document.getElementById('tipo').value,
            }
        }

        $.ajax({
            url: url,
            method: 'POST',
            data: datos,
            success: function(data){
                console.log('La data: ', data);
                if(data == 0){
                    Swal.fire({
                            title: 'Error',
                            text: 'El dato que intentas ingresar ya existe',
                            icon: 'warning',
                            confirmButtonText: 'Aceptar'
                        })
                }
                else{
                    console.log(data);
                    datosTabla = JSON.parse(data);
                    llamar_tabla(datosTabla);
                    document.getElementById('btn_duenos').innerHTML = 'Registrar';
                    if(document.getElementById('btn_duenos').innerHTML == 'Actualizar'){
                        document.getElementById('btn_duenos').innerHTML = 'Registrar';
                    }
                    limpiar();
                }
            }
        })
    }

    function eliminar(value, row){
        console.log('Row', row);
        Swal.fire({
            title: 'Eliminar',
            text: 'Seguro que quieres eliminar este auto?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if(result.value){
                $.ajax({
                    url: 'eliminar_auto',
                    method: 'POST',
                    data: {'id': row},
                    success: function(data){
                        console.log('success: ', data)
                        console.log('datos tabla length: ',datosTabla.length);
                        if(data > 0){
                            for(var i = 0; i<datosTabla.length; i++){
                                console.log('datos: ', datosTabla[i]);
                                if(datosTabla[i].id == row){
                                    datosTabla.splice(i, 1);
                                }
                            }
                            tabla.bootstrapTable('removeAll');
                            tabla.bootstrapTable('append', datosTabla);
                            return;
                        }
                    }

                })
            }
        })
    }

    function limpiar(){
        document.getElementById('num_serie').value = "";
        document.getElementById('marca').value = "";
        document.getElementById('modelo').value = "";
        document.getElementById('color').value = "";
        document.getElementById('tipo').value = "";
    }

    function editar_titulo(){
        document.getElementById('modalFormLabel').innerHTML = 'Registrar vehiculos';
        llamar_modal();
    }

    function llamar_modal(){
        console.log("Llamar modal");
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
</script> -->