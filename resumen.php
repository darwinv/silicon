<?php require 'config/core.php';?>
<!DOCTYPE html>
<html lang="es">
<?php
include 'fcn/varlogin.php';
include ("fcn/incluir-css-js.php");
?>
<body>
<?php
include ("temas/header.php");
?>
<div class="container">
	<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
		<?php include("temas/menu-left-usr.php"); ?>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
		<?php
			if(!isset($_SESSION)){
			    session_start();	
			} 
    
			##########VARIABLE CREADA EN MENU TOP USER#########
			if($_SESSION["id_rol"]=='1' || $_SESSION["id_rol"] =='2'){
				include("paginas/resumen/p_resumen.php"); 
			}else{				
				include("paginas/resumen/p_resumen_cliente.php"); 
			}
			?>
	</div>
</div>
<?php
include ("temas/footer.php");
?>

</body>
</html>