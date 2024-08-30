
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
            <button class="btn btn-round btn-azure" title="Editar" type="button" onclick="rellenar(${row.id})">
                <i class="glyph-icon icon-edit"></i>
            </button>
            <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminar(${row.id}, 'eliminar_auto', columns, tabla)">
                <i class="glyph-icon icon-trash"></i>
            </button>
        `;
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

    function registrar_local(){
        let elemento = document.getElementById('btn_duenos');
        let datos = [];
        if(elemento.innerHTML == 'Registrar'){
            datos = {
                'num_serie' : document.getElementById('num_serie').value,
                'marca' : document.getElementById('marca').value,
                'modelo' : document.getElementById('modelo').value,
                'color' : document.getElementById('color').value,
                'tipo' : document.getElementById('tipo').value,
            }
        }
        else{
            datos = {
                'id': variable,
                'num_serie' : document.getElementById('num_serie').value,
                'marca' : document.getElementById('marca').value,
                'modelo' : document.getElementById('modelo').value,
                'color' : document.getElementById('color').value,
                'tipo' : document.getElementById('tipo').value,
            }
        }
        registrar('agregar_vehiculos', 'editar_auto', datos, elemento, columns, arreglo_campos, tabla);
    }

    function cancelar_local(){
        cancelar('btn_duenos', 'btn_cancel', arreglo_campos);
    }
</script>