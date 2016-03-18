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
			if($callback=$htw->generateOAuth('http://apreciodepana.com/fcn/f_manager/c_add_tw.php?state='.$login)){
				$hsc = new Handler_NewSocialConnection();
				$hsc->startTwitterFlow(true,$callback['oauth_token'],$callback['oauth_token_secret']);
				header('location:'.$callback['url']);
			}else{
				echo "<script type='text/javascript'>if(window.opener){window.opener.ad_twa_cb({e:4,n:'',sn:'',i:''});}window.close();</script>";
			}
		}else{
				echo "<script type='text/javascript'>if(window.opener){window.opener.ad_twa_cb({e:4,n:'',sn:'',i:''});}window.close();</script>";
		}
	}catch(Exception $e){
		echo "<script type='text/javascript'>if(window.opener){window.opener.{$fcn};}window.close();</script>";
	}
?>