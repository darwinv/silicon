<?php  
class restricciones{ 

	/**LO QUE NO PUEDE VER**/
	private $rol_a=array('principal.php','actualizaciones.php','detalle.php', 'estadisticas.php', 'favoritos.php', 'listado.php', 'perfil.php','publicar.php');
	private $rol_b=array();
	private $rol_c=array('publicar.php');
	/**LO QUE PUEDE VER**/
	private $rol_a_cs;
	private $rol_b_cs;
	private $rol_c_cs;
	/****/
	public $show_page=TRUE;
	
	/* * * * * * * * * * * * * * * * * * * * * * *
	 * ===========--- Contructor ---============ *
	 * * * * * * * * * * * * * * * * * * * * * * */
	public function restricciones($id_rol = NULL, $ruta = NULL) {
		 parent::__construct();
		if ($id_rol != NULL and $ruta != NULL) { 
			$this->buscarRestriccion ( $id_rol, $ruta );
		}
	}
	public function buscarRestriccion($id_rol,$uri){
		$flag=TRUE;	 
		$url = explode('/', $uri);
        $varURL = $url[count($url) - 1]; 
		 
		if($id_rol=='1'){
			
			if (in_array($varURL, $this->rol_a)) {
				$flag=FALSE;
			}
		}
		if($id_rol=='2'){
			if (in_array($varURL, $this->rol_b)) {
				$flag=FALSE;
			}
		}
		if($id_rol=='3'){
			if (in_array($varURL, $this->rol_c)) {
				$flag=FALSE;
			}
		} 
		
		 $this->show_page=$flag;
	}
	
	
}