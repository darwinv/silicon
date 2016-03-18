<?php
	require_once "../../../config/core.php";
	include_once "../../../clases/ventas.php";
	
	$venta=new ventas($_POST["id"]);
	$listaPagos=$venta->getPagos();
	if($listaPagos):
		?>
		<div class=" col-xs-12 col-sm-2 col-md-2 col-lg-2 text-center">
              <span>Fecha</span>
              <hr>
              <br class="hidden-xs ">
              <br>                
        </div>
        <div class=" col-xs-12 col-sm-2 col-md-2 col-lg-2  text-center">
              <br class="hidden-md hidden-lg hidden-sm">
              <span>Forma de pago</span>
              <hr>
              <br class="hidden-xs ">
              <br>                   		
        </div>                    	
        <div class=" col-xs-12 col-sm-2 col-md-2 col-lg-2 text-center">
              <br class="hidden-md hidden-lg hidden-sm">
              <span>Banco</span>
              <hr>
              <br class="hidden-xs ">
              <br>
        </div>
        <div class=" col-xs-12 col-sm-2 col-md-2 col-lg-2 text-center">
              <br class="hidden-md hidden-lg hidden-sm">
              <span>Monto</span>
              <hr>
              <br class="hidden-xs ">
              <br>
        </div>
        <div class=" col-xs-12 col-sm-2 col-md-2 col-lg-2 text-center">
              <br class="hidden-md hidden-lg hidden-sm">
              <span>Referencia</span>
              <hr>
              <br class="hidden-xs ">
              <br>
        </div>  
        <div class=" col-xs-12 col-sm-2 col-md-2 col-lg-2 text-center">
              <br class="hidden-md hidden-lg hidden-sm">
              <span>Status</span>
              <hr>
              <br class="hidden-xs ">
              <br>
        </div>
		<?php
		foreach($listaPagos as $l=>$valor):
		//fa fa-clock-o naranja-apdp
		//fa fa-thumbs-o-up verde-apdp
		//fa fa-remove rojo-apdp
			?>			
                    	<div class=" col-xs-12 col-sm-2 col-md-2 col-lg-2 text-center">
                    		<span class="grisC"><?php echo $valor["fecha"];?></span>
                    		<br>                
                    	</div>
                    	<div class=" col-xs-12 col-sm-2 col-md-2 col-lg-2  text-center">
                    		<span class="grisC"><?php echo $valor["fp"];?></span> 
                    		<br>                   		
                    	</div>                    	
                    	<div class=" col-xs-12 col-sm-2 col-md-2 col-lg-2 text-center">
                    		<span class="grisC"><?php echo $valor["nombre"];?></span>
                    		<br>
                    	</div>
                    	<div class=" col-xs-12 col-sm-2 col-md-2 col-lg-2 text-center">
                    		<span class="grisC"><?php echo $valor["monto"];?></span>
                    		<br>
                    	</div>
                    	<div class=" col-xs-12 col-sm-2 col-md-2 col-lg-2 text-center">
                    		<span class="grisC"><?php echo $valor["referencia"];?></span>
                    		<br>
                    	</div>                   	
                    	<div class=" col-xs-12 col-sm-2 col-md-2 col-lg-2 text-center">
                    		<br class="hidden-md hidden-lg hidden-sm">
                    		<div class="btn-group " style="margin-top: -5px;">
							  <button type="button" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up verde-apdp" ></i><span >Verificado</span></button>
							  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    <span class="caret"></span>
							    <span class="sr-only">Toggle Dropdown</span>
							  </button>
							</div>
						<br>
                    	</div>
                    	<div class="col-xs-12">
	                   		<hr>
	                   		<br class="">
                   		</div>
               
         <?php
		endforeach;
else:
	echo "klakldklaskldklaskldkl";
endif;
?>