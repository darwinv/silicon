<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="info-social">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title " >
					<img src="galeria/img-site/logos/mascota.png" width="50" height="51"><span 
						class="marL15">Editar Informaci&oacute;n Social</span>
				</h3>
			</div>
			<form id="usr-act-form-social" action="fcn/f_usuarios.php" method="post" class="form-inline">
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-apdp">
						<div class="row">
							<div class="col-xs-12 ">
								<span class="marL10"><i class="fa fa-male"></i> Algo sobre mi :</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<textarea id="descripcion" name="descripcion" rows="4"  cols="" placeholder="Cuentame algo sobre ti..."
									class="form-textarea-foto" ></textarea>
							</div>
							<div class="col-xs-12 ">
								<span class="marL10"><i class="fa fa-globe"></i> Sitio Web</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="text" class=" form-input " id="website" name="website"
									placeholder="Agrega tu sitio Web" />
							</div>
							<div class="col-xs-12 ">
								<span class="marL10"><i class="fa fa-facebook"></i> Facebook</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="text" class=" form-input " id="facebook" name="facebook"
									placeholder=" Agrega tu Facebook" />
							</div>
							<div class="col-xs-12 ">
								<span class="marL10"><i class="fa fa-twitter"></i> Twitter</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="text" class="form-input " id="twitter" name="twitter"
									placeholder=" Agrega tu Twitter" />
							</div>
						</div>
					</section>	
				</div>
				<div class="modal-footer">
				<button id="btn-social-act" type="button" class="btn btn-primary2 marT20">Actualizar</button>					
				</div>
			</form>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->