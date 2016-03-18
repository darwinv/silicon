<?php require 'config/core.php'; ?>
<!DOCTYPE html>
<html lang="es">
<?php
include 'fcn/varlogin.php';
include ("fcn/incluir-css-js.php");
include "clases/publicaciones.php";
?>
<script type="text/javascript" src="js/usuarios.js"></script>
<body>
<?php
include ("temas/header.php");
include_once "clases/amigos.php";
?>
<div class="container">
	<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
		<?php include("temas/menu-left-usr.php"); ?>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
		<?php if($_GET["tipo"] == 1){ ?>
		<div > <?php include("paginas/preguntas/p_preguntas_v.php"); ?> </div>
		<br>
		<?php  }else{ ?> 
		<div id="pregunta_c" class=""> <?php include("paginas/preguntas/p_preguntas_c.php"); ?> </div>
		<?php }?>
	</div>
</div>
<?php
include ("temas/footer.php");
include"modales/m_info_user.php";
?>
</body>
</html>