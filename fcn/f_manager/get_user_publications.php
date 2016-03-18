<?php
	require_once("../../clases/bd.php");
	require_once("../../clases/publicaciones.php");
	$db = new bd();
	session_start();
	$uid = $_SESSION['id'];
	$sn = array();
	$nsn = array();
	
	
	$query="SELECT a.*,b.condicion FROM publicaciones AS a
		LEFT JOIN condiciones_publicaciones as b ON a.condiciones_publicaciones_id = b.id
		RIGHT JOIN publicacionesxstatus as c ON a.id=c.publicaciones_id AND c.status_publicaciones_id=1 AND c.fecha_fin IS NULL
		WHERE a.usuarios_id = $uid  AND (a.stock>0 OR a.stock IS NULL)
		ORDER BY a.id ASC";
	if($res=$db->query($query)){
		while($pub=$res->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
			$pub_object = new publicaciones($pub['id']);
		
			$pubi = array(
				"id" => $pub['id'],
				"monto" => $pub['monto'],
				"titulo" => $pub['titulo'],
				"des" => $pub['manager_des'],
				"len" => (strlen($pub['titulo'])+strlen($pub['monto']+"")+strlen($pub['condicion'])+23+23),
				"condicion" => $pub['condicion'],
				"picture" => $pub_object->getFotoPrincipal(),
				"tw" => $pub['publicar_twitter'],
				"fb" => $pub['publicar_facebook'],
				"fbp" => $pub['publicar_fanpage'],
				"gp" => $pub['publicar_grupo']
			);
			
			if( $pubi['tw']==1 ||  $pubi['fb']==1 ||  $pubi['fbp']==1 ||  $pubi['gp']==1  )
				$sn[]=$pubi;
			else 
				$nsn[]=$pubi;
		}
		
		if($_GET['type']==1){
			$rr=$sn;
		}else
			$rr=$nsn;
			
		$return = array(
			"e" => 0,
			"sn" => $rr,
		);
		
	}else{
		$return=Array("e"=>1);
	}
	echo json_encode($return);

?>