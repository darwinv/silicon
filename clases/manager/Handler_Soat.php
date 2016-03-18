<?php

namespace OneAManager;

class Handler_Soat
{
	var $apiKey = 's5Qm5Y31tz34eD230EBryqWrPE5xeoehV1Ox2txygMZ78yTj2UfQr3bfXdKDXIV9';
	
	public function __construct(){
	
	}
	
	public function userUrls($fields){
		$data = $this->cURL('http://api.1so.at/usr_url',$fields);
		return isset($data['e']) ? $data : false ;
	}
	
	public function encode($fields){
		$data = $this->cURL('http://api.1so.at/encode',$fields);
		return isset($data['s']) ? $data['s'] : false ;
	}
	
	public function decode($url){
		$data = $this->cURL('http://api.1so.at/decode',$fields);
		return isset($data['longUrl']) ? $data['longUrl'] : '' ;
	}
	
	private function cURL($url,$fields){
		$fields['k']=$this->apiKey;
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_POST, true );
		$fields_string="";
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.urlencode($value).'&'; }
		$fields_string=rtrim($fields_string, '&');
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $fields_string );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		$json = curl_exec($ch);
		curl_close($ch);
		return json_decode($json,true);
	}
}
?>