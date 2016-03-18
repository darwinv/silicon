<?php require 'config/core.php'; ?>
<!DOCTYPE html>
<html lang="es">
<?php
include 'fcn/varlogin.php';
include ("fcn/incluir-css-js.php"); 
?>
<script type="text/javascript" src="js/proveedor.js"></script>
<link href="css/proveedor.css" rel="stylesheet">
<body>
<?php
include ("temas/header.php"); 
 
?> 
 
<div class="container pad-top70">
	<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
		<?php include("temas/menu-left-usr.php"); ?>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
		<?php include("paginas/proveedor/p_proveedor.php"); ?>
	</div> 	
</div>
<?php
include "temas/footer.php";
include"modales/m_registrar_proveedor.php";
include"modales/m_edit_proveedor.php";
include"modales/m_info_prov.php";
?>

</body>
</html>