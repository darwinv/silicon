<?php
include_once 'fotos.php';
require_once __DIR__ .'/manager/autoload.php';
use OneAManager\Handler_Soat;

/**
 * @property string table
 * @property int id
 * @property string titulo;
 * @property string descripcion;
 * @property int stock;
 * @property int dias_garantia;
 * @property boolean dafactura;
 * @property boolean estienda;
 * @property int visitas_publicaciones_id;
 * @property int vencimientos_publicaciones_id;
 * @property int usuarios_id; 
 * @property int condiciones_publicaciones_id;
 * @property double monto;
 */
class publicaciones extends bd {
	protected $table="publicaciones";
	private $id;
	private $titulo;
	private $descripcion;
	private $stock;
	private $dias_garantia;
	private $dafactura;
	private $estienda;
	private $visitas_publicaciones_id;
	private $vencimientos_publicaciones_id;
	private $usuarios_id;
	private $condiciones_publicaciones_id;
	private $clasificados_id;
	private $monto;
	public function publicaciones($id = NULL){
		parent::__construct();
		if(!is_null($id)){
			$this->buscarPublicacion($id);
		}
	}
	public function nuevaPublicacion($params,$monto,$fecha,$fotos){
		
		$foto = new fotos();
		$idVisita = $this->setVisitas();
		$params["visitas_publicaciones_id"] = $idVisita;
		$params["monto"] =$monto;
		$largo=strlen($params["titulo"]);
		$params["titulo"] = strtoupper(substr($params["titulo"],0,1)) . strtolower(substr($params["titulo"],1,$largo-1));
		// ucwords(strtolower($params["titulo"]));
		$result = $this->doInsert($this->table, $params);
		//return $result;
		if($result){
			$this->id = $this->lastInsertId();
			$hso = new Handler_Soat();
			$soat_params=array(
				"u"=>"http://apreciodepana.com/detalle.php?id=".$this->id,
				"abid"=>$params['usuarios_id'],
				"absid"=>"0",
			);
			$short_url=$hso->encode($soat_params);
			$this->setMonto($monto);
			$this->setStatus(1,1,$fecha);
			$foto->path = "../../".$foto->path;
			foreach($fotos as $data){
				$foto->crearFotoPublicacion($this->id, $data);
			}
			$result=$this->doUpdate($this->table,array("short_id"=>$short_url),"id=$this->id");
			return $this->id;
		}else{
			return false;
		}
	}
	public function buscarPublicacion($id){
		$this->id = $id;
		
		$result = $this->doSingleSelect($this->table,"id = {$this->id}");
		if($result){
			$valores["id"] = $result["id"];
			$valores["titulo"] = $result["titulo"];
			$valores["descripcion"] = $result["descripcion"];
			$valores["stock"] = $result["stock"];
			$valores["dias_garantia"] = $result["dias_garantia"];
			$valores["dafactura"] = $result["dafactura"];
			$valores["estienda"] = $result["estienda"];
			$valores["visitas_publicaciones_id"] = $result["visitas_publicaciones_id"];
			$valores["vencimientos_publicaciones_id"] = $result["vencimientos_publicaciones_id"];
			$valores["usuarios_id"] = $result["usuarios_id"];
			$valores["condiciones_publicaciones_id"] = $result["condiciones_publicaciones_id"];
			$valores["clasificados_id"]=$result["clasificados_id"];
			$valores["monto"]=$result["monto"];
			$this->setPublicacion($valores);
			return true;
		}else {
			return false;
		}
	}
	public function setPublicacion($params){
		if(!empty($params)){
			foreach ($params as $key => $values){
				$this->$key = $values;
			}
			return true;
		}else{
			throw "Error Publicar 001: No se recibieron parametros";
			return false;
		}
	}
	public function __get($property) {
		if (property_exists ( $this, $property )) {
			return $this->$property;
		}
	}
	
	public function setLastShare($id,$time){
		
		$actualizar = array("last_share"=>$time);
		$condicion = "id = {$id}";
		$this->doUpdate("publicaciones", $actualizar , $condicion);
	}
	
	public function setMonto($monto){
		
		$tiempo = date("Y-m-d H:i:s",time());
		$actualizar = array("fecha_fin"=>$tiempo);
		$condicion = "publicaciones_id = {$this->id} AND fecha_fin IS NULL";
		$this->doUpdate("publicaciones_montos", $actualizar , $condicion);
		$valores = array("monto"=>$monto,"publicaciones_id"=>$this->id, "fecha" => $tiempo);
		$this->doInsert("publicaciones_montos",$valores);
	}
	public function setStatus($sta_nue=NULL,$sta_ant=NULL,$fecha=NULL){
		if(is_null($fecha)){
			$fecha = time();
		}else{
			$fecha = strtotime($fecha);			
		}
		$sta_ant=is_null($sta_ant)?1:$sta_ant;
		$sta_nue=is_null($sta_nue)?2:$sta_nue;
		
		$tiempo=date("Y-m-d H:i:s",$fecha);
		$actualizar = array("fecha_fin"=>$tiempo);
		$condicion = "publicaciones_id = {$this->id} AND fecha_fin IS NULL";
		$this->doUpdate("publicacionesxstatus",$actualizar,$condicion);
		$valores=array("fecha"=>$tiempo,"publicaciones_id"=>$this->id,"status_publicaciones_id"=>$sta_nue);
		$this->doInsert("publicacionesxstatus", $valores);
	}
	public function setVisitas(){
		
		$valores=array("numero"=>0);
		$this->doInsert("visitas_publicaciones",$valores)	;
		return $this->lastInsertId();
	}
//	public 
	public function updateVisitas(){
		
		$total=$this->getVisitas();
		$total++;
		$actualizar=array("numero"=>$total);
		$condicion="id={$this->visitas_publicaciones_id}";
		$this->doUpdate("visitas_publicaciones",$actualizar,$condicion);		
		return "visita";
	}
	
	public function setPreguntas($pregunta,$id=NULL){
		
		session_start();
		$tiempo = date("Y-m-d H:i:s",time());
		$valores=array(
			"contenido"=>$pregunta,
			"publicaciones_id"=>$this->id,
			"usuarios_id"=>$_SESSION["id"],
			"preguntas_publicaciones_id"=>$id,
			"fecha"=>$tiempo
		);	
		$this->doInsert("preguntas_publicaciones",$valores);	
		$nuevoid=$this-> lastInsertId();
		return $nuevoid;
	}
	
	public function setNotificacion($id=NULL,$tipo=NULL,$id_usr=NULL,$nuevoid){
		if($id==null)
			$id=$this->id;
		
		if(!isset($_SESSION["id"]))
		session_start();
		if($id_usr==null){
			$id_usr = $_SESSION["id"];
		}
		
		$tiempo = date("Y-m-d H:i:s",time());
		$notificacion=array(
			"fecha"=>$tiempo,
			"tipos_notificaciones_id"=>$tipo,
			"usuarios_id"=>$id_usr,
			"publicaciones_id"=>$id,
			"preguntas_publicaciones_id"=> $nuevoid
		);
		$not = $this->doInsert("notificaciones",$notificacion);	
		
	}

	
	public function getMonto($admin=0){
		
		if($admin==0){
			$consulta="select * from clasificados where ruta like '%I4F%' and id=$this->clasificados_id";
			$result=$this->query($consulta);
			foreach ($result as $r => $valor) {
				return "Consultar";
			}
	}
//		$strCondicion="publicaciones_id = $this->id AND fecha_fin IS NULL";
		$strCondicion="id = $this->id";		
		$result=$this->doSingleSelect("publicaciones"," $strCondicion ","monto");
		$parteEntera=floor($result["monto"]);
		$parteDecimal=$result["monto"] - $parteEntera;
		$parteDecimal=floor($parteDecimal*100);
		if($parteDecimal<10){
			$parteDecimal="0" . $parteDecimal;
		}
		return "Bs " . number_format($parteEntera,0,',','.') . " <sup>" . $parteDecimal . "</sup>";
//		return number_format($result["monto"],0,",",".") . " <sup>" . $parteDecimal . "</sup>";
	}
	public function getFechaStatus(){
		
		$strCondicion="publicaciones_id=$this->id AND fecha_fin IS NULL";
		$result=$this->doSingleSelect("publicacionesxstatus"," $strCondicion ","fecha");
		return $result["fecha"];
	}
	public function getVisitas(){
		
		$strCondicion="id=$this->visitas_publicaciones_id";
		$result=$this->doSingleSelect("visitas_publicaciones"," $strCondicion ","numero");
		return $result["numero"];
	}
	public function getExpiredDate(){
		
		$strCondicion="id=$this->vencimientos_publicaciones_id";
		$result=$this->doSingleSelect("vencimientos_publicaciones"," $strCondicion ","dias");
		$dias=$result["dias"];
		$strCondicion="publicaciones_id=$this->id order by fecha asc";
		$result=$this->doFullSelect("publicacionesxstatus"," $strCondicion ","fecha");
		$fecha=date("Y-m-d",strtotime("{$result[0]["fecha"]} +$dias days"));
		return $fecha . "\n";	
	}	
	public function getTiempoGarantia(){
		if($this->dias_garantia==NULL){
			return "El articulo no cuenta con <span class='negro'>Garantia </span>";
		}else{
			return $this->dias_garantia . "<span class='negro'> Garantia </span>";
		}
	}
	
	public function getTiempoPublicacion(){
		
		$strCondicion="publicaciones_id=$this->id";
		$result=$this->doSingleSelect("publicacionesxstatus"," $strCondicion ","fecha");
		$segundos=strtotime('now')-strtotime($result["fecha"]);
		$dias=intval($segundos/60/60/24);
		if($dias<1){
			$dias = intval($segundos/60/60);
			if($dias<1){
				$dias= intval($segundos/60);
					if($dias<1){
						$dias = $segundos;
						if($dias<60){
							if($dias==1){
								return " 1 s";
							}else{
								return " $segundos s";
							}
						}
					}elseif($dias<60){//minutos
						if($dias==1){
							return " 1 m";
						}else{
							return " $dias m";
						}
					}
			}elseif($dias<24){//horas
				if($dias==1){
					return " 1 h";
				}else{
					return " $dias h";
				}
			}
		}elseif($dias<=30){//dias
			if($dias==1)
				return " Ayer";
			else
				return " $dias d";	
		}	
	}
	/*public function getTiempoPublicacion(){		
				
		$strCondicion="publicaciones_id=$this->id";		
		$result=$this->doSingleSelect("publicacionesxstatus"," $strCondicion ","fecha");		
		$segundos=strtotime('now')-strtotime($result["fecha"]);		
		return $this -> getTiempo($segundos);		
	}*/
	
	public function getFotos(){
		
		$condicion="publicaciones_id=$this->id";
		$result=$this->doFullSelect("fotosxpublicaciones",$condicion);
		if(!empty($result)){
			foreach ($result as $r) {
				 $busqueda=$this->doSingleSelect("fotos","id={$r['fotos_id']}","ruta");			 
				 $rutas[]=$busqueda["ruta"].$r["fotos_id"].".png";
			}
			return $rutas;
		}else{
			return false;
		}
	}
	public function getFotoPrincipal(){
		
		$condicion="publicaciones_id=$this->id order by fotos_id";
		$result=$this->doSingleSelect("fotosxpublicaciones",$condicion);
 		$busqueda=$this->doSingleSelect("fotos","id={$result['fotos_id']}","ruta");
		$r=$busqueda["ruta"].$result["fotos_id"].".png";
		return $r;
	}
	public function getCondicion(){
		
		$condicion="id=$this->condiciones_publicaciones_id";
		$result=$this->doSingleSelect("condiciones_publicaciones",$condicion,"condicion");
		if($result){
			return $result["condicion"];
		}else{
			return "Error desconocido";
		}
	}
	
	public function getRespuestaPregunta($id_pregunta){
		
        $condicion="preguntas_publicaciones_id=$id_pregunta";
		$result=$this->doSingleSelect("preguntas_publicaciones",$condicion,"contenido,fecha");
		$segundos=strtotime('now') - strtotime($result["fecha"]);
		$dias=intval($segundos/60/60/24);
		if($dias<1){
			$dias = intval($segundos/60/60);
			if($dias<1){
				$dias= intval($segundos/60);
					if($dias<1){
						$dias = $segundos;
						if($dias<60){
							if($dias==1){
								$tiempo = "		1 s";
							}else{
							$tiempo = "		$segundos s";
							}
						}
					}elseif($dias<60){
						if($dias==1){
							$tiempo = "		1 m";
						}else{
							$tiempo = " 	$dias m";
						}
					}
			}elseif($dias<24){
				if($dias==1)
					$tiempo = " 	1 h";
				else{
					$tiempo = " 	$dias h";
				}
			}
		}elseif($dias<=30){
			if($dias==1)
				$tiempo = "		Ayer";
			else
			$tiempo = " 	$dias d";	
		}
		
				
		if(!empty($result)){
			$devolver[0]=$result["contenido"];
			$devolver[1]=$tiempo;
		}else{
			$devolver[0]="";
			$devolver[1]="";
		}
		return $devolver;
	}
	
	public function getPreguntasUsuario(){
		
		$condicion="usuarios_id=$this->usuarios_id";
        $resultado=array();
		$result=$this->doFullSelect("publicaciones",$condicion,"id,titulo");
		$i=-1;
		foreach ($result as $r) {
			$i++;
			$resultado[$i]=array("publicacion_id"=>$r["id"],"titulo"=>$r["titulo"]);
            $result2=$this->query("SELECT * FROM preguntas_publicaciones p WHERE preguntas_publicaciones_id IS NULL and publicaciones_id={$r['id']} and NOT EXISTS (SELECT * FROM preguntas_publicaciones r WHERE r.preguntas_publicaciones_id = p.id)");			
			if(!empty($result2)){
				foreach ($result2 as $row){
					$condicion="usuarios_id={$row["usuarios_id"]}";
					$usuario=$this->doSingleSelect("usuarios_accesos",$condicion);
					$resultado[$i]["preguntas"][]=array("pregunta"=>$row["contenido"],"usuario"=>$usuario["seudonimo"]);
				}
			}else{	
				$resultado[]="id de publicaci�n:" . $r["id"] . " Titulo:" . $r["titulo"] . "Pregunta por responder ninguna";
			}
		}
		return $resultado;
	}

	public function getPreguntasPublicacion($id = NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		
		$preguntas=array();
		$condicion="publicaciones_id=$id AND preguntas_publicaciones_id IS NULL";
        $result=$this->query("SELECT * FROM preguntas_publicaciones WHERE preguntas_publicaciones_id IS NULL and publicaciones_id=$id and status <> 2 order by fecha desc");	
        foreach ($result as $r){
        $segundos=strtotime('now') - strtotime($r["fecha"]);
		$tiempo = $this -> getTiempo($segundos);
        	$preguntas[]=array("id"=>$r["id"],"pregunta"=>$r["contenido"],"pre_pub_id"=>$r["preguntas_publicaciones_id"],"usuario"=>$r["usuarios_id"],"tiempo"=>$tiempo);
  		}
		return $preguntas;
	}
	
		public function getPreguntasCompra($id = NULL, $usr_id = null){
		if(is_null($id)){
			$id=$this->id;
		}
		
		$preguntas=array();
		$condicion="publicaciones_id=$id AND preguntas_publicaciones_id IS NULL";
        $result=$this->query("SELECT * FROM preguntas_publicaciones WHERE preguntas_publicaciones_id IS NULL and publicaciones_id=$id and usuarios_id=$usr_id order by fecha desc");	
        foreach ($result as $r){
        	$preguntas[]=array("id"=>$r["id"],"pregunta"=>$r["contenido"],"pre_pub_id"=>$r["preguntas_publicaciones_id"],"usr_id"=>$r["usuarios_id"]);
  		}
		return $preguntas;
	}
	
	public function getPreguntasActivas($id = NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		
		$preguntas=array();
		$condicion="publicaciones_id=$id AND preguntas_publicaciones_id IS NULL";
        $result=$this->query("select * from preguntas_publicaciones pp, usuarios_accesos u where pp.usuarios_id=u.usuarios_id and 
        id not in (SELECT preguntas_publicaciones_id FROM `preguntas_publicaciones` WHERE preguntas_publicaciones_id is not null) 
        and pp.preguntas_publicaciones_id is NULL and pp.publicaciones_id=$id order by fecha");	
        foreach ($result as $r){
        $segundos=strtotime('now') - strtotime($r["fecha"]);
		$tiempo = $this -> getTiempo($segundos);			
        	$preguntas[]=array("id"=>$r["id"],"pregunta"=>$r["contenido"],"pre_pub_id"=>$r["preguntas_publicaciones_id"],"usr_id"=>$r["usuarios_id"],'nombre'=>$r["seudonimo"],'tiempo'=>$tiempo);
  		}
		return $preguntas;
	}
	

	public function listarPublicaciones($criterios=NULL){		
		
		if(!is_null($criterios)){			
			$condicion="";
			foreach ($criterios as $r=>$valor) {
				$condicion.=$r . $valor . " AND ";
			}
			$condicion=substr($condicion,0,strlen($condicion)-4);
	        $result=$this->doFullSelect("publicaciones",$condicion);
			if(!empty($result)){
				return $result;
			}else{		
				return false;
			}
	        	        
		}else{	
			$result=$this->doFullSelect("publicaciones");
			if(!empty($result)){
				return $result;
			}else{
				return false;
			}
		}
	}
	public function getTienda(){
		if($this->estienda=="S"){
			return "El vendedor es ";
		}else{
			return "El vendedor no es ";
		}
	}
	public function getFactura(){
		if($this->dafactura=="S"){
			return "El vendedor entrega ";
		}else{
			return "El vendedor no entrega ";
		}
	}
	public function getFavoritos($devuelveVacio=false){
		
		$consulta="select count(*) as tota from publicaciones_favoritos where visitas_publicaciones_id=$this->visitas_publicaciones_id";
		$result=$this->query($consulta);
		if(!empty($result)){
			foreach ($result as $key => $value) {
				if($value["tota"]>0){
			    	return $value["tota"];
				}else{
					if($devuelveVacio){
						return "";
					}else{
						return "0";
					}
				}
			}
		}else{
			return "";
		}
	}
	public function isFavorito($id=NULL){
		
		if(is_null($id)){
			$id=$this->id;
		}
		$consulta="select * from publicaciones_favoritos where 
		usuarios_id={$_SESSION['id']} and visitas_publicaciones_id in (select visitas_publicaciones_id from publicaciones where id=$id)";
		$result=$this->query($consulta);
		if(!empty($result)){
			foreach ($result as $r => $valor) {
				return true;
			}
		}
		return false;
	}
	public function getCompartidos($tipo){
		//Si tipo=1 devuelve las veces compartido en facebook
		//Si tipo=2 devuelve las veces compartido en twitter
		//Si tipo=3 devuelve la suma de los 2
		
		$condicion="";
		$condicion="id=$this->visitas_publicaciones_id";
		$result=$this->doSingleSelect("visitas_publicaciones",$condicion);
		if(!empty($result)){
			switch($tipo){
				case 1:
					return $result["compartirf"];
					break;
				case 2:
					return $result["compartirt"];
					break;
				case 3:
					return $result["compartirf"] + $result["compartirt"];
					break;
			}				
		}else{
			return false;
		}	
	}
	public function tituloFormateado($longitud=17){
		$devolver=(strlen($this->titulo)<=$longitud?$this->titulo:substr($this->titulo,0,$longitud) . "...");
		return $devolver;
	}
	public function getFotoN($n){
		
		$condicion="publicaciones_id=$this->id";
		$result=$this->doFullSelect("fotosxpublicaciones",$condicion);
		if(!empty($result)){
			$contador=0;
			foreach ($result as $r) {
				 $contador++;
				 $busqueda=$this->doSingleSelect("fotos","id={$r['fotos_id']}","ruta");			 
				 $ruta=$busqueda["ruta"].$r["fotos_id"].".png";
				 if($contador==$n){
				 	break;
				 }
			}
			if($contador>=$n){
				return $ruta;
			}else{
				return "";
			}
				
		}else{
			return false;
		}
	}
	public function actualizarPublicacion($parametros,$monto,$fotos){
		
		$foto = new fotos();
		$condicion="id=$this->id";
		$params["titulo"] = ucwords(strtolower($params["titulo"]));
		$result=$this->doUpdate("publicaciones",$parametros,$condicion);
		$params["monto"]=$monto;
		$this->setMonto($monto);
		$foto->path = "../../".$foto->path;
		$listaFotos=$this->doFullSelect("fotosxpublicaciones","publicaciones_id=$this->id");
		$result=$this->query("delete from fotosxpublicaciones where publicaciones_id=$this->id");
		$ultimafoto=$this->query("select MAX(id) as ultimo from fotos");
		foreach ($ultimafoto as $key) {
			$ultima=$key["ultimo"];
		}		
		$i=0;
		$fila=0;
		foreach($fotos as $data){
			if(substr($data,0,10)=="data:image"){
				$i++;
				$nueva=$ultima + $i;
				$data_url=$data;
				$data_url = str_replace(" ", "+", $data_url);
				$filteredData=substr($data_url, strpos($data_url, ",")+1);			
				//Decodificar la dataurl
				$unencodedData=base64_decode($filteredData);
				$this->doInsert("fotos",array("id"=>$nueva,"ruta"=>"galeria/fotos/2015/12/"));
				$this->doInsert("fotosxpublicaciones",array("fotos_id"=>$nueva,"publicaciones_id"=>$this->id));
				//subir la imagen
				$ruta="../../../galeria/fotos/2015/12/{$nueva}.png";
				file_put_contents($ruta, $unencodedData);
			}else{				
				$this->doInsert("fotosxpublicaciones",array("fotos_id"=>$listaFotos[$fila]["fotos_id"],"publicaciones_id"=>$listaFotos[$fila]["publicaciones_id"]));
				$fila++;
			}
		}
		return true;
	}
	public function volveraPublicar($parametros){
				 
		$parametros["descripcion"]=$this->descripcion;
		$parametros["dias_garantia"]=$this->dias_garantia;
		$parametros["dafactura"]=$this->dafactura;
		$parametros["estienda"]=$this->estienda;
		$parametros["visitas_publicaciones_id"]=$this->visitas_publicaciones_id;
		$parametros["usuarios_id"]=$this->usuarios_id;
		$parametros["condiciones_publicaciones_id"]=$this->condiciones_publicaciones_id;
		$parametros["monto"]=$this->monto;
		$parametros["clasificados_id"]=$this->clasificados_id;
		$parametros["vencimientos_publicaciones_id"]=$this->vencimientos_publicaciones_id;
		$parametros["titulo"] = ucwords(strtolower($parametros["titulo"]));
		$result = $this->doInsert($this->table, $parametros);
		if($result){
			$ultimoId=$this->lastInsertId();
			$tiempo = date("Y-m-d H:i:s",time());			
			$this->doInsert("publicaciones_montos",array("fecha"=>$tiempo,"monto"=>$parametros["monto"],"publicaciones_id"=>$ultimoId));
			$this->doInsert("publicacionesxstatus",array("fecha"=>$tiempo,"publicaciones_id"=>$ultimoId,"status_publicaciones_id"=>1));
			$fotos=$this->doFullSelect("fotosxpublicaciones","publicaciones_id=$this->id","fotos_id");
			foreach($fotos as $f){
				$this->doInsert("fotosxpublicaciones",array("fotos_id"=>$f['fotos_id'],"publicaciones_id"=>$ultimoId));
			}
			return $result;
		}
	}
	public function getTiempo($segundos){
		$dias=intval($segundos/60/60/24);
			if($dias<1){
			$dias = intval($segundos/60/60);
			if($dias<1){
				$dias= intval($segundos/60);
					if($dias<1){
						$dias = $segundos;
						if($dias<60){
							if($dias==1){
								return " 1 s";
							}else{
								return " $segundos s";
							}
						}
					}elseif($dias<60){//minutos
						if($dias==1){
							return " 1 m";
						}else{
							return " $dias m";
						}
					}
			}elseif($dias<24){//horas
				if($dias==1){
					return " 1 h";
				}else{
					return " $dias h";
				}
			}
		}elseif($dias<=30){//dias
			if($dias==1)
				return " Ayer";
			else
				return " $dias d";	
		}	
	}


	}