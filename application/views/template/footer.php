    </main> <!-- /main -->

    <footer class="page-footer font-small special-color-dark pt-4 footer">
		<div class="container">
			<div class="row" style="padding:40px;">
				<div class="col-xs-12 col-sm-12 col-md-6">
					<div class="b-image">
						<img src="<?= base_url(); ?>assets/img/gobierno_municipal_logotipo.png" width="45%"></img>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-6">
					<div class="b-ubicacion">
						<h4 class="text-center">Dirección General de Tecnologías de la Información e Innovación</h4>
						<p><i class="glyphicon glyphicon-map-marker"></i> Hidalgo #77, Zona Centro, Irapuato, Gto. México</p>
						<p><i class="glyphicon glyphicon-earphone"></i> 01 (462) 60 69 999 Ext. 2021</p>
					</div>
				</div>
			</div> <!-- /.row -->

			<div class="row">
				<div class="col-xs-12">
					<div class="b-sistema">
						<h4><?= SISTEMA_NOMBRE; ?></h4>
						<p><?= SISTEMA_TEXTO; ?></p>
					</div>
				</div>
			</div> <!-- /.row -->
		</div>
		<div class="footer-copyright">
			<div class="container" align="center">
				© Irapuato | Ayuntamiento 2021 - 2024
			</div> <!-- /.container -->
		</div> </div> <!-- /.footer-copyright -->
	</footer> <!-- /.page-footer -->

	<script type="text/javascript">
		window.onload = function () {
			setTimeout(function () {
				$('#loading').fadeOut(400, "linear");
			}, 300);
		};

		function alAutenticar(igob_user) {
            document.location = '<?= base_url(); ?>';
        }
	</script>

	<!-- Modernizr -->	
	<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/js-core/modernizr.js"></script>

	<!-- jQuery 2.2.4 -->
	<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/jquery-2.2.4/jquery.min.js"></script>

	<!-- Bootstrap 3.3.7 -->
	<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/bootstrap-3.3.7/js/bootstrap.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script type="text/JavaScript" src = "https://cdn.jsdelivr.net/npm/lodash@4.17.20/lodash.min.js"></script>

	<!-- Popper -->
	<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/bootstrap-3.3.7/js/popper.min.js"></script>

	<!-- Skrollr 0.6.26 -->
	<script type="text/javascript" src="<?= base_url(); ?>assets/scss/_monarch/widgets/skrollr/skrollr.js"></script>

	<!-- HC-Sticky 1.2.43 -->
	<script type="text/javascript" src="<?= base_url(); ?>assets/scss/_monarch/widgets/sticky/sticky.js"></script>

	<!-- WOW -->
	<script type="text/javascript" src="<?= base_url(); ?>assets/scss/_monarch/widgets/wow/wow.js"></script>

	<!-- Google Platform -->
	<script src="https://apis.google.com/js/platform.js" async defer></script>

	<!-- Auth -->
	<script src="<?= URL_WEBSERVICE; ?>js/auth.js" async defer></script>
	
	<!-- Functions -->
	<script src="<?= base_url(); ?>assets/js/js-init/functions.js"></script>
	<script src="<?= base_url(); ?>assets/js/js-init/layout.js"></script>
</body>
</html>