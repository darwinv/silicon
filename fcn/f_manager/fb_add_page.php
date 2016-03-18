<?php
	require_once("../../clases/manager/autoload.php");
	require_once("../../clases/bd.php");
	use OneAManager\Handler_Facebook;
	function getPage($fbh,$at,$fpid){
		if($info=$fbh->get("/$fpid/?fields=access_token,name,picture.width(320)",$at)){
			if($info['access_token']!="")
				return array("at"=>$info['access_token'],
					"n"=>$info['name'],
					"p"=>$info['picture']['data']['url']);
			else 
				return false;
		}else{
			return false;
		}
	}


	session_start();
	$db = new bd();
	$userid=$_SESSION["id"];
	$fpid=$_POST["id"];
	$db = new bd();
	$table="manager_fb_acc";
	$condition=" userid=".$userid." AND expired=0 AND (expires_at>".time()." OR expires_at=0) ";
	if($result=$db->doSingleSelect($table,$condition)){
		$table="manager_fbp_acc";
		$condition=" userid=".$userid;
		if($db->doSingleSelect($table,$condition)){
			$return=array("e"=>2);
		}else{
			try{
				$fbh=new Handler_Facebook();
				$at=$result['access_token'];
				$timezone=$result['timezone'];
				if($page=getPage($fbh,$at,$fpid)){
					$fields=array(
						'userid'=>$userid,
						'user_id'=>$fpid,
						'name'=>$page['n'],
						'access_token'=>$page['at'],
						'expired'=>0,
						'timezone'=>$timezone,
						'img'=>$page['p'],
						'last_update'=>time()
					);
					if($db->doInsert($table,$fields)){
						$return=array(
							"e"=>0,
							"d"=>$db->lastInsertId(),
							"n"=>$page['n'],
							"p"=>$page['p']);
					}else
						$return=array("e"=>6);
				}else
					$return=array('e'=>3);
			}catch(Exception $e){
				$return=array('e'=>3);
			}
		}
	}else{
		$return=array('e'=>1);
	}
	echo json_encode($return);
	
	

?>