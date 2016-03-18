<?php
	require_once("../../clases/bd.php");
	

	session_start();
	$mesid = $_POST['id'];
	$uid = $_SESSION['id'];
	$table = "manager_fb_acc";
	$db = new bd();
	$query="DELETE FROM manager_messages_scheduled WHERE id=".$db->quote($mesid)." AND userid=".$db->quote($uid);
	error_log($query);
	if($db->query($query)){
		$return=Array("e"=>0);
	}else{
		$return=Array("e"=>1);
	}
	
	echo json_encode($return);
?>