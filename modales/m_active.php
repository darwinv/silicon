<div class="modal fade  bs-example-modal-lg modal-conf" data-type="pass" tabindex="-1" role="dialog"
aria-labelledby="myLargeModalLabel" id="msj-activar">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="usr-act-form-active" action="fcn/f_usuarios.php" method="post" class="usr-act-form-edit form-inline" data-status="1" data-method="updateStatus" >
				 
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
				aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title " ><img src="galeria/img-site/logos/mascota.png" width="50" height="51"><span
				class="marL15">Activar</span></h3>
			</div>

			<div class="modal-body marL20 marR20 ">		
				<br>	
				<p class="t16 text-center">&iquest;Estas seguro de continuar con la operaci&oacute;n?</p>
			</div>				
				
				
			<div class="modal-footer">
				<hr>
				<button type="submit" class="btn btn-default btn-usr-act btn-usr-act marT15 marB5" data-action="act-pass">
					Cancelar
				</button>
				<button type="submit"  class="btn btn-primary2 btn-usr-act btn-usr-act marT10 marB5" data-action="act-pass">
					Activar
				</button>
			</div>
			</form>

		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->