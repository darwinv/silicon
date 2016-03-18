<?php
if (!headers_sent()) {
	header('Content-Type: text/html; charset=ISO-8859-15');
}
include_once '../../clases/publicaciones.php';
$publi=new publicaciones($_POST["id"]);
$precio = str_replace(".", "", $_POST["precio"]);
$precio = str_replace(",", ".", $precio);
$foto2=$publi->getFotoN(2);
$foto3=$publi->getFotoN(3);
$foto4=$publi->getFotoN(4);
$foto5=$publi->getFotoN(5);
$foto6=$publi->getFotoN(6);
?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "> 
	<div class="contenedor grisO"
	style="margin-top: 5px; z-index: 1; padding-top: 20px; padding-bottom: 30px;">
		<div class="row" style="margin-left: 40px; margin-right: 40px;">
			<form id="pub-form-reg" name="pub-form-reg" action"ventas.php" method="get">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
					<h3 class="  negro text-left">
					<span class="">Actualizacion de la publicacion <span class="opacity grisO t16"># <?php if(isset($publi)){ echo $publi->id;}?></span></span>
					<span class="pull-right marR20 t12"><a href="ventas.php">Volver</a></span>
					<hr>
					</h3>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marT20">
					<div class="t16">
						Fotos de tu producto
						<div class="alert alert-info " role="alert"
						style="width: 80%; margin: 0px; padding: 2px; font-size: 11px;">
							<span class="marL5"><i class="fa fa-info-circle marR5"></i> <b>Recomendación: </b>Procura que la imagen sea de buena calidad y obtendras mejores
								resultados en tus ventas.</span>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marT10">
					<input type="hidden" id="fotoprincipal" value="false">
					<div class="subir-img-active foto" data-toggle="tooltip" title="Debes subir una foto">
						<img class="img-responsive"/ src="<?php echo $publi->getFotoN(1);?>" id="1">
						<i style="position: relative; top:-92px; left:84%;" class="fa fa-times red hidden"></i>
					</div>
					<div class="subir-img-active foto " >
						<?php
						$c=1;
						if($foto2==""):
							?>
						<img class="img-responsive"/>
						<?php
						else:
							$c++;
							?>
							<img class="img-responsive"/ src="<?php echo $foto2;?>" id=<?php echo $c; ?>>
							<?php
						endif;
						?>
						<i style="position: relative; top:-92px; left:84%;" class="fa fa-times red hidden"></i>						
					</div>
					<div class="subir-img-active foto">
						<?php
						if($foto3==""):
							?>
						<img class="img-responsive"/>
						<?php
						else:
							$c++;
							?>
							<img class="img-responsive"/ src="<?php echo $foto3;?>" id=<?php echo $c;?>>
							<?php
						endif;
						?>
						<i style="position: relative; top:-92px; left:84%;" class="fa fa-times red hidden"></i>
					</div>
					<div class="subir-img-active foto">
						<?php
						if($foto4==""):
							?>
						<img class="img-responsive"/>
						<?php
						else:
							$c++;
						    ?>
						    <img class="img-responsive"/ src="<?php echo $foto4;?>" id=<?php echo $c;?>>
						    <?php
						endif;
						?>
						<i style="position: relative; top:-92px; left:84%;" class="fa fa-times red hidden"></i>
					</div>
					<div class="subir-img-active foto">
						<?php
						if($foto5==""):
							?>
						<img class="img-responsive"/>
						<?php
						else:
							$c++;
							?>
							<img class="img-responsive"/ src="<?php echo $foto5;?>" id=<?php echo $c;?>>
							<?php
						endif;
						?>
						<i style="position: relative; top:-92px; left:84%;" class="fa fa-times red hidden"></i>
					</div>
					<div class="subir-img-active foto">
						<?php
						if($foto6==""):
							?>
						<img class="img-responsive"/>
						<?php
						else:
							$c++;
							?>
							<img class="img-responsive"/ src="<?php echo $foto6;?> id=<?php echo $c;?>">
							<?php
						endif;
						?>
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
							<span class="marL5"><i class="fa fa-exclamation-triangle"></i> <b>Advertencia: </b>no debes de ingresar ninguna información de contacto, de lo
								contrario tu publicación sera excluida de las listas.</span>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marT10">
					<div class="form-group input-group" style="width: 60%">
						<input type="text" placeholder="Titulo de la publicación" name="txtTitulo" id="txtTitulo"
						class=" form-control " value="<?php echo utf8_decode($_POST['titulo']);?>">
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class=""  style="width: 100%; ">
						<div class="t16">
							Detalle de la publicación:
						</div>
						<div class="alert alert-info " role="alert"
						style="width: 80%; margin: 0px; margin-left:0px; margin-bottom:5px; padding: 2px; font-size: 11px;">
							<span class="marL5"><i class="fa fa-info-circle marR5"></i> <b>Recomendación: </b> para mejor exposición utiliza mas imagenes que tenxto en el detalle de tu publicación.</span>
						</div>
						<div id="editor" name="editor"><?php echo utf8_decode($_POST["descripcion"]); ?></div>					
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marT20 marB10">
					<div class="t16">
						Más especificaciones
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">
					<div class="input-group marB10">
						<span class="input-group-addon">Condición</span>
						<select
						name="cmbCondicion" class="form-control" id="cmbCondicion">
						       <?php
						       switch($publi->condiciones_publicaciones_id){
									case 1:					    	
										echo "<option value='1' selected>Nuevo</option>
										<option value='2'>Usado</option>";
										break;
									case 2:
										echo "<option value='1'>Nuevo</option>
										<option value='2' selected>Usado</option>";
										break;
									case 3:			
										echo "<option value='3'>Servicio</option>";
							   }
								?>
						</select>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">
					<div class="input-group marB10">
						<span class="input-group-addon">Unidades</span>
						<input name="txtCantidad"
						id="txtCantidad" type="text" value="<?php echo $_POST['cantidad'];?>"  class="form-control"
						aria-describedby="inputGroupSuccess3Status">
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">
					<div class="input-group marB10">
						<span class="input-group-addon">Bs</span>
						<input name="txtPrecio" 
						id="txtPrecio" type="text" placeholder="Precio" class="form-control"
						aria-describedby="inputGroupSuccess3Status" value="<?php echo $precio;?>">
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
								<?php
								if(!strpos($publi->dias_garantia,"de")){
									echo "<input type='checkbox' id='chkGarantia' name='chkGarantia' style='width: 100%; height: 100%;margin-top:12px'>";
									$verGarantia="none";	
								}else{
									echo "<input type='checkbox' id='chkGarantia' name='chkGarantia' style='width: 100%; height: 100%;margin-top:12px' checked>";
									$verGarantia="block";
								} 
									?>									
								</div></td>
								<td valign="middle">
								<div class="t12 marR10" style="margin-top:22px">
									¿Tu producto cuenta con
									garantia?
								</div></td>
								<td valign="bottom">
									<?php
									$cadena="<select class='form-select ' style='margin-top:20px;display:$verGarantia;' id='cmbGarantia' name='cmbGarantia'>";
									$cadena.="<option value='A consultar'>A consultar</option>";
									$cadena.=$publi->dias_garantia=='15 dias de '?"<option value='15 dias de ' selected>15 Dias</option>":"<option value='15 dias de '>15 Dias</option>";
									$cadena.=$publi->dias_garantia=='1 mes de '?"<option value='1 mes de ' selected>1 Mes</option>":"<option value='1 mes de '>1 Mes</option>";
									$cadena.=$publi->dias_garantia=='2 meses de '?"<option value='2 meses de ' selected>2 Meses</option>":"<option value='2 meses de '>2 Meses</option>";
									$cadena.=$publi->dias_garantia=='3 meses de '?"<option value='3 meses de ' selected>3 Meses</option>":"<option value='3 meses de '>3 Meses</option>";
									$cadena.=$publi->dias_garantia=='6 meses de '?"<option value='6 meses de ' selected>6 Meses</option>":"<option value='6 meses de '>6 Meses</option>";
									$cadena.=$publi->dias_garantia=='9 meses de '?"<option value='9 meses de ' selected>9 Meses</option>":"<option value='9 meses de '>9 Meses</option>";
									$cadena.=$publi->dias_garantia=='1 año de '?"<option value='1 agno de ' selected>1 Año</option>":"<option value='1 agno de '>1 Año</option>";
									$cadena.=$publi->dias_garantia=='2 años de '?"<option value='2 agnos de ' selected>2 Años</option>":"<option value='2 agnos de '>2 Años</option>";
									$cadena.=$publi->dias_garantia=='3 años de '?"<option value='3 agnos de ' selected>3 Años</option>":"<option value='3 agnos de '>3 Años</option>";
									$cadena.=$publi->dias_garantia=='5 años de '?"<option value='5 agnos de ' selected>5 Años</option>":"<option value='5 agnos de '>5 Años</option>";
								    $cadena.="</select></td>";
								echo $cadena;
								?>
							</tr>
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
								<?php
								    if($publi->dafactura=="S"){
										echo "<input type='checkbox' id='chkEntregaFactura' name='chkEntregaFactura'	style='width:100%; height:100%;' checked>";
									}else{
										echo "<input type='checkbox' id='chkEntregaFactura' name='chkEntregaFactura'	style='width:100%; height:100%;'>";	
									}
								?>
								</div></td>
								<td valign="bottom"><span class="t12">¿Entregas factura fiscal?</span></td>
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
									<?php
									if($publi->estienda=="S"){
										echo "<input name='chkEresTienda' id='chkEresTienda' type='checkbox' style='width: 100%; height: 100%;' checked>";
									}else{
										echo "<input name='chkEresTienda' id='chkEresTienda' type='checkbox' style='width: 100%; height: 100%;'>";										
									}
									?>
									</div>
								</td>
								<td valign="bottom">
									<span class="t12">¿Eres tienda fisica?</span>
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