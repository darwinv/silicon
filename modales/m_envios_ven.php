<?php
	include_once "clases/bd.php";
	$bd=new bd();
	$agencias=$bd->doFullSelect("agencias_envios");
	$maximo=3;	
?>
<div class="modal fade bs-example-modal-lg modal-conf" data-type="comprar-info"  tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="envios-ven">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title ">
					<img src="galeria/img/logos/mascota.png" width="50" height="51"><span
						id="" class="marL15">Envios</span>
				</h3>
			</div>
			
				<div class="modal-body">

<br>
                    <div class=" row mar-pagos-ven" id="ajaxcontainer3" name="ajaxcontainer3">      
                    	        	
					</div>					                                            
                
                    <br>
                    <div class="row mar-envios" id="frm-envios" name="frm-envios" style="display:none;">
                    	<form id="frm-reg-envios" name="frm-reg-envios" action="">
                       	<div style="background:#00468E; color: #FFF; border-radius: 5px; display: block" class="pad5 marB10 text-center sombra-div marL5 marR5"><span class="">Ingresa los datos de la gu&iacute;a</span></div>                        	
                       	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left t12 '>
                       		<div id="date-picker"> </div>
	                       	<input id="p_fecha" name="p_fecha" type="date" placeholder="Fecha de envio" class="form-input marB10" id="">
                       	</div>
                       	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left t12 '>                       	
      	                 	<input id="p_cantidad" name="p_cantidad" type="number" placeholder=" Cantidad" name="" class="form-input marB10" id="" min=1 max=<?php echo $maximo;?>>
                       	</div>
                       	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left t12 '>    
        	               	<select class="form-select marB10" id="p_agencia" name="p_agencia">
									<option>Seleccione</option>
									<?php
									foreach($agencias as $a=>$valor):
										?>
										<option value="<?php echo $valor["id"];?>"><?php echo $valor["nombre"];?></option>
										<?php
									endforeach
									?>
							</select>
						</div>
						<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left t12 '>                       	
                	       	<input id="p_numero" name="p_numero" type="text" placeholder=" Numero de gu&iacute;a" name="" class="form-input marB10" id="">
                       	</div>
                       	<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10">
							<textarea id="p_direccion" name="p_direccion" rows="3" cols="" placeholder=" Direccion de envio" id="" name=""
									class="form-textarea"></textarea>
						</div>
						<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left t12 '>                       	
                       		<input id="p_monto" name="p_monto" type="text" placeholder=" Monto del envio aprox. (Opcional)" name="" class="form-input marB10" id="">
                       	</div> 
                 	
                     </div>
					<div class="modal-footer">					
						<button id="btn-agregar-guia" name="btn-agregar-guia" class="btn btn-default"><span>Agregar Gu&iacute;a</span></button>
						<button id="btn-guardar2" name="btn-guardar2" class="btn btn-primary2" data-dismiss="modal">Continuar</button>
                       	<button id="btn-guardar-guia" name="btn-guardar-guia" class="btn btn-primary2 hidden"><span>Guardar Gu&iacute;a</span></button>						
					</div>
                       	</form>					
				</div>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->