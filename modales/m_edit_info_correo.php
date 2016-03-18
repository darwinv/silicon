<div class="modal fade bs-example-modal-lg modal-conf" data-type="correo"  tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="info-correo">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title ">
					<img src="galeria/img-site/logos/mascota.png" width="50" height="51"><span
						id="" class="marL15">Editar Correo</span>
				</h3>
			</div>
			<form id="usr-act-form-email" action="fcn/f_usuarios.php" method="post"
				class="form-inline">
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-apdp">
						<div class="row">
							<div class="col-xs-12 ">
								<span class="marL10"><i class="fa fa-envelope"></i> Correo</span>
							</div>
							<div
								class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="email" class="form-input noseleccionable"
									id="email" name="email"
									placeholder=" Ingresa tu correo electronico..."
									oncontextmenu="return false" />
							</div>
						</div>
					</section>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary2">Actualizar</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->