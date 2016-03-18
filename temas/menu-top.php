
<nav class="navbar menu-cabecera navbar-inverse navbar-static-top" role="navigation">
	<div class="container">
		<div class="navbar-header ">
			<button type="button" class=" navbar-toggle collapsed"
				data-toggle="collapse" data-target="#menuP">
				<span class="sr-only">Mostrar / Ocultar</span> <span
					class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
			<a href="index.php" class="navbar-brand"> <img style=""
				class="marT5 marB5 marL5" src="galeria/img-site/logos/logo-header.png"
				width="auto" height="50px">
			</a>
		</div>
		<div class="collapse navbar-collapse " id="menuP">
			<div class="navbar-form navbar-left  marT15 mar-buscador ">
				<div class="input-group">
					 <input id="txtBuscar" name="txtBuscar"
						style="margin-left: -10px; border-left: trasparent;width:250px;" name="c"
						type="text" class="form-control-header2 buscador" placeholder="Buscar" >
						<span class="input-group-btn"> 
						<button class="btn-header2 btn-default-header2 buscadorBoton"
							style="width: 50px;" id="btnBuscar" name="btnBuscar">
							<span class="glyphicon glyphicon-search"></span>
					</button>
				</span>
				</div>
			</div>
			<form id="usr-log-form" name="usr-log-form" data-url="public" action="fcn/f_usuarios.php" method="POST">
				<ul class="nav navbar-nav navbar-right t16">
				<li>
					<a href="#" class="marT10 alert-reg li-icon-top" data-toggle='modal' data-target='#insc-red'> Inscribete </a>
				</li>
				<li>
					<div class="vertical-line size-line "></div>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle marT10 li-icon-top"
					data-toggle="dropdown" role="button" aria-expanded="false"
					style=""> Ingresa 
					</a>
					<ul class="dropdown-menu dropdown-menu-log " role="menu">
						<li style="padding: 12px;">Inicia Sesi&oacute;n</li>
						<li style="padding: 10px;">
						<div class="form-group">
						<input type="text" placeholder=" Seudonimo / Correo" name="log_usuario" class="form-input"
							id="log_usuario">
							</div></li>
						<li style="padding: 10px;"><div class="form-group"><input type="password"
							placeholder=" Contrase&#241;a" name="log_password" class=" form-input" id="log_password"></div>
							<p class="text-right t10 marR5 vin-blue">
								<a href="#" data-toggle="modal" data-target="#recover">&#191;Olvidaste la Contrase&#241;a?</a>
							</p></li>
						<li style="padding: 10px; margin-top: -20px"><button id="usr-log-submit" type="submit" 
								class="btn2 btn-primary2 btn-group-justified">Ingresar</button>
								<br>
								<button id="fb_log_button"
								class="btn2 btn-facebook btn-group-justified marT5 t12">Ingresar con Facebook</button>
								
								<button id="tw_log_button"
								class="btn2 btn-twitter btn-group-justified marT5 t12">Ingresar con Twitter</button>
							
								</li>
						<!--	<li class="divider"></li>
							<li style="padding: 10px;"><p class="t12 text-center">&#191;Eres
									nuevo en Vogues Eshop?</p>
								<button class="btn2 btn-default btn-group-justified " data-toggle="modal" data-target="#actualizar2">Inscribete</button></li> -->
						</ul>
					</li>
					<li>
						<div class="vertical-line size-line"></div>
						</li>
					<li>
						<a href="informar_pago.php" class="marT10 li-icon-top" > Informar Pago&nbsp; <i class="fa fa-credit-card"></i> </a>
					</li>
				</ul>
			</form>
		</div>
		</div>
	</div>
</nav>
