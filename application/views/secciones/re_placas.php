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
        <button type="button" onclick="registrar()" class="btn btn-success">Registrar</button>
    </form>
</div>

<div class="container ve_container">
    
    <table id="tableV" data-url="<?= base_url()?>secciones/placas/cargar_placas">

    </table>
</div>

<script>

    let base_url = "<?= base_url()?>secciones/placas/"
    let tabla = $("#tableV");
    let datosTabla = 0;
    let columns = [
        {
            field: 'placa', title: 'Placa'
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
        <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminar(`+row.id+`)">
                    <i class="glyph-icon icon-trash"></i>
        </button>
        `
    }

    traer_datos();

    function eliminar(row){
        Swal.fire({
            title: 'Eliminar',
            text: 'Seguro que quieres eliminar este auto?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if(result.value){
                $.ajax({
                    url: base_url + 'eliminar_placa',
                    method: 'POST',
                    data: {'id': row},
                    success: function(data){
                        if(data > 0){
                            tabla.bootstrapTable('refresh');
                            return;
                        }
                    }

                })
            }
        })
    }


    function traer_datos(){
        $.ajax({
            url: base_url + 'cargar_placas',
            method: 'POST',
            success: function(data){
                datosTabla = JSON.parse(data);
                llamar_tabla(datosTabla);
            }
        })
    }
    
    function registrar(){
        $.ajax({
            url: base_url + 'agregar_placa',
            method: 'POST',
            data: {'placa':document.getElementById('placa').value},
            success: function(data){
                console.log(data);
                if(data != 1){
                    Swal.fire({
                            title: 'Error',
                            text: 'El dato que intentas ingresar ya existe',
                            icon: 'warning',
                            confirmButtonText: 'Aceptar'
                        })
                }
                else{
                    datosTabla = JSON.parse(data);
                    tabla.bootstrapTable('refresh');
                }
            }
        })
    }

    function llamar_tabla(data){
        tabla.bootstrapTable('destroy');
        tabla.bootstrapTable({
            pagination : true,
            data: data,
            columns: columns
        })
    }
</script>