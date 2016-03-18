<div class="modal fade bs-example-modal-lg modal-info-seguidor" data-type=""  tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="info-seguidor">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title ">
					<img src="galeria/img-site/logos/mascota.png" ><span
						id="" class="marL15"></span>
				</h3>
			</div>
			
				<div class="modal-body">

                    <div class=" marL30 row">

                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                            <div class="marco-foto-conf" style="width:150px; height:150px;"<a href="#" ><img class="fotoperfil" width="100%" height="100%;" class="img img-responsive"  ></a></div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 text-left " style="margin-left:-5px;">
                        <br> 
                            <br>
                            <span class="seudonimo t16"> </span>
                            <br>
                            <span class="nombres t14"> </span>
                            <br>
                            <span class="telefono t14"> </span>
                            <br>
						    <span class="correo t14"> </span>
								
                        </div>           			
                    </div>
                    <br>
				<div class="modal-footer">
					<button class="btn btn-danger bloqueo-seguidor actualiza-follow" data-userbloq="" data-user="<?php if(isset($_SESSION["id"])) echo $_SESSION ["id"]; ?>" data-dismiss="modal">Bloquear</button>
					<button class="btn btn-primary2" data-dismiss="modal">Continuar</button>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->