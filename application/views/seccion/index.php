		<section id="bienvenida">
			<div class="wrapper">
				<div class="outer-content"></div>
				<div class="inner-content">
					<div class="container text-center">
						<div class="box">
							<form action="<?= base_url('seccion/buscar_vehiculo'); ?>" method="POST">
								<div class="form-group">
									<label for="" >
										<h2 class="text-primary">
											Buscar vehiculo por placa
										</h2>
									</label>
									<div class=''>
										<input name="placa" type="text" class="form-control" id="placa" placeholder="Escriba su placa...">
									</div>
								</div>
								<div class="">
									<button class="btn btn-primary" onclick="buscar()">
										Buscar
									</button>
								</div>
							</form>
							
						</div>
					</div>
				</div>
				
			</div>
		</section> <!-- /#bienvenida -->

		
		<script src="assets\js\buscar_vehiculo.js"></script>