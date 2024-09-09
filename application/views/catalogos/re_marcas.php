
<div class="modal" data-backdrop="static" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormLabel">Agregar Marca</h5>
            </div>
            <div class="modal-body">
                    <form action="" id="frm_container" method="POST">
                        <div class="row">
                            <div class="form-group col-sm-12 m-1">
                                <label for="mr">Agregar marca</label>
                                <input type="text" class="form-control" id="marca" name="marca" required>
                            </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-sm-12 m-1">
                                <button id="btn_submit" type='submit' class="btn btn-primary m-1">
                                    Registrar
                                </button>
                            </div>
                        </div>
                    </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_cancel" class="btn btn-danger" data-dismiss="modal" onclick="">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" data-backdrop="static" id="modalMarcas" tabindex="-1" role="dialog" aria-labelledby="modalMarcasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMarcasLabel">Vehiculos que usan la marca</h5>
            </div>
            <div class="modal-body">
                    <table id="ver_uso" data-url="">

                    </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_cancel" class="btn btn-danger" data-dismiss="modal" onclick="">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="container text-center">
    <h1 class>
        Marcas
    </h1>
    <div id="opciones">
        <button class='btn btn-success' onclick="mostrar_modal()">
            Agregar marca
        </button>
    </div>

    <table id="tabla_marcas" data-url="<?php echo base_url()."catalogos/marcas/cargar_marcas"?>"></table>
    
</div>
<script src="../assets/js/catalogos/marcas.js"></script>