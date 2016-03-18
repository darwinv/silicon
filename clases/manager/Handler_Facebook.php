<?php

/**
 * Private License, redistribution of this software is not allowed
 * Copyright (c) 2015 1ASocialMedia C.A.
 */
namespace OneAManager;
require_once('fb/autoload.php');
use Facebook\Facebook;

class Handler_Facebook{
	const app_id='1525400224445821';
	const app_secret='a6844f79229d65d6813f9ace1951e7c8';
	const default_graph_version='v2.5';
	protected $con;
	protected $lastErrorCode;
	protected $lastErrorMes;

	public function __construct($ver=null){
	
		$this->con=new Facebook([
				  'app_id' => self::app_id,
				  'app_secret' => self::app_secret,
				  'default_graph_version' => $ver?$ver:self::default_graph_version]);
	}
	
	
	public function fileToUpload($path){
		return $this->con->fileToUpload($path);
	}
	
	public function getErrorMes(){
		return $this->lastErrorMes;
	}
	
	public function getErrorCode(){
		return $this->lastErrorCode;
	}
	
	protected function manageException($e){
		$this->lastErrorMes=$e->getMessage();
		$this->lastErrorCode=$e->getCode();
	}
	
	protected function base64_url_decode($input) {
		return base64_decode(strtr($input, '-_', '+/'));
	}
	
	
	public function parseSignedRequest($signed_request){
		list($encoded_sig,$payload)=explode('.',$signed_request,2); 
		$sig=$this->base64_url_decode($encoded_sig);
		$data=json_decode($this->base64_url_decode($payload), true);
		$expected_sig = hash_hmac('sha256', $payload, self::app_secret, $raw = true);
		if($sig !== $expected_sig){
			$this->lastErrorMes="Bad signed request";
			$this->lastErrorCode="777";
			return false;
		 }
		return $data;
	}
	
	protected function manageHelperError($helper){
		$this->lastErrorMes=$helper->getError()." Reason: ".$helper->getErrorReason()." Description: ".$helper->getErrorDescription()." Code: ".$helper->getErrorCode();
		$this->lastErrorCode=$helper->getErrorCode();
	}
	
	protected function getLLAT($oAuth2Client,$accessToken){
		try{
			return $oAuth2Client->getLongLivedAccessToken($accessToken);
		}catch (Facebook\Exceptions\FacebookSDKException $e) {
			$this->manageException($e);
			return false;
		}
	}
	
	protected function checkAC($helper){
		try {
			$accessToken = $helper->getAccessToken();
		}catch(Facebook\Exceptions\FacebookResponseException $e) {
			$this->manageException($e);
			return false;
		}catch(Facebook\Exceptions\FacebookSDKException $e){
			$this->manageException($e);
			return false;
		}
		
		if (!isset($accessToken)) {
			if ($helper->getError()) {
				$this->manageHelperError($helper);
				$this->lastErrorCode=667;
			}else{
				$this->lastErrorCode=666;
				$this->lastErrorMes="someone tried to do something mean to us";
			}
			return false;
		}
		return $accessToken;
	}
	
	public function post($endpoint, array $params = [],$access_token,$asGraph=null){
		try{
			$response = $this->con->post($endpoint, $params, $access_token);
		}catch(Facebook\Exceptions\FacebookResponseException $e) {
			$this->manageException($e);
			return false;
		}catch(Facebook\Exceptions\FacebookSDKException $e) {
			$this->manageException($e);
			return false;
		}
		return $response->getDecodedBody();
	}
	
	public function get($endpoint,$access_token,$asGraph=null){
		try {
		  $response = $this->con->get($endpoint, $access_token);
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			$this->manageException($e);
			return false;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			$this->manageException($e);
			return false;
		}
		if($asGraph){
			try{
				$return=$response->getGraphNode();
			}catch(Facebook\Exceptions\FacebookSDKException $e){
				$return=$response->getGraphEdge();
			}
			return $return;
		}else
			return $response->getDecodedBody();
	}
	
	public function delete($endpoint, array $params = [],$access_token,$asGraph=null){
		try{
			$response = $this->con->delete($endpoint, $params, $access_token);
		}catch(Facebook\Exceptions\FacebookResponseException $e) {
			$this->manageException($e);
			return false;
		}catch(Facebook\Exceptions\FacebookSDKException $e) {
			$this->manageException($e);
			return false;
		}
		return $response->getDecodedBody();
	}
	
	public function getPermissions($access_token){
		return $this->get("/me/permissions",$access_token)['data'];
	}
	
	public function revokePermissions($access_token,$perm){
		return $this->delete("/me/permissions/$perm",array(),$access_token);
	}
	
	public function validatePermissions($perms=array(),$required=array()){
		foreach($required as $req){
			$requiem=array('permission'=>$req,'status'=>'granted');
			if(array_search($requiem,$perms)===false){
				$this->lastErrorCode=665;
				$this->lastErrorMes="User denied a required permission ".$req;
				return false;
			}
		}
		return true;
	}
	
	
	public function validateScopes($scopes=array(),$perms=array()){
		foreach($perms as $perm){
			if(!in_array($perm,$scopes))
				return false;
		}
		return true;
	}
	
	public function manageACOA($accessToken,$oAuth2Client,$perms=array(),$user_id=null){
		if(!$accessToken || !$oAuth2Client)
			return false;
	
		if(!$accessToken->isLongLived()){
			if(!$accessToken=$this->getLLAT($oAuth2Client,$accessToken))
				return false;
		}
		
		$tokenMetadata = $oAuth2Client->debugToken($accessToken);
		$scopes=$tokenMetadata->getScopes();
		if(!$this->validateScopes($scopes,$perms)){
			$this->revokePermissions($accessToken->getValue(),"");
			$this->lastErrorCode=665;
			$this->lastErrorMes="User didn't gave us the required permissions";
			return array(
				"e"=>665,
				"user_id"=>$tokenMetadata->getField('user_id'),
				"access_token"=>$accessToken->getValue()
			);
		}
		
		if($user_id!=null){
			if($tokenMetadata->getField('user_id')!==$user_id){
				return array(
					"e"=>664,
					"user_id"=>$tokenMetadata->getField('user_id'),
					"access_token"=>$accessToken->getValue()
				);
				/*$this->lastErrorCode=664;
				$this->lastErrorMes="This isn't the user we are looking for";
				return false;*/
			}
		}
		//manage expiration
		try{
			$tokenMetadata->validateAppId(self::app_id);
		}catch(Facebook\Exceptions\FacebookSDKException $e){
			$this->manageException($e);
			return false;
		}
		return array(
			"user_id"=>$tokenMetadata->getField('user_id'),
			"expires_at"=>$tokenMetadata->getExpiresAt()->getTimestamp(),
			"access_token"=>$accessToken->getValue());
	}
	
	public function getLoginUrl($url,$perms=array(),$reasking=''){
		$helper=$this->con->getRedirectLoginHelper();
		return $helper->getLoginUrl($url,$perms,array('auth_type'=> $reasking ));
	}
	
	public function serverCallbackManager($perms=array()){
		$helper=$this->con->getRedirectLoginHelper();
		return $this->manageACOA($this->checkAC($helper),$this->con->getOAuth2Client(),$perms);
	}
	
	public function javascriptCallbackManager($perms=array()){
		$helper=$this->con->getJavaScriptHelper();
		return $this->manageACOA($this->checkAC($helper),$this->con->getOAuth2Client(),$perms);
	}
	
}

?>
