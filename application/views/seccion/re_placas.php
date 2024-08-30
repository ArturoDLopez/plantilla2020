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
    
    <table id="tableV">

    </table>
</div>

<script>

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
        <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminar(`+value+','+row.id+`)">
                    <i class="glyph-icon icon-trash"></i>
        </button>
        `
    }

    function eliminar(value, row){
        console.log('Row', row);
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
                    url: 'eliminar_placas',
                    method: 'POST',
                    data: {'id': row},
                    success: function(data){
                        console.log('success: ', data)
                        console.log('datos tabla length: ',datosTabla.length);
                        if(data > 0){
                            for(var i = 0; i<datosTabla.length; i++){
                                console.log('datos: ', datosTabla[i]);
                                if(datosTabla[i].id == row){
                                    datosTabla.splice(i, 1);
                                }
                            }
                            tabla.bootstrapTable('removeAll');
                            tabla.bootstrapTable('append', datosTabla);
                            return;
                        }
                    }

                })
            }
        })
    }

    function operateFormatter(value, row, index) {
        return '<button class="remove btn btn-danger" type="button" onclick="eliminar('+value+','+row.id+')">Eliminar</button>'
    }

    traer_datos();

    function traer_datos(){
        $.ajax({
            url: 'cargar_placas',
            method: 'POST',
            success: function(data){
                console.log(data);
                datosTabla = JSON.parse(data);
                llamar_tabla(datosTabla);
            }
        })
    }
    
    function registrar(){
        $.ajax({
            url: 'agregar_placas',
            method: 'POST',
            data: {'placa':document.getElementById('placa').value},
            success: function(data){
                console.log(data);
                if(data == 0){
                    Swal.fire({
                            title: 'Error',
                            text: 'El dato que intentas ingresar ya existe',
                            icon: 'warning',
                            confirmButtonText: 'Aceptar'
                        })
                }
                else{
                    datosTabla = JSON.parse(data);
                    llamar_tabla(datosTabla);
                }
            }
        })
    }

    function llamar_tabla(data){
        tabla.bootstrapTable('destroy');
        tabla.bootstrapTable({
            pagination : true,
            search : true,
            data: data,
            columns: columns
        })
    }
</script>