<?php require 'config/core.php'; 
include 'fcn/varlogin.php';?>
<!DOCTYPE html>
<html lang="es">
<?php include "fcn/incluir-css-js.php";?>
<body>
<script type="text/javascript" src="js/notificaciones.js"></script>
<link href="css/notificaciones.css" rel="stylesheet">
<?php include "temas/header.php";?>
<div class="container">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pad-top25">
			<?php 
				include "paginas/notificaciones/p_notificaciones.php";
			?>
		</div>
		 
</div>
	<?php include "temas/footer.php";?>

</body>
</html>
