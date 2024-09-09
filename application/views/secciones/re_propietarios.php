<div class="container">
    <div class="container text-center" id="ve_container">
        <h1>
            Propietarios
        </h1>
    </div>

    <button onclick="traer_catalogos()" class="btn btn-success" style="margin-bottom: 1vh">
        Agregar propietarios
    </button>

    <div class="container ve_container">
        <table id="tableV" data-url="<?= base_url()?>secciones/Propietarios/cargar_propietarios"
                    data-pagination="true"
                    data-side-pagination="server"
                    data-page-size="10"
                    data-page-list=[10, 20]
                    data-query-params="queryParams"
        >
            <thead>
                <tr>
                    <th data-field="num_serie">Numero de serie</th>
                    <th data-field="nombre">Nombre</th>
                    <th data-field="apellido_p">Apellido paterno</th>
                    <th data-field="apellido_p">Apellido materno</th>
                    <th data-field="actual">Actual</th>
                    <th data-field="fecha_inicio">Fecha de inicio</th>
                    <th data-field="fecha_termino">Fecha de termino</th>
                    <th data-field="fecha_registro">Fecha de registro</th>
                    <th data-field="id" data-formatter="acciones" data-align="center">Acciones</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

</div>

<div class="modal" data-backdrop="static" id="modalForm">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #1C314F;">
				<h4 class="modal-title" style="color: white;"  id="modalFormLabel">Agregar propietarios</h4>
			</div>
			<div class="modal-body" id="cb-datos-registro">
                <form action="<?php base_url();?>agregar_propietarios" id="frm_container" method="POST" data-parsley-validate="">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="num_serie"><span class="text-danger">*</span>Numero de serie</label>
                            <select class="form-control" id="num_serie" name="num_serie" onchange="datos_num_serie()" required>

                                <!-- <option value="0">
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
                                ?> -->
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="dueno"><span class="text-danger">*</span>Dueño</label>
                            <select name="dueno" id="dueno" class="form-control" required>

                                <!-- <option value="0"><span class="text-danger">*</span>Seleccione un dueño</option>
                                <?php
                                    foreach($duenos['duenos'] as $du){
                                        echo '
                                            <option value="'.$du->id.'">'.$du->nombre.' '.$du->apellido_p.' '.$du->apellido_m.'</option>
                                        ';
                                    }
                                ?> -->
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                                    <label for="actual"><span class="text-danger">*</span>Actualmente es el dueño</label>
                                    <select name="actual" id="actual" class="form-control" onchange="habilitar_fecha()" required>
                                        <option value="0">No</option>    
                                        <option value="1">Si</option>
                                    </select>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="fecha_i"><span class="text-danger">*</span>Fecha de inicio</label>
                            <input type="date" name="fecha_i" id="fecha_i" class="form-control" data-parsley-max-hoy required>
                        </div>
                        <div class="form-group col-md-6">
                            <label id="fecha_t_l" for="fecha_t">Fecha de termino</label>
                            <input type="date" name="fecha_t" id="fecha_t" class="form-control" data-parsley-max-hoy>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <button type="submit" id="btn_duenos" class="btn btn-success" ><i class=" glyph-icon icon-save"></i> Registrar</button>
                        </div>
                    </div>
                </form>
			</div>
			<div class="modal-footer">
                
				<button id="btn_cancel" data-dismiss="modal" class="btn btn-danger" onclick ="cancelar()"><i class=" glyph-icon icon-times"></i> Cancelar</button>
			</div>
		</div>
	</div>
</div>

<div class="container text-center" id="ve_container">
</div>

<script src="../assets/js/propietarios.js"></script>