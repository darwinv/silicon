<?php
require '../config/core.php';
include_once "../clases/publicaciones.php";
include_once "../clases/usuarios.php";
switch($_POST["metodo"]){
	case "buscarPublicaciones":
		buscaPublicaciones();
		break;
}

 function buscaPublicaciones(){
    
	$inicio=(($_POST["pagina"] - 1)*5);
	$consulta="select * from publicaciones where id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 AND fecha_fin IS NULL) order by id desc limit 5 OFFSET $inicio";
	$result=$this->query($consulta);
	$resultTotal=$this->query("select count(*) as tota from publicaciones where id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 AND fecha_fin IS NULL)");
	foreach ($resultTotal as $r => $valor) {
		$total=$valor["tota"];
	}	
	$i=0;
    foreach($result as $r){
    	$i++;
    	$publicacion=new publicaciones($r["id"]);
		$usua=new usuario($publicacion->usuarios_id);
		if($_POST["pagina"]==1){
			$izquierda="";
		}else{
			$izquierda=($i==1)?" <i class='fa fa-caret-left t30 point izquierda'style='position:absolute; top:37%; left:-2%; ' id='izquierda' onClick='javascript:buscaIzquierda();'></i>":"";
		}
		if($_POST["pagina"]==5){
			$derecha="";
		}else{
			if($total<=$_POST["pagina"]*5){
				$derecha="";
			}else{
				$derecha=($i==5)?" <i class='fa fa-caret-right t30 point derecha'style='position:absolute; float:right; top:37%; right:15%; ' id='derecha' onClick='javascript:buscaDerecha();'></i>":"";
			}
		}
    	$cadena="
	    	<div class='col-xs-12 col-sm-12 col-md-6 col-lg-2'>
	    	$izquierda
	    			<div class='text-center mar10 publicaciones1' style='relative;width:70%;' id='$publicacion->id' onClick='javascript:verDetalle($publicacion->id)'>
				    	<br>
				    	<div class='marco-foto-conf  point center-block sombra-div3 ' style='height:120px; width: 120px;'  >
						<img src='" . $publicacion->getFotoPrincipal() . "'  class=' img-responsive center-block img-apdp'>
						</div>
						<br>
						<span class='negro t16'>" .  ($publicacion->tituloFormateado(15)) . "</span>
						<br>
						<span class='red t14'><b>" . $publicacion->getMonto() . "</b></span>
						<br>
						<span class='t12 grisC'>" . $usua->getEstado() . "</span> &nbsp;&nbsp; <span class='t12 grisC'><i class='fa fa-clock-o'></i>" . $publicacion->getTiempoPublicacion() . "</span>
						<br>
						<br>
					</div>
					$derecha
			</div>
		";
		echo $cadena;
		if($i==5){
			break;
		}
	}
}
?>