<?php
	require_once "../../../config/core.php";
	include_once "../../../clases/ventas.php";
	$venta=new ventas($_POST["id"]);
	$maximo=$venta->getCantFaltante();
	$listaPagos=$venta->getEnvios();
	if($listaPagos):
		?>
		<div class=" col-xs-12 col-sm-2 col-md-2 col-lg-2 text-center">
              <span>Fecha</span>
              <hr>
              <br class="hidden-xs ">
              <br>                
        </div>
        <div class=" col-xs-12 col-sm-2 col-md-2 col-lg-2 text-center">
              <br class="hidden-md hidden-lg hidden-sm">
              <span>Cantidad</span>
              <hr>
              <br class="hidden-xs ">
              <br>
        </div>
        <div class=" col-xs-12 col-sm-3 col-md-3 col-lg-3  text-center">
              <br class="hidden-md hidden-lg hidden-sm">
              <span>Agencia</span>
              <hr>
              <br class="hidden-xs ">
              <br>                   		
        </div>                    	
        <div class=" col-xs-12 col-sm-3 col-md-3 col-lg-3 text-center">
              <br class="hidden-md hidden-lg hidden-sm">
              <span>Nro. de guia</span>
              <hr>
              <br class="hidden-xs ">
              <br>
        </div>
        
        <div class=" col-xs-12 col-sm-2 col-md-2 col-lg-2 text-center">
              <br class="hidden-md hidden-lg hidden-sm">
              <span>Ver detalle</span>
              <hr>
              <br class="hidden-xs ">
              <br>
        </div>  
		<?php
		foreach($listaPagos as $l=>$valor):
		?>
                    	<div class=" col-xs-12 col-sm-2 col-md-2 col-lg-2 text-center">
                    		<span class="grisC"><?php echo $valor["fecha"];?></span>
                    		<br>                
                    	</div>
                    	<div class=" col-xs-12 col-sm-2 col-md-2 col-lg-2  text-center">
                    		<span class="grisC"><?php echo $valor["cantidad"];?></span> 
                    		<br>                   		
                    	</div>                    	
                    	<div class=" col-xs-12 col-sm-2 col-md-3 col-lg-3 text-center">
                    		<span class="grisC"><?php echo $valor["nombre"];?></span>
                    		<br>
                    	</div>
                    	<div class=" col-xs-12 col-sm-2 col-md-3 col-lg-3 text-center">
                    		<span class="grisC"><?php echo $valor["nro_guia"];?></span>
                    		<br>
                    	</div>
                    	<div class=" col-xs-12 col-sm-2 col-md-2 col-lg-2 text-center">
                    		<span class="grisC"><a>Ver</a></span>
                    		<br>
                    	</div>                   	
						
                    	<div class="col-xs-12 marT10">
	                   		<hr>
	                   		<br class="">
                   		</div>
               
         <?php
		endforeach;
else:
	echo "No hay envios";
endif;
?>

