<?php
include_once 'manager/autoload.php';
include_once 'fotos.php';
include_once 'email.php';
use OneAManager\Handler_NewSocialConnection;

/**
 *
 */
class usuario extends bd {
	/* * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Attributes ---============ *
	 * * * * * * * * * * * * * * * * * * * * * * */
	//Usuario (u)
	protected $u_table = "usuarios";
	private $id = 0;
	private $u_direccion;
	private $u_telefono;
	private $u_descripcion;
	private $u_estados_id;
	private $u_facebook;
	private $u_twitter;
	private $u_website;	
	// Juridicos (j)
	protected $j_table = "usuarios_juridicos";
	private $j_razon_social;
	private $j_rif;
	private $j_tipo;
	private $j_categorias_juridicos_id;
	// Naturales (n)
	protected $n_table = "usuarios_naturales";
	private $n_identificacion;
	private $n_nombre;
	private $n_apellido;
	private $n_tipo;
	// Acceso (a)
	protected $a_table = "usuarios_accesos";
	private $a_seudonimo;
	private $a_email;
	private $a_password;
	private $a_nivel;
	private $a_id_rol;
	private $a_status_usuarios_id;
	// Status (s)
	protected $s_table = "usuariosxstatus"; //tabla parcialmente suspendida por normalizacion
	private $s_fecha;
	private $s_status_usuarios_id;	 
	protected $sf_table = "status_usuarios"; 
	private $sf_nombre;
	
	// Ultimos Ingresos (i)
	protected $i_table = "ultimos_accesos";
	private $i_fecha;
	private $i_ip;
	private $i_datos_cliente;
	
	//Resetear Clave
	protected $r_table="reset_clave";
	private $r_id_usuario;
	private $r_seudonimo;
	private $r_token;
	private $r_creado;

	/* * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Contructor ---============ *
	 * * * * * * * * * * * * * * * * * * * * * * */
	public function usuario($id = NULL) {
		parent::__construct();
		if ($id != NULL) {
			// Hago consulta;
			$this->buscarUsuario ( $id );
		}
	}
	/* * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Methods ---=========== *
	 * * * * * * * * * * * * * * * * * * * * */
	public function buscarUsuario($id) {
		// hace consulta y setea valores
		$this->id = $id;
		if(!$this->getdatosUsuarios()){			
			if(!$this->getdatosNatural()){				
				$this->getdatosJuridico();
			}
			$this->getdatosAcceso();
			$this->getdatosStatus();
		}else{
			return false;
		}
	}
	public function crearUsuario() {
		if (isset ( $this->n_identificacion ) xor isset ( $this->j_rif )) {
			if (isset ( $this->a_seudonimo )) {
								
				$result = $this->doInsert ( $this->u_table, $this->serializarDatos ( "u_" ) );
				if ($result == true) {
					$result = 0;
					$this->id = $this->lastInsertId ();
					$hnsc= new Handler_NewSocialConnection();
					if($red_social=$hnsc->returnTableAndBody($this->id)){
						if(!$this->doInsert($red_social['table'],$red_social['fields']))
							error_log('Error occurred:'.implode(":",$this->errorInfo()));
					}
					if (isset ( $this->n_identificacion )) {
						$result += $this->doInsert ( $this->n_table, $this->serializarDatos ( "n_", $this->u_table ) );
					} else {
						$result += $this->doInsert ( $this->j_table, $this->serializarDatos ( "j_", $this->u_table ) );
					}
						$result += $this->doInsert ( $this->a_table, $this->serializarDatos ( "a_", $this->u_table ) );
						$result += $this->doInsert ( $this->s_table, $this->serializarDatos ( "s_", $this->u_table ) );
					if ($result >= 3) {
						return true;
					} else {						 
						return false;
					}
				} else {				 
					return false;
				}
			} else {
				throw new Exception ( "Error Usuario 004: No se han definido datos de acceso" );
			}
		} else {
			throw new Exception ( "Error Usuario 003: No se han definido datos Juridicos o Naturales" );
		}
	}
	
	public function getAllPublishedWithinTimeFrame($uid,$sn,$frame,$timezone){
		$min = $timezone-($frame*60);
		
		$statement = $db->prepare("SELECT * FROM manager_stats WHERE userid=? AND (time BETWEEN ? AND ?) AND type=?");
		$statement->execute(array($uid,$min,$timezone,$sn));
		$rowCount=$statement->rowCount();
		$statement->closeCursor();
		return $rowCount;
	
	}
	
	public function tieneFacebook(){
		
		return $this->doSingleSelect("manager_fb_acc", " userid = ".$this->id);
	}
	
	public function tieneTwitter(){
		
		return $this->doSingleSelect("manager_tw_acc", " userid = ".$this->id);
	}
	
	public function tieneFanpage(){
		
		return $this->doSingleSelect("manager_fbp_acc", " userid = ".$this->id);
	}
	
	public function getLastPublishedTime($uid,$sn){
		
		$statement = $db->prepare("SELECT * FROM manager_stats WHERE userid=? AND social_network=? ORDER BY time DESC LIMIT 1");
		if($statement->execute(array($uid,$sn))){
			$fetch=$statement->fetchAll();
			return $fetch[0]["time"];
		}else{
			return false;
		}
	}
	
	public function listarUsuariosConPublicaciones($status=1){
		
		$time = strtotime("00:00",time());
		$consulta="select * from usuarios where id in (
			select usuarios_id from publicaciones WHERE (publicar_twitter=1 OR publicar_facebook=1 OR publicar_fanpage=1 OR publicar_grupo=1) AND id in(
			select publicaciones_id from publicacionesxstatus where status_publicaciones_id=$status and fecha_fin IS NULL) AND last_share<$time ORDER BY last_share ASC )";
		$result=$this->query($consulta);
		$devolver=array();
		if(!empty($result)){
			foreach($result as $r){
				$statement="SELECT a.*,b.condicion FROM publicaciones AS a
				LEFT JOIN condiciones_publicaciones as b ON a.condiciones_publicaciones_id = b.id
				RIGHT JOIN publicacionesxstatus as c ON a.id=c.publicaciones_id AND c.status_publicaciones_id=1 AND c.fecha_fin IS NULL
				WHERE a.usuarios_id={$r["id"]} AND (a.stock>0 OR a.stock IS NULL) AND (a.publicar_twitter=1 OR a.publicar_facebook=1 OR a.publicar_fanpage=1 OR a.publicar_grupo=1)
				ORDER BY a.last_share ASC
				LIMIT 1";
				if($res=$this->query($statement)){
					$publicaciones=$res;
				}else $publicaciones=array();
				$statement="SELECT COUNT(*) as total FROM publicaciones AS a
				LEFT JOIN condiciones_publicaciones as b ON a.condiciones_publicaciones_id = b.id
				RIGHT JOIN publicacionesxstatus as c ON a.id=c.publicaciones_id AND c.status_publicaciones_id=1 AND c.fecha_fin IS NULL
				WHERE a.usuarios_id={$r["id"]} AND (a.stock>0 OR a.stock IS NULL) AND (a.publicar_twitter=1 OR a.publicar_facebook=1 OR a.publicar_fanpage=1 OR a.publicar_grupo=1)
				ORDER BY a.last_share ASC";
				if($res=$this->query($statement)){
					$res=$res->fetchAll();
					$total=$res[0]['total'];
				}else $total=0;
				
				
				$devolver[]=array(
					"id"=>$r["id"],
					"publicaciones"=>$publicaciones,
					"total"=>$total
				);
		   }
		}
		return $devolver;
	}
	
	public function ingresoUsuarioPorID(){
		
		$foto = new fotos();
		$condicion = " usuarios_id = {$this->id}";
		$result = $this->doSingleSelect($this->a_table,$condicion);
		if(!empty($result)){
			session_start();
			$_SESSION["id"] = $result["usuarios_id"];
			$_SESSION["seudonimo"] = $result["seudonimo"];
			$_SESSION["nivel"] = $result["nivel"];
			$_SESSION["fotoperfil"] = $foto->buscarFotoUsuario($result["usuarios_id"]);
			$_SESSION["id_rol"] = $result["id_rol"];
			
			setcookie("c_id", $_SESSION["id"], time()+7776000);
			setcookie("c_seudonimo", $_SESSION["seudonimo"], time()+7776000);
			setcookie("c_nivel", $_SESSION["nivel"], time()+7776000);			
			setcookie("c_fotoperfil", $_SESSION["fotoperfil"], time()+7776000);
			setcookie("c_id_rol", $_SESSION["id_rol"], time()+7776000); 
			return true;
		}else{
			return false;
		}
	}
	
	public function ingresoUsuario($login, $password, $url){
		
		$foto = new fotos();
		if(isset($login["seudonimo"])){
			$condicion = "seudonimo = '{$login["seudonimo"]}'";
		}else{
			$condicion = "email = '{$login["email"]}'";
		}
		$hash = hash ( "sha256", $password );
		
		if($url=="admin"){
			$condicion = "$condicion AND password = '$hash' AND id_rol <= 2 ";
		}
		else{
			$condicion = "$condicion AND password = '$hash'";
		}
		
		$result = $this->doSingleSelect($this->a_table,$condicion);
		if(!empty($result)){
			if($result["bandera"]==0){ 
				if($result["status_usuarios_id"]=='1'){ 
					if (session_status() == PHP_SESSION_NONE){ 
						session_start();
					}
					$_SESSION["id"] = $result["usuarios_id"];
					$_SESSION["seudonimo"] = $result["seudonimo"];
					$_SESSION["nivel"] = $result["nivel"];
					$_SESSION["fotoperfil"] = $foto->buscarFotoUsuario($result["usuarios_id"]);
					$_SESSION["id_rol"] = $result["id_rol"];  
					setcookie("c_id", $result["usuarios_id"], time()+7776000,'/');
					setcookie("c_seudonimo", $result["seudonimo"], time()+7776000,'/');
					setcookie("c_nivel", $result["nivel"], time()+7776000,'/');
					setcookie("c_fotoperfil", $foto->buscarFotoUsuario($result["usuarios_id"]), time()+7776000,'/'); 
					setcookie("c_id_rol", $result["id_rol"], time()+7776000,'/');
					return array(1,$result["usuarios_id"]);
				}else{
									
					return array(4,$result["usuarios_id"]);
				}
			}else{				
				return array(3,$result["usuarios_id"]);
			}
		}else{
			return array(2,"");
		}
	}


	/********Funciones de restauracion de Claves**********/
	public function recuperaClave($login){
		
		$correo=new email();
		if(isset($login["seudonimo"])){
			$condicion = "seudonimo = '{$login["seudonimo"]}'";
		}else{
			$condicion = "email = '{$login["email"]}'";
		}
		$result = $this->doSingleSelect($this->a_table,$condicion);
		if(!empty($result)){
			//if($result["status_usuarios_id"]=='1'){ 
			$email=$result["email"];
			 $link=$this->generaLinkTemporal($result["usuarios_id"],$result["seudonimo"]);
			 if($link){
				$correo->sendRecuperarPass($email,$link);
				return array(1,$result["usuarios_id"]);	
			}
			 else{
			 	return array(2,"");
			 }
			
			//}
		}
		else{
			return array(2,"");
		}		
	}

	function generaLinkTemporal($iduser,$seudonimo){
		
		$cadena=$seudonimo.rand(1,99999).date('Y-m-d');
		$token=sha1($cadena);
		$this->r_id_usuario=$iduser;
		$this->r_seudonimo=$seudonimo;
		$this->r_token=$token;
		$this->r_creado=date("Y-m-d H:i:s",time());	
		$result=$this->doInsert($this->r_table, $this->serializarDatos ( "r_" ));	
		if($result==true){
     		 // Se devuelve el link que se enviara al usuario
	      		$enlace = $_SERVER["SERVER_NAME"].'/restablecer.php?idusuario='.$iduser.'&token='.$token;
		      return $enlace;
	   	}
   		else {
   			return FALSE;
   		}     
	}			
	function comprobarToken($token){
		
		$result=$this->doSingleSelect($this->r_table,"token = '$token'");
		if($result)
			return $result;
		else 
			return false;
	}	

public function setNewPassword($user,$clave){	
				
		$clave = hash ( "sha256", $clave );		
				
		$actualizar=array( 'password'=>$clave);		
		//$parametro=$actualizar["password"]=$clave;		
		$condicion="usuarios_id=$user";		
		$result=$this->doUpdate($this->a_table, $actualizar, $condicion);		
		return $result;		
	}		
/*public function ingresoUsuarioAdmin($login, $password){
		
		$foto = new fotos();
		if(isset($login["seudonimo"])){
			$condicion = "seudonimo = '{$login["seudonimo"]}'";
		}else{
			$condicion = "email = '{$login["email"]}'";
		}
		$hash = hash ( "sha256", $password );
		$condicion = "$condicion AND password = '$hash' AND id_rol <= 2";
		$result = $this->doSingleSelect($this->a_table,$condicion);
		
	 if(!empty($result)){
			if($result["bandera"]==0){
				session_start();
				$_SESSION["id"] = $result["usuarios_id"];
				$_SESSION["seudonimo"] = $result["seudonimo"];
				$_SESSION["nivel"] = $result["nivel"];
				$_SESSION["fotoperfil"] = $foto->buscarFotoUsuario($result["usuarios_id"]);
				setcookie("c_id", $result["usuarios_id"], time()+7776000,'/');
				setcookie("c_seudonimo", $result["seudonimo"], time()+7776000,'/');
				setcookie("c_nivel", $result["nivel"], time()+7776000,'/');
				setcookie("c_fotoperfil", $foto->buscarFotoUsuario($result["usuarios_id"]), time()+7776000,'/');
				//return array(1,$result["usuarios_id"]);
				return array(1,$result);
			}else{
				//return array(3,$result["usuarios_id"]);
				return array(3,$result);
			}
		}else{
			return array(2,"");
		}
	}
 
	/* * * * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Private Methods ---=========== *
	 * * * * * * * * * * * * * * * * * * * * * * * * */
	private function serializarDatos($prefix = "u_", $foreign_table = false) {
		$reflection = new ReflectionObject ( $this );
		$properties = $reflection->getProperties ( ReflectionProperty::IS_PRIVATE );
		foreach ( $properties as $property ) {
			$name = $property->getName ();
			if (substr ( $name, 0, 2 ) == $prefix || $name == "id") {
				if ($name == "id") {
					if ($foreign_table != false) {
						if (is_array ( $foreign_table )) {
							foreach ( $foreign_table as $f_table ) {
								$params ["{$f_table}_id"] = $this->$name;
							}
						} else {
							$params ["{$foreign_table}_id"] = $this->$name;
						}
					} else {
						$params ["id"] = $this->$name;
					}
				} else {
					$params [substr ( $name, strpos ( $name, "_" ) + 1 )] = $this->$name;
				}
			}
		}
		// var_dump ( $params );
		return $params;
	}
	private function nuevoUsuario() {
		foreach ( get_class_vars ( get_class ( $this ) ) as $name => $default ) {
			$this->$name = $default;
		}
	}
	/* * * * * * * * * * * * * * * * * * *
	 * =========--- Getters ---========= *
	 * * * * * * * * * * * * * * * * * * */
	public function getdatosUsuarios(){
		
		$result = $this->doSingleSelect($this->u_table,"id = {$this->id}");
		if($result){
			$this->datosUsuario($result["direccion"], $result["telefono"], $result["descripcion"], $result["estados_id"], $result["facebook"], $result["twitter"],$result["website"]);
			$this->id = $result["id"];
		}else {
			return false;
		}
	}
	public function getdatosJuridico(){
		
		$result = $this->doSingleSelect($this->j_table, "usuarios_id = {$this->id}");
		if($result){
			$this->datosJuridico($result["rif"], $result["razon_social"], $result["tipo"], $result["categorias_juridicos_id"]);
		}else{
			return false;
		}
	}
	public function getdatosNatural(){
		
		$result = $this->doSingleSelect($this->n_table,"usuarios_id = {$this->id}");
		if($result){
			$this->datosNatural($result["identificacion"], $result["nombre"], $result["apellido"], $result["tipo"]);
		}else{
			return false;
		}
	}
	public function getdatosAcceso(){
		
		$result = $this->doSingleSelect($this->a_table,"usuarios_id = {$this->id}");
		if($result){ 
			$this->datosAcceso($result["seudonimo"], $result["email"], $result["password"], $result["nivel"], $result["id_rol"], $result["status_usuarios_id"]); 
				
		}else{
			return false;
		}
	}
	public function getdatosStatus(){
		
		$result = $this->doSingleSelect($this->s_table,"usuarios_id = {$this->id}");
		if($result){
			$this->datosStatus($result["fecha"],$result["status_usuarios_id"]);
		}else{
			return false;
		}
	}
	public function __get($property) {
		if (property_exists ( $this, $property )) {
			return $this->$property;
		}
	}
	/* * * * * * * * * * * * * * * * * * *
	 * =========--- Setters ---========= *
	 * * * * * * * * * * * * * * * * * * */
	public function datosUsuario($direccion, $telefono, $descripcion, $estados_id, $facebook = NULL, $twitter = NULL, $website = NULL) {
		$this->nuevoUsuario ();
		$this->u_direccion = $direccion;
		$this->u_telefono = $telefono;
		$this->u_descripcion = $descripcion;
		$this->u_estados_id = $estados_id;
		$this->u_facebook = $facebook;
		$this->u_twitter = $twitter;
		$this->u_website = $website;
	}
	public function datosJuridico($rif, $razon_social, $tipo, $categorias_juridicos_id) {
		if (! isset ( $this->n_identificacion )) {
			$this->j_rif = $rif;
			$this->j_razon_social = $razon_social;
			$this->j_tipo = $tipo;
			$this->j_categorias_juridicos_id = $categorias_juridicos_id;
		} else {
			throw new Exception ( "Error Usuario 001: El usuario esta definido como natural." );
		}
	}
	public function datosNatural($identificacion, $nombre, $apellido, $tipo) {
		if (! isset ( $this->j_rif )) {
			$this->n_identificacion = $identificacion;
			$this->n_nombre = ucwords(strtolower($nombre));
			$this->n_apellido = ucwords(strtolower($apellido));
			$this->n_tipo = $tipo;
		} else {
			throw new Exception ( "Error Usuario 002: El usuario esta definido como juridico." );
		}
	}
	public function datosAcceso($seudonimo, $email, $password, $nivel=0, $id_rol, $status_usuarios_id) {
		$this->a_seudonimo = strtoupper($seudonimo);		
		$this->a_email = $email;
		$this->a_password = hash ( "sha256", $password );
		$this->a_nivel = $nivel;
		$this->a_id_rol = $id_rol;
		$this->a_status_usuarios_id = $status_usuarios_id;
	}
	public function datosStatus($fecha = NULL, $status_usuarios_id = NULL) {
		 
		if(!is_null($fecha)){
			$this->s_fecha = $fecha;
		}else{
			$this->s_fecha = date ( 'Y-m-d', time () );
		}
		if(!is_null($status_usuarios_id)){
			$this->s_status_usuarios_id = $status_usuarios_id;
		}else{
			$this->s_status_usuarios_id = 1;
		}
		
	}
	/*Se puede borrar*/
	public function __set($property, $value) {
		if (property_exists ( $this, $property )) {
			
			$this->doUpdate ( $this->table, array (
					$property => $value 
			) );
			$this->$property = $value;
		}
	}
	public function getEstado($formateado=NULL){
		
		$condicion="id={$this->u_estados_id}";
		$resultado=$this->doSingleSelect("estados",$condicion,"nombre");
		if(!empty($resultado)){
			if(is_null($formateado)){
				return  ($resultado["nombre"]);
			}else{
				return $resultado["nombre"];
			}
		}else{
			throw new Exception("No se encontro informaci�n del estado", 1);
			return false;
		}
	}
	public function getTiempo(){
				
		$condicion="usuarios_id={$this->id}";
		$resultado=$this->doSingleSelect("usuariosxstatus",$condicion,"fecha");				
		if(!empty($resultado)){
			$segundos=strtotime('now') - strtotime($resultado["fecha"]);
			$dias=intval($segundos/60/60/24);
			if($dias==0){
				$dias=1;
			}
			if($dias<30){
				if($dias==1){
				    return "<span class='t18'>" . $dias . "</span> dia";
				}else{
					return "<span class='t18'>" . $dias . "</span> dias ";
				}
			}else{
				$meses=round($dias / 30,0,PHP_ROUND_HALF_DOWN);
				if($meses<12){
					if($meses==1){
						return "<span class='t18'>" . $meses . "</span> mes ";
					}else{
						return "<span class='t18'>" . $meses . "</span> meses ";
					}
				}else{
					$agnos=round($meses / 12,0,PHP_ROUND_HALF_DOWN);
					if($agnos==1){
						return "<span class='t18'>" . $agnos . "</span> A�o ";
					}else{
						return "<span class='t18'>" . $agnos . " </span> A�os ";
					}
				}
			}
		}else{
			throw new Exception("No se encontro desde cuando publica este usuario", 1);
			return false;		
		}
		/*
		
		$condicion="id=$this->usuarios_id";
		$resultado=$this->doSingleSelect("usuariosxstatus",$condicion,"fecha");
		if(!empty($resultado)){
						
			return "2 meses";
		}else{
			throw new Exception("No se encontro desde cuando publica este usuario", 1);
			return false;
		}
		 */		 
	}
    public function getNombre($formateado=0,$longitud=17){
		if(is_null($this->j_rif)){
			if(strpos($this->n_nombre," ")){
				$nombre=substr($this->n_nombre,0,strpos($this->n_nombre," "));
			}else{
				$nombre=$this->n_nombre;
			}
			if(strpos($this->n_apellido," ")){
				$nombre=$nombre . " " . substr($this->n_apellido,0,strpos($this->n_apellido," "));
			}else{
				$nombre=$nombre . " " . $this->n_apellido;
			}			
		}else{	
			$nombre=$this->j_razon_social;						
		}
		if($formateado==0){
    		return $nombre;
		}else{
			if(strlen($nombre)>$longitud){
				return substr($nombre,0,$longitud) . "...";
			}else{
				return $nombre;
			}
		}
    }
	public function getPublicaciones($status=1,$pagina=1,$id=NULL, $order=NULL){
		if(empty($order)){
			$order='id desc';
		}		
		
		$limite = ($pagina-1) * 25;
		$consulta="select * from publicaciones where id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=$status and fecha_fin is null) ";
		
		$consulta.=" order by $order";
		
		$consulta.=" LIMIT 25 OFFSET $limite";
		$result=$this->query($consulta); 
		if(!empty($result)){
			return $result;
		}else{
			return false;
		}
	}
	
	public function getAllPublicaciones($status=1,$id=NULL, $id_publicacion=NULL){		
		
		$consulta="select * from publicaciones where 
		id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=$status and fecha_fin is null) ";
				
		if(!is_null($id_publicacion)){
			$consulta.=" and id='$id_publicacion'";
		}
		
		$consulta.=" order by id desc";  
		$result=$this->query($consulta);
		if(!empty($result)){
			return $result;
		}else{
			return false;
		}
	}
	
	public function getCantPreguntasActivas($id = NULL){
		
		$preguntas=array();
        $result=$this->query("select count(*) as cant from preguntas_publicaciones where id not in (SELECT preguntas_publicaciones_id FROM preguntas_publicaciones 
        WHERE preguntas_publicaciones_id is not null) and preguntas_publicaciones_id is NULL and publicaciones_id in
         (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL )  ");	
        foreach ($result as $r){
        	$preguntas[]=array("cant"=>$r["cant"]);
  		}
		return $preguntas;
	}
	
	public function getCantCompras($id = NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		
		$preguntas=array();
        $result=$this->query("select count(*) as cant from preguntas_publicaciones where usuarios_id=$id and publicaciones_id in
         (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL ) 
         and publicaciones_id not in ( SELECT id FROM publicaciones WHERE usuarios_id = $id ) ");	
        foreach ($result as $r){
        	$preguntas[]=array("cant"=>$r["cant"]);
  		}
		return $preguntas;
	}
	

	public function getCantRespuestas($id = NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		
		$preguntas=array();
        $result=$this->query("select count(*) as cant from preguntas_publicaciones where id in (select preguntas_publicaciones_id 
        from notificaciones where leida=0 and usuarios_id=$id) and preguntas_publicaciones_id is not null ");
       			
        foreach ($result as $r){
        	$preguntas[]=array("cant"=>$r["cant"]);
  		}
		return $preguntas;
	}
	
	public function getCantNotificacionPregunta($id = NULL){
		/*if(is_null($id)){
			$id=$this->id;
		}*/
		$preguntas=array();
		
		$listado= " select preguntas_publicaciones_id from notificaciones where leida=0 ";
		if(!empty($id)){
			##si envia filtro de ID es porque es usuario publico
			$listado.= " and usuarios_id=$id";
		}
		
		$consulta=" select count(*) as cant from preguntas_publicaciones where id in ($listado) and preguntas_publicaciones_id is null ";
        $result=$this->query($consulta);	
        foreach ($result as $r){
        	$preguntas[]=array("cant"=>$r["cant"]);
  		}
		return $preguntas;
	}
	
	public function getCantidadPub($status=1,$id=NULL){
		
		$consulta="select count(*) as tota from publicaciones where id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=$status and fecha_fin is null)";
		
		if(!empty($id)){
			$consulta.=" and usuarios_id=$id";
		}
		$consulta.=" order by id desc";
		$result=$this->query($consulta);
		foreach ($result as $key => $valor) {
			//if($valor["tota"]<10){
			//	return "0" . $valor["tota"];
			//}else{
				return $valor["tota"];
			//}
		}
	}
		
	public function getPublicacionesFavoritas($orden=NULL,$pagina=NULL){
		
		$orden=is_null($orden)?"":" order by $orden";
//		$palabra=is_null($palabra)?"":" and titulo like '%{$_POST["palabra"]}%'";
		$consulta="select * from publicaciones where 
		visitas_publicaciones_id in (select visitas_publicaciones_id 
		from publicaciones_favoritos 
		where usuarios_id=$this->id) and id in 
		(select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL) $orden";
		if(!is_null($pagina)){
			$limite=($pagina - 1) * 25;
			$consulta.=" LIMIT 25 OFFSET $limite";
		}
		$result=$this->query($consulta);
		if(!empty($result)){
			return $result;
		}else{
			return false;
		}
	}
	public function getPreguntasCompra($id_usr, $id_publicacion=NULL){
		

		$consulta="select * from publicaciones where 
		id in (select publicaciones_id
		from preguntas_publicaciones 
		where usuarios_id=$id_usr and preguntas_publicaciones_id is null) and id in 
		(select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";
		
		 
		if(!is_null($id_publicacion)){
			$consulta.=" and id='$id_publicacion'";
		}
		
		$consulta.=" order by id desc";  
		
		$result=$this->query($consulta);
		if(!empty($result)){
			return $result;
		}else{
			return false;
		}
		
	}
	
	public function getAllDatosUsr($id_usr){
		
		$consulta="select * from publicaciones where 
		id in (select publicaciones_id
		from preguntas_publicaciones 
		where usuarios_id=$id_usr and preguntas_publicaciones_id is null) and id in 
		(select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";
		$result=$this->query($consulta);
		if(!empty($result)){
			return $result;
		}else{
			return false;
		}
	}
	
	public function updateNotificaciones($id=NULL,$tipos_notificaciones_id=null){
		$actualizar=array("leida"=>1);
		$condicion="leida=0";
		if(!empty($id)){
			$condicion.=" and usuarios_id=$id";
		}
		if(!empty($tipos_notificaciones_id)){
			$condicion.=" and tipos_notificaciones_id=$tipos_notificaciones_id";
		}
		var_dump($this->doUpdate("notificaciones",$actualizar,$condicion));
	}
	public function countFavoritos($id=NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		
		$result=$this->query("select count(favoritos_id) as totaF from usuarios_favoritos where favoritos_id=$id");
		$row=$result->fetch();
		return $row["totaF"];
	}
	
	public function getUsuarios($status=NULL, $orden=NULL,$pagina=NULL){
		
		
		
		$consulta="select usuarios.id, usuarios_accesos.seudonimo, usuarios_naturales.nombre, usuarios_naturales.apellido, roles.rol 
		from usuarios inner join usuarios_accesos ON usuarios.id=usuarios_accesos.usuarios_id 
		inner join usuarios_naturales ON usuarios.id=usuarios_naturales.usuarios_id 
		inner join roles ON usuarios_accesos.id_rol=roles.id
		where (usuarios_accesos.id_rol=1 or usuarios_accesos.id_rol=2) ";		
		
		if(!empty($status)){
			$consulta.=" and usuarios_accesos.status_usuarios_id =  '$status' ";
		}
		if(!empty($orden)){
			$orden=is_null($orden)?"":" order by $orden";
			$consulta.=" $orden";
		}
		if(!empty($pagina)){
			$inicio=is_null($pagina)?"":($pagina - 1) * 25;
			$consulta.=" limit 25 OFFSET $inicio"; 
		}
	
		$result=$this->query($consulta);
		if(!empty($result)){
			return $result;
		}else{
			return false;
		}
	}	
	public function updateStatus($usuarios_id=NULL, $status_usuarios_id=NULL){		 
		
		$actualizar=array( 'status_usuarios_id'=>$status_usuarios_id);
		$condicion="usuarios_id=$usuarios_id";
		$result=$this->doUpdate($this->a_table,$actualizar,$condicion);
		return $result;
	}
	
	public function updateUserGeneral($usuarios_id, $seudonimo=NULL, $email=NULL,$password=NULL,$id_rol=NULL){
				
		$actualizar=array( 'seudonimo'=>$seudonimo,'email'=>$email,'id_rol'=>$id_rol);
		//si cambiaron la contrase�a	
		if(!empty($password)){
			$password = hash ( "sha256", $password );
			$actualizar['password']=$password;
		}		
		$condicion="usuarios_id=$usuarios_id";
		$result=$this->doUpdate($this->a_table,$actualizar,$condicion);
		return $result;
	}
	
	public function getCantPanas($id = NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		
		$panas=array();
        $result=$this->query("select count(*) as cant from notificaciones where leida=0 and usuarios_id=$id and tipos_notificaciones_id=3 ");	
        foreach ($result as $r){
        	$panas[]=array("cant"=>$r["cant"]);
  		}
		return $panas;
	}
	public function getCantNotiPublicaciones($id = NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		
		$panas=array();
        $result=$this->query("select count(*) as cant from notificaciones where leida=0 and usuarios_id=$id and tipos_notificaciones_id=4 ");	
        foreach ($result as $r){
        	$panas[]=array("cant"=>$r["cant"]);
  		}
		return $panas;
	}
	public function getAllNotificaciones($id=null, $pagina=null, $tipos_notificaciones_id=null){
		/*if(is_null($id)){
			$id=$this->id;
		}*/
		$consulta = "select fecha, tipos_notificaciones_id tipo, usuarios_id usr, publicaciones_id pub, preguntas_publicaciones_id pregunta, 
		pana_id pana from notificaciones where 1 ";
		
		if(!empty($id)){
			##si envia filtro de ID es porque es usuario
			$consulta.= " and usuarios_id=$id  ";
		}
		if(!empty($tipos_notificaciones_id)){
			##si envia filtro de ID es porque es usuario
			$consulta.= " and tipos_notificaciones_id='$tipos_notificaciones_id' ";	
		}
		$consulta .= " ORDER BY `notificaciones`.`fecha`  DESC ";
		
		
		if(empty($pagina)){
			$consulta.= " limit 25";
		}else{
			$start=($pagina - 1) * 25;
			$consulta.=" LIMIT 25 OFFSET $start";
		}
		$result =$this->query($consulta);
		return $result;
	}
	public function getAllNotificacionesAdmin(){ 
			
			$consulta = "select fecha, tipos_notificaciones_id tipo, usuarios_id usr, publicaciones_id pub, preguntas_publicaciones_id pregunta, 
			pana_id pana from notificaciones where tipos_notificaciones_id='1' ORDER BY `notificaciones`.`fecha`  DESC limit 25";
			if(empty($pagina)){
				$consulta.= " limit 25";
			}else{
				$start=($pagina - 1) * 25;
				$consulta.=" LIMIT 25 OFFSET $start";
			}
			$result =$this->query($consulta);
			return $result;	
	}
	
}