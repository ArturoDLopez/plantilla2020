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
        <button class="btn btn-success" onclick="mostrar_modal()">Agregar tipo</button>
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

<script>
    $(document).ready(function(){
        $('#frm_container').parsley();
        tabla.bootstrapTable();
    });

    let tabla = $('#tabla_tipos');   
    let tabla2 = $('#ver_uso');

    let columnsV = [
        { field: 'num_serie', title: 'Número de serie' },
        { field: 'modelo', title: 'Modelo' },
        { field: 'fecha_registro', title: 'Fecha de registro' },
    ];

    $('#frm_container').on('submit', function(e){
        e.preventDefault();
        if($('#frm_container').parsley().isValid()){
            agregar();
            $('#frm_container').parsley().reset();
        }
    });

    function accion(value, row, index){
        let boton = `<button class="btn btn-round btn-danger" title="Eliminar" onclick="eliminar(${row.id})">
                        <i class="glyph-icon icon-trash"></i>
                    </button>`;
        if(row.vehiculos_id != null){
            boton = `<button class="btn btn-round btn-info" title="Ver uso del tipo" onclick="ver(${row.id})">
                        <i class="glyph-icon icon-eye"></i>
                    </button>
                    <button class="btn btn-round btn-danger" disabled>
                        <i class="glyph-icon icon-trash"></i>
                    </button>`;
        }
        return boton;
    }

    function ver(id){
        $.ajax({
            url: '<?= base_url(); ?>catalogos/tipos/ver_vehiculos_tipos',
            type: 'POST',
            data: {'id': id},
            success: function(data){
                let json = JSON.parse(data);
                if(json.length > 0){
                    $('#modalTipos').modal('show');
                    tabla2.bootstrapTable('destroy');
                    tabla2.bootstrapTable({
                        columns: columnsV,
                        data: json
                    });
                }
            }
        });
    }

    function agregar(){
        let url = "<?= base_url(); ?>catalogos/tipos/agregar_tipos";
        let data = { 'tipo': $('#tipo').val() };

        $.ajax({
            type: 'POST',
            data: data,
            url: url,
            success: function(response){
                if (response == 0){
                    Swal.fire({
                        title: 'Error',
                        text: 'El tipo ya existe',
                        icon: 'warning',
                        confirmButtonText: 'Aceptar'
                    });
                } else {
                    Swal.fire({
                        title: 'Agregado correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                    tabla.bootstrapTable('refresh');
                }
            }
        });
    }

    function eliminar(id){
        let url = "<?= base_url(); ?>catalogos/tipos/eliminar_tipos";

        Swal.fire({
            title: 'Eliminar',
            text: '¿Seguro que quieres eliminar este elemento?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if(result.value){
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: { 'id': id },
                    success: function(response){
                        if(response != 0){
                            tabla.bootstrapTable('refresh');
                        }
                    }
                });
            }
        });
    }

    function mostrar_modal(){
        $('#modalForm').modal('show');
    }

    function queryParams(params) {
        return {
            limit: params.limit,
            offset: params.offset
        };
    }
</script>
