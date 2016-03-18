<?php
	require '../../../config/core.php';
	include_once "../../../clases/publicaciones.php";
	include_once "../../../clases/usuarios.php";
	include_once "../../../clases/fotos.php";
	include_once "../../../clases/clasificados.php";

	switch($_POST["metodo"]){
		case "buscar":
			busca();
			break;
		case "filtrarEst":
			filtraEst();
			break;
		case "ordenar":
			ordena();
			break;
	}
		/**************FILTRAR POR ESTADO********************/
	function filtraEst(){
		$bd=new bd();
		$foto=new fotos();
		?>
		<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 resultados" > <!-- ocultar cuando no hay resultados -->
			<div class="marL5 marT5 marB5  contenedor">
				<div class="marL10">
					<div id="izquierda">
		<?php
		$totalVen=0;
		$totalVen2=0;
		/******************INICIO DE LA BUSQUEDA DE UBICACION******************/
		if($_POST["id"]<100){
			$est="data-estado={$_POST["id"]}";
		}else{
			$est="";
		}
		if($_POST["id"]<100):
			$row2=$bd->doSingleSelect("estados","id={$_POST["id"]}");
			$ruta= " En {$row2["nombre"]}";
			$consulta="select count(id) as totaV from usuarios where estados_id={$_POST["id"]}";
			$consulta2="select count(id) as totaV from usuarios";
			$result=$bd->query($consulta);
			$row=$result->fetch();
			$result2=$bd->query($consulta2);
			$row3=$result2->fetch();
			$totalGen=$row["totaV"];
			$ac=$totalGen;
		?>
			<div id="ubicacion" <?php echo $est;?> >
				<h5 class="negro" ><b>Ubicaci&oacute;n</b></h5>
				<hr class="marR5">
				<ul class="nav marR5 t11  marT10 marB20 ">
					<li class='marB10 t11'><div  class='h-gris'><span ><a class='filtroest' href='#' data-id='100'>TODOS (<?php echo $row3["totaV"]?>)</a></span></div></li>
						<li class='marB10 t11'><div  class='h-gris'><span ><a class='blue-vin filtroest' href='#' data-id="<?php echo $_POST["id"];?>"><?php echo  ($row2["nombre"]) . "(" . $totalGen . ")";?></a></span></div></li>																						
					<?php
		else:
			$estados=$bd->doFullSelect("estados");
			$estado="";
			$ruta="";
		?>
			<div id="ubicacion" <?php echo $estado;?>
				<h5 class="negro" ><b>Ubicaci&oacute;n</b></h5>							
				<hr class="marR5">
				<ul class="nav marR5 t11  marT10 marB20 ">
		<?php
				$ac=0;
				foreach($estados as $e=>$valor):
					$consulta="select count(id) as tota from usuarios where estados_id={$valor["id"]}";
					$result2=$bd->query($consulta);
					$row2=$result2->fetch();
					$totalG=$row2["tota"];
					$ac+=$totalG;				
					if($totalG > 0):
					?>
						<li class='marB10 t11'><div  class='h-gris'><span ><a class='blue-vin filtroest' href='#' data-id="<?php echo $valor["id"];?>"><?php echo  ($valor["nombre"]) . " ($totalG)";?></a></span></div></li>
						<?php
					endif;
				endforeach;
			?>
			</div>
			<?php
		endif;							
			?>
		   	</ul>
		<?php	
		/******************FIN DE LA BUSQUEDA DE UBICACION*********************/		
				?>
			</ul>		
			</div> <!--Cierre de Izquierda-->
			</div>
			</div>
			
		</div>
		<?php
//			$consultaNat="select usuarios_id as id,'U' as tipo from usuarios_naturales where $criterioPal2";
//			$consultaJur="select usuarios_id as id,'U' as tipo from usuarios_juridicos where $criterioPal3";
			if($_POST["id"]<100){
				$consulta="select id from usuarios where estados_id={$_POST["id"]} order by certificado desc limit 25 OFFSET 0";
			}else{
				$consulta="select id from usuarios order by certificado desc limit 25 OFFSET 0";
			}
			$result=$bd->query($consulta);
			$total=$ac;
			$totalPaginas=ceil($total/25);
		?>
		<!-- Listado -->
		</div>
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
							<?php echo  ($ruta);?>
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
									
						foreach($result as $p=>$valor):
							$usua=new usuario($valor["id"]);
							$miTitulo=$usua->getNombre();
							?>
							<div class=' col-xs-12 col-sm-6 col-md-2 col-lg-2'>
						  	  	<div class='marco-foto-conf  point marL20  ' style='height:130px; width: 130px;'  >
								    <!--<div style='position:absolute; left:40px; top:10px; ' class='f-condicion'> Vendedor </div>-->						 
								    <img src='<?php echo $foto->buscarFotoUsuario($usua->id);?>' class='img img-responsive center-block img-apdp imagen' style='width:100%;height:100%;' data-id='<?php echo $usua->id;?>'>							
								</div>
							</div>
							<div class=' col-xs-12 col-sm-6 col-md-7 col-lg-7'><p class='t16 marL10 marT5'>
							    <span class=' t15'><a class='negro' href='perfil.php?id=<?php echo $usua->id;?>' class='grisO'><b><?php echo  ($miTitulo);?></b></a></span>
								<br><span class=' vin-blue t14'><a href='perfil.php?id=<?php echo $usua->id;?>' class=''><b> <?php echo $usua->a_seudonimo;?></b></a></span><span></span>
								<br>							
								<span class='t12 orange-apdp'><?php echo $usua->getTiempo();?> Vendiendo en Apreciodepana</span><br>									
								<span class='t11 grisO'> <i class='fa fa-heart negro marL5 opacity'>
								</i><span class=' point h-under marL5'><?php echo $usua->countFavoritos();?> Me gusta</span><i class='fa fa-share-alt negro marL15 opacity hidden'></i> <span class=' point h-under marL5 hidden'> num_prueba Veces compartido</span> </span>
							    <br>
							    <br>
							    </p>
						    </div>
						    <br>
						    <div class=' col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right'><div class='marR20'>
								<span class=' t12'><?php echo $usua->getEstado();?></span><br><span class='vin-blue t16'><a href='perfil.php?id=<?php echo $usua->id;?>' style='text-decoration:underline;'>Ver Mas</a></span >
							</div></div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-2'><br></div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-10'><hr class='marR10'><br></div>						
							<?php							
						endforeach;
						?>
				</div>
				<div id="paginacion" name="paginacion" class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' data-paginaactual='1' data-total="<?php echo $total;?>"><center><nav><ul class='pagination'>
					<li id="anterior2" name="anterior2" class="hidden"><a href='#' aria-label='Previous' class='navegador' data-funcion='anterior2'><i class='fa fa-angle-double-left'></i> </a>
					<li id="anterior1" name="anterior1" class="hidden"><a href='#' aria-label='Previous' class='navegador' data-funcion='anterior1'><i class='fa fa-angle-left'></i> </a>					
					<?php
						$activo="active";
						$oculto="";
						for($i=1;$i<=$totalPaginas;$i++):
							?>
							<li class="<?php echo $activo; echo $oculto;?>"><a class="botonPagina" href='#' data-pagina="<?php echo $i;?>"><?php echo $i;?></a></li>
							<?php
							if($i==10)
							$oculto=" hidden";
							$activo="";
						endfor;
					?>
					<?php
						if($totalPaginas>1):
						?>								
						<li id="siguiente1" name="siguiente1"><a href='#' class="navegador" aria-label='Next' data-funcion='siguiente1'><i class='fa fa-angle-right'></i> </a>
						<?php
						endif;
					?>
					<?php
						if($totalPaginas>10):
							?>
							<li id="siguiente2" name="siguiente2"><a href='#' class="navegador" aria-label='Next' data-funcion='siguiente2'><i class='fa fa-angle-double-right'></i> </a>
							<?php
						endif;
					?>
					</li></ul>
					</nav></center></div>
					</div></div></div>
					</div>
		<?php
	}
	function busca(){
		$bd=new bd();
		$foto=new fotos();
		$consulta="select id,'P' as tipo from publicaciones where id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null)";
		$soloPub=false;
		if($_POST["estado"]!="" && $_POST["estado"]!=100){
			$consulta.=" and usuarios_id in (select id from usuarios where estados_id={$_POST["estado"]})";
		}
		switch($_POST["orden"]){
			case "id_asc":
				$orden="order by id asc";
				break;
			case "id_desc":
				$orden="order by id desc";
				break;
		}
		$inicio=($_POST["pagina"] - 1) * 25;
		$consulta="select id,(select count(favoritos_id) from usuarios_favoritos where favoritos_id=usuarios.id) as fav, 
		(select fecha from usuariosxstatus where usuarios_id=usuarios.id) as fecha from usuarios order by certificado desc, fav desc,fecha asc";
		$consulta.=" limit 25 OFFSET $inicio";
		$result=$bd->query($consulta);
		foreach($result as $r=>$valor){
			$usua=new usuario($valor["id"]);
			$miTitulo=$usua->getNombre();
			?>
			<div class=' col-xs-12 col-sm-6 col-md-2 col-lg-2'>
			 	  	<div class='marco-foto-conf  point marL20  ' style='height:130px; width: 130px;'  >
						    <img src='<?php echo $foto->buscarFotoUsuario($usua->id);?>' class='img img-responsive center-block img-apdp imagen' style='width:100%;height:100%;' data-id='<?php echo $usua->id;?>'>							
					</div>
			</div>
			<div class=' col-xs-12 col-sm-6 col-md-7 col-lg-7'><p class='t16 marL10 marT5'>
				    <span class=' t15'><a class='negro' href='perfil.php?id=<?php echo $usua->id;?>' class='grisO'><b><?php echo  ($miTitulo);?></b></a></span>
					<br><span class=' vin-blue t14'><a href='perfil.php?id=<?php echo $usua->id;?>' class=''><b> <?php echo $usua->a_seudonimo;?></b></a></span><span></span>
					<br>
					<span class='t12 orange-apdp'><?php echo $usua->getTiempo();?> Vendiendo en Apreciodepana</span><br>						
					<span class='t11 grisO'> <i class='fa fa-heart negro marL5 opacity'>
					</i><span class=' point h-under marL5'><?php echo $usua->countFavoritos();?> Me gusta</span><i class='fa fa-share-alt negro marL15 opacity hidden'></i> <span class=' point h-under marL5 hidden'> num_prueba Veces compartido</span> </span>
				    <br>
				    <br>
				    </p>
		    </div>
		    <br>
		    <div class=' col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right'><div class='marR20'>
					<span class=' t12'><?php echo $usua->getEstado();?></span><br><span class='vin-blue t16'><a href='perfil.php?id=<?php echo $usua->id;?>' style='text-decoration:underline;'>Ver Mas</a></span >
			</div></div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-2'><br></div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-10'><hr class='marR10'><br></div>
			<?php
		}
	}
	function ordena(){
		$bd=new bd();
		$foto=new fotos();
		$consulta="select id from usuarios";
		$_POST["orden"]=str_replace("_"," ", $_POST["orden"]);
		if($_POST["estado"]!=""){
			$consulta.=" where estados_id={$_POST["estado"]}";
		}
		$consulta.=" order by {$_POST["orden"]} limit 25 OFFSET 0";
		$result=$bd->query($consulta);
		foreach($result as $r=>$valor){
			$usua=new usuario($valor["id"]);
			$miTitulo=$usua->getNombre();
			?>
			<div class=' col-xs-12 col-sm-6 col-md-2 col-lg-2'>
			 	  	<div class='marco-foto-conf  point marL20  ' style='height:130px; width: 130px;'  >
						    <img src='<?php echo $foto->buscarFotoUsuario($usua->id);?>' class='img img-responsive center-block img-apdp imagen' style='width:100%;height:100%;' data-id='<?php echo $usua->id;?>'>							
					</div>
			</div>
			<div class=' col-xs-12 col-sm-6 col-md-7 col-lg-7'><p class='t16 marL10 marT5'>
				    <span class=' t15'><a class='negro' href='perfil.php?id=<?php echo $usua->id;?>' class='grisO'><b><?php echo  ($miTitulo);?></b></a></span>
					<br><span class=' vin-blue t14'><a href='perfil.php?id=<?php echo $usua->id;?>' class=''><b> <?php echo $usua->a_seudonimo;?></b></a></span><span></span>
					<br>
					<span class='t12 orange-apdp'><?php echo $usua->getTiempo();?> Vendiendo en Apreciodepana</span><br>						
					<span class='t11 grisO'> <i class='fa fa-heart negro marL5 opacity'>
					</i><span class=' point h-under marL5'><?php echo $usua->countFavoritos();?> Me gusta</span><i class='fa fa-share-alt negro marL15 opacity hidden'></i> <span class=' point h-under marL5 hidden'> num_prueba Veces compartido</span> </span>
				    <br>
				    <br>
				    </p>
		    </div>
		    <br>
		    <div class=' col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right'><div class='marR20'>
					<span class=' t12'><?php echo $usua->getEstado();?></span><br><span class='vin-blue t16'><a href='perfil.php?id=<?php echo $usua->id;?>' style='text-decoration:underline;'>Ver Mas</a></span >
			</div></div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-2'><br></div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-10'><hr class='marR10'><br></div>
			<?php
		}
	}
?>