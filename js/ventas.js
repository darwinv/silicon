// Plugin de editor HTML

$(document).ready(function(){
		$('head').append('<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />');
		/* BUSQUEDA CALIENTE NO UTILIZADA EN ESTE MOMENTO
		 * 	usuarios_id=$("#busqueda").data("usuario");
		 
		if($(this).val()==""){
			$("#busqueda").html("");
			$("#busqueda").addClass("hidden");
		}else{
			palabra=$(this).val();
			$.ajax({
				url:"paginas/venta/fcn/f_ventas.php",
				data:{metodo:"busquedaCaliente",usuarios_id:usuarios_id,palabra:palabra},
				type:"POST",
				dataType:"html",
				success:function(data){
					console.log(data);
					$("#busqueda").html(data);
					$("#busqueda").removeClass("hidden");
				},
				error:function(xhr,status){
					console.log(status);
				}
			});
		}*/
	/*$('#editor').trumbowyg({
		lang : 'es'
	});*/
	$("#monto").autoNumeric({aSep: '.', aDec: ','});
	$("#ven-form-mod").formValidation({
		locale: 'es_ES',
		excluded: ':hidden',
		framework : 'bootstrap',
		icon : {
			valid : 'glyphicon glyphicon-ok',
			invalid : 'glyphicon glyphicon-remove',
			validating : 'glyphicon glyphicon-refresh'
		},
		addOns: { i18n: {} },
		err: { container: 'tooltip' },
		fields:{
			titulo:{validators:{
				notEmpty:{},
				stringLength:{min:10,max:60}}},
			stock:{validators:{
				notEmpty:{},
				between:{min:1,max:300}}},
			monto:{validators:{
				notEmpty:{},
				numeric:{thousandsSeparator: '.', decimalSeparator: ','}}}
		}
	}).on('success.form.fv',function(e){
		e.preventDefault();
		id=$("#btn-social-act").data("id");
		metodo=$("#btn-social-act").data("metodo");
		monto=$("#monto").val();
		monto=monto.replace(/\./g,"");
		monto=monto.replace(",",".");
		titulo=$("#titulo").val();
		stock=$("#stock").val();
		if(metodo=="actualizar"){
			mensaje="Se actualizo correctamente.";
		}else{
			mensaje="Tu publicacion ya esta disponible en nuestros listados.";
		}
		loadingAjax(true);
		$.ajax({
			url:"paginas/venta/fcn/f_ventas.php",
			data:{metodo:metodo,id:id,monto:monto,titulo:titulo,stock:stock},
			type:"POST",
			dataType:"html",
			success:function(data){
				loadingAjax(false);
           		swal({
					title: "Exito", 
					text: mensaje,
					imageUrl: "galeria/img-site/logos/bill-ok.png",
					timer: 2000, 
					showConfirmButton: true
					}, function(){
						$("#info-publicacion").modal('hide');
						document.location.reload();
					});
			}
		});
	});	
	
	
	/*
	 * Controlas la pesta&oacute;as de mis publicaciones (activas, pausadas, inactivas)
	*/
	
	$(".pesta").click(function(){
		switch($(this).attr("id")){
			case "irActivas":				    
			    $("#irPausadas").removeClass("active");
			    $("#irFinalizadas").removeClass("active");
			    $(this).addClass("active");
			    var tipo=1;
				break;
			case "irPausadas":	
			    $("#irActivas").removeClass("active");			
			    $(this).addClass("active");
			    $("#irFinalizadas").removeClass("active");
			   
			    var tipo=2;				
				break;
			case "irFinalizadas":
			    $("#irPausadas").removeClass("active");
			    $("#irActivas").removeClass("active");
			    $(this).addClass("active");
			    
			    var tipo=3;
				break;
		}	
		var order= "id "+$("#filtro").val(); 
		var pagina=1;
		loadingAjax(true);
		$.ajax({
			url:"paginas/venta/fcn/f_ventas.php",
			data:{metodo:"buscarPublicaciones",tipo:tipo,pagina:pagina,order:order},
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
				$("#publicaciones").html(data);
				loadingAjax(false);
			}
		});
	});
	
	
	$(".pesta-ventas").click(function(){
		if($("#sin-concretar").hasClass("hidden")){
			$("#sin-concretar").removeClass("hidden");
			$("#concretadas").addClass("hidden");
			$("#paginacion").removeClass("hidden");
			$("#paginacion2").addClass("hidden");			
		}else{
			$("#sin-concretar").addClass("hidden");
			$("#concretadas").removeClass("hidden");
			$("#paginacion2").removeClass("hidden");
			$("#paginacion").addClass("hidden");
		}
		$(".pesta-ventas").removeClass("active");
		$(this).addClass("active");
	});
	
	$("#filtro").change(function(){	 
		var tipo;
		if($("#irActivas").hasClass('active')){
			tipo=1; 
		}else if($("#irPausadas").hasClass('active')){
			tipo=2;
		}else if($("#irFinalizadas").hasClass('active')){
			tipo=3;
		}  
		var order= "id "+$("#filtro").val();
		var pagina=1;
		loadingAjax(true);
		$.ajax({
			url:"paginas/venta/fcn/f_ventas.php",
			data:{metodo:"buscarPublicaciones",tipo:tipo,order:order,pagina:pagina},
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
				$("#publicaciones").html(data);
				loadingAjax(false);
			}
		});
	});
	$("#verMas").click(function(e){
		montoFormateado=$("#monto").val();
	//	montoFormateado=montoFormateado.replace(".",",");
		$("#txtTitulo").attr("value",$("#titulo").val());
		$("#txtCantidad").attr("value",$("#stock").val());
		$("#txtPrecio").attr("value",parseInt(montoFormateado));
		$("#editor").html($("#btn-social-act").data("descripcion"));
		$("#info-publicacion").modal('hide');
		var cantidad=$("#stock").val();
		var precio=$("#monto").val();
		var precio=montoFormateado;
		var titulo=$("#titulo").val();
		var descripcion=$("#descripcion_"+id).val();
		$.ajax({
			url:"paginas/venta/fcn/f_edit_publicaciones.php",
			data:{id:id,cantidad:cantidad,precio:precio,titulo:titulo,descripcion:descripcion},
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
				$("#primero").html(data);
				$("#btn-social-act").data("dismiss","modal");
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
				$("#txtPrecio").autoNumeric({aSep: '.', aDec: ','});
				//Validator del formulario
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
					err: { container: 'tooltip' },
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
					e.preventDefault();
	                var fotos = "";
					$('.foto').each(function(index) {
						if($(this).children("img").attr("src") !== undefined){							
							fotos = "&foto-"+index+"="+$(this).children("img").attr("src")+fotos;
						}
					});
					monto=$("#txtPrecio").val();
					monto=monto.replace(/\./g,"");
					monto=monto.replace(",",".");
//					form = $("#pub-form-reg").serialize() + "&id=" + id +"&fecha=" + $("#txtFecha").val()+"&monto="+$("#txtPrecio").autoNumeric("get")+"&metodo=actualizarPub"+fotos;
					form = $("#pub-form-reg").serialize() + "&id=" + id + "&monto=" + monto + "&metodo=actualizarPub"+fotos;
					$.ajax({
						url:"paginas/venta/fcn/f_ventas.php",
						data:form,
						type:"POST",
						dataType:"html",
						success:function(data){
							//location.href="ventas.php";
//							alert("kdkdkdk");
	            		swal({
							title: "Exito", 
							text: "Se actualizo correctamente.",
							imageUrl: "galeria/img-site/logos/bill-ok.png",
							timer: 2000, 
							showConfirmButton: true
							}, function(){
								window.open("detalle.php?id=" + id,"_self");
							});							
						}						
					});
		        }).on('prevalidate.form.fv',function(e){				
					if($("#1").attr("src") === undefined){
						$("#fotoprincipal").val("false");
						$(".foto").first().tooltip("show");
						return false;
					}else{
						$("#fotoprincipal").val("true");
						$(".foto").first().tooltip("destroy");
					}
				});
				//Final del validator
				$("#txtPrecio").keydown(function(){
					$('#pub-form-reg').formValidation('revalidateField', 'txtPrecio');
				});	
				var contador=0;
				$('.foto').each(function(){
					if($(this).children("img").attr("src")!="" && $(this).children("img").attr("src")!=undefined){
						contador++;
						$(this).children("img").attr("id",contador);
						if(contador>1){
							$(this).children("i").removeClass("hidden");
						}
					}
				});	
			}
		});
	});
	//Inicia el cropit
	$("#primero").on("click", ".foto", function(e) {
		if($(e.target).is('i')){   //Significa que va a eliminar una foto
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
					$(this).next().children("img").removeAttr("src");
					$(this).next().children("img").removeAttr("id");
		            $(this).next().children("i").addClass('hidden');
		            $(this).next().css("background","");
		            $(this).addClass("subir-img");
				}
			});
      }else{  //Significa que va a buscar una foto
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
	$("#primero").on('change','#txtPrecio',function(){
		$('#pub-form-reg').formValidation('revalidateField', 'txtPrecio');
	});
	$("#monto").keydown(function(){		
		$('#ven-form-mod').formValidation('revalidateField', 'monto');
	});	
	//Finaliza el cropit
	$("#primero").on("click", "#chkGarantia", function() {
		if ($("#chkGarantia").attr("value") == 0 || $("#chkGarantia").attr("value")==undefined) {
			$("#chkGarantia").attr("value", 1);
			$("#cmbGarantia").css("display", "block");
			$("#cmbGarantia").focus();
		} else {
			$("#chkGarantia").attr("value", 0);
			$("#cmbGarantia").css("display", "none");
		}
	});
	$("#publicaciones").on("click",".imagen",function(){
		window.open("detalle.php?id=" + $(this).data("id"),"_self");
	});		
	$(document).on("click",".botonPagina",function(){
		var orden=$("#filter").val();
		var pagina=$(this).data("pagina");
		var palabra=$("#txtBusqueda").val();
		var metodo=$("#paginas").data("metodo");
		var id=$("#paginas").data("id");
		var tipo=$("#paginas").data("tipo");
		var order= "id "+$("#filtro").val();
		$(".pagination li").removeClass("active");
		$(this).parent().addClass("active");
		loadingAjax(true);
		$.ajax({
			url:"paginas/venta/fcn/f_ventas.php",
			data:{metodo:metodo,orden:orden,palabra:palabra,pagina:pagina,id:id,tipo:tipo,order:order},
			type:"POST",
			dataType:"html",
			success:function(data){
				$("#publicaciones").html(data);
				loadingAjax(false);
			},
			error:function(xhr,status){
				loadingAjax(false);
			}
		});
	});
	
	$(document).on("click",".botonPaginaventas",function(){
		var pagina=$(this).data("pagina");
		var elemento=$(this);
		if($("#sin-concretar").hasClass("hidden")){
			var eldiv=$("#concretadas");
			var origen=3;
			var metodo="paginar2";
		}else{
			var eldiv=$("#sin-concretar");
			var origen=1;
			metodo="paginar1";
		}
		var orden=$("#filtro").val();		
		loadingAjax(true);
		$.ajax({
			url:"paginas/venta/fcn/f_ventas.php",
			data:{metodo:metodo,pagina:pagina,origen:origen,orden:orden},
			type:"POST",
			dataType:"html",
			success:function(data){
				if(origen==1){
					$('#paginacion').find('li').removeClass("active");
				}else{
					$('#paginacion2').find('li').removeClass("active");
				}
				elemento.parent().addClass("active");
				eldiv.html(data);
				loadingAjax(false);
			}
		});
	});
	$("body").on('click', '.ver-detalle-user', function(e) {
	 	
	 	var usuarios_id= $(this).data("usuarios_id");
		usuarios_id = parseInt(usuarios_id);
		  
		if(usuarios_id>0){
			$.ajax({
				url: "fcn/f_usuarios.php", // la URL para la petici&oacute;n
	            data: {method:"get", id:usuarios_id}, // la informaci&oacute;n a enviar
	            type: 'POST', // especifica si ser&aacute; una petici&oacute;n POST o GET
	            dataType: 'json', // el tipo de informaci&oacute;n que se espera de respuesta
	            success: function (data) {
	            	// c&oacute;digo a ejecutar si la petici&oacute;n es satisfactoria; 
	            	if (data.result === 'OK') {  
	            		console.log(data.campos);
	            				$('.modal-datail-user .fotoperfil').attr("src", data.campos.ruta); 
	            				if(data.campos.n_nombre!=null){  
				            		$('.modal-datail-user .nombre').html(data.campos.n_nombre+' '+data.campos.n_apellido);
				            	}
				            	else {
				            		$('.modal-datail-user .nombre').html(data.campos.j_razon_social);
				            	}
				            	
				            	if(data.campos.n_identificacion!=null){
				            	$('.modal-datail-user .rif').html(data.campos.n_identificacion); 	
				            	}
				            	else{
				            	$('.modal-datail-user .rif').html(data.campos.j_rif); 	
				            	}
				            	
				            	$('.modal-datail-user .direccion').html(data.campos.u_direccion);
				            	$('.modal-datail-user .telefono').html(data.campos.u_telefono);
				            	$('.modal-datail-user .correo').html(data.campos.a_email);
		            }
	          	},// c&oacute;digo a ejecutar si la petici&oacute;n falla;
	            error: function (xhr, status) {
	            	SweetError(status);
	            }
	        });
	    }
	 	
	});	
	
	$(document).on("click",".vinculopagos",function(){
		var id=$(this).attr("id").substr(4);
		if($(this).data("target")==="#pagos-ven2"){
			var pagina="paginas/venta/fcn/f_pagos2.php";
			var elDiv=$("#ajaxcontainer2");
		}else{
			var pagina="paginas/venta/fcn/f_pagos.php";
			var elDiv=$("#ajaxcontainer");
		}
		$.ajax({
			url : pagina,
			data : {id:id},
			type : "POST",
			dataType : "html",
			success : function(data){
				elDiv.html(data);
				actual=id;
			}
		});
	});
	
	$("#ventas").css("display","block");	
				switch($('body').data("tipo")){
					case 1:
						$("#uno1").addClass("active");
						break;
					case 2:
						$("#uno2").addClass("active");
						break;
					case "":
						$("#uno1").addClass("active");
						break;		
				}
	$("#ajaxcontainer").on("click",".boton-status",function(e){
		//fa fa-clock-o naranja-apdp
		//fa fa-thumbs-o-up verde-apdp
		//fa fa-remove rojo-apdp
		e.preventDefault();
		if($(this).data("indice")==1){
			return false;
		}
		var id=$(this).data("id");
		var anterior=$("#primero" + id).text();
		if(pagos!="")
		pagos+=",";		
		pagos+=id + " ";
		pagos+=$(this).data("texto");	
		$("#primero" + id).text($(this).data("texto"));
		$("#iconoa" + id).removeClass();
		$("#iconob" + id).removeClass();
		$("#iconoc" + id).removeClass();		
		if($(this).data("texto")=="Pendiente"){
			$("#iconoa" + id).addClass("fa fa-clock-o naranja-apdp");
			$("#iconob" + id).addClass("fa fa-thumbs-o-up verde-apdp");
			$("#iconoc" + id).addClass("fa fa-remove rojo-apdp");
			$("#segundo" + id).text("Verificar");
			$("#tercero" + id).text("Rechazar");			
			$(this).data("texto","Verificado");
			$(this).next().data("texto","Rechazado");
		}else if($(this).data("texto")=="Verificado"){
			$("#iconoa" + id).addClass("fa fa-thumbs-o-up verde-apdp");
			$("#iconob" + id).addClass("fa fa-clock-o naranja-apdp");
			$("#iconoc" + id).addClass("fa fa-remove rojo-apdp");						
			$("#segundo" + id).text("Pendiente");
			$("#tercero" + id).text("Rechazar");
			if($(this).data("indice")==2){			
				$(this).data("texto","Pendiente");
				$(this).next().data("texto","Rechazado");
			}else{
				$("#iconoa" + id).addClass("fa fa-clock-o naranja-apdp");				
				$(this).prev().data("texto","Pendiente");
				$(this).data("texto","Rechazado");				
			}
		}else if($(this).data("texto")=="Rechazado"){
			$("#iconoa" + id).addClass("fa fa-remove rojo-apdp");
			$("#iconob" + id).addClass("fa fa-clock-o naranja-apdp");
			$("#iconoc" + id).addClass("fa fa-thumbs-o-up verde-apdp");
			$("#segundo" + id).text("Pendiente");
			$("#tercero" + id).text("Verificado");		
			$(this).data("texto","Verificado");
			$(this).prev().data("texto","Pendiente");
		}
	});
	
	$("#btn-guardar").click(function(){
		if(pagos!=""){
			loadingAjax(true);
			$.ajax({
				url:"paginas/venta/fcn/f_ventas.php",
				data:{metodo:"actualizarPagos",pagos:pagos,id:actual},
				type:"POST",
				dataType:"html",
				success:function(data){
					loadingAjax(false);
					pagos="";
					console.log(data);					
					$("#pago" + actual + ">span").html(data);
					$("#pago" + actual + ">i").first().removeClass();
					switch(data){
						case "Pago verificado":
							$("#pago" + actual + ">i").first().addClass("fa fa-credit-card verde-apdp");
							break;
						case "Pago incompleto":			
							$("#pago" + actual + ">i").first().addClass("fa fa-credit-card naranja-apdp");
							break;
						case "Pago rechazado":		
							$("#pago" + actual + ">i").first().addClass("fa fa-credit-card rojo-apdp");						
							break;
						case "Pago pendiente":
							$("#pago" + actual + ">i").first().addClass("fa fa-credit-card amarillo-apdp");						
							break;							
					}
				}
			});
		}
	});
	
	$(document).on("click",".vinculoenvios",function(e){
		e.preventDefault();
		var id=$(this).attr("id").substr(5);
		var maximo=$(this).data("maximo");
		//var status=$(this).data("status");
		var status=$("#pago" + id + ">span").first().text();
		if(status!="Pago verificado"){			
			return false;
		}
		$("#envios-ven").modal('show');
		$.ajax({
			url : "paginas/venta/fcn/f_envios.php",
			data : {id:id},
			type : "POST",
			dataType : "html",
			success : function(data){
				$("#ajaxcontainer3").html(data);
				$("#p_cantidad").attr("max",maximo);
				actual=id;
				if(maximo<=0){
					$("#btn-agregar-guia").addClass("hidden");					
				}else{
					$("#btn-agregar-guia").removeClass("hidden");
				}
				$("#frm-reg-envios").formValidation({
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
						p_cantidad:{validators:{
							notEmpty:{}}},
						p_agencia:{validators:{
							notEmpty:{}}},
						p_numero:{validators:{
							notEmpty:{}}},							
						p_direccion:{validators:{
							notEmpty:{}}}
						}
				}).on('success.form.fv',function(e){
					e.preventDefault();
					var form = $(e.target);
					form=$("#frm-reg-envios").serialize() + "&metodo=guardarEnvio&id=" + actual;
					$.ajax({
						url : "paginas/venta/fcn/f_ventas.php",
						data : form,
						type : "POST",
						dataType : "html",
						success : function(data){
							console.log(data);
							$("#ajaxcontainer3").load("paginas/venta/fcn/f_envios.php",{id:actual});
							var faltante=$("#p_cantidad").attr("max") - $("#p_cantidad").val();
							$("#envio" + actual).data("maximo",faltante);
							if(faltante==0){
								$("#p_cantidad").attr("max",faltante);
								$("#p_cantidad").val("");
								$("#p_direccion").val("");
								$("#p_numero").val("");
								$("#p_fecha").val("");
								$("#p_monto").val("");
								$("#p_agencia").val("");				
								swal({
									title: "Envio realizado",
									text: "Se completo el envio",
									imageUrl: "galeria/img/logos/bill-ok.png",
									showConfirmButton: true
								});
								$("#envios-ven").modal("hide");						
								$("#envio" + actual + ">span").first().text("Enviado");
								$("#envio" + actual + ">i").first().removeClass("rojo-apdp naranja-apdp");
								$("#envio" + actual + ">i").first().addClass("verde-apdp");
								$("#concretadas").append($("#venta" + actual));
								return false;
							}
							$("#p_cantidad").attr("max",faltante);
							$("#p_cantidad").val("");
							$("#p_direccion").val("");
							$("#p_numero").val("");
							$("#p_fecha").val("");
							$("#p_monto").val("");
							$("#p_agencia").val("");
							$("#btn-agregar-guia").removeClass("hidden");
							$("#btn-guardar2").removeClass("hidden");
							$("#btn-guardar-guia").addClass("hidden");
							$("#envio" + actual + ">span").first().text("En camino");
							$("#envio" + actual + ">i").first().removeClass("naranja-apdp rojo-apdp");
							$("#envio" + actual + ">i").first().addClass("naranja-apdp");							
						}
					});
					$("#frm-envios").slideUp();
		       });
			}
		});
	});
	
	$(document).on("click",".vinculodescuento",function(){
		actual=$(this).attr("id").substr(4);
		total=$(this).data("monto");
		$("#frm-reg-desc").formValidation({
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
				p_descuento:{validators:{
					notEmpty:{},
					between:{min:1,max:total}}}
			}
			}).on('success.form.fv',function(e){
					monto=$("#p_descuento").val();
					e.preventDefault();
					$.ajax({
						url:"paginas/venta/fcn/f_ventas.php",
						data:{metodo:"guardarDescuento",id:actual,monto:monto},
						type:"POST",
						dataType:"html",
						success:function(data){
							$("#pago" + actual + ">span").text(data);
							$("#pago" + actual + ">i").removeClass();
							switch(data){
								case "Pago pendiente":
									$("#pago" + actual + ">i").addClass("fa fa-credit-card amarillo-apdp");								
									break;
								case "Pago rechazado":
									$("#pago" + actual + ">i").addClass("fa fa-credit-card rojo-apdp");
									break;
								case "Pago verificado":
									$("#pago" + actual + ">i").addClass("fa fa-credit-card verde-apdp");
									break;
								case "Pago incompleto":
									$("#pago" + actual + ">i").addClass("fa fa-credit-card naranja-apdp");
									break;
							}						
						}
					});
					$("#descuento").modal('hide');
			});		
	});
	
	$(document).on("click",".vinculocomentario",function(){
		$("#p_comentario").val($(this).data("nota"));
		actual=$(this).attr("id").substr(5);
		$("#frm-reg-comentario").formValidation({
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
				p_comentario:{validators:{
					notEmpty:{}}}
			}
			}).on('success.form.fv',function(e){
				e.preventDefault();
				var nota=$("#p_comentario").val();
				$.ajax({
					url:"paginas/venta/fcn/f_ventas.php",
					data:{metodo:"guardarComentario",id:actual,nota:nota},
					type:"POST",
					dataType:"html",
					success:function(data){
						console.log(data);
						$("#comen" + actual).data("nota",nota);
						$("#comentario").modal('hide');
					}
				});
		});
	});
	
	$("#btn-agregar-guia").click(function(e){
		e.preventDefault();
		$(this).addClass("hidden");
		$("#btn-guardar2").addClass("hidden");
		$("#btn-guardar-guia").removeClass("hidden");
		$("#frm-envios").slideDown();
	});
	
	function validacion(){
		swal({
			title: "Falta datos importantes",
			text: "Algunos de los valores necesarios estan vacios",
			imageUrl: "galeria/img/logos/bill-ok.png",
			showConfirmButton: true
			}, function(){		
				//document.location.href = 'detalle.php?id='+data.id;
			});
	}
	
	
	$(document).on("change","#filtro",function(){
		if($("#sin-concretar").hasClass("hidden")){
			var eldiv=$("#concretadas");
			var origen=2;
		}else{
			var eldiv=$("#sin-concretar");
			var origen=1;
		}
		var orden=$(this).val();
		loadingAjax(true);
		$.ajax({
			url:"paginas/venta/fcn/f_ventas.php",
			data:{metodo:"ordenar",orden:orden,origen:origen},
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);				
				eldiv.html(data);				
				if(origen==1){
					$('#paginacion').find('li').removeClass("active");
					$("#paginacion").find('li').first().next().addClass("active");				
				}else{
					$('#paginacion2').find('li').removeClass("active");
					$("#paginacion2").find('li').first().next().addClass("active");				
				}
				loadingAjax(false);
			}
		});
	});
	
	$("#principal").on("keyup","#txtBuscar",function(){
		if($(this).val()!=""){
			var c=0;
			var valor=$(this).val().toUpperCase();			
			$(".general").each(function(i){
				var titulo=$(this).data("titulo").toUpperCase();				
				if(titulo.indexOf(valor)==-1) {
					$(this).css("display","none");
				}else{
					c++;
					$(this).css("display","block");
				}
			});
			if(c==0){
				$("#noresultados").removeClass("hidden");
				$("#publicaciones").addClass("hidden");
			}else{
				$("#noresultados").addClass("hidden");
				$("#publicaciones").removeClass("hidden");				
			}
		}else{		
			if($(".general").length>0){
				$("#noresultados").addClass("hidden");
				$("#publicaciones").removeClass("hidden");
				$(".general").css("display","block");				
			}else{
				$("#noresultados").removeClass("hidden");
				$("#publicaciones").addClass("hidden");				
			}
		}		
	});
	
	var input1 = $('#p_fecha').pickadate({editable: false, container: '#date-picker',
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
$('#p_fecha').off('click focus');

$('#calendario').on('click', function(e) {
  if (picker1.get('open')) { 
    picker1.close();
  } else {
    picker1.open();
  }
  
  e.stopPropagation();    
});


$('#p_fecha').on('click', function(e) {
  if (picker1.get('open')) { 
    picker1.close();
  } else {
    picker1.open();
  }
  
  e.stopPropagation();    
});
});