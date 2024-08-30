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
        
        <table id="tableV">

        </table>
    </div>
</div>

<div class="modal" data-backdrop="static" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFormLabel">Agregar emplacado</h5>
      </div>
      <div class="modal-body">
        <form action="" id="frm_container" method="POST">
            <div class="row pt-4">

                
                <div class="form-group col-md-4">
                    <label for="num_serie">Numero de serie</label>
                    <select class="form-control" id="num_serie" name="num_serie">
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
                    <label for="placa">Placas</label>
                    <select name="placa" id="placa" class="form-control">
                        <option value="0">Seleccione un dueño</option>
                        <?php
                            foreach($placas['placas'] as $du){
                                echo '
                                    <option value="'.$du->id.'">'.$du->placa.'</option>
                                ';
                            }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-4">
                            <label for="actual">Actualmente son las placas del vehiculo</label>
                            <select name="actual" id="actual" class="form-control" onchange="habilitar_fecha()">
                                <option value="0">No</option>    
                                <option value="1">Si</option>
                            </select>
                </div>
                
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="fecha_i">Fecha de inicio</label>
                    <input type="date" name="fecha_i" id="fecha_i" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="fecha_t">Fecha de termino</label>
                    <input type="date" name="fecha_t" id="fecha_t" class="form-control">
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

    function acciones(value, row, index){
        return `
            <button class="btn btn-round btn-azure" title="Editar" type="button" onclick="rellenar(${row.id})">
                <i class="glyph-icon icon-edit"></i>
            </button>
            <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminar(${row.id}, 'eliminar_emplacado', columns, tabla)">
                <i class="glyph-icon icon-trash"></i>
            </button>
        `;
    }

    traer_datos('cargar_emplacado', columns, tabla);

    function llamar(){
        llamar_modal(modal_id, arreglo_campos);
    }

    function rellenar(id){
        $.ajax({
            url: 'consultar_emplacado',
            method: 'POST',
            data: {'id': id},
            success: function(datos){
                datos = JSON.parse(datos);
                console.log(datos);
                let fecha_inicio = new Date(datos.fecha_inicio);
                fecha_inicio = fecha_inicio.toISOString().split('T')[0];

                 let fecha_termino_completa = datos.fecha_termino;
                console.log("datos.fecha_termino: ", fecha_termino_completa);
                let fecha_termino = datos.fecha_termino == null || datos.fecha_termino == "0000-00-00 00:00:00" || datos.fecha_termino == "" ?  "" : new Date(datos.fecha_termino);
                console.log('Fehca de termino: ', fecha_termino);
                fecha_termino = fecha_termino == "" ? "" : fecha_termino.toISOString().split('T')[0];

                llamar_modal(modal_id, arreglo_campos);
                document.getElementById('modalFormLabel').innerHTML = 'Actualizar Emplacado';
                document.getElementById('btn_duenos').innerHTML = 'Actualizar';
                document.getElementById('num_serie').value = datos.vehiculos_id;
                document.getElementById('placa').value = datos.placas_id;
                document.getElementById('actual').value = datos.actual; 
                document.getElementById('fecha_i').value = fecha_inicio;
                document.getElementById('fecha_t').value = fecha_termino;
                variable = id;
            }
        })
    }

    function registrar_local(){
        let elemento = document.getElementById('btn_duenos');
        let datos = [];
        if(elemento.innerHTML == 'Registrar'){
            document.getElementById('modalFormLabel').innerHTML = 'Registrar Emplacado';
            datos = {
                'num_serie' : document.getElementById('num_serie').value,
                'placa' : document.getElementById('placa').value,
                'actual' : document.getElementById('actual').value,
                'fecha_i' : document.getElementById('fecha_i').value,
                'fecha_t' : document.getElementById('fecha_t').value,
            }
        }
        else{
            datos = {
                'id': variable,
                'num_serie' : document.getElementById('num_serie').value,
                'placa' : document.getElementById('placa').value,
                'actual' : document.getElementById('actual').value,
                'fecha_i' : document.getElementById('fecha_i').value,
                'fecha_t' : document.getElementById('fecha_t').value,
            }
        }
        registrar('agregar_emplacado', 'editar_emplacado', datos, elemento, columns, arreglo_campos, tabla);
    }

    function cancelar_local(){
        cancelar('btn_duenos', 'btn_cancel', arreglo_campos);
    }

</script>