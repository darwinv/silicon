<?php require 'config/core.php'; ?>
<!DOCTYPE html>
<html lang="es">
	<?php	
	include "fcn/incluir-css-js.php";
	?>
	<link rel="stylesheet" type="text/css" href="css/slick.css" />
	<link rel="stylesheet" type="text/css" href="css/slick-theme.css"/>
	<body style="margin-top: 80px;">
		<?php include "temas/header.php";
		?>		
		<center>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " >
				<div style="" class="ancho85 center-block marB10"><?php include('paginas/index/principal.php'); ?></div>
			    <div class=" ancho85 pad20 div-principal " ><?php 
					include "paginas/index/p_index.php";
					?>
				</div>
					<br>
					<br>
<br>
<br>
				</div>	
			
		
			</center>		
		<?php
		include "temas/footer.php";
		include "modales/m_registrar.php";
		include "modales/m_emp_per.php";
		include "modales/m_edit_info_personal_n.php";
		include "modales/m_edit_info_personal_j.php";
		?>
		<div class="modal-backdrop fade in cargador" style="display:none"></div>
		</body>
	
	<!--INCLUIREMOS ACA DADO QUE SOLO SE USARA EN PRINCIPAL POR LOS MOMENTOS-->
	<script type="text/javascript" src="js/slick.min.js"></script>
	
	
</html>