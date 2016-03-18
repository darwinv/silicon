<?php
	require_once("../../clases/bd.php");
	require_once("../../clases/fotos.php");
	require_once("../../clases/manager/autoload.php");
	use OneAManager\Handler_Soat;
	use OneAManager\Handler_Message;
	date_default_timezone_set('UTC');
	
	function formatDate($date){
		$months=array(
			"January",
			"February",
			"March",
			"April",
			"May",
			"June",
			"July",
			"August",
			"September",
			"October",
			"November",
			"December"
		
		);
	
		$array=explode(",",$date);
		$array_2=explode(" ",$array[0]);
		$month=array_search($array_2[1],$months)+1;
		return $array[1]."-".$month."-".$array_2[0];
	}
	
	function formatTimeStamp($timestamp){
	
	
		$months=array(
			"Enero" => "January",
			"Febrero" => "February",
			"Marzo" => "March",
			"Abril" => "April",
			"Mayo" => "May",
			"Junio" => "June",
			"Julio" => "July",
			"Agosto" => "August",
			"Septiembre" => "September",
			"Octubre" => "October",
			"Noviembre" => "November",
			"Diciembre" => "December"
		
		);
	
	
		$day = date("d",$timestamp);
		$year = date("Y",$timestamp);
		$month = date("F",$timestamp);
		$month = array_search($month,$months);
	
		return "$day $month, $year";
	}
	
	function formatHour($hour){
		$hour=explode(":",$hour);
		if($hour[0]>12){
			$h=$hour[0]-12;
			$t=" PM";
		}else{
			$h=$hour[0];
			$t=" AM";
		}
		return $h.":".$hour[1].$t;
	
	}
	
	function makeTimes($fields){
		$thing = substr($fields['hour'], -2);
		$fields['hour'] = str_replace($thing,"",$fields['hour']);
		if($thing=="PM"){
			$array=explode(":",$fields['hour']);
			$array[0]=$array[0]+12;
			$fields['hour']=implode(":",$array);}
		//var_dump($fields);
		$time=time()-16400;
		$time_start=strtotime($fields['time_start']." ".$fields['hour'],$time);
		$time_end=strtotime($fields['time_end']." ".$fields['hour'],$time);
		if($time_start>$time_end){
			return 6;
		}
		if($time>$time_end){
			return 7;
		}
		$fields['time_start']=$time_start;
		$fields['time_end']=$time_end;
		return $fields;
	}
	
	function cleanMessage($message, $max_chars, $userid){
		$message = trim($message);
		$message = str_replace(array("<",">"),array("&lt;","&gt;"),$message);
		$chars=$max_chars;
		$links=Handler_Message::$LINKSRX;
		$texto=$message;
		if($num=preg_match_all($links,$texto,$matches,PREG_SET_ORDER)>0){
			$chars=$chars-(23*$num);
			$texto=preg_replace($links,"",$texto);
		}
		$chars=$chars-strlen($texto);
		if($chars>($max_chars-10)){
			//mensaje muy corto
			return 4;
		}else if($chars<0){
			//mensaje muy largo
			return 5;
		}else if(count($matches)>0){
			$new_urls=array();
			$old_urls=array();
			$hso = new Handler_Soat();
			$soat=array("abid"=>$userid,"absid"=>0);
			foreach($matches as $match){
				if(preg_match_all("/(https?:\/\/1so\.at\/[A-Za-z0-9&ntilde;&Ntilde;_\-]+)/",$match[0])==0){
					$old_urls[]="/".str_replace("/","\/",preg_quote($match[0]))."/";
					$soat['u']="".$match[0];
					$new="http://1so.at/".$hso->encode($soat);
					$new_urls[]=$new!=''?$new:$match[0];}
			}
			$message=preg_replace($old_urls,$new_urls,$message);
		}
		return $message;
	}
	
	session_start();
	$hdb=new bd();
	$userid=$_SESSION["id"];
	$table="manager_messages_scheduled";
	$sql="SELECT * FROM $table WHERE userid = ".$hdb->quote($userid);
	if($res=$hdb->query($sql)){
		if($res->rowCount()<11 || $_POST['edit']){
		
			if($_POST['publish_tw']==1)
				$max_chars=140;
			else
				$max_chars=2000;
			if($_POST['img']){
				if(substr ( $_POST['img'], 0, 4 ) == "data"){
					$fotob=new fotos();
					if($img=$fotob->subirFotoManager($_POST['img'],$userid)){
						
					}else{
						error_log("Error al subir foto");
						$img="";
					}
				}else{
					$img=$_POST['img'];
				}
			}else
				$img="";
			$message = cleanMessage($_POST['message'], $max_chars, $userid);
			if(!is_numeric($message) || $message>5){
				$fields=array(
					'userid' => $userid,
					'message' => $message,
					'img' => $img,
					'time_start' => $_POST['time_start'],
					'time_end' => $_POST['time_end'],
					'days' => $_POST['days'],
					'hour' => $_POST['hour'],
					'publish_fb' => $_POST['publish_fb'],
					'publish_tw' => $_POST['publish_tw'],
					'publish_fbp' => $_POST['publish_fbp'],
					'publish_fbgp' => $_POST['publish_group'],
				);
				if(is_array(($fields=makeTimes($fields)))){
				
					if($_POST['edit']==true){
						unset($fields['userid']);
						if($hdb->doUpdate($table,$fields," id=".$hdb->quote($_POST['mes_id'])." AND userid=".$hdb->quote($userid))){
							$return=array("e"=>0,
							"c"=>array(
								"i" => $_POST['mes_id'],
								"m" => $fields['message'],
								"p" => $fields['img'],
								"ts_es" => formatTimeStamp($fields['time_start']),
								"ts_en" => date('Y-m-d',$fields['time_start']),
								"te_es" => formatTimeStamp($fields['time_end']),
								"te_en" => date('Y-m-d',$fields['time_end']),
								"t_p" => $fields['img'],
								"d" => $fields['days'],
								"h" => formatHour($fields['hour']),
								"tw" => $fields['publish_tw'],
								"fb" => $fields['publish_fb'],
								"fbp"=> $fields['publish_fbp'],
								"gp" => $fields['publish_fbgp'])
							);
						}else{ 
							error_log($hdb->errorInfo());
							$return=array("e"=>2);}
					}else{
						if($hdb->doInsert($table,$fields)){
							$return=array("e"=>0,
							"c"=>array(
								"i" => $hdb->lastInsertId(),
								"m" => $fields['message'],
								"p" => $fields['img'],
								"ts_es" => formatTimeStamp($fields['time_start']),
								"ts_en" => date('Y-m-d',$fields['time_start']),
								"te_es" => formatTimeStamp($fields['time_end']),
								"te_en" => date('Y-m-d',$fields['time_end']),
								"t_p" => $fields['img'],
								"d" => $fields['days'],
								"h" => formatHour($fields['hour']),
								"tw" => $fields['publish_tw'],
								"fb" => $fields['publish_fb'],
								"fbp"=> $fields['publish_fbp'],
								"gp" => $fields['publish_fbgp']));
						}else{ 
							error_log($hdb->errorInfo());
							$return=array("e"=>2);}
					}
				}else{
					$return=array("e"=>$fields);
				}
			}else{
				$return=array("e"=>$message);
			}
		}else{
			$return=array("e"=>1);
		}
	}else{
		$return=array("e"=>3);
	}
	echo json_encode($return);



?>