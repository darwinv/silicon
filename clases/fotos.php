<?php
class fotos extends bd {
	protected $table = "fotos";
	protected $table_user = "fotos_usuarios";
	protected $table_pub = "fotosxpublicaciones";
	public $path = "../galeria/fotos";
	private $id;
	private $ruta;
	private $manager_ruta;
	
// 	public function fotos($id = NULL, $tipo = "usr"){
// 		if ($id != NULL) {
// 			// Hago consulta;
// 			if($tipo = "usr"){
// 				$this->buscarFotoUsuario ( $id );
// 			}else{
// 				$this->buscarFotoPublicacion ( $id );
// 			}			
// 		}
// 	}
	public function buscarFotoUsuario($id){
		
		$table = "fotos, fotos_usuarios";
		$condicion = "usuarios_id = $id AND fotos_id = id";
		$result = $this->doSingleSelect($table,$condicion);
		if(!empty($result)){
			return $result["ruta"].$result["id"].".png";
		}else{
			return "galeria/img-site/logos/silueta-bill.png";
		}
	}
	
	public function buscarFotoPort($id){
		
		$table = "fotos , fotos_usuarios ";
		$condicion = "usuarios_id = $id AND fotos_id = id and status = 'P'";
		$result = $this->doSingleSelect($table,$condicion);
		if(!empty($result)){
			return $result["ruta"].$result["id"].".png";
		}else{
			return "galeria/img-site/fondos/portada.png";
		}
	}
	
	public function crearFotoPublicacion($id_publicacion, $dataurl)
	{
		
		if(substr ( $dataurl, 0, 4 ) == "data")
		{
			$this->ruta = $this->crearRuta();
			$result = $this->doInsert($this->table,array("id" => 0, "ruta" => substr($this->ruta, strpos($this->ruta, "/") + 7)));
			if($result){
				$this->id = $this->lastInsertId();
				$this->doInsert($this->table_pub, array("publicaciones_id" => $id_publicacion, "fotos_id" => $this->id));
				$this->subirFoto($dataurl);
				return true;
			}else{
				echo $result;
				return false;
			}
		}
	}
	public function actualizarFotoPublicacion($id_publicacion, $dataurl,$id)
	{
		if(substr ( $dataurl, 0, 4 ) == "data")
		{
			$this->id = $id;
			$this->ruta = $this->crearRuta();
			$this->subirFoto($dataurl);
		}
	}	
	public function crearFotoUsuario($id_usuario, $dataurl){
				
		if(substr ( $dataurl, 0, 4 ) == "data")
		{
			$this->ruta = $this->crearRuta();
			$result = $this->doInsert($this->table,array("id" => 0, "ruta" => substr($this->ruta, strpos($this->ruta, "/") + 1)));
			if($result){
				$this->id = $this->lastInsertId();
				$this->doInsert($this->table_user, array("status" => "A", "usuarios_id" => $id_usuario, "fotos_id" => $this->id));
				$this->subirFoto($dataurl);
				return true;
			}else{
				return false;
			}	
			$this->updateSessionFoto($id_usuario);
//		}else{	///Viene de una url
//			copy($dataurl,"galeria/prueba.png");
		}
	}
	public function crearFotoPort($id_usuario, $dataurl){
				
		if(substr ( $dataurl, 0, 4 ) == "data")
		{
			$this->ruta = $this->crearRuta();
			$result = $this->doInsert($this->table,array("id" => 0, "ruta" => substr($this->ruta, strpos($this->ruta, "/") + 1)));
			if($result){
				$this->id = $this->lastInsertId();
				$this->doInsert($this->table_user, array("status" => "P", "usuarios_id" => $id_usuario, "fotos_id" => $this->id)); // fotos de portada se agregan con el estado PA (portada activa)
				$this->subirFoto($dataurl);
				return true;
			}else{
				return false;
			}	
		}
	}
	
	public function subirFoto($dataurl,$ruta = NULL){	
		//Obtener la dataurl de la imagen
		$data_url = str_replace(" ", "+", $dataurl);
		$filteredData=substr($data_url, strpos($data_url, ",")+1);			
		//Decodificar la dataurl
		$unencodedData=base64_decode($filteredData);
		//subir la imagen
		if(is_null($ruta)){
			$ruta = "{$this->ruta}{$this->id}.png";
		}else{
			$ruta = "../$ruta";			
		}
		return file_put_contents($ruta, $unencodedData);
	}
	
	public function subirFotoManager($dataurl,$user){	
		//Obtener la dataurl de la imagen
		$ruta = __DIR__ . "/../galeria/manager/$user/";
		$return_ruta = "galeria/manager/$user/";
		if(!file_exists($ruta)){
			mkdir($ruta,0777,true);
		}
		$data_url = str_replace(" ", "+", $dataurl);
		$filteredData=substr($data_url, strpos($data_url, ",")+1);
		$unencodedData=base64_decode($filteredData);
		$ruta=$ruta.time().".png";
		$return_ruta = $return_ruta.time().".png";
		if(file_put_contents($ruta, $unencodedData))
			return $return_ruta;
		else 
			return false;
	}
	
	public function getRuta(){
		return $this->manager_ruta;
	}
	
	public function updateFoto($ruta,$dataurl,$id){
		if($ruta == "galeria/img-site/logos/silueta-bill.png")
		{
			return $this->crearFotoUsuario($id, $dataurl);
		}else{
			return $this->subirFoto($dataurl,$ruta);
		}
	}
	
	public function updatePort($ruta,$dataurl,$id){
		if($ruta == "galeria/img-site/fondos/portada.png")
		{
			return $this->crearFotoPort($id, $dataurl);
		}else{
			return $this->subirFoto($dataurl,$ruta);
		}
	}
	
	public function updateSessionFoto($id){
		session_start();
		$_SESSION["fotoperfil"] = $this->buscarFotoUsuario($id);	
	}
	public function crearRuta(){		
		$mes = date("m");
		$year = date("Y");
		$fullpath= "{$this->path}/{$year}/{$mes}/";
		if(!file_exists($fullpath)){
			mkdir($fullpath,0777,true);
		}
		return $fullpath;
	}
}