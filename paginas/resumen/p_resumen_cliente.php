<?php
	$usr = new usuario();
	$usr_publicaciones = $usr -> getPreguntasCompra($_SESSION["id"]);
	$cant_preg_usr = $usr -> getCantCompras($_SESSION["id"]);
	$cantidad_preguntas=$cant_preg_usr[0]["cant"];
?>
<div class=" contenedor">
	
	<div class="row marL20 marR20 marB20">

			<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10   "><!-- inicio titulo   -->	
				<h4 class="  t20 negro pad10" ><span class="marL10">Resumen</span></h4>
				<center>
					<hr class='anchoC'>
				</center>
			</div><!-- Fin titulo -->
		
			 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 "><!-- Titulo de Productos -->
			 	<div class="pad10 pad-left-20  t18  " style="background: #F2F2F2;"> 
			 		<i class="fa fa-shopping-cart marL10"></i> Compras
			 	</div>
			 </div ><!-- Fin Titulo de Productos -->
			 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  ">
			 	<hr>
			 	<div class=" pad-left-20  t16"><span class="marL20"><span class="badge badge-publicar "><?php echo $usua->getCantidadPub(1,$_SESSION["id"]);?></span> <a href="#"><span class="marL10 " >Compras concretadas</span></span></a></div>
			 </div>
			 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  ">
			 	<hr>
			 	<div class=" pad-left-20  t16"><span class="marL20"><span class="badge badge-publicar "><?php echo $usua->getCantidadPub(2,$_SESSION["id"]);?></span> <a href="preguntas.php?tipo=2"><span class="marL10 " >Compras sin concretar</span></span></a></div>
			 </div>
			 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  ">
			 	<hr>
			 	<div class=" pad-left-20  t16"><span class="marL20"><span class="badge badge-publicar "><?php echo $usua->getCantidadPub(3,$_SESSION["id"]);?></span> <a href="#"><span class="marL10 " >Compras con reclamos</span></span></a></div>
			 	<hr>
			 </div>
			 
			 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10 "><!-- Espaciador-->
			 </div>
			  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 "><!-- Titulo de Productos -->
			 	<div class="pad10 pad-left-20  t18  " style="background: #F2F2F2;"> 
			 		<i class="fa fa-comment  marL10"></i> Preguntas
			 	</div>
			 </div ><!-- Fin Titulo de Productos -->
			 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  ">
			 	<hr>
			 	<div class="pad-left-20 t16"><span class="marL20"><span class="badge badge-publicar "><?php echo $cantidad_preguntas;?></span> <a href="preguntas.php?tipo=2"><span class="marL10 " >Sobre tus Compras</span></span></a></div>
			 </div>

		</div>
	
	</div >