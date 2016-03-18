<?php
if (!headers_sent()) {
	header('Content-Type: text/html; charset=UTF-8');
}
require '../../../config/core.php';
include_once "../../../clases/clasificados.php";
include_once "../../../clases/publicaciones.php";
switch($_POST["metodo"]){
	case "traerClasificados":
		traerClasificados();
		break;
	case "guardar":
		guardarPublicacion();
		break;
	default:
		echo "Error:";
		exit();
		break;
}

function traerClasificados(){
	$clasificados=new clasificados();
    $resultado=$clasificados->buscarHijos($_POST["id_clasificados"]);
    if($resultado){
       $array = array();
       foreach($resultado as $r)  {
    	   $array[] = array(
    			"campos" => array(
    					"id" =>  ($r['id']),
    					"nombre" =>  ($r['nombre'])
    			)
    	  );
       }
       echo json_encode($array);
    }else{
         echo json_encode(array("resultado"=>"Error"));
    }
}

function guardarPublicacion(){
	//We have to save inside the follow tables
	//publicacionesxstatus
	//publicaciones_montos
	//visitas_publicaciones
	//publicaciones	
	session_start();
	$publicacion = new publicaciones();
	$listaValores=array(			
			"titulo"=>$_POST["txtTitulo"],
			"descripcion"=>$_POST["editor"],
			"stock"=>$_POST["txtCantidad"],
			"dias_garantia"=>isset($_POST["chkGarantia"])?$_POST["cmbGarantia"]:NULL,
			"dafactura"=>isset($_POST["chkEntregaFactura"])?'S':'N',
			"estienda"=>isset($_POST["chkEresTienda"])?'S':'N',
			"clasificados_id"=>$_POST["idclas"],
			"condiciones_publicaciones_id"=>1,
			"vencimientos_publicaciones_id"=>2,
			"usuarios_id"=>$_SESSION["id"],
			"publicar_facebook"=>$_POST["fb"],
			"publicar_twitter"=>$_POST["tt"],
			"publicar_fanpage"=>$_POST["fp"],
			"publicar_grupo"=>$_POST["gr"]);
	$monto = $_POST["monto"];
	$fecha = date("Y-m-d H:i:s",time());;
	$listaValores["dias_garantia"]=str_replace("gn", "&ntilde;", $listaValores["dias_garantia"]);
	for ($i=0; $i < 6 ; $i++) {
		if(isset($_POST["foto-".$i])){
			$fotos[] = $_POST["foto-".$i];
		}		
	}
	$listaValores["titulo"]=($listaValores["titulo"]);
	$idPub = $publicacion->nuevaPublicacion($listaValores,$monto,$fecha,$fotos);
	//echo json_encode(array("result" => "error","query" => $idPub ));
	if($idPub){
		echo json_encode(array("result" => "OK", "id" => $idPub));
	}else{
		echo json_encode(array("result" => "error"));
	}
}
/*Existen tres variables $SESSION, id, seudonimo, fotoperfil*/
?>