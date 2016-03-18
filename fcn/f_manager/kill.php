<?php
	require_once("../../clases/bd.php");
	

	session_start();
	$type = $_POST['type'];
	$pid = $_POST['pid'];
	$uid = $_SESSION['id'];
	switch($type){
		case "fb":
			$table = "manager_fb_acc";
			break;
		case "tw":
			$table = "manager_tw_acc";
			break;
		case "fbp":
			$table = "manager_fbp_acc";
			break;
		default:
			exit(json_encode(Array("e"=>2)));
			break;
	}
	
	$db = new bd();
	$query="DELETE FROM $table WHERE id=".$db->quote($pid)." AND userid=".$db->quote($uid);
	if($db->query($query)){
		$return=Array("e"=>0);
	}else{
		$return=Array("e"=>1);
	}
	
	echo json_encode($return);
?>