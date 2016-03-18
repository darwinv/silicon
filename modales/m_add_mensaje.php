<div class="modal fade  bs-example-modal-lg modal-conf" data-type="pass" tabindex="-1" role="dialog"
aria-labelledby="myLargeModalLabel" id="add-msj">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<form name="new_msg_manager" id="new_msg_manager">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h3 class="modal-title " ><img src="galeria/img-site/logos/mascota.png" width="50" height="51"><span
					class="marL15"><span id="titulo" name="titulo">Mensaje Nuevo / Editar Mensaje</span></h3>
				</div>
				<div class="modal-body marL20 marR20 ">
					<br>
					<div class=" contenedor sombra-left" >
						<!-- contenedor General 1er bloque-->
						<div class=" conte-div-img-red row">
							<!--INICIO contenedor de las fotos de perfiles de las cuentas de las redes sociales-->
							
							<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
								<div class="cfb_manager">
									 <div id="fffb" data-rs="fb" class="redsocial" style="position: relative">
									 <a href="#"><img id="f-fb" src="galeria/img-site/logos/silueta-bill.png" class="img-red-perfil center-block marB5 opacity"   /> </a>
									 <i id="fb" data-fb="0" class="fa fa-check-circle green" style="display: none; position: absolute; top: 2px; right: 40px;"></i>
									 </div>
									 <div class="marB5 text-center ">Facebook</div>
								</div>
								<div class="cfp_manager">
									 <div id="fffp" data-rs="fp" class="redsocial"style="position: relative">
									  <a href="#"><img id="f-fp" src="galeria/img-site/logos/silueta-bill.png" class="img-red-perfil center-block marB5 opacity"   /> </a>
									 <i id="fp" data-fp="0" class="fa fa-check-circle green" style="display: none;  position: absolute; top: 2px; right: 40px;"></i>
									 </div> 
									<div class="marB5 text-center">FanPage</div>	
								</div>
								<div class="ctw_manager">
									<div id="fftw" data-rs="tw" class="redsocial" style="position: relative">
									  <a href="#"><img id="f-tw" src="galeria/img-site/logos/silueta-bill.png" class="img-red-perfil center-block marB5 opacity"   /> </a>
									 <i id="tw" data-tw="0" class="fa fa-check-circle green" style="display: none;  position: absolute; top: 2px; right: 40px;"></i>
									 </div>
									 <div class="marB5 text-center">Twitter</div>
								</div>
									 <div id="ffgr" data-rs="gr" class="redsocial"style="position: relative">
									  <a href="#"><img id="f-gr" src="galeria/img-site/logos/silueta-bill.png" class="img-red-perfil center-block marB5 opacity"   /> </a>
									 <i id="gr" data-gr="0" class="fa fa-check-circle green" style="display: none;  position: absolute; top: 2px; right: 40px;"></i>
									 </div>
									<div class="marB5 text-center">Grupo</div>
								
								 
							</div>
							<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" style="border-left: 1px dashed #CCC; ">
							<textarea id="descripcion_nm" name="descripcion_nm"   cols="" placeholder=" Escribe tu mensaje"
											class="form-textarea-msj " ></textarea>
											<div style="background:#FFF; width:100%; " class="text-right  pad10">
							<span id="restante_nm" name="restante_nm" class="t12 grisO"> 140 </span>
						</div>
						</div>
						
					</div>
					</div>
					
					<div class="contenedor marT5 sombra-right " >
						<!-- contenedor general 2do bloque-->

						<div class="div-menu-msj">
							<!-- menu de calendario y de subir imagenes y seleccion de tipo de mensaje -->
							<div style="width: 150px; display: inline-flex">
								<a href="#" class="text-dec-none" id="btnCalendario" name="btnCalendario"><span class="grisC ">Programar Fecha</span><i class="fa fa-calendar t24 marL10 grisO" ></i></a>
							</div>
							<div style="width: 150px; display: inline-flex">
								<a href="#" id="btnImagenes" name="btnImagenes" class="text-dec-none"><span class="grisC ">Insertar Imagen</span><i class="fa fa-picture-o t24 marL10 grisO" ></i></a>
							</div>
							<div style="display: inline-flex" class="marL20 pull-right">
								<a id="delete_thingy" href="#"><i class="fa fa-remove"></i> Eliminar Mensaje </a>
							</div>
						</div>

						<div  id="imagenes" name="imagenes" class="text-center vertical-centered-text div-option-msj" style="display:none; position:relative">
							<!-- opciones de calendario y de subir imagenes -->
							<span id="arrastrar_manager" class="16 grisC calendario foto2 ">Arrastra tus fotos aqui </span>
							<div id="imagen_manager" class="subir-img-active foto marL20 hidden" style="float: none;">
								<img id="1" class="img-responsive"/>
								<i id="imagen_delete" style="position: relative; top:-92px; left:84%;" class="fa fa-times red hidden"></i>
								</i>
							</div>
						</div>
							<div class="form-group">
							<div class="row ">
								
									<!--<form id="pickDateForm" method="post" class="form-horizontal"  style="border-right: solid 1px #CCC;" data-tipo="date"> 
											   <input type="text" class="col-xs-12 col-sm-6 col-md-3 col-lg-3 calendario" name="dob" id="dob"/>							  
									</form>-->			 
								<div id="from" data-tipo="desde" class="col-xs-12 col-sm-6 col-md-3 col-lg-3 calendario" style="border-right: solid 1px #CCC;">
									Desde
									<input id="fromm" name="from"  type="text" class="date-input form-control" style="display:none;"/>		  
								</div>
									
								<div id="2" data-tipo="hasta" class="col-xs-12 col-sm-6 col-md-3 col-lg-3 calendario" style="border-right: solid 1px #CCC;">
									Hasta
									<input id="t2" name="until"  type="text" class="date-input form-control" style="display:none;"/>		  
								</div>
								
								<div id="3" data-tipo="hora" class="col-xs-12 col-sm-6 col-md-3 col-lg-3 calendario" style="border-right: solid 1px #CCC;">
									Hora
									<input id="t3" name="hour"  type="text" class="date-input form-control" style="display:none;"/>		  
								</div>
								
								
									<div id="3" data-tipo="hora" class="col-xs-12 col-sm-6 col-md-3 col-lg-3 calendario " >
									<span id="dia" data-toggle="modal" data-target="#dias">Dias</span>
								  </div>
							
					<?php include "modales/m_dias.php"; ?>			
						</div>
						<div id="date-picker"> </div>
			
						</div>
					</div>
				</div>

				<div class="modal-footer">

					<button id="btnLimpiar" name="btnLimpiar" type="reset" class="btn btn-default btn-usr-act btn-usr-act marT15 marB5" data-action="act-pass">
						Limpiar
					</button>
					<button type="submit" class="btn btn-primary2 btn-usr-act btn-usr-act marT10 marB5" data-action="act-pass">
						<span id="btn-ok"></span>
					</button>
				</div>

			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->