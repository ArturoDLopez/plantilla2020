
<div class="container m-5" id="ve_container">
    <h1>
        Agregar Dueños
    </h1>
    <form action="" method="post" id='frm_duenos'>
        <div class="row">

            <div class="form-group col-sm-4">
                <label for="nombre" class="">Nombre</label>
                <input type="text" class="form-control" required id="nombre" name="nombre" placeholder="Ingresa tu nombre">
            </div>

            <div class="form-group col-sm-4">
                <label for="ap" class="">Apellido paterno</label>
                <input type="text" class="form-control" required id="ap" name="ap" placeholder="Ingresa tu apellido paterno">
            </div>

            <div class="form-group col-sm-4">
                <label for="am" class="">Apellido materno</label>
                <input type="text" class="form-control" required id="am" name="am" placeholder="Ingresa tu apellido materno">
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <button type="button" id="btn_duenos" onclick="registrar()" class="btn btn-success">Registrar</button>
            </div>
            
            <div class="col-md-1" id="btn_cancel">

            </div>
        </div>
        
    </form>

    <!-- Tabla de todos los duenos -->
    <div class="container"  id="cls_container">

        <div class="container ve_container">
    
        <table id="tableV">

        </table>
    </div>

    </div>
</div>

<script>

    let tabla = $("#tableV");
    let datosTabla = 0;
    let columns = [
        {
            field: 'nombre', title: 'Nombre'
        },
        {
            field: 'apellido_p', title: 'Apellido paterno'
        },
        {
            field: 'apellido_m', title: 'Apellido materno'
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
        <button class="btn btn-round btn-azure" title="Editar" type="button" onclick="rellenar(`+row.id+`)">
                    <i class="glyph-icon icon-edit"></i>
        </button>
        <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminar(`+value+','+row.id+`)">
                    <i class="glyph-icon icon-trash"></i>
        </button>
        `
    }

    traer_datos();

    function traer_datos(){
        $.ajax({
            url: 'cargar_duenos',
            method: 'POST',
            success: function(data){
                console.log(data);
                datosTabla = JSON.parse(data);
                llamar_tabla(datosTabla);
            }
        })
    }

    function fomrmaterEliminar(value, row, index) {
        return '<button class="remove btn btn-danger" type="button" onclick="eliminar('+value+','+row.id+')">Eliminar</button>'
    }
    
    function fomrmaterActualizar(value, row, index) {
        return `<button class="remove btn btn-warning" type="button" onclick='rellenar(`+row.id+`)'>Actualizar</button>`;
    }

    let variable;

    function rellenar(id){
        console.log('variables: '+id);
        $.ajax({
            url: 'consultar_dueno',
            method: 'POST',
            data: {'id': id},
            success: function(datos){
                datos = JSON.parse(datos);
                console.log(datos);
                document.getElementById('btn_cancel').innerHTML = `<button type="button"  onclick="cancelar()" class="btn btn-danger">Cancelar</button>`;
                document.getElementById('btn_duenos').innerHTML = 'Actualizar';
                document.getElementById('nombre').value = datos.nombre;
                document.getElementById('ap').value = datos.apellido_p;
                document.getElementById('am').value = datos.apellido_m;
                variable = id;
            }
        })
    }

    function cancelar(){
        document.getElementById('btn_cancel').innerHTML = ``;
        document.getElementById('btn_duenos').innerHTML = 'Registrar';
        limpiar();
    }


    function registrar(){
        console.log("Si era asi: ", variable);
        url = 'agregar_duenos';
        data = {'nombre':document.getElementById('nombre').value, 'ap':document.getElementById('ap').value, 'am':document.getElementById('am').value}
        if(document.getElementById('btn_duenos').innerHTML == 'Actualizar'){
            url = 'editar_dueno';
            data = {'id': variable, 'nombre':document.getElementById('nombre').value, 'ap':document.getElementById('ap').value, 'am':document.getElementById('am').value}
            document.getElementById('btn_cancel').innerHTML = ``;
        }
        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: function(data){
                console.log(data);
                datosTabla = JSON.parse(data);
                llamar_tabla(datosTabla);
                document.getElementById('btn_duenos').innerHTML = 'Registrar';
                if(document.getElementById('btn_duenos').innerHTML == 'Actualizar'){
                    document.getElementById('btn_duenos').innerHTML = 'Registrar';
                }
                limpiar();
            }
        })
    }

    function limpiar(){
        document.getElementById('nombre').value = "";
        document.getElementById('ap').value = "";
        document.getElementById('am').value = "";
    }

    function eliminar(value, row){
        console.log('Row', row);
        Swal.fire({
            title: 'Eliminar',
            text: 'Seguro que quieres eliminar a este dueño?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if(result.value){
                $.ajax({
                    url: 'eliminar_dueno',
                    method: 'POST',
                    data: {'id': row},
                    success: function(data){
                        data = JSON.parse(data);
                        if(data.length > 0){
                            llamar_tabla(data);
                            return;
                        }
                    }
                })
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