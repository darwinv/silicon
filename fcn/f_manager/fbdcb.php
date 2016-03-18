<?php
	require_once("../../clases/manager/autoload.php");
	require_once("../../clases/bd.php");
	use OneAManager\Handler_Facebook;
	try{
		$fbh = new Handler_Facebook();
		$hsc = new Handler_NewSocialConnection();
		$db = new bd();

		if($signed_request=$_REQUEST['signed_request']){
			if($data=$fbh->parseSignedRequest($signed_request)){
				$uid=$data['user_id'];
				$table="manager_fb_acc";
				if($acc=$db->doSingleSelect($table," user_id=".$uid)){
					$uuid=$acc['userid'];
					$table="manager_fb_acc";
					$condition=" user_id=".$uuid;
					$fields = array('expires_at'=>1,'expired'=>1);
					$db->doUpdate($table,$fields,$condition);
					$table="manager_fbp_acc";
					$fields=array('expired'=>1);
					$condition=" user_id=".$uuid;
					$db->doUpdate($table,$fields,$condition);
					error_log("I've deleted $uid");
				}else{
					error_log("We got lucky, I guess! $uid");
				}
			}
		}else{
			error_log("No request");
		}
	}catch(Exception $e){
		$return=array("e"=>4);
	}
?>