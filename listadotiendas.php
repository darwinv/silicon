<?php require 'config/core.php'; ?>
<!DOCTYPE html>
<html lang="es">
<?php include "fcn/incluir-css-js.php";?>
<body>
<script type="text/javascript" src="js/listadotiendas.js"></script>
<?php include "temas/header.php";?>
<div class="container">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
			<?php include "paginas/listadotiendas/p_listado.php"; ?>
		</div>
	</div>
<?php 
include "temas/footer.php";
include "modales/m_registrar.php";
?>
<div class="modal-backdrop fade in cargador" style="display:none"></div>
</body>
</html>
