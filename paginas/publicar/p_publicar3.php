<?php
if (!headers_sent()) {
	header('Content-Type: text/html; charset=UTF-8');
}
?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
	<div class="contenedor "
	style="margin-top: 5px; z-index: 1; padding-top: 20px; padding-bottom: 30px;">
		<div class="row" style="margin-left: 40px; margin-right: 40px;">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
				<div
				style="padding: 10px; width: 100%; background: #FAFAFA; -webkit-box-shadow: 0px 5px 21px -2px rgba(0, 0, 0, 0.5); -moz-box-shadow: 0px 5px 21px -2px rgba(0, 0, 0, 0.5); box-shadow: 0px 5px 21px -2px rgba(0, 0, 0, 0.5); border: 1px solid #ccc; border-bottom: none;"
				class="t16 ">
					<i class="fa fa-tags marL20"></i> Tu Publicaci&oacute;n
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 vin-blue t14">
				<div class="" style="border: #ccc 1px solid">
					<div  class="row text-left">						
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
							<form id="pub-form-date" method="POST" name="pub-form-date">
								<div style="margin:40px; margin-left: 200px; margin-right: 200px; ">
									<i class="fa fa-check-circle green marL10"></i> Tu publicacion sera
									iniciada
									<div class="input-group marB10">
									
										<span id="calendario" class="input-group-addon"><i class="fa fa-calendar" id="boton-calendario" name="boton-calendario"></i></span>	
										<input id="txtFecha" type="text" class="date-input form-control"name="txtFecha" data-value="<?php echo date("Y-m-d");?>"/>	
										<!--<input id="txtFecha" name="txtFecha" type="date" min="<?php echo date("Y-m-d");?>" max="<?php echo date('Y-m-d', strtotime("+30 days"));?>" value="<?php echo date("Y-m-d");?>"
										class="form-control"
										aria-describedby="inputGroupSuccess3Status">-->
											<div id="date-picker"> </div>
									</div>
									<div class="alert alert-success " role="alert"
									style="width: 100%; margin: 0px;  margin-bottom:5px; padding: 5px; font-size: 12px; ">
										<span class="marL5"><i class="fa fa-info-circle marR5"></i> <b>Informacion: </b> Tu publicacion es totalmente gratis y estara en nuestros listados durante 30 dias...</span>
									</div>
									<p class="t12 orange-apdp marL10 "> &iexcl;Compra y vende lo que quieras! </p>
									<div class="text-right marT10">
										<button class="btn3 btn-primary2 " type="submit" id="btnPublicar" name="btnPublicar">
											Publicar
										</button>
									</div>									
								</div>
							</form>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>