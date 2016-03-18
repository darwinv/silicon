<?php
include "clases/busqueda.php";
include_once "clases/fotos.php";
include_once "clases/publicaciones.php";
$bd=new bd();
$foto=new fotos();
$act_cla=isset($_GET["id_cla"])?$_GET["id_cla"]:"";
$palabra=isset($_GET["palabra"])?$_GET["palabra"]:"";
$valores=array("palabra"=>$palabra,
				"clasificados_id"=>$act_cla);
$busqueda=new busqueda($valores);
//$publiUsua=$busqueda->listado;
$publiUsua=$busqueda->getPublicaciones();
$estados=$busqueda->getEstados();
$categorias=$busqueda->getCategorias();
$condiciones=$busqueda->getCondiciones();
//$tipos=$busqueda->getTipos();
$ruta=$busqueda->getRuta();
$total=$publiUsua->rowCount();
if(isset($_GET["palabra"])){
	$lista=array();
	$c=0;
	foreach($publiUsua as $p=>$valor){
		/*
		if($valor["tipo"]=="P"){
			$lista[$cp]["id"]=$valor["id"];
			$lista[$cp]["tipo"]="P";
			$cp+=2;
		}else{
			$lista[$cu]["id"]=$valor["id"];
			$lista[$cu]["tipo"]="U";
			$cu+=2;
		}
		 * 
		 */
		if($valor["tipo"]=="P"){
			$lista[$c]["parecido"]=similar_text(strtoupper($valor["nombre"]),strtoupper($palabra));			
			$lista[$c]["id"]=$valor["id"];
			$lista[$c]["tipo"]="P";
		}else{
			$lista[$c]["parecido"]=similar_text(strtoupper($valor["nombre"]),strtoupper($palabra));
			$lista[$c]["id"]=$valor["id"];
			$lista[$c]["tipo"]="U";		
		}
		$c++;
	}
	array_multisort($lista,SORT_DESC);	
//	var_dump($lista);
//	ksort($lista);
}else{
	$lista=array();
	$cp=0;
	foreach($publiUsua as $p=>$valor){
		$lista[$cp]["id"]=$valor["id"];
		$lista[$cp]["tipo"]="P";
		$cp++;
	}
}
//if(!isset($_SESSION)){
//	session_start();
//}
//$_SESSION["lista"]=array_values($lista);
$totalPaginas=ceil($total/25);

function buscaRuta(){
	$ruta=isset($_GET["palabra"])?$_GET["palabra"]:"";
	if(isset($_GET["id_cla"])){
		$cla=new clasificados($_GET["id_cla"]);
		$ruta=$cla->getAdressWithLinks($ruta);
	}else{
		$ruta=$ruta!=""?"'$ruta'":$ruta;
	}
	return $ruta;
}
?>
<div class="container " id="principal" name="principal"  data-cla="prueba" data-est="prueba" data-con="prueba" 
		data-pag="prueba" data-palabra="<?php echo $palabra;?>" data-can="prueba" data-nomest="prueba">
		<div class="row">
			<?php
			if($total==0):
			?>
			 <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' id="noresultados" name"noresultados">
                         <div class='alert alert-warning2  text-left' role='alert'   >
                         	<img src="galeria/img-site/logos/bill-error.png" width="100px" height="100px;" class="pull-left" style="margin-top:0px;"/>
                         	<div class="t16 marL20 marB5 ">No se encontraron resultados de tu busqueda.</div>
                         	<span class="t12 marL30 grisO">
                         		<i class="fa fa-caret-right marR10"></i> Verifica la ortografia en cada palabra.
                         	</span>
                         		<br>
							<span class="t12 marL30 grisO">	
								<i class="fa fa-caret-right marR10"></i> Utiliza palabras m&aacute;s estandares.
							</span>	
							<br>
							<span class="t12 marL30 grisO">	
								<i class="fa fa-caret-right marR10"></i> utiliza categorias mas especificas para mejorar la busqueda.
							</span>	
							<br>	
							<span class="t12 marL30 grisO">	
								<i class="fa fa-caret-right marR10"></i> No se hallaron publicaciones relacionadas a tu selecci&oacute;n.
							</span>	
                         </div>  
                         <br>
                           <div class="anchoC center-block">
                          	<br>
                          	<br>
                          	<?php include_once "fcn/f_categorias.php"; ?> 
                          	<br>
                          	<br>
                          	</div>                   
            </div>
            <?php
			else:
				$totalPub=$condiciones["tota1"] + $condiciones["tota2"] + $condiciones["tota3"]
			?>
			<!-- Filtros -->
			<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 resultados" > <!-- ocultar cuando no hay resultados -->
				<div class="marL5 marT5 marB5  contenedor">
					<div class="marL10">
						<div id="izquierda">
						<?php /*	<div id="tipo">
							<h5 class="negro" ><b>Tipo</b></h5>
							<hr class="marR5">
							</div>							
								<ul class="nav marR5 marT10 marB20 t11">
										<?php
										if($totalPub>0):
										?>
										<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO' href='#'>
										<span class='blue-vin <?php if(isset($_GET["palabra"]) && $act_cla=="") echo "filtropub";?>'>Publicaciones (<?php echo $totalPub;?>)</a></li>
										<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO' href='#'>
										<?php
										endif;
										if(isset($_GET["palabra"]) && $act_cla==""):
											if(($total - ($condiciones["tota1"] + $condiciones["tota2"] + $condiciones["tota3"]))>0):
											?> 
												<span class='blue-vin filtroven'>Vendedores (<?php echo $total - ($condiciones["tota1"] + $condiciones["tota2"] + $condiciones["tota3"]);?>)</a></li>
											<?php
											endif;
										endif;
										?>											
								</ul> */?>
								<?php
									$cat=$act_cla!=""?"data-categoria=$act_cla":""; 
								?>
							<div id="categoria" name="categoria" <?php echo $cat;?> style="display:<?php if($totalPub==0){ echo "none"; } else{ echo "block"; }?>">
								<h5 class="negro"><b>Categoria</b></h5>
								<hr class="marR5">
									<ul class="nav marR5 t11  marT10 marB20 ">
										<?php
											foreach($categorias as $c=>$valor):
												if($valor["totaC"]>0):
											?>
													<li class='marB10 t11'><div  class='h-gris'><span ><a class='blue-vin filtrocat' href='#' data-id="<?php echo $valor["id"];?>" data-cantidad="<?php echo $valor["totaC"];?>" ><?php echo "{$valor["nombre"]} ({$valor["totaC"]})";?></a></span></div></li>
													<?php
												endif;
											endforeach;
											?>
									</ul>							
							</div>
							 
						<?php  /*	<div id="ubicacion">
									<h5 class="negro" ><b>Ubicaci&oacute;n</b></h5>							
									<hr class="marR5">
									<ul class="nav marR5 t11  marT10 marB20 ">
										<?php
											foreach($estados as $e=>$valor):
												if($valor["totaP"]>0):
											?>
													<li class='marB10 t11'><div  class='h-gris'><span ><a class='blue-vin filtroest' href='#' data-id="<?php echo $valor["id"];?>"><?php echo "{$valor["nombre"]} ({$valor["totaP"]})";?></a></span></li>
													<?php
												endif;
											endforeach;
											?>
									</ul>
							</div> */ ?>
						<?php /*	<div id="condicion" style="display:<?php if($totalPub==0){ echo "none"; } else{ echo "block"; }?>">
								<h5 class="negro" ><b>Condici&oacute;n</b></h5>
								<hr class="marR5">
							</div>
								<ul class="nav marR5 marT10 marB20 t11">
										<?php
										if($condiciones["tota1"]>0):
											?>
											<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO filtrocon' href='#' data-id="1">
											<span class='blue-vin'>Nuevo (<?php echo $condiciones["tota1"];?>)</a></li>
										<?php
										endif;
										if($condiciones["tota2"]>0):
											?>											
											<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO filtrocon' href='#' data-id="2">
											<span class='blue-vin'>Usado (<?php echo $condiciones["tota2"];?>)</a></li>
										<?php
										endif;										
										if($condiciones["tota3"]>0):
											?>											
										<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO filtrocon' href='#' data-id="3">
										<span class='blue-vin'>Servicios (<?php echo $condiciones["tota3"];?>)</a></li>
										<?php
										endif;
										?>
								</ul>  */ ?>
							</div>						
							</div>
							</div>
							</div>
							<!-- Listado -->
							<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 resultados" > <!-- ocultar si no hay resultados -->
							<div class="mar5 contenedor row">
							<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 text-left vin-blue ">
							<!-- mostrar la busqueda o donde esta segun lo q selecciono y almaceno en la variable de busqueda 2 y contar seria la cantidad de resultados obtenidos segun la busqueda -->
							<div class="marL20 t14"><p style="margin-top:15px;"> 
								<span id="inicio" name="inicio" class="grisC"> 1</span> - <span id="final" name="final" class="grisC"><?php if($total>=25){ echo "25"; }else{ echo $total;}?>  de </span> 
								<span class="grisC">
									<?php echo $total;?>
								</span> 
								<span class="marR5 grisC"> resultados</span>
									<a href="index.php" style="color:#000" class="marL5">Inicio </a> 
									<i class="fa fa-caret-right negro marR5 marL5"></i>
									<span id="ruta" name="ruta">
										<?php
											echo buscaRuta();
										?>
									</span>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 ">
							<div class=" marR20" style="margin-top:10px;" id="orden">
							<select id="filtro"  class="form-control  input-sm" style="width:auto;"  >
							<option value='id_desc' selected>Mas Recientes</option>
							<option value='id_asc'>Menos Recientes</option>
							<option value='monto_desc'>Mayor Precio</option>							
							<option value='monto_asc'>Menor Precio</option>	
							</select>
							</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<hr class="marL10 marR10">
							<br>
							</div>
						<div id="ajaxContainer" border="3" > <!-- ESTE DIV SE UTILIZARA SI SE DECIDI APLICARLE AJAX, POR EL MOMENTO NO SE UTILIZA -->
									<!--Usuario-->
									<?php
										$i=0;										
										foreach($lista as $p=>$valor):
											$i++;
											if($valor["tipo"]=="P"):
												
												$publi=new publicaciones($valor["id"]);
												/*$usua=new usuario($publi->usuarios_id);*/
												$miTitulo=$publi->titulo;
												if($palabra!=""){
													$miTitulo=str_ireplace($palabra, "<span style='background:#ccc'><b>$palabra</b></span>", $miTitulo);
												}												
											?>
									            <!--publicaci&oacute;n-->
												<div class=' col-xs-12 col-sm-6 col-md-2 col-lg-2'>
											    	<div class='marco-foto-conf  point marL20  ' style='height:130px; width: 130px;'  >
											    		<div style='position:absolute; left:40px; top:10px; ' class='f-condicion'> </div>			 
											    		<img src='<?php echo $publi->getFotoPrincipal();?>' class='img img-responsive center-block img-apdp imagen' style='width:100%;height:100%;'
											    		data-id='<?php echo $publi->id;?>'>				
													</div>
												</div>
												<div class=' col-xs-12 col-sm-6 col-md-7 col-lg-7'><p class='t16 marL10 marT5'>
											    	<span class=' t15'><a class='negro' href='detalle.php?id=<?php echo $publi->id;?>' class='grisO'><b> <?php echo $miTitulo;?></b></a></span>
													<?php /* <br><span class=' vin-blue t14'><a href='perfil.php?id=<?php echo $usua->id;?>' class=''><b> <?php echo $usua->a_seudonimo;?></b></a></span> */ ?>
												<?php /*	<br><span class='t14 grisO '><?php echo $usua->getNombre();?></span><br> */ ?>
													<span class='t12 grisO' style="display: block;"><i class='glyphicon glyphicon-time t14  opacity'></i><?php echo $publi->getTiempoPublicacion();?></span>
													<span class='t11 grisO'> <span> <i class='fa fa-eye negro opacity'></i></span><span class='marL5'><?php echo $publi->getVisitas();?> Visitas</span><i class='fa fa-heart negro marL5 opacity'>
													</i><span class=' point h-under marL5'><?php echo $publi->getFavoritos();?> Me gusta</span><i class='fa fa-share-alt negro marL15 opacity hidden'></i> <span class=' point h-under marL5 hidden'> <?php echo $publi->getCompartidos(3);?> Veces compartido</span> </span>
													<br>
													<br>
													<br>
													</p>
											    </div>
											    <div class=' col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right'>
											    	<div class='marR20'><span class='red t20'><b> <?php echo $publi->getMonto();?></b></span >
														<?php /* <br><span class=' t12'> <?php echo ($usua->getEstado());?> </span><br> */?>
														<span style="display: block;" class='vin-blue t16'><a href='detalle.php?id=<?php echo $publi->id;?>' style='text-decoration:underline;'>Ver Mas</a></span >
													</div>
												</div>
												<div class='col-xs-12 col-sm-12 col-md-12 col-lg-2'><br></div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-10'><hr class='marR10'><br></div>
											<?php
											endif;
											if($i==25)
											break;
										endforeach;
									?>
						</div>
					    <div id="paginacion" name="paginacion" class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' data-paginaActual='1' data-total="<?php echo $total;?>"><center><nav><ul class='pagination'>
					    	<!--
								<li><a href='listado.php' aria-label='Previous'><i class='fa fa-angle-double-left'></i></a></li>
								<li><a href='#' aria-label='Previous'><i class='fa fa-angle-left'></i></a></li>
								-->
									<li id="anterior2" name="anterior2" class="hidden"><a href='#' aria-label='Previous' class='navegador' data-funcion='anterior2'><i class='fa fa-angle-double-left'></i> </a>
									<li id="anterior1" name="anterior1" class="hidden"><a href='#' aria-label='Previous' class='navegador' data-funcion='anterior1'><i class='fa fa-angle-left'></i> </a>											
									<?php
									$oculto="";
									$activo="active";									
									for($i=1;$i<=$totalPaginas;$i++):
									?>
										<li class="<?php echo $activo; echo $oculto;?>"><a class="botonPagina" href='#' data-pagina="<?php echo $i;?>"><?php echo $i;?></a></li>
									<?php
									$activo="";
									if($i==10)
									$oculto=" hidden";
									endfor;
								?>
								<?php
									if($totalPaginas>1):
									?>								
										<li id="siguiente1" name="siguiente1"><a href='#' aria-label='Next' class='navegador' data-funcion='siguiente1'><i class='fa fa-angle-right'></i> </a>
									<?php
									endif;
									?>
								<?php
									if($totalPaginas>10):
										?>
										<li id="siguiente2" name="siguiente2"><a href='#' aria-label='Next' class='navegador' data-funcion='siguiente2'><i class='fa fa-angle-double-right'></i> </a>
									<?php
									endif;
								?>
								</li></ul>
						</nav></center></div>
						 <?php
						endif;
						?>
						</div></div></div>
					</div>