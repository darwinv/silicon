<?php
include_once "clases/ventas.php";
include_once "clases/publicaciones.php";
include_once "clases/usuarios.php";
include_once "clases/fotos.php";
$compras=new ventas();
$foto=new fotos();
$listaCompras=$compras->listarPorUsuario(2); //Compras sin concretar
$listaCompras2=$compras->listarPorUsuario(4); //Compras concretadas
$total=$compras->contar(2);
$total2=$compras->contar(4);
$totalPaginas=ceil($total/25);
$totalPaginas2=ceil($total2/25);
$clasesP1="active";
$clasesP2="";
?>
<div class="row" id="principal">
	<!-- inicion del row principal  -->

	<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 maB10  " >
		<!-- inicio contenido  -->

		<div class=" contenedor">
			<!-- inicio contenido conte1-1 -->

			<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10   ">
				<!-- inicio titulo y p  -->

				<h4 class=" marL20 marR20 t20 negro" style="padding:10px;"><span class="marL10">Mis compras</span></h4>
				<center>
					<hr class='ancho95'>
				</center>
				<br>

				<ul class="nav nav-tabs marL30 marR30 t14 " >
					<li role="presentation" class="<?php echo $clasesP1;?> pesta-compras" >
						<a class="grisO pointer">Sin Concretar</a>
					</li>
					<li role="presentation" class="<?php echo $clasesP2;?> pesta-compras">
						<a class="grisO pointer">Concretadas</a>
					</li>
				</ul>
			</div>
			<div class='col-sm-12 col-md-5 col-lg-4 marB10 '>
				<form action="" method="GET"
				class="navbar-form navbar-left  marT15 marL30 " role="search">
				<div class="input-group" style="">
					<span class="input-group-btn">
						<button class="btn-header btn-default-header" style="border: #ccc 1px solid; border-right:transparent;"
							>
							<span class="glyphicon glyphicon-search"></span>
						</button>
					</span> <input style="margin-left: -10px; border: #ccc 1px solid; border-left:1px solid #FFF;  "
						 type="text" class="form-control-header " placeholder="Buscar" id="txtBusqueda" name="txtBusqueda">						 
				</div>
				<div id="busqueda" name="busqueda" class="hidden  pad10  " style="   width: 308px; background: #FAFAFA;" data-usuario=''>Publicaciones:</div>
			</form>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 marB10 marT15" >
				<div class=" btn-group marL30 ">
					<button type="button" class="btn btn-default">
						Filtrar
					</button>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a class="pointer">Mas compras</a>
						</li>
						<li>
							<a class="pointer">Menos compras </a>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10">
				<div class="marL30 marR20" style="background: #F2F2F2;">
					<table width="100%" class="alto50" border="0" cellspacing="0" cellpadding="0" >
						<tr>
							<td  width="75%"  align="right"><span class="marR10">compras 1 - <?php if($total<=25){ echo "$total de <b> $total"; }else{ echo "25 de <b>$total"; }?></span></td>
							<td   width="15%"  align="right" height="40px;" >
							<select id="filtro" class="form-control  input-sm " style="width:auto; margin-right:20px;">
								<option value="desc" >Mas Recientes</option>
								<option value="asc" >Menos Recientes </option>
							</select></td>
						</tr>
					</table>
				</div>
			</div>
			<div class='row  marB10 marT10 marL50 marR30'>
				<div id="noresultados" name="noresultados" class="container center-block col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden">	
					<br>
					<br>
					<div class='alert alert-warning2  text-center' role='alert'  >                                        	
	              		<span class="t16  "><i class="fa fa-info-circle"></i> No se encontraron publicaciones.</span>
	         		</div>
	         		<br>
	         	</div>  
	       
			<div id="sin-concretar" name="sin-concretar" class="">	        
	        <?php
	        if($listaCompras):
				foreach ($listaCompras as $l => $valor):
					$usua=new usuario($valor["vendedor"]);
					$compra=new ventas($valor["id"]);
					$publi=new publicaciones($valor["publicaciones_id"]);
					$statusPago=$compra->getStatusPago();
					switch($statusPago){
						case "Pago pendiente":
							$claseColor="amarillo-apdp";
							break;
						case "Pago incompleto":
							$claseColor="naranja-apdp";
							break;
						case "Pago verificado":
							$claseColor="verde-apdp";
							break;
						case "Pago rechazado":
							$claseColor="rojo-apdp";
							break;	
						default:
							$claseColor="";
							break;											
					}
					$maximo=is_null($valor["maximo"])?$valor["cantidad"]:$valor["maximo"];
					if($maximo<$valor["cantidad"]){
						$statusEnvio="Envio en camino";
						$claseColor2="naranja-apdp";
					}else{
						$statusEnvio="Envio pendiente";
						$claseColor2="rojo-apdp";
					}
//					$statusEnvio=$maximo>0?"Envio pendiente":"Envio en curso";
//					$statusEnvio=$compra->getStatusEnvio();
				?>
				<div id="compra<?php echo $valor["id"];?>">
					<div class='col-xs-12 col-sm-12 col-md-1 col-lg-1  '>
							<div class='marco-foto-publicaciones  point ' style='width: 65px; height: 65px;' > 
							<a href="detalle.php?id=<?php echo $publi->id;?>"><img src='<?php echo $publi->getFotoPrincipal();?>' width='100%' height='100%;' 
							style='border: 1px solid #ccc;' class='img img-responsive center-block imagen' data-id='#'> </div>
					</div>
					<div class='col-xs-12 col-sm-12 col-md-3 col-lg-5 vin-blue t14  '>
						<div style="margin-left: 3%;">
						<span class='detalle.php'> <a href='detalle.php?id=<?php echo $compra->publicaciones_id;?>'> <span id='#'><?php echo $valor["titulo"];?></span></a></span>
						<br>
						<span class='red t14' id='#'>Bs <?php echo $valor["monto"];?> </span>  <span class='t12 opacity' id='#'> x <?php echo $valor["cantidad"];?> und</span>
						</div>
					</div>
					<div class='col-xs-12 col-sm-12 col-md-3 col-lg-4 vin-blue t14  '>					
						<div class="t12 pad5 " style="background: #FAFAFA">	
						 <span><a class="vinculopagos pointer" data-toggle="modal" data-target="#pagos-ven" id="pago<?php echo $valor["id"];?>" name="pago<?php echo $valor["id"];?>"><i class="fa fa-credit-card <?php echo $claseColor;?>"></i> <span><?php echo $statusPago;?></span></a></span> 
						<br>
						 <span ><a class="vinculoenvios pointer" id="envio<?php echo $valor["id"];?>" name="envio<?php echo $valor["id"];?>" data-maximo="<?php echo $maximo;?>"> <i class="fa fa-truck <?php echo $claseColor2;?>"></i> <span><?php echo $statusEnvio;?></span></a></span> 
						<br>
						 <span ></span><i class="fa fa-clock-o"></i> <span><?php echo $compra->getTiempoCompra();?> en espera</span>
						<br>
						 <span><i class="fa fa-exclamation-triangle"></i> Reclamo abierto</span>
						</div>
					</div>
					<div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 text-right  t12 '>
						<div class='btn-group '>
							<a href="detalle-ventas.php?id=<?php echo $valor["id"];?>"<button class="btn2 btn-default marB5">Ver detalle</button></a>
							<button class="btn2 btn-default marB5 vinculopagos" data-toggle="modal" data-target="#informar-pago" data-id="<?php echo $valor["id"];?>">Informar pago</button> 
						</div>
					</div>
									
					<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10'>
						<center><hr class='center-block'></center>
					</div>
				</div>
				<?php
					endforeach;
				endif;
				?>  		
			</div>
			<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10' id="paginacion" name="paginacion">
				<nav class='text-center'>
				  <ul class='pagination'><li class="hidden">
				      <a class="pointer" aria-label='Previous'>
				        <span aria-hidden='true'>&laquo;</span>
				      </a>
				    </li>
				    <?php
				    	$claseInicio="active";
				    	for($i=1;$i<=$totalPaginas;$i++):							
							?>
								<li class="<?php echo $claseInicio;?>"><a class="botonPaginacompras pointer" data-pagina="<?php echo $i;?>"><?php echo $i;?></a></li>
							<?php
							$claseInicio="";
						endfor;
						if($totalPaginas>10):
							?>				
								<li>
							      <a class="pointer" aria-label='Next'>
							        <span aria-hidden='true'>&raquo;</span>
							      </a>
							    </li>
							 <?php
						endif;
						?>
				  </ul>
				</nav>
			</div>			
				<!-- FIN del detalle del listado -->
			<div id="concretadas" name="concretadas" class="hidden">
	        <?php
	        if($listaCompras2):
				foreach ($listaCompras2 as $l => $valor):
					$usua=new usuario($valor["usuarios_id"]);
					$compra=new comprascompras($valor["id"]);
					$publi=new publicaciones($valor["publicaciones_id"]);
					$statusPago=$compra->getStatusPago();
					$maximo=is_null($valor["maximo"])?$valor["cantidad"]:$valor["maximo"];
					if($maximo==0){
						$statusEnvio="Enviado";
					}elseif($maximo<$valor["cantidad"]){
						$statusEnvio="Envio en camino";
					}else{
						$statusEnvio="Envio pendiente";
					}
//					$statusEnvio=$maximo>0?"Envio pendiente":"Envio en curso";
//					$statusEnvio=$compra->getStatusEnvio();
				?>	
				<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 vin-blue t14  '>
					 <span id='#' class="negro t14"><?php echo $usua->getNombre();?></span>
					<br>
					<span class=''><a href="perfil.php?id=<?php echo $usua->id;?>"><?php echo $usua->a_seudonimo;?></a></span>
					<br>
					<span class=" grisC t12"><?php echo $usua->a_email;?></span>
					<br>
					<span class="t12"><?php echo $usua->u_telefono;?></span>
				</div>
				<div class='col-xs-12 col-sm-12 col-md-1 col-lg-1  '>
						<div class='marco-foto-publicaciones  point ' style='width: 65px; height: 65px;' > 
						<a href="detalle.php?id=<?php echo $publi->id;?>"><img src='<?php echo $publi->getFotoPrincipal();?>' width='100%' height='100%;' 
						style='border: 1px solid #ccc;' class='img img-responsive center-block imagen' data-id='#'> </div>
				</div>
				<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 vin-blue t14  '>
					<div style="margin-left: 3%;">
					<span class='detalle.php'> <a href='detalle.php?id=<?php echo $compra->publicaciones_id;?>'> <span id='#'><?php echo $valor["titulo"];?></span></a></span>
					<br>
					<span class='red t14' id='#'>Bs <?php echo $valor["monto"];?> </span>  <span class='t12 opacity' id='#'> x <?php echo $valor["cantidad"];?> und</span>
					</div>
			</div> 
				<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 vin-blue t14  '>					
					<div class="t12 pad5 " style="background: #FAFAFA">	
					 <span><a class="vinculopagos pointer" data-toggle="modal" data-target="#pagos-ven2" id="pago<?php echo $valor["id"];?>" name="pago<?php echo $valor["id"];?>"><i class="fa fa-credit-card verde-apdp"></i> <span><?php echo $statusPago;?></span></a></span> 
					<br>
					 <span ><a class="vinculoenvios pointer" id="envio<?php echo $valor["id"];?>" name="envio<?php echo $valor["id"];?>" data-maximo="<?php echo $maximo;?>"> <i class="fa fa-truck verde-apdp"></i> <span><?php echo $statusEnvio;?></span></a></span> 
					<br>
					 <span ></span><i class="fa fa-clock-o"></i> <span>despachado en <?php echo $compra->getTiempoCompra(2);?> </span>
					<br>
					 <span><i class="fa fa-exclamation-triangle"></i> Reclamo abierto</span>
					</div>
				</div>
				<div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 text-center t12 '>
					<div class='btn-group pull-right marR10'>				
							<button class="btn2 btn-default">Ver detalle</button> 
							<div class="dropdown pull-right">
  							<button class="btn2 btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
   							<i class="fa fa-cog"></i>
  							</button>
  								<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							    <li><a class="vinculocomentario pointer" data-toggle="modal" data-target="#comentario" id="comen<?php echo $valor["id"];?>" name="comen<?php echo $valor["id"];?>" data-nota="<?php echo $valor["nota"];?>">Agregar comentario</a></li>
 								</ul>
						</div>						
						</div>
				</div>		
				<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10'>
					<center><hr class=' center-block'></center></div>
				<?php
					endforeach;
				endif;
				?>
			</div>
			<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10 hidden' id="paginacion2" name="paginacion2">
				<nav class='text-center'>
				  <ul class='pagination'><li class="hidden">
				      <a class="pointer" aria-label='Previous'>
				        <span aria-hidden='true'>&laquo;</span>
				      </a>
				    </li>
				    <?php
				    	$claseInicio="active";
				    	for($i=1;$i<=$totalPaginas2;$i++):							
							?>
								<li class="<?php echo $claseInicio;?>"><a class="botonPaginacompras pointer" data-pagina="<?php echo $i;?>"><?php echo $i;?></a></li>
							<?php
							$claseInicio="";
						endfor;
						if($totalPaginas>10):
							?>				
								<li>
							      <a class="pointer" aria-label='Next'>
							        <span aria-hidden='true'>&raquo;</span>
							      </a>
							    </li>
							 <?php
						endif;
						?>
				  </ul>
				</nav>
			</div>			
 </div>
		</div>
		<!-- fin contenido conte1-1 -->
</div>
<!-- fin de row principal  -->

