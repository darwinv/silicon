<?php
	##lEER JSON PARA CAPTURAR CONFIGURACION	
	if($dir_index=='public_html') {
		$datos_params = file_get_contents($domain_root.'config/parameter.json');
	}else if($_SERVER ['SERVER_NAME']=='localhost' || !filter_var($_SERVER ['SERVER_NAME'], FILTER_VALIDATE_IP) === false){
		$datos_params = file_get_contents($domain_root.$dir_index.'/config/parameter.json');
	}
	
	$json_params = json_decode($datos_params, true);
	
	##DEFINIMOS VARIABLES
	foreach($json_params as $campo=>$valor){
		define($campo, $valor);
	}