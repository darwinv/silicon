<?php
require 'config/core.php';
// Incluimos las clases a usar.

include 'clases/usuarios.php';
include_once 'clases/fotos.php';
include 'clases/amigos.php';
include "clases/publicaciones.php";
?>
<!DOCTYPE html>
<html lang="es">
<?php include "fcn/incluir-css-js.php";?>
<body >
<?php include "temas/header.php";?>
<div class="container">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">			
			<?php include "paginas/pago/p_informar_pago.php"; ?>	
		</div>
	</div>
<?php include "temas/footer.php";?>
<div class="modal-backdrop fade in cargador" style="display:none"></div>
</body>
</html>
