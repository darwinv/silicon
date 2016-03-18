<?php $cant = $usua->getCantPreguntasActivas();
$compras = $usua->getCantCompras();  ?>
<div class=" contenedor">
	
	<div class="row marL20 marR20 marB20">

			<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10   "><!-- inicio titulo   -->	
				<h4 class="  t20 negro pad10" ><span class="marL10">Resumen</span></h4>
				<center>
					<hr class='anchoC'>
				</center>
			</div><!-- Fin titulo -->
		
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 "><!-- Titulo de Publicaciones -->
			 	<div class="pad10 pad-left-20  t18  " style="background: #F2F2F2;"> 
			 		<i class="fa fa-comment marL10"></i> Preguntas
			 	</div>
			 </div ><!-- Fin Titulo de Publicaciones -->
			 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  ">
			 	<hr>
			 	<div class=" pad-left-20  t16"><span class="marL20"><span class="badge badge-publicar "><?php echo $cant[0]["cant"];?></span> <a href="preguntas.php?tipo=1"><span class="marL10 " >Preguntas sin responder</span></span></a></div>
			 </div>
			 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  ">
			 	<hr>
			 	<div class=" pad-left-20  t16"><span class="marL20"><span class="badge badge-publicar "><?php echo $compras[0]["cant"];?></span> <a href="preguntas.php?tipo=2"><span class="marL10 " >Tus preguntas</span></span></a></div>
			 </div>

			 
			 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10  "><!-- Espaciador-->
			 </div>
			 
			 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10  "><!-- Espaciador-->
			 </div>
		
		
			 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 "><!-- Titulo de Publicaciones -->
			 	<div class="pad10 pad-left-20  t18  " style="background: #F2F2F2;"> 
			 		<i class="fa fa-tags marL10"></i> Publicaciones
			 	</div>
			 </div ><!-- Fin Titulo de Publicaciones -->
			 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  ">
			 	<hr>
			 	<div class=" pad-left-20  t16"><span class="marL20"><span class="badge badge-publicar "><?php echo $usua->getCantidadPub(1);?></span> <a href="ventas.php"><span class="marL10 " >Activa</span></span></a></div>
			 </div>
			 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  ">
			 	<hr>
			 	<div class=" pad-left-20  t16"><span class="marL20"><span class="badge badge-publicar "><?php echo $usua->getCantidadPub(2);?></span> <a href="ventas.php?tipo=2"><span class="marL10 " >Pausadas</span></span></a></div>
			 </div>
			 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  ">
			 	<hr>
			 	<div class=" pad-left-20  t16"><span class="marL20"><span class="badge badge-publicar "><?php echo $usua->getCantidadPub(3);?></span> <a href="ventas.php?tipo=3"><span class="marL10 " >Finalizadas</span></span></a></div>
			 	<hr>
			 </div>
			 
			 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10  "><!-- Espaciador-->
			 </div>
			 



			 
			 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10  "><!-- Espaciador-->
			 </div>
			 

		</div>
	
	</div >
	



