<script>
	function copiarPortaPapeles(id_elemento){
	 // Crea un campo de texto "oculto"
  	var aux = document.createElement("input");
	  // Asigna el contenido del elemento especificado al valor del campo
  	aux.setAttribute("value", document.getElementById(id_elemento).innerHTML);
  	// Añade el campo a la página
  	document.body.appendChild(aux);
  	// Selecciona el contenido del campo
  	aux.select();
  	// Copia el texto seleccionado
  	document.execCommand("copy");
  	// Elimina el campo de la página
  	document.body.removeChild(aux);
	}
</script>
<div class="contenedor" style="margin-top: 25px">
			<div class="row mar20">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pad20 marB10" style="background: #f5f5f5;  border: solid 1px #ccc;">		
						<div class=" t22 ">
							<i class="fa fa-shopping-cart"></i>  Detalle de la venta <span class="opacity"># <?php echo $_GET["id"];?></span>
							<span class="pull-right t14"><a href="javascript:history.back(-1);">Volver a mis ventas</a></span>
						</div>
						
					</div>
					<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 pad20 marB10" style="background: #f5f5f5;  border: solid 1px #ccc;">
						
						<a href="detalle.php?id=<?php echo $publicacion->id;?>"><img src="<?php echo $publicacion->getFotoPrincipal();?>" class="center-block" width="200px" height="200px" style="border: solid 1px #ccc"  /></a>
						<br>
						<br>
						<a href="detalle.php?id=<?php echo $publicacion->id;?>"><?php echo $publicacion->titulo;?></a>
						<br>
						<span class="red">Bs <?php echo $publicacion->getMonto();?></span> x <span class="grisO"><?php echo $venta->getAtributo("cantidad");?> und</span>
						<br>
						<span class="grisC">Fecha de compra: <?php echo date("d-m-Y",strtotime($venta->getAtributo("fecha")));?></span>
						<br>
						<br>
						<span> <b>Comprador</b></span>
						<br>
						<span><?php echo $comprador->a_seudonimo;?></span>
						<br>
						<span><?php echo $comprador->getNombre();?></span>
						<br>
						<span class="grisC" id="span_email" name="span_email"><?php echo $comprador->a_email;?></span> &nbsp;<i class="fa fa-files-o t10 pointer" onClick="copiarPortaPapeles('span_email');"></i>
						<br>
						<?php echo $comprador->u_telefono;?>
						<br>
						<br>
						<span><i class="fa fa-comment grisC"></i> &nbsp; <a id="ver-preguntas" name="ver-preguntas" style="cursor: pointer;"> Ver Preguntas de la venta</a></span>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 ">
						<div class="mar10" id="lista-pagos" data-id="<?php echo $_GET["id"];?>" data-pub="<?php echo $publicacion->id;?>">
							<?php
							$statusPago=$venta->getStatusPago();
							switch($statusPago){
								case "Pago pendiente":
									$claseColor="naranja-apdp";
									break;
								case "Pago rechazado":
									$claseColor="rojo-apdp";
									break;
								case "Pago verificado":
									$claseColor="verde-apdp";
									break;
								case "Pago incompleto":
									$claseColor="verde-apdp";
									break;
							}
							$statusEnvio=$venta->getStatusEnvio();
							switch($statusEnvio){
								case "Envio pendiente":
									$claseColor2="rojo-apdp";
									break;
								case "Envio en camino":
									$claseColor2="naranja-apdp";
									break;
								case "Enviado":
									$claseColor2="verde-apdp";
									break;
							}
							?>
							<div class="t18 negro marB10 marL5">Pagos <span class="pull-right t16 marR5"><i class="fa fa-credit-card <?php echo $claseColor;?>"></i> <?php echo $statusPago;?></span></div>
							
								<table class="table   " >
									<tr style="background: #ACACAC; color: #FFF;">
										<td align="center"><b>Fecha</b></td>
										<td align="center"><b>Forma de pago</b></td>
										<td align="center"><b>Banco</b></td>
										<td align="center"><b>Monto</b></td>
										<td align="center"><b>Referencia</b></td>
										<td align="center"><b>Status</b></td>
									</tr>
									<?php
									$listaPagos=$venta->getPagos();
									$ac=0;
									if($listaPagos):
										foreach ($listaPagos as $l => $valor) :	
											switch($valor["status_pago"]){
												case "1":
													$titulo1="Pendiente";
													$titulo2="Verificar";
													$titulo3="Rechazar";
													$texto1="Pendiente";
													$clases1="fa fa-clock-o naranja-apdp";
													$texto2="Verificado";
													$clases2="fa fa-thumbs-o-up verde-apdp";
													$texto3="Rechazado";
													$clases3="fa fa-remove rojo-apdp";					
													break;					
												case "2":
													$titulo1="Verificado";
													$titulo2="Pendiente";
													$titulo3="Rechazar";				
													$texto1="Verificar";
													$clases1="fa fa-thumbs-o-up verde-apdp";
													$texto2="Pendiente";
													$clases2="fa fa-clock-o naranja-apdp";
													$texto3="Rechazado";
													$clases3="fa fa-remove rojo-apdp";
													$ac+=$valor["monto"];									
													break;
												case "3":
													$titulo1="Rechazar";
													$titulo2="Pendiente";
													$titulo3="Verificar";					
													$texto1="Rechazado";
													$clases1="fa fa-remove rojo-apdp";
													$texto2="Pendiente";
													$clases2="fa fa-clock-o naranja-apdp";
													$texto3="Verificado";
													$clases3="fa fa-thumbs-o-up verde-apdp";				
													break;
											}
									?>
									<tr>
										<td align="center"><?php echo date("d-m-Y",strtotime($valor["fecha"]));?></td>
										<td align="center"><?php echo $valor["fp"];?></td>
										<td align="center"><?php echo $valor["siglas"];?></td>
										<td align="center"><?php echo number_format($valor["monto"],2);?></td>
										<td align="center"><?php echo $valor["referencia"];?></td>
										<td align="center">
											<br class="hidden-md hidden-lg hidden-sm">
                    						<div class="btn-group ">
							  					<button type="button" class="btn btn-default btn-xs boton-status" data-indice="1" data-texto="<?php echo $texto1;?>" data-id="<?php echo $valor["id"];?>"><i class="<?php echo $clases1;?>" id="iconoa<?php echo $valor["id"];?>"></i><span id="primero<?php echo $valor["id"];?>" name="primero<?php echo $valor["id"];?>"><?php echo $titulo1;?></span></button>
							  					<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    					<span class="caret"></span>
							    					<span class="sr-only">Toggle Dropdown</span>
							  					</button>							  
							  					<ul class="dropdown-menu" >
							    						<li class="boton-status" data-indice="2" data-texto="<?php echo $texto2;?>" data-id="<?php echo $valor["id"];?>"><a class="pointer"><i class="<?php echo $clases2;?>" id="iconob<?php echo $valor["id"];?>"></i> <span id="segundo<?php echo $valor["id"];?>" name="segundo<?php echo $valor["id"];?>"><?php echo $titulo2;?></span></a></li>
							    						<li class="boton-status" data-indice="3" data-texto="<?php echo $texto3;?>" data-id="<?php echo $valor["id"];?>"><a class="pointer"><i class="<?php echo $clases3;?>" id="iconoc<?php echo $valor["id"];?>"></i> <span id="tercero<?php echo $valor["id"];?>" name="tercero<?php echo $valor["id"];?>"><?php echo $titulo3;?></a></li>
							  					</ul>
											</div>
											<br>
										</td>
									</tr>
									<?php
									endforeach;
								endif;
								?>
								</table>
								<br><br>
								<div style="background: #FAFAFA;" class="pad10">
								<table class="marL10 tam-detalle-ventas grisO "  >
									<tr>
										<td><b>Monto Total de la venta</b></td>
										<td>Bs.</td>
										<td align="right"><?php $totalGeneral=$publicacion->monto * $venta->getAtributo("cantidad"); echo number_format($totalGeneral,2);?></td>								
									</tr>
									<tr>
										<td><b>Descuento</b></td>
										<td>Bs</td>
										<td align="right"><?php $descuento=$venta->getAtributo("descuento");echo number_format($descuento,2);?></td>								
									</tr>
									<tr>
										<td style="border-bottom: 1px solid #ccc; padding-bottom: 5px;"><b>Monto Total Cancelado</b></td>
										<td style="border-bottom: 1px solid #ccc; padding-bottom: 5px;">Bs</td>
										<td style="border-bottom: 1px solid #ccc; padding-bottom: 5px;" align="right"><?php echo number_format($ac,2);?></td>								
									</tr>
									<tr>
										<td style=" padding-top: 5px;"><b>Monto Restante Para Cancelar</b></td>
										<td style=" padding-top: 5px;">Bs</td>
										<td style=" padding-top: 5px;" align="right">
											<?php
												$restante=$totalGeneral - $descuento - $ac;
												if($restante<=0){
													echo "PAGADO";
												}else{
													echo number_format($restante,2);
												}
											?>
										</td>
									</tr>
									
								</table>
								</div>	
								<br>
								<div class="text-right marR10"> <a class="pointer"><button class="btn btn-primary2" id="btn-guardar" name="btn-guardar">Guardar</button></a></div>
								<br>
								<hr>
								<br>
								<br>
								<div class="t18 negro marB10 marL5">Envios <span class="pull-right t16 marR5"><i class="fa fa-truck <?php echo $claseColor2;?>"></i> <?php echo $statusEnvio;?></span></div>
								<table class="table  " id="tabla-envios" name="tabla-envios">
									<tr style="background: #ADADAD; color: #FFF;">
										<td align="center"><b>Fecha</b></td>
										<td align="center"><b>Cantidad</b></td>
										<td align="center"><b>Agencia</b></td>
										<td align="center"><b>N. de guia</b></td>
										<td align="center"><b>Ver detalle</b></td>				
									</tr>
									<?php
										$listaEnvios=$venta->getEnvios();
										if($listaEnvios):
											foreach($listaEnvios as $l=>$valor):
												?>
												<tr>
													<td align="center"><?php echo date("d-m-Y",strtotime($valor["fecha"]));?></td>
													<td align="center"><?php echo $valor["cantidad"];?></td>
													<td align="center"><?php echo $valor["nombre"];?></td>
													<td align="center"><?php echo $valor["nro_guia"];?></td>
													<td align="center"><a>ver</a></td>
												</tr>
											<?php
											endforeach;
										endif;
										?>				
								</table>
								<br>
								<?php
								if($statusPago=="Pago verificado"):
									?>
										<div class="text-right marR10"> <a class="pointer" data-toggle="modal" data-target="#envios-ven"><button class="btn btn-primary2" id="btn-add-guia" name="btn-add-guia">Agregar guia</button></a></div>
								<?php endif; ?>
								<br>
								<hr>
								<br>
								<div class="t18 negro marB10 marL5">Datos de facturaci&oacute;n</div>
								<div class="pad10" style="background: #FAFAFA;">			
								<b>Cedula / Rif / Pasaporte :</b> C.I. V-19236990
								<br>
								<b>Nombre / Razon Social :</b> jean alviarez
								<br>
								<b>Direcci&oacute;n :</b> Venezuela, Tachira, San Cristobal, la guacara
								<br>
								<b>Agencia de Envio :</b> Zoom 
								<br>
								</div>
								<div class="text-right marT5 marR10" ><a class="point">Editar</a></div>
								<br>
								
								<div class="t18 negro marB5 marL5">Comentario</div>
								<div class="pad10"><input class="form-input" value="Comentario sobre esta venta" style="outline: 0"></div>
								<div class="text-right marR10" ><a class="point">Guardar</a></div>
							</div>
					</div>
			</div>
			
		</div>
		
				
      

		