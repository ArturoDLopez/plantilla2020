<div class="modal" data-backdrop="static" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormLabel">Agregar tipo</h5>
            </div>
            <div class="modal-body">
                <form action="" id="frm_container" method="POST">
                    <div class="row">
                        <div class="form-group col-sm-12 m-1">
                            <label for="tipo">Agregar tipo</label>
                            <input type="text" class="form-control" id="tipo" name="tipo" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 m-1">
                            <button id="btn_submit" type='submit' class="btn btn-primary m-1">Registrar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_cancel" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" data-backdrop="static" id="modalTipos" tabindex="-1" role="dialog" aria-labelledby="modalTiposLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTiposLabel">Vehículos de ese tipo</h5>
            </div>
            <div class="modal-body">
                <table id="ver_uso"></table>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_cancel" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="container text-center">
    <h1>Tipos</h1>
    <div id="opciones">
        <button class="btn btn-success" onclick="mostrar_modal('modalForm')">Agregar tipo</button>
    </div>

    <table id="tabla_tipos" 
        data-url="<?= base_url().'catalogos/tipos/cargar_tipos'; ?>"
        data-pagination="true" 
        data-side-pagination="server"
        data-page-size="10" 
        data-page-list="[10, 25, 50, 100]"
        data-query-params="queryParams">
        <thead>
            <tr>
                <th data-field="nom_tipo">Tipo</th>
                <th data-field="fecha_registro">Fecha registro</th>
                <th data-field="id" data-formatter="accion" data-align="center">Acciones</th>
            </tr>
        </thead>
    </table>
</div>
<script src="../../assets/js/catalogos/tipos.js"></script>
<script src="../../assets/js/funciones.js"></script>