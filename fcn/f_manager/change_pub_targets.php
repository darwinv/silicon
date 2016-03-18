<?php
	require_once("../../clases/bd.php");
	$db = new bd();
	session_start();
	
	$uid = $_SESSION['id'];
	$pid = $db->quote($_POST['id']);
	$tw  = $_POST['tw'] == 1 ? 1 : 0;
	$fb  = $_POST['fb'] == 1 ? 1 : 0;
	$fbp = $_POST['fbp']== 1 ? 1 : 0;
	$gp  = $_POST['gp'] == 1 ? 1 : 0;
	$des = $_POST['des'];
	
	$tabla="publicaciones";
	$fields=array(
		"publicar_twitter"  => $tw,
		"publicar_facebook" => $fb,
		"publicar_fanpage"  => $fbp,
		"publicar_grupo"    => $gp,
		"manager_des"		=> $des
	);

	
	if($db->doUpdate($tabla, $fields, " id=$pid AND usuarios_id=$uid ")) $return=array("e"=>0);
	else $return=array("e"=>1);
	echo json_encode($return);
?>