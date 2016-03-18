<?php
/*codigo estandar para validar que se inicie session*/
/*REQUERIDO EN TODAS LAS PAGINAS RESTRINGIDAS*/
session_start();
if(!isset($_SESSION["id"])):
	header("Location: index.php");
// else:
// 	$url = $_SERVER ['REQUEST_URI'];
// 	$pagina = substr ( $url, strrpos ( $url, '/' ) + 1 );
// 	if($_SESSION["rol"] == "USUARIO" and $pagina == "usuarios.php"):
// 		header("Location: admin.php");
// 	endif;
endif;