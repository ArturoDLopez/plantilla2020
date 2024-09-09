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



<script src="../assets/js/buscar_vehiculo.js">
    
   
</script>