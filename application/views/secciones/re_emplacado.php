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

<script src="../assets/js/modal.js"></script>
<script src="../assets/js/emplacado.js"></script>
<script src="../assets/js/funciones.js"></script>