<?php
class proveedor extends bd {
	/* * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Attributes ---============ *
	 * * * * * * * * * * * * * * * * * * * * * * */
	protected $p_table = "proveedores";
	private $id = 0;
	private $p_tipo;
	private $p_documento;
	private $p_nombre;
	private $p_telefono;
	private $p_email;
	private $p_direccion;
	private $p_proveedores_id;
	
	protected $b_table = "proveedores_bancos";
	private $b_bancos_id;
	private $b_tipos_cuentas_id;
	private $b_nro_cuenta;
	
	/* * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Contructor ---============ *
	 * * * * * * * * * * * * * * * * * * * * * * */
	public function proveedor($id = NULL) {
		parent::__construct();
		if ($id != NULL) {
			$this->buscarProveedor ( $id );
		}
	}
	/* * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Methods ---=========== *
	 * * * * * * * * * * * * * * * * * * * * */
	public function buscarProveedor($id){
		// hace consulta y setea valores
		
		if(!empty($id)){
			$this->id = $id;
			$this->getdatosProveedores();
		} 
	}	
	public function crearProveedor($bancos, $titular) {
		if(array_key_exists("documento", $titular)){
			$result = $this->doInsert ( $this->p_table, $titular );
			$this->p_proveedores_id = $this->lastInsertId ();
		}		
		$result = $this->doInsert ( $this->p_table, $this->serializarDatos ( "p_" ) );
		$this->id = $this->lastInsertId ();
		if (empty ( $this->p_proveedores_id)) {				 
			$this->doUpdate($this->p_table,array("proveedores_id"=>$this->id),"id=$this->id");
		}
		
		$count=count($bancos['nro_cuentas']);			
		for($i=0;$i<$count;$i++){
			$this->datosBancos($bancos['tipos_bancos_id'][$i], $bancos['bancos_id'][$i], $bancos['nro_cuentas'][$i]);
			$this->doInsert ( $this->b_table, $this->serializarDatos ( "b_", $this->p_table ) );
		}		
	}
	public function modificarProveedor($listaValores_proveedor, $listaValores_titular=array(), $bancos){
		$this->getdatosProveedores();

			if(array_key_exists("documento", $listaValores_titular)){
				if ($this->id!=$this->p_proveedores_id) {
					##SI EXISTE MODIFICAMOS
					$result=$this->doUpdate($this->p_table,$listaValores_titular,"id=$this->p_proveedores_id");
					$listaValores_proveedor['proveedores_id']=$this->p_proveedores_id;
				}else{
					##SINO CREAMOS
					$result = $this->doInsert ( $this->p_table, $listaValores_titular );
					$listaValores_proveedor['proveedores_id']= $this->lastInsertId ();
				}				
			}else{
				##SI NO ESTA CHEKEADO BORRAMOS TITULAR
				$listaValores_proveedor['proveedores_id']=$this->id;
			}
		//var_dump($listaValores_proveedor);
		$this->doUpdate($this->p_table,$listaValores_proveedor,"id=$this->id");		
		##BORRAMOS LOS BANCOS ASOCIADOS
		$this->borrarBancos($this->id);
		$count=count($bancos['nro_cuentas']);
		##INSERTAMOS LOS NUEVOS BANCOS
	 	for($i=0;$i<$count;$i++){
			$this->datosBancos($bancos['tipos_bancos_id'][$i], $bancos['bancos_id'][$i], $bancos['nro_cuentas'][$i]);
			$this->doInsert ( $this->b_table, $this->serializarDatos ( "b_", $this->p_table ) );
		}
	}
	public function getProveedores($campos = null){
		$campos=is_null($campos)?"*":$campos;
		$consulta="select $campos FROM proveedores WHERE proveedores_id IS NOT NULL";
        $result=$this->query($consulta);
		return $result;
	}
	public function getBancos($proveedores_id=null){
		$consulta="select * FROM proveedores_bancos WHERE proveedores_id='$proveedores_id'";
        $result=$this->query($consulta);
		return $result;
	}
	public function getTitulares($proveedores_id=null){
		$consulta="select * FROM proveedores WHERE id='$proveedores_id' and proveedores_id IS NULL";
        $result=$this->query($consulta);
		return $result;
	}
	public function getBancosFullData($proveedores_id=null){
		$consulta="SELECT
					proveedores_bancos.proveedores_id,
					proveedores_bancos.bancos_id,
					proveedores_bancos.tipos_cuentas_id,
					proveedores_bancos.nro_cuenta,
					tipos_cuentas.nombre AS tipo_cuenta,
					bancos.siglas AS banco
					FROM
					bancos
					Inner Join proveedores_bancos ON proveedores_bancos.bancos_id = bancos.id
					Inner Join tipos_cuentas ON proveedores_bancos.tipos_cuentas_id = tipos_cuentas.id
					WHERE proveedores_bancos.proveedores_id='$proveedores_id'";
        $result=$this->query($consulta);
		return $result;
	}	
	/* * * * * * * * * * * * * * * * * * *
	 * =========--- Getters ---========= *
	 * * * * * * * * * * * * * * * * * * */
	public function getdatosProveedores(){
		$result = $this->doSingleSelect($this->p_table,"id = {$this->id}");
		if($result){
			$this->datosProveedor($result["tipo"], $result["documento"], $result["nombre"], $result["telefono"], $result["email"], $result["direccion"], $result["proveedores_id"]);			
			$this->id = $result["id"];
		}else{
			return false;
		}
	}	
	/* * * * * * * * * * * * * * * * * * *
	 * =========--- Setters ---========= *
	 * * * * * * * * * * * * * * * * * * */
	public function datosProveedor($tipo, $documento, $nombre, $telefono, $email, $direccion, $proveedores_id=null) {
		$this->defaultClass();
		$this->p_tipo = $tipo;
		$this->p_documento = $documento;
		$this->p_nombre = $nombre;
		$this->p_telefono = $telefono;
		$this->p_email = $email;
		$this->p_direccion = $direccion;
		$this->p_proveedores_id = $proveedores_id;
	}
	public function datosTitular($tipo_titular, $documento_titular, $nombre_titular, $email_titular) {
		$this->t_tipo = $tipo_titular;
		$this->t_documento = $documento_titular;
		$this->t_nombre = $nombre_titular;
		$this->t_email = $email_titular;
	}
	public function datosBancos($tipos_bancos, $bancos, $nros_cuentas) {
		$this->b_tipos_cuentas_id = $tipos_bancos;
		$this->b_bancos_id = $bancos;
		$this->b_nro_cuenta = $nros_cuentas;
	}
	public function setID($id) {
		$this->id=$id;
	}
	/* * * * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Delete Row ---===========      *
	 * * * * * * * * * * * * * * * * * * * * * * * * */
	 public function borrarTitular($proveedores_id) {
	 	$result=$this->query("delete from proveedores_titulares where proveedores_id='$proveedores_id'");
	}
	 public function borrarBancos($proveedores_id) {
	 	$result=$this->query("delete from proveedores_bancos where proveedores_id='$proveedores_id'");
	}
	
	/* * * * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Private Methods ---=========== *
	 * * * * * * * * * * * * * * * * * * * * * * * * */
	 public function __get($property) {
		if (property_exists ( $this, $property )) {
			return $this->$property;
		}
	}
	private function defaultClass() {
		foreach ( get_class_vars ( get_class ( $this ) ) as $name => $default ) {
			$this->$name = $default;
		}
	}
	private function serializarDatos($prefix = "p_", $foreign_table = false) {
		$reflection = new ReflectionObject ( $this );
		
		$properties = $reflection->getProperties ( ReflectionProperty::IS_PRIVATE );
		
		foreach ( $properties as $property ) {
			$name = $property->getName ();
			
			if (substr ( $name, 0, 2 ) == $prefix || $name == "id") {
				if ($name == "id") {
					if ($foreign_table != false) {
						if (is_array ( $foreign_table )) {
							foreach ( $foreign_table as $f_table ) {
								$params ["{$f_table}_id"] = $this->$name;
							}
						} else {
							$params ["{$foreign_table}_id"] = $this->$name;
						}
					} else {
						$params ["id"] = $this->$name;
					}
				} else {
					$params [substr ( $name, strpos ( $name, "_" ) + 1 )] = $this->$name;
				}
			}
		}
		 //var_dump ( $params );
		return $params;
	}
	
}