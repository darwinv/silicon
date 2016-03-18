<?php include_once 'modales/m_cropper.php';?>
<div class="modal fade bs-example-modal-lg modal-edit-proveedor" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="edit-prov">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title " >
					<img src="galeria/img-site/logos/mascota.png" width="50" height="51"><span id="title-modal-prov"
						class="marL15">Actualizar Proveedor</span>
				</h3>
			</div>
			<!--<img class="hidden" src="" id="foto-usuario" name="foto-usuario"></img>-->
			<form action="paginas/proveedor/fcn/f_proveedor.php" data-method="update" id="edit-prov-form" class="form-proveedor edit-prov-form" method="post"  >			
				<div class="modal-body marL20 marR20 ">
					<br>
					<section class="form-apdp" data-title="Informaci&oacute;n del Proveedor" data-step="1"  >
							<div class="col-xs-12 ">
								<div class="marL10"><i class="fa fa-list-alt"></i>
									Identificaci&oacute;n</div>
							</div>
							<div  class="col-xs-12 col-sm-12 col-md-3 col-lg-3 input" >
								<select class="form-select" id="prov_tipo" name="prov_tipo">
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
									placeholder="Ingresa el numero de documento..." name="prov_documento"
									class="form-input" id="prov_documento">
							</div>
							<div class="col-xs-12">
								<span class="marL10"><i class="fa fa-user"></i> Nombre </span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input" >
								<input type="text" placeholder="Ingresa tu nombre..." name="prov_nombre"
									class=" form-input " id="prov_nombre">
							</div>
							<div class="col-xs-12">
								<span class="marL10"><i class="fa fa-phone"></i> Telefono</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="text"
									placeholder="Ingrese un numero de telefono..." name="prov_telefono"
									class=" form-input" id="prov_telefono">
							</div>
							<div class="col-xs-12 ">
								<span class="marL10"><i class="fa fa-envelope"></i> Correo</span>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<input type="email" class="form-input noseleccionable" id="prov_email" name="prov_email"
									placeholder=" Ingresa correo electronico..." oncontextmenu="return false"/>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
								<textarea rows="4" cols="" placeholder=" Direccion del Proveedor" id="prov_direccion" name="prov_direccion"
									class="form-textarea"></textarea>
							</div>
						 
						
					</section>			
					<section class="form-apdp" style="display: none" data-title="Informaci&oacute;n Bancaria" data-step="2" >
						<div class="row">
							
								<div class="col-xs-7 ">
									<div class="marL10"><i class="fa fa-list-alt"></i>
										Informaci&oacute;n de Bancos</div>
								</div>
								<div class="col-xs-5 ">
									<div class="text-right pad-right5">
										<span class="diff_titular">Usar un titular distinto</span><input class="diff_titular_checkbox" type="checkbox" id="diff_titular" name="diff_titular" />
									</div>
								</div>
							
								<!--DATOS EN CASO DE SER DIFERENTE EL TITULAR BAJO CLASE diff-titular-field-->
								
									<div  class="form-group diff-titular-field col-xs-12 col-sm-12 col-md-3 col-lg-3 input" >
										<select disabled="disabled" class="form-select" id="prov_tipo_titular" name="prov_tipo_titular">
											<option>V</option>
											<option>E</option>
											<option>P</option>
											<option>J</option>
											<option>G</option>
											<option>C</option>
										</select>
									</div>
									<div class="form-group diff-titular-field col-xs-12 col-sm-12 col-md-9 col-lg-9 input" >
										<input disabled="disabled" type="text"
											placeholder="Ingresa el numero de documento..." name="prov_documento_titular"
											class="form-input" id="prov_documento_titular">
									</div>
									<div class="col-xs-12 diff-titular-field">
										<span class="marL10"><i class="fa fa-user"></i> Nombre </span>
									</div>
									<div class="form-group diff-titular-field col-xs-12 col-sm-12 col-md-12 col-lg-12 input" >
										<input disabled="disabled" type="text" placeholder="Ingresa tu nombre..." name="prov_nombre_titular"
											class=" form-input " id="prov_nombre_titular">
									</div>
									<div class="col-xs-12 diff-titular-field">
										<span class="marL10"><i class="fa fa-envelope"></i> Correo</span>
									</div>
									<div class="form-group diff-titular-field col-xs-12 col-sm-12 col-md-12 col-lg-12 input">
										<input disabled="disabled" type="email" class="form-input noseleccionable" id="prov_email_titular" name="prov_email_titular"
											placeholder=" Ingresa correo electronico..." oncontextmenu="return false"/>
									</div>
									<div class="col-xs-12 mar10">										
									</div>
								
								<!------------------------------------------------------------------------>
							
							 
						    <!-- The option field template containing an option field and a Remove button -->
						    <div class="form-group hide " id="optionTemplate">
						        <div class="form-group col-xs-12 col-sm-8 col-md-7 col-lg-7 input marT10" >								 
									<select disabled="disabled" class="form-select" id="prov_banco" name="prov_banco[]">
										<option value="" disabled selected >Seleccione un Banco</option>
										<option  >Seleccione un Banco</option>
									<?php
									foreach ($bancos as $banco ) :
										?>
									<option value="<?php echo $banco["id"]; ?>"><?php echo $banco["nombre"]; ?></option>
									<?php endforeach;?> 
									</select>								 
								</div>
								<div class="form-group col-xs-12 col-sm-4 col-md-5 col-lg-5 input marT10" >
									<select disabled="disabled" class="form-select" id="prov_tipo_banco" name="prov_tipo_banco[]">
										<option value="" disabled selected>Tipo de Cuenta</option>	 
										<?php
											foreach ($tipos_cuentas as $tipos ) :
												?>
											<option value="<?php echo $tipos["id"]; ?>"><?php echo $tipos["nombre"]; ?></option>
										<?php endforeach;?> 
									</select>								 
								</div>
								<div class="form-group col-xs-11 col-sm-11 col-md-11 col-lg-11 input" >
									<input disabled="disabled" maxlength="20" type="text"
										placeholder="Ingrese solo numeros sin caracteres extraños" name="prov_nro_cuenta[]"
										class="form-input" id="prov_nro_cuenta">
								</div>					
						        <div class="col-xs-1 pad-left0">
						            <button type="button" class="btn btn-default removeButton t12"><i class="fa fa-minus"></i></button>
						        </div>
						    </div>
						</div>
					</section>
				</div>
				<div class="modal-footer">
				<button id="edit-prov-submit" type="button" class="btn btn-primary2 btn-prov-submit">Next</button>
								
				</div>
			</form>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->