<?php
include_once "clases/usuarios.php";
if(isset($_SESSION["id"])){
	$usua=new usuario($_SESSION["id"]);
	$correo=$usua->a_email;
	$nombre=$usua->getNombre();
	$habilitado="disabled";
}else{
	$habilitado="";
	$correo="";
	$nombre="";
}
?>
<div class="modal fade" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="contacto">
	<div class="modal-dialog modal-lg">
		<form method="post" id="enviar-email" name="enviar-email"
			action="" method="POST">
			<div class="modal-content"
				style="padding-top: 50px; padding-bottom: 50px;">

				<button type="button" class="close marR30 grisO" data-dismiss="modal"
					aria-label="Close" style="margin-top: -25px;">
					<span aria-hidden="true">&times;</span>
				</button>
				<br>
				<img alt="" src="galeria/img-site/icono_contacto.png"
					class="center-block img-responsive">
				<h1 class="text-center me-p_contenido" style="color: #000;">Cont&aacute;ctanos</h1>
				<br>

				<div class="center-block" style="width: 50%">
					<div class="form-group center-block text-left">
						<input type="text" class="form-control  marT5 text-left"
							id="nombre" name="nombre" placeholder="Nombre" <?php echo $habilitado; ?> value="<?php echo $nombre;?>">
					</div>

					<div class="form-group center-block text-left">
						<input type="text" class="form-control  marT5 text-left"
							id="email" name="email" placeholder="Email" <?php echo $habilitado; ?> value="<?php echo $correo;?>">
					</div>
					<div class="form-group center-block text-left">

						<textarea class="form-control marT5 text-left" id="mensaje"
							rows="6" name="mensaje" placeholder="Mensaje"></textarea>
					</div>
					<div class="text-center">
						<button class="btn btn-default" type="reset">Limpiar</button>
						<button type="submit" id="enviar" data-dismiss="modal"
					aria-label="Close" class="btn btn-primary2">Enviar</button>
					</div>
				</div>
				<br>
				<div class="center-block text-center" style="width: 80%">
					<?php echo COMPANY .", C.A. RIF: ".RIF." Dirección: ".DIRECCION ?>  <br>
					Telefonos: <?php echo CONTAC_TEFL1 ;?> / <?php echo CONTAC_TEFL2 ;?>  &nbsp; Email:
				<?php echo " ".EMAIL ;?>
				</div>
			</div>
		</form>
	</div>
</div> 


