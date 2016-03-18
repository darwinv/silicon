<?php
if(!isset($_SESSION)){
	session_start();
}
if(!isset($_SESSION["id"])){
	header ( "Location: index.php" );
}
if($_SESSION["nivel"]<1){
	header ( "Location: index.php" );
}
include "fcn/incluir-css-js.php";
include "clases/bd.php";
$bd=new bd();

$sql=$bd->query("select count(*) as tota from publicaciones where id in
(select publicaciones_id from publicacionesxstatus where DATE(fecha)=DATE(now()) and status_publicaciones_id=1)");
$row = $sql->fetch();
$valor1=$row["tota"];

$sql=$bd->query("select count(*) as tota from publicaciones where id in
(select publicaciones_id from publicacionesxstatus where date(fecha)=date(DATE_SUB(CONCAT(CURDATE(), ' 00:00:00'),INTERVAL 1 DAY)) and status_publicaciones_id=1)");
$row = $sql->fetch();
$valor2=$row["tota"];

$sql=$bd->query("select count(*) as tota from publicaciones where id in
(select publicaciones_id from publicacionesxstatus where WEEKOFYEAR(fecha)=WEEKOFYEAR(now()) and status_publicaciones_id=1)");
$row = $sql->fetch();
$valor3=$row["tota"];

$sql=$bd->query("select count(*) as tota from publicaciones where id in
(select publicaciones_id from publicacionesxstatus where WEEKOFYEAR(fecha)=WEEKOFYEAR(date(DATE_SUB(CONCAT(CURDATE(), ' 00:00:00'),INTERVAL 7 DAY))) and status_publicaciones_id=1)");
$row = $sql->fetch();
$valor4=$row["tota"];

$sql=$bd->query("select count(*) as tota from publicaciones where id in 
(select publicaciones_id from publicacionesxstatus where MONTH(fecha)=MONTH(now()) and YEAR(fecha)=YEAR(now()) and status_publicaciones_id=1)");
$row = $sql->fetch();
$valor5=$row["tota"];

$sql=$bd->query("select count(*) as tota from publicaciones where id in 
(select publicaciones_id from publicacionesxstatus where MONTH(fecha)=MONTH(DATE_ADD(CURDATE(),INTERVAL -1 MONTH)) and status_publicaciones_id=1)");
$row = $sql->fetch();
$valor6=$row["tota"];

$sql=$bd->query("select count(*) as tota from publicaciones where id in 
(select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)");
$row = $sql->fetch();
$valor7=$row["tota"];

$sql=$bd->query("select count(*) as tota from usuariosxstatus where DATE(fecha)=DATE(now()) and status_usuarios_id=1");
$row = $sql->fetch();
$valor8=$row["tota"];

$sql=$bd->query("select count(*) as tota from usuariosxstatus where date(fecha)=date(DATE_SUB(CONCAT(CURDATE(), ' 00:00:00'),INTERVAL 1 DAY)) and status_usuarios_id=1");
$row = $sql->fetch();
$valor9=$row["tota"];

$sql=$bd->query("select count(*) as tota from usuariosxstatus where WEEKOFYEAR(fecha)=WEEKOFYEAR(now()) and status_usuarios_id=1");
$row = $sql->fetch();
$valor10=$row["tota"];

$sql=$bd->query("select count(*) as tota from usuariosxstatus where WEEKOFYEAR(fecha)=WEEKOFYEAR(date(DATE_SUB(CONCAT(CURDATE(), ' 00:00:00'),INTERVAL 7 DAY))) and status_usuarios_id=1");
$row = $sql->fetch();
$valor11=$row["tota"];

$sql=$bd->query("select count(*) as tota from usuariosxstatus where MONTH(fecha)=MONTH(now()) and YEAR(fecha)=YEAR(now()) and status_usuarios_id=1");
$row = $sql->fetch();
$valor12=$row["tota"];

$sql=$bd->query("select count(*) as tota from usuariosxstatus where MONTH(fecha)=MONTH(DATE_ADD(CURDATE(),INTERVAL -1 MONTH))and status_usuarios_id=1");
$row = $sql->fetch();
$valor13=$row["tota"];

$sql=$bd->query("select count(*) as tota from usuariosxstatus where status_usuarios_id=1");
$row = $sql->fetch();
$valor14=$row["tota"];
?>
<div class="container" style="margin-top: -80px;">
	<center><h2>ESTADISTICAS</h2></center>
	<BR>
	<div class="contenedor sombra-div  pad20  center-block t16" style="width:50%;">
		<div class="row lista-estadisticas">	
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-10 pad10" >&nbsp;<i class="fa fa-tag"></i> Publicaciones de Hoy</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 resultado"><?php echo $valor1; ?></div>
			
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-10 pad10" >&nbsp;<i class="fa fa-tag"></i> Publicaciones de Ayer</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 resultado"><?php echo $valor2; ?></div>
						
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-10 pad10">&nbsp;<i class="fa fa-tag"></i> Publicaciones de la semana</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 resultado"><?php echo $valor3; ?></div>

			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-10 pad10">&nbsp;<i class="fa fa-tag"></i> Publicaciones de la semana pasada</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 resultado"><?php echo $valor4; ?></div>
			
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-10 pad10">&nbsp;<i class="fa fa-tag"></i> Publicaciones del mes</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 resultado"><?php echo $valor5; ?></div>

			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-10 pad10">&nbsp;<i class="fa fa-tag"></i> Publicaciones del mes anterior</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 resultado"><?php echo $valor6; ?></div>

			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-10 pad10">&nbsp;<i class="fa fa-tag"></i> Total de Publicaciones activas</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 resultado"><?php echo $valor7; ?></div>
			
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pad10  "><hr></div>
			
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-10 pad10">&nbsp;<i class="fa fa-user"></i> Usuarios registrados hoy</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 resultado"><?php echo $valor8; ?></div>

			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-10 pad10">&nbsp;<i class="fa fa-user"></i> Usuarios registrados ayer</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 resultado"><?php echo $valor9; ?></div>
			
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-10 pad10">&nbsp;<i class="fa fa-user"></i> Usuarios registrados en la semana</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 resultado"><?php echo $valor10; ?></div>

			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-10 pad10">&nbsp;<i class="fa fa-user"></i> Usuarios registrados en la semana pasada</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 resultado"><?php echo $valor11; ?></div>

			
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-10 pad10">&nbsp;<i class="fa fa-user"></i> Usuarios registrados en el mes</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 resultado"><?php echo $valor12; ?></div>

			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-10 pad10">&nbsp;<i class="fa fa-user"></i> Usuarios registrados en el mes anterior</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 resultado"><?php echo $valor13; ?></div>
			
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-10 pad10">&nbsp;<i class="fa fa-user"></i> Total de usuarios</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 resultado"><?php echo $valor14; ?></div>
		</div>	
</div>