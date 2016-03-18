<?php
	require_once('../../clases/manager/autoload.php');
	use OneAManager\Handler_Twitter;
	use OneAManager\Handler_NewSocialConnection;
	
	$login=$_GET['state']?$_GET['state']:0;
	switch($login){
		case 0:
			$fcn="rg_twa_cb({e:4,n:'',sn:'',i:''})";
			break;
		case 1:
			$fcn="lg_twa_cb(4)";
			break;
		case 2:
			$fcn="ap_twa_cb({e:4,n:'',sn:'',i:''})";
			break;
	}
	error_log("Log is $login");
	try{
		if($htw=new Handler_Twitter()){
			if($callback=$htw->generateOAuth('http://apreciodepana.com/fcn/f_manager/c_add_tw_alt.php?state='.$login)){
				$hsc = new Handler_NewSocialConnection();
				$hsc->startTwitterFlow(true,$callback['oauth_token'],$callback['oauth_token_secret']);
				header('location:'.$callback['url']); exit();
			}else{
				header("location:http://apreciodepana.com/redes.php?tipo=1&add_tw=4"); exit();
			}
		}else{
			header("location:http://apreciodepana.com/redes.php?tipo=1&add_tw=4"); exit();
		}
	}catch(Exception $e){
		header("location:http://apreciodepana.com/redes.php?tipo=1&add_tw=4"); exit();
	}
?>