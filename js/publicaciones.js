/**
 * JavaScript publicar.php
 */
/*
 La activa debe tener btn,btn-default2,btn-default2-active y sin default
 La que no este activa debe tener las clases:btn,btn-default2
 La que no este activa que btn,btn-default2 y el disabled
 */
$(document).ready(function() {
//	var a=jQuery.noConflict(true);
	$('head').append('<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />');
	/*
	 * 1er Paso: Pasar a publicar1-2.php
	 */
	$(".catg").click(function() {
		var laimagen = $(this).children("img").attr("src");
		$.ajax({
			url : "paginas/publicar/fcn/f_publicar1-2.php",
			data : {
				id_clasificados : $(this).data("idcatg")
			},
			type : "POST",
			dataType : "html",
			success : function(data) {
				$("#ajaxContainer").html(data);
				$("#imagenclasificado").attr("src", laimagen);
			},
			error : function(xhr, status) {
				SweetError(status);
			}
		});
	});
	/*
	 * 2do Paso: Cargar selects de clasificados mediante seleccion
	 */
	$("#ajaxContainer").on('change', '.listaclasificados', function() {
		var laimagen = $(this).children("img").attr("src");
		var nivel = $(this).data("nivel");
		//$(this).find(".badge").removeClass("badge-publicar");
		var copia = $(this).clone();
		//$(".badge").removeClass("badge-publicar-antes");
		//$(".badge").addClass("badge-publicar");
		$clasificado = $(this).find(".form-select-publicar").val();
		$.ajax({
			url : "paginas/publicar/fcn/f_publicaciones.php",
			data : {
				id_clasificados : $clasificado,
				metodo : "traerClasificados"
			},
			type : "POST",
			dataType : "json",
			success : function(data) {
				//console.log(data);
				if (data.resultado != "Error") {
					copia.data("nivel", nivel++);
					var nivelUltimo = $("#ajaxListas > div").last().data("nivel");
					while ((nivel - 1) < nivelUltimo) {
						$("#ajaxListas > div").last().remove();
						nivelUltimo = $("#ajaxListas > div").last().data("nivel");
					}
					$("#ajaxListas").append(copia);
					$("#ajaxListas > div").last().data("nivel", nivel);
					$("#ajaxListas > div").last().find(".form-select-publicar").attr("id", "select" + nivel);
					//$("#ajaxListas > div").last().find(".badge").html(nivel);
					$("#select" + nivel).html("");
					for (var campos in data) {
						$("#select" + nivel).append("<option value='" + data[campos].campos.id + "'>" + data[campos].campos.nombre + "</option>");
					}
					$("#ok").css("visibility", "hidden");
				} else {
					$("#ok").css("visibility", "visible");
					var nivelUltimo = $("#ajaxListas > div").last().data("nivel");
					while ((nivel) < nivelUltimo) {
						$("#ajaxListas > div").last().remove();
						nivelUltimo = $("#ajaxListas > div").last().data("nivel");
					}
				}
			},
			error : function(xhr, status) {
				SweetError(status);
			}
		});
	});
	/*
	 * 3er Paso: Codigo para pasar a publicar 2
	 */
	$("#ajaxContainer").on('click', '#btnOk', function() {
		//Guardar imagen actual
		var laimagen = $("#imagenclasificado").attr("src");
		//ejecutamos ajax para pasar a 2.
		$.ajax({
			url : "paginas/publicar/fcn/f_publicar2.php",
			data : {
				id : $("#ajaxListas > div").last().find(".form-select-publicar").val()				
			},
			type : "POST",
			dataType : "html",
			success : function(data) {
				//Codigo para cambiar el active del menu				 
				$("#pesta1").removeClass("btn-default2-active");				
				$("#pesta2").addClass("btn-default2-active");
				$("#pesta2").prop("disabled", false);
				$("#pesta2").children("span").removeClass("badge-publicar-antes");
				$("#pesta2").children("span").addClass("badge-publicar1");
				/*
				 * Manipular los AjaxContainers: Ojo no se borra el AjaxContainer 2
				 * para permitir el paso atras.
				 */				
				$("#ajaxContainer2").html(data);
				$("#ajaxContainer").css("display", "none");
				$("#imagentipo").attr("src", laimagen);
				$("#txtPrecio").autoNumeric({aSep: '.', aDec: ','});
				//Inicializacion del editor HTML				
				tinymce.init({
				  	selector:'div#editor',
				  	language:'es_MX',
				  	height: 450,
				  	statusbar: false,
				  	menubar: false,
				  	default_link_target: "_blank",
				  	plugins: "charmap, hr, lists, preview, searchreplace, table, wordcount, anchor, code, fullpage, image, media, visualblocks, imagetools, fullscreen, link, textcolor",
				  	toolbar:[
				  	 'styleselect, formatselect, fontselect, fontsizeselect, undo, charmap, hr, preview, ',
				  	 ' bold, italic,underline,alignleft, aligncenter, alignright, alignjustify, bullist, numlist, outdent, indent,  link, media, image, visualblocks, forecolor, backcolor' 	
				  		]
				   });	
				   			
				if($("#cmbCondicion").val()==3){
					$("#txtCantidad").attr("readonly","true");
				}else{
					$("#txtCantidad").removeAttr("readonly");
				}
				//Validador p_publicar2
				$("#pub-form-reg").formValidation({
					locale: 'es_ES',
					excluded: ':hidden',
					framework : 'bootstrap',
					icon : {
						valid : 'glyphicon glyphicon-ok',
						invalid : 'glyphicon glyphicon-remove',
						validating : 'glyphicon glyphicon-refresh'
					},
					addOns: { i18n: {} },
					err: { container: 'tooltip',  },
					fields:{
						txtTitulo:{validators:{
							notEmpty:{},
							stringLength:{min:10,max:60}}},
						txtCantidad:{validators:{
							notEmpty:{},
							between:{min:1,max:300}}},
						txtPrecio:{validators:{
							notEmpty:{},
							numeric:{thousandsSeparator: '.', decimalSeparator: ','}}}
						}
				}).on('success.form.fv',function(e){
					/*
					 * 4 Paso: Validar el formulario para pasar a publicar 3
					 */
					e.preventDefault();
					var form = $(e.target);
					//validacion externa para saber si se subio una foto
					if($("#fotoprincipal").val() == "false"){
						return false;						
					}else{
						//ajax para pasar a publicar 3
						// Manipulamos el AjaxContainer2 y cambiamos la posicion del menu.						
//						$("#ajaxContainer3").html(data);
						$("#ajaxContainer3").css("display","block");
						$("#ajaxContainer2").css("display", "none");
						$("#pesta2").removeClass("btn-default2-active");	
						$("#pesta3").children("span").removeClass("badge-publicar-antes");
						$("#pesta3").children("span").addClass("badge-publicar1");
						$("#pesta3").addClass("btn-default2-active");
						$("#pesta3").prop("disabled", false);
						/*
						jQuery.noConflict();					
						jQuery('head').append('<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />');
						jQuery('head').append('<script src="http://code.jquery.com/jquery-1.9.1.js"></script>');
						jQuery('head').append('<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>');
						jQuery("#txtFecha").datepicker();
						*/
						$("#pub-form-date").formValidation({
							locale: 'es_ES',
							framework : 'bootstrap',
							icon : {
								valid : 'glyphicon glyphicon-ok',
								invalid : 'glyphicon glyphicon-remove',
								validating : 'glyphicon glyphicon-refresh'
							},
							addOns: { i18n: {} },
							err: { container: 'tooltip' },
							fields:{
								/*txtFecha:{validators:{
								date:{format:'DD/MM/YYYY'}}}*/
							}
						}).on('success.form.fv',function(e){
							/*
							 * 5 paso: enviar el formulario.
							 */
							e.preventDefault();
							loadingAjax(true);
							var fotos = "";
							$('.foto').each(function(index) {
								if($(this).children("img").attr("src") !== undefined){
									fotos = "&foto-"+index+"="+$(this).children("img").attr("src")+fotos;
								}
							});
							form = $("#pub-form-reg").serialize() +"&fecha=" + $("#txtFecha").val()+"&idclas="+$(".form-select-publicar").last().val()+"&monto="+$("#txtPrecio").autoNumeric("get")+
							"&fb="+$("#fb").data("fb")+"&tt="+$("#tt").data("tt")+"&fp="+$("#fp").data("fp")+"&gr="+$("#gr").data("gr")+"&metodo=guardar"+fotos;
							$.ajax({
								url:'paginas/publicar/fcn/f_publicaciones.php',
								data:form,
								type : "POST",
								dataType : "json",
								success : function(data){
									console.log(data);
									if(data.result !== "error"){
										var text;
										if( $("#txtFecha").val() === $("#txtFecha").attr("min")){
											text = "Tu publicacion ya esta disponible en nuestros listados.";
										}else{
											text = "Tu publicacion estara disponible en nuestros listados el "+$("#txtFecha").val();
										}
										loadingAjax(false);								
										swal({
											title: "Exito",
											text: text,
											imageUrl: "galeria/img-site/logos/bill-ok.png",
											showConfirmButton: true
											}, function(){			
												document.location.href = 'detalle.php?id='+data.id;
											});
									}else{
										SweetError("Ocurrio un error al publicar. Intentalo de nuevo");
									}
								},
								error : function(xhr, staus) {
									SweetError(status);
								}
							});
						});							
					}
				}).on('prevalidate.form.fv',function(e){				
					if($("#1").attr("src") === undefined){
						$("#fotoprincipal").val("false");
						$(".foto").first().tooltip("show");
						return false;
					}else{
						$("#fotoprincipal").val("true");
						$(".foto").first().tooltip("destroy");
					}
				}).on('err.field.fv', function(e, data) {
		            if (data.fv.getSubmitButton()) {
		                data.fv.disableSubmitButtons(false);
		            }
		            if($("#txtTitulo").val().length<10){
		        		$("#rs_acpt").css("visibility","hidden");
		        		$(".btn-default").hide();
		        		$("#i"+rs).hide("swing");
		        		}	        	
		        })
		        .on('success.field.fv', function(e, data) {
		            if (data.fv.getSubmitButton()) {
		                data.fv.disableSubmitButtons(false);
		            }
		        }).on('success.field.fv', function(e){
		        	if($("#txtTitulo").val().length>=10 && $("#txtTitulo").val().length<=60){
		        		$("#rs_acpt").css("visibility","visible");
		        	}
		        });
			},
			error : function(xhr, status){
				SweetError(status);
			}


		});
	

	
	});
	

	/*
	 * Navegacion de las pesta&ntilde;as
	 */
	$("#ajaxContainer2").on("click","#volverClasificado",function(){
		$("#pesta1").click();
	});
	$("#pesta1").click(function(){
		$("#ajaxContainer").css("display", "block");
		$("#ajaxContainer2").html("");
		$("#ajaxContainer3").html("");
		$("#pesta2").children("span").addClass("badge-publicar-antes");
		$("#pesta2").children("span").removeClass("badge-publicar1");
		$("#pesta2").removeClass("btn-default2-active");
		$("#pesta2").prop("disabled", true);
		$("#pesta1").addClass("btn-default2-active");
	});
	$("#pesta2").click(function(){
		$("#ajaxContainer2").css("display", "block");
		$("#ajaxContainer3").html("");
		$("#pesta3").children("span").addClass("badge-publicar-antes");
		$("#pesta3").children("span").removeClass("badge-publicar1");
		$("#pesta3").removeClass("btn-default2-active");
		$("#pesta3").prop("disabled", true);
		$("#pesta2").addClass("btn-default2-active");
	});	
	/*
	 * Check Garantia mostrar select
	 */
	$("#ajaxContainer2").on("click", "#chkGarantia", function() {
		if ($("#chkGarantia").attr("value") == 0) {
			$("#chkGarantia").attr("value", 1);
			$("#cmbGarantia").css("display", "block");
			$("#cmbGarantia").focus();
		} else {
			$("#chkGarantia").attr("value", 0);
			$("#cmbGarantia").css("display", "none");
		}
	});
	/*
	 * Foto Publicacion
	 */
	$("#ajaxContainer2").on("click", ".foto", function(e) {
		if($(e.target).is('i')){
			var index = $(this);
			$(this).children("img").removeAttr('src');
			$(this).children("img").removeAttr("id");
            $(this).children("i").addClass('hidden');
            $(this).css("background","");
			$('.foto').each(function(i, obj){
				if($(this).children("img").attr("src") === undefined && $(this).next().children("img").attr("src") !== undefined){
					$(this).children("img").attr("src",$(this).next().children("img").attr("src"));
					$(this).css("background","transparent");
					$(this).children("img").attr("id",i+1);
					$(this).children("i").removeClass('hidden');
					$(this).next().children("img").removeAttr("src");
					$(this).next().children("img").removeAttr("id");
		            $(this).next().children("i").addClass('hidden');
		            $(this).next().css("background","");
				}
			});
        }else{
        	var numero = $(this).children("img").attr("id");
			if(numero !== undefined){
				$("#save-foto").data("nro",numero);
			}
			$('.cropit-image-input').click();
        }		
	});
	/*
	 * Captura el cambio del input
	 */
	$(document).on("change", ".cropit-image-input", function() {
		var file = this.files[0];
		var imageType = "image";
		if (file.type.substring(0,5) == imageType) {
			var reader = new FileReader();
			reader.onload = function(e) {
				// Create a new image.
				var img = new Image();
				// Set the img src property using the data URL.
				img.src = reader.result;
				// Add the image to the page.
				$(".cropit-image-input").val("");
				$('#cropper').modal("show");
				$('#usr-reg-title').html("Edita la foto de tu producto");
			};
			reader.readAsDataURL(file);	
		} else {
			SweetError("Archivo no soportado.");
		}		
	});
	/*
	 * Revalidar el campo txtPrecio para que funcione con el validador.
	 */
	$("#cambiar-foto").click(function(){
		$("#cropper").modal("hide");
		$('.cropit-image-input').click();
	});
	
	$("#ajaxContainer2").on('change','#txtPrecio',function(){
		$('#pub-form-reg').formValidation('revalidateField', 'txtPrecio');
	});
	$("#ajaxContainer2").on('click','#checkbox',function(){
		if($("#checkbox").is(":checked")){
		$(".btn-default").show();
		}else{
		$(".btn-default").css("display","none");
		}
	});
	
	$("#ajaxContainer2").on('click','.btn-default',function(e){
		e.preventDefault();
		var rs= $(this).data("rs");
		if($("#i"+rs).css("display")=="none"){
			$("#"+rs).attr("data-"+rs,"1");
			$("#i"+rs).show("swing");
		}else{
			$("#"+rs).attr("data-"+rs,"0");
			$("#i"+rs).hide("swing");
		}
	});
}); 

$(document).ready(function() {

//validar fechas

var input1 = $('#txtFecha').pickadate({editable: false, container: '#date-picker',
  monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
  weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mier', 'Jue', 'Vie', 'Sab'],
  today: 'Hoy',
  clear: 'Limpiar',
  close: 'Cerrar',
  
  format: 'yyyy-mm-dd',
  formatSubmit: 'y-m-d'});
var picker1 = input1.pickadate('picker');
picker1.set('min', true);
picker1.set('max', 30);
//Fecha desde
$('#txtFecha').off('click focus');

$('#calendario').on('click', function(e) {
  if (picker1.get('open')) { 
    picker1.close();
  } else {
    picker1.open();
  }
  
  e.stopPropagation();    
});


$('#txtFecha').on('click', function(e) {
  if (picker1.get('open')) { 
    picker1.close();
  } else {
    picker1.open();
  }
  
  e.stopPropagation();    
});

});
