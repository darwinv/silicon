<?php
include_once 'clases/usuarios.php';

if (isset ( $_SESSION ["id"] )) :
	$foto = $_SESSION ["fotoperfil"];
	$usuario = new usuario ( $_SESSION ["id"] );
	$tipo = is_null($usuario->j_rif)?"N":"J";
endif;
?>

<div class="contenedor">
<input type="file" class="hidden" id="input_foto">
	
		<!--<div style='overflow: hidden; height: 150px; width: 150px; margin-top: -30px;'
		class="pull-right borderS foto-resumen marco-foto-conf ">		
		 <img id="foto-usuario" src="<?php echo $foto;?>" style='height: 100%; width: 100%; '>	
		 <div  style="position: absolute; bottom:-25px; right:50px;" class="t14">Ver Perfil</div>
		</div> -->
		
	
	<h3 class=" marL20 marR20 negro text-center" style="padding: 10px;">
		<span class="marL10 ">Configuracion de datos</span>
	</h3>
	<br> <br> <i class="fa fa-user  borderS t26 marL30"
		style="width: 60px; text-align: center; padding: 10px;"></i><span
		class="marL10 t18 ">Informacion personal</span> <br> <br> <br>
	<?php if(is_null($usuario->j_rif)):?>
	<div class="linea-resumen marL30 marR30"
		style="border-top: 1px solid #e5e5e5">
		<b class="t14">Nombre: </b> <?php echo $usuario->n_nombre;?> <span class="opacity">
		</span>
	</div>
	<div class="linea-resumen marL30 marR30">
		<b class="t14">Apellido: </b> <?php echo $usuario->n_apellido;?> <span
			class="opacity"> </span>
	</div>
	<div class="linea-resumen marL30 marR30">
		<b class="t14">Documento de Identidad: </b> <?php echo $usuario->n_tipo."-".$usuario->n_identificacion;?> <span
			class="opacity"> </span>
	</div>
	<?php else:?>
	<div class="linea-resumen marL30 marR30"
		style="border-top: 1px solid #e5e5e5">
		<b class="t14">Razon Social: </b>  <?php echo $usuario->j_razon_social;?> <span
			class="opacity"> </span>
	</div>
	<div class="linea-resumen marL30 marR30">
		<b class="t14">RIF: </b> <?php echo "{$usuario->j_tipo}-{$usuario->j_rif}";?><span
			class="opacity"> </span>
	</div>
	<?php endif;?>	
	<div class="linea-resumen marL30 marR30">
		<b class="t14">Telefono:</b> <?php echo $usuario->u_telefono;?><span
			class="opacity"></span>
	</div>
	<div class="linea-resumen marL30 marR30">
		<b class="t14">Direccion:</b> <?php echo $usuario->u_direccion;?><span
			class="opacity"></span>
	</div>
	
	<div class=" marL30 marR30 text-right" style="padding: 10px;">
		<button type="button" class="btn btn-primary2" id="info-usuario" data-type="<?php echo $tipo;?>">Modificar</button>
	</div>
	<br> <i class="fa fa-lock  borderS t26 marL30"
		style="width: 60px; text-align: center; padding: 10px;"></i><span
		class="marL10 t18 ">Informacion de acceso</span> <br> <br> <br>

	<div class="linea-resumen marL30 marR30"
		style="border-top: 1px solid #e5e5e5">
		<b class="t14">Seudonimo: </b><?php echo $usuario->a_seudonimo;?> <span
			class="opacity"></span> <span class="vin-blue pull-right marR10"><a href="#" data-toggle="modal" data-target="#info-seudonimo">Editar</a></span>
	</div>
	<div class="linea-resumen marL30 marR30">
		<b class="t14">Correo: </b><?php echo $usuario->a_email;?>  <span class="opacity">
		</span> <span class="vin-blue pull-right marR10"><a href="#" data-toggle="modal" data-target="#info-correo">Editar</a></span>
	</div>
	<div class="linea-resumen marL30 marR30">
		<b class="t14">Contrase&ntilde;a: </b> ******** <span class="opacity"> </span> <span class="vin-blue pull-right marR10"><a href="#" data-toggle="modal" data-target="#info-pass">Editar</a></span>
	</div>
	<br> <br>
	<div class="linea-resumen marL30 marR30">
		<span> <a href="#" data-toggle="modal" data-target="#msj-eliminar">Desactivar Cuenta</a></span>
	</div>
	 <br> <br>
</div>