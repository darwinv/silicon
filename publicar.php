<?php require 'config/core.php';
include_once 'fcn/varlogin.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php include "fcn/incluir-css-js.php";?>
<!-- include adicional (editor) debe ir antes del body -->
<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script> 
<link rel="stylesheet" href="js/cropit/cropit.css">

<?php include "temas/header.php";?>
<div class="container">	
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 conte1">
		<?php include "paginas/publicar/p_header.php";?>
		<div id="ajaxContainer" style="display: block;">
			<?php include "paginas/publicar/p_publicar1-1.php"; ?>
		</div>	
		<div id="ajaxContainer2"></div>	
		<div id="ajaxContainer3" style="display: none;">
			<?php include "paginas/publicar/p_publicar3.php"; ?>
		</div>	
	</div>
</div>
<div class="modal-backdrop fade in cargador" style="display:none"></div>
<script type="text/javascript" src="js/autoNumeric/autoNumeric-min.js"></script>
<script type="text/javascript" src="js/publicaciones.js"></script>
<?php 
include "modales/m_cropper.php";
include "temas/footer.php";
;?>
</html>
