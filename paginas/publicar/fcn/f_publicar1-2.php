<?php require '../../../config/core.php';
if (!headers_sent()) {
	header('Content-Type: text/html; charset=UTF-8');
}

?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
	<div class="contenedor " style="margin-top: 5px; z-index: 1; padding-bottom: 20px;">
		<div class="row"
			style="margin-left: 15px; margin-right: 15px; padding-top: 10px; padding-bottom: 10px;">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
				<div class="vin-blue" style="padding:10px;">
					<a href="#" onclick="document.location.reload()"><i class="fa fa-angle-double-left marL30"></i> Atras</a>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 ">
				<div class="">
					<img alt="" id="imagenclasificado"
						class="center-block marT10 marB10 ">
				</div>
			</div>
			<div id="ajaxListas">
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 listaclasificados" data-nivel="1">
					<div class="div-select-publicar" style="padding-right: 20px;">
						<!--<div class="badge badge-publicar"
							style="position: absolute; float: left; top:3px; left:-2px; -webkit-box-shadow: -1px 2px 57px -7px rgba(0,0,0,0.5);
	-moz-box-shadow: -1px 2px 57px -7px rgba(0,0,0,0.5);
	box-shadow: -1px 2px 57px -7px rgba(0,0,0,0.5);">1</div>-->
						<select class="form-select-publicar center-block" size="15">
							<?php 
							include_once "../../../clases/clasificados.php";
							$clasificado = new clasificados();
							//$resultado=$clasificado->buscarHijos($_POST["id_clasificados"]);
							
							$resultado=$clasificado->buscarPadresdeHijos("'1039','1051','1648','5726','1000','1430','3937','1144'");
							foreach ($resultado as $r):?>
								<option value="<?php echo $r["id"];?>"><?php echo $r["nombre"];?></option>
								 
							<?php endforeach;?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 " id="ok" style="visibility:hidden;">
				<div class="" style="padding-right: 20px;">
					<div class="text-center">
					<span class="fa-stack fa-lg green marT10" style="font-size: 60px;">
          <i class="fa fa-circle fa-stack-2x"></i>
          <i class="fa fa-thumbs-up fa-stack-1x fa-inverse "></i>
        </span>
					<br>
					<h2>&iexcl;Listo!</h2>
					<br>
					<button class="btn btn-primary2 t20" type="button" id="btnOk">Continuar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>