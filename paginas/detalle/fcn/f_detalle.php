<?php
require '../../../config/core.php';
include_once "../../../clases/usuarios.php";
include_once "../../../clases/publicaciones.php";
switch($_POST["metodo"]){
	case "actualizarFavoritos":
		actualizaFavoritos();
		break;
	case "guardarPregunta":
		guardaPregunta();
		break;
	case "enviarPregunta":
		sendPregunta();
		break;
}
function actualizaFavoritos(){
	$bd=new bd();
	session_start();
	$valores=array("usuarios_id"=>$_SESSION["id"],"visitas_publicaciones_id"=>$_POST["id"]);
	if($_POST["tipo"]==1){
		$result=$bd->doInsert("publicaciones_favoritos",$valores);
	}else{
		$result=$bd->query("delete from publicaciones_favoritos where usuarios_id={$_SESSION['id']} and visitas_publicaciones_id={$_POST['id']}");
	}
}
function guardaPregunta(){
	$publi=new publicaciones($_POST["id"]);
	$inse = $publi->setPreguntas( (htmlspecialchars(strip_tags($_POST["pregunta"]))));	
	$not = $publi->setNotificacion($_POST["id"],$_POST["tipo"],$_POST["usr"],$inse);
	$preguntas=$publi->getPreguntasPublicacion();
	?>
	<div style="background: #FFF; margin-top: -10px; width: 140px;" class="marR20 text-center pull-right"> <span>Ultimas Preguntas</span></div>
	<div class="alert alert-info hidden" style="padding: 4px; margin: 5px; margin-left: 20px; margin-right:10px;">hola</div>
	<?php
		foreach ($preguntas as $key => $valor):
		$respuesta=$publi->getRespuestaPregunta($valor["id"])[0];
		$usuario=new usuario($valor["usuario"]); 
		$claseR=$respuesta==""?"hidden":"";
	?>							
		<p class="t14 marL20 marR20" style="border-bottom: #ccc 1px dashed;">
	  <br>
		<i class="fa fa-comment blueO-apdp marL10"></i> <span class="marL5"><?php echo  ($valor["pregunta"]); ?></span>
		<br>
		<i class="fa fa-comments-o marL20 blueC-apdp <?php echo $claseR;?>" >			
		</i> <span class="marL5"><?php echo  ($publi->getRespuestaPregunta($valor["id"])[0]); ?> </span> <span class="opacity t11"> - <?php echo $publi->getRespuestaPregunta($valor["id"])[1]; ?> </span>
		<br>	
		<br>						
		</p>
		<?php
		endforeach;
		?>
		<br><br>
		<?php
	}

function sendPregunta(){
		$cli = new usuario($_POST["usr_id"]);
		$poster = new usuario($_POST["id_poster"]);
		$publicacion = new publicaciones($_POST["pub_id"]);
		ini_set("sendmail_from",$poster->a_email);
		$email_to = "" . $cli-> a_email . "";

		$email_subject = "Apreciodepana.com "." -  ".$poster-> n_nombre." ".$poster->n_apellido." tiene una pregunta!";
		$email_message = "Sobre la publicacion:  ".$publicacion -> titulo." \n\n ".$_POST['pregunta'];	
	
		$headers = 'From: Apreciodepana.com ' . "\r\n" . 'Reply-To: '  . "no-reply@apreciodepana.com" . "\r\n" . 'X-Mailer: PHP/' . phpversion ();
		mail ( $email_to, $email_subject, $email_message, $headers );
		echo json_encode(array("correo a enviar"=>$cli-> a_email, "correo from"=>$poster->a_email,"header"=>$headers,"subject"=>$email_subject,"message"=>$email_message));				
}


?>