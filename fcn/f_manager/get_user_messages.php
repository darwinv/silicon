<?php
	require_once("../../clases/bd.php");
	require_once("../../clases/publicaciones.php");
	$db = new bd();
	session_start();
	$uid = $_SESSION['id'];
	$sn = array();
	
	function formatTimeStamp($timestamp,$lang=false){
	
	
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
	
	$query="SELECT * FROM manager_messages_scheduled WHERE userid = $uid";
	if($res=$db->query($query)){
		while($pub=$res->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
			$pub_object = new publicaciones($pub['id']);
		
			$pubi = array(
				"i" => $pub['id'],
				"m" => $pub['message'],
				"p" => $pub['img'],
				"ts_es" => formatTimeStamp($pub['time_start'],true),
				"ts_en" => date('Y-m-d',$pub['time_start']),
				"te_es" => formatTimeStamp($pub['time_end'],true),
				"te_en" => date('Y-m-d',$pub['time_end']),
				"t_p" => $pub['img'],
				"d" => $pub['days'],
				"h" => formatHour($pub['hour']),
				"tw" => $pub['publish_tw'],
				"fb" => $pub['publish_fb'],
				"fbp"=> $pub['publish_fbp'],
				"gp" => $pub['publish_fbgp'],
			);
			$sn[]=$pubi;
		}
		$return = array(
			"e" => 0,
			"sn" => $sn,
		);
		
	}else{
		$return=Array("e"=>1);
	}
	echo json_encode($return);




?>