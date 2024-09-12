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
        
        <table id="tableV" data-url="<?= base_url()?>secciones/robos/cargar_robos">

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
        <form  id="frm_container" method="POST" data-parsley-validate="">
            <div class="row pt-4">
                
                <div class="form-group col-md-4">
                    <label for="num_serie">Numero de serie</label>
                    <select class="form-control" id="num_serie" name="num_serie" onchange="buscar_datos()" required>
                        
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
                        <label for="placa">Placa</label>
                        <input type="text" disabled class="form-control" id="inp_placa" name="placas_id" required>
                </div>

                <div class="form-group col-md-4">
                        <label for="placa">Dueño</label>
                        <input type="text" disabled class="form-control" id="inp_dueno" name="duenos_id" required>
                </div>
                
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="descripcion">Descripcion</label>
                    <textarea class="form-control" name="descripcion" id="descripcion" required></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="fecha_r">Fecha del robo</label>
                    <input type="datetime-local" name="fecha_r" id="fecha_r" class="form-control" required>
                </div>

            </div>
            <div class="row">
                <div class="col-md-1">
                    <button type="submit" id="btn_duenos" class="btn btn-success" >Registrar</button>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <div class="col-md-1">
            
            <!-- <button type="button" id="btn_duenos" onclick="registrar_local()" class="btn btn-success" data-dismiss="modal">Registrar</button> -->
        </div>
                        
        <button type="button" id="btn_cancel" class="btn btn-danger" data-dismiss="modal" onclick="cancelar_local()">Cancelar</button>

      </div>
    </div>
  </div>
</div>

<script src="../../assets/js/modal.js"></script>
<script src="../../assets/js/robos.js"></script>
<script src="../../assets/js/funciones.js"></script>