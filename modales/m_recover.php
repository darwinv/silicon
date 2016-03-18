
<div class="modal fade" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="recover">
	<div class="modal-dialog modal-lg">
		<form method="post" id="recover-password" name="recover-password"
			action="fcn/f_usuarios.php" method="POST">
			<div class="modal-content"
				style="padding-top: 50px; padding-bottom: 50px;">

				<button type="button" class="close marR30 grisO" data-dismiss="modal"
					aria-label="Close" style="margin-top: -25px;">
					<span aria-hidden="true">&times;</span>
				</button>
				<br>
				<img alt="" src="galeria/img-site/logos/logo-modal2.png" width="auto" height="150px"
					class="center-block ">
				<h2 class="text-center me-p_contenido" style="color: #000;">Recuperar contrase&ntilde;a</h2>
				<br>

				<div class="center-block" style="width: 50%">
	
					<div class="form-group center-block text-left">
						<input type="text" placeholder="Seudonimo / Correo" name="rec_usuario" class="form-input"
								id="rec_usuario">
					</div>
					
					<div class="text-center">
						<button id="usr-log-submit" type="submit" 
									class="btn2 btn-primary2 btn-group-justified">Recuperar</button>
					</div>
				</div>
				<br>
			</div>
		</form>
	</div>
</div> 


