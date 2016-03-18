<div class="modal fade" id="foto_portada" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content ">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title ">
					<img src="galeria/img-site/logos/mascota.png" width="50" height="51"><span
						id="usr-reg-title" class="marL15">Edita tu portada</span>
				</h3>
			</div>
			<div class="modal-body ">
				<div class="image-editor center-block ">
					<input type="file" class="cropit-imagen-input">
					<!-- .cropit-image-preview-container is needed for background image to work -->
					<div class="cropit-image-preview-container " style="top:0px; left:100px; ">
						<div id="preview" class="cropit-image-preview " style="width: 960px;
  height: 540px;" ></div>
					</div>
					<br>
					<br>
					<div class="image-size-label">Resize image</div>
					<input type="range" class="cropit-image-zoom-input">
					
				</div>
			</div>
			<div class="modal-footer">
				<button id="cambiar-foto" type="button" class="btn btn-default">Cambiar Imagen</button>
				<button id="save-foto" type="button" class="btn btn-primary"
					data-dismiss="modal">Guardar</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="js/cropit/jquery.cropit.js"></script>
<script type="text/javascript" src="js/cropit/cropit.js"></script>