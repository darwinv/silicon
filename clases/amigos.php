<?php
class amigos extends bd{
	// Amigos (f)
	protected $table = "usuarios_amigos";
	protected $table_fav = "usuarios_favoritos";
	private $fecha;
	private $usuarios_id;
	private $amigos_id;
	private $result;
	
	public function contarMeGustan($id){
		
		$sql = $this->query("SELECT COUNT(*) total FROM {$this->table_fav} WHERE favoritos_id = $id GROUP BY favoritos_id");
		if($sql->rowCount()>0){
			$row = $sql->fetch();			
			return $row["total"];
		}else{
			return 0;
		}		
	}
	public function yamegusta($useract,$userper){
		
		$sql = $this->query("SELECT * FROM {$this->table_fav} WHERE usuarios_id = $userper AND favoritos_id = $useract");
		if($sql->rowCount()>0){			
			return true;
		}else{
			return false;
		}		
	}
	public function borrarFavorito($usuarios_id, $favoritos_id){
		
		$sql = $this->query("DELETE FROM usuarios_favoritos WHERE usuarios_id = $usuarios_id AND favoritos_id = $favoritos_id");
		if($sql->rowCount()>0){
			return true;
		}else{
			return false;
		}
	}
	
	public function buscarAmigos($id,$tipo = NULL, $busqueda = NULL) {
		$querynatural = "SELECT ua.usuarios_id numero, seudonimo, CONCAT(nombre,' ', apellido) nombre, estados_id estado
						  FROM usuarios_naturales un, usuarios_accesos ua, usuarios u 
						  WHERE u.id = un.usuarios_id AND u.id = ua.usuarios_id ";
		$queryjuridico = "SELECT ua.usuarios_id numero, seudonimo, razon_social nombre, estados_id estado 
						  FROM usuarios_juridicos uj, usuarios_accesos ua, usuarios u  
						  WHERE  u.id = uj.usuarios_id AND u.id = ua.usuarios_id ";
		$estado = "";
		$union = "";
		$search = "";
		if(!is_null($tipo)){
			if($tipo == "jur"){
				$querynatural = "";
			} elseif($tipo == "nat"){
				$queryjuridico = "";
			} elseif($tipo == "all"){
				$union = " UNION ALL ";
			} elseif(is_numeric($tipo)){
				$estado = " AND estado = $tipo ";
				$union = " UNION ALL ";
			}
		}else{
			$union = " UNION ALL ";
		}
		
		if(!empty($busqueda)){
			$search = " AND (nombre LIKE '%$busqueda%' OR seudonimo LIKE '%$busqueda%')";
		}
		$statement = "SELECT numero, seudonimo, nombre, estado 
					  FROM ($querynatural
						  $union
						  $queryjuridico) tabla, usuarios_amigos 
					  WHERE amigos_id = numero $estado $search AND usuarios_id = ?";
		try {
			$sql = $this->prepare ( $statement );
			$sql->execute ( array (
					$id 
			) );
			if($sql->rowCount()>0){
				return $sql->fetchAll ();
			}else{
				return false;
			}			 
		} catch ( PDOException $ex ) {
			return $this->showError ( $ex );
		}
	}
	public function nuevoAmigo($fecha, $usuarios_id, $amigos_id) {
		$this->doInsert ( $this->table, array (
				"fecha" => $fecha,
				"usuarios_id" => $usuarios_id,
				"amigos_id" => $amigos_id 
		) );
	}
	public function nuevoFavorito($fecha, $usuarios_id, $favoritos_id) {
		$this->doInsert ( $this->table_fav, array (
				"fecha" => $fecha,
				"usuarios_id" => $usuarios_id,
				"favoritos_id" => $favoritos_id
		) );
	}
}
