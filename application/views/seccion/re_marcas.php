
<div class="container">
<ul class="nav nav-tabs">
  <li role="presentation" class="active" id="li_marcas"><a  onclick="seleccion_opciones('marca')">Marcas</a></li>
  <li role="presentation" id="li_colores"><a  onclick="seleccion_opciones('color')">Colores</a></li>
  <li role="presentation" id="li_tipos"><a onclick="seleccion_opciones('tipo')">Tipos</a></li>
</ul>

<!-- <form method="post" id="formAsignacion">
    <div class="row">
        <div class="form-group col-sm-4 m-1">
            <label for="mr">Agregar marca</label>
            <input type="text" class="form-control" id="input_nom" name="nom_marca" required>
        </div>
        <div class="form-group col-sm-4 m-1">
            <button id="btn_submit" type='button' class="btn btn-primary m-1" onclick="agregar('agregar_marcas')">
                Registrar
            </button>
        </div>
        
    </div>
</form> -->

    <div id="opciones">

    </div>

    <table id="tablaM"></table>
    
</div>

<script>


    function accionC(value, row, index){
        return `
        <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminarC(`+value+','+row.id+`)">
                    <i class="glyph-icon icon-trash"></i>
        </button>
        `
    }

    function accionM(value, row, index){
        return `
        <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminarM(`+value+','+row.id+`)">
                    <i class="glyph-icon icon-trash"></i>
        </button>
        `
    }

    function accionT(value, row, index){
        return `
        <button class="btn btn-round btn-danger" title="Eliminar" type="button" onclick="eliminarT(`+value+','+row.id+`)">
                    <i class="glyph-icon icon-trash"></i>
        </button>
        `
    }
    
    const opcion_marcas = `
    
    <form method="post" id="formAsignacion">
    <div class="row">
        <div class="form-group col-sm-4 m-1">
            <label for="mr">Agregar marca</label>
            <input type="text" class="form-control" id="input_nom" name="nom_marca" required>
        </div>
        <div class="form-group col-sm-4 m-1">
            <button id="btn_submit" type='button' class="btn btn-primary m-1" onclick="agregar('agregar_marcas')">
                Registrar
            </button>
        </div>
        
    </div>
    </form>
    <?php echo form_close();?>
           
    `;

    const opcion_colores = `
    <?php echo form_open('dashboard/agregar_colores');?>
    <div class="row">
        <div class="form-group col-sm-4 m-1">
            <label for="mr">Agregar color</label>
            <input type="text" class="form-control" id="input_nom" name="nom_color" required>
        </div>
        <div class="form-group col-sm-4 m-1">
            <button id="btn_submit" type='button' class="btn btn-primary m-1" onclick="agregar('agregar_colores')">
                Registrar
            </button>
        </div>
        
    </div>
        
    <?php echo form_close();?>
    `;

    const opcion_tipos = `
    <?php echo form_open('dashboard/agregar_tipos');?>
    <div class="row">
        <div class="form-group col-sm-4 m-1">
            <label for="mr">Agregar tipo</label>
            <input type="text" class="form-control" id="input_nom" name="nom_tipo" required>
        </div>
        <div class="form-group col-sm-4 m-1">
            <button type='button' class="btn btn-primary m-1" onclick="agregar('agregar_tipos')">
                Registrar
            </button>
        </div>
        
    </div>
        
    <?php echo form_close();?>
    `;

    function imprimir(url, columns)
    {
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

    columnsColor = [{
                    field: 'nom_color',
                    title: 'Color'
                }, {
                    field: 'fecha_registro',
                    title: 'Fecha de registro'
                }, {
                    field: 'id', title: 'Acciones', formatter: accionC, align: 'center'
                }

    ];

    columnsMarca = [{
                field: 'nom_marca',
                title: 'Marca'
            }, {
                field: 'fecha_registro',
                title: 'Fecha de registro'
            }, {
                    field: 'id', title: 'Acciones', formatter: accionM, align: 'center'
                }];

    columnsTipo = [{
                field: 'nom_tipo',
                title: 'Tipo'
            }, {
                field: 'fecha_registro',
                title: 'Fecha de registro'
            }, {
                    field: 'id', title: 'Acciones', formatter: accionT, align: 'center'
                }];

    const seleccion_opciones = (opcion) =>{
        document.getElementById('opciones').innerHTML = opcion == 'marca'? opcion_marcas : opcion == 'color'? opcion_colores : opcion_tipos;
        switch(opcion){
            case 'marca':
                $("#li_marcas").addClass("active");
                $("#li_colores").removeClass("active");
                $("#li_tipos").removeClass("active");
                imprimir('cargar_marcas', columnsMarca);
                columns = columnsMarca;
                break;
            case 'color':
                $("#li_colores").addClass("active");
                $("#li_marcas").removeClass("active");
                $("#li_tipos").removeClass("active");
                imprimir('cargar_colores', columnsColor);
                columns = columnsColor;
                break;
            case 'tipo':
                $("#li_tipos").addClass("active");
                $("#li_marcas").removeClass("active");
                $("#li_colores").removeClass("active");
                imprimir('cargar_tipos', columnsTipo);
                columns = columnsTipo;
                break;
            default:
                break;
            
        }
    }

    seleccion_opciones('marca');

    columns = columnsMarca;

    function agregar(url){
        
        let data = {
                'nombre': document.getElementById('input_nom').value
            },
            validate = false;
            console.log('Datos: ', data);
            
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
                        switch(url){
                            case 'agregar_colores':
                                columns = columnsColor;
                                break;
                            case 'agregar_marcas':
                                columns = columnsMarca;
                                break;
                            case 'agregar_tipos':
                                columns = columnsTipo;
                                break;
                        }
                    llamar_tabla(data, columns);
                    }
                    
                    console.log('Datos en el success: ', data);
                }
            })
    }

    function pregunta(funcion, url, id){
        Swal.fire({
            title: 'Eliminar',
            text: 'Seguro que quieres eliminar este elemento?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if(result.value){
                funcion(url, id)
            }
        });
    }

    function eliminarC(value, row){
        pregunta(eliminar, 'eliminar_colores', row)
    }

    function eliminarM(value, row){
        pregunta(eliminar, 'eliminar_marcas', row)
    }

    function eliminarT(value, row){
        pregunta(eliminar, 'eliminar_tipos', row)
    }

    function eliminar(url, row){
        $.ajax({
                url: url,
                method: 'POST',
                data: {'id': row},
                success: function(data){
                    if(data != 0){
                        llamar_tabla(data, columns);
                    }
                }
            })
    }

    let tabla = $('#tablaM');    

    function llamar_tabla(datos, columns){
        datos = JSON.parse(datos);
        console.log("Datos: ", datos);
        if(datos.length == 0) {
            tabla.bootstrapTable('destroy');
            return
        }

        console.log('llamar tabla', datos);
        console.log("Columasn: ", columns);
        tabla.bootstrapTable('destroy');
        tabla.bootstrapTable({
            columns: columns,
            data: datos
        })
    }

</script>