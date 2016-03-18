<?php require 'config/core.php';
include_once "fcn/varlogin.php";
?>
<!DOCTYPE html>
<html lang="es">
<?php include "fcn/incluir-css-js.php";?>
<!-- include adicional (editor) debe ir antes del body -->
<link rel="stylesheet" href="js/cropit/cropit.css">
<script type="text/javascript" src="js/tinymce/tinymce.min.js"> </script> 
<!--<script type="text/javascript" src="js/htmledit/trumbowyg.min.js"></script>-->
<!-- <script type="text/javascript" src="js/htmledit/langs/es.min.js"> </script> -->
<body>
<?php include "temas/header.php";?>
<div class="container">	
	<div class="row">
	<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 ">
		<?php include "temas/menu-left-usr.php";?>
	</div>
	<?php if($_GET["type"]=='1') { ?> 
	<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 ">	
		<div class="marL20 " id="primero" name="primero"><?php include "paginas/venta/p_admin_publicaciones.php";?></div>
	</div>
	<?php }?>
	<?php if($_GET["type"]=='2') { ?> 
	<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 ">	
		<div class="marL20 " id="primero" name="primero"><?php include "paginas/venta/p_ventas.php";?></div>
	</div>
	<?php }?>
	
	</div>
</div>
<?php include "modales/m_edit_publicacion.php";?>
<?php include "modales/m_cropper.php";?>
<?php include "modales/m_pagos_ven.php";?>
<?php include "modales/m_pagos_ven2.php";?>
<?php include "modales/m_descuento.php";?>
<?php include "modales/m_comentario.php";
	  include"modales/m_info_user.php";
?>

<script type="text/javascript" src="js/autoNumeric/autoNumeric-min.js"></script>
<script type="text/javascript" src="js/ventas.js"></script>
<div class="modal-backdrop fade in cargador" style="display:none"></div>
</body>
</html>
