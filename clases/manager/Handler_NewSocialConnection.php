<?php
namespace OneAmanager;

class Handler_NewSocialConnection
{

	private $prefix="OneAManager_";

	public function __construct(){
		session_start();
	}
	
	public function startTwitterFlow($aggresive=true,$oauth_token,$oauth_token_secret){
		if($aggresive) $this->clearFlow();
		$_SESSION["{$this->prefix}aggression"] = $aggresive;
		$_SESSION["{$this->prefix}token"] = $oauth_token;
		$_SESSION["{$this->prefix}token_secret"] = $oauth_token_secret;
	}
	
	private function formSessionBody($params=array()){
		foreach($params as $key=>$value)
			$_SESSION["{$this->prefix}{$key}"] = $value;
	}
	
	public function clearFlow(){
		foreach($_SESSION as $key=>$value){
			if (strpos($key,$this->prefix) !== false) {
				unset($_SESSION[$key]);
			}
		}
	}
	
	public function getTwitterFlowRequestToken(){
		return array(
			"oauth_token" => $_SESSION["{$this->prefix}token"],
			"oauth_token_secret" => $_SESSION["{$this->prefix}token_secret"]
		);
	}
	
	public function createFlowProfile($params=array(),$aggression=null){
		if($aggression===null)
			$aggression=$_SESSION["{$this->prefix}aggression"];
		if($aggression) $this->clearFlow();
		elseif($aggression===null)
			$aggression=false;
		$this->formSessionBody($params);
		$_SESSION["{$this->prefix}aggression"] = $aggression;
	}
	
	public function returnTableAndBody($id){
			
		//EN CASO DE QUE NO ESTE DEFINIDO LA VARIABLE PARA REDES SOCIALES
		if(isset($_SESSION["{$this->prefix}type"])){
			$type=$_SESSION["{$this->prefix}type"];
		}else{
			$type="default";
		}
		
		
		switch($type){
			case "tw_acc":
				$table="manager_tw_acc";
				$fields=array(
					"userid"=>$id,
					"user_id"=>$_SESSION["{$this->prefix}user_id"],
					"name"=>$_SESSION["{$this->prefix}name"],
					"screen_name"=>$_SESSION["{$this->prefix}screen_name"],
					"img"=>$_SESSION["{$this->prefix}img"],
					"timezone"=>$_SESSION["{$this->prefix}timezone"],
					"location"=>$_SESSION["{$this->prefix}location"],
					"token"=>$_SESSION["{$this->prefix}token"],
					"token_secret"=>$_SESSION["{$this->prefix}token_secret"],
					"expired"=>0,
					"last_update"=>time()
				);
				break;
			case "fb_acc":
				$table="manager_fb_acc";
				$fields=array(
					"userid"=>$id,
					"user_id"=>$_SESSION["{$this->prefix}user_id"],
					"first_name"=>$_SESSION["{$this->prefix}first_name"],
					"last_name"=>$_SESSION["{$this->prefix}last_name"],
					"email"=>$_SESSION["{$this->prefix}email"],
					"gender"=>$_SESSION["{$this->prefix}gender"],
					"location"=>$_SESSION["{$this->prefix}location"],
					"verified"=>$_SESSION["{$this->prefix}verified"],
					"access_token"=>$_SESSION["{$this->prefix}access_token"],
					"expired"=>0,
					"expires_at"=>$_SESSION["{$this->prefix}expires_at"],
					"timezone"=>$_SESSION["{$this->prefix}timezone"],
					"img"=>$_SESSION["{$this->prefix}img"],
					"last_update"=>time()
				);
				break;
			default:
				$this->clearFlow();
				return false;
				break;
		}
		if($_SESSION["{$this->prefix}aggression"]) $this->clearFlow();
		return array(
			"table" => $table,
			"fields" => $fields
		);
	}
	
}


?>