<?php ?>
<?php include 'modales/m_cropper.php';?>
<div class="modal fade bs-example-modal-lg  modal-update-user" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="usr-update-info">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title " >
					<img src="galeria/img-site/logos/mascota.png" width="50" height="51"><span 
						class="marL15">Actualizar Datos</span>
				</h3>
			</div>
			<img class="hidden" src=""  name="foto-usuario"></img>
			<form id="usr-update-form" action="fcn/f_usuarios.php" method="post" class="form-inline" data-method="update_user" >
			 
				<div class="modal-body marL20 marR20 ">
					<br> 	
					<section class="form-apdp" style="display: none" data-title="Informaci&oacute;n de acceso"
						data-step="2" >
						<div class="row">

							<div class="col-xs-12 ">
								<span class="marL10"><i class="fa fa-male"></i> Seudonimo</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input class=" form-input " id="update_seudonimo" name="update_seudonimo"
									placeholder=" Ingresa un nombre con el que te identificaras en el sitio..." />
							</div>
							<div class="col-xs-12 ">
								<span class="marL10"><i class="fa fa-envelope"></i> Correo</span>
							</div>
							<div class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="email" class="form-input noseleccionable" id="update_email" name="update_email"
									placeholder=" Ingresa correo electronico..." oncontextmenu="return false"/>
							</div> 
							<div class="col-xs-12   ">
								<span class="marL10"><i class="fa fa-lock"></i> Rol de Usuario</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input  ">
								<select class="form-select" id="update_id_rol_select" name="update_id_rol_select"  >
									<option value="1">Super Administrador</option>
									<option value="2">Administrador</option> 
								</select> 
							</div>
						<div class="password_container col-xs-12" >
							<div class="col-xs-12 marT10 btn btn-default talign-left btn-container-password ">
								<span ><i class="fa fa-lock"></i>  Actualizar Contrase&ntildea</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input hidden">
								<input type="password" class="form-input noseleccionable" id="update_password" name="update_password"
									placeholder=" Ingresa contrase&ntilde;a..." oncontextmenu="return false" disabled="disabled"/>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input hidden">
								<input type="password" class="form-input noseleccionable" id="update_password_val" name="update_password_val"
									placeholder=" Repite la contrase&ntilde;a..." oncontextmenu="return false" disabled="disabled"/>
							</div>
							
						</div>
						 
							
						</div>
					</section>
				</div>
				<div class="modal-footer">
				<button id="update_usr-reg-submit" type="button" class="btn btn-primary2">Actualizar</button>	
								
				</div>
			</form>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->