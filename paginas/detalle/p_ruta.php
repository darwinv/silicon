<?php
include_once "clases/clasificados.php";
include_once "clases/publicaciones.php";
//$publicacion=new publicaciones($_GET["id"]);
 //$publicacion=new publicaciones(28);
$clasificado=new clasificados($publicacion->clasificados_id);
?>
<div class="col-xs-12">
	<p class="t14 vin-blue text-right   pad10 mar0  "> 
                <span class="pull-left"> 
                    <!-- <span class="hidden-xs"> <a href="#" style="color: #000;">Inicio</a> > <a href="#"><?php echo $clasificado->getAdress();?></a> </span> -->
                         <span class="hidden-xs"> <a href="index.php" style="color: #000;">Inicio</a> ><?php echo $clasificado->getAdressWithLinks();?> </span>
                </span>
                <span class="opacity">Publicacion # <?php echo $publicacion->id;?></span> <a href="#">Denunciar </a></p>
</div>