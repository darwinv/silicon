<?php 
if (!headers_sent()) {
    header('Content-Type: text/html; charset=UTF-8');
} 
/*
 * Pagina de Perfil
* REQUIERE "usuarios.php,fotos.php,amigos.php
* RECIBE "id" ->mediate get
* RETORNA "contenido perfil"
*/
// Incluimos las clases a usar.
if(file_exists('../../clases/usuarios.php')){
	include_once '../../clases/usuarios.php';
	include_once '../../clases/fotos.php';
	include_once '../../clases/amigos.php';
}

// validamos el session_start
if (! isset ( $_SESSION )) {
	session_start ();
}
if (isset ( $_GET ["id"] )) {
	$usuario = new usuario ( $_GET ["id"] ); // instanciamos la clase usuario(perfil a ver)
	$bd = new bd ();
}
if(isset($_SESSION["id"])){
	if($_GET["id"] == $_SESSION["id"]){
		$edit= 1;
		$direccion=",{$usuario->u_direccion}";
	}else{
		$direccion="";
	}
}
?>
<div class="contenedor" style="margin-top: 25px">
	<br class="hidden-xs"> <br>

	<div class="row mar-perfil-informacion">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div
				style="background: #f5f5f5; padding-top: 15px; padding-bottom: 15px; border: solid 1px #ccc;">
				<h3 class="titulo-perfil">
					<i class="fa fa-user"></i> Informaci&oacute;n
				</h3>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<br>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			<br>
			<div class="perfil-info-menu  mar-perfil-informacion">
				<div class="act" data-href="#informacion">
					<i class="fa fa-share"></i> Informaci&oacute;n Personal
				</div>
				<br>
				<div data-href="#redes">
					<i class="fa fa-share"></i> Informaci&oacute;n Social
				</div>
				<br>
				<div data-href="#ventas">
					<i class="fa fa-share"></i> Informac&oacute;n de Ventas
				</div>
				<br>
				<div>
					<i class="fa fa-share"></i> Mas
				</div>
				<br>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
			<section id="informacion" class="borde-left-informacion sec-informacion">
				<div class="contenedor sombra-div mar10 mar-perfil-informacion"
					style="padding: 10px;">
					<b class="marR5">Telefono:</b> <?php echo $usuario->u_telefono;?>
				</div>
				<div class="contenedor sombra-div mar10 mar-perfil-informacion"
					style="padding: 10px;">
					<b class="marR5">Correo:</b> <?php echo $usuario->a_email;?>
				</div>
				<div class="contenedor sombra-div mar10 mar-perfil-informacion"
					style="padding: 10px;">
					<b class="marR5">Ubicaci&oacute;n:</b> 
					<?php $row = $bd->doSingleSelect("estados","id = {$usuario->u_estados_id}")?>
					<?php $row2 = $bd->doSingleSelect("paises","id = {$row["paises_id"]}")?>
					<?php echo "{$row2["nombre"]}, {$row["nombre"]} $direccion"?>
				</div>
			</section>
			<?php if(isset($edit)):?>
			<div class="text-right marR20">
				<a href="configuracion.php">Editar</a>
			</div>
			<?php endif;?>
			<br> <br>
			<section id="redes" class="borde-left-informacion sec-informacion">
				<div class="contenedor sombra-div mar10 mar-perfil-informacion "
					style="padding: 10px;">
					<b class="marR5">Algo sobre mi:</b> <?php echo is_null($usuario->u_descripcion)?"<span class='opacity'>Sin informacion</span>":$usuario->u_descripcion;?>
				</div>
				<div class="contenedor sombra-div mar10 mar-perfil-informacion "
					style="padding: 10px;">
					<b class="marR5">Sitio Web: </b> <?php echo is_null($usuario->u_website)?"<span class='opacity'>Sin informacion</span>":$usuario->u_website;?>
				</div>
				<div class="contenedor sombra-div mar10 mar-perfil-informacion "
					style="padding: 10px;">
					<b class="marR5">Facebook: </b> <?php echo is_null($usuario->u_facebook)?"<span class='opacity'>Sin informacion</span>":$usuario->u_facebook;?>
				</div>
				<div class="contenedor sombra-div mar10 mar-perfil-informacion "
					style="padding: 10px;">
					<b class="marR5">Twitter: </b><?php echo is_null($usuario->u_twitter)?"<span class='opacity'>Sin informacion</span>":$usuario->u_twitter;?>
				</div>
			</section>
			<?php if(isset($edit)):?>
			<div class="text-right marR20">
				<a href="#" data-toggle="modal" data-target="#info-social" id="btn-info-social" name="btn-info-social">Editar</a>
			</div>
			<?php endif;?>
			<br> <br>
			<section id="ventas" class="borde-left-informacion sec-informacion">
				<div class="hidden contenedor sombra-div mar10 mar-perfil-informacion "
					style="padding: 10px;">
					<b class="marR5">Ventas:</b> <br>
					<div class="btn-group btn-group-justified mar-ventas" role="group"
			aria-label="..." style="">
			<div class="btn-group hidden-xs " role="group" style="">
				<button 
					class="btn btn-ventas">
					Hoy <span class="green t18 under-score">55</span>
				</button>
			</div>
			<div class="btn-group" role="group" >
				<button  class="btn btn-ventas">Ayer <span class="green t18 under-score">55</span> </button>
			</div>
			<div class="btn-group" role="group" data-href="paginas/perfil/p_perfil_informacion.php">
				<button class="btn btn-ventas ">
						Este Mes <span class="green t18 under-score">55</span>
					</button>
			</div>
			<div class="btn-group" role="group" data-href="paginas/perfil/p_perfil_amigos.php">
				<button  class="btn btn-ventas">
						Mes Anterior <span class="green t18 under-score">55</span>
					</button>
			</div>
			<div class="btn-group" role="group">
				<button  class="btn btn-ventas "
						style="border-right: 1px solid #ccc">
					Todas <span class="green t18 under-score">55</span>
					</button>
			</div>
		</div>
				</div>
				<div  class="contenedor hidden sombra-div mar10 mar-perfil-informacion "
					style="padding: 10px;">
					<b>Reputaci&oacute;n</b>
					<div class="progress">
						<div
							class="progress-bar progress-bar-success progress-bar-striped active"
							role="progressbar" aria-valuenow="50" aria-valuemin="0"
							aria-valuemax="100" style="width: 50%"></div>
					</div>
					<p class="t14 text-left marL5 marR5 marT5  mar0 ">
						<span class="green t16 marR10"><i class="fa fa-plus-square "></i>
							<span class="grisO">0</span></span> <span class="red2 t16 marR10"><i
							class="fa fa-minus-square "></i> <span class="grisO">0</span></span>
						<span class="blueO-apdp t16 "><i class="fa fa-circle "></i> <span
							class="grisO">0</span></span>
					</p>
				</div>
				<div class="contenedor sombra-div mar10 mar-perfil-informacion "
					style="padding: 10px;">
					<b class="marR5">Experiencia: </b> 
					<?php echo $usuario->getTiempo();?> vendiendo en <span class="orange-apdp">A Precio De Pana</span>
					
				</div>

			</section>
			<div class="text-right marR20 hidden">
				<a href="resumen.php">Ver todas las calificaciones</a>
			</div>
		</div>
	</div>

	<br> <br class="hidden-xs"> <br class="hidden-xs">
</div>

