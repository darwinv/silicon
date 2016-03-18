<?php include_once 'modales/m_cropper.php';?>
<div class="modal fade bs-example-modal-lg modal-conf-user" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="usr-reg-admin">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title " >
					<img src="galeria/img-site/logos/mascota.png" width="50" height="51"><span id="usr-reg-title-admin"
						class="marL15">Registrar administrador</span>
				</h3>
			</div>
			<!--<img class="hidden" src="" id="foto-usuario" name="foto-usuario"></img>-->
			<form id="usr-reg-form-admin" action="fcn/f_usuarios.php" method="post" class="form-inline" data-method="admin_reg_user" >
			 <input type="hidden" id="type_admin" name="type_admin"/>
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-apdp" data-title="Informaci&oacute;presarial" data-step="1" data-type="e"  >
						<div class="row">
							<div class="col-xs-12 ">
								<div class="marL10"><i class="fa fa-list-alt"></i>
									Identificaci&oacute;n</div>
							</div>
							<div  class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3 input" >
								<select class="form-select" id="p_tipo_admin" name="p_tipo_admin">
									<option>V</option>
									<option>E</option>
									<option>P</option>
								</select>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-9 col-lg-9 input" >
								<input type="text"
									placeholder="Ingresa el numero de documento..." name="p_identificacion_admin"
									class="form-input" id="p_identificacion_admin">
							</div>
							<div class="col-xs-12">
								<span class="marL10"><i class="fa fa-user"></i> Nombre y
									Apellido</span>
							</div>
							<div class=" form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 input" >
								<input type="text" placeholder="Ingresa tu nombre..." name="p_nombre_admin"
									class=" form-input " id="p_nombre_admin">
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 input" >
								<input type="text" placeholder="Ingresa tu apellido..." name="p_apellido_admin"
									class=" form-input " id="p_apellido_admin">
							</div>
							
							
							
							<div class="col-xs-12">
								<span class="marL10"><i class="fa fa-phone"></i> Telefono</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="text"
									placeholder="Ingrese un numero de telefono..." name="e_telefono_admin"
									class=" form-input" id="e_telefono_admin">
							</div>
							<div class="col-xs-12">
								<span class="marL10"><i class="fa fa-map-marker"></i>
									Sambil</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<select class=" form-select " id="e_estado_admin" name="e_estado_admin">
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
								 
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<textarea rows="4" cols="" placeholder=" Direccion del Local" id="e_direccion_admin" name="e_direccion_admin"
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
								<input class=" form-input " id="seudonimo_admin" name="seudonimo_admin"
									placeholder=" Ingresa un nombre con el que se identificara en el sitio..." />
							</div>
							<div class="col-xs-12 ">
								<span class="marL10"><i class="fa fa-envelope"></i> Correo</span>
							</div>
							<div class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="email" class="form-input noseleccionable" id="email_admin" name="email_admin"
									placeholder=" Ingresa correo electronico..." oncontextmenu="return false"/>
							</div>
							
							
								<div class="col-xs-12  ">
									<span class="marL10 title-container-password "><i class="fa fa-lock"></i> Contrase&ntilde;a</span>
								</div>
								<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input ">
									<input type="password" class="form-input noseleccionable" id="password_admin" name="password_admin"
										placeholder=" Ingresa contrase&ntilde;a..." oncontextmenu="return false"/>
								</div>
								<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input ">
									<input type="password" class="form-input noseleccionable" id="password_val_admin" name="password_val_admin"
										placeholder=" Repite la contrase&ntilde;a..." oncontextmenu="return false"/>
								</div>
											 
							<div class="col-xs-12  ">
								<span class="marL10"><i class="fa fa-user "></i> Rol de Usuario</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input ">
								<select class="form-select" id="id_rol_admin" name="id_rol_admin" >
									<option value="1">Super Administrador</option>
									<option value="2">Administrador</option> 
								</select>								
							</div>
							 
							 
							
						</div>
					</section>
				</div>
				<div class="modal-footer">
				<button id="usr-reg-submit-admin" type="button" class="btn btn-primary2">Continuar</button>	
								
				</div>
			</form>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->