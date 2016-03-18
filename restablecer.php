<?php require 'config/core.php';
if (!isset ( $_GET ["token"] )) {
	header ( "Location: index.php" );
}
		include "fcn/incluir-css-js.php";		
		include 'clases/usuarios.php';
		
		$token = $_GET['token'];
		$idusuario = $_GET['idusuario'];
		
		$user=new usuario();
		$result=$user->comprobarToken($token);
		
		if($result){
			 if( $result['id_usuario'] == $idusuario ){ ?>
			 	
			 
		
	
<!DOCTYPE html>
<html lang="es">	
	<body class="body-index">	
<div class="container center-container login-admin" style="width:500px; padding:30px; margin-top: 5%">
	<form id="restablecer-password" data-user="<?php echo $idusuario ?>" name="restablecer-password" action="fcn/f_usuarios.php" method="POST">				 			
 		<div style="background: #FFF; border: solid 1px #ccc; border-radius: 5px; -webkit-box-shadow: 0px 0px 28px -2px rgba(204,12,NaN,0); -moz-box-shadow: 0px 0px 28px -2px rgba(204,12,NaN,0); box-shadow: 0px 0px 28px -2px rgba(204,12,NaN,0); padding: 20px;">			 			
 			<div class="center" style=""> 
 				<img class="center-block" src="galeria/img-site/logos/logo-modal2.png" height="150px" width="auto" />
 			</div>					
			<div class="text-center"><h2>Restablecer Contrase&ntilde;a</h2>
			</div>
			<br>						
			<div class="form-group">
				<input type="password" placeholder=" Ingrese Nueva Contrase&#241;a" id="rec_clave" name="rec_clave" class="form-input marB10">
			</div>																								
			<div class="form-group"><input type="password"
				placeholder="Confirme Contrase&#241;a" id="rec_clave2" name="rec_clave2" class="form-input marB10" >
			</div>								
			<button id="rec-clave-submit" name="rec-clave-submit" type="submit" class="btn2 btn-primary2 btn-group-justified">Restablecer</button>
			<br>											
		</div>		
	</form>
</div>
<script type="text/javascript" src="js/restablecer.js"></script>
</body>
</html>
<?php 
}else {
	header ( "Location: index.php" );}
		}
 else {
 	header ( "Location: index.php" );
 } 