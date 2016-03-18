<div class="row">
	<!-- inicion del row principal  -->

	<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 maB10  " >
		<!-- inicio contenido  -->

		<div class=" contenedor">
			<!-- inicio contenido conte1-1 -->

			<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10   "><!-- inicio titulo   -->	
				<h4 class=" marL20 marR20 t20 negro" style="padding:10px;"><span class="marL10">Publicaciones Automatizadas</span></h4>
				<center>
					<hr class='ancho95'>
				</center>
				<br>

				<ul class="nav nav-tabs marL30 marR30 t14 " >
					<li role="presentation" class="active pesta" id="irActivas">
						<a href="#"  class="grisO">Compartidas</a>
					</li>
					<li role="presentation" class="  pesta" id="irPausadas">
						<a href="#" class="grisO">Sin Compartir</a>
					</li>
				</ul>
			</div><!-- Fin titulo   -->

			<div class='col-sm-12 col-md-5 col-lg-4 marB10 '><!-- Buscador -->

				<form action="" method="GET"
				class="navbar-form navbar-left  marT15 marL30 " role="search">
				<div class="input-group" style="">
					<span class="input-group-btn">
						<button class="btn-header btn-default-header" style="border: #ccc 1px solid; border-right:transparent;"
							>
							<span class="glyphicon glyphicon-search"></span>
						</button>
					</span> <input style="margin-left: -10px; border: #ccc 1px solid; border-left:1px solid #FFF;  "
						name="c" type="text" class="form-control-header "
						placeholder="Buscar">
				</div>
			</form>
			</div><!-- fin de buscador -->

			<div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 marB10 marT15" >
				<button type="button" class="btn btn-primary2 marL20 hidden"> <i class="fa fa-plus-square marR5"></i> Agregar Mensaje</button>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10">

				<div class="marL30 marR20" style="background: #F2F2F2;">

					<table width="100%" class="alto50" border="0" cellspacing="0" cellpadding="0" >
						<tr>					
							<td  width="75%"  align="right"><span class="marR10">Publicaciones 1 - 50 de <b>100</b></span></td>
							<td   width="15%"  align="right" height="40px;" >
							<select id="filtro" class="form-control  input-sm " style="width:auto; margin-right:20px;">
								<option value="desc" >Mas Recientes</option>
								<option value="asc" >Menos Recientes </option>
								<option value="desc" >Mayor Precio</option>
								<option value="asc" >Menor Precio </option>
							</select></td>
						</tr>
					</table>

				</div>

			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10"></div> <!--Espaciado -->

			<div class='row  marB10 marT10 marL50 marR30'>	
				<div id="listaPublicaciones">
					<ul id="active_publications">
					
					
					</ul>
				
				
				<!-- fin de la fila de la publicacion  -->
				
					<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10'> <!-- Paginacion -->
					<nav class='text-center'>
						<ul class='pagination'>
						<li>
						  <a href='#' aria-label='Previous'>
							<span aria-hidden='true'>&laquo;</span>
						  </a>
						</li>
						<li>
							<a href='#'>1</a>
						</li>
						<li>
						  <a href='#' aria-label='Next'>
							<span aria-hidden='true'>&raquo;</span>
						  </a>
						</li>
					  </ul>
					</nav>
					</div>	
				
				</div><!-- FIN de la paginacion -->
				

			</div>

		</div>
		<!-- fin contenido conte1-1 -->

	</div >
	<!-- fin de contenido -->

</div>
<!-- fin de row principal  -->

