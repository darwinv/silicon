<?php
require '../../../config/core.php';
include_once "../../../clases/usuarios.php";
include_once "../../../clases/publicaciones.php";
switch($_POST["metodo"]){
	case "buscarFavoritos":
		buscaFavoritos();
		break;
	case "buscarPublicaciones":
		buscaPublicaciones();
		break;	
}
function buscaFavoritos(){
if(!isset($_SESSION["id"])){
	session_start();
}
$usua=new usuario($_SESSION["id"]);
$pagina=1;
if(!isset($_POST["pagina"])){
	$publicaciones=$usua->getPublicacionesFavoritas($_POST["orden"]);
}else{
	$publicaciones=$usua->getPublicacionesFavoritas($_POST["orden"],$_POST["pagina"]);
}
										$ac=0;
									foreach($publicaciones as $key => $valor) {
										if($_POST["palabra"]==""){
											$mostrar="block";
										}elseif(strpos(strtoupper($valor["titulo"]),strtoupper($_POST["palabra"]))!==false){
											$mostrar="block";
										}else{
											$mostrar="none";
										}
										$ac++;
										$publi=new publicaciones($valor["id"]);
										$estado=$usua->getEstado();
										$cadena="
										<div class='general' id='general" . $valor["id"] . "' name='general" . $valor["id"] . "' data-titulo='{$valor["titulo"]}' data-id='{$valor["id"]}' style='display:$mostrar'>
											<div class=' col-xs-12 col-sm-12 col-md-12 col-lg-12 marT20'></div>
											<div class=' col-xs-12 col-sm-6 col-md-2 col-lg-2 ' ><!-- inicio del registro de la publicacion-->
								    		<div class='marco-foto-conf  point marL20  ' style='height:130px; width: 130px;'  >
									    	<div style='position:absolute; left:40px; top:10px; ' class='f-condicion'>" . $publi->getCondicion() . "</div>							 
									    	<img src='" . $publi->getFotoPrincipal() . "' class='img img-responsive center-block img-apdp imagen' data-id='" . $valor["id"] . "'>						
											</div>
											</div>
											<div class=' col-xs-12 col-sm-6 col-md-7 col-lg-7'>
										<p class='t16 marL10 marT5'>
										    <span class=' t15'><a class='negro' href='detalle.php?id=" . $publi->id . "' class='grisO'><b>" . $publi->titulo . "</b></a></span>
											<br>
											<span class=' vin-blue t14'><a href='' class=''><b>" . $usua->a_seudonimo . "</b></a></span>
											<br>
											<span class='t14 grisO '>" . $usua->getNombre() . "</span>
											<br>
											<span class='t12 grisO '><i class='glyphicon glyphicon-time t14  opacity'></i>" . $publi->getTiempoPublicacion() . "</span>
											<br>
											<span class='t11 grisO'> <span> <i class='fa fa-eye negro opacity'></i></span><span class='marL5'> " . $publi->getVisitas() . " Visitas</span><i class='fa fa-thumbs-up negro marL15 opacity'>
											</i><span class='  h-under marL5'>" . $publi->getFavoritos() .  " Me gusta</span><i class='fa fa-share-alt negro marL15 opacity hidden'></i> <span class=' hidden point h-under marL5'>15 Veces compartido</span> </span>
								      </p>
								    </div>
								    <div class=' col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right'>
								    	<br>
								    	<div class='marR20'>
								    		<span class='red t20'><b>". $publi->getMonto() . "</b></span >
											<br>
											<span class=' t12'>" . $estado . "</span>
											<br>
											<span class='vin-blue t16'><a href='detalle.php?id=" . $valor["id"] . "' style='text-decoration:underline;'>Ver Mas</a></span >
										</div>
									</div>
									<div class='col-xs-12 col-sm-12 col-md-12 col-lg-2'><br></div>
									<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'><hr class='marR10'><br></div> </div><!-- inicio del registro de la publicacion-->";									
									echo $cadena;
								}
								

}

function buscaPublicaciones(){
if(!isset($_SESSION["id"])){
	session_start();
}
$usua=new usuario($_POST["id"]);
$pagina=1;
if(!isset($_POST["pagina"])){
	$publicaciones=$usua->getPublicaciones(1);
}else{
	$publicaciones=$usua->getPublicaciones(1,$_POST["pagina"]);
}
										$ac=0;
									foreach($publicaciones as $key => $valor) {
										if($_POST["palabra"]==""){
											$mostrar="block";
										}elseif(strpos(strtoupper($valor["titulo"]),strtoupper($_POST["palabra"]))!==false){
											$mostrar="block";
										}else{
											$mostrar="none";
										}
										$ac++;
										$publi=new publicaciones($valor["id"]);
										$estado=$usua->getEstado();
										$cadena="
										<div class='general' id='general" . $valor["id"] . "' name='general" . $valor["id"] . "' data-titulo='{$valor["titulo"]}' data-id='{$valor["id"]}' style='display:$mostrar'>
											<div class=' col-xs-12 col-sm-12 col-md-12 col-lg-12 marT20'></div>
											<div class=' col-xs-12 col-sm-6 col-md-2 col-lg-2 ' ><!-- inicio del registro de la publicacion-->
								    		<div class='marco-foto-conf  point marL20  ' style='height:130px; width: 130px;'  >
									    	<div style='position:absolute; left:40px; top:10px; ' class='f-condicion'>" . $publi->getCondicion() . "</div>							 
									    	<img src='" . $publi->getFotoPrincipal() . "' class='img img-responsive center-block img-apdp imagen' data-id='" . $valor["id"] . "'>						
											</div>
											</div>
											<div class=' col-xs-12 col-sm-6 col-md-7 col-lg-7'>
										<p class='t16 marL10 marT5'>
										    <span class=' t15'><a class='negro' href='detalle.php?id=" . $publi->id . "' class='grisO'><b>" . $publi->titulo . "</b></a></span>
											<br>
											<span class=' vin-blue t14'><a href='' class=''><b>" . $usua->a_seudonimo . "</b></a></span>
											<br>
											<span class='t14 grisO '>" . $usua->getNombre() . "</span>
											<br>
											<span class='t12 grisO '><i class='glyphicon glyphicon-time t14  opacity'></i>" . $publi->getTiempoPublicacion() . "</span>
											<br>
											<span class='t11 grisO'> <span> <i class='fa fa-eye negro opacity'></i></span><span class='marL5'> " . $publi->getVisitas() . " Visitas</span><i class='fa fa-thumbs-up negro marL15 opacity'>
											</i><span class='  h-under marL5'>" . $publi->getFavoritos() .  " Me gusta</span><i class='fa fa-share-alt negro marL15 opacity hidden'></i> <span class=' hidden point h-under marL5'>15 Veces compartido</span> </span>
								      </p>
								    </div>
								    <div class=' col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right'>
								    	<br>
								    	<div class='marR20'>
								    		<span class='red t20'><b>". $publi->getMonto() . "</b></span >
											<br>
											<span class=' t12'>" . $estado . "</span>
											<br>
											<span class='vin-blue t16'><a href='detalle.php?id=" . $valor["id"] . "' style='text-decoration:underline;'>Ver Mas</a></span >
										</div>
									</div>
									<div class='col-xs-12 col-sm-12 col-md-12 col-lg-2'><br></div>
									<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'><hr class='marR10'><br></div> </div><!-- inicio del registro de la publicacion-->";									
									echo $cadena;
								}
								

}
?>