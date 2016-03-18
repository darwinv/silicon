<?php
require '../../../config/core.php';
include_once "../../../clases/usuarios.php";
include_once "../../../clases/publicaciones.php";
include_once "../../../clases/email.php";

switch($_POST["metodo"]){
	case "guardarRespuesta":
		guardarRespuesta();
		break;
	case "guardarPregunta":
		guardarPregunta();
		break;
	case "enviarRespuesta":
		sendRespuesta();
		break;
	case "enviarPregunta":
		sendPregunta();
		break;
	case "eliminarPregunta":
		eliminarPregunta();
		break;
}

function guardarRespuesta()
{
	//die();
	$publicacion = new publicaciones($_POST["pub_id"]);
	$inse = $publicacion->setPreguntas($_POST["respuesta"],$_POST["id"]);	
	$not = $publicacion->setNotificacion($_POST["pub_id"],$_POST["tipo"],$_POST["usr"],$inse);
}		

function guardarPregunta()
{
	$publicacion = new publicaciones($_POST["pub_id"]);
	$inse = $publicacion->setPreguntas($_POST["respuesta"]);	

	$not = $publicacion->setNotificacion($_POST["pub_id"],$_POST["tipo"],$_POST["usr"],$inse);

}	

function sendPregunta(){
		
	$destino = new usuario($_POST["usr_id"]);
	$correo=new email();
	
	$link_detalle=FULL_WEBPAGE.'/detalle.php?id='.$_POST["pub_id"];
	$link_pregunta=FULL_WEBPAGE.'/preguntas.php?tipo=1&publicacion='.$_POST["pub_id"];
	$links=array("detalle"=>$link_detalle,"pregunta"=>$link_pregunta);
	
	$correo->sendPregunta($destino-> a_email , $links,  $_POST['pregunta']);	
		/*
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
	*///echo json_encode(array("estado"=>"OK"));
}


function sendRespuesta(){
	$destino = new usuario($_POST["usr_id"]);
	$correo=new email();
	
	$link_detalle=FULL_WEBPAGE.'/detalle.php?id='.$_POST["pub_id"];
	$link_respuesta=FULL_WEBPAGE.'/preguntas.php?tipo=2&publicacion='.$_POST["pub_id"];
	
	$links=array("detalle"=>$link_detalle,"respuesta"=>$link_respuesta);
	
	$correo->sendRespuesta($destino-> a_email , $links,  $_POST['respuesta']);
	/*
		$cli = new usuario($_POST["usr_id"]);
		$poster = new usuario($_POST["id_poster"]);
		$publicacion = new publicaciones($_POST["pub_id"]);
		ini_set("sendmail_from",$poster->a_email);
		$email_to = "" . $cli-> a_email . "";

		$email_subject = "Apreciodepana.com "." -  ".$poster-> n_nombre." ".$poster->n_apellido." ha contestado tu pregunta!";
		$email_message = "Sobre la publicacion:  ".$publicacion -> titulo." \n\n ".$_POST['respuesta'];	
		
		$txt = '<!DOCTYPE html>
      <html lang="es"><body>
		<div style=" padding 20px; text-align:left; margin: 20px;">
		<div style="width:500px;background:#fff; color:#666; padding:20px; margin-left:30px; margin-right:30px;">
		<div style="text-align:left; padding-bottom:10px; border-bottom: 1px solid #CCC;"><img src="http://vogueseshop.com/galeria/img-site/logos/logo-header2.png"></div>
		<br>';	
		
		
		$txt .= " <div style='text-align:left; margin-left:10px; 	font-size: 18px; '>
		               <p><b>Te han respondido!</b></p>
		               <p>Te respondieron una pregunta sobre la siguiente publicaci&oacute;n</p>
		                <a style='text-decoration:none;'><p>$link_detalle</p><a>
		            </div>
		            <br>		
		            <div style='text-align:left; padding-bottom:10px; border-bottom: 1px solid #ccc;' >
		               <a href=$link_respuesta style='text-decoration:none;'>
		               <button style='background:#36A7E1;
		                  text-align:center;  color:#FFF; padding:10px; margin:10px; border: 1px solid #1e8dc6; cursor: pointer; font-size: 18px;'>Ver Respuesta</button>
		               </a> ";	
		
		$txt .= '<br></div><div style="font-size: 12px; text-align:left; margin-left:10px; color:#999;  margin-top:5px;">
			Vistete a la moda con la mejor tecnologia </div></div></div></body></html>';
		//$headers = 'From: Apreciodepana.com ' . "\r\n" . 'Reply-To: ' . "no-reply@apreciodepana.com" . "\r\n" . 'X-Mailer: PHP/' . phpversion ();
		$headers = 'From: Vogues Eshop <no-responder@vogueseshop.com> \r\n' . 'Reply-To: '  . "no-responder@vogueseshop.com" . "\r\n" . 'X-Mailer: PHP/' . phpversion ()." MIME-Version: 1.0\r\n"." Content-type: text/html; charset=UTF-8.";
		
		mail ( $email_to, 'vogueseshop.com', $txt, $headers );
		//echo json_encode(array("estado"=>"OK"));
		echo json_encode(array("correo a enviar"=>$cli-> a_email, "correo from"=>$poster->a_email,"header"=>$headers,"subject"=>$email_subject,"message"=>$email_message));		

	 * 
	 */
}


function eliminarPregunta(){
		$bd=new bd();
        $result=$bd->query("delete FROM preguntas_publicaciones WHERE id={$_POST["id"]}");		
}

?>