<?php include "clases/proveedor.php"; ?>
<div class="pad20 contenedor">
            <div class="marB20">
                <h4>
                    Panel administrativo de Proveedores
                </h4>
                <hr>
                <br>             
                <div class="text-right">
                   <a class="admin-reg-prov" href="#" data-toggle='modal' data-target='#reg-prov' data-rol-type='select'  data-tipo='1' >
						<button class="btn2 btn-default t16 " style="">Agregar Proveedor</button>
					</a>
                </div>
            </div>       
            <div class="tab-content">
                <div class="tab-pane active" id="tab-shop-active">
                    <div id="lista-prov-active">
                        <table class="table  text-center table-hover">
                            <tr style="background: #D8DFEA">
                                <th class="text-center">
                                    Documento
                                </th>
                                <th class="text-center">
                                    Nombre
                                </th>
                                <th class="text-center">
                                    Telefono
                                </th>
                                <th colspan="1" class="text-center">
                                    Email
                                </th>
                                <th colspan="2" class="text-center">
                                    Acci&oacute;n
                                </th>
                            </tr>
                            <tbody id="ajaxContainer">
                                <?php                               
                                $proveedor = new proveedor();								
                                $result=$proveedor->getProveedores('count(id) as total')->fetch();
								$total=$result['total'];
                                $totalPaginas=ceil($total/25);
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="paginacion" name="paginacion" class='col-xs-12 col-sm-12 col-md-12 col-lg-12 ' data-paginaActual='1' data-total="<?php echo $total;?>"><center><nav><ul class='pagination'>
					    	<!--
								<li><a href='listado.php' aria-label='Previous'><i class='fa fa-angle-double-left'></i></a></li>
								<li><a href='#' aria-label='Previous'><i class='fa fa-angle-left'></i></a></li>
								-->
									<li id="anterior2" name="anterior2" class="hidden"><a href='#' aria-label='Previous' class='navegador' data-status="1" data-container="#lista-shop-active"  data-funcion='anterior2'><i class='fa fa-angle-double-left'></i> </a>
									<li id="anterior1" name="anterior1" class="hidden"><a href='#' aria-label='Previous' class='navegador' data-status="1" data-container="#lista-shop-active"  data-funcion='anterior1'><i class='fa fa-angle-left'></i> </a>											
									<?php
									$oculto="";
									$activo="active";									
									for($i=1;$i<=$totalPaginas;$i++):
									?>
										<li class="<?php echo $activo; echo $oculto;?>"><a class="botonPagina" href='#' data-status="1" data-container="#lista-shop-active" data-pagina="<?php echo $i;?>"><?php echo $i;?></a></li>
									<?php
									$activo="";
									if($i==10)
									$oculto=" hidden";
									endfor;
								?>
								<?php
									if($totalPaginas>1):
									?>								
										<li id="siguiente1" name="siguiente1"><a href='#' data-status="1" data-container="#lista-shop-active" aria-label='Next' class='navegador' data-funcion='siguiente1'><i class='fa fa-angle-right'></i> </a>
									<?php
									endif;
									?>
								<?php
									if($totalPaginas>10):
										?>
										<li id="siguiente2" name="siguiente2"><a href='#' data-status="1" data-container="#lista-shop-active" aria-label='Next' class='navegador' data-funcion='siguiente2'><i class='fa fa-angle-double-right'></i> </a>
									<?php
									endif;
								?>
								</li></ul>
						</nav></center></div>
                </div>
                
            </div>
        </div>