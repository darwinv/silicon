<?php
include_once "clases/publicaciones.php";
include_once "clases/bd.php";
$bd=new bd();
$publicaciones=$bd->query("select publicaciones_id from publicacionesxstatus where status_publicaciones_id<4 and fecha_fin IS NULL and fecha<=DATE_SUB(CURDATE(), INTERVAL 30 DAY)");
$tiempo = date("Y-m-d H:i:s",time());
$contador=0;
foreach ($publicaciones as $key => $valor) {
	$valores=array("fecha"=>$tiempo,"publicaciones_id"=>$valor["publicaciones_id"],"status_publicaciones_id"=>4,"fecha_fin"=>$tiempo);
	$consulta="update publicacionesxstatus set fecha_fin='$tiempo' where publicaciones_id={$valor["publicaciones_id"]} and fecha_fin IS NULL";
	$bd->query($consulta);
	$bd->doInsert("publicacionesxstatus",$valores);
	$contador++;
}
echo "Actualizadas $contador publicaciones";
?>