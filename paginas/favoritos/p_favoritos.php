<?php
if(file_exists('../../clases/usuarios.php')){
	include_once '../../clases/usuarios.php';
	include_once '../../clases/publicaciones.php';
	$vienedeAjax=true;
}else{
	$vienedeAjax=false;
}
if (! isset ( $_SESSION )) {
	session_start ();
}
$usua=new usuario($_SESSION["id"]);
$pagina=1;
?>
<div class="contenedor" style="margin-top: 25px">
	<br class="hidden-xs"> <br>
	<div class="row mar-perfil-amigos">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="row"
				style="background: #f5f5f5; padding-top: 15px; padding-bottom: 15px; border: solid 1px #ccc;">
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
					<div>
						<h3 class="  titulo-perfil ">
							<i class="fa fa-tags"></i> Publicaciones Favoritas
						</h3>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 text-right">
					
					<div class="navbar-form marR10 marL10" role="search">
						<i class="fa fa-list t24 marR10 grisC hidden"></i>
						<i class="fa fa-th-large t24 marR10 grisC hidden"></i>
						<div class="input-group" style="">
					<span class="input-group-btn">
						<button class="btn-header btn-default-header" style="border: #ccc 1px solid; border-right:transparent;"
							>
							<span class="glyphicon glyphicon-search"></span>
						</button>
					</span> <input style="margin-left: -10px; border: #ccc 1px solid; border-left:1px solid #FFF; width: 180px;  "
						 type="text" class="form-control-header " placeholder="Buscar" id="txtBusqueda" name="txtBusqueda">						 
				</div>
						<select class="form-control input" id="filter" name="filter">
							<option value='id desc'>Mas Recientes</option>
							<option value='id asc'>Menos Recientes</option>
							<option value='monto desc'>Mayor Precio</option>
							<option value='monto asc'>Menor Precio</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		
				<div id="noresultados" name="noresultados" class="container center-block col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden">	
					<br>
					<br>
				<div class='alert alert-warning2  text-center' role='alert'  >                                        	
                         	<span class="t16  "><i class="fa fa-info-circle"></i> No se encontraron publicaciones favoritas.</span>
                         </div>
                         <br>  
                   </div>
                   		<div class="row " id="publicaciones" name="publicaciones"> 
		<?php
			$hijos=$usua->getPublicacionesFavoritas("id desc");
			$publicaciones=$hijos;
										$ac=0;
									foreach($publicaciones as $key => $valor) {
										$ac++;
										$publi=new publicaciones($valor["id"]);
										$usua2=new usuario($publi->usuarios_id);
										$estado=$usua2->getEstado(1);
										$cadena="
										<div class='general' id='general" . $valor["id"] . "' name='general" . $valor["id"] . "' data-titulo='{$valor["titulo"]}' data-id='{$valor["id"]}'>
											<div class=' col-xs-12 col-sm-12 col-md-12 col-lg-12 marT20'></div>
											<div class=' col-xs-12 col-sm-6 col-md-2 col-lg-2 ' ><!-- inicio del registro de la publicacion-->
								    		<div class='marco-foto-conf  point marL20  ' style='height:130px; width: 130px;'  >
									    	<div style='position:absolute; left:40px; top:10px; ' class='f-condicion'>" . $publi->getCondicion() . "</div>							 
									    	<a href='detalle.php?id=" . $valor["id"] . "'><img src='" . $publi->getFotoPrincipal() . "' class='img img-responsive center-block img-apdp imagen' 
									    	data=id'" . $valor["id"] . "'></a>						
											</div>
											</div>
											<div class=' col-xs-12 col-sm-6 col-md-7 col-lg-7'>
										<p class='t16 marL10 marT5'>
										    <span class=' t15'><a class='negro' href='detalle.php?id=" . $publi->id . "' class='grisO'><b>" . $publi->titulo . "</b></a></span>
											<br>
											<span class=' vin-blue t14'><a href='perfil.php?id=" . $usua2->id ."' class=''><b>" . $usua2->a_seudonimo . "</b></a></span>
											<br>
											<span class='t14 grisO '>" . $usua2->getNombre() . "</span>
											<br>
											<span class='t12 grisO '><i class='glyphicon glyphicon-time t14  opacity'></i>" . $publi->getTiempoPublicacion() . "</span>
											<br>
											<span class='t11 grisO'> <span> <i class='fa fa-eye negro opacity'></i></span><span class='marL5'> " . $publi->getVisitas() . " Visitas</span><i class='fa fa-thumbs-up negro marL15 opacity'>
											</i><span class='  h-under marL5'>" . $publi->getFavoritos() .  " Me gusta</span><i class='fa fa-share-alt negro marL15 opacity hidden'></i> <span class=' hidden point h-under marL5'>15 Veces compartido</span> </span>
								      </p>
								    </div>
								    <div class=' col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right'>
								    	<br>
								    	<div class='marR20'>
								    		<span class='red t20'><b>". $publi->getMonto() . "</b></span >
											<br>
											<span class=' t12'>" . $estado . "</span>
											<br>
											<span class='vin-blue t16'><a href='detalle.php?id=" . $valor["id"] . "' style='text-decoration:underline;'>Ver Mas</a></span >
										</div>
									</div>
									<div class='col-xs-12 col-sm-12 col-md-12 col-lg-2'><br></div>
									<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'><hr class='marR10'><br></div> </div><!-- inicio del registro de la publicacion-->";									
									echo $cadena;
								}
								$totalPaginas=floor($ac/25);
								$restantes=$ac-($totalPaginas*25);
								if($restantes>0){
									$totalPaginas++;
								}								
								echo "</div><!-- FIN de la paginacion --> <div class='row'>";
								echo"<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 paginas' id='paginas' name='paginas' data-metodo='buscarFavoritos' data-id='" . $usua->id . "'><center><nav><ul class='pagination'>";
								/*
								if($pagina>10){
									$anteriorGrupo=$pagina-10;
									echo "<li><a href='listado.php?id_cla=$act_cla&pagina=$anteriorGrupo&palabra=$palabra' aria-label='Previous'><i class='fa fa-angle-double-left'></i></a></li>";
								}
								if($pagina>1){
									$anteriorPagina=$pagina-1;
									echo "<li><a href='' aria-label='Previous'><i class='fa fa-angle-left'></i></a></li>";
								}
								 * * */
								$contador=0;
								if($pagina<=10){
									$inicio=1;
								}else{
									$inicio=floor($pagina/10);
									if($pagina % 10!=0){
										$inicio=($inicio*10)+1;
									}else{
										$inicio=($inicio*10)-9;
									}									
								}
								 								 
								for($i=$inicio;$i<=$totalPaginas;$i++){
									$contador++;
									if($i==1){
										echo "<li class='active'><a href='#' class='botonPagina' data-pagina='" . $i ."'>$i</a></li>";
									}else{
										echo "<li class=''><a href='#' class='botonPagina' data-pagina='" . $i ."'>$i</a></li>";
									}
									if($contador==10){
										break;
									}
								}
								//echo "<li><a href='#' aria-label='Next'><i class='fa fa-angle-right'></i> </a>";
								if($i<$totalPaginas){
									if(($pagina+10)<=$totalPaginas){
										$siguienteGrupo=$pagina + 10;
									}else{
										$siguienteGrupo=$totalPaginas;
									}
									echo "<li><a href='#' aria-label='Next'><i class='fa fa-angle-double-right'></i> </a>";
								}
								echo "</li></ul></nav></center></div></div></div></div></div></div>";
								?>
					
					   		</div>
									<!-- fin de la fila de la publicacion  -->				
				
				
			  <?php
			  if($ac==0){
			  	?>
			  	<script>
			  		$("#noresultados").removeClass("hidden");
			  		$("#publicaciones").addClass("hidden");
			  	</script>		  	
			  	<?php
			  }
			  ?>
		</div>
		
	</div>