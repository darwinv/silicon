<?php
	include_once "../../../clases/ventas.php";
	switch($_POST["metodo"]){
		case "guardarPago":
			guardaPago();
			break;
	}
	function guardaPago(){
		$compra=new ventas();
		$result=$compra->setPagos($_POST["p_referencia"], $_POST["p_monto"], $_POST["p_fecha"], $_POST["p_forma_pago"], $_POST["p_banco"],$_POST["id"]);
		echo $result;
	}
?>
