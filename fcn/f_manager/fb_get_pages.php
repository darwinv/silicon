<?php
	require_once("../../clases/manager/autoload.php");
	require_once("../../clases/bd.php");
	use OneAManager\Handler_Facebook;
	
	function getFBPpic($at,$fbh,$id){
		if($info=$fbh->get("/$id/?fields=picture.width(320)",$at)){
			return $info['picture']['data']["url"];
		}else{
			return false;
		}
	}

	function getFBPages($at,$fbh){
		$pages=array();
		$table="fb_acc_page";
		if($info=$fbh->get("/me/accounts",$at)){
			$c=count($info['data']);
			if($c>0){
				foreach($info['data'] as $page){
					$perms=$page["perms"];
					if(in_array("ADMINISTER",$perms) || in_array("CREATE_CONTENT",$perms) || in_array("BASIC_ADMIN",$perms)){
						$pages[]=array(
							"n"=>$page['name'],
							"i"=>$page['id'],
							"p"=>getFBPpic($page['access_token'],$fbh,$page['id'])
						);
					}
				}
			}
		}
		return $pages;
	}
	
	
	session_start();
	$db = new bd();
	$userid=$_SESSION["id"];
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
				$return=array(
					"e"=>0,
					"p"=>getFBPages($at,$fbh));
			}catch(Exception $e){
				$return=array("e"=>3);
			}
		}
	}else{
		$return=array("e"=>1);
	}
	echo json_encode($return);
?>