<div class="modal fade bs-example-modal-lg modal-conf in" data-type="personal" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="info-personal" name="info-personal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title " >
					<img src="galeria/img-site/logos/mascota.png" width="50" height="51"><span id="usr-reg-title"
						class="marL15">Editar Informaci&oacute;n Personal</span>
				</h3>
			</div>
			<input type="hidden" id="p_id" name="p_id"></input>
			<form id="usr-act-form-nat" action="fcn/f_usuarios.php" method="post" class="form-inline">
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-apdp" 
						 data-step="1" data-type="p" >
						<div class="row">
							<div class="col-xs-12 ">
								<div class="marL10"><i class="fa fa-list-alt"></i>
									Identificaci&oacute;n</div>
							</div>
							<div  class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3 input" >
								<select class="form-select" id="p_tipo" name="p_tipo">
									<option>V</option>
									<option>E</option>
									<option>P</option>
								</select>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-9 col-lg-9 input" >
								<input type="text"
									placeholder="Ingresa el numero de documento..." name="p_identificacion"
									class="form-input" id="p_identificacion">
							</div>
							<div class="col-xs-12">
								<span class="marL10"><i class="fa fa-user"></i> Nombre y
									Apellido</span>
							</div>
							<div class=" form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 input" >
								<input type="text" placeholder="Ingresa tu nombre..." name="p_nombre"
									class=" form-input " id="p_nombre">
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 input" >
								<input type="text" placeholder="Ingresa tu apellido..." name="p_apellido"
									class=" form-input " id="p_apellido">
							</div>
							<div class="col-xs-12">
								<span class="marL10"><i class="fa fa-phone"></i> Telefono</span>
							</div>
							<div class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input " >
								<input type="text"
									placeholder="Ingrese un numero de telefono..." name="p_telefono"
									class=" form-input" id="p_telefono">
							</div>
							<div class="col-xs-12">
								<span class="marL10"><i class="fa fa-map-marker"></i>
									Ubicacion...</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input" >
								<select class="error-select form-select " id="p_estado" name="p_estado">
									<option value="" disabled selected>Seleccione un Estado</option>
								<?php
								$estados = new bd ();
								foreach ( $estados->getDatosBase ( "estados", 1 ) as $estado ) :
									?>
								<option value="<?php echo $estado["id"]; ?>"><?php echo $estado["nombre"]; ?></option>
								<?php endforeach;?>
								</select>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input" >
								<textarea rows="4" cols="" placeholder="Direccion" id="p_direccion" name="p_direccion"
									class="form-textarea"></textarea>
							</div>
						</div>
					</section>					
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary2 btn-usr-act" data-action="act-nat">Actualizar</button>					
				</div>
			</form>		
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->