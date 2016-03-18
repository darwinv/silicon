<?php
	require_once("../../clases/manager/autoload.php");
	require_once("../../clases/bd.php");
	use OneAManager\Handler_Twitter;
	use OneAManager\Handler_NewSocialConnection;

	function makeBody($e=0,$c="",$d="",$i="",$b="false",$l=""){
		$c="'$c'";
		$d="'$d'";
		$i="'$i'";
		$l="'$l'";
		
		$login=$_GET['state']?$_GET['state']:0;
		switch($login){
			case 0:
				$fun="rg_twa_cb({e:$e,n:$c,sn:$d,i:$i,d:$b,l:$l})";
				break;
			case 1:
				$fun="lg_twa_cb($e)";
				break;
			case 2:
				$fun="ap_twa_cb({e:$e,n:$c,sn:$d,i:$i,d:$b,l:$l})";
				break;
		}
		echo "I be here";
		$body="<script type='text/javascript'>if(window.opener){window.opener.$fun;}window.close();</script>";
		return $body;
	}
	
	$login=$_GET['state']?$_GET['state']:0;
	error_log($login);
	$hsc = new Handler_NewSocialConnection();
	$request_token = $hsc->getTwitterFlowRequestToken();
	$e=0;
	$d=false;
	$c=false;
	$i=false;
	if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
		$hsc->clearFlow();
		exit(makeBody(4));
	}else{
		if($_REQUEST['denied']) exit(makeBody(2));
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
						switch($login){
							case 0:
								$hsc->clearFlow();
								exit(makeBody(1));
								break;
							case 1:
								$userid=$result['userid'];
								require_once("../../clases/usuarios.php");
								$us=new usuario($userid);
								$us->ingresoUsuarioPorID();
								$hsc->clearFlow();
								exit(makeBody(0));
								break;
							case 2:
								exit(makeBody(1));
								break;
						}
					}else{
						//nueva cuenta
						switch($login){
							case 0:
								if($htw=new Handler_Twitter($access_token['oauth_token'], $access_token['oauth_token_secret'])){
									if($credentials=$htw->genericGet("account/verify_credentials",array("include_entities"=>"false","skip_status"=>1))){
										$fields['img']=$credentials->profile_image_url;
										$fields['name']=$credentials->name;
										$fields['location']=$credentials->location?$credentials->location:"";
										$fields['timezone']=$credentials->utc_offset;
										$hsc->createFlowProfile($fields);
										exit(makebody(0,$fields['name'],$fields['screen_name'],$fields['img'],$credentials->default_profile_image?"true":"false",$fields['location']));
									}else{ $hsc->clearFlow(); exit(makeBody(4));}
								}else{ $hsc->clearFlow(); exit(makeBody(4));}
								break;
							case 1:
								$hsc->clearFlow(); exit(makeBody(1));
								break;
							case 2:
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
												exit(makebody(0,$fields['name'],$fields['screen_name'],$fields['img'],$credentials->default_profile_image?"true":"false",$fields['location']));
											}else
												exit(makeBody(6));
										}
									}else{ $hsc->clearFlow(); exit(makeBody(4));}
								}
								break;
						}
					}
				}else{ $hsc->clearFlow(); exit(makeBody(2));}
			}else{ $hsc->clearFlow(); exit(makeBody(4));}
		}catch(Exception $e){
			$hsc->clearFlow();
			exit(makeBody(4));
		}
	}
?>