<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "> 
	<div class="contenedor grisO"
	style="margin-top: 5px; z-index: 1; padding-top: 20px; padding-bottom: 30px;">
		<div class="row" style="margin-left: 40px; margin-right: 40px;">
			<form id="pub-form-reg" name="pub-form-reg" action"ventas.php" method="get">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
					<h3 class="  negro text-left">
					<span class="">Actualizacion de la publicacion <span class="opacity grisO t16"># 5289</span></span>
					<span class="pull-right marR20 t12"><a href="ventas.php">Volver</a></span>
					<hr>
					</h3>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marT20">
					<div class="t16">
						Fotos de tu producto
						<div class="alert alert-info " role="alert"
						style="width: 80%; margin: 0px; padding: 2px; font-size: 11px;">
							<span class="marL5"><i class="fa fa-info-circle marR5"></i> <b>Recomendaci&oacute;n: </b>Procura que la imagen sea de buena calidad y obtendras mejores
								resultados en tus ventas.</span>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marT10">
					<input type="hidden" id="fotoprincipal" value="false">
					<div class="subir-img-active foto" data-toggle="tooltip" title="Debes subir una foto">
						<img class="img-responsive"/ src="galeria/fotos/2015/12/637.png" id="1">
						<i style="position: relative; top:-92px; left:84%;" class="fa fa-times red hidden"></i>
					</div>
					<div class="subir-img-active foto " >
												<img class="img-responsive"/>
												<i style="position: relative; top:-92px; left:84%;" class="fa fa-times red hidden"></i>						
					</div>
					<div class="subir-img-active foto">
												<img class="img-responsive"/>
												<i style="position: relative; top:-92px; left:84%;" class="fa fa-times red hidden"></i>
					</div>
					<div class="subir-img-active foto">
												<img class="img-responsive"/>
												<i style="position: relative; top:-92px; left:84%;" class="fa fa-times red hidden"></i>
					</div>
					<div class="subir-img-active foto">
												<img class="img-responsive"/>
												<i style="position: relative; top:-92px; left:84%;" class="fa fa-times red hidden"></i>
					</div>
					<div class="subir-img-active foto">
												<img class="img-responsive"/>
												<i style="position: relative; top:-92px; left:84%;" class="fa fa-times red hidden"></i>
					</div>
				</div>
				<div id="alertafoto" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marT10 hidden">
					<div class="alert alert-danger " role="alert"
					style="width: 80%; margin: 0px; padding: 2px; font-size: 11px;">
						<span class="marL5"><i class="fa fa-warning marR5"></i> Debes subir al menos una (01) imagen para tu publicacion.</span>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marT20">
					<div class="t16">
						Titulo tu producto
						<br>
						<div class="alert alert-warning " role="alert"
						style="width: 80%; margin: 0px; padding: 2px; font-size: 11px;">
							<span class="marL5"><i class="fa fa-exclamation-triangle"></i> <b>Advertencia: </b>no debes de ingresar ninguna informaci&oacute;n de contacto, de lo
								contrario tu publicaci&oacute;n sera excluida de las listas.</span>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marT10">
					<div class="form-group input-group" style="width: 60%">
						<input type="text" placeholder="Titulo de la publicaci&oacute;n" name="txtTitulo" id="txtTitulo"
						class=" form-control " value="Gjnytujdty6udhth">
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class=""  style="width: 100%; ">
						<div class="t16">
							Detalle de la publicaci&oacute;n:
						</div>
						<div class="alert alert-info " role="alert"
						style="width: 80%; margin: 0px; margin-left:0px; margin-bottom:5px; padding: 2px; font-size: 11px;">
							<span class="marL5"><i class="fa fa-info-circle marR5"></i> <b>Recomendaci&oacute;n: </b> para mejor exposici&oacute;n utiliza mas imagenes que tenxto en el detalle de tu publicaci&oacute;n.</span>
						</div>
						<div id="editor" name="editor"></div>					
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marT20 marB10">
					<div class="t16">
						M&aacute;s especificaciones
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">
					<div class="input-group marB10">
						<span class="input-group-addon">Condici&oacute;n</span>
						<select
						name="cmbCondicion" class="form-control" id="cmbCondicion">
						       <option value='1' selected>Nuevo</option>
										<option value='2'>Usado</option>						</select>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">
					<div class="input-group marB10">
						<span class="input-group-addon">Unidades</span>
						<input name="txtCantidad"
						id="txtCantidad" type="text" value="1"  class="form-control"
						aria-describedby="inputGroupSuccess3Status">
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">
					<div class="input-group marB10">
						<span class="input-group-addon">Bs</span>
						<input name="txtPrecio" readonly="true"
						id="txtPrecio" type="text" placeholder="Precio" class="form-control"
						aria-describedby="inputGroupSuccess3Status" value="15.000,00">
					</div>
				</div>
				<br>
				<br>
				<br>
				<br>
				<!-- Garantia -->
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
					<div class="text-left marL20  ">
						<table>
							<tr>
								<td>
								<div class="marR10"
								style="width: 20px; height: 20px; border: 0px; float: left;">
								<input type='checkbox' id='chkGarantia' name='chkGarantia' style='width: 100%; height: 100%;margin-top:12px'>									
								</div></td>
								<td valign="middle">
								<div class="t12 marR10" style="margin-top:22px">
									&iquest;Tu producto cuenta con
									garantia?
								</div></td>
								<td valign="bottom">
									<select class='form-select ' style='margin-top:20px;display:none;' id='cmbGarantia' name='cmbGarantia'><option value='A consultar'>A consultar</option><option value='15 dias de '>15 Dias</option><option value='1 mes de '>1 Mes</option><option value='2 meses de '>2 Meses</option><option value='3 meses de '>3 Meses</option><option value='6 meses de '>6 Meses</option><option value='9 meses de '>9 Meses</option><option value='1 agno de '>1 A&ntilde;o</option><option value='2 agnos de '>2 A&ntilde;os</option><option value='3 agnos de '>3 A&ntilde;os</option><option value='5 agnos de '>5 A&ntilde;os</option></select></td>							</tr>
						</table>
					</div>
				</div>
				<!-- Factura-->
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
					<div class="text-left marL20 marT10 ">
						<table>
							<tr>
								<td>
								<div class="marR10"
								style="width: 20px; height: 20px; border: 0px; float: left;">
								<input type='checkbox' id='chkEntregaFactura' name='chkEntregaFactura'	style='width:100%; height:100%;'>								</div></td>
								<td valign="bottom"><span class="t12">&iquest;Entregas factura fiscal?</span></td>
							</tr>
						</table>
					</div>
				</div>
				<!-- Tienda Fisica -->
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
					<div class="text-left marL20 marT10 ">
						<table>
							<tr>
								<td>
									<div class="marR10"
									style="width: 20px; height: 20px; border: 0px; float: left;">
									<input name='chkEresTienda' id='chkEresTienda' type='checkbox' style='width: 100%; height: 100%;'>									</div>
								</td>
								<td valign="bottom">
									<span class="t12">&iquest;Eres tienda fisica?</span>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
					<div class="text-right">
						<button class="btn3 btn-primary2" type="submit" id="btnContinuar" name="btnContinuar">
							Actualizar
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>