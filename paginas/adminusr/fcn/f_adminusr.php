<?php 
	require '../../../config/core.php';
	include_once "../../../clases/usuarios.php";
	switch($_POST["metodo"]){
		case "buscar": 
			buscar();			
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
		
		$usuarios=new usuario($id_user);
		$status=$_POST["status"]; 
		$orden='';
		$pagina=$_POST["pagina"];
		$result=$usuarios->getUsuarios($status, $orden ,$pagina);
		foreach($result as $r=>$fila){

				?>
				<tr>
                    <td><?php echo $fila["seudonimo"]; ?></td>
                    <td><?php echo $fila["nombre"].' '.$fila["apellido"]; ?></td>
                    <td><?php echo $fila["rol"]; ?></td>
                    
                   <?php if($status=='1'){ ?>  
                        <td><a href="#mod" class="update_user show-select-rol" data-toggle="modal" data-target="#usr-update-info" data-rol-type="select" data-tipo="1" data-method="actualizar" data-usuarios_id="<?php echo $fila['id']; ?>"  ><i class="fa fa-lock" ></i> Modificar</a></td>
                        <td><a href="#del" class="select-usr-delete " data-toggle="modal" data-target='#msj-eliminar' data-status='3'  data-usuarios_id="<?php echo $fila['id']; ?>"   >
                        		<i class="fa fa-remove"></i> Eliminar
                        	</a> 
                        </td>
                   <?php }else if($status=='3'){ ?>
                   		<td><a href="#del" class="select-usr-active" data-toggle="modal" data-target='#msj-activar' data-status='1'  data-usuarios_id="<?php echo $fila['id']; ?>"   >
                        		<i class="fa fa-check"></i> Activar
                        	</a>
                        </td>
                   	<?php } ?>
                        <td><a href="#del" class="ver-detalle-user" data-toggle="modal" data-target='#info-user-detail' data-usuarios_id="<?php echo $fila['id']; ?>"   >
                        		<i class="fa fa-eye"></i> Ver
                        	</a> 
                        </td>
                    
                </tr>
                <?php
		}
	}
?>