<?php
	require_once("../../../clases/manager/autoload.php");
	require_once("../../../clases/bd.php");
	require_once("../../../clases/usuarios.php");
	use OneAManager\Handler_Twitter;
	use OneAManager\Handler_Facebook;
	use OneAManager\Handler_Message;
	date_default_timezone_set('UTC');
	
	$key=$_GET['key'];
	
	if($key!=5688747) exit("u're 2casul 4 dis");
	
	
	function uploadTWMedia($htw,$url){
		if($media_id=$htw->uploadFile($url)){
			return $media_id;
		}else{
			error_log("Error uploading media: ".$htw->lastError);
			return false;
		}
	}
	
	function handleTwitterMessage($message,$db,$user_object){
		$uid=$message->getPubId();
		$condition="SELECT *  FROM manager_tw_acc  WHERE userid=".$uid." AND expired=0";
		if($twacc=$db->query($condition)){
			if($twacc->rowCount () > 0){
				$twacc=$twacc->fetch();
				$timezone=time()+$twacc['timezone'];
				$limit=$user_object->getAllPublishedWithinTimeFrame($uid,"tw",30,$timezone);
				if($limit<30){
					try{
						$htw=new Handler_Twitter($twacc['token'],$twacc['token_secret']);
						if($pic=$message->getPicture())
							$message->setPictureMediaId(uploadTWMedia($htw,$pic));
						if($post=$htw->genericPost("statuses/update",$message->getTwitterPostBody())){
							if($message->getPicture()){
								$media_url=array();
								$ccc=count($post->extended_entities->media);
								for($i=0;$i<$ccc;$i++){
									$media_url[]="".$post->extended_entities->media[$i]->media_url;
								}
								$media_url=implode(",",$media_url);
							}else $media_url="";
							$table="manager_stats";
							$fields=array(
								"userid"=>$uid,
								"social_network"=>"tw",
								"user_id"=>$twacc['user_id'],
								"message"=>$message->getStatus(),
								"message_id"=>$post->id_str,
								"type"=>2,
								"time"=>$timezone,
								"media_url"=>$media_url
							);
							$db->doInsert($table,$fields);
						}else{
							error_log($htw->getLastError());
						}
						
					}catch(Exception $e){
						error_log($e);
					}
				}
			}
		}
	}
	
	function handleFacebookMessage($message,$db,$user_object,$type){
		$uid=$message->getPubId();
		switch($type){
			case "fb":
				$con="AND (expires_at>".time()." OR expires_at=0)";
				break;
			case "fbp":
				$con="";
				break;
		}
		$condition="SELECT *  FROM manager_".$type."_acc  WHERE userid=".$uid." AND expired=0  $con";
		if($fbacc=$db->query($condition)){
			if($fbacc->rowCount () > 0){
				$fbacc=$fbacc->fetch();
				$timezone=time()+$fbacc['timezone'];
				$limit=$user_object->getAllPublishedWithinTimeFrame($uid,$type,30,$timezone);
				if($limit<45){
					try{
						$hfb=new Handler_Facebook();
						if($post=$hfb->post($message->getFacebookTarget(),$message->getFacebookPostBody(),$fbacc['access_token'])){
							$table="manager_stats";
							$fields=array(
								"userid"=>$uid,
								"social_network"=>$type,
								"user_id"=>$fbacc['user_id'],
								"message"=>$message->getStatus(),
								"message_id"=>$post['id'],
								"type"=>1,
								"time"=>$timezone
							);
							$db->doInsert($table,$fields);
						}else{
							error_log($hfb->getErrorMes());
						}
					}catch(Exception $e){
						error_log($e);
					}
				}
			}
		}
	}
	
	
	
	
	$user_object=new usuario();
	$db=new bd();
	$time=time()-16200;
	$day=date('D',$time);
	$hour_min=date('H:i:00',strtotime('- 29 minutes',$time));
	$hour_max=date('H:i:00',strtotime('+ 29 minutes',$time));
	$table="manager_messages_scheduled";
	$condition=" days LIKE '%$day%' 
		AND time_start<=$time AND time_end>$time 
		AND hour>'$hour_min' && hour<'$hour_max'";
	echo $condition;
	$user_object=new usuario();
	if($res=$db->doFullSelect($table,$condition)){
		foreach($res as $re){
			$message= new Handler_Message($re,false);
			if($message->canPublishTwitter()) handleTwitterMessage($message,$db,$user_object);
			if($message->canPublishFacebook()) handleFacebookMessage($message,$db,$user_object,"fb");
			if($message->canPublishFacebook()) handleFacebookMessage($message,$db,$user_object,"fbp");
		}
	}	
?>	