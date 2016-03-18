<?php
include "clases/busqueda.php";
include_once "clases/fotos.php";
include_once "clases/publicaciones.php";
$bd=new bd();
$foto=new fotos();
$lista=$bd->query("select id,(select count(favoritos_id) from usuarios_favoritos where favoritos_id=usuarios.id) as fav, 
(select fecha from usuariosxstatus where usuarios_id=usuarios.id) as fecha from usuarios order by certificado desc, fav desc,fecha asc");
$estados=$bd->query("select id,nombre,(select count(id) from usuarios where estados_id = estados.id) as totaP from estados");
$total=$lista->rowCount();
$totalPaginas=ceil($total/25);
?>
<div class="container " id="principal" name="principal" >
		<div class="row">
			<?php
			if($total==0):
			?>
			 <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' id="noresultados" name"noresultados">
                         <div class='alert alert-warning2  text-left' role='alert'   >
                         	<img src="galeria/img-site/logos/bill-error.png" width="120px" height="120px;" class="pull-left" style="margin-top:-10px;"/>
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
			?>
			<!-- Filtros -->
			<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 resultados" > <!-- ocultar cuando no hay resultados -->
				<div class="marL5 marT5 marB5  contenedor">
					<div class="marL10">
						<div id="izquierda">
							<div id="ubicacion">
									<h5 class="negro" ><b>Ubicaci&oacute;n</b></h5>							
									<hr class="marR5">
									<ul class="nav marR5 t11  marT10 marB20 ">
										<?php
											foreach($estados as $e=>$valor):
												if($valor["totaP"]>0):
											?>
													<li class='marB10 t11'><div  class='h-gris'><span ><a class='blue-vin filtroest' href='#' data-id="<?php echo $valor["id"];?>"><?php echo "{$valor["nombre"]} ({$valor["totaP"]})";?></a></span></div></li>
													<?php
												endif;
											endforeach;
											?>
									</ul>
							</div>
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
								<span id="inicio" name="inicio" class="grisC"> 1</span> - <span id="final" name="final" class="grisC"><?php if($total>=25){ echo "25"; }else{ echo $total;}?>  de </span> <span class="grisC">
									<?php echo $total;?></span> <span class="marR5 grisC"> resultados</span>
									<a href="index.php" style="color:#000" class="marL5">Inicio </a> 
									<i class="fa fa-caret-right negro marR5 marL5"></i>
									<span id="ruta" name="ruta">
									</span>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 ">
							<div class=" marR20" style="margin-top:10px;" id="orden">
							<select id="filtro"  class="form-control  input-sm " style="width:auto;"  >
							<option value='id_desc' selected>Mas Recientes</option>
							<option value='id_asc'>Menos Recientes</option>
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
											$usua=new usuario($valor["id"]);
											$miTitulo=$usua->getNombre();
											if(isset($_GET["palabra"])){
												$criterioPal1=explode(" ", $_GET["palabra"]);
												foreach($criterioPal1 as $c=>$valor){
													$miTitulo=str_ireplace($valor, "<span style='background:#ccc'><b>" . strtoupper($valor) . "</b></span>", $miTitulo);										
												}
											}
											?>
											<div class=' col-xs-12 col-sm-6 col-md-2 col-lg-2'>
										  	  	<div class='marco-foto-conf  point marL20  ' style='height:130px; width: 130px;'  >
												    <!--<div style='position:absolute; left:40px; top:10px; ' class='f-condicion'> Vendedor </div>-->						 
												    <img src='<?php echo $foto->buscarFotoUsuario($usua->id);?>' class='img img-responsive center-block img-apdp imagen' style='width:100%;height:100%;' data-id='<?php echo $usua->id;?>'>							
												</div>
											</div>
											<div class=' col-xs-12 col-sm-6 col-md-7 col-lg-7'><p class='t16 marL10 marT5'>
											    <span class=' t15'><a class='negro' href='perfil.php?id=<?php echo $usua->id;?>' class='grisO'><b><?php echo $miTitulo;?></b></a></span>
												<br><span class=' vin-blue t14'><a href='perfil.php?id=<?php echo $usua->id;?>' class=''><b> <?php echo $usua->a_seudonimo;?></b></a></span><span></span>
												<br>
												<span class='t12 orange-apdp'><?php echo $usua->getTiempo();?> Vendiendo en Apreciodepana</span><br>
												<span class='t11 grisO'> <i class='fa fa-heart negro opacity'>
												</i><span class=' point h-under marL5'><?php echo $usua->countFavoritos();?> Me gusta</span><i class='fa fa-share-alt negro marL15 opacity hidden'></i> <span class=' point h-under marL5 hidden'> num_prueba Veces compartido</span> </span>
											    <br>
											    <br>
											    </p>
										    </div>
										    <br>
										    <div class=' col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right'><div class='marR20'>
											<span class=' t12'><?php echo ($usua->getEstado());?></span><br><span class='vin-blue t16'><a href='perfil.php?id=<?php echo $usua->id;?>' style='text-decoration:underline;'>Ver Mas</a></span >												
											</div></div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-2'><br></div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-10'><hr class='marR10'><br></div>
											<?php
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