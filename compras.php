<?php require "config/core.php";
if(isset($_GET["tipo2"])){
	if($_GET["tipo2"]==1){   
		$clase1="";
		$clase2="hidden";
	}else{
		$clase1="hidden";
		$clase2="";
	}
	$tipo2=$_GET["tipo2"];
}else{
	$clase1="";
	$clase2="hidden";	
	$tipo2="";
}
include_once "fcn/varlogin.php";
?>
<!DOCTYPE html>
<html lang="es">
<?php include "fcn/incluir-css-js.php";?>
<!-- include adicional (editor) debe ir antes del body -->
<link rel="stylesheet" href="js/htmledit/ui/trumbowyg.css">
<!-- <link rel="stylesheet" href="js/cropit/cropit.css"> 
<script type="text/javascript" src="js/htmledit/trumbowyg.min.js"></script>
<script type="text/javascript" src="js/htmledit/langs/es.min.js"></script> -->
<body data-tipo='<?php echo $tipo2;?>'>
<?php include "temas/header.php";?>
<div class="container">	
	<div class="row">
		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 ">
			<?php include "temas/menu-left-usr.php";?>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 ">
			<div class="marL20 " id="segundo" name="segundo">
				<?php include "paginas/compra/p_compras.php";?>
			</div>
		</div>
	</div>
</div>
<?php include "modales/m_edit_publicacion.php";?>
<?php include "modales/m_cropper.php";?>
<?php include "modales/m_pagos_ven.php";?>
<?php include "modales/m_pagos_ven2.php";?>
<?php include "modales/m_envios_ven.php";?>
<?php include "modales/m_descuento.php";?>
<?php include "modales/m_comentario.php";?>
<?php include "modales/m_informar_pago.php";?>
<script type="text/javascript" src="js/autoNumeric/autoNumeric-min.js"></script>
<script type="text/javascript" src="js/compras.js"></script>
<div class="modal-backdrop fade in cargador" style="display:none"></div>
</body>
</html>