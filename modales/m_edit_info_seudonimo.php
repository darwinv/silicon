<div class="modal fade bs-example-modal-lg modal-conf" data-type="seudonimo" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="info-seudonimo">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title " >
					<img src="galeria/img-site/logos/mascota.png" width="50" height="51"><span 
						class="marL15">Editar Seudonimo</span>
				</h3>
			</div>
			<form id="usr-act-form-seudonimo" action="fcn/f_usuarios.php" method="post" class="form-inline">
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-apdp">
						<div class="row">

							<div class="col-xs-12 ">
								<span class="marL10"><i class="fa fa-male"></i> Seudonimo</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input class=" form-input " id="seudonimo" name="seudonimo"
									placeholder=" Ingresa un nombre con el que te identificaras en el sitio..." />
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