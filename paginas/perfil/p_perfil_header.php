<?php

/*
 * Pagina de Perfil
 * REQUIERE "usuarios.php,fotos.php,amigos.php
 * RECIBE "id" ->mediate get
 * RETORNA "contenido perfil"
 */
// Incluimos las clases a usar.
include_once 'clases/usuarios.php';
include_once 'clases/fotos.php';
include_once 'clases/amigos.php';
// validamos el session_start
if (! isset ( $_SESSION )) {
	session_start ();
}
if (isset ( $_GET ["id"] )) {
	$usuario = new usuario ( $_GET ["id"] ); // instanciamos la clase usuario(perfil a ver)
	$foto = new fotos (); // instanciamos la clase fotos
	$ruta = $foto->buscarFotoUsuario ( $_GET ["id"] ); // asignamos la ruta de la foto de perfil
	$rutaP = $foto->buscarFotoPort( $_GET ["id"] );
	$bd = new bd ();
	$amigos = new amigos();
	$megustan = $amigos->contarMeGustan( $_GET ["id"] );
}
if (isset ( $_SESSION ["id"] )) {
	$usuarioActual = new usuario ( $_SESSION ["id"] );
	if($amigos->yamegusta( $_GET ["id"], $_SESSION ["id"])){
		$yamegusta = "Te gusta";
		$iconomegusta = "fa-thumbs-up";
		$contador = $megustan;
		$megustan ="";		
		$datamegusta = "data-action = 'dislike'";
	}else{
		$yamegusta = "Me gusta";
		$iconomegusta = "fa-thumbs-up";
		$datamegusta = "data-action = 'like'";
		$contador = $megustan;
	}	
	if($usuarioActual->id == $usuario->id):
	$oculto = "hidden";
	endif;
}else{
	$oculto = "hidden";
}
?>
<?php $input_foto = "";
	  $input_banner = "";
 if(isset($usuarioActual)):
	if($usuarioActual->id == $usuario->id): 
		$input_foto = "subir-foto-perfil";
		$input_banner = "subir-foto-portada";
	endif;
endif;?>	
<script>
$(document).ready(function(){
	$('#open-popup').magnificPopup({
		closeBtnInside: true,
    items: [
      {
        src: '<?php echo $ruta;?>', 
      }
    ],
    type: 'image' // this is a default type
});
});
</script>

<div id="my-popup" class="mfp-hide white-popup "></div>

<div class="row" style="margin-left: -5px; margin-right: -5px;">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
		<div class="portada text-center">
			<div id="" class="">
			<img id="img-portada" data-foto="por" src="<?php echo $rutaP ?>"
				class="img img-responsive hidden-xs <?php echo $input_banner;?> foto-perfil">	
				<?php if(isset($usuarioActual)):
					  if($usuarioActual->id == $usuario->id):?>
						<div class="actualizar " ><i class="fa fa-camera"></i> Actualizar</div>
				<?php endif; endif; ?>		
			</div>
									
			
			<div class='rota-img marco-foto-perfil '>
				<!--<a class="fancybox-thumb" rel="fancybox-thumb" href="<?php echo $ruta;?>" title=""> -->
				<div id=<?php if($usuarioActual->id != $usuario->id):?>"open-popup" <?php endif?>>
				<img id='img-perfil' data-foto="per" alt="" width="200px" height="200px" src='<?php echo $ruta;?>'
					class='img img-responsive center-block foto-perfil '  data-id="<?php echo $_GET['id'];?>">  <!--</a>--> 
					<?php if(isset($usuarioActual)):?>
						<?php if($usuarioActual->id == $usuario->id):?>
							<div class="actualizar <?php echo $input_foto; ?>" style="z-index: 10000;" ><i class="fa fa-camera" ></i> Actualizar</div>
						<?php endif;?>
					<?php endif;?>	
					
				</div>
			
					<div class="seu-nom-perfil-header center-block" style="width:500px;">
					<b class="texto-perfil-header"><?php echo strtoupper($usuario->a_seudonimo);?></b>
					<br>
					<span class="texto2-perfil-header">
					<?php if(is_null($usuario->j_rif)):
							echo $usuario->getNombre();
						  else:
						  	$row = $bd->doSingleSelect("categorias_juridicos","id = {$usuario->j_categorias_juridicos_id}");
						  	echo $row["nombre"];
						  endif;?>
					</span>
					</div>
					
			</div>		
			
		<!--	<?php if(isset($usuarioActual)):?>
						<?php if($usuarioActual->id == $usuario->id):?>
							</div>
						<?php endif;?>
				<?php endif;?>		-->
			<div class="  btn-group  mar-me-gusta  pull-right-me-gusta "
				role="group">
				<button type="button" style="padding-top: 5px; padding-bottom: 5px; font-size: 12px;" data-count="<?php echo isset($contador)?$contador:$megustan;?>"
					class="btn2 btn-default2 <?php echo isset($oculto)?$oculto:'';?>" id="btn-megusta"  <?php echo isset($datamegusta)?$datamegusta:"";?> >
					<i class="fa <?php echo isset($iconomegusta)?$iconomegusta:"fa-thumbs-up";?>"></i> <?php echo isset($yamegusta)?$yamegusta:"Me gusta";?>
				</button>
				<!-- Boton de compartir 
					<button type="button" style="padding-top: 5px; padding-bottom: 5px; font-size: 12px;"
					class="btn2 btn-default2">
					<i class="fa fa-share-alt "></i> 0 Compartido
				</button>
				-->
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
		<div class="btn-group btn-group-justified perfil-menu" role="group"
			aria-label="..." style="">
			<div class="btn-group hidden-xs " role="group" style="">
				<button type="button" style="cursor: auto;"
					class="btn btn-default3">
					<br>
				</button>
			</div>
			<div class="btn-group" role="group" data-href="paginas/perfil/p_perfil_listado.php">
				<button type="button" class="btn btn-default2 btn-default2-active">Publicaciones</button>
			</div>
			<div class="btn-group" role="group" data-href="paginas/perfil/p_perfil_informacion.php">
				<button type="button" class="btn btn-default2 ">
						<b>Informacion</b>
					</button>
			</div>
			<div class="btn-group" role="group" data-href="paginas/perfil/p_perfil_amigos.php">
				<button type="button" class="btn btn-default2">
						<b>Panas</b>
					</button>
			</div>
			<div class="btn-group" role="group">
				<button type="button" class="btn btn-default3 negro"
						style="border-right: 1px solid #ccc" >
						A <b><span id="megustan"><?php echo $amigos->contarMeGustan($usuario->id);?></span></b> Personas les gusta tu perfil
					</button>
			</div>
		</div>
	</div>
</div>