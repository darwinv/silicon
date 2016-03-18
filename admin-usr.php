<?php require 'config/core.php'; ?>
<!DOCTYPE html>
<html lang="es">
<?php
include 'fcn/varlogin.php';
include ("fcn/incluir-css-js.php"); 
?>
<script type="text/javascript" src="js/usuarios.js"></script> 

<body>
<?php
include ("temas/header.php"); 
 
?> 
 
<div class="container pad-top70">
	<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
		<?php include("temas/menu-left-usr.php"); ?>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
		<?php include("paginas/adminusr/p_adminusr.php"); ?>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marT40">
			<?php include "temas/footer.php";?>
	</div>	
</div>
<?php

include"modales/m_delete.php"; 
include"modales/m_active.php"; 
include"modales/m_edif_info_user.php"; 
include"modales/m_registrar_by_admin.php";
include"modales/m_info_user.php";
?>

</body>
</html>