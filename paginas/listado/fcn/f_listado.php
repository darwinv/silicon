<?php
	require '../../../config/core.php';
	include_once "../../../clases/publicaciones.php";
	include_once "../../../clases/usuarios.php";
	include_once "../../../clases/fotos.php";
	include_once "../../../clases/clasificados.php";
	include_once "../../../clases/busqueda.php";
	switch($_POST["metodo"]){
		case "buscar":
			if($_POST["bandera"]==""){
				busca();
			}else{
				busca2();
			}		
			break;
		case "filtrarCat":
			filtraCat();
			break;
		case "filtrarEst":
			filtraEst();
			break;
		case "filtrarCon":
			filtraCon();
			break;
		case "ordenar":
			ordena();
			break;
		case "filtrarPub":
			filtraPub();
			break;
		case "filtrarVen":
			filtraVen();
			break;			
	}
	function filtraCat(){
		 
		$bd=new bd();		
		$clasificado=new clasificados($_POST["id"]);
		$palabra=$_POST["palabra"]!=""?" and titulo like '%{$_POST["palabra"]}%'":"";
		if($_POST["estado"]!=""){
			$strEstado=" and usuarios_id in (select id from usuarios where estados_id={$_POST["estado"]})";
		}else{
			$strEstado="";
		}
		if($_POST["condicion"]!=""){
			$strCondicion=" and condiciones_publicaciones_id={$_POST["condicion"]}";
		}else{
			$strCondicion="";
		}
		$ruta=$clasificado->getAdressWithLinks($_POST["palabra"]);
		/*?>
		<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 resultados" > <!-- ocultar cuando no hay resultados -->
			<div class="marL5 marT5 marB5  contenedor">
				<div class="marL10">
					<div id="izquierda">
		<?php		*/
		/********************INICIO DE LA BUSQUEDA DE CATEGORIAS********************/
		$hijos=$clasificado->buscarHijos();
		 
		 if(!$hijos){
		 	$hijos[0]['id']=$clasificado->getID();
			$hijos[0]['nombre']=$clasificado->getNombre();
		 }
		 
		 ob_start();
		 
		if($hijos):
			
			
			?>			
			 
				<h5 class="negro"><b>Categorias</b></h5>
				<hr class="marR5">
				<ul class="nav marR5 t11  marT10 marB20 ">
					<?php
					foreach($hijos as $h=>$valor):
						$criterio="I" . $valor["id"] . "F";
						$condicion ="";
						
						$consulta="select count(id) as totaC from publicaciones where id in
						(select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null) $strEstado $strCondicion
						and clasificados_id in (select id from clasificados where ruta like '%$criterio%') $condicion $palabra";
						
						$result=$bd->query($consulta);
						$row=$result->fetch();
						if($row["totaC"]>0):
						?>
							<li class='marB10 t11'><div  class='h-gris'><span ><a class='blue-vin filtrocat' href='#' data-id="<?php echo $valor["id"];?>" data-cantidad="<?php echo $row["totaC"];?>"  ><?php echo  ($valor["nombre"]) ." ({$row["totaC"]})";?></a></span></div></li> 
							<?php
						endif;
						 
					endforeach;
					?>
				</ul>			
			 
			<?php
		endif;
		
		$categorias = ob_get_clean();
    	ob_end_clean();
		 
		echo (json_encode ( array('categoria'=> $categorias,'paginacion'=> paginator($_POST['cantidad']), 'ruta'=>$ruta) ));
		
		/******************FIN DE LA BUSQUEDA DE CATEGORIAS********************/
		/******************INICIO DE LA BUSQUEDA DE UBICACION******************/
		/*if($_POST["estado"]!=""){
			if($_POST["estado"]<100){
				$estados=$bd->doFullSelect("estados","id={$_POST["estado"]}");
				$ruta.=" En {$estados[0]["nombre"]}";
			}else{
				$estados=$bd->doFullSelect("estados");
			}
		}else{
			$estados=$bd->doFullSelect("estados");
		}
		$estado=$_POST["estado"]!=""?"data-estado={$_POST["estado"]}":"";
		?>
			<div id="ubicacion" <?php echo $estado;?>
				<h5 class="negro" ><b>Ubicaci&oacute;n</b></h5>							
					<hr class="marR5">
						<ul class="nav marR5 t11  marT10 marB20 ">
							<?php
							foreach($estados as $e=>$valor):
								$criterio="I" . $_POST["id"] . "F";
								$condicion=" and clasificados_id in (select id from clasificados where ruta like '%$criterio%') and ";
								$condicion.="id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null) $palabra $strCondicion";					
								$consulta="select count(id) as totaP from publicaciones where usuarios_id in (select id from usuarios where estados_id={$valor["id"]}) $condicion";
								$result=$bd->query($consulta);
								$row=$result->fetch();
								if($row["totaP"]>0):
								?>
									<li class='marB10 t11'><div  class='h-gris'><span ><a class='blue-vin filtroest' href='#' data-id="<?php echo $valor["id"];?>"><?php echo  ($valor["nombre"]) . " ({$row["totaP"]})";?></a></span></div></li>
<!--								<li class='marB10 t11'><div  class='h-gris'><span ><a class='blue-vin filtroest' href='#' data-id="<?php echo $valor["id"];?>"><?php echo  ($valor["nombre"]) . " (0)";?></a></span></li>-->
								<?php
								endif;
							endforeach;
							?>
						</ul>
			</div>
		<?php*/	
		/******************FIN DE LA BUSQUEDA DE UBICACION*********************/
		/******************INICIO DE LA BUSQUEDA DE CONDICION******************/
		/*
		$criterio="I" . $_POST["id"] . "F";		
		$condicion=" and clasificados_id in (select id from clasificados where ruta like '%$criterio%') and ";
		$condicion.="id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null) $palabra $strCondicion";
		$condicion.=$strEstado;
		$consulta="select 
		(select count(id) from publicaciones where condiciones_publicaciones_id=1 $condicion) as tota1,
		(select count(id) from publicaciones where condiciones_publicaciones_id=2 $condicion) as tota2,
		(select count(id) from publicaciones where condiciones_publicaciones_id=3 $condicion) as tota3";
		$result=$bd->query($consulta);
		$condiciones=$result->fetch();
		$con="";		
		switch($_POST["condicion"]){
			case 1:
				$con="data-condicion={$_POST["condicion"]}";
				$ruta .=" <span class='f-condicion'>Nuevo</span>";	
				break;
			case 2:
				$con="data-condicion={$_POST["condicion"]}";
				$ruta .=" <span class='f-condicion'>Usado</span>";	
				break;
			case 3:
				$con="data-condicion={$_POST["condicion"]}";
				$ruta .=" <span class='f-condicion'>Servicio</span>";	
				break;
		}
			$total=$condiciones["tota1"] + $condiciones["tota2"] + $condiciones["tota3"];		
		?>
			<div id="condicion" data-ruta="<?php echo  ($ruta);?>" <?php echo $con; ?> style="display:<?php if($total==0){ echo "none"; } else{ echo "block"; }?>">
				<h5 class="negro" ><b>Condici&oacute;n</b></h5>
				<hr class="marR5">
			</div>
			<ul class="nav marR5 marT10 marB20 t11">
				<?php
				if($condiciones["tota1"]>0):
					?>
				<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO filtrocon' href='#' data-id='1'>
				<span class='blue-vin'>Nuevo (<?php echo $condiciones["tota1"];?>)</a></div></div></li>
					<?php
				endif;			
				if($condiciones["tota2"]>0):
					?>			
				<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO filtrocon' href='#' data-id='2'>
				<span class='blue-vin'>Usado (<?php echo $condiciones["tota2"];?>)</a></div></div></li>
				<?php
				endif;
				if($condiciones["tota3"]>0):
				?>	
				<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO filtrocon' href='#' data-id='3'>
				<span class='blue-vin'>Servicios (<?php echo $condiciones["tota3"];?>)</a></div></div></li>
				<?php
				endif;
				  ?>
			</ul> 
		 /******************FIN DE LA BUSQUEDA DE CONDICION (NUEVO, USADO, SERVICIO)********************/
		/* ?>
			</div> <!--Cierre de Izquierda-->
			</div>
			</div>
		</div>
		<?php 
		 
			$condicion=substr($condicion,5,strlen($condicion));
			$consulta="select id from publicaciones where $condicion limit 25 OFFSET 0";
			$result=$bd->query($consulta);
			//$total=$result->rowCount();
			$totalPaginas=ceil($total/25);
		?>
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
							<?php echo  ($ruta);?>
						</span>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 ">
					<div class=" marR20" style="margin-top:10px;" id="orden">
						<select id="filtro"  class="form-control  input-sm " style="width:auto;"  >
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
						foreach($result as $p=>$valor):
							$i++;
							$publi=new publicaciones($valor["id"]);
							$usua=new usuario($publi->usuarios_id);
							$miTitulo=$publi->titulo;
							if($_POST["palabra"]!=""){
								$miTitulo=str_ireplace($_POST["palabra"], "<span style='background:#ccc'><b>" . $_POST["palabra"] . "</b></span>", $miTitulo);
							}
							?>
				            <!--publicacion-->
							<div class=' col-xs-12 col-sm-6 col-md-2 col-lg-2'>
						    	<div class='marco-foto-conf  point marL20  ' style='height:130px; width: 130px;'  >
						    		<div style='position:absolute; left:40px; top:10px; ' class='f-condicion'><?php echo $publi->getCondicion();?> </div>			 
							    		<img src='<?php echo $publi->getFotoPrincipal();?>' class='img img-responsive center-block img-apdp imagen' style='width:100%;height:100%;'
							    		data-id='<?php echo $publi->id;?>' data-tipo='P'>				
									</div>
								</div>
								<div class=' col-xs-12 col-sm-6 col-md-7 col-lg-7'><p class='t16 marL10 marT5'>
							    	<span class=' t15'><a class='negro' href='detalle.php?id=<?php echo $publi->id;?>' class='grisO'><b> <?php echo  ($miTitulo);?></b></a></span>
									<br><span class=' vin-blue t14'><a href='perfil.php?id=<?php echo $usua->id;?>' class=''><b> <?php echo $usua->a_seudonimo;?></b></a></span>
									<br><span class='t14 grisO '><?php echo  ($usua->getNombre());?></span><br>
									<span class='t12 grisO '><i class='glyphicon glyphicon-time t14  opacity'></i><?php echo $publi->getTiempoPublicacion();?></span><br>
									<span class='t11 grisO'> <span> <i class='fa fa-eye negro opacity'></i></span><span class='marL5'><?php echo $publi->getVisitas();?> Visitas</span><i class='fa fa-heart negro marL5 opacity'>
									</i><span class=' point h-under marL5'><?php echo $publi->getFavoritos();?> Me gusta</span><i class='fa fa-share-alt negro marL15 opacity hidden'></i> <span class=' point h-under marL5 hidden'> <?php echo $publi->getCompartidos(3);?> Veces compartido</span> </span></p>
							    </div>
							    <div class=' col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right'>
							    	<div class='marR20'><span class='red t20'><b> <?php echo $publi->getMonto();?></b></span >
										<br><span class=' t12'> <?php echo $usua->getEstado();?> </span><br><span class='vin-blue t16'><a href='detalle.php?id=<?php echo $publi->id;?>' style='text-decoration:underline;'>Ver Mas</a></span >
									</div>
								</div>
								<div class='col-xs-12 col-sm-12 col-md-12 col-lg-2'><br></div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-10'><hr class='marR10'><br></div>
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
					<?php */
					 
	}
		/**************FILTRAR POR ESTADO********************/
	function filtraEst(){
		$bd=new bd();
		$palabra=$_POST["palabra"]!=""?" and titulo like '%{$_POST["palabra"]}%'":"";
		$condicion=" and usuarios_id in (select id from usuarios where estados_id={$_POST["id"]})";
		$foto=new fotos();
		if($_POST["condicion"]!=""){
			$strCondicion=" and condiciones_publicaciones_id={$_POST["condicion"]}";
		}else{
			$strCondicion="";
		}
		?>
		<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 resultados" > <!-- ocultar cuando no hay resultados -->
			<div class="marL5 marT5 marB5  contenedor">
				<div class="marL10">
					<div id="izquierda">
		<?php
		if($_POST["palabra"]!=""){
			$criterioPal1=explode(" ",$_POST["palabra"]);
			$criterioPal2="(";
			$criterioPal3="(";
			foreach ($criterioPal1 as $c=>$valor) {
				$criterioPal2.="nombre like '%$valor%' or apellido like '%$valor%' or ";
				$criterioPal3.="razon_social like '%$valor%' or ";
			}
			$criterioPal2=substr($criterioPal2,0,strlen($criterioPal2)-4) . ")";
			$criterioPal3=substr($criterioPal3,0,strlen($criterioPal3)-4) . ")";
			if($_POST["id"]<100){
				$consultaNat="select usuarios_id from usuarios_naturales where $criterioPal2 and usuarios_id in (select id from usuarios where estados_id={$_POST["id"]})";
				$consultaJur="select usuarios_id from usuarios_juridicos where $criterioPal3 and usuarios_id in (select id from usuarios where estados_id={$_POST["id"]})";
				$consultaNat2="select usuarios_id from usuarios_naturales where $criterioPal2";
				$consultaJur2="select usuarios_id from usuarios_juridicos where $criterioPal3";
			}else{
				$consultaNat="select usuarios_id from usuarios_naturales where $criterioPal2";
				$consultaJur="select usuarios_id from usuarios_juridicos where $criterioPal3";
				$consultaNat2=$consultaNat;
				$consultaJur2=$consultaJur;				
			}
			$result1=" id in ($consultaNat UNION $consultaJur)";
			$result2=" id in ($consultaNat2 UNION $consultaJur2)";
			$consulta="select count(id) as tota from usuarios where $result1";
			$consulta2="select count(id) as tota from usuarios where $result2";
			$result=$bd->query($consulta);
			$row2=$result->fetch();
			$totalVen=$row2["tota"];
			$result=$bd->query($consulta2);
			$row3=$result->fetch();			
			$totalVen2=$row3["tota"];
		}else{
			$totalVen=0;
			$totalVen2=0;
		}
		if($_POST["categoria"]==""):   //Mostrar el DIV de Tipos ya que no ha seleccionado ninguna categoria
			/*****************BUSCAR LA CANTIDAD DE PUBLICACIONES Y VENDEDORES****************/
			$result=$bd->query("select count(id) as tota from publicaciones where id in 
				(select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null) $palabra $condicion $strCondicion");
			$row=$result->fetch();
			?>
			<div id="tipo">
				<h5 class="negro" ><b>Tipo</b></h5>
				<hr class="marR5">
			</div>		
			<ul class="nav marR5 marT10 marB20 t11">
				<?php
				if($row["tota"]>0):
					?>
				<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO' href='#'>
				<span class='blue-vin <?php if(!isset($row2)) echo "filtropub";?>'>Publicaciones (<?php echo $row["tota"];?>)</a></div></li>
				<?php
				endif;
				if(isset($row2)):
					?>
					<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO' href='#'>
					<span class='blue-vin filtroven'>Vendedores (<?php echo $row2["tota"];?>)</a></div></div></li>
					<?php
				endif;
				?>
			</ul>
			<?php
		endif;
		/*************FIN DE LA BUSQUEDA DE CANTIDAD DE PUBLICACIONES Y VENDEDORES****************/
		/**********************INICIO DE LA BUSQUEDA DE CATEGORIAS********************************/
		if($_POST["categoria"]!=""){
			$hijos=$bd->doFullSelect("clasificados","clasificados_id={$_POST["categoria"]}");
			$cat="data-categoria='{$_POST["categoria"]}'";
			$categoria=new clasificados($_POST["categoria"]);
			$ruta=$categoria->getAdressWithLinks($_POST["palabra"]);
			$criterio="I" . $_POST["categoria"] . "F";
		    $criterio=" and clasificados_id in (select id from clasificados where ruta like '%$criterio%')";						
		}else{
			$hijos=$bd->doFullSelect("clasificados","clasificados_id<=4");
			$cat="";
			$criterio="";
			$ruta=$_POST["palabra"]!=""?"'{$_POST["palabra"]}'":"";
		}
		if($hijos):
			?>
			<div id="categoria" <?php echo $cat;?>>
				<h5 class="negro"><b>Categorias</b></h5>
				<hr class="marR5">
				<ul class="nav marR5 t11  marT10 marB20 ">
					<?php
					$strUsuario=$_POST["id"]<100?"and usuarios_id in (select id from usuarios where estados_id={$_POST["id"]})":"";
					foreach($hijos as $h=>$valor):
						$criterio2="I" . $valor["id"] . "F";
						$consulta="select count(id) as totaC from publicaciones where id in 
						(select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null) 
						and clasificados_id in (select id from clasificados where ruta like '%$criterio2%') $palabra $strUsuario $strCondicion";
						$result=$bd->query($consulta);
						$row=$result->fetch();
						if($row["totaC"]>0):
						?>
							<li class='marB10 t11'><div  class='h-gris'><span ><a class='blue-vin filtrocat' href='#' data-id="<?php echo $valor["id"];?>"><?php echo  ($valor["nombre"]) ." ({$row["totaC"]})";?></a></span></div></li> 
							<?php
						endif;
					endforeach;
					?>
				</ul>
			</div>
			<?php
		endif;
		/***********************FINAL DE LA BUSQUEDA DE CATEGORIAS********************************/
		/******************INICIO DE LA BUSQUEDA DE UBICACION******************/
		if($_POST["id"]<100){
			$est="data-estado={$_POST["id"]}";
		}else{
			$est="";
		}
		if($_POST["id"]<100):
			$row2=$bd->doSingleSelect("estados","id={$_POST["id"]}");
			$ruta.= " En {$row2["nombre"]}";
			$strUsuario=$_POST["id"]<100?"and usuarios_id in (select id from usuarios where estados_id={$_POST["id"]})":"";
			$condicion=" id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null) $palabra";								
			$consulta="select count(id) as totaP from publicaciones where $condicion $strUsuario $criterio $strCondicion";
			$consulta2="select count(id) as totaP from publicaciones where $condicion $criterio $strCondicion";
			$result=$bd->query($consulta);
			$row=$result->fetch();
			$result=$bd->query($consulta);
			$row3=$result->fetch();			
			$totalGen=$totalVen + $row["totaP"];
			$totalGen2=$totalVen2 + $row3["totaP"];
			$ac=$totalGen;
		?>
			<div id="ubicacion" <?php echo $est;?> >
				<h5 class="negro" ><b>Ubicaci&oacute;n</b></h5>
				<hr class="marR5">
				<ul class="nav marR5 t11  marT10 marB20 ">
					<li class='marB10 t11'><div  class='h-gris'><span ><a class='filtroest' href='#' data-id='100'>TODOS (<?php echo $totalGen2;?>)</a></span></div></li>
						<li class='marB10 t11'><div  class='h-gris'><span ><a class='blue-vin filtroest' href='#' data-id="<?php echo $_POST["id"];?>"><?php echo  ($row2["nombre"]) . "(" . $totalGen . ")";?></a></span></div></li>																						
					<?php
		else:
			$estados=$bd->doFullSelect("estados");
			$estado="";
			if($_POST["palabra"]!="" && $_POST["categoria"]=="" && $_POST["condicion"]==""){
				$consultaNat="select usuarios_id from usuarios_naturales where $criterioPal2";
				$consultaJur="select usuarios_id from usuarios_juridicos where $criterioPal3";
			}
		?>
			<div id="ubicacion" <?php echo $estado;?>
				<h5 class="negro" ><b>Ubicaci&oacute;n</b></h5>							
				<hr class="marR5">
				<ul class="nav marR5 t11  marT10 marB20 ">
		<?php
				$ac=0;
				foreach($estados as $e=>$valor):
					$condicion=" $criterio ";
					$condicion="and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null) $criterio $palabra $strCondicion";								
					$consulta="select count(id) as totaP from publicaciones where usuarios_id in (select id from usuarios where estados_id={$valor["id"]}) $condicion";					
					$result=$bd->query($consulta);
					$row=$result->fetch();
					$totalG=$row["totaP"];
					if($_POST["palabra"]!="" && $_POST["categoria"]=="" && $_POST["condicion"]==""){
						$consulta="select count(id) as tota from usuarios where id in ($consultaNat UNION $consultaJur) and estados_id={$valor["id"]}";
						$result2=$bd->query($consulta);
						$row2=$result2->fetch();
						$totalG+=$row2["tota"];
					}
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
		/******************INICIO DE LA BUSQUEDA DE CONDICION******************/
		if($_POST["categoria"]!=""){
			$criterio="I" . $_POST["categoria"] . "F";
			$condicion=" and clasificados_id in (select id from clasificados where ruta like '%$criterio%') and ";			
		}else{
			$condicion="and ";
		}
		if($_POST["id"]<100){
			$condicion.="usuarios_id in (select id from usuarios where estados_id={$_POST["id"]}) and id in 
			(select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null) $palabra";
		}else{
			$condicion.="id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null) $palabra";			
		}
		$consulta="select  
		(select count(id) from publicaciones where condiciones_publicaciones_id=1 $condicion) as tota1,
		(select count(id) from publicaciones where condiciones_publicaciones_id=2 $condicion) as tota2,
		(select count(id) from publicaciones where condiciones_publicaciones_id=3 $condicion) as tota3";
		$result=$bd->query($consulta);
		$condiciones=$result->fetch();		
		$con="";		
		switch($_POST["condicion"]){
			case 1:
				$con="data-condicion={$_POST["condicion"]}";
				$ruta .=" <span class='f-condicion'>Nuevo</span>";
				$total=$condiciones["tota1"];					
				break;
			case 2:
				$con="data-condicion={$_POST["condicion"]}";
				$ruta .=" <span class='f-condicion'>Usado</span>";
				$total=$condiciones["tota2"];					
				break;
			case 3:
				$con="data-condicion={$_POST["condicion"]}";
				$ruta .=" <span class='f-condicion'>Servicio</span>";
				$total=$condiciones["tota3"];
				break;
			default:
				$total=$condiciones["tota1"] + $condiciones["tota2"] + $condiciones["tota3"];
				break;
		}
		?>
			<div id="condicion" data-ruta="<?php echo  ($ruta);?>" <?php echo $con;?> style="display:<?php if($total==0){ echo "none"; } else{ echo "block"; }?>">
				<h5 class="negro" ><b>Condici&oacute;n</b></h5>
				<hr class="marR5">
			</div>
			<ul class="nav marR5 marT10 marB20 t11">
				<?php
				if($condiciones["tota1"]>0 && ($_POST["condicion"]=="" || $_POST["condicion"]==1)):
					?>
				<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO filtrocon' href='#' data-id='1'>
				<span class='blue-vin'>Nuevo (<?php echo $condiciones["tota1"];?>)</a></div></div></li>
					<?php
				endif;			
				if($condiciones["tota2"]>0 && ($_POST["condicion"]=="" || $_POST["condicion"]==2)):
					?>			
				<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO filtrocon' href='#' data-id='2'>
				<span class='blue-vin'>Usado (<?php echo $condiciones["tota2"];?>)</a></div></div></li>
				<?php
				endif;
				if($condiciones["tota3"]>0 && ($_POST["condicion"]=="" || $_POST["condicion"]==3)):
				?>	
				<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO filtrocon' href='#' data-id='3'>
				<span class='blue-vin'>Servicios (<?php echo $condiciones["tota3"];?>)</a></div></div></li>
				<?php
				endif;
				/******************FIN DE LA BUSQUEDA DE CONDICION (NUEVO, USADO, SERVICIO)********************/				
				?>
			</ul>		
			</div> <!--Cierre de Izquierda-->
			</div>
			</div>
			
		</div>
		<?php
			if($total==0):
				?>
				<script>$("#categoria").css("display","none");</script>
			<?php
			endif;
			$condicion=substr($condicion,4,strlen($condicion));
			if($_POST["palabra"]=="" || $_POST["categoria"]!="" || $_POST["condicion"]!=""){
				//$consulta="select id,'P' as tipo from publicaciones where $condicion $strCondicion limit 25 OFFSET 0";
				$consulta="select id,'P' as tipo from publicaciones where $condicion $strCondicion limit 25 OFFSET 0";
//				$consultaTota="select count(id) as tota from publicaciones where $condicion $strCondicion";
				$result=$bd->query($consulta);
//				$result=$bd->query($consultaTota);				
//				$row=$result->fetch();
//				$total=$row["tota"];				
			}else{
				if($_POST["id"]!=100){	
					$consultaNat="select usuarios_id as id,'U' as tipo from usuarios_naturales where $criterioPal2 and usuarios_id in (select id from usuarios where estados_id={$_POST["id"]})";
					$consultaJur="select usuarios_id as id,'U' as tipo from usuarios_juridicos where $criterioPal3 and usuarios_id in (select id from usuarios where estados_id={$_POST["id"]})";
				}else{
					$consultaNat="select usuarios_id as id,'U' as tipo from usuarios_naturales where $criterioPal2";
					$consultaJur="select usuarios_id as id,'U' as tipo from usuarios_juridicos where $criterioPal3";
				}				
				$consulta="select id,'P' as tipo from publicaciones where $condicion $strCondicion UNION $consultaNat UNION $consultaJur limit 25 OFFSET 0";
//				$consultaTota="select count(id) as tota from publicaciones where $condicion $strCondicion UNION $consultaNat UNION $consultaJur ";
				$result=$bd->query($consulta);
				$total=$ac;
			}
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
									
						foreach($result as $p=>$valor):
							if($valor["tipo"]=="P"):
								$publi=new publicaciones($valor["id"]);
								$usua=new usuario($publi->usuarios_id);
								$miTitulo=$publi->titulo;
								if($_POST["palabra"]!=""){
									$miTitulo=str_ireplace($_POST["palabra"], "<span style='background:#ccc'><b>" . $_POST["palabra"] . "</b></span>", $miTitulo);
								}
								?>
				            	<!--publicacion-->
								<div class=' col-xs-12 col-sm-6 col-md-2 col-lg-2'>
							    	<div class='marco-foto-conf  point marL20  ' style='height:130px; width: 130px;'  >
							    		<div style='position:absolute; left:40px; top:10px; ' class='f-condicion'><?php echo $publi->getCondicion();?> </div>			 
								    		<img src='<?php echo $publi->getFotoPrincipal();?>' class='img img-responsive center-block img-apdp imagen' style='width:100%;height:100%;'
								    		data-id='<?php echo $publi->id;?>'>				
										</div>
									</div>
									<div class=' col-xs-12 col-sm-6 col-md-7 col-lg-7'><p class='t16 marL10 marT5'>
								    	<span class=' t15'><a class='negro' href='detalle.php?id=<?php echo $publi->id;?>' class='grisO'><b> <?php echo  ($miTitulo);?></b></a></span>
										<br><span class=' vin-blue t14'><a href='perfil.php?id=<?php echo $usua->id;?>' class=''><b> <?php echo $usua->a_seudonimo;?></b></a></span>
										<br><span class='t14 grisO '><?php echo  ($usua->getNombre());?></span><br>
										<span class='t12 grisO '><i class='glyphicon glyphicon-time t14  opacity'></i><?php echo $publi->getTiempoPublicacion();?></span>
										<span class='t11 grisO'> <span> <i class='fa fa-eye negro opacity'></i></span><span class='marL5'><?php echo $publi->getVisitas();?> Visitas</span><i class='fa fa-heart negro marL5 opacity'>
										</i><span class=' point h-under marL5'><?php echo $publi->getFavoritos();?> Me gusta</span><i class='fa fa-share-alt negro marL15 opacity hidden'></i> <span class=' point h-under marL5 hidden'> <?php echo $publi->getCompartidos(3);?> Veces compartido</span> </span>
										<br>
										<br>
										<br>
										</p>
								    </div>
								    <div class=' col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right'>
								    	<div class='marR20'><span class='red t20'><b> <?php echo $publi->getMonto();?></b></span >
											<br><span class=' t12'> <?php echo $usua->getEstado();?> </span><br><span class='vin-blue t16'><a href='detalle.php?id=<?php echo $publi->id;?>' style='text-decoration:underline;'>Ver Mas</a></span >
										</div>
									</div>
									<div class='col-xs-12 col-sm-12 col-md-12 col-lg-2'><br></div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-10'><hr class='marR10'><br></div>
								<?php
							else:
								$usua=new usuario($valor["id"]);
								$miTitulo=$usua->getNombre();
								if($_POST["palabra"]!=""){
									foreach($criterioPal1 as $c=>$valor){
										$miTitulo=str_ireplace($valor, "<span style='background:#ccc'><b>" . strtoupper($valor) . "</b></span>", $miTitulo);										
									}
//									$miTitulo=str_ireplace($_POST["palabra"], "<span style='background:#ccc'><b>" . strtoupper($_POST["palabra"]) . "</b></span>", $miTitulo);
								}
								?>
								<div class=' col-xs-12 col-sm-6 col-md-2 col-lg-2'>
							  	  	<div class='marco-foto-conf  point marL20  ' style='height:130px; width: 130px;'  >
									    <!--<div style='position:absolute; left:40px; top:10px; ' class='f-condicion'> Vendedor </div>-->						 
									    <img src='<?php echo $foto->buscarFotoUsuario($usua->id);?>' class='img img-responsive center-block img-apdp imagen' style='width:100%;height:100%;' data-id='prueba'>							
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
							endif;
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
	function filtraCon(){
		$bd=new bd();
		$palabra=$_POST["palabra"]!=""?" and titulo like '%{$_POST["palabra"]}%'":"";
//		$condicion=" and usuarios_id in (select id from usuarios where estados_id={$_POST["estado"]})";
		if($_POST["id"]!=4){
			$strCondicion=" and condiciones_publicaciones_id={$_POST["id"]}";
		}else{
			$strCondicion="";
		}
		?>
		<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 resultados" > <!-- ocultar cuando no hay resultados -->
			<div class="marL5 marT5 marB5  contenedor">
				<div class="marL10">
					<div id="izquierda">
		<?php				
		/**********************INICIO DE LA BUSQUEDA DE CATEGORIAS********************************/
		if($_POST["categoria"]!=""){
			$hijos=$bd->doFullSelect("clasificados","clasificados_id={$_POST["categoria"]}");
			$cat="data-categoria='{$_POST["categoria"]}'";
			$categoria=new clasificados($_POST["categoria"]);
			$ruta=$categoria->getAdressWithLinks($_POST["palabra"]);
			$criterio="I" . $_POST["categoria"] . "F";
		    $criterio=" clasificados_id in (select id from clasificados where ruta like '%$criterio%') and";
		}else{
			$hijos=$bd->doFullSelect("clasificados","clasificados_id<=4");
			$cat="";
			$criterio="";
			$ruta=$_POST["palabra"]!=""?"'{$_POST["palabra"]}'":"";
		}
		if($_POST["estado"]!=""){
			if($_POST["estado"]<100){
				$estados=$bd->doFullSelect("estados","id={$_POST["estado"]}");
				$ruta.=" En {$estados[0]["nombre"]}";
				$strUsuario="and usuarios_id in (select id from usuarios where estados_id={$_POST["estado"]})";				
			}else{
				$estados=$bd->doFullSelect("estados");
				$strUsuario="";
			}
		}else{
			$estados=$bd->doFullSelect("estados");
			$strUsuario="";			
		}
		$estado=$_POST["estado"]!=""?"data-estado={$_POST["estado"]}":"";
		if($hijos):
			?>
			<div id="categoria" <?php echo $cat;?>>
				<h5 class="negro"><b>Categorias</b></h5>
				<hr class="marR5">
				<ul class="nav marR5 t11  marT10 marB20 ">
					<?php
					foreach($hijos as $h=>$valor):
						$criterio2="I" . $valor["id"] . "F";
						$consulta="select count(id) as totaC from publicaciones where id in 
						(select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null) 
						and clasificados_id in (select id from clasificados where ruta like '%$criterio2%') $palabra $strUsuario $strCondicion";
						$result=$bd->query($consulta);
						$row=$result->fetch();
						if($row["totaC"]>0):
						?>
							<li class='marB10 t11'><div  class='h-gris'><span ><a class='blue-vin filtrocat' href='#' data-id="<?php echo $valor["id"];?>"><?php echo  ($valor["nombre"]) ." ({$row["totaC"]})";?></a></span></div></li> 
							<?php
						endif;
					endforeach;
					?>
				</ul>
			</div>
			<?php
		endif;
		/***********************FINAL DE LA BUSQUEDA DE CATEGORIAS********************************/
		/******************INICIO DE LA BUSQUEDA DE UBICACION******************/
		?>
			<div id="ubicacion" <?php echo $estado;?>
				<h5 class="negro" ><b>Ubicaci&oacute;n</b></h5>		
					<hr class="marR5">
						<ul class="nav marR5 t11  marT10 marB20 ">
							<?php							
							foreach($estados as $e=>$valor):
								$strUsuario=" and usuarios_id in (select id from usuarios where estados_id={$valor["id"]})";
								$condicion=" $criterio ";
								$condicion.="id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null) $palabra ";
								$consulta="select count(id) as totaP from publicaciones where $condicion $strUsuario $strCondicion";
								$result=$bd->query($consulta);
								$row=$result->fetch();
								if($row["totaP"]>0):
								?>
									<li class='marB10 t11'><div  class='h-gris'><span ><a class='blue-vin filtroest' href='#' data-id="<?php echo $valor["id"];?>"><?php echo  ($valor["nombre"]) . " ({$row["totaP"]})";?></a></span></div></li>
<!--								<li class='marB10 t11'><div  class='h-gris'><span ><a class='blue-vin filtroest' href='#' data-id="<?php echo $valor["id"];?>"><?php echo  ($valor["nombre"]) . " (0)";?></a></span></li>-->
								<?php
								endif;
							endforeach;
							?>
						</ul>
			</div>
		<?php	
		/******************FIN DE LA BUSQUEDA DE UBICACION*********************/
		/******************INICIO DE LA BUSQUEDA DE CONDICION******************/
		if($_POST["categoria"]!=""){
			$criterio="I" . $_POST["categoria"] . "F";
			$condicion=" and clasificados_id in (select id from clasificados where ruta like '%$criterio%') and ";			
		}else{
			$condicion="and ";
		}
		if($_POST["estado"]!=""){
			if($_POST["estado"]<100){
				$condicion.="usuarios_id in (select id from usuarios where estados_id={$_POST["estado"]}) and id in 
				(select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null) $palabra";
			}else{
				$condicion.="id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null) $palabra";
			}			
		}else{
			$condicion.="id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null) $palabra";			
		}
		$consulta="select  
		(select count(id) from publicaciones where condiciones_publicaciones_id=1 $condicion) as tota1,
		(select count(id) from publicaciones where condiciones_publicaciones_id=2 $condicion) as tota2,
		(select count(id) from publicaciones where condiciones_publicaciones_id=3 $condicion) as tota3";
		$result=$bd->query($consulta);
		$condiciones=$result->fetch();
		switch($_POST["id"]){
			case 1:
				$con="data-condicion={$_POST["id"]}";
				$ruta .=" <span class='f-condicion'>Nuevo</span>";	
				break;
			case 2:
				$con="data-condicion={$_POST["id"]}";
				$ruta .=" <span class='f-condicion'>Usado</span>";	
				break;
			case 3:
				$con="data-condicion={$_POST["id"]}";
				$ruta .=" <span class='f-condicion'>Servicio</span>";	
				break;
			case 4:
				$con="";			
				break;								
		}
		?>
			<div id="condicion" data-ruta="<?php echo  ($ruta);?>" <?php echo $con;?>>
				<h5 class="negro" ><b>Condici&oacute;n</b></h5>
				<hr class="marR5">
			</div>
			<ul class="nav marR5 marT10 marB20 t11">
				<?php
				if($_POST["id"]!=4):
					?>
					<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO filtrocon' href='#' data-id='4'>
					<span class='blue-vin'>TODOS (<?php echo $condiciones["tota1"] + $condiciones["tota2"] + $condiciones["tota3"];?>)</a></div></div></li>
					<?php					
				endif;
				if($condiciones["tota1"]>0 && ($_POST["id"]==4 || $_POST["id"]==1)):
					?>
				<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO filtrocon' href='#' data-id='1'>
				<span class='blue-vin'>Nuevo (<?php echo $condiciones["tota1"];?>)</a></div></div></li>
					<?php
				endif;			
				if($condiciones["tota2"]>0 && ($_POST["id"]==4 || $_POST["id"]==2)):
					?>			
				<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO filtrocon' href='#' data-id='2'>
				<span class='blue-vin'>Usado (<?php echo $condiciones["tota2"];?>)</a></div></div></li>
				<?php
				endif;
				if($condiciones["tota3"]>0 && ($_POST["id"]==4 || $_POST["id"]==3)):
				?>	
				<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO filtrocon' href='#' data-id='3'>
				<span class='blue-vin'>Servicios (<?php echo $condiciones["tota3"];?>)</a></div></div></li>
				<?php
				/******************FIN DE LA BUSQUEDA DE CONDICION (NUEVO, USADO, SERVICIO)********************/				
				endif;
				?>
			</ul>
			</div> <!--Cierre de Izquierda-->
			</div>
			</div>
		</div>
		<?php
			if($_POST["id"]==4){
				$condicion=substr($condicion,4,strlen($condicion));
				$consulta="select id from publicaciones where $condicion limit 25 OFFSET 0";
				$total=$condiciones["tota1"] + $condiciones["tota2"] + $condiciones["tota3"];				
			}else{
				$consulta="select id from publicaciones where condiciones_publicaciones_id={$_POST["id"]} $condicion limit 25 OFFSET 0";
				$total=$condiciones["tota{$_POST["id"]}"];
			}
			$result=$bd->query($consulta);
			//$total=$result->rowCount();
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
						foreach($result as $p=>$valor):
							$i++;
							$publi=new publicaciones($valor["id"]);
							$usua=new usuario($publi->usuarios_id);
							$miTitulo=$publi->titulo;
							if($_POST["palabra"]!=""){
								$miTitulo=str_ireplace($_POST["palabra"], "<span style='background:#ccc'><b>" . $_POST["palabra"] . "</b></span>", $miTitulo);
							}
							?>
				            <!--publicacion-->
							<div class=' col-xs-12 col-sm-6 col-md-2 col-lg-2'>
						    	<div class='marco-foto-conf  point marL20  ' style='height:130px; width: 130px;'  >
						    		<div style='position:absolute; left:40px; top:10px; ' class='f-condicion'><?php echo $publi->getCondicion();?> </div>			 
							    		<img src='<?php echo $publi->getFotoPrincipal();?>' class='img img-responsive center-block img-apdp imagen' style='width:100%;height:100%;'
							    		data-id='<?php echo $publi->id;?>'>				
									</div>
								</div>
								<div class=' col-xs-12 col-sm-6 col-md-7 col-lg-7'><p class='t16 marL10 marT5'>
							    	<span class=' t15'><a class='negro' href='detalle.php?id=<?php echo $publi->id;?>' class='grisO'><b> <?php echo  ($miTitulo);?></b></a></span>
									<br><span class=' vin-blue t14'><a href='perfil.php?id=<?php echo $usua->id;?>' class=''><b> <?php echo $usua->a_seudonimo;?></b></a></span>
									<br><span class='t14 grisO '><?php echo  ($usua->getNombre());?></span><br>
									<span class='t12 grisO '><i class='glyphicon glyphicon-time t14  opacity'></i><?php echo $publi->getTiempoPublicacion();?></span>
									<span class='t11 grisO'> <span> <i class='fa fa-eye negro opacity'></i></span><span class='marL5'><?php echo $publi->getVisitas();?> Visitas</span><i class='fa fa-heart negro marL5 opacity'>
									</i><span class=' point h-under marL5'><?php echo $publi->getFavoritos();?> Me gusta</span><i class='fa fa-share-alt negro marL15 opacity hidden'></i> <span class=' point h-under marL5 hidden'> <?php echo $publi->getCompartidos(3);?> Veces compartido</span> </span>
									<br>
									<br>
									<br>
									</p>
							    </div>
							    <div class=' col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right'>
							    	<div class='marR20'><span class='red t20'><b> <?php echo $publi->getMonto();?></b></span >
										<br><span class=' t12'> <?php echo $usua->getEstado();?> </span><br><span class='vin-blue t16'><a href='detalle.php?id=<?php echo $publi->id;?>' style='text-decoration:underline;'>Ver Mas</a></span >
									</div>
								</div>
								<div class='col-xs-12 col-sm-12 col-md-12 col-lg-2'><br></div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-10'><hr class='marR10'><br></div>
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
		
		$categoria=isset($_POST["categoria"])?$_POST["categoria"]:"";
		$condicion=isset($_POST["condicion"])?$_POST["condicion"]:"";
		$estado=isset($_POST["estado"])?$_POST["estado"]:"";
		$orden=isset($_POST["orden"])?$_POST["orden"]:"";
		$palabra=isset($_POST["palabra"])?$_POST["palabra"]:"";
		$ver_tiendas=isset($_POST["ver_tiendas"])?$_POST["ver_tiendas"]:"0";
		$pagina=isset($_POST["pagina"])?$_POST["pagina"]:"1";
		
		$categoria=$valores=array("palabra"=>$palabra,
				"ver_tiendas"=>$ver_tiendas,
				"pagina"=>$pagina,
				"orden"=>$orden,
				"estados_id"=>$estado,
				"clasificados_id"=>$categoria);
		
		$busqueda=new busqueda($valores);
		
		$result=$busqueda->getPublicaciones();
		  
		foreach($result as $r=>$valor){
			if($valor["tipo"]=="P"):
				$publi=new publicaciones($valor["id"]);
				/*$usua=new usuario($publi->usuarios_id);*/
				$miTitulo=$publi->titulo;
				$miTitulo=str_ireplace($palabra, "<span style='background:#ccc'><b>" . strtoupper($palabra) . "</b></span>", $miTitulo);				
				?>

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
					<div class='col-xs-12 col-sm-12 col-md-12 col-lg-2'><br></div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-10'><hr class='marR10'><br></div><?php			
			endif;
		}
	}
	function busca2(){
		$bd=new bd();
		$foto=new fotos();
		$consulta="select id from usuarios";
		$criterioPal1=explode(" ",$_POST["palabra"]);
		$criterioPal2="(";
		$criterioPal3="(";
		foreach ($criterioPal1 as $c=>$valor) {
			$criterioPal2.="nombre like '%$valor%' or apellido like '%$valor%' or ";
			$criterioPal3.="razon_social like '%$valor%' or ";			
		}
		$criterioPal2=substr($criterioPal2,0,strlen($criterioPal2)-4) . ")";
		$criterioPal3=substr($criterioPal3,0,strlen($criterioPal3)-4) . ")";
		$consultaNat="select usuarios_id as id from usuarios_naturales where $criterioPal2";
		$consultaJur="select usuarios_id as id from usuarios_juridicos where $criterioPal3";
		$consulta.=" where id in ($consultaNat UNION $consultaJur)";
		$inicio=($_POST["pagina"] - 1) * 25;
		if($_POST["estado"]!=""){
			$consulta.=" and estados_id={$_POST["estado"]}";
		}		
		$consulta.=" limit 25 OFFSET $inicio";
		$result=$bd->query($consulta);
		foreach($result as $r=>$valor){
			$usua=new usuario($valor["id"]);
			$miTitulo=$usua->getNombre();
			$criterioPal1=explode(" ",$_POST["palabra"]);
			foreach($criterioPal1 as $c=>$valor){
				$miTitulo=str_ireplace($valor, "<span style='background:#ccc'><b>" . strtoupper($valor) . "</b></span>", $miTitulo);										
			}		
			?>
			<div class=' col-xs-12 col-sm-6 col-md-2 col-lg-2'>
		 	  	<div class='marco-foto-conf  point marL20  ' style='height:130px; width: 130px;'  >
				    <img src='<?php echo $foto->buscarFotoUsuario($usua->id);?>' class='img img-responsive center-block img-apdp imagen' style='width:100%;height:100%;' data-id='prueba'>							
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
		$consulta="select id from publicaciones where id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null)";
		$_POST["orden"]=str_replace("_"," ", $_POST["orden"]);
		if($_POST["categoria"]!=""){
			$criterio="I{$_POST["categoria"]}F";
			$consulta.=" and clasificados_id in (select id from clasificados where ruta like '%$criterio%')";
		}
		if($_POST["condicion"]){
			$consulta.=" and condiciones_publicaciones_id = {$_POST["condicion"]}";
		}
		if($_POST["estado"]!=""){
			$consulta.=" and usuarios_id in (select id from usuarios where estados_id={$_POST["estado"]})";
		}
		if($_POST["palabra"]!=""){
			$consulta.=" and titulo like '%{$_POST["palabra"]}%'";
		}
		$consulta.=" order by {$_POST["orden"]} limit 25 OFFSET 0";
		$result=$bd->query($consulta);
		foreach($result as $r=>$valor){
			$publi=new publicaciones($valor["id"]);
			$usua=new usuario($publi->usuarios_id);
			$miTitulo=$publi->titulo;
			$miTitulo=str_ireplace($_POST["palabra"], "<span style='background:#ccc'><b>" . strtoupper($_POST["palabra"]) . "</b></span>", $miTitulo);				
			?>
			<div class=' col-xs-12 col-sm-6 col-md-2 col-lg-2'>
			   	<div class='marco-foto-conf  point marL20  ' style='height:130px; width: 130px;'  >
			   		<div style='position:absolute; left:40px; top:10px; ' class='f-condicion'><?php echo $publi->getCondicion();?> </div>			 
			    		<img src='<?php echo $publi->getFotoPrincipal();?>' class='img img-responsive center-block img-apdp imagen' style='width:100%;height:100%;'
			    		data-id='<?php echo $publi->id;?>'>				
					</div>
				</div>
			<div class=' col-xs-12 col-sm-6 col-md-7 col-lg-7'><p class='t16 marL10 marT5'>
		    <span class=' t15'><a class='negro' href='detalle.php?id=<?php echo $publi->id;?>' class='grisO'><b> <?php echo  ($miTitulo);?></b></a></span>
			<?php /*	<br><span class=' vin-blue t14'><a href='perfil.php?id=<?php echo $usua->id;?>' class=''><b> <?php echo $usua->a_seudonimo;?></b></a></span> */?>
			<?php /*	<br><span class='t14 grisO '><?php echo  ($usua->getNombre());?></span><br> */?>
				<span class='t12 grisO' style="display: block;"><i class='glyphicon glyphicon-time t14  opacity'></i><?php echo $publi->getTiempoPublicacion();?></span><br>
				<span class='t11 grisO'> <span> <i class='fa fa-eye negro opacity'></i></span><span class='marL5'><?php echo $publi->getVisitas();?> Visitas</span><i class='fa fa-heart negro marL5 opacity'>
				</i><span class=' point h-under marL5'><?php echo $publi->getFavoritos();?> Me gusta</span><i class='fa fa-share-alt negro marL15 opacity hidden'></i> <span class=' point h-under marL5 hidden'> <?php echo $publi->getCompartidos(3);?> Veces compartido</span> </span></p>
		    </div>
		    <div class=' col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right'>
		    	<div class='marR20'><span class='red t20'><b> <?php echo $publi->getMonto();?></b></span >
						<?php /*<br><span class=' t12'> <?php echo $usua->getEstado();?> </span><br> */ ?>
						<span style="display: block;" class='vin-blue t16'><a href='detalle.php?id=<?php echo $publi->id;?>' style='text-decoration:underline;'>Ver Mas</a></span >
				</div>
			</div>
			<div class='col-xs-12 col-sm-12 col-md-12 col-lg-2'><br></div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-10'><hr class='marR10'><br></div>		
		<?php
		}
	}
	function filtraPub(){
		$bd=new bd();		
		$palabra=$_POST["palabra"]!=""?" and titulo like '%{$_POST["palabra"]}%'":"";
		if($_POST["estado"]!=""){
			$strEstado=" and usuarios_id in (select id from usuarios where estados_id={$_POST["estado"]})";
		}else{
			$strEstado="";
		}
		$ruta=$_POST["palabra"]!=""?"'{$_POST["palabra"]}'":"";
		$ruta.=" <span class='f-condicion'> Publicaciones </span>";
		?>
		<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 resultados" > <!-- ocultar cuando no hay resultados -->
			<div class="marL5 marT5 marB5  contenedor">
				<div class="marL10">
					<div id="izquierda">
		<?php		
		/********************INICIO DE LA BUSQUEDA DE CATEGORIAS********************/
		$hijos=$bd->query("select * from clasificados where clasificados_id<=4");
		if($hijos):
			?>			
			<div id="categoria">
				<h5 class="negro"><b>Categorias</b></h5>
				<hr class="marR5">
				<ul class="nav marR5 t11  marT10 marB20 ">
					<?php
					foreach($hijos as $h=>$valor):
						$criterio="I" . $valor["id"] . "F";
						$consulta="select count(id) as totaC from publicaciones where id in 
						(select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null) $strEstado 
						and clasificados_id in (select id from clasificados where ruta like '%$criterio%') $palabra";
						$result=$bd->query($consulta);
						$row=$result->fetch();
						if($row["totaC"]>0):
						?>
							<li class='marB10 t11'><div  class='h-gris'><span ><a class='blue-vin filtrocat' href='#' data-id="<?php echo $valor["id"];?>"><?php echo  ($valor["nombre"]) ." ({$row["totaC"]})";?></a></span></div></li> 
							<?php
						endif;
					endforeach;
					?>
				</ul>
			</div>
			<?php
		endif;
		/******************FIN DE LA BUSQUEDA DE CATEGORIAS********************/
		/******************INICIO DE LA BUSQUEDA DE UBICACION******************/
		if($_POST["estado"]!=""){
			if($_POST["estado"]<100){
				$estados=$bd->doFullSelect("estados","id={$_POST["estado"]}");
				$ruta.=" En {$estados[0]["nombre"]}";
			}else{
				$estados=$bd->doFullSelect("estados");
			}
		}else{
			$estados=$bd->doFullSelect("estados");
		}
		$estado=$_POST["estado"]!=""?"data-estado={$_POST["estado"]}":"";
		?>
			<div id="ubicacion" <?php echo $estado;?>
				<h5 class="negro" ><b>Ubicaci&oacute;n</b></h5>							
					<hr class="marR5">
						<ul class="nav marR5 t11  marT10 marB20 ">
							<?php
							foreach($estados as $e=>$valor):
								$condicion=" and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null) $palabra";					
								$consulta="select count(id) as totaP from publicaciones where usuarios_id in (select id from usuarios where estados_id={$valor["id"]}) $condicion";
								$result=$bd->query($consulta);
								$row=$result->fetch();
								if($row["totaP"]>0):
								?>
									<li class='marB10 t11'><div  class='h-gris'><span ><a class='blue-vin filtroest' href='#' data-id="<?php echo $valor["id"];?>"><?php echo  ($valor["nombre"]) . " ({$row["totaP"]})";?></a></span></div></li>
<!--								<li class='marB10 t11'><div  class='h-gris'><span ><a class='blue-vin filtroest' href='#' data-id="<?php echo $valor["id"];?>"><?php echo  ($valor["nombre"]) . " (0)";?></a></span></li>-->
								<?php
								endif;
							endforeach;
							?>
						</ul>
			</div>
		<?php	
		/******************FIN DE LA BUSQUEDA DE UBICACION*********************/
		/******************INICIO DE LA BUSQUEDA DE CONDICION******************/
		$condicion=" and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null) $palabra ";
		$condicion.=$strEstado;
		$consulta="select 
		(select count(id) from publicaciones where condiciones_publicaciones_id=1 $condicion) as tota1,
		(select count(id) from publicaciones where condiciones_publicaciones_id=2 $condicion) as tota2,
		(select count(id) from publicaciones where condiciones_publicaciones_id=3 $condicion) as tota3";
		$result=$bd->query($consulta);
		$condiciones=$result->fetch();
		$con="";		
		$total=$condiciones["tota1"] + $condiciones["tota2"] + $condiciones["tota3"];		
		?>
			<div id="condicion" data-ruta="<?php echo  ($ruta);?>" style="display:<?php if($total==0){ echo "none"; } else{ echo "block"; }?>">
				<h5 class="negro" ><b>Condici&oacute;n</b></h5>
				<hr class="marR5">
			</div>
			<ul class="nav marR5 marT10 marB20 t11">
				<?php
				if($condiciones["tota1"]>0):
					?>
				<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO filtrocon' href='#' data-id='1'>
				<span class='blue-vin'>Nuevo (<?php echo $condiciones["tota1"];?>)</a></div></div></li>
					<?php
				endif;			
				if($condiciones["tota2"]>0):
					?>			
				<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO filtrocon' href='#' data-id='2'>
				<span class='blue-vin'>Usado (<?php echo $condiciones["tota2"];?>)</a></div></div></li>
				<?php
				endif;
				if($condiciones["tota3"]>0):
				?>	
				<li class='marB10 t11'><div  class='h-gris'><div style='padding:2px; '><a class='grisO filtrocon' href='#' data-id='3'>
				<span class='blue-vin'>Servicios (<?php echo $condiciones["tota3"];?>)</a></div></div></li>
				<?php
				endif;
				/******************FIN DE LA BUSQUEDA DE CONDICION (NUEVO, USADO, SERVICIO)********************/
				?>
			</ul>
			</div> <!--Cierre de Izquierda-->
			</div>
			</div>
		</div>
		<?php
			$condicion=substr($condicion,5,strlen($condicion));
			$consulta="select id from publicaciones where $condicion limit 25 OFFSET 0";
			$result=$bd->query($consulta);
			//$total=$result->rowCount();
			$totalPaginas=ceil($total/25);
		?>
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
							<?php echo  ($ruta);?>
						</span>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 ">
					<div class=" marR20" style="margin-top:10px;" id="orden">
						<select id="filtro"  class="form-control  input-sm " style="width:auto;"  >
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
						foreach($result as $p=>$valor):
							$i++;
							$publi=new publicaciones($valor["id"]);
							$usua=new usuario($publi->usuarios_id);
							$miTitulo=$publi->titulo;
							if($_POST["palabra"]!=""){
								$miTitulo=str_ireplace($_POST["palabra"], "<span style='background:#ccc'><b>" . $_POST["palabra"] . "</b></span>", $miTitulo);
							}
							?>
				            <!--publicacion-->
							<div class=' col-xs-12 col-sm-6 col-md-2 col-lg-2'>
						    	<div class='marco-foto-conf  point marL20  ' style='height:130px; width: 130px;'  >
						    		<div style='position:absolute; left:40px; top:10px; ' class='f-condicion'><?php echo $publi->getCondicion();?> </div>			 
							    		<img src='<?php echo $publi->getFotoPrincipal();?>' class='img img-responsive center-block img-apdp imagen' style='width:100%;height:100%;'
							    		data-id='<?php echo $publi->id;?>'>				
									</div>
								</div>
								<div class=' col-xs-12 col-sm-6 col-md-7 col-lg-7'><p class='t16 marL10 marT5'>
							    	<span class=' t15'><a class='negro' href='detalle.php?id=<?php echo $publi->id;?>' class='grisO'><b> <?php echo  ($miTitulo);?></b></a></span>
									<br><span class=' vin-blue t14'><a href='perfil.php?id=<?php echo $usua->id;?>' class=''><b> <?php echo $usua->a_seudonimo;?></b></a></span>
									<br><span class='t14 grisO '><?php echo  ($usua->getNombre());?></span><br>
									<span class='t12 grisO '><i class='glyphicon glyphicon-time t14  opacity'></i><?php echo $publi->getTiempoPublicacion();?></span><br>
									<span class='t11 grisO'> <span> <i class='fa fa-eye negro opacity'></i></span><span class='marL5'><?php echo $publi->getVisitas();?> Visitas</span><i class='fa fa-heart negro marL5 opacity'>
									</i><span class=' point h-under marL5'><?php echo $publi->getFavoritos();?> Me gusta</span><i class='fa fa-share-alt negro marL15 opacity hidden'></i> <span class=' point h-under marL5 hidden'> <?php echo $publi->getCompartidos(3);?> Veces compartido</span> </span></p>
							    </div>
							    <div class=' col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right'>
							    	<div class='marR20'><span class='red t20'><b> <?php echo $publi->getMonto();?></b></span >
										<br><span class=' t12'> <?php echo $usua->getEstado();?> </span><br><span class='vin-blue t16'><a href='detalle.php?id=<?php echo $publi->id;?>' style='text-decoration:underline;'>Ver Mas</a></span >
									</div>
								</div>
								<div class='col-xs-12 col-sm-12 col-md-12 col-lg-2'><br></div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-10'><hr class='marR10'><br></div>
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
	function filtraVen(){
		$bd=new bd();
		$palabra=$_POST["palabra"];
		$foto=new fotos();
		$ruta=$_POST["palabra"]!=""?"'{$_POST["palabra"]}'":"";
		$ruta.=" <span class='f-condicion'> Vendedores </span>";		
		?>
		<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 resultados" > <!-- ocultar cuando no hay resultados -->
			<div class="marL5 marT5 marB5  contenedor">
				<div class="marL10">
					<div id="izquierda">
		<?php
		$criterioPal1=explode(" ",$_POST["palabra"]);
		$criterioPal2="(";
		$criterioPal3="(";
		foreach ($criterioPal1 as $c=>$valor) {
			$criterioPal2.="nombre like '%$valor%' or apellido like '%$valor%' or ";
			$criterioPal3.="razon_social like '%$valor%' or ";
		}
		$criterioPal2=substr($criterioPal2,0,strlen($criterioPal2)-4) . ")";
		$criterioPal3=substr($criterioPal3,0,strlen($criterioPal3)-4) . ")";
		if($_POST["estado"]<100 && $_POST["estado"]!=""){
			$consultaNat="select usuarios_id from usuarios_naturales where $criterioPal2 and usuarios_id in (select id from usuarios where estados_id={$_POST["estado"]})";
			$consultaJur="select usuarios_id from usuarios_juridicos where $criterioPal3 and usuarios_id in (select id from usuarios where estados_id={$_POST["estado"]})";
			$consultaNat2="select usuarios_id from usuarios_naturales where $criterioPal2";
			$consultaJur2="select usuarios_id from usuarios_juridicos where $criterioPal3";
		}else{
			$consultaNat="select usuarios_id from usuarios_naturales where $criterioPal2";
			$consultaJur="select usuarios_id from usuarios_juridicos where $criterioPal3";
			$consultaNat2=$consultaNat;
			$consultaJur2=$consultaJur;				
		}
		$result1=" id in ($consultaNat UNION $consultaJur)";
		$result2=" id in ($consultaNat2 UNION $consultaJur2)";
		$consulta="select count(id) as tota from usuarios where $result1";
		$consulta2="select count(id) as tota from usuarios where $result2";
		$result=$bd->query($consulta);
		$row2=$result->fetch();
		$totalVen=$row2["tota"];
		$result=$bd->query($consulta2);
		$row3=$result->fetch();			
		$totalVen2=$row3["tota"];
		/******************INICIO DE LA BUSQUEDA DE UBICACION******************/
		if($_POST["estado"]<100){
			$est="data-estado={$_POST["estado"]}";
		}else{
			$est="";
		}
		if($_POST["estado"]<100 && $_POST["estado"]!=""):
			$row2=$bd->doSingleSelect("estados","id={$_POST["estado"]}");
			$ruta.= " En {$row2["nombre"]}";
			$totalGen=$totalVen;
			$totalGen2=$totalVen2;
		?>
 			<div data-bandera="sv" id="ubicacion" <?php echo $est;?> >
				<h5 class="negro" ><b>Ubicaci&oacute;n</b></h5>
				<hr class="marR5">
				<ul class="nav marR5 t11  marT10 marB20 ">
					<li class='marB10 t11'><div  class='h-gris'><span ><a class='filtroest' href='#' data-id='100'>TODOS (<?php echo $totalGen2;?>)</a></span></div></li>
						<li class='marB10 t11'><div  class='h-gris'><span ><a class='blue-vin filtroest' href='#' data-id="<?php echo $_POST["estado"];?>"><?php echo  ($row2["nombre"]) . "(" . $totalGen . ")";?></a></span></div></li>																						
					<?php
		else:
			$estados=$bd->doFullSelect("estados");
			$estado="";
			$consultaNat="select usuarios_id from usuarios_naturales where $criterioPal2";
			$consultaJur="select usuarios_id from usuarios_juridicos where $criterioPal3";
		?>
			<div data-bandera="sv" id="ubicacion" <?php echo $estado;?>
				<h5 class="negro" ><b>Ubicaci&oacute;n</b></h5>							
				<hr class="marR5">
				<ul class="nav marR5 t11  marT10 marB20 ">
		<?php
				foreach($estados as $e=>$valor):
					$consulta="select count(id) as tota from usuarios where id in ($consultaNat UNION $consultaJur) and estados_id={$valor["id"]}";
					$result2=$bd->query($consulta);
					$row2=$result2->fetch();
					$totalG=$row2["tota"];			
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
		/******************FIN DE LA BUSQUEDA DE UBICACION*********************/
			?>
		   	</ul>
			</ul>		
			</div> <!--Cierre de Izquierda-->
			</div>
			</div>			
		</div>
		<?php
			if($_POST["estado"]!=100 && $_POST["estado"]!=""){
				$consultaNat="select usuarios_id as id,'U' as tipo from usuarios_naturales where $criterioPal2 and usuarios_id in (select id from usuarios where estados_id={$_POST["estado"]})";
				$consultaJur="select usuarios_id as id,'U' as tipo from usuarios_juridicos where $criterioPal3 and usuarios_id in (select id from usuarios where estados_id={$_POST["estado"]})";
			}else{
				$consultaNat="select usuarios_id as id,'U' as tipo from usuarios_naturales where $criterioPal2";
				$consultaJur="select usuarios_id as id,'U' as tipo from usuarios_juridicos where $criterioPal3";
			}				
			$consulta="$consultaNat UNION $consultaJur";
			$result=$bd->query($consulta);
			$total=$result->rowCount();
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
						foreach($result as $p=>$valor):
								$usua=new usuario($valor["id"]);
								$miTitulo=$usua->getNombre();
								if($_POST["palabra"]!=""){
									foreach($criterioPal1 as $c=>$valor){
										$miTitulo=str_ireplace($valor, "<span style='background:#ccc'><b>" . strtoupper($valor) . "</b></span>", $miTitulo);										
									}
//									$miTitulo=str_ireplace($_POST["palabra"], "<span style='background:#ccc'><b>" . strtoupper($_POST["palabra"]) . "</b></span>", $miTitulo);
								}
								$i++;
								?>
								<div class=' col-xs-12 col-sm-6 col-md-2 col-lg-2'>
							  	  	<div class='marco-foto-conf  point marL20  ' style='height:130px; width: 130px;'  >
									    <!--<div style='position:absolute; left:40px; top:10px; ' class='f-condicion'> Vendedor </div>-->						 
									    <img src='<?php echo $foto->buscarFotoUsuario($usua->id);?>' class='img img-responsive center-block img-apdp imagen' style='width:100%;height:100%;' data-id='prueba'>							
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
								if($i>=25)
								break;							
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
						<li id="siguiente1" name="siguiente1"><a href='#' class="navegador" data-funcion='siguiente1' aria-label='Next'><i class='fa fa-angle-right'></i> </a>
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
	function paginator($total=null){
		if(empty($total))
			$total=$_POST['total_row'];
		$totalPaginas=ceil($total/25);
		
		$oculto="";
		$activo="active";			
		$paginador='<div id="paginacion" name="paginacion" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " data-paginaActual="1" data-total="<?php echo $total;?>"><center><nav><ul class="pagination">
							    	 
											<li id="anterior2" name="anterior2" class="hidden"><a href="#" aria-label="Previous" class="navegador" data-funcion="anterior2"><i class="fa fa-angle-double-left"></i> </a>
											<li id="anterior1" name="anterior1" class="hidden"><a href="#" aria-label="Previous" class="navegador" data-funcion="anterior1"><i class="fa fa-angle-left"></i> </a>';									
									 										
											for($i=1;$i<=$totalPaginas;$i++):
											
												$paginador.='<li class="'.$activo.' '.$oculto.'"><a class="botonPagina" href="#" data-pagina="'.$i.'">'.$i.'</a></li>';
											
											$activo="";
											if($i==10)
											$oculto=" hidden";
											endfor;
										
											if($totalPaginas>1):
												$paginador.='<li id="siguiente1" name="siguiente1"><a href="#" aria-label="Next" class="navegador" data-funcion="siguiente1"><i class="fa fa-angle-right"></i> </a>';
											
											endif;
											 
											if($totalPaginas>10):
												$paginador.='<li id="siguiente2" name="siguiente2"><a href="#" aria-label="Next" class="navegador" data-funcion="siguiente2"><i class="fa fa-angle-double-right"></i> </a>';
											 
											endif;
									
										$paginador.='</li></ul>
								</nav></center></div>';
		return $paginador;
	}
?>