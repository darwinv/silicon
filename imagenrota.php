<?php
require 'config/core.php';
$bd=new bd();
$c1=0;
$c2=0;
$result=$bd->query("select * from fotosxpublicaciones where publicaciones_id in (
select id from publicaciones where id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null))");
foreach($result as $r=>$valor){
	$ruta=$bd->doSingleSelect("fotos","id={$valor["fotos_id"]}");
	$file=$ruta["ruta"] . $ruta["id"] . ".png";
	if(file_exists($file)){
		echo "<br>EXISTE EL ARCHIVO: $file";
		$c1++;
	}else{
		$c2++;
		echo "<br>NO EXISTE EL ARCHIVO: $file";
		copy("galeria/img-site/actualizar_foto.png",$file);
	}
}
echo "<br>Existen $c1 <br>";
echo "No Existen $c2 <br>";
?>