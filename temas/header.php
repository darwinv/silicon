<header class="header">
<?php

if (! isset ( $_SESSION )) {
	session_start();
}
if(isset($_COOKIE["c_id"])){
	$_SESSION["id"]=$_COOKIE["c_id"];
	$_SESSION["seudonimo"]=$_COOKIE["c_seudonimo"];
	$_SESSION["fotoperfil"]=$_COOKIE["c_fotoperfil"];
	$_SESSION["nivel"]=$_COOKIE["c_nivel"];	
	$_SESSION["id_rol"]=$_COOKIE["c_id_rol"];	
}
if (isset ( $_SESSION ["id"] )) {
	include_once "clases/usuarios.php";
	include ("menu-top-usr.php");
} else {
	include ("menu-top.php");
}

?>
</header>
<?php 
include ("js/script.php");
include"modales/m_contacto.php";
include"modales/m_recover.php";
include"modales/m_tipo_usuario.php";
include"modales/m_inscribir_redes.php";

?>