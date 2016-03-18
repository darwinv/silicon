<?php
include_once "clases/usuarios.php";
if(isset($_SESSION["id"])){
	$usua=new usuario($_SESSION["id"]);
	$correo=$usua->a_email;
	$nombre=$usua->getNombre();
	$habilitado="disabled";
}else{
	$habilitado="";
	$correo="";
	$nombre="";
}
?>
<div class="modal fade dia" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="dias">
	<div class="modal-dialog modal-sm" style="margin-top: 25%;">
			<div class="modal-content"
				style="padding-top: 20px; padding-bottom: 20px; padding-left: 20px; padding-right: 20px;">
				<div class="mar20 text-center icono-dias">
				<div id="sun" data-dia="sun" data-act="1" class="btn btn-default redes-dias marB5"><i id="isun" class="fa fa-check-circle " style="display: visible;"></i> Domingo</div> 			
				<br>			
				<div id="mon" data-dia="mon" data-act="1" class="btn btn-default redes-dias marB5"><i id="imon" class="fa fa-check-circle " style="display: visible;"></i> Lunes</div> 				
				<br>
				<div id="tue" data-dia="tue" data-act="1" class="btn btn-default redes-dias marB5"><i id="itue" class="fa fa-check-circle " style="display: visible;"></i> Martes</div> 			
				<br>
				<div id="wed" data-dia="wed" data-act="1" class="btn btn-default redes-dias marB5"><i id="iwed" class="fa fa-check-circle " style="display: visible;"></i> Miercoles</div> 			
				<br>
				<div id="thu" data-dia="thu" data-act="1" class="btn btn-default redes-dias marB5"><i id="ithu" class="fa fa-check-circle " style="display: visible;"></i> Jueves</div> 			
				<br>
				<div id="fri" data-dia="fri" data-act="1" class="btn btn-default redes-dias marB5"><i id="ifri" class="fa fa-check-circle " style="display: visible;"></i> Viernes</div> 			
				<br>
				<div id="sat" data-dia="sat" data-act="1" class="btn btn-default redes-dias marB5"><i id="isat" class="fa fa-check-circle " style="display: visible;"></i> Sabado</div> 			
			    </div>
			</div>
	</div>
</div> 


