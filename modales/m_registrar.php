<?php include 'modales/m_cropper.php';?>
<div class="modal fade bs-example-modal-lg modal-conf-user" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="usr-reg">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title " >
					<img src="galeria/img-site/logos/mascota.png" width="50" height="51"><span id="usr-reg-title"
						class="marL15">Inscribete</span>
				</h3>
			</div>
			<img class="hidden" src="" id="foto-usuario" name="foto-usuario"></img>
			<form id="usr-reg-form" action="fcn/f_usuarios.php" method="post" class="form-inline" data-method="new" >
			<input type="hidden" id="type" name="type"/>
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-apdp" style="display: none"
						data-title="Informaci&oacute;n Personal" data-step="1" data-type="p" >
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
					<section class="form-apdp" style="display: none"
						data-title="Informaciï&iquest;½n Empresarial" data-step="1" data-type="e"  >
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
									<option>C</option>
								</select>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-9 col-lg-9 input" >
								<input type="text"
									placeholder="Ingresa el numero de documento..." name="e_rif"
									class="form-input " id="e_rif">
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
					<section class="form-apdp" style="display: none" data-title="Informaci&oacute;n de acceso"
						data-step="2" >
						<div class="row">

							<div class="col-xs-12 ">
								<span class="marL10"><i class="fa fa-male"></i> Seudonimo</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input class=" form-input " id="seudonimo" name="seudonimo"
									placeholder=" Ingresa un nombre con el que te identificaras en el sitio..." />
							</div>
							<div class="col-xs-12 ">
								<span class="marL10"><i class="fa fa-envelope"></i> Correo</span>
							</div>
							<div class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="email" class="form-input noseleccionable" id="email" name="email"
									placeholder=" Ingresa tu correo electronico..." oncontextmenu="return false"/>
							</div>
							
							<div class="col-xs-12 password_container pad-left0 pad-right0">
								<div class="col-xs-12  ">
									<span class="marL10 title-container-password "><i class="fa fa-lock"></i> Contrase&ntilde;a</span>
								</div>
							 
							 
								<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input ">
									<input type="password" class="form-input noseleccionable" id="password" name="password"
										placeholder=" Ingresa tu contrase&ntilde;a..." oncontextmenu="return false"/>
								</div>
								<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input ">
									<input type="password" class="form-input noseleccionable" id="password_val" name="password_val"
										placeholder=" Repite tu contrase&ntilde;a..." oncontextmenu="return false"/>
								</div>
							</div>
							<div class="col-xs-12  hidden">
								<span class="marL10"><i class="fa fa-user "></i> Rol de Usuario</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input hidden">
								<select class="form-select" id="id_rol_select" name="id_rol" disabled="disabled">
									<option value="1">Super Administrador</option>
									<option value="2">Administrador</option> 
								</select>								
							</div>
							<div class="col-xs-12 form-password-update pad-left0 pad-right0">
								 
							</div>
							<input type="hidden" id="ingresoUsuario" name="ingresoUsuario" value="1" />
							
							<input type="hidden" id="id_rol_hidden" name="id_rol" value="3" />					
						</div>
					</section>
				</div>
				<div class="modal-footer">
				<button id="usr-reg-submit" type="button" class="btn btn-primary2">Continuar</button>	
								
				</div>
			</form>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->