<?php
require '../../../config/core.php';
include_once "../../../clases/usuarios.php";
include_once "../../../clases/publicaciones.php";
include_once "../../../clases/amigos.php";
include_once "../../../clases/ventas.php";
include_once "../../../clases/fotos.php";
switch($_POST["metodo"]){
	case "buscarPublicaciones":
		buscaPublicaciones();
		break;
	case "actualizar":
		actualiza();
		break;
	case "cambiarStatus":
		cambiaStatus();
		break;
	case "actualizarPub":
		actualizaPub();
		break;
	case "republicar":
		republica();
		break;
	case "actualizarPagos":
		actualizaPagos();
		break;
	case "busquedaCaliente":
		buscarCaliente();
		break;
	case "guardarEnvio":
		guardaEnvio();
		break;
	case "guardarDescuento":
		guardaDescuento();
		break;
	case "guardarComentario":
		guardaComentario();
		break;		
	case "paginar1":
		pagina1();
		break;
	case "paginar2":
		pagina2();
		break;		
	case "ordenar":
		ordena();
		break;
}
function buscaPublicaciones(){
		if(!isset($_POST["pagina"]))
		$_POST["pagina"]=1;
		session_start();
	    $usua2=new usuario($_SESSION["id"]);
		$hijos2=$usua2->getPublicaciones($_POST["tipo"],$_POST["pagina"]);
		$contador=0;
		$des=$_POST["tipo"]==1?"":"disabled";
		$pagina=$_POST["pagina"];
		foreach ($hijos2 as $key => $valor) {
			$contador++;
			$publicacion=new publicaciones($valor["id"]);
			switch($_POST["tipo"]){
				case 1:
					$boton1="<li onclick='javascript:modificarOpciones($publicacion->id,2,1)'><a class='pausar opciones pointer'  id=''  data-toggle='modal' value='pausar'>Pausar</a></li>";
					$boton2="<li onclick='javascript:modificarOpciones($publicacion->id,3,1)'><a class='finalizar opciones pointer' id='' data-toggle='modal' value='finalizar'>Finalizar</a></li>";
					break;
				case 2:
					$boton1="<li onclick='javascript:modificarOpciones($publicacion->id,1,2)'><a class='pausar opciones pointer'  id=''  data-toggle='modal' value='reactivar'>Reactivar</a></li>";
					$boton2="<li onclick='javascript:modificarOpciones($publicacion->id,3,2)'><a class='pausar opciones pointer'  id=''  data-toggle='modal' value='reactivar'>Finalizar</a></li>";
					break;
				case 3:
					$boton1="<li onclick='javascript:republicarPublicacion($publicacion->id)'><a class='pausar opciones pointer'  id='' data-toggle='modal' data-target='#info-publicacion' value='republicar'>Republicar</a></li>";			
					$boton2="<li onclick='javascript:eliminarPublicacion($publicacion->id)'><a class='pausar opciones pointer'  id='' data-toggle='modal' value='eliminar'>Eliminar</a></li>";
					break;
			}			
			$cadena="<span id='general" . $valor["id"] . "' name='general" . $valor["id"] . "' class='general' data-titulo={$valor["titulo"]}>
			<div class='col-xs-12 col-sm-12 col-md-1 col-lg-1  '>			
					<div class='marco-foto-publicaciones  point ' style='width: 65px; height: 65px;' > <img src='" . $publicacion->getFotoPrincipal() . "' width='100%' height='100%;' 
					style='border: 1px solid #ccc;' class='img img-responsive center-block imagen' data-id='" . $valor["id"] . "'> </div>				
			</div>
			<div class='col-xs-12 col-sm-12 col-md-6 col-lg-6 vin-blue t14  '>
				<span class='detalle.php'> <a href='detalle.php?id={$valor["id"]}'><span id='titulo" . $valor["id"] . "'>" . utf8_encode($valor["titulo"]) . "</span> </a>
				<br>
				<span class='opacity'># $publicacion->id</span>
			</div>
			<div class='col-xs-12 col-sm-12 col-md-2 col-lg-2  text-left '>
				<span class='red t14' id='monto" . $valor["id"] . "'>" . $publicacion->getMonto(1) . " </span>
				<span class='t12 opacity' id='stock" . $valor["id"] . "'> x " . $publicacion->stock . " und</span>
				<br>
				<span> " . $publicacion->getVisitas() . " Visitas</span>
				<span class='opacity hidden'> / </span>
				<span class=' blue-vin hidden'> 30 ventas </span>
			</div>
			<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 text-center t12 '>
				<div class='btn-group pull-right marR10'>					
					<button id='b" . $publicacion->id . "' type='button' class='btn2 btn-warning boton' data-toggle='modal' data-target='#info-publicacion' onclick='javascript:pasavalores($publicacion->id)'
					data-id='$publicacion->id' data-titulo='" . utf8_encode($publicacion->titulo) . "' data-stock='$publicacion->stock' data-monto='" . number_format($publicacion->monto,2,',','.') . "' data-id='b" . $publicacion->id . "' data-listado='{$_POST["tipo"]}' $des>
						Modificar
					</button> 
						<div id='descripcion" . $publicacion->id ."' name='descripcion" . $publicacion->id . "' class='hidden'>
							$publicacion->descripcion
						</div>
					<button id='btnReactivar" . $publicacion->id . "' type='button' class='btn2 btn-warning hidden' data-toggle='modal' onclick='javascript:modificarOpciones(" . $publicacion->id . ",1,1)'>
						Reactivar
					</button> 
					<button id='btnPausar" . $publicacion->id . "' type='button' class='btn2 btn-warning hidden' data-toggle='modal' onclick='javascript:modificarOpciones(" . $publicacion->id . ",2,2)'>
						Pausar
					</button>						
					<button id='btnFinalizar" . $publicacion->id . "' type='button' class='btn2 btn-warning hidden' data-toggle='modal' onclick='javascript:modificarOpciones(" . $publicacion->id . ",3,3)'>
						Finalizar
					</button>					
					<button id='btnOpciones" . $publicacion->id . "' type='button' class='btn2 btn-warning dropdown-toggle  ' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' >
						<span class='glyphicon glyphicon-cog '></span>
						<span class='caret'></span>
					</button>
					<ul  class='  dropdown-menu'  id='opciones'>			
							$boton1						
							$boton2						
					</ul>
					<div id='menPau" . $publicacion->id . "' class='alert alert-success t10 hidden' style='padding:3px;margin-bottom:0px; margin-top:3px;' role='alert'>
						Publicacion pausada
					</div>
					<div id='menAct" . $publicacion->id . "' class='  alert alert-success t10 hidden' style='padding:3px;margin-bottom:0px; margin-top:3px;' role='alert'>
						Publicacion activa
					</div>
					<div id='menFin" . $publicacion->id . "' class='  alert alert-success t10 hidden' style='padding:3px;margin-bottom:0px; margin-top:3px;' role='alert'>
						Publicacion finalizada
					</div>
					<div id='menRep" . $publicacion->id . "' class='  alert alert-success t10 hidden' style='padding:3px;margin-bottom:0px; margin-top:3px;' role='alert'>
						Republicada
					</div>
				</div>
			</div>
			<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10'>
				<center><hr class=' center-block'></center>
			</div>
		</span>";
			echo $cadena;
		}
		echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10'>
			<nav class='text-center'>
			  <ul class='pagination'>";
								$ac=$usua2->getCantidadPub($_POST["tipo"]);
								$totalPaginas=floor($ac/25);
								$restantes=$ac-($totalPaginas*25);
								if($restantes>0){
									$totalPaginas++;
								}
								echo"</div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' id='paginas' name='paginas' data-metodo='buscarPublicaciones' data-tipo='" . $_POST["tipo"] . "' data-id='" . $usua2->id . "' > <center><nav><ul class='pagination'>";
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
									if($i==$_POST["pagina"]){
										echo "<li class='active' style='cursor:pointer'><a class='botonPagina' data-pagina='" . $i ."'>$i</a></li>";
									}else{
										echo "<li class='' style='cursor:pointer'><a class='botonPagina' data-pagina='" . $i ."'>$i</a></li>";
									}
									if($contador==10){
										break;
									}
								}
				 if($totalPaginas>0){
				 echo "<li>
				      <a href='#' aria-label='Next'>
				        <span aria-hidden='true'>&raquo;</span>
				      </a>
				    </li>
			  </ul>
			</nav>
			</div>	";
		   }
		   if($contador==0){
			?>
			<script>
				$("#noresultados").removeClass("hidden");
				$("#publicaciones").addClass("hidden");
			</script>		  	
			<?php
			}else{
			?>
			<script>
			$("#noresultados").addClass("hidden");
			$("#publicaciones").removeClass("hidden");
			</script>
			<?php		  						
		}
}
function actualiza(){
	$bd=new bd();
	$publi=new publicaciones($_POST["id"]);
	$monto=$_POST["monto"];
	$publi->setMonto($monto);
	$bd->doUpdate("publicaciones", array("titulo"=>utf8_decode($_POST["titulo"]),"stock"=>$_POST["stock"],"monto"=>$monto), "id={$_POST["id"]}");
}
function cambiaStatus(){
	$publi=new publicaciones($_POST["id"]);
	$publi->setStatus($_POST["tipo"],$_POST["anterior"]);
	$amigos = new amigos();
	$panas = $amigos -> buscarAmigos2($publi -> usuarios_id);
	foreach ($panas as $p => $value) {
		$mostrar = $publi -> deletePanaNoti($_POST["id"],4,$value["numero"]);
	}
	echo $mostrar;	
}
function instancia(){
	$publi=new publicaciones($_POST["id"]);
}
function actualizaPub(){
	$publi=new publicaciones($_POST["id"]);	
	$listaValores=array(
			"titulo"=>$_POST["txtTitulo"],
			"descripcion"=>$_POST["editor"],
			"stock"=>$_POST["txtCantidad"],
			"dias_garantia"=>isset($_POST["chkGarantia"])?$_POST["cmbGarantia"]:NULL,
			"dafactura"=>isset($_POST["chkEntregaFactura"])?'S':'N',
			"estienda"=>isset($_POST["chkEresTienda"])?'S':'N',
			"condiciones_publicaciones_id"=>$_POST["cmbCondicion"],
			"monto"=>$_POST["monto"],
			"vencimientos_publicaciones_id"=>2);	
	$monto = $_POST["monto"];
	$fecha=time();
	for ($i=0; $i < 6 ; $i++) {
		if(isset($_POST["foto-".$i])){
			$fotos[] = $_POST["foto-".$i];
		}
	} 	
	$listaValores["dias_garantia"]=str_replace("gn", "�", $listaValores["dias_garantia"]);
	$listaValores["titulo"]=utf8_decode($listaValores["titulo"]);
	$publi->actualizarPublicacion($listaValores,$monto,$fotos);
	echo "OK";
}
function republica(){
	$publi=new publicaciones($_POST["id"]);	
	$amigos = new amigos();
	$bd = new bd();
	$listaValores=array(
			"titulo"=>$_POST["titulo"],
			"monto"=>$_POST["monto"],
			"stock"=>$_POST["stock"]);
	$resultado=$publi->volveraPublicar($listaValores);
	$panas = $amigos -> buscarAmigos2($publi -> usuarios_id);
	foreach ($panas as $p => $value) {
		$publi-> setPanaPublicacion($resultado,4,$value["numero"]);
	}			
	echo $resultado;
}
function buscarCaliente(){
	$bd=new bd();
	$result=$bd->query("select * from publicaciones where usuarios_id={$_POST["usuarios_id"]} and titulo like '%{$_POST["palabra"]}%' and id in (
	select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)");
	$devolver="";
	foreach ($result as $key => $valor) {
		$devolver.="<a href=detalle.php?id='" . $valor["id"] . "'>" . $valor["titulo"] . "</a><br>";
	}
	echo $devolver;
}
function actualizaPagos(){
	$bd=new bd();
	$venta=new ventas($_POST["id"]);
	$pagos=explode(",",$_POST["pagos"]);
	foreach ($pagos as $p => $valor) {
		$pago=explode(" ",$valor);
		$id=$pago[0];
		switch($pago[1]){
			case "Pendiente":
				$status=1;
				break;
			case "Verificado":
				$status=2;
				break;
			case "Rechazado":
				$status=3;
				break;
			case "guardarEnvio":
				guardaEnvio();
				break;
		}
		$result=$bd->doUpdate("pagosxcompras",array("status_pago"=>$status),"id=$id");
	}
	$sta=$venta->getStatusPago();
	echo $sta;
}
function guardaEnvio(){
	$venta=new ventas($_POST["id"]);
	$result=$venta->setEnvios($_POST["p_fecha"], $_POST["p_numero"], $_POST["p_cantidad"], $_POST["p_direccion"], $_POST["p_agencia"],$_POST["p_monto"]);
}
function guardaDescuento(){
	$venta=new ventas($_POST["id"]);
	echo $venta->setDescuento($_POST["monto"]);
}
function guardaComentario(){
	$venta=new ventas($_POST["id"]);
	echo $venta->setComentario($_POST["nota"]);
}
function pagina1(){
	$ventas=new ventas();
	$listaVentas=$ventas->listarPorUsuario(1,$_POST["pagina"],$_POST["orden"]);
	$foto=new fotos();
    if($listaVentas):
		foreach ($listaVentas as $l => $valor):
			$usua=new usuario($valor["usuarios_id"]);
			$publi=new publicaciones($valor["publicaciones_id"]);			
			$venta=new ventas($valor["id"]);
			$statusPago=$venta->getStatusPago();
			switch($statusPago){
				case "Pago pendiente":
					$claseColor="amarillo-apdp";
					break;
				case "Pago incompleto":
					$claseColor="naranja-apdp";
					break;
				case "Pago verificado":
					$claseColor="verde-apdp";
					break;
				case "Pago rechazado":
					$claseColor="rojo-apdp";
					break;	
				default:
					$claseColor="";
					break;											
			}
			$maximo=is_null($valor["maximo"])?$valor["cantidad"]:$valor["maximo"];
			if($maximo<$valor["cantidad"]){
				$statusEnvio="Envio en camino";
				$claseColor2="naranja-apdp";
			}else{
				$statusEnvio="Envio pendiente";
				$claseColor2="rojo-apdp";
			}
//			$statusEnvio=$maximo>0?"Envio pendiente":"Envio en curso";
//			$statusEnvio=$venta->getStatusEnvio();
		?>
				<div id="venta<?php echo $valor["id"];?>">
					<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 vin-blue t14  '>
						 <span id='#' class="negro t14"><?php echo $usua->getNombre();?></span>
						<br>
						<span class=''><a href="perfil.php?id=<?php echo $usua->id;?>"><?php echo $usua->a_seudonimo;?></a></span>
						<br>
						<span class=" grisC t12"><?php echo $usua->a_email;?></span>
						<br>
						<span class="t12"><?php echo $usua->u_telefono;?></span>
					</div>
					<div class='col-xs-12 col-sm-12 col-md-1 col-lg-1  '>
							<div class='marco-foto-publicaciones  point ' style='width: 65px; height: 65px;' > 
							<a href="detalle.php?id=<?php echo $publi->id;?>"><img src='<?php echo $publi->getFotoPrincipal();?>' width='100%' height='100%;' 
							style='border: 1px solid #ccc;' class='img img-responsive center-block imagen' data-id='#'> </div>
					</div>
					<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 vin-blue t14  '>
						<div style="margin-left: 3%;">
						<span class='detalle.php'> <a href='detalle.php?id=<?php echo $venta->publicaciones_id;?>'> <span id='#'><?php echo $valor["titulo"];?></span></a></span>
						<br>
						<span class='red t14' id='#'>Bs <?php echo $valor["monto"];?> </span>  <span class='t12 opacity' id='#'> x <?php echo $valor["cantidad"];?> und</span>
						</div>
					</div>
					<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 vin-blue t14  '>					
						<div class="t12 pad5 " style="background: #FAFAFA">	
						 <span><a class="vinculopagos" href="#" data-toggle="modal" data-target="#pagos-ven" id="pago<?php echo $valor["id"];?>" name="pago<?php echo $valor["id"];?>"><i class="fa fa-credit-card <?php echo $claseColor;?>"></i> <span><?php echo $statusPago;?></span></a></span> 
						<br>
						 <span ><a class="vinculoenvios" href="#" id="envio<?php echo $valor["id"];?>" name="envio<?php echo $valor["id"];?>" data-maximo="<?php echo $maximo;?>"> <i class="fa fa-truck <?php echo $claseColor2;?>"></i> <span><?php echo $statusEnvio;?></span></a></span> 
						<br>
						 <span ></span><i class="fa fa-clock-o"></i> <span><?php echo $venta->getTiempoCompra();?> en espera</span>
						<br>
						 <span><i class="fa fa-exclamation-triangle"></i> Reclamo abierto</span>
						</div>
					</div>
					<div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 text-center t12 '>
						<div class='btn-group pull-right marR10'>				
							<a href="detalle-ventas.php?id=<?php echo $valor["id"];?>"><button class="btn2 btn-default">Ver detalle</button></a> 
							<div class="dropdown pull-right">
  								<button class="btn2 btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
   									<i class="fa fa-cog"></i>
  								</button>
  								<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    								<li><a class="vinculodescuento" href="#" data-toggle="modal" data-target="#descuento" id="desc<?php echo $valor["id"];?>" name="desc<?php echo $valor["id"];?>" data-monto=<?php echo $valor["monto"];?>>Agregar descuento</a></li>
    								<li><a href="#" data-toggle="modal" data-target="#comentario">Agregar comentario</a></li>
  								</ul>
							</div>						
						</div>
					</div>
					<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10'>
						<center><hr class=' center-block'></center>
					</div>
				</div>
				<?php
					endforeach;
				endif;	
}
function pagina2(){
	$ventas=new ventas();
	$listaVentas=$ventas->listarPorUsuario(3,$_POST["pagina"],$_POST["orden"]);
	$foto=new fotos();	
		if($listaVentas):
				foreach ($listaVentas as $l => $valor):
					$usua=new usuario($valor["usuarios_id"]);
					$publi=new publicaciones($valor["publicaciones_id"]);
					$venta=new ventas($valor["id"]);
					$statusPago=$venta->getStatusPago();
					$maximo=is_null($valor["maximo"])?$valor["cantidad"]:$valor["maximo"];
					if($maximo==0){
						$statusEnvio="Enviado";
					}elseif($maximo<$valor["cantidad"]){
						$statusEnvio="Envio en camino";
					}else{
						$statusEnvio="Envio pendiente";
					}
				?>	
				<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 vin-blue t14  '>
					 <span id='#' class="negro t14"><?php echo $usua->getNombre();?></span>
					<br>
					<span class=''><?php echo $usua->a_seudonimo;?></span>
					<br>
					<span class=" grisC t12"><?php echo $usua->a_email;?></span>
					<br>
					<span class="t12"><?php echo $usua->u_telefono;?></span>
				</div>
				<div class='col-xs-12 col-sm-12 col-md-1 col-lg-1  '>
						<div class='marco-foto-publicaciones  point ' style='width: 65px; height: 65px;' > 
						<a href="detalle.php?id=<?php echo $publi->id;?>"><img src='<?php echo $publi->getFotoPrincipal();?>' width='100%' height='100%;' 
						style='border: 1px solid #ccc;' class='img img-responsive center-block imagen' data-id='#'> </div>
				</div>
				<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 vin-blue t14  '>
					<div style="margin-left: 3%;">
					<span class='detalle.php'> <a href='detalle.php?id=<?php echo $venta->publicaciones_id;?>'> <span id='#'><?php echo $valor["titulo"];?></span></a></span>
					<br>
					<span class='red t14' id='#'>Bs <?php echo $valor["monto"];?> </span>  <span class='t12 opacity' id='#'> x <?php echo $valor["cantidad"];?> und</span>
					</div>
				</div>
				<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 vin-blue t14  '>					
					<div class="t12 pad5 " style="background: #FAFAFA">	
					 <span><a class="vinculopagos" href="#" data-toggle="modal" data-target="#pagos-ven2" id="pago<?php echo $valor["id"];?>" name="pago<?php echo $valor["id"];?>"><i class="fa fa-credit-card verde-apdp"></i> <span><?php echo $statusPago;?></span></a></span> 
					<br>
					 <span ><a class="vinculoenvios" href="#" id="envio<?php echo $valor["id"];?>" name="envio<?php echo $valor["id"];?>" data-maximo="<?php echo $maximo;?>"> <i class="fa fa-truck verde-apdp"></i> <span><?php echo $statusEnvio;?></span></a></span> 
					<br>
					 <span ></span><i class="fa fa-clock-o"></i> <span>despachado en <?php echo $venta->getTiempoCompra(2);?> </span>
					<br>
					 <span><i class="fa fa-exclamation-triangle"></i> Reclamo abierto</span>
					</div>
				</div>
				<div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 text-center t12 '>
					<div class='btn-group pull-right marR10'>				
							<button class="btn2 btn-default">Ver detalle</button> 
							<div class="dropdown pull-right">
  							<button class="btn2 btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
   							<i class="fa fa-cog"></i>
  							</button>
  								<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							    <li><a class="vinculocomentario" href="#" data-toggle="modal" data-target="#comentario" id="comen<?php echo $valor["id"];?>" name="comen<?php echo $valor["id"];?>" data-nota="<?php echo $valor["nota"];?>">Agregar comentario</a></li>
 								</ul>
						</div>						
						</div>
				</div>		
				<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10'>
					<center><hr class=' center-block'></center></div>
				<?php
					endforeach;
				endif;	
}
function ordena(){
	$ventas=new ventas();
	if($_POST["origen"]==1){
		$listaVentas=$ventas->listarPorUsuario(1,1,$_POST["orden"]); //Ventas sin concretar
	}else{
		$listaVentas=$ventas->listarPorUsuario(3,1,$_POST["orden"]); //Ventas concretadas
	}
    if($listaVentas):
		foreach ($listaVentas as $l => $valor):
			$usua=new usuario($valor["usuarios_id"]);
			$publi=new publicaciones($valor["publicaciones_id"]);
			$venta=new ventas($valor["id"]);
			$statusPago=$venta->getStatusPago();
			switch($statusPago){
				case "Pago pendiente":
					$claseColor="amarillo-apdp";
					break;
				case "Pago incompleto":
					$claseColor="naranja-apdp";
					break;
				case "Pago verificado":
					$claseColor="verde-apdp";
					break;
				case "Pago rechazado":
					$claseColor="rojo-apdp";
					break;	
				default:
					$claseColor="";
					break;											
			}
			$maximo=is_null($valor["maximo"])?$valor["cantidad"]:$valor["maximo"];
			if($maximo<$valor["cantidad"]){
				$statusEnvio="Envio en camino";
				$claseColor2="naranja-apdp";
			}else{
				$statusEnvio="Envio pendiente";
				$claseColor2="rojo-apdp";
			}
		?>
		<div id="venta<?php echo $valor["id"];?>">
			<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 vin-blue t14  '>
				 <span id='#' class="negro t14"><?php echo $usua->getNombre();?></span>
				<br>
				<span class=''><?php echo $usua->a_seudonimo;?></span>
				<br>
				<span class=" grisC t12"><?php echo $usua->a_email;?></span>
				<br>
				<span class="t12"><?php echo $usua->u_telefono;?></span>
			</div>
			<div class='col-xs-12 col-sm-12 col-md-1 col-lg-1  '>
				<div class='marco-foto-publicaciones  point ' style='width: 65px; height: 65px;' > 
					<a href="detalle.php?id=<?php echo $publi->id;?>"><img src='<?php echo $publi->getFotoPrincipal();?>' width='100%' height='100%;' 
						style='border: 1px solid #ccc;' class='img img-responsive center-block imagen' data-id='#'> </div>
				</div>
				<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 vin-blue t14  '>
					<div style="margin-left: 3%;">
					<span class='detalle.php'> <a href='detalle.php?id=<?php echo $venta->publicaciones_id;?>'> <span id='#'><?php echo $valor["titulo"];?></span></a></span>
					<br>
					<span class='red t14' id='#'>Bs <?php echo $valor["monto"];?> </span>  <span class='t12 opacity' id='#'> x <?php echo $valor["cantidad"];?> und</span>
				</div>
			</div>
			<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 vin-blue t14  '>					
				<div class="t12 pad5 " style="background: #FAFAFA">	
					 <span><a class="vinculopagos" href="#" data-toggle="modal" data-target="#pagos-ven" id="pago<?php echo $valor["id"];?>" name="pago<?php echo $valor["id"];?>"><i class="fa fa-credit-card <?php echo $claseColor;?>"></i> <span><?php echo $statusPago;?></span></a></span> 
					<br>
					 <span ><a class="vinculoenvios" href="#" id="envio<?php echo $valor["id"];?>" name="envio<?php echo $valor["id"];?>" data-maximo="<?php echo $maximo;?>"> <i class="fa fa-truck <?php echo $claseColor2;?>"></i> <span><?php echo $statusEnvio;?></span></a></span> 
					<br>
					 <span ></span><i class="fa fa-clock-o"></i> <span><?php echo $venta->getTiempoCompra();?> en espera</span>
					<br>
					 <span><i class="fa fa-exclamation-triangle"></i> Reclamo abierto</span>
				</div>
			</div>
			<div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 text-center t12 '>
				<div class='btn-group pull-right marR10'>
					<a href="detalle-ventas.php?id=<?php echo $valor["id"];?>"><button class="btn2 btn-default">Ver detalle</button></a> 
					<div class="dropdown pull-right">
						  <button class="btn2 btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
   								<i class="fa fa-cog"></i>
  						  </button>
  						  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    							<li><a class="vinculodescuento" href="#" data-toggle="modal" data-target="#descuento" id="desc<?php echo $valor["id"];?>" name="desc<?php echo $valor["id"];?>" data-monto=<?php echo $valor["monto"];?>>Agregar descuento</a></li>
    							<li><a class="vinculocomentario" href="#" data-toggle="modal" data-target="#comentario" id="comen<?php echo $valor["id"];?>" name="comen<?php echo $valor["id"];?>" data-nota="<?php echo $valor["nota"];?>">Agregar comentario</a></li>
  						  </ul>
					</div>						
				</div>
			</div>
			<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10'>
				<center><hr class=' center-block'></center>
			</div>
		</div>
		<?php
		endforeach;
	endif;	
}
?>