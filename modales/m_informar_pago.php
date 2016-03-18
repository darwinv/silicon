<?php
	include_once "clases/bd.php";
	$bancos=$bd->doFullSelect("bancos");
	$fp=$bd->doFullSelect("formas_pagos");
?>
<div class="modal fade bs-example-modal-lg modal-conf" data-type="comprar-info"  tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="informar-pago">
	<div class="modal-dialog ">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title ">
					<img src="galeria/img/logos/mascota.png" width="50" height="51"><span
						id="" class="marL15">Datos del vendedor</span>
				</h3>
			</div>			
			<div class="modal-body">
				<br>
                <div class="row  tam-modal-formulario ">
					<div class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input " >
						<form id="frm-informar-pago" name="frm-informar-pago">
							<span class="grisO">Fecha del pago</span>
							<input type="date" placeholder="" class=" form-input" id="p_fecha" name="p_fecha">
							<div class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input " >
								<span class="grisO">Forma de pago</span>
								<select placeholder="Seleccione forma de pago" class=" form-input" id="p_forma_pago" name="p_forma_pago">
									<?php
										foreach ($fp as $f => $valor):
											?>
											<option value="<?php echo $valor["id"];?>"><?php echo $valor["nombre"];?></option>
											<?php
										endforeach;
									?>
								</select>
							</div>
							<div class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input " >
								<span class="grisO">Banco</span>
								<select placeholder="Seleccione banco" class=" form-input" id="p_banco" name="p_banco">
									<?php
										foreach ($bancos as $b => $valor):
											?>
											<option value="<?php echo $valor["id"];?>"><?php echo $valor["siglas"];?></option>
											<?php
										endforeach;
									?>
								</select>									
							</div>
							<div class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input " >
								<span class="grisO">Monto</span>
								<input type="number" placeholder="Monto del pago" class=" form-input" id="p_monto" name="p_monto">
							</div>
							<div class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 input " >
								<span class="grisO">Referencia</span>
								<input type="text" placeholder="" class=" form-input" id="p_referencia" name="p_referencia">
							</div>
							<div class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 " >						
								<input type="checkbox" placeholder="" name="" class=" form-input" id="p_datos" name="p_datos"/>
								<label class="grisO">Los mismos datos de facturaci&oacute;n</label>
							</div>							
							
				    </div>                      
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary2">Guardar</button>
					</div>
					</form>
				</div>
		<!-- /.modal-content -->
			</div>
	<!-- /.modal-dialog -->
	</div>
<!-- /.modal -->
</div>
</div>