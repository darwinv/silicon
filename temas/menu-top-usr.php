<?php
include_once "clases/publicaciones.php";
if(!isset($_SESSION)){
    session_start();	
}
/*else{
	
	$usr = new usuario($_SESSION["id"]);	
	$cant_compras = $usr->getCantRespuestas();
	$cant_ventas = $usr -> getCantNotificacionPregunta();
	$visto=0;
}*/
?> 
<nav class="navbar menu-cabecera navbar-inverse navbar-static-top" role="navigation ">
	<div class="container">
		<div class="navbar-header ">
			<button type="button" class=" navbar-toggle collapsed"
				data-toggle="collapse" data-target="#menuP">
				<span class="sr-only">Mostrar / Ocultar</span> <span
					class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
			<a href="index.php" class="navbar-brand"> <img style=""
				class=" marT5 marB5 marL5" src="galeria/img-site/logos/logo-header.png"
				width="auto" height="50px">
			</a>
		</div>
		<div class="collapse navbar-collapse " id="menuP">
			<div	class="navbar-form navbar-left  marT15 mar-buscador "> 
<!--	            <form> --> 
				<div class="input-group">
					<input id="txtBuscar" name="txtBuscar"
						style="margin-left: -10px; border-left: trasparent;width:250px;" name="c"
						type="text" class="form-control-header2 buscador" placeholder="Buscar" >
						<span class="input-group-btn"> 
						<button class="btn-header2 btn-default-header2 buscadorBoton"
							style="width: 50px;" id="btnBuscar" name="btnBuscar">
							<span class="glyphicon glyphicon-search"></span>
					</button>
				</span> 
				</div>
		</div>
			<ul class="nav navbar-nav navbar-right t16">
				<li class="marT10 hidden-xs hidden-sm">
					<!-- <div class="borderS  point eti-blanco "
						style=" height: 40px; width: 40px;">
							<a href="perfil.php?id=<?php echo $_SESSION["id"];?>" > <img id="fotoperfilm" src="<?php echo $_SESSION["fotoperfil"];?>" id=""
							class="img img-responsive center-block"
							style="max-height: 96%; cursor: pointer;background:white;" data-container="body" data-toggle="popover" data-placement="bottom" 
							data-content="Actualiza tu foto de perfil">
						</a> 	
					</div>-->
				</li>
				<li>&nbsp;&nbsp;
				<li>
				<li class="dropdown"><a href="#" class="dropdown-toggle marT10 li-icon-top"
					data-toggle="dropdown" role="button" aria-expanded="false"
					style=""> <?php echo strtoupper($_SESSION["seudonimo"]);?> </a>
					<ul class="dropdown-menu blanco" role="menu">
						<li><a href="resumen.php">Mi Cuenta</a></li>
						<li><a href="salir.php">Salir</a></li>
					</ul></li>
				<li>
					<div class="vertical-line size-line" ></div>
				</li>
					<?php if ($_SESSION["id_rol"] == '3') { ?>
					<li><a href="informar_pago.php" class="marT10 li-icon-top " > Informar Pago</a></li>
					
					<li>
						<div class="vertical-line size-line" ></div>
					</li>
					
					<?php  } ?>
				</li>
				<!-- Se agrega la opcion en el caso de que sea admin -->
				<?php if ($_SESSION["id_rol"] <=2 ) { ?> 
				<li><a href="publicar.php" data-toggle="" data-target="" class="marT10 li-icon-top">Publicar</a></li>
				<li>
					<div class="vertical-line size-line"></div>
				</li>
  			<?php  } ?>
				<!--  Fin de la condicion-->
				<?php if ($_SESSION["id_rol"] == 1 ) { ?>
					<li><a href="admin-usr.php" data-toggle="" data-target="" class="marT10 li-icon-top">
						<i class="fa fa-users"></i> </a></li>
				
					<?php  } ?>
				
				
	<?php
	$usr = new usuario($_SESSION["id"]);
	
	if($_SESSION['id_rol']=='1' || $_SESSION['id_rol']=='2'){
		$cant_ventas = $usr -> getCantNotificacionPregunta(null);
		$alerts = $usr -> getAllNotificaciones(NULL);
		$cant_compras = 0;
	}
	else {
		$cant_compras = $usr->getCantRespuestas();
		$alerts = $usr -> getAllNotificaciones();
		$cant_ventas = 0;
	}
	$cant_panas = 0;
	$cant_pub = 0;
	
	$status = $usr -> s_status_usuarios_id;
	
	$visto=0;	
	
	$alertas = $cant_compras[0]["cant"] + $cant_ventas[0]["cant"] + $cant_panas[0]["cant"] + $cant_pub[0]["cant"];
 
?>
			 		
		
				<li id="notificacion" data-id="<?php echo $_SESSION["id"];?>" class="dropdown">
					<a href="#" data-toggle="dropdown" role="button" class="dropdown-toggle marT10 li-icon-top" onclick="<?php echo $visto=1; ?>" aria-expanded="false"
					style="">
					<?php if($alertas!=0){
						 echo '<span id="alerta" class="badge blanco" style="background: red; position: absolute; top: -2px; left: -1px;">';
						  echo $alertas; 
						   echo '</span>';
					}?>

					
					<i class="fa fa-bell"></i>  
					</a>
						  
			        <?php if($alerts->rowCount()>0){ ?>
					<ul class="dropdown-menu blanco alertas" role="menu"> 
						<?php 
						 
						foreach ($alerts as $a => $val) {
							$fecha = $val["fecha"];
							$tipo = $val["tipo"];
							$id_pana = $val["pana"];
							$id_pub = $val["pub"];
							$id_pre = $val["pregunta"];
							$pub = new publicaciones($id_pub);
							$segundos = strtotime('now')-strtotime($fecha);
							$tiempo = $pub -> getTiempo($segundos);
							if($tipo==1){//Pregunta
								$foto = $pub -> getFotoPrincipal();
								$title= $pub -> tituloFormateado();
								$id   = 1;
								$tema = "Te Preguntaron";
								$link = "pre_pub";
							}
							if($tipo==2){//Repuesta
								$foto = $pub -> getFotoPrincipal();
								$title= $pub -> tituloFormateado();
								$id   = 2;
								$tema = "Te Respondieron";
								$link = "resp_pub";
							}
							if($tipo==3){//Panas
								$foto = $usr -> buscarFotoUsuario($id_pana);
								$id   = $id_pana;
								$title= $usr -> getPana($id_pana);
								$tema = "Ahora te sigue";	
								$link = "ver-noti-seguidor";
							}
							if($tipo==4){//Publicacion
								$foto = $pub -> getFotoPrincipal();
								$title= $pub -> tituloFormateado();
								$tema = "Nuevos Articulos";
								$id   = $id_pub;
								$link = "detalle";
							}
						?>
						<li data-id="<?php echo $id; ?>" data-id_pub="<?php echo $id_pub; ?>"  class="<?php echo $link; ?> noti-hover pointer">
							<a class="" style="overflow: hidden;">
								<div style="display: inline-block;   ">
									<div style="padding-bottom: 5px;"><img src="<?php echo $foto; ?>" width="50px" height="50px"></div>
								</div>
								<div style="display:inline-block;    width: 145px; " >
									<div class="marL10" >						
										<b ><?php echo $title; ?></b>
									</span>
										<br>
										<span class="grisC t12"><?php echo $tema; ?></span>							
									</div>									
								</div>
								
								<div style="display: inline-block;  ">
									<!--<i class="fa fa-times" style="float: right; top: 5px;"></i>-->
									<div class="marL10"><p><span class="grisC opacity t10"><?php echo $tiempo; ?></span></p></div>
								</div>															
								

							</a>
						</li>
				<?php }?>
				
				<div class="AlertsFooter"><a class="seeMore" href="notificaciones.php" accesskey="5"><span>Ver todas</span></a></div>
				
				
						 </ul>
						 
						 <?php } ?>
				</li>	

					
					<?php if ($_SESSION["id_rol"] == 3 ) { ?>
						 	
					<li><a href="favoritos.php" data-toggle="" data-target="" class="marT10"><i
						class="fa fa-heart"></i> </a></li>	
					 <li><a href="#" data-toggle="modal" data-target="#contacto" class="marT10"><i
						class="fa fa-envelope"></i> </a></li>
						<?php } ?>
						
						
				<li class="hidden"><a href="#" data-toggle="modal" data-target="#ayuda" class="marT10"><i
						class="fa fa-question-circle"></i> </a></li>
			</ul>
		</div>
	</div>
</nav>
