<style>
    #ve_container{
        margin-top: 2vh;
    }

    #frm_container{
        margin-top: 2vh;
    }
</style>




<div class="container m-5" id="ve_container">
    <h1>
        Agregar reporte de robo
    </h1>
    <form  id="frm_container" method="POST">
        <div class="row pt-4">

            
            <div class="form-group col-md-4">
                <label for="num_serie">Numero de serie</label>
                <select class="form-control" id="num_serie" name="num_serie" onchange="buscar_datos()">
                    <option value="0">
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
                    ?>
                </select>
            </div>

            <div class="form-group col-md-4">
                    <label for="placa">Placa</label>
                    <input type="text" disabled class="form-control" id="inp_placa" name="placas_id">
            </div>

            <div class="form-group col-md-4">
                    <label for="placa">Dueño</label>
                    <input type="text" disabled class="form-control" id="inp_dueno" name="duenos_id">
            </div>
            
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="descripcion">Descripcion</label>
                <textarea class="form-control" name="descripcion" id="descripcion"></textarea>
            </div>
            <div class="form-group col-md-6">
                <label for="fecha_r">Fecha del robo</label>
                <input type="date" name="fecha_r" id="fecha_r" class="form-control">
            </div>

            

        </div>
        
        <div class="row">
            <div class="col-md-1">
                <button type="button" id="btn_duenos" onclick="enviar_datos()" class="btn btn-success">Registrar</button>
            </div>
            
            <div class="col-md-1" id="btn_cancel">

            </div>
        </div>
    </form>
</div>
<div class="container ve_container">
    <!-- <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Numero de serie</th>
                <th>Placas</th>
                <th>Dueño</th>
                <th>Descripcion</th>
                <th>Fecha del Robo</th>
                <th>Fecha de registro</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
                foreach($robos['robos'] as $placa){
                    echo '
                        <tr>
                            <td>
                                '.$count++.'
                            </td>
                            <td>
                                '.$placa->num_serie.'
                            </td>
                            <td>
                                '.$placa->placa.'
                            </td>
                            <td>
                                '.$placa->nombre. ' ' . $placa->apellido_p . '
                            </td>
                            <td>
                                '.$placa->descripcion.'
                            </td>
                            <td>
                                '.$placa->fecha.'
                            </td>
                            <td>
                                '.$placa->fecha_registro.'
                            </td>
                        </tr>
                    ';
                }
            ?>
        </tbody>
    </table> -->
</div>
<div class="container ve_container">
    <table id="tablaB" class="table"></table>

</div>

<script>

    let global;
    let datos_table;
    let tabla = $('#tablaB');
    const columns = [{
                        field: 'id',
                        title: '#'
                    }, {
                        field: 'num_serie',
                        title: 'Numero de serie'
                    }, {
                        field: 'placa',
                        title: 'Placas'
                    }, {
                        field: 'nombre',
                        title: 'Dueno nombre'
                    }, {
                        field: 'apellido_p',
                        title: 'Apellido paterno'
                    }, {
                        field: 'descripcion',
                        title: 'Descripcion'
                    }, {
                        field: 'fecha',
                        title: 'Fecha de robo'
                    }, {
                        field: 'fecha_registro',
                        title: 'Fecha de registro'
                    }, 
        {
            field: 'id', title: 'Acciones', formatter: acciones, align: 'center'
        }

    ];

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

    function eliminar(value, row){
        console.log('Row', row);
        Swal.fire({
            title: 'Eliminar',
            text: 'Seguro que quieres eliminar este robo?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if(result.value){
                $.ajax({
                    url: 'eliminar_robo',
                    method: 'POST',
                    data: {'id': row},
                    success: function(data){
                        console.log('success: ', data)
                        console.log('datos tabla length: ',datos_table.length);
                        if(data > 0){
                            for(var i = 0; i<datos_table.length; i++){
                                console.log('datos: ', datos_table[i]);
                                if(datos_table[i].id == row){
                                    datos_table.splice(i, 1);
                                }
                            }
                            tabla.bootstrapTable('removeAll');
                            tabla.bootstrapTable('append', datos_table);
                            return;
                        }
                    }

                })
            }
        })
        //tabla.bootstrapTable('removeAll')
    }

    function fomrmaterEliminar(value, row, index) {
        return '<button class="remove btn btn-danger" type="button" onclick="eliminar('+value+','+row.id+')">Eliminar</button>'
    }

    function fomrmaterActualizar(value, row, index) {
        return '<button class="remove btn btn-warning" type="button" onclick="rellenar('+value+','+row.id+')">Actualizar</button>'
    }

    let variable;

    function rellenar(id){
        $.ajax({
            url: 'consultar_robo',
            method: 'POST',
            data: {'id': id},
            success: function(datos){
                datos = JSON.parse(datos);
                console.log(datos);
                document.getElementById('btn_cancel').innerHTML = `<button type="button"  onclick="cancelar()" class="btn btn-danger">Cancelar</button>`;
                document.getElementById('btn_duenos').innerHTML = 'Actualizar';
                document.getElementById('num_serie').value = datos.vehiculos_id;
                document.getElementById('inp_placa').value = datos.placas_id;
                document.getElementById('inp_dueno').value = datos.duenos_id; 
                document.getElementById('descripcion').value = datos.descripcion;
                document.getElementById('fecha_r').value = datos.fecha;
                variable = id;
                buscar_datos();
            }
        })
    }
   
    imprimir()

    function imprimir()
    {
        
        $.ajax({
            url: 'cargar_robos',
            type: 'POST',
            success: function(data){
                console.log('Datos: ', data);
                datos_table = JSON.parse(data);
                llamar_tabla(datos_table);
            }
        });
    };


    function buscar_datos() {
        
        var combo = document.getElementById("num_serie");
        var sel = combo.options[combo.selectedIndex].text;
        //let url = "<?php echo base_url('dashboard/buscar_datos');?>";
        let json = {
            'serie': sel
        }
        //console.log("buscar_datos: ", url);
        $.ajax({
            url: 'buscar_datos',
            type: 'POST',
            data: json,
            success: function(data){
                console.log('datos crudos:',data);
                var json = JSON.parse(data);
                global = json;
                console.log('json.parse',json);
                let placa = json.placa;
                let dueno = json.nombre + ' ' + json.apellido_p;
                document.getElementById('inp_placa').value = placa;
                document.getElementById('inp_dueno').value = dueno;
                
            }

        })
    }

    function cancelar(){
        document.getElementById('btn_cancel').innerHTML = ``;
        document.getElementById('btn_duenos').innerHTML = 'Registrar';
        limpiar();
    }

    function enviar_datos(){
        let num_serie = document.getElementById('num_serie').value;
        let placas_id = global.placa_id;
        let duenos_id = global.dueno_id;
        let descripcion = document.getElementById('descripcion').value;
        let fecha = document.getElementById('fecha_r').value;
        let url = 'agregar_robo';
        let json =
        {
            'num_serie' : num_serie,
            'placas_id' : placas_id,
            'duenos_id' : duenos_id,
            'descripcion' : descripcion,
            'fecha_r' : fecha
        }
        if(document.getElementById('btn_duenos').innerHTML == 'Actualizar'){
            url = 'editar_robo';
            json = {
                'id': variable,
                'num_serie' : num_serie,
                'placas_id' : placas_id,
                'duenos_id' : duenos_id,
                'descripcion' : descripcion,
                'fecha_r' : fecha
            }
            document.getElementById('btn_cancel').innerHTML = ``;
        }
        console.log('json: ', json);
        $.ajax({
            url: url,
            type: 'POST',
            data: json,
            success: function(datos){
                console.log('Datos: ', datos);
                datos_table = JSON.parse(datos);
                llamar_tabla(datos_table);
                document.getElementById('btn_duenos').innerHTML = 'Registrar';
                if(document.getElementById('btn_duenos').innerHTML == 'Actualizar'){
                    document.getElementById('btn_duenos').innerHTML = 'Registrar';
                }
                limpiar();
                
            
            }
        })
    }

    function limpiar(){
        document.getElementById('num_serie').value = "";
        document.getElementById('inp_placa').value = "";
        document.getElementById('inp_dueno').value = ""; 
        document.getElementById('descripcion').value = "";
        document.getElementById('fecha_r').value = "";
    }
    
    function llamar_tabla(datos){
        tabla.bootstrapTable('destroy');
        tabla.bootstrapTable({
            pagination : true,
            search : true,
            columns: columns,
            data: datos
        });
    }
        
</script>