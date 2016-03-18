<?php
	require_once("../../clases/manager/autoload.php");
	require_once("../../clases/bd.php");
	use OneAManager\Handler_Twitter;
	use OneAManager\Handler_NewSocialConnection;
	
	$login=$_GET['state']?$_GET['state']:0;
	$hsc = new Handler_NewSocialConnection();
	$request_token = $hsc->getTwitterFlowRequestToken();
	$e=0;
	$d=false;
	$c=false;
	$i=false;
	if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
		$hsc->clearFlow();
		header("location:http://apreciodepana.com/redes.php?tipo=1&add_tw=4"); 
	}else{
		if($_REQUEST['denied']) header("location:http://apreciodepana.com/redes.php?tipo=1&add_tw=2"); 
		try{
			if($htw=new Handler_Twitter($request_token['oauth_token'], $request_token['oauth_token_secret'])){
				if($access_token=$htw->generateAccessToken($_REQUEST['oauth_verifier'])){
					$fields = array(
						"type" => "tw_acc",
						"token" => $access_token["oauth_token"],
						"token_secret" => $access_token["oauth_token_secret"],
						"screen_name" => $access_token["screen_name"],
						"user_id" => $access_token["user_id"],
					);
					$db = new bd();
					$table="manager_tw_acc";
					$condition=" user_id=".$access_token["user_id"];
					if($result=$db->doSingleSelect($table,$condition)){
						error_log($result);
						//cuenta pertenece a otro usuario
						header("location:http://apreciodepana.com/redes.php?tipo=1&add_tw=1"); 
					}else{
						//nueva cuenta
						$hsc->clearFlow();
						$userid=$_SESSION["id"];
						$table="manager_tw_acc";
						$condition=" userid=".$userid;
						if($result=$db->doSingleSelect($table,$condition)){
							$return=array("e"=>5);
						}else{
							if($htw=new Handler_Twitter($access_token['oauth_token'], $access_token['oauth_token_secret'])){
								if($credentials=$htw->genericGet("account/verify_credentials",array("include_entities"=>"false","skip_status"=>1))){
									$fields['userid']=$userid;
									$fields['img']=$credentials->profile_image_url;
									$fields['name']=$credentials->name;
									$fields['location']=$credentials->location?$credentials->location:"";
									$fields['timezone']=$credentials->utc_offset;
									unset($fields['type']);
									$table="manager_tw_acc";
									if($db->doInsert($table,$fields)){
										$hsc->clearFlow();
										header("location:http://apreciodepana.com/redes.php?tipo=1&add_tw=0"); 
									}else
										header("location:http://apreciodepana.com/redes.php?tipo=1&add_tw=6"); 
								}
							}else{ $hsc->clearFlow(); header("location:http://apreciodepana.com/redes.php?tipo=1&add_tw=4"); }
						}
					}
				}else{ $hsc->clearFlow(); header("location:http://apreciodepana.com/redes.php?tipo=1&add_tw=2"); }
			}else{ $hsc->clearFlow(); header("location: http://apreciodepana.com/redes.php?tipo=1&add_tw=4"); }
		}catch(Exception $e){
			$hsc->clearFlow();
			header("location:http://apreciodepana.com/redes.php?tipo=1&add_tw=4"); 
		}
	}
?>