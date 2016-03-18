<?php
	$usr = new usuario();										
	$amigos= new amigos();
	$id_publicacion=isset($_GET["publicacion"])?$_GET["publicacion"]:NULL;
	$usr_publicaciones = $usr -> getPreguntasCompra($_SESSION["id"], $id_publicacion);
	$cant_preg_usr = $usr -> getCantCompras($_SESSION["id"]);	
?>

<div class="contenedor">
	<div class="row marL20 marR20 ">
			<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10   "><!-- inicio titulo   -->	
				<h4 class="t20 negro pad10" ><span class="marL10">Preguntas sobre tus Compras</span>
					 <?php if(empty($id_publicacion)){ ?>
					 	(<span id="cantP" class="t20"><?php echo $cant_preg_usr[0]["cant"] ?></span>)
					 <?php } ?>	 
					 </h4>
				<center>
					<hr class='anchoC'>
				</center>
			</div><!-- Fin titulo -->
			
		</div>
	
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin: 30px; margin-top: 10px;">
	 
	  	
<?php	
foreach ($usr_publicaciones as $up => $valor) {
	$id_pub = $valor["id"];
	$usr->buscarUsuario($valor["usuarios_id"]);
	$pub = new publicaciones($id_pub);
	/*$usr_pub=$pub->getOwnerPublicacion($id_pub);
	
	if($amigos->verificarBloqueado($_SESSION["id"], $usr_pub))
		$estaBloqueado=true;
	else
		$estaBloqueado=false;*/
	$estaBloqueado=false;
	
	$p_preguntas = $pub -> getPreguntasCompra($id_pub, $_SESSION["id"]); 
	if($p_preguntas != null ){ 		
?>

<!--data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $id_pub;?>" aria-expanded="true" aria-controls="collapse<?php echo $id_pub;?>"     codigo para desplegar el panel -->
 <div class="panel panel-default" >
		<div class="panel-heading" role="tab" id="heading<?php echo $id_pub;?>" role="button" >
	      <h4 class="panel-title">  
	      			<a href="detalle.php?id=<?php echo $id_pub; ?>" > 	 							 
						<img src= "<?php echo $pub->getFotoPrincipal($id_pub); ?>"
					  	style="width:60px;height:60px; border: 1px solid #CCC; background: #FFF; padding: 5px;" >
					</a>
					<a href="detalle.php?id=<?php echo $id_pub; ?>" >							
						<span class="marL10"> <?php echo $valor["titulo"]; ?>  </span> 
	        		</a>
	        			<span class="red t14 marL10"><b>Bs <?php echo $valor["monto"] ?> </b></span> 
	        			<span class="opacity t12"><?php echo "x ".$valor["stock"]. " Und"; ?></span> 
	      </h4> 
	    </div>
	    <div id="collapse<?php echo $id_pub;?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<?php echo $id_pub;?>">
	        	 <div class="panel-body t14 " id="panel<?php echo $id_pub;?>">	
	        	 	<br>
<?php 
foreach ($p_preguntas as $pp => $valor2) {
	$id_pregunta = $valor2["id"]; 
	$resp = new publicaciones($id_pregunta);
	$id_usr = $valor2["usr_id"];
	$r = $resp -> getRespuestaPregunta($id_pregunta);
	
?>
	
	     							
									<p class="t14 marL20 marR20" id="preguntas<?php echo $id_pub;?>" style="border-bottom: #ccc 1px dashed;">
										<i class="fa fa-comment blueO-apdp marL10"></i> <span class="marL5"><?php echo $valor2["pregunta"]; ?>&nbsp;&nbsp;</span>
										<br>
										<br>
									<?php if($r[0] != null) {?>
										<i class="fa fa-comments-o marL20 blueC-apdp"></i> <span class="marL5"> <?php echo $r[0]; ?> </span> <span class="opacity t11"> - <?php echo $r[1];?> </span>
										<br>	
									<?php }?>	
									<br>												
									</p>	
																						 	
	    				     
	    	
	    	
<?php
}?>
			
		<?php if(!$estaBloqueado) {?>	<div class="text-right t14 marL20 marR20 togglePreguntar" data-id="<?php echo $id_pub; ?>"><a id="Preguntar<?php echo $id_pub; ?>" href="#">Hacer Otra Pregunta</a></div> <?php } ?>
									
									
									<div class="" id="<?php echo $id_pub; ?>" style="background:#D8DFEA; padding:10px; padding: 20px; border:1px solid #ccc; display:none">
			                        	<div style="background: #FFF">
			                        		<textarea lang="5" class="form-textarea-msj2 preguntas"  placeholder="Indica tu duda o pregunta ... " id="txtPregunta<?php echo $id_pub; ?>" name="txtPregunta<?php echo $id_pub; ?>" data-id="<?php echo $id_pub; ?>"></textarea>            
			                        		<p class="text-right marR10 t10" id="restante<?php echo $id_pub;?>" name="restante<?php echo $id_pub;?>" >240</p>
			                        	</div>
										<div style="text-align: left;">
											<button id="limpiar" class="btn2 btn-default marL10 limpiarP"  data-pub_id="<?php echo $id_pub; ?>" data-id="<?php echo $id_pub; ?>" >Limpiar</button>
											<button class="btn2 btn-primary2 marT5 marL5 btnPreguntar" id="cmdPreguntar" name="cmdPreguntar" data-pub_id='<?php echo $id_pub; ?>' data-usr_id='<?php echo $pub->usuarios_id; ?>' data-id_poster='<?php echo $_SESSION["id"]; ?>'>Preguntar</button> 
											 <span class="marL5 t10 grisC">no uses lenguaje vulgar por que sera supendida tu cuenta.</span>
										</div>
									</div>	
			
				</div>
													

		</div>
 </div>
<?php
	}else{
		include_once("fcn/f_no_find.php");		
	}
}
?>  
	     
    </div>
 </div>