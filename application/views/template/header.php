<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
	<!-- <meta name="google-signin-client_id" content="410063102046-1ff47uqbcftdv1ojluc1b3396skrgv5k.apps.googleusercontent.com"> -->
	<title>Sistema de robos</title>

	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/bootstrap-3.3.7/css/bootstrap.min.css">

	<!-- bootstrapTable -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.2/dist/bootstrap-table.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.2/dist/bootstrap-table.min.css">

	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.2/dist/bootstrap-table.min.js"></script>

	<!--Noty-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/noty/themes/sunset.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/noty/noty.css">

	<!-- Monarch -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/css/monarch.min.css">

	<!-- Ventanilla -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/css/ventanilla.min.css">

	<!-- Favicons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= base_url(); ?>assets/img/icons/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= base_url(); ?>assets/img/icons/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= base_url(); ?>assets/img/icons/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="<?= base_url(); ?>assets/img/icons/apple-touch-icon-57-precomposed.png">
	<link rel="shortcut icon" href="<?= base_url(); ?>assets/img/logotipo-iso.png">

	<link rel="stylesheet" href="../assets/css/separadores.css">

	<style>
    #ve_container{
        margin-top: 2vh;
    }

    #frm_container{
        margin-top: 2vh;
    }
	</style>


</head>
<body>
	<div id="loading">
		<div class="spinner">
			<div class="bounce1"></div>
			<div class="bounce2"></div>
			<div class="bounce3"></div>
		</div>
	</div> <!-- /loading -->

	<div id="ayuda">
		<div class="bg-warning">
			<i class="glyph-icon icon-question-circle"></i> <span>Ayuda</span>
		</div>
	</div> <!-- /ayuda -->

	<div class="top-bar" style="color:white !important">
		<div class="container">
			<div class="elements">
				<div class="b-social">
					
				</div>
				<div class="b-title">
					<p>Sistema de robos - Irapuato</p>
				</div>
				<div class="b-login">
				<?php 
					if(!$login):?> 
					<div class="igob-signin-c" sistema-id="<?= SISTEMA_TOKEN ?>"></div>
				<?php else: ?>	
					<a type="button" href="<?= base_url('seccion/logout')?>" class="btn btn-danger">Salir</a>
				<?php endif ?>
				</div>
			</div> <!-- /.elements -->
		</div> <!-- /.container -->
	</div> <!-- /.top-bar -->

	<?php
		if($login):?> 
			<div class="main-header bg-header wow fadeInDown" id="fixed-nav">
				<div class="container">
					<div class="b-sistema-logotipo">
						<a href="<?= base_url()?>seccion/buscar_vehiculo">
							<?= img("assets/img/digital.png", FALSE, array("width" => "auto", "height" => "60px", "title" => SISTEMA_TEXTO)) ?>
						</a>
					</div>
					<div class="right-header-btn">
						<div id="mobile-navigation">
							<button id="nav-toggle" class="collapsed">
								<span></span>
							</button>
						</div>
					</div>
					<ul class="header-nav">
						<li data-toggle="tooltip" data-placement="bottom" title="Consulatr vehiculo">
							<a href="<?= base_url()?>seccion/tabla_vehiculos">
								<span>Consultar vehiculo</span>
							</a>
						</li>
						<li>
							<a href="#">
								<span>Registrar <i class="glyph-icon icon-angle-down"></i></span>
							</a>
							<ul class="submenu">
								<li>
									<a href="<?= base_url()?>catalogos/marcas"><span>Marcas</span></a>
									<a href="<?= base_url()?>catalogos/colores"><span>Colores</span></a>
									<a href="<?= base_url()?>catalogos/tipos"><span>Tipos</span></a>
								</li>
								<li>
									<a href="<?= base_url()?>secciones/vehiculos"><span>Autos</span></a>
								</li>
								<li>
									<a href="<?= base_url()?>secciones/duenos"><span>Dueños</span></a>
								</li>
								<li>
									<a href="<?= base_url()?>secciones/placas"><span>Placas</span></a>
								</li>
								<li>
									<a href="<?= base_url()?>secciones/propietarios"><span>Propietarios</span></a>
								</li>
								<li>
									<a href="<?= base_url()?>secciones/emplacado"><span>Emplacado</span></a>
								</li>
								<li>
									<a href="<?= base_url()?>secciones/robos"><span>Robos</span></a>
								</li>
								<li>
									<a href="#"><span>Usuarios</span></a>
								</li>
							</ul>
						</li>
						
						
					</ul> <!-- /.header-nav -->
					<ul class="header-nav responsive">
						<li>
							<a href="<?= base_url()?>seccion/enlace1">
								<span>Enlace 1</span>
							</a>
						</li>
						<li>
							<a href="<?= base_url()?>seccion/enlace2">
								<span>Enlace 2</span>
							</a>
						</li>
						<li>
							<a href="<?= base_url()?>seccion/enlace3">
								<span>Enlace 3</span>
							</a>
						</li>
						<li>
							<a href="<?= base_url()?>seccion/enlace4">
								<span>Enlace 4</span>
							</a>
						</li>
					</ul> <!-- /.header-nav.reponsive -->
				</div> <!-- .container -->
			</div> <!-- /.main-header -->
		<?php endif ?>
	<div class="clearfix"></div>

	<script>
		var base_url = '<?= base_url(); ?>';
	</script>

    <main id="content">
