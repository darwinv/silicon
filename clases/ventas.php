<?php
	//include_once "bd.php";
	class ventas extends bd {
/*******Atributos de la tabla compras_publicaciones los cuales inician con el sufijo 'c'*****/
		private $table="compras_publicaciones";
		private $id;
		private $fecha;
		public $publicaciones_id;
		private $usuarios_id;
		private $cantidad;
		private $descuento;
		private $nota;

/**********POR EL MOMENTO EL CONSTRUCTOR SOLO CARGA LOS ATRIBUTOS DE LA TABLA compras_publicaciones************/		
		public function ventas($id=NULL){
			parent::__construct();
			if(!is_null($id)){
				$this->buscarCompra($id);
			}
		}
		public function buscarCompra($id){
			//$bd=new bd();
			$result=$this->doSingleSelect($this->table,"id=$id");
			if($result){
				$this->id=$result["id"];
				$this->fecha=$result["fecha"];
				$this->publicaciones_id=$result["publicaciones_id"];
				$this->usuarios_id=$result["usuarios_id"];
				$this->cantidad=$result["cantidad"];
				$this->descuento=$result["descuento"];
				$this->nota=$result["nota"];
			}
		}
/*********************************SETTERS************************************************/
		public function setCompra($id_pub){
		
			$tiempo = date("Y-m-d H:i:s",time());
			$params=array("fecha"=>$tiempo,
						  "publicaciones_id"=>$id_pub,
						  "usuarios_id"=>$_POST["id"]
						  );
			$result=$this->doInsert($table,$params);
			if($result){
				return $this->lastInsertId();
			}else{
				return false;
			}
		}
		public function setPagos($referencia,$monto,$fecha,$fp,$bancos_id=NULL,$id){
			if(is_null($id)){
				$id=$this->id;
			}
		
			$params=array("referencia"=>$referencia,
						  "monto"=>$monto,
						  "fecha"=>$fecha,
						  "status_pago"=>1,
						  "bancos_id"=>$bancos_id,
						  "formas_pagos_id"=>$fp,
						  "compras_publicaciones_id"=>$id
						 );
			$result=$this->doInsert("pagosxcompras",$params);
			return $result;
		}
		public function setEnvios($fecha,$nro_guia,$cantidad,$direccion,$agencia,$monto=0,$status=1,$id=NULL){
			if(is_null($id)){
				$id=$this->id;
			}
		//$bd=new bd();
			$params=array("fecha"=>$fecha,
						  "nro_guia"=>$nro_guia,
						  "cantidad"=>$cantidad,
						  "direccion"=>$direccion,
						  "status_envios_compras_id"=>$status,
						  "agencias_envios_id"=>$agencia,
						  "compras_publicaciones_id"=>$id,
						  "costo"=>$monto
						 );
			$result=$this->doInsert("compras_envios",$params);
			return $result;			
		}
		public function setCalificacion($comentario,$calificacion,$usuarios_id=NULL,$id){
			if(is_null($id)){
				$id=$this->id;
			}
			if(is_null($usuarios_id)){
				$usuarios_id=$this->usuarios_id;
			}
			
			$params=array("comentario"=>$comentario,
						  "calificacion"=>$calificacion,
						  "compras_publicaciones_id"=>$id,
						  "usuarios_id"=>$usuarios_id
						  );
			$result=$this->doInsert("calificaciones_compras",$params);
			return $result;
		}
		public function setDescuento($monto,$id=NULL){
			if(is_null($id)){
				$id=$this->id;
			}
			
			$result=$this->doUpdate($this->table,array("descuento"=>$monto),"id=$id");
			if($result){
				$this->descuento=$monto;
				return $this->getStatusPago();
			}
		}
		public function setComentario($nota,$id=NULL){
			if(is_null($id)){
				$id=$this->id;
			}
			//$bd=new bd();
			$result=$this->doUpdate($this->table,array("nota"=>$nota),"id=$id");
			if($result){
				$this->nota=$nota;
				return "Ok.";
			}
		}		
/******************************END OF SETTER**********************************/

 
/******************************GETTING***************************************/
		public function getPagos($status=0,$id=NULL){
			if(is_null($id)){
				$id=$this->id;
			}
			
			if($status==0){
				$condicion="p.compras_publicaciones_id=$id";
			}else{
				$condicion="p.compras_publicaciones_id=$id and p.status_pago=$status";
			}
			$consulta="select p.*,b.nombre,b.siglas,f.nombre as fp from pagosxcompras as p,bancos as b,formas_pagos as f where p.bancos_id=b.id and $condicion and p.formas_pagos_id=f.id";
			//$result=$bd->doFullSelect("pagosxcompras",$condicion);
			$result=$this->query($consulta);
			return $result;
		}
		public function getEnvios($id=NULL){
			if(is_null($id)){
				$id=$this->id;
			}
			
			//$result=$bd->doFullSelect("compras_envios","compras_publicaciones_id=$id");
			$consulta="select compras_envios.*,agencias_envios.nombre from compras_envios,agencias_envios where agencias_envios_id=agencias_envios.id and compras_publicaciones_id=$id";
			$result=$this->query($consulta);
			return $result;
		}
		public function getCalificaciones($id=NULL){
			if(is_null($id)){
				$id=$this->id;
			}	
			$result=$this->doFullSelect("calificaciones_compras","compras_publicaciones_id=$id");
			return $result;
		}
		public function getMonto($formato=0,$id=NULL){
			if(is_null($id)){
				$id=$this->id;
			}
			return $this->monto - $this->descuento;
		}
		public function getMontoGeneral($formato=0,$id=NULL){
			if(is_null($id)){
				$id=$this->id;
			}
			return $this->monto;
		}		
		public function getCantidad($id=NULL){
			if(is_null($id)){
				$id=$this->id;
			}
			return $this->cantidad;
		}
		public function getFecha($id=NULL){
			if(is_null($id)){
				$id=$this->id;
			}
			return $this->fecha;
		}
		public function getComprador($id=NULL){
			if(is_null($id)){
				$id=$this->id;
			}
			return $this->usuarios_id;
		}
		public function getAtributo($name,$id=NULL){
			if(is_null($id)){
				$id=$this->id;
			}
			return $this->$name;
		}			
		public function listarPorUsuario($tipo=1,$pagina=1,$orden="id desc",$usuario=NULL){
			//$bd = new bd();
			if(is_null($usuario)){
				if(!isset($_SESSION))
					session_start();
				$usuario=$_SESSION["id"];
			}
			
			if($tipo==1){    //Las ventas sin concretar
				$condicion="publicaciones_id in (select id from publicaciones where usuarios_id=$usuario) and c.publicaciones_id=p.id and (c.cantidad- (select COALESCE(sum(cantidad),0) from compras_envios where compras_publicaciones_id=c.id))<>0";
			}elseif($tipo==2){ //Las compras sin concretadas 
				$condicion="c.usuarios_id = $usuario and c.publicaciones_id=p.id and (c.cantidad- (select COALESCE(sum(cantidad),0) from compras_envios where compras_publicaciones_id=c.id))<>0";
			}elseif($tipo==3){ //Las ventas concretadas
				$condicion="publicaciones_id in (select id from publicaciones where usuarios_id=$usuario) and c.publicaciones_id=p.id and (c.cantidad- (select COALESCE(sum(cantidad),0) from compras_envios where compras_publicaciones_id=c.id))=0";				
			}elseif($tipo==4){ //Las compras concretadas
				$condicion="c.usuarios_id = $usuario and c.publicaciones_id=p.id and (c.cantidad- (select COALESCE(sum(cantidad),0) from compras_envios where compras_publicaciones_id=c.id))=0";
			}
			$inicio=($pagina - 1) * 25;
			$consulta="select c.*,p.titulo,p.monto,p.usuarios_id as vendedor, c.cantidad- (select sum(cantidad) from compras_envios where compras_publicaciones_id=c.id) as maximo from compras_publicaciones as c,publicaciones as p where $condicion order by $orden limit 25 OFFSET $inicio";
		//$consulta=	"select c.*,p.titulo,p.monto,p.usuarios_id as vendedor, 100 as maximo from compras_publicaciones as c,publicaciones as p order by $orden limit 25 OFFSET $inicio";
		//	var_dump($consulta);
			$result=$this->query($consulta);
			return $result;
		}
		public function contar($tipo=1,$usuario=NULL){
			if(is_null($usuario)){
				if(!isset($_SESSION))
					session_start();
				$usuario=$_SESSION["id"];
			}
			//$bd = new bd();
			if($tipo==1){    //Las ventas sin concretar
				$condicion="publicaciones_id in (select id from publicaciones where usuarios_id=$usuario) and c.publicaciones_id=p.id and (c.cantidad- (select COALESCE(sum(cantidad),0) from compras_envios where compras_publicaciones_id=c.id))<>0";
			}elseif($tipo==2){ //Las compras sin concretadas 
				$condicion="c.usuarios_id = $usuario and c.publicaciones_id=p.id and (c.cantidad- (select COALESCE(sum(cantidad),0) from compras_envios where compras_publicaciones_id=c.id))<>0";
			}elseif($tipo==3){ //Las ventas concretadas
				$condicion="publicaciones_id in (select id from publicaciones where usuarios_id=$usuario) and c.publicaciones_id=p.id and (c.cantidad- (select COALESCE(sum(cantidad),0) from compras_envios where compras_publicaciones_id=c.id))=0";				
			}elseif($tipo==4){ //Las compras concretadas
				$condicion="c.usuarios_id = $usuario and c.publicaciones_id=p.id and (c.cantidad- (select COALESCE(sum(cantidad),0) from compras_envios where compras_publicaciones_id=c.id))=0";
			}
			$consulta="select count(c.id) as tota from compras_publicaciones as c,publicaciones as p WHERE $condicion";	
	
			$result=$this->query($consulta);
			$row=$result->fetch();
			return $row["tota"];	
		}
		public function getStatusPago($id=NULL,$monto=NULL){
			if(is_null($id)){
				$id=$this->id;
			}
			if(is_null($monto)){
				
				$res=$this->doSingleSelect("publicaciones","id=$this->publicaciones_id","monto");
				//echo $this->id."hi";
				$monto=$res["monto"];
			}
			$result=$this->query("select (select COALESCE(sum(monto),0) from pagosxcompras where compras_publicaciones_id=$id and status_pago=2) as tota2,
									   (select COALESCE(sum(monto),0) from pagosxcompras where compras_publicaciones_id=$id and status_pago=3) as tota3");
			if($result){
				$row=$result->fetch();
				if($row["tota2"]==0){
					if($row["tota3"]==0){
						return "Pago pendiente";
					}else{
						return "Pago rechazado";
					}
				}elseif($row["tota2"]>=($monto - $this->descuento)){
					return "Pago verificado";
				}else{
					return "Pago incompleto";					
				}
			}else{
				return "Algo paso";
			}
		}
		public function getStatusEnvio($id=NULL){
			if(is_null($id)){
				$id=$this->id;
			}

			$consulta="select COALESCE(sum(cantidad),0) as tota from compras_envios where compras_publicaciones_id=$id";
			$result=$this->query($consulta);
			$row=$result->fetch();
			if($row["tota"]<=0){
				return "Envio pendiente";
			}elseif($row["tota"]<$this->cantidad){
				return "Envio en camino";
			}else{
				return "Enviado";
			}
		}
		public function getCantFaltante($id=NULL){
			if(is_null($id)){
				$id=$this->id;
			}
			return $this->cantidad;
		}
		public function getTiempoCompra($tipo=1,$id=NULL){
			if(is_null($id)){
				$id=$this->id;
			}
			if($tipo==1){
				$segundos=strtotime('now')-strtotime($this->fecha);
			}else{
				$result=$this->query("select fecha from compras_envios where compras_publicaciones_id=$id order by fecha desc limit 1");
				$row=$result->fetch();
				$segundos=strtotime($row["fecha"]) - strtotime($this->fecha);
			}
			$dias=intval($segundos/60/60/24);
			if($dias<1){
				$dias = intval($segundos/60/60);
				if($dias<1){
					$dias= intval($segundos/60);
					if($dias<1){
						$dias = $segundos;
						if($dias<60){
							if($dias==1){
								return " 1 segundo";
							}else{
								return " $segundos segundos";
							}
						}
					}elseif($dias<60){//minutos
						if($dias==1){
							return " 1 minuto";
						}else{
							return " $dias minutos";
						}
					}
				}elseif($dias<24){//horas
					if($dias==1){
						return " 1 hora";
					}else{
						return " $dias horas";
					}
				}
			}elseif($dias<=60){//dias
				if($dias==1)
					return " Ayer";
				else
					return " $dias dias";
			}			
		}
/*****************************END GETTING*************************************/
	}
?>