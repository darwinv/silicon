<?php
if(file_exists('../../clases/usuarios.php')){
	include_once '../../clases/usuarios.php';
	include_once '../../clases/publicaciones.php';
	$vienedeAjax=true;
}else{
	$vienedeAjax=false;
	include "clases/publicaciones.php";
}
if (! isset ( $_SESSION )) {
	session_start ();
}
$usua=new usuario($_GET["id"]);
$pagina=1;
?>
<div class="contenedor" style="margin-top: 25px">
	<br class="hidden-xs"> <br>
	<div class="row mar-perfil-amigos">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="row"
				style="background: #f5f5f5; padding-top: 15px; padding-bottom: 15px; border: solid 1px #ccc;">
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
					<div>
						<h3 class="  titulo-perfil ">
							<i class="fa fa-tags"></i> Publicaciones
						</h3>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 text-right">
					
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
							<option >Mas Recientes</option>
							<option >Menos Recientes</option>
							<option >Mayor Precio</option>
							<option >Menor Precio</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<?php
			$hijos=$usua->getPublicaciones(1);
   		$ac=0;
		if(!empty($hijos)){
			$publicaciones=$hijos;
		?>
		<script type="text/javascript">$("#categorias").css("display","none");</script>
			<?php
		}else{
			$publicaciones=array();
		}
		?> 
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
									$ac=0;
									foreach($publicaciones as $key => $valor) {
										$ac++;
										$publi=new publicaciones($valor["id"]);
										$estado=$vienedeAjax? ($usua->getEstado(1)):$usua->getEstado(1);
										$cadena="
										<div class='general' id='general" . $valor["id"] . "' name='general" . $valor["id"] . "' data-titulo='" . $valor["titulo"] . "'>
											<div class=' col-xs-12 col-sm-12 col-md-12 col-lg-12 marT20'></div>
											<div class=' col-xs-12 col-sm-6 col-md-2 col-lg-2'><!-- inicio del registro de la publicacion-->
								    		<div class='marco-foto-conf  point marL20  ' style='height:130px; width: 130px;'  >
									    	<div style='position:absolute; left:40px; top:10px; ' class='f-condicion'>" . $publi->getCondicion() . "</div>							 
									    	<img src='" . $publi->getFotoPrincipal() . "' class='img img-responsive center-block img-apdp imagen' data-id='" . $valor["id"] . "' >						
											</div>
											</div>
											<div class=' col-xs-12 col-sm-6 col-md-7 col-lg-7'>
										<p class='t16 marL10 marT5'>
										    <span class=' t15'><a class='negro' href='detalle.php?id=" . $publi->id . "' class='grisO'><b>" . $publi->titulo . "</b></a></span>
											<br>
											<span class=' vin-blue t14'><a href='' class=''><b>" . $usua->a_seudonimo . "</b></a></span>
											<br>
											<span class='t14 grisO '>" . $usua->getNombre() . "</span>
											<br>
											<span class='t12 grisO '><i class='glyphicon glyphicon-time t14  opacity'></i>" . $publi->getTiempoPublicacion() . "</span>
											<br>
											<span class='t11 grisO'> <span> <i class='fa fa-eye negro opacity'></i></span><span class='marL5'> " . $publi->getVisitas() . " Visitas</span><i class='fa fa-thumbs-up negro marL15 opacity'>
											</i><span class=' point h-under marL5'>" . $publi->getFavoritos() .  " Me gusta</span><i class='fa fa-share-alt negro marL15 opacity hidden'></i> <span class=' point h-under marL5 hidden'>15 Veces compartido</span> </span>
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
									<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'><hr class='marR10'><br></div></div> <!-- inicio del registro de la publicacion-->";									
									echo $cadena;
								}
								$ac=$usua->getCantidadPub(1);
								$totalPaginas=floor($ac/25);
								$restantes=$ac-($totalPaginas*25);
								if($restantes>0){
									$totalPaginas++;
								}
								echo"</div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' id='paginas' name='paginas' data-metodo='buscarPublicaciones' data-id='" . $usua->id . "'> <center><nav><ul class='pagination'>";
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
										echo "<li class='active' style='cursor:pointer'><a class='botonPagina' data-pagina='" . $i ."'>$i</a></li>";
									}else{
										echo "<li class='' style='cursor:pointer'><a class='botonPagina' data-pagina='" . $i ."'>$i</a></li>";
									}
									if($contador==10){
										break;
									}
								}
								echo "</li></ul></nav></center></div></div></div></div></div></div>";
								?>
									<!-- fin de la fila de la publicacion  -->						
		</div>
		
	</div>