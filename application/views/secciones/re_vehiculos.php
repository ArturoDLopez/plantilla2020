
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
            
            <table id="tableV" >

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
                    <input type="text" class="form-control" id="num_serie" name="num_serie" required>
                </div>
                
                <div class="form-group col-md-4">
                    <label for="marca">Marca</label>
                    <select class="form-control" id="marca" name="marca" required>
                        
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="modelo">Modelo</label>
                    <input data-parsley-type="number" data-parsley-length="[4, 4]" data-parsley-min="1900" data-parsley-min="2025" class="form-control" id="modelo" name="modelo" required>
                </div>
                
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="color">Color</label>
                    <select class="form-control" name="color" id="color" required>
                        <!-- <option value="0">Selecciona una opcion</option>
                        <?php
                            foreach($colores['colores'] as $color):
                        ?>
                            <option value="<?php echo $color->id; ?>">
                                <?php echo $color->nom_color; ?>
                            </option>
                        <?php 
                            endforeach;
                        ?> -->
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="marca">Tipo</label>
                    <select class="form-control" id="tipo" name="tipo" required>
                        
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">
                    <button type="submit" id="btn_duenos" class="btn btn-success">Registrar</button>
                </div>
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

<script src="../assets/js/re_vehiculos.js">

</script>