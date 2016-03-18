<?php require 'config/core.php'; ?>
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
	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
		<?php include("temas/menu-left-usr.php"); ?>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
		<?php include("paginas/configuracion/p_confi_datos.php"); ?>
	</div>
</div>
<?php
include ("temas/footer.php");
include ("modales/m_edit_info_personal_n.php");
include ("modales/m_edit_info_personal_j.php");
include ("modales/m_edit_info_seudonimo.php");
include ("modales/m_edit_info_correo.php");
include ("modales/m_edit_info_pass.php");

?>
<script type="text/javascript" src="js/configuracion.js"></script>
</body>
</html>