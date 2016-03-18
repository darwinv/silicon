<?php
/**
 * Private License, redistribution of this software is not allowed
 * Copyright (c) 2015 1ASocialMedia C.A.
 */
 

namespace OneAManager;

require_once('tw/autoload.php');
use Abraham\TwitterOAuth\TwitterOAuth;

class Handler_Twitter{
	var $con;
	protected $CONSUMER_KEY="PsgewLxOFtHnk2gbY8K16vtBW";
	protected $CONSUMER_SECRET="1faYJnQUqovKKScN1cmOPsmNakz7XZ32XBhmJSBwQS771duLs9";
	protected $lastError;

	public function __construct($access_token=null, $access_token_secret=null){
		if(isset($access_token) && isset($access_token_secret)){
			$this->con=new TwitterOAuth($this->CONSUMER_KEY, $this->CONSUMER_SECRET,$access_token,$access_token_secret);
		}else{
			$this->con=new TwitterOAuth($this->CONSUMER_KEY, $this->CONSUMER_SECRET);}
		$this->con->setTimeouts(15, 50);
	}
	
	function getLastError(){
		return $this->lastError;
	}
	
	
	protected function errorHandle($error){
		if(is_numeric($error->errors[0]->code))
			$code = $error->errors[0]->code;
		else $code=0;
		Switch($code){
			case 0:
				//no se pudo capturar el error
				break;
			case 32:
				//No se puedo autenticar
				break;
			case 34:
				//404, no deberia suceder
				break;
			case 37:
				//Codigo no Autorizado
				break;
			case 64:
				//cuenta del usuario esta suspendida
				break;
			case 68:
				//irrelevante, api vieja
				break;
			case 88:
				//Limite Excedido
				break;
			case 89:
				//Access token expirado o invalido, hay un problema con el usuario
				break;
			case 92:
				//No hay conexion SSL
				break;
			case 130:
				//Error de Twitter, intentarlo m&aacute;s tarde
				break;
			case 131:
				//Error del servidor de twitter
				break;
			case 135:
				//Error de autenticaci&oacute;n relacionado con pais que utilicen oauth_timestamp
				break;
			case 161:
				//El usuari no puede seguir a nadie m&aacute;s
				break;
			case 179:
				//Se intendo acceder a un Tweet privado
				break;
			case 185:
				//No se puede postear m&aacute;s en el dia, bien sea porque el usuario ha publicado muchos tweets, o por el bot
				break;
			case 187:
				//Tweet duplicado, intentarlo con otro tweet
				break;
			case 215:
				//Autenticacion invalida
				break;
			case 220:
				//metodo invalido
				break;
			case 226:
				//Twitter se dio cuenta que el sistema era un bot
				break;
			case 231:
				//La cuenta del usuario debe generar una nueva contrase&ntilde;a y el sistema debe conseguir access tokens otra vez
				break;
			case 251:
				//Esta api ya no existe
				break;
			case 261:
				//Aplicacion suspendida
				break;
			case 271:
				//El usuario no se puede silenciar a si mismo
				break;
			case 272:
				//Error al silenciar un usuario
				break;
			case 327:
				//Status ya retweeteado
				break;
			case 429:
				//Demaciadas solicitudes
				break;
		}
		
		$this->lastError=$code;
		return false;
	}
	
	
	public function genericGet($api,$params){
		if(is_array($params))
			$request=$this->con->Get($api,$params);
		else
			$request=$this->con->Get($api);
		if($this->con->getLastHttpCode() == 200) return $request;
		else return $this->errorHandle($request);
	}
	
	public function genericPost($api,$params=array()){
		$request=$this->con->post($api,$params);
		if($this->con->getLastHttpCode() == 200) return $request;
		else return $this->errorHandle($request);
	}
	
	public function generateOAuth($callback){
		$request=$this->con->oauth('oauth/request_token', array('oauth_callback' => $callback));
		if ($this->con->getLastHttpCode() == 200) {
			$url = $this->con->url('oauth/authorize', array('oauth_token' => $request['oauth_token']));
			$return=Array("oauth_token"=>$request['oauth_token'],
							"oauth_token_secret"=>$request['oauth_token_secret'],
							"url"=>$url);
			return $return;
		} else {
			return $this->errorHandle($request);
		}
	}
	
	public function generateAccessToken($oauth_verifier){
		$request=$this->con->oauth('oauth/access_token', array('oauth_verifier' => $oauth_verifier));
		if ($this->con->getLastHttpCode() == 200) {
			return $request;
		}else{ 
			return $this->errorHandle($request);}
		
	}
	
	public function getTrend($where,$done){
		$request=$this->con->Get("trends/place",array("id"=>$where));
		if($this->con->getLastHttpCode() == 200){
			if($done==true){
				$count=count($request[0]->trends);
				$trend="";
				for($i=0;$i<$count;$i++){
					$trend.=$request[0]->trends[$i]->name.",";
				}
				$trend=rtrim($trend,",");
				return $trend;
			}else{	return $request;}
		}
		else return $this->errorHandle($request);
	}
	
	public function uploadFile($filePath){
		$request=$this->con->upload('media/upload', array('media' => $filePath));
		if($this->con->getLastHttpCode() == 200){
			return $request->media_id_string;
		}else{
			return $this->errorHandle($request);
		}
	}
	
	


}

?>