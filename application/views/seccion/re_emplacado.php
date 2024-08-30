<style>
    #ve_container{
        margin-top: 2vh;
    }

    #frm_container{
        margin-top: 2vh;
    }
</style>
<div class="container m-5" id="ve_container">
    <h1>
        Agregar emplacado
    </h1>
    <form action="" id="frm_container" method="POST">
        <div class="row pt-4">

            
            <div class="form-group col-md-4">
                <label for="num_serie">Numero de serie</label>
                <select class="form-control" id="num_serie" name="num_serie">
                    <option value="0">
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
                    ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="placa">Placas</label>
                <select name="placa" id="placa" class="form-control">
                    <option value="0">Seleccione un dueño</option>
                    <?php
                        foreach($placas['placas'] as $du){
                            echo '
                                <option value="'.$du->id.'">'.$du->placa.'</option>
                            ';
                        }
                    ?>
                </select>
            </div>

            <div class="form-group col-md-4">
                        <label for="actual">Actualmente son las placas del vehiculo</label>
                        <select name="actual" id="actual" class="form-control" onchange="habilitar_fecha()">
                            <option value="0">No</option>    
                            <option value="1">Si</option>
                        </select>
            </div>
            
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="fecha_i">Fecha de inicio</label>
                <input type="date" name="fecha_i" id="fecha_i" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label for="fecha_t">Fecha de termino</label>
                <input type="date" name="fecha_t" id="fecha_t" class="form-control">
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
</div>
<div class="container ve_container">
    <table id="tableV">

    </table>
</div>
<script>
    const habilitar_fecha = () =>{
        let actual = document.getElementById('actual').value;
        console.log('Actuual: ', actual);
        if(actual == 1){
            document.getElementById('fecha_t').setAttribute('disabled', true);
            document.getElementById('fecha_t').value = null;
        }else if(actual == 0){
            document.getElementById('fecha_t').removeAttribute('disabled', false);
        }
    }
</script>

<script>

    let tabla = $("#tableV");
    let datosTabla = 0;
    let columns = [
        {
            field: 'num_serie', title: 'Numero de serie'
        },
        {
            field: 'placa', title: 'Placas'
        },
        {
            field: 'actual', title: 'Actual'
        },
        {
            field: 'fecha_inicio', title: 'Fecha de inicio'
        },
        {
            field: 'fecha_termino', title: 'Fecha de finalizacion'
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
            url: 'cargar_emplacado',
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
        $.ajax({
            url: 'consultar_emplacado',
            method: 'POST',
            data: {'id': id},
            success: function(datos){
                datos = JSON.parse(datos);
                console.log(datos);
                let fecha_inicio = new Date(datos.fecha_inicio);
                fecha_inicio = fecha_inicio.toISOString().split('T')[0];
                let fecha_termino = datos.fecha_termino !== null? new Date(datos.fecha_termino) : "";
                fecha_termino = fecha_termino != "" ? fecha_termino.toISOString().split('T')[0] : "";
                
                document.getElementById('btn_cancel').innerHTML = `<button type="button"  onclick="cancelar()" class="btn btn-danger">Cancelar</button>`;
                document.getElementById('btn_duenos').innerHTML = 'Actualizar';
                document.getElementById('num_serie').value = datos.vehiculos_id;
                document.getElementById('placa').value = datos.placas_id;
                document.getElementById('actual').value = datos.actual; 
                document.getElementById('fecha_i').value = fecha_inicio;
                document.getElementById('fecha_t').value = fecha_termino;
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
        url = 'agregar_emplacado';
        data = {'num_serie':document.getElementById('num_serie').value, 'placa':document.getElementById('placa').value, 'actual':document.getElementById('actual').value, 'fecha_i':document.getElementById('fecha_i').value, 'fecha_t':document.getElementById('fecha_t').value}
        if(document.getElementById('btn_duenos').innerHTML == 'Actualizar'){
            url = 'editar_emplacado';
            data = {'id': variable, 'num_serie':document.getElementById('num_serie').value, 'placa':document.getElementById('placa').value, 'actual':document.getElementById('actual').value, 'fecha_i':document.getElementById('fecha_i').value, 'fecha_t':document.getElementById('fecha_t').value}
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
                    document.getElementById('btn_cancel').innerHTML = "";
                }
                limpiar();
                
            }
        })
    }

    function limpiar(){
        document.getElementById('num_serie').value = "";
        document.getElementById('placa').value = "";
        document.getElementById('actual').value = ""; 
        document.getElementById('fecha_i').value ="";
        document.getElementById('fecha_t').value = "";
    }

    function eliminar(value, row){
        console.log('Row', row);
        Swal.fire({
            title: 'Eliminar',
            text: 'Seguro que quieres eliminar este emplacado?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if(result.value){
                $.ajax({
                    url: 'eliminar_emplacado',
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

    function editar_titulo(){
        document.getElementById('modalFormLabel').innerHTML = 'Registrar vehiculos';
        llamar_modal();
    }

    function llamar_modal(){
        console.log("Llamar modal");
        limpiar();
        $("#modalForm").modal('show');  
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