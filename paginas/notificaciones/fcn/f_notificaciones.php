<?php
	require '../../../config/core.php';
	include_once "../../../clases/usuarios.php";
	include_once "../../../clases/publicaciones.php";
	switch($_POST["method"]){
		case "get_Notificaciones":
			getNotificaciones();
			break;		
	}
	function getNotificaciones(){
		if (! isset ( $_SESSION )) {
			session_start ();
		}
		 $usr = new usuario();
		 if($_SESSION['id_rol']=='1' || $_SESSION['id_rol']=='2')
			$id_user_noti=null;
		else 
			$id_user_noti=$_SESSION["id"];
		
		 $alerts = $usr -> getAllNotificaciones($id_user_noti, $_POST['pagina']);
		 
		if(TRUE):	
			$notificaciones='';
			
			foreach ($alerts as $a => $val) {
			
			$fecha = $val["fecha"];
			$tipo = $val["tipo"];
			$id_pana = $val["pana"];
			$id_pub = $val["pub"];
			$id_pre = $val["pregunta"];
			$pub = new publicaciones($id_pub);
			$segundos = strtotime('now')-strtotime($fecha);
			$tiempo = $pub -> getTiempo($segundos);
			
			if($tipo==1){//Pregunta
				$foto = $pub -> getFotoPrincipal();
				$title= $pub -> tituloFormateado();
				$id   = 1;
				$tema = "Te Preguntaron";
				$link = "pre_pub";
			}
			if($tipo==2){//Repuesta
				$foto = $pub -> getFotoPrincipal();
				$title= $pub -> tituloFormateado();
				$id   = 2;
				$tema = "Te Respondieron";
				$link = "resp_pub";
			}
			if($tipo==3){//Panas
				$foto = $usr -> buscarFotoUsuario($id_pana);
				$id   = $id_pana;
				$title= $usr -> getPana($id_pana);
				$tema = "Ahora te sigue";	
				$link = "ver-noti-seguidor";
			}
			if($tipo==4){//Publicacion
				$foto = $pub -> getFotoPrincipal();
				$title= $pub -> tituloFormateado();
				$tema = "Nueva Publicacion";
				$id   = $id_pub;
				$link = "detalle";
			}
			
			$img_noti=$foto;
			$usuario_class=''; //definir para mostrar el modal o redireccionar a la tienda			
			$usuario_name=$title;
			$accion_noti=$tema;
			$time_noti=$tiempo;

				
			$notificaciones.=	'<div class="col-xs-12 notificaciones pointer '.$link.'" data-id_pub="'.$id_pub.'" data-id="'.$id.'" >
					<div class="row">
						<div class="col-xs-3 col-sm-4 col-md-2 col-lg-2 text-center">							
								<img id="img-perfil" src="'.$img_noti.'" class="img foto-max-80   foto-perfil " data-id="1268"   >							
						</div>
						<div class="col-xs-9 col-sm-6 col-md-10 col-lg-10">
							<div>
								<span class=" vin-blue t14"><b>'.$usuario_name.'</b></span>
								'.$accion_noti.'
							</div>
							<div>
								<span class="t12 grisO "><i class="glyphicon glyphicon-time t14  opacity"></i>'.$time_noti.'</span>
							</div>
						</div>
					</div>
				</div>';
 
			}
		endif;		
		 
		echo json_encode ( array('notificaciones'=> $notificaciones));
					 
	}