<?php
class clasificados extends bd{
	protected $table = "clasificados";
	private $id;
	private $nombre;
	private $clasificados_id;
    private $ruta;
	public function clasificados($id = NULL){
		parent::__construct();
		if(!is_null($id)){
			$this->buscarClasificado($id);
		}
	}
	public function crearClasificado($id, $nombre, $padre = NULL,$ruta=NULL){
		
		$valores["id"] = $id;
		$valores["nombre"] = $nombre;
		$valores["clasificados_id"] = $padre;
		$valores["ruta"] = $ruta;
		if($this->doInsert($this->table, $valores)){
			return true;
		}else{
			return false;
		}
	}
	public function buscarClasificado($id){
		
		$row = $this->doSingleSelect($this->table,"id = $id order by orden,nombre");
		if($row){
			$this->setClasificado($row["id"], $row["nombre"], $row["clasificados_id"], $row["ruta"]);
			return true;
		}else {
			return false;
		}
	}
	public function buscarHijos($id=NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		
		$condicion=" clasificados_id=$id  order by orden,nombre";
		$filas=$this->doFullSelect("clasificados",$condicion);
		if(!empty($filas)){
			return $filas;
		}else{
			return false;
		}		
	}
	public function buscarPadresdeHijos($id=NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		
		$condicion=" id in ($id)  order by orden,nombre";
		$filas=$this->doFullSelect("clasificados",$condicion);
		 
		if(!empty($filas)){
			return $filas;
		}else{
			return false;
		}		
	}
	public function setClasificado($id,$nombre,$clasificados_id,$ruta){
		$this->id = $id;
		$this->nombre = $nombre;
		$this->clasificados_id = $clasificados_id;
		$this->ruta = $ruta;
	}
	public function getAdressWithLinks($palabra=NULL,$id=NULL){
		if(is_null($id)){
			$id=$this->id;
		}
		if(is_null($palabra)){
			$palabra="";
		}
		
		$inicioHtml = "<span id='categoriaNombre'>";
		$finHtml = "</span><i class='fa fa-angle-right' style='color:#000;' ></i>";
        $row = $this->doSingleSelect("clasificados","id= $id");
        $cadena = "";
		$contador=0;
        while($row["clasificados_id"] != NULL){
        	$nombre=$row["nombre"];
			if($contador>0){
			    $cadena = "{$inicioHtml} <a href='listado.php?id_cla={$row["id"]}'> {$nombre} </a> {$finHtml}  $cadena";			    
			}else{
				$cadena = "{$inicioHtml} <a href='listado.php?id_cla={$row["id"]}'> {$nombre} </a> </span>" . $cadena;
			}
			$contador++;
           	$row = $this->doSingleSelect("clasificados","id= {$row["clasificados_id"]}");
		}
        if($palabra!=""){
        	$cadena=$cadena .  "'" . $palabra . "'";
        }
//	    $cadena = "{$inicioHtml} <a href='listado.php?id_cla={$row["id"]}'> {$row["nombre"]} </a> {$finHtml}$cadena";	
		return $cadena;
	}
	public function getAdress($id=NULL){
		if(is_null($id)){
			$id=$this->id;
		}		
		
		$inicioHtml = "<span id='categoriaNombre'>";
		$finHtml = "</span><i class='fa fa-angle-right' style='color:#000;' ></i>";
        $row = $this->doSingleSelect("clasificados","id= $id");
        $cadena = "";
		$contador=0;
        while($row["clasificados_id"] != NULL){
        	$nombre=$row["nombre"];
			if($contador>0){
			    $cadena = "{$inicioHtml} {$nombre} {$finHtml}$cadena";
			}else{
				$contador++;
				$cadena = "{$inicioHtml} {$nombre}" . "</span>" . $cadena;
			}
           	$row = $this->doSingleSelect("clasificados","id= {$row["clasificados_id"]}");
		}
        $cadena = "{$inicioHtml} {$row["nombre"]} {$finHtml}$cadena";		
		return $cadena;
	}
	//Buscar las publicaciones y por estado en una sola funci&oacute;n, devolviendo un arreglo con dos conjuntos
	//el primer conjunto las categorias y el segundo los estados
	
	public function getHijosCondicionado($id=NULL,$criterioOrden=NULL,$pagina=NULL,$id_est=NULL,$condicion=NULL){			
    	if(is_null($id)){
    		$id=$this->id;
    	}
		if(is_null($pagina)){
			$pagina=1;
		}
		if(is_null($criterioOrden)){
			$criterioOrden="id desc";
		}elseif($criterioOrden=="id_asc"){
			$criterioOrden="id asc";
		}elseif($criterioOrden=="id_desc"){
			$criterioOrden="id desc";
		}elseif($criterioOrden=="monto_desc"){
			$criterioOrden="monto desc";
		}elseif($criterioOrden=="monto_asc"){
			$criterioOrden="monto asc";
		}
		$strCondicion=is_null($condicion)?"":" and condiciones_publicaciones_id=$condicion";
//		echo $criterioOrden;
		
		$clasif=$this->buscarHijos($id);
		$devolverCat=array();
		$devolver=array();
		$resultadoEstados=$this->doFullSelect("estados");
		foreach ($resultadoEstados as $estado => $valorEstado) {
			$estados[]=array("id"=>$valorEstado["id"],"nombre"=>$valorEstado["nombre"],"cantidad"=>0);
		}
		$anterior=0;
		if(!empty($clasif)){
			foreach ($clasif as $key => $valor) {
				$criterio="I" . $valor["id"] . "F";
				if(is_null($id_est)){
					$consulta="select count(*) as tota,clasificados_id,usuarios_id from publicaciones where	clasificados_id in (select id from clasificados where ruta like '%$criterio%')
					$strCondicion and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and  fecha_fin IS NULL) group by clasificados_id,usuarios_id order by clasificados_id";
				}else{
					$consulta="select count(*) as tota,clasificados_id,usuarios_id from publicaciones where usuarios_id in (select usuarios.id from usuarios,estados where usuarios.estados_id=estados.id and estados.id=$id_est) 
					$strCondicion and clasificados_id in (select id from clasificados where ruta like '%$criterio%')
					and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL) group by clasificados_id,usuarios_id order by clasificados_id";
				}
				$ac=0;
				$ac2=0;
				$rows=$this->query($consulta);
				foreach ($rows as $row => $valor2) {
					$consulta="id={$valor2["usuarios_id"]}";
					$resultadoUsuarios=$this->doSingleSelect("usuarios",$consulta,"estados_id");
					$ac+=$valor2["tota"];
					$estados[$resultadoUsuarios["estados_id"]-1]["cantidad"]+=$ac;
					$ac2+=$ac;
					$ac=0;
				}
				if($ac2>0){
					$devolverCat[]=array("nombre"=>$valor["nombre"],"cantidad"=>$ac2,"id"=>$valor["id"]);
				}
			}
		}else{
			$ac=0;
			$consulta="select count(*) as tota,clasificados_id,usuarios_id from publicaciones where clasificados_id=$id and 
			id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)	$strCondicion group by clasificados_id,usuarios_id order by clasificados_id";
			$resultado=$this->query($consulta);
			foreach ($resultado as $key => $valor) {
				$consulta="id={$valor["usuarios_id"]}";
				$resultadoUsuarios=$this->doSingleSelect("usuarios",$consulta,"estados_id");
				foreach ($estados as $estado => $valorEstado) {
					if($valorEstado["id"]==$resultadoUsuarios["estados_id"]){
						$estados[$estado]["cantidad"]+=$valor["tota"];
						break;
					}
				}
			}
		}
    	foreach ($estados as $estado => $valorEstado) {
			if($valorEstado["cantidad"]>0){
				$devolver[]=array("nombre"=>$valorEstado["nombre"],"cantidad"=>$valorEstado["cantidad"],"id"=>$valorEstado["id"]);
			}
		}
		$criterio="I" . $id . "F";		
		if(is_null($id_est)){
            if($pagina==1){
            	$consulta="select * from publicaciones where clasificados_id in (select id from clasificados where ruta like '%$criterio%') $strCondicion and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL) order by $criterioOrden limit 25";

				$consultaNuevos="select count(*) as tota from publicaciones where
				condiciones_publicaciones_id=1 and clasificados_id in (select id from clasificados where ruta like '%$criterio%') and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";

				$consultaUsados="select count(*) as tota from publicaciones where
				condiciones_publicaciones_id=2 and clasificados_id in (select id from clasificados where ruta like '%$criterio%') and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";

				$consultaServicios="select count(*) as tota from publicaciones where
				condiciones_publicaciones_id=3 and clasificados_id in (select id from clasificados where ruta like '%$criterio%') and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";				
			}else{
				$limite=($pagina - 1) * 25;
				$consulta="select * from publicaciones where clasificados_id in (select id from clasificados where ruta like '%$criterio%') and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL) $strCondicion order by $criterioOrden limit 25 OFFSET " . $limite;
				$consultaNuevos="select count(*) as tota from publicaciones where 
				condiciones_publicaciones_id=1 and clasificados_id in (select id from clasificados where ruta like '%$criterio%') and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";				

				$consultaUsados="select count(*) as tota from publicaciones where 
				condiciones_publicaciones_id=2 and clasificados_id in (select id from clasificados where ruta like '%$criterio%') and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";

				$consultaServicios="select count(*) as tota from publicaciones where 
				condiciones_publicaciones_id=3 and clasificados_id in (select id from clasificados where ruta like '%$criterio%') and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";						
			}					
		}else{
            $consulta="select * from publicaciones where usuarios_id in (select usuarios.id from usuarios,estados where usuarios.estados_id=estados.id and estados.id=$id_est) 
            $strCondicion and clasificados_id in (select id from clasificados where ruta like '%$criterio%') ";

            $consultaNuevos="select count(*) as tota from publicaciones where condiciones_publicaciones_id=1 and
             usuarios_id in (select usuarios.id from usuarios,estados where usuarios.estados_id=estados.id
			 and estados.id=$id_est) and clasificados_id in (select id from clasificados where ruta like '%$criterio%') and
			 id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";

            $consultaUsados="select count(*) as tota from publicaciones where condiciones_publicaciones_id=2 and
             usuarios_id in (select usuarios.id from usuarios,estados where usuarios.estados_id=estados.id
			 and estados.id=$id_est) and clasificados_id in (select id from clasificados where ruta like '%$criterio%') and
			 id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";

            $consultaServicios="select count(*) as tota from publicaciones where condiciones_publicaciones_id=3 and
             usuarios_id in (select usuarios.id from usuarios,estados where usuarios.estados_id=estados.id
			 and estados.id=$id_est) and clasificados_id in (select id from clasificados where ruta like '%$criterio%') and
			 id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";
			if($pagina==1){
				$consulta=$consulta . " and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL) order by $criterioOrden limit 25";
			}else{
				$limite=($pagina - 1) * 25;
				$consulta=$consulta . " and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL) order by $criterioOrden limit 25 OFFSET " . $limite;
			}
		}
		$publicaciones=$this->query($consulta);
		$nuevos=$this->query($consultaNuevos);
		$rowNuevos=$nuevos->fetch();		
		$usados=$this->query($consultaUsados);
		$rowUsados=$usados->fetch();
		$servicios=$this->query($consultaServicios);
		$rowServicios=$servicios->fetch();
		return array("categorias"=>$devolverCat,"estados"=>$devolver,"publicaciones"=>$publicaciones,"nuevos"=>$rowNuevos["tota"],"usados"=>$rowUsados["tota"],"servicios"=>$rowServicios["tota"]); 	
    }
//Esta pendiente simplificar el c&oacute;digo de esta funci&oacute;n despues que funcione bien
	public function getHijosPorPalabras($palabra=NULL,$criterioOrden=NULL,$pagina=NULL,$id_est=NULL,$id_cla=NULL,$condicion=NULL){
		if(is_null($pagina)){
			$pagina=1;
		}
		if(is_null($criterioOrden)){
			$criterioOrden="id desc";
		}elseif($criterioOrden=="id_asc"){
			$criterioOrden="id asc";
		}elseif($criterioOrden=="id_desc"){
			$criterioOrden="id desc";
		}elseif($criterioOrden=="monto_desc"){
			$criterioOrden="monto desc";
		}elseif($criterioOrden=="monto_asc"){
			$criterioOrden="monto asc";
		}
		$strCondicion=is_null($condicion)?"":"and condiciones_publicaciones_id=$condicion";		
		
		$devolverCat=array();
		$devolver=array();
		if(is_null($id_cla)){
			for($i=1;$i<=4;$i++){
				$clasif=$this->buscarHijos($i);
				$resultadoEstados=$this->doFullSelect("estados");
				foreach ($resultadoEstados as $estado => $valorEstado) {
					$estados[]=array("id"=>$valorEstado["id"],"nombre"=>$valorEstado["nombre"],"cantidad"=>0);
				}
				$anterior=0;
				if($clasif){
					foreach ($clasif as $key => $valor) {
						$criterio="I" . $valor["id"] . "F";
						if(is_null($id_est)){
							if($palabra!="TODOS"){
								$consulta="select count(*) as tota,clasificados_id,usuarios_id from publicaciones where clasificados_id in (select id from clasificados where ruta like '%$criterio%')
								$strCondicion and titulo like '%$palabra%' and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL) group by clasificados_id,usuarios_id order by clasificados_id";
							}else{
								$consulta="select count(*) as tota,clasificados_id,usuarios_id from publicaciones where clasificados_id in (select id from clasificados where ruta like '%$criterio%')
								$strCondicion and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL) group by clasificados_id,usuarios_id order by clasificados_id";						
							}
						}else{
							if($palabra!="TODOS"){
								$consulta="select count(*) as tota,clasificados_id,usuarios_id from publicaciones where 
								usuarios_id in (select usuarios.id from usuarios,estados where usuarios.estados_id=estados.id and estados.id=$id_est)
								$strCondicion and clasificados_id in (select id from clasificados where ruta like '%$criterio%')
								and titulo like '%$palabra%' and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL) group by clasificados_id,usuarios_id order by clasificados_id";
							}else{
								$consulta="select count(*) as tota,clasificados_id,usuarios_id from publicaciones where 
								usuarios_id in (select usuarios.id from usuarios,estados where usuarios.estados_id=estados.id and estados.id=$id_est) 
								$strCondicion and clasificados_id in (select id from clasificados where ruta like '%$criterio%')					
								and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL) group by clasificados_id,usuarios_id order by clasificados_id";							
							}
						}
						$ac=0;
						$ac2=0;
						$rows=$this->query($consulta);
						foreach ($rows as $row => $valor2) {
							$consulta="id={$valor2["usuarios_id"]}";
							$resultadoUsuarios=$this->doSingleSelect("usuarios",$consulta,"estados_id");
							$ac+=$valor2["tota"];
							$estados[$resultadoUsuarios["estados_id"]-1]["cantidad"]+=$ac;
							$ac2+=$ac;
							$ac=0;
						}
						if($ac2>0){
							$devolverCat[]=array("nombre"=>$valor["nombre"],"cantidad"=>$ac2,"id"=>$valor["id"]);
						}
					}
				}else{
					$ac=0;
					$consulta="select count(*) as tota,clasificados_id,usuarios_id from publicaciones where clasificados_id=$id
					$strCondicion and id in (select publicaciones_id from publicacionesxstatus where 
					status_publicaciones_id=1 and fecha_fin IS NULL) group by clasificados_id,usuarios_id order by clasificados_id";
					$resultado=$this->query($consulta);
					foreach ($resultado as $key => $valor) {
						$consulta="id={$valor["usuarios_id"]}";
						$resultadoUsuarios=$this->doSingleSelect("usuarios",$consulta,"estados_id");
						foreach ($estados as $estado => $valorEstado) {
							if($valorEstado["id"]==$resultadoUsuarios["estados_id"]){
								$estados[$estado]["cantidad"]+=$valor["tota"];
								break;
							}
						}
					}
				}
			}
		}else{
			$clasif=$this->buscarHijos($id_cla);
			$resultadoEstados=$this->doFullSelect("estados");
			foreach ($resultadoEstados as $estado => $valorEstado) {
				$estados[]=array("id"=>$valorEstado["id"],"nombre"=>$valorEstado["nombre"],"cantidad"=>0);
			}
			$anterior=0;
			if($clasif){
				foreach ($clasif as $key => $valor) {
					$criterio="I" . $valor["id"] . "F";
					if(is_null($id_est)){
						$consulta="select count(*) as tota,clasificados_id,usuarios_id from publicaciones where clasificados_id in (select id from clasificados where ruta like '%$criterio%')
						$strCondicion and titulo in (select titulo from publicaciones where titulo like '%$palabra%') and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL) group by clasificados_id,usuarios_id order by clasificados_id";
					}else{
						$consulta="select count(*) as tota,clasificados_id,usuarios_id from publicaciones where 
						usuarios_id in (select usuarios.id from usuarios,estados where usuarios.estados_id=estados.id and estados.id=$id_est) 
						$strCondicion and clasificados_id in (select id from clasificados where ruta like '%$criterio%')
						and titulo in (select titulo from publicaciones where titulo like '%$palabra%') and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL) group by clasificados_id,usuarios_id order by clasificados_id";
					}
					$ac=0;
					$ac2=0;
					$rows=$this->query($consulta);				
					foreach ($rows as $row => $valor2) {
						$consulta="id={$valor2["usuarios_id"]}";
						$resultadoUsuarios=$this->doSingleSelect("usuarios",$consulta,"estados_id");
						$ac+=$valor2["tota"];
						$estados[$resultadoUsuarios["estados_id"]-1]["cantidad"]+=$ac;
						$ac2+=$ac;
						$ac=0;
					}
					if($ac2>0){
						$devolverCat[]=array("nombre"=>$valor["nombre"],"cantidad"=>$ac2,"id"=>$valor["id"]);
					}
				}
			}else{
				$ac=0;
				$consulta="select count(*) as tota,clasificados_id,usuarios_id from publicaciones where clasificados_id=$id_cla and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL) $strCondicion group by clasificados_id,usuarios_id";
				$resultado=$this->query($consulta);
				foreach ($resultado as $key => $valor) {
					$consulta="id={$valor["usuarios_id"]}";
					$resultadoUsuarios=$this->doSingleSelect("usuarios",$consulta,"estados_id");
					foreach ($estados as $estado => $valorEstado) {
						if($valorEstado["id"]==$resultadoUsuarios["estados_id"]){
							$estados[$estado]["cantidad"]+=$valor["tota"];
							break;
						}
					}
				}
			}
		}
	    foreach ($estados as $estado => $valorEstado) {
			if($valorEstado["cantidad"]>0){
				$devolver[]=array("nombre"=>$valorEstado["nombre"],"cantidad"=>$valorEstado["cantidad"],"id"=>$valorEstado["id"]);
			}
		}
		if(is_null($id_est)){
	        if($pagina==1){
	        	if($palabra!="TODOS"){
		           	$consulta="select * from publicaciones where titulo like '%$palabra%' $strCondicion and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL) order by $criterioOrden limit 25";
					$consultaNuevos="select count(*) as tota from publicaciones where titulo like '%$palabra%' and 
					condiciones_publicaciones_id=1 and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";
					
					$consultaUsados="select count(*) as tota from publicaciones where titulo like '%$palabra%' and
					condiciones_publicaciones_id=2 and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";

					$consultaServicios="select count(*) as tota from publicaciones where titulo like '%$palabra%' and
					condiciones_publicaciones_id=3 and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";					
	           	}else{
	           		$consulta="select * from publicaciones where id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL) $strCondicion order by $criterioOrden limit 25";
					$consultaNuevos="select count(*) as tota from publicaciones where 
					condiciones_publicaciones_id=1 and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";
					
					$consultaUsados="select count(*) as tota from publicaciones where 
					condiciones_publicaciones_id=2 and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";

					$consultaServicios="select count(*) as tota from publicaciones where 
					condiciones_publicaciones_id=3 and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";					
	           	}
			}else{
				if($palabra!="TODOS"){
					$consulta="select * from publicaciones where titulo like '%$palabra%' and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL) 
					$strCondicion order by $criterioOrden limit 25 OFFSET " . ($pagina - 1) * 25;
					$consultaNuevos="select count(*) as tota from publicaciones where 
					condiciones_publicaciones_id=1 and titulo like '%$palabra%' and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";

					$consultaUsados="select count(*) as tota from publicaciones where 
					condiciones_publicaciones_id=2 and titulo like '%$palabra%' and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";

					$consultaServicios="select count(*) as tota from publicaciones where 
					condiciones_publicaciones_id=3 and titulo like '%$palabra%' and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";					
				}else{
					$limite=($pagina - 1) * 25;
					$consulta="select * from publicaciones where id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL) 
					$strCondicion order by $criterioOrden limit 25 OFFSET " . $limite;

					$consultaNuevos="select count(*) as tota from publicaciones where 
					condiciones_publicaciones_id=1 and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)"; 

					$consultaUsados="select count(*) as tota from publicaciones where 
					condiciones_publicaciones_id=2 and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";

					$consultaServicios="select count(*) as tota from publicaciones where 
					condiciones_publicaciones_id=3 and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";
				}
			}
		}else{
			if($palabra!="TODOS"){
		        $consulta="select * from publicaciones where usuarios_id in (select usuarios.id from usuarios,estados where usuarios.estados_id=estados.id and estados.id=$id_est) 
		        $strCondicion and titulo like '%$palabra%' and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";

		        $consultaNuevos="select count(*) as tota from publicaciones where condiciones_publicaciones_id=1 and usuarios_id in 
		        (select usuarios.id from usuarios,estados where usuarios.estados_id=estados.id
				 and estados.id=$id_est) and titulo like '%$palabra%' and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";

		        $consultaUsados="select count(*) as tota from publicaciones where condiciones_publicaciones_id=2 and usuarios_id in 
		        (select usuarios.id from usuarios,estados where usuarios.estados_id=estados.id
				 and estados.id=$id_est) and titulo like '%$palabra%' and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";

		        $consultaServicios="select count(*) as tota from publicaciones where condiciones_publicaciones_id=3 and usuarios_id in 
		        (select usuarios.id from usuarios,estados where usuarios.estados_id=estados.id
				 and estados.id=$id_est) and titulo like '%$palabra%' and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";				 
 			}else{
				$consulta="select * from publicaciones where usuarios_id in (select usuarios.id from usuarios,estados where usuarios.estados_id=estados.id and estados.id=$id_est) 
				$strCondicion and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";

				$consultaNuevos="select count(*) as tota from publicaciones where condiciones_publicaciones_id=1 and usuarios_id in 
				(select usuarios.id from usuarios,estados where usuarios.estados_id=estados.id
				 and estados.id=$id_est) and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";

				$consultaUsados="select count(*) as tota from publicaciones where condiciones_publicaciones_id=2 and usuarios_id in 
				(select usuarios.id from usuarios,estados where usuarios.estados_id=estados.id
				 and estados.id=$id_est) and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";

				$consultaServicios="select count(*) as tota from publicaciones where condiciones_publicaciones_id=3 and usuarios_id in 
				(select usuarios.id from usuarios,estados where usuarios.estados_id=estados.id
				 and estados.id=$id_est) and id in (select publicaciones_id from publicacionesxstatus where status_publicaciones_id=1 and fecha_fin IS NULL)";
			}
			if($pagina==1){
				$consulta.=" order by $criterioOrden limit 25";
			}else{
				$limite=($pagina - 1) * 25;
				$consulta.=" order by $criterioOrden limit 25 OFFSET " . $limite;
			}
		}
		$publicaciones=$this->query($consulta);
		$nuevos=$this->query($consultaNuevos);
		$rowNuevos=$nuevos->fetch();		
		$usados=$this->query($consultaUsados);
		$rowUsados=$usados->fetch();
		$servicios=$this->query($consultaServicios);
		$rowServicios=$servicios->fetch();		
		return array("categorias"=>$devolverCat,"estados"=>$devolver,"publicaciones"=>$publicaciones,"nuevos"=>$rowNuevos["tota"],"usados"=>$rowUsados["tota"],"servicios"=>$rowServicios["tota"]); 	
    }
    function buscarPadre($id=NULL){
    	if(is_null($id)){
    		$id=$this->id;
    	}
    	return substr($this->ruta,0,3);
    }
}