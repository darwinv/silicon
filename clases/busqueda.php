<?php
/*****************CLASE ENCARGADA DE TRATAR LAS BUSQUEDAS*********************/
/**
 * @property string palabra;
 * @property string orden;
 * @property int clasificados_id;
 * @property int pagina;
 * @property int codicion;
 */
include_once 'clasificados.php';
class busqueda extends bd{
	private $palabra;
	private $orden;
	private $clasificados_id;
	private $pagina;
	private $condicion;
	private $estados_id;
	public $listado;
/*************Constructor*******/	
	public function busqueda($parametros){
		parent::__construct();
		$this->palabra=$parametros["palabra"];
		$this->orden=array_key_exists("orden", $parametros)?$parametros["orden"]:"id desc";
		$this->clasificados_id=$parametros["clasificados_id"];
		$this->pagina=array_key_exists("pagina", $parametros)?$parametros["pagina"]:NULL;
		$this->condiciones_publicaciones_id=array_key_exists("condicion_publicaciones_id", $parametros)?$parametros["condiciones_publicaciones_id"]:NULL;
		$this->estados_id=array_key_exists("estados_id", $parametros)?$parametros["estados_id"]:NULL;
		$this->listado=$this->getPublicaciones();
	}
/************M&eacute;todos***********/
	public function getPublicaciones(){
		
		
		$condicion="where publicaciones.id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null)";
		
		$operador="and";
		if($this->palabra!=""){
			$condicion.=" $operador titulo like '%{$this->palabra}%'";
			$operador=" and ";
		}
		if($this->clasificados_id!=""){
			$criterio="I" . $this->clasificados_id . "F";
			$condicion .=$operador . " clasificados_id in (select id from clasificados where ruta like '%$criterio%')";
			$operador=" and ";			
		}
		
		#SI ENVIARON PALABRA, CREAMOS CRITERIO PARA FILTRAR LA BUSQUEDA
		if($this->palabra!=""){
			$criterio=explode(" ",$this->palabra);
			//$criterio2="(";
			$criterio3="(";
			foreach ($criterio as $c=>$valor) {
				//$criterio2.="nombre like '%$valor%' or apellido like '%$valor%' or ";
				$criterio3.="razon_social like '%$valor%' or ";
			}
			//$criterio2=substr($criterio2,0,strlen($criterio2)-4) . ")";
			$criterio3=substr($criterio3,0,strlen($criterio3)-4) . ")";			
			
			
		}
			
		#SI ENVIARON PALABRA o DESEAMOS VER LAS TIENDAS BUSCAMOS EN USUARIOS JURIDICOS
		/*if($this->palabra!="" || $this->ver_tiendas=='1'){
			
			#$consultaUsua=" union (select usuarios_id as id,identificacion,'U' as tipo,CONCAT(nombre,' ',apellido) as nombre from usuarios_naturales
			#				Inner Join usuarios ON usuarios_naturales.usuarios_id = usuarios.id
			#				where ($criterio2) and usuarios.id_sede =  '$id_sede')
			#			 	union (select usuarios_id as id,razon_social,'U' as tipo,razon_social as nombre from usuarios_juridicos
			#			 	Inner Join usuarios ON usuarios_juridicos.usuarios_id = usuarios.id
			#			 	where ($criterio3) and usuarios.id_sede =  '$id_sede')";
			$consultaUsua=" (select usuarios_accesos.usuarios_id as id,razon_social,'U' as tipo,razon_social as nombre from usuarios_juridicos
						 	Inner Join usuarios ON usuarios_juridicos.usuarios_id = usuarios.id
						 	Inner Join usuarios_accesos ON usuarios.id = usuarios_accesos.usuarios_id
						 	where ($criterio3) and usuarios.id_sede =  '$id_sede' AND
							usuarios_accesos.status_usuarios_id =  '1')  ";
		}else{
			$consultaUsua="";
		}*/
		 
		$consultaUsua="";
		#SI NO SE DESEA SOLO BUSCAR POR TIENDA
		
		if($condicion=="where ")
		$condicion="";
		switch($this->orden){
			case "id_asc":
				$orden="id asc";
				break;
			case "id_desc":
				$orden="id desc";
				break;
			case "monto_asc":
				$orden="monto asc";
				break;
			case "monto_desc":
				$orden="monto desc";
				break;
			default:
       			$orden="id desc";
				break;
		}
		
		$consultaPubli="(select  publicaciones.id,usuarios_id,'P' as tipo,titulo as nombre from publicaciones 
					Inner Join usuarios ON publicaciones.usuarios_id = usuarios.id
		$condicion order by {$orden})";
		
		
		
		
		
		 #SI EXISTEN LOS DOS QUERYS LOS UNIMOS
		if(!empty($consultaPubli) && !empty($consultaUsua)){
			$union='union';
		}
		else {
			$union='';
		}		
		
		#ARMAMOS EL QUERY
		$consulta="$consultaPubli $union $consultaUsua";

  
		#PARA PAGINAR
	 	if(!empty($this->pagina)){
	 		$this->pagina=$this->pagina?$this->pagina:"1";
			$inicio=($this->pagina - 1) * 25;
			$consulta.=" limit 25 OFFSET $inicio";
	 	}else{
	 		$consulta.=" limit 250 OFFSET 0";  //para asegurar no traer mas de 1000productos para un solo listado
	 	}
		   //var_dump($consulta);
		$publicaciones=$this->query($consulta);
		return $publicaciones;
	}
	public function getUsuarios(){
		
		if($this->palabra!=""){
			$criterio=explode(" ",$_POST["palabra"]);
			$criterio2="(";
			$criterio3="(";
			foreach ($criterio as $c=>$valor) {
				$criterio2.="nombre like '%$valor%' or apellido like '%$valor%' or ";
				$criterio3.="razon_social like '%$valor%' or ";
			}
			$criterio2=substr($criterio2,0,strlen($criterio2)-4) . ")";
			$criterio3=substr($criterio3,0,strlen($criterio3)-4) . ")";			
			$consulta="(select usuarios_id as id,'U' as tipo from usuarios_naturales where $criterio2)
				 union (select usuarios_id as id,'U' as tipo from usuarios_juridicos where $criterio3";
			$usuarios=$this->query($consulta);
			return $usuarios;
		}else{
			return false;
		}
	}	
	public function getEstados(){
  		
		 $est=$this->doFullSelect("estados");
		 $lista=array();
		 $i=1;
		 foreach($est as $e=>$valor){
		 		$lista[$i]["id"]=$valor["id"];
			  	$lista[$i]["nombre"]=$valor["nombre"];				
				$lista[$i]["totaP"]=0;
				$i++;
		 }		  
		 $anterior="";
		 foreach($this->listado as $l=>$valor){
		 		if($valor["tipo"]=="P"){
		  			if($valor["usuarios_id"]!=$anterior){
		  				$anterior=$valor["usuarios_id"];
						$r=$this->doSingleSelect("usuarios","id={$valor["usuarios_id"]}");
						$actual=$r["estados_id"];
					}
		  		}else{
		  			if($valor["id"]!=$anterior){
		  				$anterior=$valor["id"];
						$r=$this->doSingleSelect("usuarios","id={$valor["id"]}");
						$actual=$r["estados_id"];
					}
		  		}
				$lista[$actual]["totaP"]++;
		 }  
		 return $lista;
	}
	public function getRuta(){
		$devolver="";
		if($this->clasificados_id!=""){
			$clasificado=new clasificados($this->clasificados_id);
			$devolver .=$clasificado->getAdressWithLinks($this->palabra);
		}
		if($this->palabra!="")
		$devolver .="'$this->palabra'";
		return $devolver;
	}
	public function getPaginas(){
		
	}
	public function getCategorias(){
  		
		if($this->clasificados_id==""){
		 	$cla=$this->doFullSelect("clasificados","clasificados_id<=4 and clasificados_id is not null order by nombre");
		}else{
			$cla=$this->doFullSelect("clasificados","clasificados_id=$this->clasificados_id order by nombre");
		}
		$lista=array();
		if(is_array($cla)){	 	 
		 foreach($cla as $c=>$valor){
		 		$i=$valor["id"];
		 		$lista[$i]["id"]=$valor["id"];
			  	$lista[$i]["nombre"]=$valor["nombre"];
				$criterio="I" . $valor["id"] . "F";
				$condicion="where id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null)";
				if($this->palabra!="")
				$condicion .=" and titulo like '%{$this->palabra}%'";
				$consulta="select count(id) as totaC from publicaciones $condicion and clasificados_id in (select id from clasificados where 
							ruta like '%$criterio%')";
				$r=$this->query($consulta);
				$row=$r->fetch();
				$lista[$i]["totaC"]=$row["totaC"];
		 }	
		}	  
		 return $lista;
	}
	public function getCondiciones(){
		
		$condicion="where id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin is null)";
		$operador="and";
		if($this->palabra!=""){
			$condicion.=" $operador titulo like '%{$this->palabra}%'";
			$operador=" and ";			
		}
		if($this->clasificados_id!=""){
			$criterio="I" . $this->clasificados_id . "F";
			$condicion .=$operador . " clasificados_id in (select id from clasificados where ruta like '%$criterio%')"; //ojo
			$operador=" and ";
		}
		$consulta="select (select count(id) from publicaciones $condicion and condiciones_publicaciones_id=1) as tota1,
    				(select count(id) from publicaciones $condicion and condiciones_publicaciones_id=2) as tota2,
    				(select count(id) from publicaciones $condicion and condiciones_publicaciones_id=3) as tota3";
		$r=$this->query($consulta);
		if($r){
			return $r->fetch();
		}else{
			return false;
		}
	}
	public function getParametros(){
		$devolver="";
		$devolver.="palabra={$this->palabra}<br>";
		$devolver.="pagina={$this->pagina}<br>";
		$devolver.="esatdos_id={$this->estados_id}<br>";
		return $devolver;
	}
}
?> 