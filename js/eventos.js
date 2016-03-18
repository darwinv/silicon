$(document).ready(function(){
	var url_path = "/Electronics/";
	
	$("#insc_usr").click(function(){
		$("#fondo").show();
		$("#div_insc_usr").show();
	});
	
	$("#ing_usr").click(function(){
		$("#fondo").show();
		$("#div_ing_usr").show();
	});
	
	$("#insc_usr_log").click(function(){
		$("#div_insc_usr").show();
		$("#div_ing_usr").hide();
	});
	
	$("#cuenta_admin").click(function(){
		$("#fondo").show();
		$("#div_cuenta").show();
	});
	
	$("#ingresar").click(function(){
		if($("#tipo_usuario_ing").val() == "usuario"){
			usu = 1
		}
		else{
			usu = 2
		}
		$.post(url_path+"validar_usuario.php", { val0 : $("#input1_mail_ing").val(), val1 : $("#input1_pass_ing").val(), val2 : usu, val3 : $("#tipo_usuario_ing").val() }, function(data){
			if(data[0].opc == 0){
				alert("No tiene permisos de acceso");
				$("#input1_mail_ing").val("");
				$("#input1_pass_ing").val("");
			}
			else{
				if($("#tipo_usuario_ing").val() == "usuario"){
					location.href = url_path+"index.php";
				}
				else{
					location.href = url_path+"Elect-Admin/resumen-admin.php";
				}
			}
		}, "json");
	});
	
	$("#buscar").click(function(){
		$("#tipo_busqueda").val("advanced");
		form1.action = url_path+"listado.php";
		form1.submit();
	});
	
	$("#input3_lista").change(function () {
		$("#input3_lista option:selected").each(function () {
			if($("#input3_lista").val() == "null"){
				$("#input4_lista").attr("disabled",true);
				$("#input4_lista").val("null");
				$("#input5_lista").attr("disabled",true);
				$("#input5_lista").val("null");
			}
			else{
				$.post("usuarios/ajax/buscar_estado.php", { id: $("#input3_lista").val() }, function(data){
					$("#input4_lista").empty();
					$("#input4_lista").html(data);
					$("#input4_lista").removeAttr("disabled");
				});
			}            
		});
	});
	
	$("#input4_lista").change(function () {
		$("#input4_lista option:selected").each(function () {
			if($("#input4_lista").val() == "null"){
				$("#input5_lista").attr("disabled",true);
				$("#input5_lista").val("null");
			}
			else{
				$.post("usuarios/ajax/buscar_ciudad.php", { id: $("#input4_lista").val() }, function(data){
					$("#input5_lista").empty();
					$("#input5_lista").html(data);
					$("#input5_lista").removeAttr("disabled");
				});
			}            
		});
	});
	
	$("#input1_cedu").blur(function() {
		if($("#input1_cedu").val() == ""){
			return;
		}
		$.post("usuarios/ajax/validar_cedula.php", { val0 : $("#input1_lista").val(), val1 : $("#input2_lista").val(), val2 : $("#input1_cedu").val() }, function(data){
			if(data[0].opc == 1){
				$("#input1_name").val(data[0].nombre);
				$("#input2_name").val(data[0].apellido);
				$("#input1_telf").val(data[0].telefono);
				$("#input3_lista").empty();
				$("#input3_lista").append("<option value='"+data[0].id_pais+"' selected='selected'>"+data[0].pais+"</option>");
				$("#input4_lista").append("<option value='"+data[0].id_estado+"' selected='selected'>"+data[0].estado+"</option>");
				$("#input5_lista").append("<option value='"+data[0].id_ciudad+"' selected='selected'>"+data[0].ciudad+"</option>");
				$("#input1_dir").val(data[0].direccion);
				$("#input1_lista").attr("disabled", "true");
				$("#input2_lista").attr("disabled", "true");
				$("#input1_cedu").attr("readonly", "true");
				$("#input1_name").attr("readonly", "true");
				$("#input2_name").attr("readonly", "true");
				$("#input1_telf").attr("readonly", "true");
				$("#input3_lista").attr("disabled", "true");
				$("#input1_dir").attr("readonly", "true");
			}
		}, "json");
	});
	
	//inicio agregar fotos para mostrar por pantalla jquery
	$('#imagen_publicar1').change(function(e) {
		$("#imagen_text").val("#imagen_publicar1");
		$("#cargar_imagen").val("#btn_imagen_publicar1");
		addImage(e); 
	})
	
	$('#imagen_publicar2').change(function(e) {
		$("#imagen_text").val("#imagen_publicar2");
		$("#cargar_imagen").val("#btn_imagen_publicar2");
		addImage(e); 
	})
	
	$('#imagen_publicar3').change(function(e) {
		$("#imagen_text").val("#imagen_publicar3");
		$("#cargar_imagen").val("#btn_imagen_publicar3");
		addImage(e); 
	})
	
	$('#imagen_publicar4').change(function(e) {
		$("#imagen_text").val("#imagen_publicar4");
		$("#cargar_imagen").val("#btn_imagen_publicar4");
		addImage(e); 
	})
	
	$('#imagen_publicar5').change(function(e) {
		$("#imagen_text").val("#imagen_publicar5");
		$("#cargar_imagen").val("#btn_imagen_publicar5");
		addImage(e); 
	})
	
	$('#imagen_publicar6').change(function(e) {
		$("#imagen_text").val("#imagen_publicar6");
		$("#cargar_imagen").val("#btn_imagen_publicar6");
		addImage(e); 
	})
	//fin agregar fotos para mostrar por pantalla
	
	//inicio eventos de publicar	
	$("#publicar_producto").click(function () {
		location.href="publicar/publicar.php";
	});
	
	$("#image_publicar").click(function () {
		menu_publicar("div_principal");
	});
	
	$("#opc_publicar").click(function () {
		menu_publicar("div_categorias");
	});
	
	$("#opc_publicar1").click(function () {
		if ($(this).hasClass('pointer')){
			menu_publicar("div_descripcion");
			$("#aux_posicion").val("descripcion");
		}
	});
	
	$("#opc_publicar2").click(function () {
		if ($(this).hasClass('pointer')){
			menu_publicar("div_precios");
			$("#aux_posicion").val("precios");
		}
	});
	
	$("#opc_publicar3").click(function () {
		if ($(this).hasClass('pointer')){
			menu_publicar("div_confirmar");
			$("#aux_posicion").val("confirmar");
			$("#opc_publicar2").removeClass();
			$("#opc_publicar2").attr("class","aliniar-left2 box pointer");
			$("#opc_publicar3").removeClass();
			$("#opc_publicar3").attr("class","aliniar-left2 box2 pointer");
			$("#aux_posicion").val("confirmar");
			$("#paso_publicar").val("confirmar");
			$("#div_precios").hide();
			$("#div_confirmar").show();
			$("#direccion_publicar").html($("#path_publicar").val());
			$("#tit_producto").html($("#titulo_producto").val());
			if($("#link_video").val() == ""){
				$("#video_publicar").html("No exite link de youtube");
			}
			else{
				$("#video_publicar").html($("#link_video").val());
			}
			$("#cant_publicar").html($("#cantidad").val()+" Unidades");
			$("#precio_publicar").html("BsF "+$("#precio").val());
			if($("#garantia1").is(':checked')) {  
				$("#garantia_publicar").html("Garant&iacute;a (Si)");
			}
			if($("#garantia2").is(':checked')) {  
				$("#garantia_publicar").html("Garant&iacute;a (No)");
			}
			if($("#condicion_producto1").is(':checked')) {  
				$("#condicion_publicar").html("Condici&oacute;n (Nuevo)");
			}
			if($("#condicion_producto2").is(':checked')) {  
				$("#condicion_publicar").html("Condici&oacute;n (Usado)");
			}
			
			fecha = $("#fecha").val();
			fecha_array = fecha.split("-");
			$("#fecha_publicacion").html("Tu publicacion iniciara "+fecha_array[2]+"/"+fecha_array[1]+"/"+fecha_array[0]+" "+$("#hora").val()+":"+$("#minutos").val());
		}
	});
	
	$("#publi_1").change(function () {
		$("#publi_1 option:selected").each(function () {
			$("#publi_3").empty();
			$("#publi_4").empty();
			$("#publi_5").empty();
			$("#publi_6").empty();
			$("#div_publi_3").hide();
			$("#div_publi_4").hide();
			$("#div_publi_5").hide();
			$("#div_publi_6").hide();
			$("#div_publi_7").hide();
			$.post("ajax/llenar_combo.php", { id: $("#publi_1").val(), id1: $("#publi_1").val(), id2: 2 }, function(data){
				$("#div_publi_2").empty();
				$("#div_publi_2").append(data[0].opc);
				$("#div_publi_2").show();
				$("#paso_publicar").val("categorias")
			}, "json");         
		});
	});
	
	$("#garantia1").click(function(){
		if($("#garantia1").is(':checked')) {  
            $("#tiempo_garantia").attr('readonly', false);
			$("#medida_garantia").attr('disabled', false);
        }
	});
	
	$("#garantia2").click(function(){
		if($("#garantia2").is(':checked')) {  
            $("#tiempo_garantia").attr('readonly', true);
			$("#medida_garantia").attr('disabled', true);
        }
	});
	
	$("#direccion_publicar").click(function(){
		$("#div_categorias").show();
		$("#div_confirmar").hide();
		$("#aux_posicion").val("categorias");
	});
	
	$("#tit_producto").click(function(){
		$("#div_descripcion").show();
		$("#div_confirmar").hide();
		$("#aux_posicion").val("descripcion");
	});
	
	$("#video_publicar").click(function(){
		$("#div_descripcion").show();
		$("#div_confirmar").hide();
		$("#aux_posicion").val("descripcion");
	});
	
	$("#imagenes_publicar").click(function(){
		$("#div_descripcion").show();
		$("#div_confirmar").hide();
		$("#aux_posicion").val("descripcion");
	});
	
	$("#descrip_publi").click(function(){
		$("#div_descripcion").show();
		$("#div_confirmar").hide();
		$("#aux_posicion").val("descripcion");
	});
	
	$("#condicion_publicar").click(function(){
		$("#div_descripcion").show();
		$("#div_confirmar").hide();
		$("#aux_posicion").val("descripcion");
	});
	
	$("#cant_publicar").click(function(){
		$("#div_precios").show();
		$("#div_confirmar").hide();
		$("#aux_posicion").val("precios");
	});
	
	$("#precio_publicar").click(function(){
		$("#div_precios").show();
		$("#div_confirmar").hide();
		$("#aux_posicion").val("precios");
	});
	
	$("#garantia_publicar").click(function(){
		$("#div_precios").show();
		$("#div_confirmar").hide();
		$("#aux_posicion").val("precios");
	});
	
	$("#fecha_publicacion").click(function(){
		$("#div_precios").show();
		$("#div_confirmar").hide();
		$("#aux_posicion").val("precios");
	});
	//fin eventos de publicar
	
	//inicio desplegar busqueda de imagen publicar
	$("#btn_imagen_publicar1").click(function(){
		$("#imagen_publicar1").click();
	});
	
	$("#btn_imagen_publicar2").click(function(){
		$("#imagen_publicar2").click();
	});
	
	$("#btn_imagen_publicar3").click(function(){
		$("#imagen_publicar3").click();
	});
	
	$("#btn_imagen_publicar4").click(function(){
		$("#imagen_publicar4").click();
	});
	
	$("#btn_imagen_publicar5").click(function(){
		$("#imagen_publicar5").click();
	});
	
	$("#btn_imagen_publicar6").click(function(){
		$("#imagen_publicar6").click();
	});
	//fin desplegar busqueda de imagen publicar
	
	//inicio preguntas publicacion
	$("#Image28").click(function(){
		if($("#opc_3").val() == "no"){
			alert("No has ingresado como usuario, por favor ingresa o registrate");
			return false;
		}
		if($("#textarea").val() == ""){
			alert("Debes llenar la pregunta");
			return false;
		}
		$.post("../ajax/agr_pregunta.php", { id : $("#id_publicacion").val(), id_usuario : $("#id_usuario").val(), preg : $("#textarea").val() }, function(data){
			valor = data[0].opc;
			val = valor.split("*");
			if(val[0] == 0){
				alert("No se pudo agregar la pregunta, por favor intente de nuevo");
			}
			else{
				$("#textarea").val("");
				$("#tabla_preguntas").append(val[1]);
			}
		}, "json");        
	});
	//fin preguntas publicacion	
	
	//inicio compra usuario
	$("#compra-det").click(function(){
		$.post("../ajax/compra_cliente.php", { cant : $("#cant").val(), precio : $("#precio").val(), id : $("#id_publicacion").val(), id_usuario : $("#id_usuario").val() }, function(data){
			val = data[0].opc;
			valor = val.split("*");
			if(valor[0] == 0){
				alert("No se pudo realizar la compra, por favor int&eacute;ntelo m&aacute;s tarde");
			}
			else{
				$("#id_venta").val(valor[1]);
				form1.action = url_path+"dat_concretar.php";
				form1.submit(); 
			}
		}, "json");             
	});
	
	$("#Image19").click(function(){
		form1.action = "info-pago.php";
		form1.submit();
	});
	
	$("#forma_pago").change(function () {
		$("#forma_pago option:selected").each(function () {
			if($("#forma_pago").val() == 4){
				$("#banco").attr('disabled', true);
				$("#banco").val("null");
				$("#num_registro").attr('readonly', true);
				$("#num_registro").val("");
			}    
			else{
				$("#banco").attr('disabled', false);
				$("#num_registro").attr('readonly', false);
			}
		});
	});
	
	$("#Image1").click(function(){
		if($("#RadioGroup3_0").is(':checked')){
			check = $("#RadioGroup3_0").val()
		}
		else{
			check = $("#RadioGroup3_1").val()
		}
		
		if($("#titular").is(':checked')){
			titular = 1
		}
		else{
			titular = 0
		}
		$.post("ajax/informar_pago.php", { fecha : $("#fecha").val(), forma_pago : $("#forma_pago").val(), monto : $("#monto").val(), num_registro : $("#num_registro").val(), check : check, id_venta : $("#id_venta").val(), banco : $("#banco").val(), id_pers : $("#id_pers").val(), titular : titular, nombre : $("#nombre").val(), docu : $("#docu").val(), tipo : $("#tipo").val(), cedu : $("#input1_cedu").val() }, function(data){
			if(data[0].opc == 0){
				alert("No se pudo realizar la compra, por favor int&eacute;ntelo m&aacute;s tarde");
			}
			else{
				form1.action = url_path+"listado.php";
				form1.submit(); 
			}
		}, "json");  
	});
	//fin compra usuario
	
	//inicio funcion del editor jquery
	var initEditor = function() {
		$("textarea").sceditor({
			plugins: 'bbcode',
			style: "./minified/jquery.sceditor.default.min.css"
		});
	};

	$("#theme").change(function() {
		var theme = "./minified/themes/" + $(this).val() + ".min.css";
		$("textarea").sceditor("instance").destroy();
		$("link:first").remove();
		$("#theme-style").remove();

		loadCSS(theme, initEditor);
	});

	initEditor();
	//fin funcion del editor
});

function MM_swapImgRestore() { //v3.0
	var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
	var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
	var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
	if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
	var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
	d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
	if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
		for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
    if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
	var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
	if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function volver(){
	if($("#tipo_volver_continuar").val() == "publicar"){
		if($("#aux_posicion").val() == "descripcion"){
			$("#aux_posicion").val("categorias");
			menu_publicar("div_categorias");
		}
			
		if($("#aux_posicion").val() == "precios"){
			$("#aux_posicion").val("descripcion");
			menu_publicar("div_descripcion");
		}
		
		if($("#aux_posicion").val() == "confirmar"){
			$("#aux_posicion").val("precios");
			menu_publicar("div_precios");
		}
	}
}

//inicio publicar	
function continuar(){
	$("html, body").animate({scrollTop: 0}, 0);
	if($("#tipo_volver_continuar").val() == "publicar"){
		if($("#aux_posicion").val() == "descripcion"){
			if(validar_div_descrip() == false){
				return false;
			}
			$("#opc_publicar1").removeClass();
			$("#opc_publicar1").attr("class","aliniar-left2 box pointer");
			$("#opc_publicar2").removeClass();
			$("#opc_publicar2").attr("class","aliniar-left2 box2");
			$("#opc_publicar3").removeClass();
			$("#opc_publicar3").attr("class","aliniar-left2 box");
			$("#div_descripcion").hide();
			$("#aux_posicion").val("precios");
			$("#div_precios").show();
			$("#paso_publicar").val("precios");
		}
		else if($("#aux_posicion").val() == "precios"){
			if(validar_div_precios() == false){
				return false;
			}
			$("#opc_publicar2").removeClass();
			$("#opc_publicar2").attr("class","aliniar-left2 box pointer");
			$("#opc_publicar3").removeClass();
			$("#opc_publicar3").attr("class","aliniar-left2 box2 pointer");
			$("#aux_posicion").val("confirmar");
			$("#paso_publicar").val("confirmar");
			$("#div_precios").hide();
			$("#div_confirmar").show();
			$("#direccion_publicar").html($("#path_publicar").val());
			$("#tit_producto").html($("#titulo_producto").val());
			$("#img_publicar").attr("src",url_imagen_publicar());
			img_publicar
			if($("#link_video").val() == ""){
				$("#video_publicar").html("No exite link de youtube");
			}
			else{
				$("#video_publicar").html($("#link_video").val());
			}
			$("#cant_publicar").html($("#cantidad").val()+" Unidades");
			$("#precio_publicar").html("BsF "+$("#precio").val());
			if($("#garantia1").is(':checked')) {  
				$("#garantia_publicar").html("Garant&iacute;a (Si)");
			}
			if($("#garantia2").is(':checked')) {  
				$("#garantia_publicar").html("Garant&iacute;a (No)");
			}
			if($("#condicion_producto1").is(':checked')) {  
				$("#condicion_publicar").html("Condici&oacute;n (Nuevo)");
			}
			if($("#condicion_producto2").is(':checked')) {  
				$("#condicion_publicar").html("Condici&oacute;n (Usado)");
			}
			
			fecha = $("#fecha").val();
			fecha_array = fecha.split("-");
			$("#fecha_publicacion").html("Tu publicacion iniciara "+fecha_array[2]+"/"+fecha_array[1]+"/"+fecha_array[0]+" "+$("#hora").val()+":"+$("#minutos").val()); 
		}
	}
}


function menu_publicar(div_activar){
	if($("#paso_publicar").val() == "descripcion"){
		$("#opc_publicar1").removeClass();
		$("#opc_publicar1").attr("class","aliniar-left2 box2 pointer");
	}
	else if($("#paso_publicar").val() == "precios"){
		$("#opc_publicar1").removeClass();
		$("#opc_publicar1").attr("class","aliniar-left2 box pointer");
		$("#opc_publicar2").removeClass();
		$("#opc_publicar2").attr("class","aliniar-left2 box2 pointer");
	}
	else if($("#paso_publicar").val() == "confirmar"){
		$("#opc_publicar3").removeClass();
		$("#opc_publicar3").attr("class","aliniar-left2 box2 pointer");
	}
	
	$("#div_principal").hide();
	$("#div_categorias").hide();
	$("#div_descripcion").hide();
	$("#div_precios").hide();
	$("#div_confirmar").hide();
	$("#"+div_activar).show();
}

function opcion_publicar(clasif, imagen){
	if($("#id_clasificacion").val() != clasif){
		$("#id_clasificacion").val(clasif);
		$("#div_principal").hide();
		$("#div_categorias").show();
		$("#image_publicar").attr("src", "/Electronics/imagenes/"+imagen+".png");
		$("#publi_2").hide();
		$("#publi_3").empty();
		$("#publi_4").empty();
		$("#publi_5").empty();
		$("#publi_6").empty();
		$("#div_publi_2").hide();
		$("#div_publi_3").hide();
		$("#div_publi_4").hide();
		$("#div_publi_5").hide();
		$("#div_publi_6").hide();
		$("#div_publi_7").hide();
		$("#paso_publicar").val("categorias");
		
		$.post("ajax/llenar_combo1.php", { id: $("#id_clasificacion").val() }, function(data){
			$("#publi_1").empty();
			$("#publi_1").html(data);
		});
	}   
	else{
		$("#div_principal").hide();
		$("#div_categorias").show();
	}
}

function cont_descrip(){
	$("#paso_publicar").val("descripcion");
	$("#aux_posicion").val("descripcion");
	$("#opc_publicar").removeClass();
	$("#opc_publicar").attr("class","aliniar-left2 box pointer");
	$("#opc_publicar1").removeClass();
	$("#opc_publicar1").attr("class","aliniar-left2 box2");
	$("#opc_publicar2").removeClass();
	$("#opc_publicar2").attr("class","aliniar-left2 box");
	$("#opc_publicar3").removeClass();
	$("#opc_publicar3").attr("class","aliniar-left2 box");
	$("#div_categorias").hide();
	$("#img_descrip").attr("src",url_imagen_publicar());
	
	$.post("ajax/direc_producto_vender.php", { id: $("#id_clasificacion").val(), id1: $("#publi_1").val(), id2: $("#publi_2").val(), id3: $("#publi_3").val(), id4: $("#publi_4").val(), id5: $("#publi_5").val(), id6: $("#publi_6").val() }, function(data){
		$("#producto_vender").empty();
		$("#producto_vender").append(data[0].opc);
		$("#producto_vender").append(" <a href='#'>modificar</a>");
		if(data[0].opc != $("#path_publicar").val()){
			$("#producto_vender").val("");
			$("#btn_imagen_publicar1").attr("src","/Electronics/imagenes/botones/agregar.png");
			$("#btn_imagen_publicar2").attr("src","/Electronics/imagenes/botones/agregar.png");
			$("#btn_imagen_publicar3").attr("src","/Electronics/imagenes/botones/agregar.png");
			$("#btn_imagen_publicar4").attr("src","/Electronics/imagenes/botones/agregar.png");
			$("#btn_imagen_publicar5").attr("src","/Electronics/imagenes/botones/agregar.png");
			$("#btn_imagen_publicar6").attr("src","/Electronics/imagenes/botones/agregar.png");
			$("#imagen_publicar1").val("");
			$("#imagen_publicar2").val("");
			$("#imagen_publicar3").val("");
			$("#imagen_publicar4").val("");
			$("#imagen_publicar5").val("");
			$("#imagen_publicar6").val("");
			$("#link_video").val("");
			$("#titulo_producto").val("");
			$("#descrip_producto").val("");
			$("#condicion_producto1").attr('checked', true);
			$("#condicion_producto2").attr('checked', false);
			$("#path_publicar").val(data[0].opc);
		}
	}, "json");   
	$("#div_descripcion").show();
}

function url_imagen_publicar(){
	url_imagen = "";
	if($("#id_clasificacion").val() == 1){
		url_imagen = "../../imagenes/vehiculos.png";
	}
	else if($("#id_clasificacion").val() == 2){
		url_imagen = "../../imagenes/inmuebles.png";
	}
	else if($("#id_clasificacion").val() == 3){
		url_imagen = "../../imagenes/servicios.png";
	}
	else{
		url_imagen = "../../imagenes/productos.png";
	}
	return url_imagen;
}

function publicar(){
	form1.action = "guardar.php";
	form1.submit();
}
//fin publicar

function cerrar_contenedor(div){
	$("#fondo").hide();
	$(div).hide();
	$("#input1_lista").removeAttr("disabled");
	$("#input2_lista").removeAttr("disabled");
	$("#input1_cedu").removeAttr("readonly");
	$("#input1_name").removeAttr("readonly");
	$("#input2_name").removeAttr("readonly");
	$("#input1_telf").removeAttr("readonly");
	$("#input3_lista").removeAttr("disabled");
	$("#input3_lista").empty();
	$.post("usuarios/ajax/buscar_pais.php", { }, function(data){
		$("#input3_lista").empty();
		$("#input3_lista").html(data);
		$("#input3_lista").removeAttr("disabled");
	})
	$("#input1_dir").removeAttr("readonly");
	$("#input1_name").val("");
	$("#input2_name").val("");
	$("#input1_lista").val("C.I.");
	$("#input2_lista").val("V");
	$("#input1_cedu").val("");
	$("#input1_cedu").change();
	$("#input1_mail").val("");
	$("#input2_mail").val("");
	$("#input1_telf").val("");
	$("#input1_dir").val("");
	$("#input1_pass").val("");
	$("#input2_pass").val("");
	$("#input3_lista").val("null");
	$("#input4_lista").val("null");
	$("#input4_lista").attr("disabled","true");
	$("#input5_lista").val("null");
	$("#input5_lista").attr("disabled","true");
	$("#fondo").hide();
	$("#div_insc_usr").hide();
}

//inicio funcion del editor
// Source: http://www.backalleycoder.com/2011/03/20/link-tag-css-stylesheet-load-event/
var loadCSS = function(url, callback){
	var link = document.createElement('link');
	link.type = 'text/css';
	link.rel = 'stylesheet';
	link.href = url;
	link.id = 'theme-style';

	document.getElementsByTagName('head')[0].appendChild(link);

	var img = document.createElement('img');
	img.onerror = function(){
		if(callback) callback(link);
	}
	img.src = url;
}
//fin funcion del editor

//inicio funcion para agregar imagen en div
function addImage(e){
	file = e.target.files[0],
	imageType = /image.*/
    
	if (!file.type.match(imageType)){
		alert("El archivo no es una imagen");
		$($("#imagen_text").val()).val("");
		return
	}
  
	reader = new FileReader();
	reader.onload = fileOnload;
	reader.readAsDataURL(file);
}
  
function fileOnload(e) {
	result=e.target.result
	$($("#cargar_imagen").val()).attr("src",result);
}
//fin funcion para agregar imagen en div

function status_envio(){
	/*if($("#tiempo_espera_envio").is(':display')){
		$("#tiempo_espera_envio").hide();
	}
	else{
		$("#tiempo_espera_envio").show();
	}*/
}

function buscar_listado_categoria(id_busqueda){
	$("#categ_buscar").val(id_busqueda);
	$("#tipo_busqueda").val("categoria");
	form1.submit();
}

function detalle_publicacion(id_publicacion){
	$("#id_publicacion").val(id_publicacion);
	form1.submit();
}