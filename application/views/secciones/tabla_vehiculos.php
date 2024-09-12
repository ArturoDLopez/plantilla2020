<style>
    h1{
        color: #ffff !important
    }

    .centrado{
        text-align: center
    }

</style>

<div class="modal" data-backdrop="static" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFormLabel">Reporte de robos</h5>
      </div>
      <div class="modal-body">
        <table id="tablaR" data-url="">

        </table>
      </div>
      <div class="modal-footer">
                        
        <button type="button" id="btn_cancel" class="btn btn-danger" data-dismiss="modal">Cancelar</button>

      </div>
    </div>
  </div>
</div>

<section id="bienvenida">
			<div class="wrapper">
				<div class="outer-content"></div>
				<div class="inner-content">
					<div class="container text-center">   
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

<script src="../../assets/js/buscar_vehiculo.js"></script>