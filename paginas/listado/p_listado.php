<?php 
if (!headers_sent()) {
	header('Content-Type: text/html; charset=UTF-8');
}
?>
<?php
include_once "clases/clasificados.php";
include_once "clases/publicaciones.php";
include_once "clases/usuarios.php";
include_once "clases/fotos.php";
$publicacion=new publicaciones();
$foto=new fotos();
if(isset($_GET["id_cla"])){
	$act_cla=$_GET["id_cla"];
}else{
	$act_cla=-1;
}
if(isset($_GET["id_est"])){
	$act_est=$_GET["id_est"];
}else{
	$act_est=100;
}
if(isset($_GET["pagina"])){
	$pagina=$_GET["pagina"];
}else{
	$pagina=1;
}
if(!isset($_GET["palabra"])){
	$palabra="TODOS";
}else{
	$palabra=$_GET["palabra"];
}
if(isset($_GET["cantidadAnt"])){
	$cantidadAnt=$_GET["cantidadAnt"];
}else{
	$cantidadAnt=0;
}
if($act_cla!=-1){
	$clasificado=new clasificados($act_cla);
}else{
	$clasificado=new clasificados();
}
if(isset($_GET["nombre_est"])){
	$nombre_est=$_GET["nombre_est"];
}else{
	$nombre_est="";
}
if(!isset($_GET["orden"])){
	$orden="id_desc";
}else{
	$orden=$_GET["orden"];
}
if(!isset($_GET["condicion"])){
	$condicion=NULL;
	$laCondicion="";
	$laCondicion2="";
	$muestraSpan="hidden";
}else{
	$muestraSpan="";
	$condicion=$_GET["condicion"];
	switch($_GET["condicion"]){
		case 1:
			$laCondicion="  Nuevo";
			break;
		case 2:
			$laCondicion="  Usado";
			break;
		case 3:
			$laCondicion="  Servicio";
			break;
	}
	$laCondicion2="&condicion=$condicion";
}
if(($nombre_est=="" && $act_cla==-1) || $laCondicion==""){
	$muestraIcono="hidden";
}else{
	$muestraIcono="";
}
$primero=(($pagina - 1) * 25) + 1;
$ultimo=$pagina * 25;
?>
	<div class="container " id="principal" name="principal"  data-cla="<?php echo $act_cla;?>" data-est="<?php echo $act_est;?>" data-con="<?php echo $condicion;?>" 
		data-pag="<?php echo $pagina;?>" data-pal="<?php echo $palabra;?>" data-can="<?php echo $cantidadAnt;?>" data-nomest="<?php echo $nombre_est;?>" >
		<div class="row">			
			 <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' id="noresultados" name"noresultados" style="display:none">
                         <div class='alert alert-warning2  text-left' role='alert'   >
                         	<img src="galeria/img-site/logos/bill-error.png" width="100px" height="100px;" class="pull-left" style="margin-top:0px;"/>
                         	<div class="t16 marL20 marB5 ">No se encontraron resultados de tu busqueda.</div>
                         	<span class="t12 marL30 grisO">
                         		<i class="fa fa-caret-right marR10"></i> Verifica la ortografia en cada palabra.
                         	</span>
                         		<br>
							<span class="t12 marL30 grisO">	
								<i class="fa fa-caret-right marR10"></i> Utiliza palabras m&aacute;s estandares.
							</span>	
							<br>
							<span class="t12 marL30 grisO">	
								<i class="fa fa-caret-right marR10"></i> utiliza categorias mas especificas para mejorar la busqueda.
							</span>	
							<br>	
							<span class="t12 marL30 grisO">	
								<i class="fa fa-caret-right marR10"></i> No se hallaron publicaciones relacionadas a tu selecci&oacute;n.
							</span>	
                         </div>  
                         <br>
                           <div class="anchoC center-block">
                          	<br>
                          	<br>
                          	<?php include_once "fcn/f_categorias.php"; ?> 
                          	<br>
                          	<br>
                          	</div>                   
                      </div>
			<!-- Filtros -->
			<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 resultados" > <!-- ocultar cuando no hay resultados -->
				<div class="marL5 marT5 marB5  contenedor">
					<div class="marL10">
						<div id="categorias">
							<br>
							<h5 class="negro"><b>Categorias</b></h5>
						<hr class="marR5"></div>
						<ul class="nav marR5 t11  marT10 marB20 ">
								<!--imprimir las categoria resultantes segun lo seleccionado mediante las condiciones anteriores  (YA SE HIZO)-->
								<?php
								if($act_est!=100){  //si escogio un estado
									if($palabra=="TODOS"){  //si no escribio nada
										if($act_cla!=-1){  //si escogio una categoria
											$hijos=$clasificado->getHijosCondicionado($act_cla,$orden,$pagina,$act_est,$condicion);
										}else{
											$hijos=$clasificado->getHijosPorPalabras($palabra,$orden,$pagina,$act_est,NULL,$condicion);
										}
									}else{
										if($act_cla!=-1){  //si escogio una categoria
											$hijos=$clasificado->getHijosPorPalabras($palabra,$orden,$pagina,$act_est,$act_cla,$condicion);
										}else{
											$hijos=$clasificado->getHijosPorPalabras($palabra,$orden,$pagina,$act_est,NULL,$condicion);
										}	
									}
								}else{   //si no selecciono estado
									if($palabra=="TODOS"){   //si no ingreso una palabra a buscar
									   if($act_cla!=-1){
									   	   $hijos=$clasificado->getHijosCondicionado($_GET['id_cla'],$orden,$pagina,NULL,$condicion);
//										   $hijos=$clasificado->getHijosPorPalabras($palabra,$orden,$pagina,$act_cla);
									   }else{
										   $hijos=$clasificado->getHijosPorPalabras($palabra,$orden,$pagina,NULL,NULL,$condicion);
									   }
									}else{
										if($act_cla!=-1){
											$hijos=$clasificado->getHijosPorPalabras($palabra,$orden,$pagina,NULL,$act_cla,$condicion);
										}else{
											$hijos=$clasificado->getHijosPorPalabras($palabra,$orden,$pagina,NULL,NULL,$condicion);
										}
									} 
								}
    							$ac=0;
								if(!empty($hijos)){
									$publicaciones=$hijos["publicaciones"];
									$categorias=$hijos["categorias"];
									if(!empty($categorias)){
										foreach($categorias as $h["categorias"]=>$valor){
											if($act_est!=100){
												$rutaEstado="&id_est=$act_est&nombre_est={$_GET['nombre_est']}";
											}else{
												$rutaEstado="";
											}
											if($palabra!="TODOS"){
												$cadena="<li class='marB10 t11'><div  class='h-gris'><span ><a class='blue-vin' href='listado.php?id_cla={$valor["id"]}$rutaEstado&palabra=$palabra&cantidadAnt=$cantidadAnt" . $laCondicion2 . "'>";
											}else{
												$cadena="<li class='marB10 t11'><div  class='h-gris'><span ><a class='blue-vin' href='listado.php?id_cla={$valor["id"]}$rutaEstado&palabra=TODOS&cantidadAnt=$cantidadAnt" . $laCondicion2 . "'>";
											}
											$cadena.=$valor["nombre"];
											$cadena.="<span class='grisO'>" . " (" . $valor["cantidad"] . ")</span></a></span></div></li>";
											$ac+=$valor["cantidad"];										
											echo $cadena;										
										}
										if($ac<$ultimo){
											$ultimo=$ac;
										}
									}else{
										?>
										<script type="text/javascript">$("#categorias").css("display","none");</script>
										<?php
									}
								}else{
									$publicaciones=array();
								}
								?> 
							</ul>

							<div id="ubicacion">
								
							<h5 class="negro" ><b>Ubicaci&oacute;n</b></h5>
							<hr class="marR5">
							</div>
							<ul class="nav marR5 marT10 marB20 t11  ">
								<!-- Llamar al m&eacute;todo de la clase publicaciones que lista la cantidad de publicaciones por estado -->
								<?php
								if($act_est!=100){
									if($ac==0){   //No hubo categorias
										$ac=1;
									}									
									$cadena="<li class='marB10 t11'><div  class='h-gris'><div style='background:#F1F1F1; padding:2px; '><a class='grisO' href='listado.php?id_cla=$act_cla&palabra=$palabra&cantidadAnt=$cantidadAnt" . $laCondicion2 . "'>";
									$cadena.="<b class='grisO'>Todos ( $cantidadAnt )</b></a></div></li>";
									echo $cadena;
//									$cadena="<li class='marB10 t11'><div  class='h-gris'><a class='grisO' href='listado.php?id_cla=$act_cla&palabra=$palabra'>";
									$cadena="<li class='marB10 t11'><div  class='h-gris'>";
									$cadena.="<span class='blue-vin'>" . $nombre_est . "( $ac )" . "</span></div></li>";
									echo $cadena;
									$elEstado=" &nbsp;<i>En " . $_GET["nombre_est"] . "</i>";
								}else{
									$elEstado="";
									$estados=$hijos["estados"];
									//Buscarle otra soluci&oacute;n para no repetir el ciclo
									if($ac==0){
										foreach ($estados as $l=>$valor) {
											$ac+=$valor["cantidad"];
										}
									}		
									foreach ($estados as $l=>$valor) {
										$cadena="<li class='marB10 t11'><div  class='h-gris'><a class='blue-vin' href='listado.php?id_cla=$act_cla&id_est={$valor["id"]}&nombre_est={$valor["nombre"]}&palabra=$palabra&cantidadAnt" . $laCondicion2 . "'>";
										$cadena.=$valor["nombre"] . "<span class='grisO'> &nbsp; (" . $valor["cantidad"] .")</span></a></div></li>";
										echo $cadena;
									}
									if($ac<$ultimo){
										$ultimo=$ac;
									}
								}
								?>
<!--							<li class="marB10 t11"><div  class="h-gris"><span ><a class="grisO" href="listado.php">T&aacute;chira<b class="grisO">(19)</b></a></span></div></li> -->
							</ul>
							<div id="condicion">
								
							<h5 class="negro" ><b>Condici&oacute;n</b></h5>
							<hr class="marR5">
							
							</div>
							<?php
							$vinculo="listado.php?id_cla=$act_cla&id_est=$act_est&nombre_est=$nombre_est&palabra=$palabra&cantidadAnt=0&condicion=1";
							$vinculo2="listado.php?id_cla=$act_cla&id_est=$act_est&nombre_est=$nombre_est&palabra=$palabra&cantidadAnt=0&condicion=2";
							$vinculo3="listado.php?id_cla=$act_cla&id_est=$act_est&nombre_est=$nombre_est&palabra=$palabra&cantidadAnt=0&condicion=3";
							$vinculo4="listado.php?id_cla=$act_cla&id_est=$act_est&nombre_est=$nombre_est&palabra=$palabra&cantidadAnt=0";
							?>
							<ul class="nav marR5 marT10 marB20 t11">
									<?php
									if($condicion==1):
									?>
									<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO' href='<?php echo $vinculo4; ?>'>
									<span class='blue-vin'>TODOS ( <?php echo $hijos["nuevos"] + $hijos["usados"] + $hijos["servicios"];?> )</a></li>
									<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO' href='#'>
									<span class='blue-vin'>Nuevo ( <?php echo $hijos["nuevos"];?> )</a></li>
									<?php
									elseif($condicion==2):
									?>
									<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO' href='<?php echo $vinculo4; ?>'>
									<span class='blue-vin'>TODOS ( <?php echo $hijos["nuevos"] + $hijos["usados"] + $hijos["servicios"];?> )</a></li>
									<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO' href='#'>
									<span class='blue-vin'>Usados ( <?php echo $hijos["usados"];?> )</a></li>
									<?php
									elseif($condicion==3):
									?>
									<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO' href='<?php echo $vinculo4; ?>'>
									<span class='blue-vin'>TODOS ( <?php echo $hijos["nuevos"] + $hijos["usados"] + $hijos["servicios"];?> )</a></li>
									<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO' href='#'>
									<span class='blue-vin'>Servicios ( <?php echo $hijos["servicios"];?> )</a></li>
									<?php
									else:
									?>
									<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO' href='<?php echo $vinculo; ?>'>
									<span class='blue-vin'>Nuevo ( <?php echo $hijos["nuevos"];?> )</a></li>									
									<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO' href='<?php echo $vinculo2; ?>'>
									<span class='blue-vin'>Usado ( <?php echo $hijos["usados"];?> )</a></li>									
									<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO' href='<?php echo $vinculo3; ?>'>
									<span class='blue-vin'>Servicios ( <?php echo $hijos["servicios"];?> )</a></li>
									<?php												
									endif;
									?>			
							</ul>
							<br>
							</div>
							</div>
							</div>
							<!-- Listado -->
							<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 resultados" > <!-- ocultar si no hay resultados -->
							<div class="mar5 contenedor row">
							<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 text-left vin-blue ">
							<!-- mostrar la busqueda o donde esta segun lo q selecciono y almaceno en la variable de busqueda 2 y contar seria la cantidad de resultados obtenidos segun la busqueda -->
							<div class="marL20 t14"><p style="margin-top:15px;"> 
								<span class="grisC"> <?php echo $primero . ' - ' . $ultimo; ?> de </span><span class="grisC">
									<?php echo $ac;?></span> <span class="marR5 grisC"> resultados</span>
									<a href="index.php" style="color:#000" class="marL5">Inicio </a> 
									<i class="fa fa-caret-right negro marR5 marL5"></i>
									<?php echo $clasificado->getAdressWithLinks(NULL,$palabra);echo $elEstado; echo "  <i class='fa fa-caret-right negro marR5 marL5 {$muestraIcono}'></i><span class='f-condicion t10 {$muestraSpan}' style='padding:4px;'>$laCondicion</span>";?>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 ">
							<div class=" marR20" style="margin-top:10px;" id="orden">
							<select id="filtro"  class="form-control  input-sm " style="width:auto;"  >
							<?php if($orden=="id_desc"){ echo "<option value='id_desc' selected>Mas Recientes</option>";}else{echo "<option value='id_desc'>Mas Recientes</option>";}?>
							<?php if($orden=="id_asc"){ echo "<option value='id_asc' selected>Menos Recientes</option>";}else{echo "<option value='id_asc'>Menos Recientes</option>";}?>
							<?php if($orden=="monto_desc"){ echo "<option value='monto_desc' selected>Mayor Precio</option>";}else{echo "<option value='monto_desc'>Mayor Precio</option>";}?>							
							<?php if($orden=="monto_asc"){ echo "<option value='monto_asc' selected>Menor Precio</option>";}else{echo "<option value='monto_asc'>Menor Precio</option>";}?>	
							</select>
							</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<hr class="marL10 marR10">
							<br>
							</div>
							
							<div id="">
						<div id="ajaxContainer" border="3" > <!-- ESTE DIV SE UTILIZARA SI SE DECIDI APLICARLE AJAX, POR EL MOMENTO NO SE UTILIZA -->
						<!-- Listado filas -->
						
						<?php
						    if($ac>0){
						    	?>
						    	<script type='text/javascript'>$('#ubicacion').css('display','block');</script>
								<script type='text/javascript'>$('.sinresultados').css('display','block');</script>
								<?php
								foreach ($publicaciones as $h["publicaciones"] => $valor):
									$miTitulo=$valor["titulo"];
									$miTitulo=str_ireplace($palabra, "<span style='background:#ccc'><b>$palabra</b></span>", $miTitulo);
									$publi=new publicaciones($valor["id"]);
									$usua=new usuario($publi->usuarios_id);
									$contadorVisitas=$publi->getVisitas()!=1?$publi->getVisitas() ." Visitas ":$publi->getVisitas() ." Visita ";
									?>
									<div class=' col-xs-12 col-sm-6 col-md-2 col-lg-2'>
								    <div class='marco-foto-conf  point marL20  ' style='height:130px; width: 130px;'  >
								    <div style='position:absolute; left:40px; top:10px; ' class='f-condicion'> <?php echo $publi->getCondicion();?> </div>								 
								    <img src='<?php echo $publi->getFotoPrincipal();?>' class='img img-responsive center-block img-apdp imagen' style='width:100%;height:100%;' data-id='<?php echo $valor["id"];?>'>							
									</div></div>
									<div class=' col-xs-12 col-sm-6 col-md-7 col-lg-7'><p class='t16 marL10 marT5'>
								    <span class=' t15'><a class='negro' href='detalle.php?id=<?php echo $valor["id"];?>' class='grisO'><b> <?php echo $miTitulo;?></b></a></span>
									<br><span class=' vin-blue t14'><a href='perfil.php?id=<?php echo $valor["usuarios_id"];?>' class=''><b> <?php echo $usua->a_seudonimo;?></b></a></span><span></span>
									<br><span class='t14 grisO '> <?php echo $usua->n_nombre . " " . $usua->n_apellido . $usua->j_razon_social;?></span><br>
									<span class='t12 grisO '><i class='glyphicon glyphicon-time t14  opacity'></i><?php echo $publi->getTiempoPublicacion();?></span><br>
									<span class='t11 grisO'> <span> <i class='fa fa-eye negro opacity'></i></span><span class='marL5'><?php echo $contadorVisitas;?></span><i class='fa fa-heart negro marL5 opacity'>
									</i><span class=' point h-under marL5'><?php echo $publi->getFavoritos();?> Me gusta</span><i class='fa fa-share-alt negro marL15 opacity hidden'></i> <span class=' point h-under marL5 hidden'> <?php echo $publi->getCompartidos(3);?> Veces compartido</span> </span>
								    </p></div>
								    <div class=' col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right'><div class='marR20'><span class='red t20'><b> <?php echo $publi->getMonto();?></b></span >
									<br><span class=' t12'> <?php echo ($usua->getEstado()); ?> </span><br><span class='vin-blue t16'><a href='detalle.php?id=<?php echo $valor["id"];?>' style='text-decoration:underline;'>Ver Mas</a></span >
									</div></div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-2'><br></div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-10'><hr class='marR10'><br></div>
								<?php
								endforeach;
								$totalPaginas=floor($ac/25);
								$restantes=$ac-($totalPaginas*25);
								if($restantes>0){
									$totalPaginas++;
								}
								?>
								<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 '><center><nav><ul class='pagination'>
								<?php
								if($pagina>10){
									$anteriorGrupo=$pagina-10;
									echo "<li><a href='listado.php?id_cla=$act_cla&pagina=$anteriorGrupo&palabra=$palabra" . $laCondicion2 . "' aria-label='Previous'><i class='fa fa-angle-double-left'></i></a></li>";
								}
								if($pagina>1){
									$anteriorPagina=$pagina-1;
									echo "<li><a href='listado.php?id_cla=$act_cla&pagina=$anteriorPagina&palabra=$palabra" . $laCondicion2 . "' aria-label='Previous'><i class='fa fa-angle-left'></i></a></li>";
								}
								$contador=0;
								if($pagina<=10){
									$inicio=1;
								}else{
									$inicio=floor($pagina/10);
									if($pagina % 10!=0){
										$inicio=($inicio*10)+1;
									}else{
										$inicio=($inicio*10)-9;
									}
								}
								for($i=$inicio;$i<=$totalPaginas;$i++){
									$contador++;
									if($i==$pagina){
										echo "<li class='active'><a href='listado.php?id_cla=$act_cla&pagina=$i&palabra=$palabra" . $laCondicion2 . "' class='botonPagina'>$i</a></li>";
									}else{
										echo "<li><a href='listado.php?id_cla=$act_cla&pagina=$i&palabra=$palabra" . $laCondicion2 . "' class='botonPagina'>$i</a></li>";
									}
									if($contador==10){
										break;
									}
								}
								if($pagina<$totalPaginas){
									$siguientePagina=$pagina+1;
									echo "<li><a href='listado.php?id_cla=$act_cla&pagina=$siguientePagina&palabra=$palabra" . $laCondicion2 . "' aria-label='Next'><i class='fa fa-angle-right'></i> </a>";
								}else{
									$siguientePagina=$totalPaginas;
								}																
								if($i<$totalPaginas){
									if(($pagina+10)<=$totalPaginas){
										$siguienteGrupo=$pagina + 10;
									}else{
										$siguienteGrupo=$totalPaginas;
									}
									echo "<li><a href='listado.php?id_cla=$act_cla&pagina=$siguienteGrupo&palabra=$palabra" . $laCondicion2 . "' aria-label='Next'><i class='fa fa-angle-double-right'></i> </a>";
								}
								?>
								</li></ul></nav></center></div>
								
								
								</div></div></div></div></div>
							<?php							
						}else{
							?>
							<script type='text/javascript'>$('#noresultados').css('display','block');</script>
							<script type='text/javascript'>$('#ubicacion').css('display','none');</script>
							<script type='text/javascript'>$('.resultados').css('display','none');</script>
							<?php
						}
						?>
						</div>