<?php 
if (!headers_sent()) {
	header('Content-Type: text/html; charset=UTF-8');
}

// Incluimos las clases a usar.
include_once '../../clases/usuarios.php';
include_once '../../clases/fotos.php';
include_once '../../clases/amigos.php';
// validamos el session_start
if (! isset ( $_SESSION )) :
	session_start ();
endif;
// validamos que el id este seteado, caso contrario regresamos al usuario a otra pagina
if (isset ( $_GET ["id"] )) :
	$usuario = new usuario ( $_GET ["id"] ); // instanciamos la clase usuario(perfil a ver)
	$estado_id = $usuario->u_estados_id; // obtengo el id del estado para luego mostrar
	$bd = new bd ();
endif;
if (isset ( $_SESSION ["id"] )) :
	$usuarioActual = new usuario ( $_SESSION ["id"] );
	$estado_id = $usuarioActual->u_estados_id;
endif;
?>
<div class="contenedor" style="margin-top: 25px">
	<br class="hidden-xs"> <br>
	<div class="row mar-perfil-amigos">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="row"
				style="background: #f5f5f5; padding-top: 15px; padding-bottom: 15px; border: solid 1px #ccc;">
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<div>
						<h3 class="  titulo-perfil ">
							<i class="fa fa-users"></i> Panas
						</h3>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 text-right">
					<div class="navbar-form marR10 marL10" role="search">
						<div class="input-group input">
							<input name="q" id="q" type="text" class="form-control input-xs "
								placeholder="Buscar"> <span class="input-group-btn">
								<button id="amigoSearch" class="btn btn-default input-xs" style="width: 50px;">
									<span class="glyphicon glyphicon-search"></span>
								</button>
							</span>
						</div>
						<select class="form-control input" id="filter" name="filter">
							<option value="all">Todos</option>
							<option value="ven" disabled>Mas ventas</option>
							<option value="jur">Empresas</option>
							<option value="nat">Personas</option>
							<?php $row = $bd->doSingleSelect("estados","id = $estado_id")?>
							<option value="<?php echo $row["id"]?>"><?php echo $row["nombre"]?></option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<br>
		</div>
		<!--===== CONTENIDO AMIGOS =====-->
		<div id="ajaxAmigos">
		<?php include 'fcn/f_amigos.php';?> 
		</div>
		<!--=== FIN CONTENIDO AMIGOS ===-->
	</div>
	<br> <br class="hidden-xs"> <br class="hidden-xs">
</div>
