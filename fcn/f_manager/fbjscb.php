<?php
	require_once("../../clases/manager/autoload.php");
	require_once("../../clases/bd.php");
	use OneAManager\Handler_Facebook;
	use OneAManager\Handler_NewSocialConnection;
	
	$login=$_GET['state']?$_GET['state']:0;
	
	
	try{
		$fbh = new Handler_Facebook();
		$hsc = new Handler_NewSocialConnection();
		$db = new bd();
		$permissions = ['publish_actions','user_photos','manage_pages','publish_pages'];
		if($info=$fbh->javascriptCallbackManager($permissions)){
			$uid=$info['user_id'];
			$at=$info['access_token'];
			$table="manager_fb_acc";
			$condition=" user_id=".$uid;
			if($result=$db->doSingleSelect($table,$condition)){
				//account already belongs to a user
				if($info["e"]){
					//some error, could mean a lot of things, but whichever the case we need to expire all the accounts.
					$fbh->revokePermissions($at,array());
					$fields = array('expires_at'=>1,'expired'=>1);
					$db->doUpdate($table,$fields,$condition);
					$return=array("e"=>2);
				}else{
					$ea=$info['expires_at'];
					$fields = array('access_token'=>$at,'expires_at'=>$ea,'expired'=>0);
					$db->doUpdate($table,$fields,$condition);
					switch($login){
						case 0:
							$return=array("e"=>1);
							break;
						case 1:
							$userid=$result['userid'];
							require_once("../../clases/usuarios.php");
							$us=new usuario($userid);
							$us->ingresoUsuarioPorID();
							$hsc->clearFlow();
							$return=array("e"=>0);
							break;
						case 2:
							$return=array("e"=>1);
							break;
					}
				}
			}else{
				//it is a new account
				switch($login){
					case 0:
						if($info["e"]){
							//some error, could mean a lot of things, but whichever the case we need to expire all the accounts.
							$fbh->revokePermissions($at,array());
							$return=array("e"=>2);
						}else if($profile_info=$fbh->get('/me?fields=email,location,first_name,last_name,gender,timezone,picture.width(320),verified',$at)){
							$fields=array("type"=>"fb_acc",
								"user_id"=>$uid,
								"first_name"=>$profile_info['first_name'],
								"last_name"=>$profile_info['last_name'],
								"email"=>$profile_info['email']?$profile_info['email']:'',
								"gender"=>$profile_info['gender']?$profile_info['gender']:'',
								"location"=>$profile_info['location']['name']?$profile_info['location']['name']:'',
								"verified"=>$profile_info['verified']?1:0,
								"access_token"=>$at,
								"expires_at"=>$info['expires_at'],
								"timezone"=>($profile_info['timezone']*3600),
								"img"=>$profile_info['picture']['data']['url']);
							$hsc->createFlowProfile($fields,true);
							$return=array(
								"e"=>0,
								"l"=>$profile_info['location']['name'],
								"fn"=>$profile_info['first_name'],
								"ln"=>$profile_info['last_name'],
								"em"=>$profile_info['email']?$profile_info['email']:'',
								"ps"=>$profile_info['picture']['data']['is_silhouette'],
								"p"=>$profile_info['picture']['data']['url']);
						}else{
							$return=array("e"=>4);
						}
						break;
					case 1:
						$return=array("e"=>1);
						break;
					case 2:
						$userid=$_SESSION["id"];
						$table="manager_fb_acc";
						$condition=" userid=".$userid;
						if($info["e"]){
							$fbh->revokePermissions($at,array());
							$return=array("e"=>2);
						}else if($result=$db->doSingleSelect($table,$condition)){
							$return=array("e"=>5);
						}else if($profile_info=$fbh->get('/me?fields=email,location,first_name,last_name,gender,timezone,picture.width(320),verified',$at)){
							$fields=array("userid"=>$userid,
								"user_id"=>$uid,
								"first_name"=>$profile_info['first_name'],
								"last_name"=>$profile_info['last_name'],
								"email"=>$profile_info['email']?$profile_info['email']:'',
								"gender"=>$profile_info['gender']?$profile_info['gender']:'',
								"location"=>$profile_info['location']['name']?$profile_info['location']['name']:'',
								"verified"=>$profile_info['verified']?1:0,
								"access_token"=>$at,
								"expires_at"=>$info['expires_at'],
								"timezone"=>($profile_info['timezone']*3600),
								"img"=>$profile_info['picture']['data']['url']);
							$table="manager_fb_acc";
							if($db->doInsert($table,$fields)){
								$hsc->clearFlow();
								$return=array(
									"e"=>0,
									"l"=>$profile_info['location']['name'],
									"fn"=>$profile_info['first_name'],
									"ln"=>$profile_info['last_name'],
									"em"=>$profile_info['email']?$profile_info['email']:'',
									"ps"=>$profile_info['picture']['data']['is_silhouette'],
									"p"=>$profile_info['picture']['data']['url']);
							}else
								$return=array("e"=>6);
						}
						break;
				}
			}
		}else{
			$return=array("e"=>4);
		}
	}catch(Exception $e){
		$return=array("e"=>4);
	}
	echo json_encode($return);
?>