<style>
    h1{
        color: #ffff !important
    }

    .centrado{
        text-align: center
    }

</style>
<section id="bienvenida">
			<div class="wrapper">
				<div class="outer-content"></div>
				<div class="inner-content">
					<div class="container text-center">
                        
                            <form action="<?= base_url('seccion/buscar_vehiculo'); ?>" method="POST">
                                <div class="form-group">
                                    <label for="" >
                                        <h1 class="">
                                            Buscar vehiculo por placa
                                        </h1>
                                    </label>
                                    <div class=''>
                                        <input name="placa" type="text" class="form-control centrado" id="inp_placa" placeholder="Escriba su placa...">
                                    </div>
                                </div>
                                <div class="">
                                    <button class="btn btn-primary" type="button" onclick="buscar()">
                                        Buscar
                                    </button>
                                </div>
                            </form>

                            <div id="buscar_vehiculo" class="container m-5" id="ve_container">
                                <h1 id="ve_h1">
                                    
                                </h1>
                                

                                <table id="tablaB">

                                </table>

                                
                            </div>
							
					</div>
				</div>
				
			</div>
		</section> <!-- /#bienvenida -->



<script>
    
    let tabla = $('#tablaB');
    let columns = [{
                        field: 'num_serie',
                        title: 'Numero de serie'
                    }, {
                        field: 'placa',
                        title: 'Placas'
                    }, {
                        field: 'nom_marca',
                        title: 'Marca'
                    }, {
                        field: 'modelo',
                        title: 'Modelo'
                    }, {
                        field: 'nom_tipo',
                        title: 'Tipo'
                    }, {
                        field: 'nom_color',
                        title: 'Color'
                    }, {
                        field: 'nombre',
                        title: 'Nombre'
                    }, {
                        field: 'apellido_p',
                        title: 'Apellido paterno'
                    }, {
                        field: 'ro_id',
                        title: 'Reporte de robos',
                        formatter: acciones,
                        align: 'center'
                    }, {
                        field: 'fecha_registro',
                        title: 'Fecha de registro'
    }];

    function acciones(value, row, index){
        return `
            <button class="btn btn-round btn-info" title="Ver" onclick="ver_robos(`+row.id+`)">
                <i class="glyph-icon icon-info"></i>
            </button>
        `
    }

    

    function ver_robos(){
        console.log("Hay que buscar robos");
    }

    //buscar();

    function buscar(){
        let value = document.getElementById('inp_placa').value;

        let json = {
            'placa': value
        }

        $.ajax({
            url: 'buscar_vehiculo_ajax',
            type: 'POST',
            data: json,
            success: function(data){
                let json = JSON.parse(data);
                llamar_tabla(json, value);
            },
            error: function (res){
                console.log("Error: ");
                console.log(res);
            }
        })
    }

    function llamar_tabla(datos, p){
        if(datos.length == 0) {
            Swal.fire({
                title: 'Datos no encontrados',
                text: 'La placa "' + p + '" no ha sido registrada en el sistema o no tiene vehiculos asignados',
                icon: 'warning',
                confirmButtonText: 'Aceptar'
            })
            tabla.bootstrapTable('destroy');
            document.getElementById('ve_h1').innerHTML = "";
            return
        }

        console.log('llamar tabla', datos);
        tabla.bootstrapTable({
            columns: columns,
            data: datos
        })
        document.getElementById('ve_h1').innerHTML = "Vehiculo encontrado";
       //si esta inicializada
        if (tabla.bootstrapTable('getData').length === 0) {
            tabla.bootstrapTable({
                columns: columns,
                data: datos
            });
        } else {
            // actualiza los datos solo si esta inicializada
            tabla.bootstrapTable('load', datos);
        }
    }

</script>