<?php
/** 
 * @property string driver tipo de conexion
 * @property string host nombre del host
 * @property string bd_name nombre de la base de datos
 * @property string bd_charset charset de la base de datos
 * @property string user usario de la base de datos
 * @property string password password para la base de datos
 * @property array options array con las opciones de la conexion
 * @property int rowcount contiene el numero de filas obtenidas por la consulta
 */
class bd extends PDO {
	private $driver = "mysql";
	private $host = "localhost";
	private $bd_name = DB_NAME;
	private $bd_charset = "utf8";
	private $user = DB_USER;
	private $password = DB_PASS;
	private $options = array (
			PDO::ATTR_EMULATE_PREPARES => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC 
	);
	private $rowcount;
	public function bd() {
		try {
			parent::__construct ( "$this->driver:host=$this->host;dbname=$this->bd_name;charset=$this->bd_charset", $this->user, $this->password, $this->options );
		} catch ( PDOException $ex ) {
			return $ex->getMessage ();
		}
	}
	public function valueExist($table, $search, $column) {
		$stament = "SELECT * FROM {$table} WHERE {$column} = ?";
		try {
			$sql = $this->prepare ( $stament );
			$sql->execute ( array (
					$search 
			) );
			$count = $sql->rowCount ();
			if ($count > 0) {
				return true;
			} else {
				return false;
			}
		} catch ( PDOException $ex ) {
			return $this->showError ( $ex );
		}
	}
	
	
	public function doFullSelect($table, $condition = NULL, $columns = "*") {
		if (isset ( $condition )) {
			$condition = "WHERE $condition";
		}
		$stament = "SELECT {$columns} FROM {$table} {$condition}";
		try {
			$sql = $this->query ( $stament );
			if ($sql->rowCount () > 0) {
				return $sql->fetchAll ();
			} else {
				return false;
			}
		} catch ( PDOException $ex ) {
			return $this->showError ( $ex );
		}
	}
	public function doSingleSelect($table, $condition = NULL, $columns = "*") {
		if (isset ( $condition )) {
			$condition = "WHERE $condition";
		}
		$stament = "SELECT {$columns} FROM {$table} {$condition}";
	//return $stament;
		try {
			$sql = $this->query ( $stament );
			$this->rowcount=$sql->rowCount();
			if ($sql->rowCount () > 0) {
				return $sql->fetch ();
			} else {
				return false;
			}
		} catch ( PDOException $ex ) {
				var_dump($stament);
		var_dump($condition);
			return $this->showError ( $ex );
		}
	}
	public function doInsert($table, $params) {
		//var_dump($params);
		if ($vars = $this->prepareParams ( $params )) {
			$stament = "INSERT INTO {$table}({$vars['columns']}) VALUES ({$vars['values']})";
			
			//var_dump($stament.' - '. $params);
			try {
				
				$sql = $this->prepare ( $stament );
				foreach ( $vars ['valuesp'] as $key => $value ) {
					$sql->bindValue ( $key, $value );
				}
				
				return $sql->execute ();
			} catch ( PDOException $ex ) {
					
				echo ($this->showError ( $ex )); 	
				return $this->showError ( $ex );
			}
		}
	}
	public function doUpdate($table, $params, $condition) {
		try {
			$array_last = array_keys ( $params );
			$last_key = end ( $array_last );
			$columns = "";
			foreach ( $params as $key => $value ) {
				$values [] = $value;
				$columns .= "$key  = ?";
				if ($key != $last_key) {
					$columns .= ", ";
				}
			}
			$statement = "UPDATE $table SET $columns WHERE $condition";
			$sql = $this->prepare ( $statement );
			$sql->execute ( $values );
			if ($sql->rowCount () > 0) {
				return true;
			} else {
				return false;
			}
		} catch ( PDOException $ex ) {
			return $ex->getMessage ();
		}
	}
	public function emptyTable($table) {
		try {
			var_dump ( $this->query ( "DELETE FROM $table" ) );
			$this->query ( "ALTER TABLE $table auto_increment = 1" );
		} catch ( PDOException $ex ) {
			return $ex->getMessage ();
		}
	}
	public function truncateTable($table) {
		try {
			$this->query ( "TRUNCATE $table" );
		} catch ( PDOException $ex ) {
			return $ex->getMessage ();
		}
	}
	public function getDatosBase($table, $id = NULL) {
		if (isset ( $id )) {
			$sql = $this->query ( "SELECT * FROM $table WHERE paises_id = $id" );
			$this->rowcount = $sql->rowCount ();
			return $sql->fetchAll ();
		} else {
			$sql = $this->query ( "SELECT * FROM $table" );
			$this->rowcount = $sql->rowCount ();
			return $sql->fetchAll ();
		}
	}
	public function getAllDatos($table, $row='', $fields='*') {
		$consulta = "SELECT $fields FROM $table WHERE 1" ; 
		if (isset ( $row['indice'] ) and isset ( $row['value'])) {		
			$consulta .= ' and '.$row['indice'].' = '. $row['value'];
		}
		$sql = $this->query ( $consulta );
		$this->rowcount = $sql->rowCount ();
		return $sql->fetchAll ();
	}
	/**
	 * Funciones Magicas*
	 */
	public function __get($property) {
		if (property_exists ( $this, $property )) {
			return $this->$property;
		}
	}
	public function __set($property, $value) {
		if (property_exists ( $this, $property )) {
			$this->$property = $value;
		}
	}
	/**
	 * Funciones Privadas*
	 */
	public function showError($ex) {
		return "<p>" . $ex->getMessage () . "<p>";
	}
	private function prepareParams($params) {
		if (! empty ( $params )) {
			$vars ["columns"] = "";
			$vars ["values"] = "";
			$array_last = array_keys ( $params );
			$last_key = end ( $array_last );
			foreach ( $params as $key => $value ) {
				if ($key != $last_key) {
					$coma = ",";
				} else {
					$coma = "";
				}
				$vars ["columns"] .= "{$key}{$coma}";
				$vars ["values"] .= ":{$key}{$coma}";
				$vars ["valuesp"] [":$key"] = $value;
			}
			return $vars;
		} else {
			throw new Exception ( "Error BD 001: No se recibieron parametros validos" );
			return false;
		}
	}
}