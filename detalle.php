<?php
require 'config/core.php';
include_once "clases/publicaciones.php";
if (!isset ( $_GET ["id"] )) {
	header ( "Location: index.php" );
}else{
	$existe=$publicacion=new publicaciones($_GET["id"]);	
}
?>
<!DOCTYPE html>
<html lang="es">
<?php include "fcn/incluir-css-js.php";?>
<body>
<?php include "temas/header.php";?>
<script type="text/javascript" src="js/detalle.js"></script>
<div class="container " >
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
			<?php include "paginas/detalle/p_ruta.php"; ?>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 conte1">
			<?php include "paginas/detalle/p_detalle.php"; ?>
		</div>
		
	</div>
<?php 
include "temas/footer.php";
include "modales/m_registrar.php";
include "modales/m_comprar.php";
?>
<div class="modal-backdrop fade in cargador" style="display:none"></div>

</body>
</html>