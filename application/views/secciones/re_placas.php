<div class="container m-5" id="ve_container">
    <h1>
        Agregar placas
    </h1>
    <form action="<?php base_url(); ?>agregar_placas" method="post" id='frm_placas'>
        <div class="row">
            <div class="form-group col-sm-4">
                <label for="placa" class="">Placa</label>
                <input type="text" class="form-control" required id="placa" name="placa" placeholder="Ingresa la placa">
            </div>
        </div>
        <button type="submit"  class="btn btn-success">Registrar</button>
    </form>
</div>

<div class="container ve_container">
    
    <table id="tableV" data-url="<?= base_url()?>secciones/placas/cargar_placas">

    </table>
</div>

<script src="../assets/js/placas.js"></script>
<script src="../assets/js/funciones.js"></script>