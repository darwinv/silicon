<?php ?>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="usr-log2">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title">
					<img src="galeria/img-site/logos/mascota.png" width="50" height="51"><span
						class="marL15">Ingresa</span>
				</h3>
			</div>
			<form id="usr-log-form" action="fcn/f_usuarios.php" method="post" class="form-inline">
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-apdp"
						data-title="Informaci&oacute;n Personal" data-step="1" data-type="p" >
						<div class="row">
							
							<div class="col-xs-12">
								<span class="marL10"><i class="fa fa-user"></i> Usuario</span>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 input" >
								<input type="text" placeholder="Ingresa tu seudonimo o correo" name="usuario"
									class=" form-input " id="usuario">
							</div>
							<div class="col-xs-12">
								<span class="marL10"><i class="fa fa-lock"></i> Contrase&ntilde;a</span>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 input" >
								<input type="password" placeholder="Ingresa tu contrase&ntilde;a" name="password"
									class=" form-input " id="password">
							</div>
						</div>
					</section>	
				</div>
				<div class="modal-footer">
					<a href="#">&iquest;Olvidaste la contrase&ntilde;a?</a><button type="submit" class="btn btn-primary2 marL30">Continuar</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

