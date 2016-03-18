<?php
if(!isset($_SESSION)){
	session_start();
}
if(!isset($_SESSION["id"])){
	header ( "Location: index.php" );
}
if($_SESSION["nivel"]<1){
	header ( "Location: index.php" );
}
include_once "clases/bd.php";
$bd=new bd();
if(isset($_GET["usuario"])){
	$id_usuario=$_GET["usuario"];
	$bd->query("delete from usuariosxstatus where usuarios_id=$id_usuario");
	$bd->query("delete from usuarios_naturales where usuarios_id=$id_usuario");
	$bd->query("delete from usuarios_juridicos where usuarios_id=$id_usuario");
	$bd->query("delete from usuarios_accesos where usuarios_id=$id_usuario");
	$bd->query("delete from manager_tw_acc where userid=$id_usuario");
	$bd->query("delete from usuarios where id=$id_usuario");
}
if(isset($_GET["usuario"])){
	echo "Eliminado el usuario id=$id_usuario <br>";
}else{
	echo "No especific&oacute; que usuario desea eliminar<br>";
}
if(isset($_GET["publicacion"])){
	$id_publicacion=$_GET["publicacion"];
	$visita=$bd->doSingleSelect("publicaciones","id=$id_publicacion","visitas_publicaciones_id");
	if(!empty($visita)){
		$id_visita=$visita["visitas_publicaciones_id"];
	}else{
		$id_visita=-1;
	}
	$bd->query("delete FROM fotosxpublicaciones WHERE publicaciones_id=$id_publicacion");
	$bd->query("delete FROM publicaciones_montos WHERE publicaciones_id=$id_publicacion");
	$bd->query("delete FROM publicacionesxstatus WHERE publicaciones_id=$id_publicacion");
	$bd->query("delete FROM preguntas_publicaciones WHERE publicaciones_id=$id_publicacion");
	$bd->query("delete FROM publicaciones WHERE id=$id_publicacion");
	$bd->query("delete FROM publicaciones_favoritos WHERE visitas_publicaciones_id=$id_visita");	
	$bd->query("delete FROM visitas_publicaciones WHERE id=$id_visita");
}
	
if(isset($_GET["publicacion"])){
	echo "Eliminada la publicacion id=$id_publicacion <br>";
}else{
	echo "No especific&oacute; que publicacion desea eliminar<br>";
}
?>