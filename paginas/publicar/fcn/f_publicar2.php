<?php require '../../../config/core.php';
if (!headers_sent()) {
	header('Content-Type: text/html; charset=UTF-8');
}
include_once "../../../clases/clasificados.php";
$clasificado = new clasificados($_POST["id"]);

?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
	<div class="contenedor "
	style="margin-top: 5px; z-index: 1; padding-top: 20px; padding-bottom: 30px;">
		<div class="row" style="margin-left: 80px; margin-right: 80px;">
			<form id="pub-form-reg" name="pub-form-reg" action="paginas/publicar/fcn/f_publicaciones" method="POST">
				<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2 ">
					<div class="">
						<img alt="" src="" id="imagentipo"
						style="width: auto; height: 120px;"
						class=" marT10 marB10 center-block ">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-10 col-lg-10 ">
					<div class="text-left t16 vin-blue ">
						<br>
						<br>
						<?php echo $clasificado -> getAdress($_POST["id"]); ?>
						<br>
						<a href="#" id="volverClasificado"><i class="fa fa-angle-double-left "></i> Atras</a>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marT20">
					<div class="t16">
						<b>Ingresa las fotos de tu producto</b>
						<br>
						<div class="alert alert-info " role="alert"
						style="width: 80%; margin: 0px; padding: 2px; font-size: 11px;">
							<span class="marL5"><i class="fa fa-info-circle marR5"></i> <b>Recomendaci&oacute;n: </b>Procura que la imagen sea de buena calidad y obtendras mejores
								resultados en tus ventas.</span>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marT10">
					<input type="hidden" id="fotoprincipal" value="false">
					<div class="subir-img-active foto" style="margin-left: 0px;" data-toggle="tooltip" title="Debes subir una foto">
						<img class="img-responsive"/>
						<!--<div class="text-center grisC t10" style="margin-top: 105%;">
						Principal
						</div>-->
						<i style="position: relative; top:-92px; left:84%;" class="fa fa-times red hidden"></i>
					</div>
					<div class="subir-img-active foto " >
						<img class="img-responsive"/>
						<i style="position: relative; top:-92px; left:84%;" class="fa fa-times red hidden"></i>
						</i>
					</div>
					<div class="subir-img-active foto"><img class="img-responsive"/>
						<i style="position: relative; top:-92px; left:84%;" class="fa fa-times red hidden"></i>
						</i>
					</div>
					<div class="subir-img-active foto"><img class="img-responsive"/>
						<i style="position: relative; top:-92px; left:84%;" class="fa fa-times red hidden"></i>
						</i>
					</div>
					<div class="subir-img-active foto"><img class="img-responsive"/>
						<i style="position: relative; top:-92px; left:84%;" class="fa fa-times red hidden"></i>
						</i>
					</div>
					<div class="subir-img-active foto"><img class="img-responsive"/>
						<i style="position: relative; top:-92px; left:84%;" class="fa fa-times red hidden"></i>
						</i>
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
						<b>Colocale un titulo a tu producto</b>
						<br>
						<div class="alert alert-warning " role="alert"
						style="width: 80%; margin: 0px; padding: 2px; font-size: 11px;">
							<span class="marL5"><i class="fa fa-exclamation-triangle"></i> <b>Advertencia: </b>no debes de ingresar ninguna informaci&oacute;n de contacto, de lo
								contrario tu publicaci&oacute;n sera excluida de las listas.</span>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 marT10 marB10 ">
					<div class="form-group input-group" style="width: 100%; ">
						<input type="text" placeholder="Titulo de la publicaci&oacute;n" name="txtTitulo" id="txtTitulo" class=" form-control " id="">
					</div>				
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 marT10  marB10 ">
					<div class="input-group" id="rs_acpt" style=" visibility: hidden; border-radius: 0px; ">
				      <span class="input-group-addon" style="border-radius: 0px;">
				        <input type="checkbox" id="checkbox" style="width: 20px; height: 20px;">
				      </span>
				      <input type="text" class="form-control" readonly="true"  value="Aceptas compartir automaticamente en tus Redes Sociales">				      
				    </div>	
				    <br>
				    <div class="text-center">
				    	<button class="btn btn-default" id="fb" data-fb="0" data-rs="fb" style="display: none;"><i class="fa fa-facebook-f"></i> Facebook <i class="fa fa-check" id="ifb" style="display: none; color: green"></i></button> 
				    	<button class="btn btn-default" id="tt" data-tt="0" data-rs="tt" style="display: none;"><i class="fa fa-twitter"></i> Twitter <i class="fa fa-check" id="itt" style="display: none; color: green"></i></button> 
				    	<button class="btn btn-default" id="fp" data-fp="0" data-rs="fp" style="display: none;"><i class="fa fa-thumbs-o-up"></i> Fan Page <i class="fa fa-check" id="ifp"  style="display: none; color: green"></i></button> 
				    	<button class="btn btn-default" id="gr" data-gr="0" data-rs="gr" style="display: none;"><i class="fa fa-users"></i> Grupo <i class="fa fa-check" id="igr"  style="display: none; color: green"></i></button>
				    	</div>
				   </div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marT10">
					<div class=""  style="width: 100%; ">
						<div class="t16">
							<b>Describe tu producto</b>
						<br>
						<div class="alert alert-info " role="alert"
						style="width: 80%; margin: 0px; margin-left:0px; margin-bottom:5px; padding: 2px; font-size: 11px;">
							<span class="marL5"><i class="fa fa-info-circle marR5"></i> <b>Recomendaci&oacute;n: </b> para mejor exposici&oacute;n utiliza mas imagenes que texto en el detalle de tu publicaci&oacute;n.</span>
						</div>
						</div>
						<div id="editor" ></div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marT20 marB10">
					<div class="t16">
						<b>M&aacute;s especificaciones</b>
					</div>
				</div>
			<!--	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">
					<div class="input-group marB10">
						<span class="input-group-addon">Condici&oacute;n</span>
						<select
						name="cmbCondicion" class="form-control" id="cmbCondicion">
						    <?php 
						    if($clasificado->buscarPadre()=="I2F"){
						    	echo "<option value='3'>Servicio</option>";
							}else{
								echo "<option value='1'>Nuevo</option>";
								echo "<option value='2'>Usado</option>";
							}
							?>
						</select>
					</div>
			</div> -->
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
						<input name="txtPrecio"
						id="txtPrecio" type="text" placeholder="Precio" class="form-control"
						aria-describedby="inputGroupSuccess3Status">
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
									<input type="checkbox" id="chkGarantia" name="chkGarantia" value="0"
									style="width: 100%; height: 100%;margin-top:12px" >
								</div></td>
								<td valign="middle">
								<div class="t12 marR10" style="margin-top:22px">
									&iquest;Tu producto cuenta con
									garantia?
								</div></td>
								<td valign="bottom">
								<select class="form-select " style="margin-top:20px;display:none;" id="cmbGarantia" name="cmbGarantia">
									<option value="A consultar">A consultar</option>
									<option value="15 dias de ">15 Dias</option>
									<option value="1 mes de ">1 Mes</option>
									<option value="2 meses de ">2 Meses</option>
									<option value="3 meses de ">3 Meses</option>
									<option value="6 meses de ">6 Meses</option>
									<option value="9 meses de ">9 Meses</option>
									<option value="1 agno de ">1 A&ntilde;o</option>
									<option value="2 agnos de ">2 A&ntilde;os</option>
									<option value="3 agnos de ">3 A&ntilde;os</option>
									<option value="5 agnos de ">5 A&ntilde;os</option>
								</select></td>
							</tr>
						</table>
					</div>
				</div>
				<!-- Factura-->
			<!-- 	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
					<div class="text-left marL20 marT10 ">
						<table>
							<tr>
								<td>
								<div class="marR10"
								style="width: 20px; height: 20px; border: 0px; float: left;">
									<input type="checkbox" id="chkEntregaFactura" name="chkEntregaFactura"
									style="width:100%; height:100%;">
								</div></td>
								<td valign="bottom"><span class="t12">&iquest;Entregas factura fiscal?</span></td>
							</tr>
						</table>
					</div>
			</div> -->
				<!-- Tienda Fisica -->
				<!--	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
					<div class="text-left marL20 marT10 ">
						<table>
							<tr>
								<td>
									<div class="marR10"
									style="width: 20px; height: 20px; border: 0px; float: left;">
										<input name="chkEresTienda" id="chkEresTienda" type="checkbox"
										style="width: 100%; height: 100%;">
									</div>
								</td>
								<td valign="bottom">
									<span class="t12">&iquest;Eres tienda fisica?</span>
								</td>
							</tr>
						</table>
					</div>
				</div>  -->
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
					<div class="text-right">
						<button class="btn3 btn-primary2" type="submit" id="btnContinuar" name="btnContinuar">
							Continuar
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>