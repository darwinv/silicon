<?php
	require_once("../../../clases/manager/autoload.php");
	require_once("../../../clases/bd.php");
	require_once("../../../clases/usuarios.php");
	
	
	use OneAManager\Handler_Twitter;
	use OneAManager\Handler_Facebook;
	use OneAManager\Handler_Message;
	date_default_timezone_set('UTC');
	
	$key=$_GET['key'];
	
	if($key!=5688746) exit("u're 2casul 4 dis");
	
	
	function minMax($tot_int){
		if($tot_int>0){
			$max=round((1440*3.5)/$tot_int);
			$min=round((1440*2.9)/$tot_int);}
		if($tot_int>10){
			$max=round((1440*2.9)/$tot_int);
			$min=round((1440*2.6)/$tot_int);}
		if($tot_int>20){
			$max=round((1440*2.5)/$tot_int);
			$min=round((1440*2.1)/$tot_int);}
		if($tot_int>35){
			$max=round((1440*2)/$tot_int);
			$min=round((1440*1.6)/$tot_int);}
		if($tot_int>50){
			$max=round((1440*1.6)/$tot_int);
			$min=round(1440/$tot_int);}
		if($max>1440)
			$max=1440;
		if($min>1440)
			$min=1439;	
		return array("min"=>$max,"max"=>$min);
	}
	
	function sanityCheck($present,$last_time,$total_entries){
		//error_log("Total entries is $total_entries");
		$minmax=minMax($total_entries);
		if(($present>=strtotime("00:00",$present)) && $present<strtotime("03:00",$present)){
			return false;
		}else if(($present>=strtotime("03:00",$present)) && $present<strtotime("07:29",$present)){
			return false;
		}else if(($present>=strtotime("07:30",$present)) && $present<strtotime("10:00",$present)){
			/*if($total_entries<9)
				return false;*/
			$rand=mt_rand($minmax['max'],$minmax['min']);
			$offset=round($rand*2);
		}else if(($present>=strtotime("10:00",$present)) && $present<strtotime("15:00",$present)){
			$rand=mt_rand($minmax['max'],$minmax['min']);
			$offset=round($rand*0.4);
		}else if(($present>=strtotime("15:00",$present)) && $present<strtotime("18:00",$present)){
			$rand=mt_rand($minmax['max'],$minmax['min']);
			$offset=round($rand*1.1);
		}else if(($present>=strtotime("18:00",$present)) && $present<strtotime("20:00",$present)){
			$rand=mt_rand($minmax['max'],$minmax['min']);
			$offset=round($rand*0.5);
			//error_log("offset is $offset");
		}else if(($present>=strtotime("20:00",$present)) && $present<strtotime("22:00",$present)){
			$rand=mt_rand($minmax['max'],$minmax['min']);
			$offset=round($rand*1.3);
		}else if(($present>=strtotime("22:00",$present)) && $present<strtotime("23:59",$present)){
			$rand=mt_rand($minmax['max'],$minmax['min']);
			$offset=round($rand*1.7);
		}
		$offset=$offset*60;
		//error_log(($last_time+$offset)." should be less than $present");
		if($last_time+$offset<$present) return true;
		else return false;
	}
	
	function uploadTWMedia($htw,$url){
		if($media_id=$htw->uploadFile($url)){
			return $media_id;
		}else{
			error_log("Error uploading media: ".$htw->getLastError());
			return false;
		}
	}
	
	function handleTwitterMessage($message,$uid,$db,$user_object,$total){
		$table="manager_tw_acc";
		$condition="SELECT *  FROM manager_tw_acc  WHERE userid=".$uid." AND expired=0";
		if($twacc=$db->query($condition)){
			if($twacc->rowCount () > 0){
				$twacc=$twacc->fetch();
				$timezone=time()+$twacc['timezone'];
				$lastTime=$user_object->getLastPublishedTime($uid,"tw",1);
				$limit=$user_object->getAllPublishedWithinTimeFrame($uid,"tw",30,$timezone);
				if($limit<30 && sanityCheck($timezone,$lastTime,$total)){
					try{
						/*echo "I am about to publish in twitter the following message<br>";
						var_dump($message->getTwitterPostBody());
						echo "message<br>";*/
						$htw=new Handler_Twitter($twacc['token'],$twacc['token_secret']);
						if($pic=$message->getPicture())
							$message->setPictureMediaId(uploadTWMedia($htw,$pic));
						if($post=$htw->genericPost("statuses/update",$message->getTwitterPostBody())){
							$media_url=array();
							$ccc=count($post->extended_entities->media);
							for($i=0;$i<$ccc;$i++){
								$media_url[]="".$post->extended_entities->media[$i]->media_url;
							}
							$media_url=implode(",",$media_url);
							$table="manager_stats";
							$fields=array(
								"userid"=>$uid,
								"social_network"=>"tw",
								"user_id"=>$twacc['user_id'],
								"message"=>$message->getStatus(),
								"message_id"=>$post->id_str,
								"type"=>1,
								"time"=>time(),
								"media_url"=>$media_url
							);
							$db->doInsert($table,$fields);
							$message->setLastShare();
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
	
	function handleFacebookMessage($message,$uid,$db,$user_object,$total,$type){
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
				/*foreach($fbacc as $key=>$value)
					error_log(" $key => $value ");*/
				$timezone=time()+$fbacc['timezone'];
				$lastTime=$user_object->getLastPublishedTime($uid,$type,1);
				$limit=$user_object->getAllPublishedWithinTimeFrame($uid,$type,30,$timezone);
				if($limit<45 && sanityCheck($timezone,$lastTime,$total)){
					try{
						$hfb=new Handler_Facebook();
						error_log(json_encode($message->getFacebookPostBody()));
						if($post=$hfb->post("/me/feed",$message->getFacebookPostBody(),$fbacc['access_token'])){
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
							$message->setLastShare();
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
	$usuarios=$user_object->listarUsuariosConPublicaciones(1);
	
	
	
	
	foreach($usuarios as $usuario){
		$uid=$usuario['id'];
		$pubs=$usuario['publicaciones']->fetchAll();
		$message=new Handler_Message($pubs[0]);
		$query="SELECT * FROM manager_messages_scheduled WHERE userid = $uid";
		if($res=$db->query($query)){
			$plus=$res->rowCount();
		}else{
			$plus=0;
		}
		
		
		$upst=$usuario['total']+$plus;
		if($upst>0){
			if($message->canPublishTwitter()) handleTwitterMessage($message,$uid,$db,$user_object,$upst);
			if($message->canPublishFacebook()) handleFacebookMessage($message,$uid,$db,$user_object,$upst,"fb");
			if($message->canPublishFacebookFanPage()) handleFacebookMessage($message,$uid,$db,$user_object,$upst,"fbp");
		}
	}

?>