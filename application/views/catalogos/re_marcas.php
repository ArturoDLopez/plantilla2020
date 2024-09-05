
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

<script>

    $(document).ready(function(){
        $('#frm_container').parsley();
        imprimir(columns);
    });

    let tabla = $('#tabla_marcas');
    let tabla2 = $('#ver_uso');
    columns = [{
                    field: 'nom_marca',
                    title: 'marca'
                }, {
                    field: 'fecha_registro',
                    title: 'Fecha de registro'
                }, {
                    field: 'id', title: 'Acciones', formatter: accion, align: 'center'
                }
    ];
    let columnsV = [
        {
            field: 'num_serie', title: 'Numero de serie'
        },
        {
            field: 'modelo', title: 'modelo'
        },
        {
            field: 'fecha_registro', title: 'Fecha de registro'
        },

    ];

    $('#frm_container').on('submit', function(e){
        e.preventDefault();
        if($('#frm_container').parsley().isValid()){
            agregar();
            $('#frm_container').parsley().reset();
        }
    })

    function accion(value, row, index){
        let boton = `
        <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminar(`+row.id+`)">
                    <i class="glyph-icon icon-trash"></i>
        </button>
        `;
        if(row.vehiculos_id != null){
            boton = `
            <button class="btn btn-round btn-info" title="La marca esta en uso" type="button" onclick="ver(`+row.id+`)">
                        <i class="glyph-icon icon-eye"></i>
            </button>
            <button class="btn btn-round btn-danger" title="Ver uso" disabled type="button" onclick="eliminar(`+row.id+`)">
                        <i class="glyph-icon icon-trash"></i>
            </button>
        `;
        }

        return boton;
    }

    function imprimir(columns){
        url = '<?= base_url(); ?>catalogos/marcas/cargar_marcas';
        $.ajax({
            url: url,
            type: 'POST',
            success: function(data){
                if(data != 0){
                    llamar_tabla(data, columns);
                }
            }
        });
    };

    function ver(id){
        url = '<?= base_url(); ?>catalogos/marcas/ver_vehiculos_marcas';
        $.ajax({
            url: url,
            type: 'POST',
            data: {'id':id},
            success: function(data){
                json = JSON.parse(data);
                if(json.length >= 0){
                    $('#modalMarcas').modal('show');
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
        url = "<?= base_url(); ?>catalogos/marcas/agregar_marcas";
        let data = {
                'marca': document.getElementById('marca').value
            };
            
            $.ajax({
                type: 'POST',
                data: data,
                url: url,
                success: function (data){
                    if (data == 0){
                        Swal.fire({
                            title: 'Error',
                            text: 'El dato que intentas ingresar ya existe',
                            icon: 'warning',
                            confirmButtonText: 'Aceptar'
                        })
                    }
                    else{
                        Swal.fire({
                            title: 'Agregado correctamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar',        
                        })
                        tabla.bootstrapTable('refresh');
                    }
                    console.log('Datos en el success: ', data);
                }
            })
    }

    function eliminar(id, url){
        url = "<?= base_url(); ?>catalogos/marcas/eliminar_marcas";

        Swal.fire({
            title: 'Eliminar',
            text: 'Seguro que quieres eliminar este elemento?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if(result.value){
                $.ajax({
                url: url,
                method: 'POST',
                data: {'id': id},
                success: function(data){
                    if(data != 0){
                        tabla.bootstrapTable('refresh');
                    }
                }
            })
            }
        });
    }

    function llamar_tabla(datos, columns){
        datos = JSON.parse(datos);
        console.log("Datos: ", datos);
        if(datos.length == 0) {
            tabla.bootstrapTable('destroy');
            return
        }

        tabla.bootstrapTable('destroy');
        tabla.bootstrapTable({
            columns: columns,
            data: datos
        })
    }

    function mostrar_modal(){
        $('#modalForm').modal('show');
    }

</script>