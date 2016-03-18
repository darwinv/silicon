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
			
			switch($valor["status_pago"]){
				case "1":
					$titulo1="Pendiente";
					$titulo2="Verificar";
					$titulo3="Rechazar";
					$texto1="Pendiente";
					$clases1="fa fa-clock-o naranja-apdp";
					$texto2="Verificado";
					$clases2="fa fa-thumbs-o-up verde-apdp";
					$texto3="Rechazado";
					$clases3="fa fa-remove rojo-apdp";					
					break;					
				case "2":
					$titulo1="Verificado";
					$titulo2="Pendiente";
					$titulo3="Rechazar";				
					$texto1="Verificado";
					$clases1="fa fa-thumbs-o-up verde-apdp";
					$texto2="Pendiente";
					$clases2="fa fa-clock-o naranja-apdp";
					$texto3="Rechazado";
					$clases3="fa fa-remove rojo-apdp";									
					break;
				case "3":
					$titulo1="Rechazar";
					$titulo2="Pendiente";
					$titulo3="Verificar";					
					$texto1="Rechazado";
					$clases1="fa fa-remove rojo-apdp";
					$texto2="Pendiente";
					$clases2="fa fa-clock-o naranja-apdp";
					$texto3="Verificado";
					$clases3="fa fa-thumbs-o-up verde-apdp";				
					break;
			}
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
							  <button type="button" class="btn btn-default btn-xs boton-status" data-indice="1" data-texto="<?php echo $texto1;?>" data-id="<?php echo $valor["id"];?>"><i class="<?php echo $clases1;?>" id="iconoa<?php echo $valor["id"];?>"></i><span id="primero<?php echo $valor["id"];?>" name="primero<?php echo $valor["id"];?>"><?php echo $titulo1;?></span></button>
							  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    <span class="caret"></span>
							    <span class="sr-only">Toggle Dropdown</span>
							  </button>
							  
							  <ul class="dropdown-menu" >
							    <li class="boton-status" data-indice="2" data-texto="<?php echo $texto2;?>" data-id="<?php echo $valor["id"];?>"><a href="#"><i class="<?php echo $clases2;?>" id="iconob<?php echo $valor["id"];?>"></i> <span id="segundo<?php echo $valor["id"];?>" name="segundo<?php echo $valor["id"];?>"><?php echo $titulo2;?></span></a></li>
							    <li class="boton-status" data-indice="3" data-texto="<?php echo $texto3;?>" data-id="<?php echo $valor["id"];?>"><a href="#"><i class="<?php echo $clases3;?>" id="iconoc<?php echo $valor["id"];?>"></i> <span id="tercero<?php echo $valor["id"];?>" name="tercero<?php echo $valor["id"];?>"><?php echo $titulo3;?></a></li>
							  </ul>
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
	echo "No hay pagos";
endif;
?>