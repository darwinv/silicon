<div class="modal fade bs-example-modal-lg modal-conf" data-type="pass" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="info-pass">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title " >
					<img src="galeria/img-site/logos/mascota.png" width="50" height="51"><span
						class="marL15">Editar Contrase&ntilde;a</span>
				</h3>
			</div>
			<form id="usr-act-form-pass" action="fcn/f_usuarios.php" method="post" class="form-inline">
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-apdp" >
						<div class="row">
							<div class="col-xs-12 ">
								<span class="marL10"><i class="fa fa-lock"></i> Contrase&ntilde;a</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="password" class="form-input noseleccionable" id="password" name="password_act"
									placeholder=" Ingresa tu actual contrase&ntilde;a..." oncontextmenu="return false"/>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="password" class="form-input noseleccionable" id="password" name="password"
									placeholder=" Ingresa tu nueva contrase&ntilde;a..." oncontextmenu="return false"/>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="password" class="form-input noseleccionable" id="password_val" name="password_val"
									placeholder=" Repite tu nueva contrase&ntilde;a..." oncontextmenu="return false"/>
							</div>
						</div>
					</section>
				</div>
				<div class="modal-footer">
				<button type="submit" class="btn btn-primary2 btn-usr-act btn-usr-act" data-action="act-pass">Actualizar</button>					
				</div>
			</form>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->