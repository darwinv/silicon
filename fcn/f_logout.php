<?php
/*Destruimos la sesion al llamar a esta pagina*/
if(isset($_COOKIE["c_id"])){
    setcookie("c_id","",-1000,'/');
    setcookie("c_seudonimo","",-1000,'/');
    setcookie("c_fotoperfil","",-1000,'/');
    setcookie("c_nivel","",-1000,'/');
	setcookie("c_id_rol","",-1000,'/');
}
session_start ();
if (isset ( $_SESSION ["id"] )):
	session_destroy ();
	header("Location: index.php");
else:
	header("Location: index.php");
endif;