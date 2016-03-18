<div class="modal fade bs-example-modal-lg modal-conf in" data-type="empresarial" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="info-empresarial">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title " >
					<img src="galeria/img-site/logos/mascota.png" width="50" height="51"><span 
						class="marL15">Editar Informaci&oacute;n Empresarial</span>
				</h3>
			</div>
			<input type="hidden" id="p_id" name="p_id"></input>
			<form id="usr-act-form-jur" action="fcn/f_usuarios.php" method="post" class="form-inline">
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-apdp">
						<div class="row">
							<div class="col-xs-12 ">
								<span class="marL10"><i class="fa fa-list-alt"></i>
									Identificaci&oacute;n</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3 input" >
								<select class=" form-select" id="e_tipo" name="e_tipo">
									<option>V</option>
									<option>E</option>
									<option>P</option>
									<option>J</option>
									<option>G</option>						
								</select>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-9 col-lg-9 input" >
								<input type="text"
									placeholder="Ingresa el numero de documento..." name="e_rif"
									class="form-input " id="e_rif" >
							</div>
							<div class="col-xs-12">
								<span class="marL10"><i class="fa fa-industry"></i> Nombre de la empresa</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 input">
								<input type="text" placeholder="Ingresa la razon social..." name="e_razonsocial"
									class=" form-input " id="e_razonsocial">
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 input">
								<select 
									class=" form-select " id="e_categoria" name="e_categoria">
									<option value="" disabled selected>Area de tu empresa</option>
									<?php								
							$areas = new bd ();
							foreach ( $estados->getDatosBase ( "categorias_juridicos" ) as $area ) :
									?>
								<option value="<?php echo $area["id"]; ?>"><?php echo $area["nombre"]; ?></option>
								<?php endforeach;?>
									</select>
							</div>
							<div class="col-xs-12">
								<span class="marL10"><i class="fa fa-phone"></i> Telefono</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="text"
									placeholder="Ingrese un numero de telefono..." name="e_telefono"
									class=" form-input" id="e_telefono">
							</div>
							<div class="col-xs-12">
								<span class="marL10"><i class="fa fa-map-marker"></i>
									Ubicacion...</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<select class=" form-select " id="e_estado" name="e_estado">
									<option value="" disabled selected>Seleccione un Estado</option>
								<?php								
								$estados = new bd ();
								foreach ( $estados->getDatosBase ( "estados", 1 ) as $estado ) :
									?>
								<option value="<?php echo $estado["id"]; ?>"><?php echo $estado["nombre"]; ?></option>
								<?php endforeach;?>
								</select>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<textarea rows="4" cols="" placeholder=" Direccion" id="e_direccion" name="e_direccion"
									class="form-textarea"></textarea>
							</div>
						</div>
					</section>					
				</div>
				<div class="modal-footer">
				<button type="submit" class="btn btn-primary2 btn-usr-act" data-action="act-jur">Actualizar</button>					
				</div>
			</form>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->