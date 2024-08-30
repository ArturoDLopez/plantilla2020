<div class="container m-5" id="ve_container">
    <h1>
        Agregar reporte de robo
    </h1>
</div>

<div class="container ve_container">
    <div class="row mb-1">
        <button onclick="llamar()" class="btn btn-success justify-content-center m-2 p-2">
            Registrar nuevo reporte
        </button>
    </div>
    
    <div class="row">
        
        <table id="tableV">

        </table>
    </div>
</div>

<div class="modal" data-backdrop="static" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header"  style="background-color: #1C314F;">
        <h5 class="modal-title" id="modalFormLabel">Agregar reporte de robo</h5>
      </div>
      <div class="modal-body">
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
        </form>
      </div>
      <div class="modal-footer">
        <div class="col-md-1">
            <button type="button" id="btn_duenos" onclick="registrar_local()" class="btn btn-success" data-dismiss="modal">Registrar</button>
        </div>
                        
        <button type="button" id="btn_cancel" class="btn btn-danger" data-dismiss="modal" onclick="cancelar_local()">Cancelar</button>

      </div>
    </div>
  </div>
</div>

<script src="../assets/js/modal.js">
    
</script>

<script>

    let modal_id = "modalForm";
    let tabla = $("#tableV");
    let arreglo_campos = ['num_serie', 'inp_placa', 'inp_dueno', 'descripcion', 'fecha_r'];
    let variable;
    let global;
    let datosTabla = 0;
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

    traer_datos('cargar_robos', columns, tabla);

    function acciones(value, row, index){
        return `
            <button class="btn btn-round btn-azure" title="Editar" type="button" onclick="rellenar(${row.id})">
                <i class="glyph-icon icon-edit"></i>
            </button>
            <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminar(${row.id}, 'eliminar_robo', columns, tabla)">
                <i class="glyph-icon icon-trash"></i>
            </button>
        `;
    }

    function llamar(){
        llamar_modal(modal_id, arreglo_campos);
    }

    function rellenar(id){
        $.ajax({
            url: 'consultar_robo',
            method: 'POST',
            data: {'id': id},
            success: function(datos){
                datos = JSON.parse(datos);
                console.log(datos);
                llamar_modal(modal_id, arreglo_campos);
                document.getElementById('modalFormLabel').innerHTML = 'Actualizar robo';
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

    function registrar_local(){
        let elemento = document.getElementById('btn_duenos');
        let datos = [];
        let num_serie = document.getElementById('num_serie').value;
        let placas_id = global.placa_id;
        let duenos_id = global.dueno_id;
        let descripcion = document.getElementById('descripcion').value;
        let fecha = document.getElementById('fecha_r').value;
        if(elemento.innerHTML == 'Registrar'){
            document.getElementById('modalFormLabel').innerHTML = 'Registrar Emplacado';
            datos = {
                'num_serie' : num_serie,
                'placas_id' : placas_id,
                'duenos_id' : duenos_id,
                'descripcion' : descripcion,
                'fecha_r' : fecha
            }
        }
        else{
            datos = {
                'id': variable,
                'num_serie' : num_serie,
                'placas_id' : placas_id,
                'duenos_id' : duenos_id,
                'descripcion' : descripcion,
                'fecha_r' : fecha
            }
        }
        registrar('agregar_robo', 'editar_robo', datos, elemento, columns, arreglo_campos, tabla);
    }

    function cancelar_local(){
        cancelar('btn_duenos', 'btn_cancel', arreglo_campos);
    }
 
</script>