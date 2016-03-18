<?php
	require '../../../config/core.php';
	include '../../../clases/proveedor.php';
	switch($_POST["metodo"]){
		case "buscar":
			buscar();
			break;
		case "crearProveedor":
			crearProveedor();
			break;
		case "getProveedores":
			buscarProveedores();
			break;
		case "getrBancos":
			buscarBancos();
			break;
		case "update":
			modificarProveedor();
			break;
		case "buscarDetalleProveedores":
			buscarDetalleProveedores();
			break;			
		default :
			echo "error";
			break;
	}
	 function buscar(){
	 	if (! isset ( $_SESSION )) {
			session_start ();
		}
		if(isset($_COOKIE["c_id"])){
			$id_user=$_COOKIE["c_id"];
		}else{
			$id_user=NULL;
		}
		
		$proveedor=new proveedor();
		$orden='id desc';
		$pagina=$_POST["pagina"];
		$result=$proveedor->getProveedores(null, $orden ,$pagina);
		foreach($result as $r=>$fila){

				?>
				<tr>
                    <td><?php echo $fila["documento"]; ?></td>
                    <td><?php echo $fila["nombre"]; ?></td>
                    <td><?php echo $fila["telefono"]; ?></td>
                    <td><?php echo $fila["email"]; ?></td>        
                   
                    <td><a href="#mod" class="admin-edit-prov" data-toggle="modal" data-target="#edit-prov" data-proveedor_id="<?php echo $fila['id']; ?>" ><i class="fa fa-lock" ></i> Modificar</a></td>
                    <td><a href="#mod" class="admin-ver-prov"  data-toggle="modal" data-target="#ver-prov"  data-proveedor_id="<?php echo $fila['id']; ?>" ><i class="fa fa-eye"  ></i> Ver      </a></td>
                   
                   <!-- <td><a href="#del" class="select-usr-delete " data-toggle="modal" data-target='#msj-eliminar' data-status='3'  data-usuarios_id="<?php echo $fila['id']; ?>"   >
                    		<i class="fa fa-remove"></i> Eliminar
                    	</a> 
              		</td>-->
                    
                </tr>
                <?php
		}
	}
	function crearProveedor() {
		$proveedor = new proveedor();
		
		$tipo = filter_input ( INPUT_POST, "prov_tipo" );
		$documento = filter_input ( INPUT_POST, "prov_documento" );
		$nombre = filter_input ( INPUT_POST, "prov_nombre" );
		$telefono = filter_input ( INPUT_POST, "prov_telefono" );
		$email = filter_input ( INPUT_POST, "prov_email" );
		$direccion = filter_input ( INPUT_POST, "prov_direccion" );	
		
		if (isset($_POST['diff_titular'])) {
		    $tipo_titular = filter_input ( INPUT_POST, "prov_tipo_titular" );
			$documento_titular = filter_input ( INPUT_POST, "prov_documento_titular" );
			$nombre_titular = filter_input ( INPUT_POST, "prov_nombre_titular" );
			$email_titular = filter_input ( INPUT_POST, "prov_email_titular" );			
			$proveedor_titular=array (
					"tipo" => $tipo_titular,
					"documento" => $documento_titular,
					"nombre" => $nombre_titular,
					"email" => $email_titular
					);
		}else{
			$proveedor_titular=array ();
		}
		
		$tipos_bancos = $_POST['prov_tipo_banco'];
		$bancos = $_POST['prov_banco'];
		$nros_cuentas = $_POST['prov_nro_cuenta'];
		$proveedor_bancos=array (
					"tipos_bancos_id" => $tipos_bancos,
					"bancos_id" => $bancos,
					"nro_cuentas" => $nros_cuentas
					);
					
		$proveedor->datosProveedor($tipo, $documento, $nombre, $telefono, $email, $direccion);
		
		$proveedor->crearProveedor($proveedor_bancos, $proveedor_titular);
				
		echo json_encode ( array (
					"result" => "ok"
			) );
		 
	}
	 function buscarProveedores($returnValores=null){
		if(!isset($_POST["id"])){
			if(!isset($_SESSION)){
				session_start();
			}
			$id=$_SESSION ["id"];
		}else{
			$id=$_POST ["id"];
		}
		$proveedor = new proveedor ( $id );
		$reflection = new ReflectionObject ($proveedor);
		$properties = $reflection->getProperties ( ReflectionProperty::IS_PRIVATE );
		foreach ( $properties as $property ) {
			$name = $property->getName();
			if(isset($_POST ["id"])){
				$valores [$name] = $proveedor->$name;
				
			}
		}
		
		
		$obj_titular=$proveedor->getTitulares( $valores ['p_proveedores_id'] );
		
		$array_titular=$obj_titular->fetch();
		
		if(is_array($array_titular)){
			foreach ($array_titular as $key => $dataTitulares) {
				if($key!='id'){
					$valores[$key]=$dataTitulares;
				}
			}
		}
		
		if($returnValores){
			 return $valores;
		}else{
				echo json_encode ( array (
				"result" => "OK",
				"campos" => $valores) );
		}
	}
	 function buscarDetalleProveedores(){
		if(!isset($_POST["id"])){
			if(!isset($_SESSION)){
				session_start();
			}
			$id=$_SESSION ["id"];
		}else{
			$id=$_POST ["id"];
		}
		$proveedor = new proveedor ( $id );
		
		$valores=buscarProveedores(true);
		
		$prov_bancos	= $proveedor->getBancosFullData($id);
		
		ob_start();
		 
	
		foreach ($prov_bancos as $key => $dataBanco) {
			 $var =substr_replace($dataBanco['nro_cuenta'],"-",4,0);
			 $var =substr_replace($var,"-",9,0);
			 $var =substr_replace($var,"-",12,0);
			?>
			
				<div class="marT5">
					 <span></span>
					<span class="t15"><?php echo $dataBanco['banco']; ?></span>
					-
					 
						Tipo de Cuenta:
					 
					<?php echo $dataBanco['tipo_cuenta']; ?>
					
					 
				</div>
				<div>
					<span>
						Nº Cuenta: 
					</span>
					<?php echo $var; ?>
				</div>
					
		<?php
		}	
		
		$valores['bancos'] = ob_get_clean();
    	ob_end_clean();
		
		
		echo json_encode ( array (
				"result" => "OK",
				"campos" => $valores) );
		
	}
	 
	 function buscarBancos(){
		$proveedor 		= new proveedor();
		$prov_bancos	= $proveedor->getBancos($_POST ["id"]);
		$Array_bancos	= $prov_bancos->fetchAll();
		$count			= count($Array_bancos);
		$bancos			= $proveedor->getAllDatos ("bancos");
		$tipos_cuentas	= $proveedor->getAllDatos ("tipos_cuentas");		
		
		$banco_id=isset($Array_bancos[0]['bancos_id'])?$Array_bancos[0]['bancos_id']:'';
		$tipos_cuentas_id=isset($Array_bancos[0]['tipos_cuentas_id'])?$Array_bancos[0]['tipos_cuentas_id']:'';
		$nro_cuenta=isset($Array_bancos[0]['nro_cuenta'])?$Array_bancos[0]['nro_cuenta']:'';
		?>
	<div class="form-group aditionalOpt ">
		<div class="form-group col-xs-12 col-sm-8 col-md-7 col-lg-7 input" >
			<select class="form-select" id="prov_banco" name="prov_banco[]">
				<option value="" disabled selected >Seleccione un Banco</option>
				<?php					
					foreach ($bancos as $banco ) :
						?>
					<option value="<?php echo $banco["id"]; ?>" <?php if($banco_id==$banco["id"]){ echo 'selected';} ?> ><?php echo $banco["nombre"]; ?></option>
				<?php endforeach;?> 
			</select>								 
		</div>
		<div class="form-group col-xs-12 col-sm-4 col-md-5 col-lg-5 input" >								 
			<select class="form-select" id="prov_tipo_banco" name="prov_tipo_banco[]">
				<option value="" disabled selected>Tipo de Cuenta</option>							 
				<?php					
					foreach ($tipos_cuentas as $tipos ) :
						?>
					<option value="<?php echo $tipos["id"]; ?>" <?php if($tipos_cuentas_id==$tipos["id"]){ echo 'selected';} ?> ><?php echo $tipos["nombre"]; ?></option>
				<?php endforeach;?>
			</select>								 
		</div>
		<div class="form-group col-xs-11 col-sm-11 col-md-11 col-lg-11 input" >
			<input value="<?php echo $nro_cuenta; ?>"
			maxlength="20" type="text" placeholder="Ingrese solo numeros sin caracteres extraños" name="prov_nro_cuenta[]"
				class="form-input" id="prov_nro_cuenta">
		</div>
        <div class="col-xs-1 pad-left0">
            <button type="button" class="btn btn-default addButton t12"><i class="fa fa-plus"></i></button>
        </div>
		
	</div>
		
		<?php		
		for($i=1;$i<$count;$i++){
		?>
			<div class="form-group aditionalOpt ">
		        <div class="form-group col-xs-12 col-sm-8 col-md-7 col-lg-7 input marT10" >								 
					<select class="form-select" id="prov_banco" name="prov_banco[]">
						<option value="" disabled >Seleccione un Banco</option>
						<option  >Seleccione un Banco</option>
					<?php
					foreach ($bancos as $banco ) :
						?>
					<option value="<?php echo $banco["id"]; ?>"  <?php if($Array_bancos[$i]['bancos_id']==$banco["id"]){ echo 'selected';} ?> ><?php echo $banco["nombre"]; ?></option>
					<?php endforeach;?> 
					</select>								 
				</div>
				<div class="form-group col-xs-12 col-sm-4 col-md-5 col-lg-5 input marT10" >
					<select class="form-select" id="prov_tipo_banco" name="prov_tipo_banco[]">
						<option value="" disabled selected>Tipo de Cuenta</option>	 
						<?php
							foreach ($tipos_cuentas as $tipos ) :
								?>
							<option value="<?php echo $tipos["id"]; ?>" <?php if($Array_bancos[$i]['tipos_cuentas_id']==$tipos["id"]){ echo 'selected';} ?> ><?php echo $tipos["nombre"]; ?></option>
						<?php endforeach;?> 
					</select>								 
				</div>
				<div class="form-group col-xs-11 col-sm-11 col-md-11 col-lg-11 input" >
					<input value="<?php echo $Array_bancos[$i]['nro_cuenta']; ?>"
					 maxlength="20" type="text"	placeholder="Ingrese solo numeros sin caracteres extraños" name="prov_nro_cuenta[]"
						class="form-input" id="prov_nro_cuenta">
				</div>					
		        <div class="col-xs-1 pad-left0">
		            <button type="button" class="btn btn-default removeButton t12"><i class="fa fa-minus"></i></button>
		        </div>
		    </div>
		<?php
		}
		/*echo json_encode ( array (
				"result" => "OK",
				"campos" => $valores
		) );*/
	}
	function modificarProveedor() {
		$proveedor = new proveedor();
		
		$id = filter_input ( INPUT_POST, "id" );
		$tipo = filter_input ( INPUT_POST, "prov_tipo" );
		$documento = filter_input ( INPUT_POST, "prov_documento" );
		$nombre = filter_input ( INPUT_POST, "prov_nombre" );
		$telefono = filter_input ( INPUT_POST, "prov_telefono" );
		$email = filter_input ( INPUT_POST, "prov_email" );
		$direccion = filter_input ( INPUT_POST, "prov_direccion" );
			
		if (isset($_POST['diff_titular'])) {
		    $tipo_titular = filter_input ( INPUT_POST, "prov_tipo_titular" );
			$documento_titular = filter_input ( INPUT_POST, "prov_documento_titular" );
			$nombre_titular = filter_input ( INPUT_POST, "prov_nombre_titular" );
			$email_titular = filter_input ( INPUT_POST, "prov_email_titular" );			
			$listaValores_titular=array (
					"tipo" => $tipo_titular,
					"documento" => $documento_titular,
					"nombre" => $nombre_titular,
					"email" => $email_titular
					);
		}else{
			$listaValores_titular=array ();
		}		
		
		$tipos_bancos = $_POST['prov_tipo_banco'];
		$bancos = $_POST['prov_banco'];
		$nros_cuentas = $_POST['prov_nro_cuenta'];
		
		$listaValores_proveedor=array(
			"tipo"=>$tipo,
			"documento"=>$documento,
			"nombre"=>$nombre,
			"telefono"=>$telefono,
			"email"=>$email,
			"direccion"=>$direccion);
		$listaValores_bancos=array (
					"tipos_bancos_id" => $tipos_bancos,
					"bancos_id" => $bancos,
					"nro_cuentas" => $nros_cuentas
					);
		
		$proveedor->setID($id);
		$proveedor->modificarProveedor($listaValores_proveedor, $listaValores_titular, $listaValores_bancos);
		 
		 echo json_encode ( array (
					"result" => "ok"
			) );
	}

?>