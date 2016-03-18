<script>
$(document ).ready(function() {
/* Considerar borrar este c�digo y llamar a configuracion-js*>*/
	$('#usr-act-form-nat').formValidation({
		locale: 'es_ES',
		framework : 'bootstrap',
		icon : {
			valid : 'glyphicon glyphicon-ok',
			invalid : 'glyphicon glyphicon-remove',
			validating : 'glyphicon glyphicon-refresh'
		},
		addOns: { i18n: {} },
		err: { container: 'tooltip' },
		fields : {
			p_identificacion: {validators : {
				notEmpty:{},
				digits:{},
				stringLength : { max : 10 },
				blank: {}}},
			p_nombre : {validators : {
				notEmpty : {},
				stringLength : {max : 512},
				regexp: {regexp: /^[\u00F1a-z\s]+$/i}}},
			p_apellido : {validators : {
				notEmpty : {},
				stringLength : {max : 512},
				regexp: {regexp: /^[\u00F1a-z\s]+$/i}}},
			p_telefono : {validators : {
				notEmpty : {},
				phone : {country:'VE'}}},
			p_estado : {validators : {
				notEmpty : {}}},
			p_direccion : {validators : {
				notEmpty : {},
				stringLength : {min: 10,max : 1024}}}
		}
	}).on('success.form.fv', function(e) {
		e.preventDefault();
		var form = $(e.target);
		var fv = form.data('formValidation');
		var method = "&id=" + $("#p_id").val() + "&method=act-nat";
		$.ajax({
			url: form.attr('action'), // la URL para la petición
            data: form.serialize() + method, // la información a enviar
            type: 'POST', // especifica si será una petición POST o GET
            dataType: 'json', // el tipo de información que se espera de respuesta
            success: function (data) {
//	            	alert(data);
            	// código a ejecutar si la petición es satisfactoria;
            	// console.log(data);
	            if (data.result === 'error') {
	            	for (var field in data.fields) {
	        			fv
	                    // Show the custom message
	                    .updateMessage(field, 'blank', data.fields[field])
	                    // Set the field as invalid
	                    .updateStatus(field, 'INVALID', 'blank');
	            	}
	            } else {
	            	swal({
						title: "Exito", 
						text: "Se actualizo correctamente.",
						imageUrl: "galeria/img-site/logos/bill-ok.png",
						timer: 2000, 
						showConfirmButton: true
						}, function(){
//							loadingAjax(true);
							$.ajax({
								url:"fcn/f_usuarios.php",
								data:{method:"loadSession",id:elId},
								type:"POST",
								dataType:"html",
								success:function(data){
									console.log(data);
//									loadingAjax(false);
									location.reload();
								}
							});
						});
                }
          	},// código a ejecutar si la petición falla;
            error: function (xhr, status) {
            	SweetError(status);
            }
        });
    });
	/*---======= Validacion de Datos Personales JUR ========---*/
	$('#usr-act-form-jur').formValidation({
		locale: 'es_ES',
		framework : 'bootstrap',
		icon : {
			valid : 'glyphicon glyphicon-ok',
			invalid : 'glyphicon glyphicon-remove',
			validating : 'glyphicon glyphicon-refresh'
		},
		addOns: { i18n: {} },
		err: { container: 'tooltip' },
		fields : {
			e_rif: {validators : {
				notEmpty:{},
				digits:{},
				stringLength : { max :  10},
				blank: {}}},
			e_razonsocial : {validators : {
				notEmpty : {},
				stringLength : {min : 5, max : 512}}},
			e_categoria : {validators : {
				notEmpty : {}}},
			e_telefono : {validators : {
				notEmpty : {},
				phone : {country:'VE'}}},
			e_estado : {validators : {
				notEmpty : {}}},
			e_direccion : {validators : {
				notEmpty : {},
				stringLength : {min: 10,max : 1024}}}
		}
	}).on('success.form.fv', function(e) {
		e.preventDefault();
		var form = $(e.target);
		var fv = form.data('formValidation');
		var method = "&id=" + $("#p_id").val() + "&method=act-jur";
		$.ajax({
			url: form.attr('action'), // la URL para la petición
            data: form.serialize() + method, // la información a enviar
            type: 'POST', // especifica si será una petición POST o GET
            dataType: 'json', // el tipo de información que se espera de respuesta
            success: function (data) {
            	// código a ejecutar si la petición es satisfactoria;
            	// console.log(data);
	            if (data.result === 'error') {
	            	for (var field in data.fields) {
	        			fv
	                    // Show the custom message
	                    .updateMessage(field, 'blank', data.fields[field])
	                    // Set the field as invalid
	                    .updateStatus(field, 'INVALID', 'blank');
	            	}
	            } else {
	            	swal({
						title: "Exito",
						text: "Se actualizo correctamente.",
						imageUrl: "galeria/img-site/logos/bill-ok.png",
						timer: 2000,
						showConfirmButton: true
						}, function(){
							$.ajax({
								url:"fcn/f_usuarios.php",
								data:{method:"loadSession",id:elId},
								type:"POST",
								dataType:"html",
								success:function(data){
									console.log(data);
//									loadingAjax(false);
									location.reload();
								}
							});
						});
                }
          	},// código a ejecutar si la petición falla;
            error: function (xhr, status) {
            	SweetError(status);
            }
        });
    });
/*Hasta aqui*/
	
	/* ============================----- Modal Registrar -----=========================*/
	var pagina=1;
	$('#usr-reg-form').formValidation({
		locale: 'es_ES',
		framework : 'bootstrap',
		icon : {
			valid : 'glyphicon glyphicon-ok',
			invalid : 'glyphicon glyphicon-remove',
			validating : 'glyphicon glyphicon-refresh'
		},
		addOns: { i18n: {} },
		err: { container: 'tooltip' },
		fields : {
			p_identificacion: {validators : {
				notEmpty:{},
				digits:{},	
				stringLength : { max : 10 },
				blank: {}}},
			p_nombre : {validators : {
				notEmpty : {},
				stringLength : {max : 512},
				regexp: {regexp: /^[\u00F1a-z\s]+$/i}}},
			p_apellido : {validators : {
				notEmpty : {},
				stringLength : {max : 512},
				regexp: {regexp: /^[\u00F1a-z\s]+$/i}}},
			p_telefono : {validators : {
				notEmpty : {},
				phone : {country:'VE'}}},
			p_estado : {validators : {
				notEmpty : {}}},
			p_direccion : {validators : {
				notEmpty : {},
				stringLength : {min: 10,max : 1024}}},
			e_rif: {validators : {
				notEmpty:{},	
				digits:{},
				stringLength : { max :  10},
				blank: {}}},
			e_razonsocial : {validators : {
				notEmpty : {},
				stringLength : {min : 5, max : 512}}},
			e_categoria : {validators : {
				notEmpty : {}}},
			e_telefono : {validators : {
				notEmpty : {},
				phone : {country:'VE'}}},
			e_estado : {validators : {
				notEmpty : {}}},
			e_direccion : {validators : {
				notEmpty : {},
				stringLength : {min: 10,max : 1024}}},			
			seudonimo : {validators : {
				notEmpty : {},
				stringLength : {max : 64},
				regexp: {regexp: /^[a-zA-Z0-9_.-]*$/i},
				blank: {}}},
			email : {validators : {
				notEmpty : {},
				emailAddress : {},
				blank: {}}},
			email_val : {validators : {
				identical: {field: 'email'}}},
			password : {validators : {
				notEmpty : {},
				stringLength : {min:6,max : 64}}},
			password_val : {validators : {
				identical: {field: 'password'}}}
		}
	}).on('success.form.fv', function(e) {
		e.preventDefault();				
		var form = $(e.target);
		var fv = form.data('formValidation');
		var foto = "&foto="+$("#foto-usuario").attr("src");
		var method = "&method="+$(this).data("method");
		
		$.ajax({
			url: form.attr('action'), // la URL para la petición
            data: form.serialize() + foto + method, // la información a enviar
            type: 'POST', // especifica si será una petición POST o GET
            dataType: 'json', // el tipo de información que se espera de respuesta		           
            success: function (data) {
            	// código a ejecutar si la petición es satisfactoria;	
            	// console.log(data);
	            if (data.result === 'error') {
	            	$("#usr-reg-skip").hide();
            		$("#usr-reg-foto").hide();
            		$("section").hide();
            		keys = Object.keys(data.fields);
            		if(jQuery.inArray("e_rif",keys) !== -1 || jQuery.inArray("p_identificacion",keys) !== -1){
            			$("#usr-reg-submit").data("step",1);	
            			$("section[data-type='"+$("#type").val()+"']").show();
            		}else if(jQuery.inArray("seudonimo",keys) !== -1 || jQuery.inArray("email",keys)!== -1){
            			$("#usr-reg-submit").data("step",2);	
            			$("section[data-step='2']").show();
            		}
	            	for (var field in data.fields) { 
	        			fv
	                    // Show the custom message
	                    .updateMessage(field, 'blank', data.fields[field])
	                    // Set the field as invalid
	                    .updateStatus(field, 'INVALID', 'blank');
	            	}
	            }else if($( "#ingresoUsuario" ).val()=="0"){ //si registramos usuarios por backend
	            			
	            				swal({
							title: "Registro de Usuario", 
							text: "&iexcl;Usuario Creado Exitosamente!",
							imageUrl: "galeria/img-site/logos/bill-ok.png",
							timer: 2000, 
							showConfirmButton: true
							}, function(){
								location.reload();
							});	
	            			
	            		}else{   //si es un registro de usuario publico
		            			swal({
							title: "Bienvenido", 
							text: "&iexcl;A <?php echo COMPANY_NAME_MAY;?>!",
							imageUrl: "galeria/img-site/logos/bill-ok.png",
							timer: 2000, 
							showConfirmButton: true
							}, function(){			
								location.reload();
							});	
	            			
	            		}
		        						
                            
          	},// código a ejecutar si la petición falla;
            error: function (xhr, status) {
            	SweetError(status);
            }
        });          
    });	
	/* ============================----- Formulario de registro -----=========================*/
	/*Codigo que pide al usuario seleccionar si sera personal natural o juridica*/
	$('.alert-reg').click(function() {
		$("section").hide();
		$("#usr-reg-skip").hide();
		$("#usr-reg-foto").hide();
		$("#usr-reg-submit").data("step",1); 	
	});
	
	
	$("#usr-reg-submit").click(function(){
		
		var step, section;
		step = $("#usr-reg-submit").data("step"); 
		switch(step){
		case 1:
			if(validarForm(step)){
				step++;
				$("#usr-reg-submit").data("step",step);		
				$("section[data-type='"+$("#usr-reg-submit").data("type")+"']").fadeOut( "slow", function() {
					$("#usr-reg-title").html($("section[data-step='"+step+"']").data("title"));
					$("section[data-step='"+step+"']").fadeIn("slow");
				});
			}
			break;
		case 2:
			$("#usr-reg-form").data('formValidation').validate();
			break;
		}
	});

	function validarForm(step){
		var type;
		 var fv = $('#usr-reg-form').data('formValidation'), // FormValidation instance
        // The current step container
		type = $("#usr-reg-submit").data("type");
		if(step === 1){
			$container = $('#usr-reg-form').find('section[data-type="' + type +'"]');
		}else{
			$container = $('#usr-reg-form').find('section[data-step="' + step +'"]');
		}
        // Validate the container
        fv.validateContainer($container);	
        var isValidStep = fv.isValidContainer($container);
        if (isValidStep === false || isValidStep === null) {
            // Do not jump to the next step
            return false;
        }        
        return true;
	} 
	
	/* ============================----- Modal Login -----=========================*/	
	
	$('#usr-log-form').formValidation({
		locale: 'es_ES',
		excluded: ':disabled',
		framework : 'bootstrap',
		icon : {
			valid : 'glyphicon glyphicon-ok',
			invalid : 'glyphicon glyphicon-remove',
			validating : 'glyphicon glyphicon-refresh'
		},
		addOns: { i18n: {} },
		err: { container: 'tooltip' },
		fields : {			
			log_usuario : {validators : {
				notEmpty : {},
				blank: {}}},
			log_password : {validators : {
				notEmpty : {},
				blank: {}}}
		}
	}).on('success.field.fv', function(e, data) {
        if (data.fv.getInvalidFields().length > 0) {    // There is invalid field
            data.fv.disableSubmitButtons(true);
        }
    }).on('err.form.fv', function(e,data) {
    	$(".dropdown-toggle").dropdown('toggle');
    }).on('success.form.fv', function(e) {
		e.preventDefault();
		var url=$(this).data("url");
		var sendurl="&url="+url;
		var form = $(e.target);
		var fv = form.data('formValidation');
		var method = "&method=log";
		$.ajax({
			url: form.attr('action'), // la URL para la petición
           data: form.serialize() + method + sendurl, // la información a enviar
            type: 'POST', // especifica si será una petición POST o GET
            dataType: 'json', // el tipo de información que se espera de respuesta            
            success: function (data) {            	
            	// código a ejecutar si la petición es satisfactoria;
            	// código a ejecutar si la petición es satisfactoria;
            	// console.log(data);
	            if (data.result === 'error'){
	            	for (var field in data.fields) {
	        			fv
	                    // Show the custom message
	                    .updateMessage(field, 'blank', data.fields[field])
	                    // Set the field as invalid
	                    .updateStatus(field, 'INVALID', 'blank');
	        			setTimeout(function(){
	        				$("#"+field).focus();	       			
	        			}, 10);
	            	}
	            	$(".dropdown-toggle").dropdown('toggle');
	            	
	            } else if(data.result==="Actualice") {
					elId=data.id;
	            	$("#actualizar").modal('show');
	            } else{
	            	swal({
						title: "Bienvenido", 
						text: "&iexcl;A <?php echo COMPANY_NAME_MAY;?>!",
						imageUrl: "galeria/img-site/logos/bill-ok.png",
						timer: 2000, 
						showConfirmButton: true
						}, function(){
							if(url=="admin"){
										window.location.href = "resumen.php";
										}else{
											location.reload();
										}
						});
                } 
          	},// código a ejecutar si la petición falla;
            error: function (xhr, status) {
            	SweetError(status);
            }
        });
	});		
	
	$(".li-icon-top").focus(function() {
		$(this).parent().next().children('div').removeClass('vertical-line');
		$(this).parent().prev().children('div').removeClass('vertical-line');
	});
	$(".li-icon-top ").blur(function() {
		$(this).parent().next().children('div').addClass('vertical-line');
		$(this).parent().prev().children('div').addClass('vertical-line');
	});	
	$(".li-icon-top").hover(function(){
		$(this).parent().next().children('div').removeClass('vertical-line');
		$(this).parent().prev().children('div').removeClass('vertical-line');
		}, function(){
			if(!$(this).is(":focus")){
				$(this).parent().next().children('div').addClass('vertical-line');
				$(this).parent().prev().children('div').addClass('vertical-line');
			}			
	});


	
	$(".buscador").keydown(function(e){
		if(e.which==13){
			if($('#txtBuscar').val()!=""){
		        buscar=$('#txtBuscar').val();
				window.open("listado.php?palabra=" + buscar,"_self");				
			}else
			window.open("listado.php", "_self");
		}
	});
	$(".buscadorBoton").click(function(e){
		if($('#txtBuscar').val()!=""){
		        buscar=$('#txtBuscar').val();
				window.open("listado.php?palabra=" + buscar,"_self");
			}else
			window.open("listado.php", "_self");
	});
	$("#usr-log-submit").prop("disabled",true);	
	$("#opcion1").click(function(){
		if($("#opcion1").hasClass('active-cat')){
			return false;
		}else{
			loadingAjax(true);
		    setTimeout(pararCarga,800);
			$("#productos").css("display","block");
			$("#vehiculos").css("display","none");
			$("#servicios").css("display","none");
			$("#inmuebles").css("display","none");
			$("#tiendas").css("display","none");			
			$("#opcion1").addClass("active-cat");
			$("#opcion2").removeClass("active-cat");
			$("#opcion3").removeClass("active-cat");
			$("#opcion4").removeClass("active-cat");
			$("#opcion5").removeClass("active-cat");
			$("#tituloCategoria").css("display","block");
		}		
	});
	$("#opcion2").click(function(){
		if($("#opcion2").hasClass('active-cat')){
			return false;
		}else{		
			loadingAjax(true);
		    setTimeout(pararCarga,800);		
			$("#productos").css("display","none");
			$("#vehiculos").css("display","block");
			$("#servicios").css("display","none");
			$("#inmuebles").css("display","none");
			$("#tiendas").css("display","none");			
			$("#opcion1").removeClass("active-cat");
			$("#opcion2").addClass("active-cat");
			$("#opcion3").removeClass("active-cat");
			$("#opcion4").removeClass("active-cat");
			$("#opcion5").removeClass("active-cat");
			$("#tituloCategoria").css("display","block");
		}		
	});
	$("#opcion3").click(function(){
		if($("#opcion3").hasClass('active-cat')){
			return false;
		}else{		
			loadingAjax(true);
		    setTimeout(pararCarga,800);		
			$("#productos").css("display","none");
			$("#vehiculos").css("display","none");
			$("#inmuebles").css("display","block");		
			$("#servicios").css("display","none");
			$("#tiendas").css("display","none");
			$("#opcion1").removeClass("active-cat");
			$("#opcion2").removeClass("active-cat");
			$("#opcion3").addClass("active-cat");
			$("#opcion4").removeClass("active-cat");
			$("#opcion5").removeClass("active-cat");
			$("#tituloCategoria").css("display","block");			
		}		
	});
	$("#opcion4").click(function(){
		if($("#opcion4").hasClass('active-cat')){
			return false;
		}else{		
			loadingAjax(true);
		    setTimeout(pararCarga,800);		
			$("#productos").css("display","none");
			$("#vehiculos").css("display","none");
			$("#inmuebles").css("display","none");		
			$("#servicios").css("display","block");
			$("#tiendas").css("display","none");
			$("#opcion1").removeClass("active-cat");
			$("#opcion2").removeClass("active-cat");
			$("#opcion3").removeClass("active-cat");
			$("#opcion5").removeClass("active-cat");
			$("#opcion4").addClass("active-cat");
			$("#tituloCategoria").css("display","block");			
		}		
	});
	$("#opcion5").click(function(){
		if($("#opcion5").hasClass('active-cat')){
			return false;
		}else{		
			loadingAjax(true);
		    setTimeout(pararCarga,800);		
			$("#productos").css("display","none");
			$("#vehiculos").css("display","none");
			$("#inmuebles").css("display","none");		
			$("#servicios").css("display","none");
			$("#tiendas").css("display","block");
			$("#opcion1").removeClass("active-cat");
			$("#opcion2").removeClass("active-cat");
			$("#opcion3").removeClass("active-cat");
			$("#opcion4").removeClass("active-cat");
			$("#opcion5").addClass("active-cat");
			$("#tituloCategoria").css("display","none");			
		}		
	});	
	$(".publicaciones1,.publicaciones2").click(function(e){
		window.open("detalle.php?id=" + $(this).attr("id"),"_self");
	});
	$(".vendedores").click(function(e){
		window.open("perfil.php?id=" + $(this).attr("id"),"_self");
	});	
	function pararCarga(){
		loadingAjax();
	}
	
	/* Validador de Formulario de recuperar contrase&oacute;a */	
$('#recover-password').formValidation({
		locale: 'es_ES',
		excluded: ':disabled',
		framework : 'bootstrap',
		icon : {
			valid : 'glyphicon glyphicon-ok',
			invalid : 'glyphicon glyphicon-remove',
			validating : 'glyphicon glyphicon-refresh'
		},
		addOns: { i18n: {} },
		err: { container: 'tooltip' },
		fields : {			
			rec_usuario : {validators : {
				notEmpty : {},
				blank: {}}}
		}
	}).on('success.field.fv', function(e, data) {
        if (data.fv.getInvalidFields().length > 0) {    // There is invalid field
            data.fv.disableSubmitButtons(true);
        }
    }).on('err.form.fv', function(e,data) {
    	//$(".dropdown-toggle").dropdown('toggle');
    }).on('success.form.fv', function(e) {
		e.preventDefault();
		//var url=$(this).data("url");
		//var sendurl="&url="+url;
		var form = $(e.target);
		var fv = form.data('formValidation');
		var method = "&method=recover";
		$.ajax({
			url: form.attr('action'), // la URL para la petición
           data: form.serialize() + method, // la información a enviar
            type: 'POST', // especifica si será una petición POST o GET
            dataType: 'json', // el tipo de información que se espera de respuesta            
            success: function (data) {            	
            	// código a ejecutar si la petición es satisfactoria;
            	// código a ejecutar si la petición es satisfactoria;
            	// console.log(data);
	            if (data.result === 'error'){
	            	for (var field in data.fields) {
	        			fv
	                    // Show the custom message
	                    .updateMessage(field, 'blank', data.fields[field])
	                    // Set the field as invalid
	                    .updateStatus(field, 'INVALID', 'blank');
	        			setTimeout(function(){
	        				$("#"+field).focus();	       			
	        			}, 10);
	            	}
	            	$(".dropdown-toggle").dropdown('toggle');
	            	
	            } else if(data.result==="Actualice") {
					elId=data.id;
	            	$("#actualizar").modal('show');
	            } else{
	            	swal({
						title: "Excelente", 
						text: "&iexcl;Revisa tu correo!",
						imageUrl: "galeria/img-site/logos/bill-ok.png",
						timer: 2000, 
						showConfirmButton: true
						}, function(){
							location.reload();
										
						});
                } 
          	},// código a ejecutar si la petición falla;
            error: function (xhr, status) {
            	SweetError(status);
            }
        });
	});		
 
/*	$(".izquierda").click(function(){
		var elDiv=$("#listaPublicaciones");
		var laPagina=elDiv.data("pagina");
		laPagina--;
		$.ajax({
			url:"fcn/f_index.php",
			data:{metodo:"buscarPublicaciones",pagina:laPagina},
			type:"POST",
			dataType:"html",
			success: function(data){
				console.log(data);
				elDiv.html(data);
				elDiv.data("pagina",laPagina);
			}
		});
	});*/
	
	
// Tooltip ------------------------------------
  $('[data-toggle="tooltip"]').tooltip();
//---------------------------------------------

// Popover------------------------------------
 // $('[data-toggle="popover"]').popover("show");
 //---------------------------------------------

	function buscaDerecha(){
		var elDiv=$("#listaPublicaciones");
		var elInicio=$("#inicio");
		var laPagina=$("#inicio").data("pagina");
		laPagina++;
		$.ajax({
			url:"fcn/f_index.php",
			data:{metodo:"buscarPublicaciones",pagina:laPagina},
			type:"POST",
			dataType:"html",
			success: function(data){
				console.log(data);
				elDiv.html(data);
				elInicio.data("pagina",laPagina);
			}
		});
	}
	
	$("#enviar-email").formValidation({
		locale: 'es_ES',
		excluded: ':disabled',
		framework : 'bootstrap',
		icon : {
			valid : 'glyphicon glyphicon-ok',
			invalid : 'glyphicon glyphicon-remove',
			validating : 'glyphicon glyphicon-refresh'
		},
		addOns: { i18n: {} },
		err: { container: 'tooltip' },
		fields : {			
			nombre : {validators : {
				notEmpty : {},
				stringLength : {max : 512},
				regexp: {regexp: /^[\u00F1a-z\s]+$/i}}},
			email : {validators : {
				notEmpty : {},
				emailAddress : {}}},			
			mensaje : {validators : {
				notEmpty:{}}				
			}
		}
	}).on('success.field.fv', function(e) {		
		e.preventDefault();
		email=$("#email").val();
		nombre=$("#nombre").val();
		mensaje=$("#mensaje").val();
		method="send-email";

	});	
$("#enviar").click(function(e){
		e.preventDefault();
		email=$("#email").val();
		nombre=$("#nombre").val();
		mensaje=$("#mensaje").val();
		method="send-email";
		$.ajax({
			url:"/fcn/f_usuarios.php",
			data:{'method':method,'nombre':nombre,'email':email,'mensaje':mensaje},
			type:"POST",
			dataType:"html",
			success:function(data){
				//alert(data);
			},
			error:function(xhr,status){
				alert(data);
				SweetError(status);
			}
		});
			swal({
						title: "Exito", 
						text: "Tu mensaje ha sido enviado.",
						imageUrl: "galeria/img-site/logos/bill-ok.png",
						timer: 2000, 
						showConfirmButton: true
				});
		
	});
	$(document).on('keyup',"#txtBusqueda",function(e){
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
	//$('.modal-conf').on('show.bs.modal', function (e) {	
	$("#btnEmpresa").click(function(e){
		e.preventDefault();
		$.ajax({
			url:"fcn/f_usuarios.php",
			data:{method:'get',id:elId},
			type:"POST",
			dataType:"json",
			success:function(data){
				console.log(data);
				$("#info-empresarial").modal('show');
       			$(".modal-conf #e_tipo").val(data.campos.j_tipo);
            	$(".modal-conf #e_razonsocial").val(data.campos.j_razon_social);
	           	$(".modal-conf #e_categoria").val(data.campos.j_categorias_juridicos_id);
	           	$(".modal-conf #e_rif").val(data.campos.j_rif);
	           	$('.modal-conf #e_telefono').val(data.campos.u_telefono);
	           	$(".modal-conf #e_estado").val(data.campos.u_estados_id);
	           	$('.modal-conf #e_direccion').val(data.campos.u_direccion);
            	$('.modal-conf #p_id').val(elId);
				$("#actualizar").hide();
			}
		});
	});
	$("#btnPersona").click(function(e){
		e.preventDefault();
		$.ajax({
			url:"fcn/f_usuarios.php",
			data:{method:'get',id:elId},
			type:"POST",
			dataType:"json",
			success:function(data){
				console.log(data);
				$("#actualizar").hide();
				$("#info-personal").modal('show');
            	$(".modal-conf #p_identificacion").val(data.campos.n_identificacion);
       			$(".modal-conf #p_tipo").val(data.campos.n_tipo);
            	$(".modal-conf #p_nombre").val(data.campos.n_nombre);
            	$(".modal-conf #p_apellido").val(data.campos.n_apellido);
            	$('.modal-conf #p_telefono').val(data.campos.u_telefono);
            	$(".modal-conf #p_estado").val(data.campos.u_estados_id);
            	$('.modal-conf #p_direccion').val(data.campos.u_direccion);
            	$('.modal-conf #p_identificacion').data('valid',data.campos.n_identificacion);
            	$('.modal-conf #p_id').val(elId);
			}
		});
	});
	
	/*$("#btnPersona2").click(function(e){
		/*$("#btn_sin_cuenta").data("tipo","1");
		$("#tw_reg_button").data("tipo","1");
	    $("#actualizar2").data("tipo","1");
	   
		$("#actualizar2").modal('hide');
		
		$("#usr-reg-title").html($("section[data-type='p']").data("title"));
			$("#usr-reg-submit").data("type","p");
			$("section[data-type='p']").fadeIn();
			$("#type").val("p");
	});	*/
	
	/*$("#btnEmpresa2").click(function(e){
		/*$("#btn_sin_cuenta").data("tipo","2");
		$("#tw_reg_button").data("tipo","2");
		$("#actualizar2").data("tipo","2"); 
		$("#actualizar2").modal('hide');
		$("#usr-reg-title").html($("section[data-type='e']").data("title"));
			$("#usr-reg-submit").data("type","e");
			$("section[data-type='e']").fadeIn();
			$("#type").val("e");
		
	});		
	
	*/
	
	$("#btnPersona2").click(function(e){
		/*$("#btn_sin_cuenta").data("tipo","1");
		/*$("#tw_reg_button").data("tipo","1");
	    $("#actualizar2").data("tipo","1");*/
	   
		$("#actualizar2").modal('hide');
		
		$("#usr-reg-title").html($("section[data-type='p']").data("title"));
			$("#usr-reg-submit").data("type","p");
			$("section[data-type='p']").fadeIn();
			$("#type").val("p");
	});
	$("#btnEmpresa2").click(function(e){
		/*$("#btn_sin_cuenta").data("tipo","2");
		$("#tw_reg_button").data("tipo","2");
		$("#actualizar2").data("tipo","2"); */
		$("#actualizar2").modal('hide');
		$("#usr-reg-title").html($("section[data-type='e']").data("title"));
			$("#usr-reg-submit").data("type","e");
			$("section[data-type='e']").fadeIn();
			$("#type").val("e");
		
	});		
	
	$("#info-personal").on("hidden.bs.modal",function(){
		$("#actualizar").modal('show');
	});
	$("#info-empresarial").on("hidden.bs.modal",function(){
		$("#actualizar").modal('show');
	});
	$("#insc-red").on("hidden.bs.modal",function(){
		if ($('#usr-reg').is(':hidden')){
		}
	});	
	
	$("#btn_sin_cuenta").click(function(){
		/*if ($(this).data("tipo")==1) {
			$("#usr-reg-title").html($("section[data-type='p']").data("title"));
			$("#usr-reg-submit").data("type","p");
			$("section[data-type='p']").fadeIn();
			$("#type").val("p");
		} else {
			$("#usr-reg-title").html($("section[data-type='e']").data("title"));
			$("#usr-reg-submit").data("type","e");
			$("section[data-type='e']").fadeIn();
			$("#type").val("e");
		}		*/
		$("#insc-red").modal('hide');
	});
	
	$(".btn_sin_cuenta").click(function(){
		if ($(this).data("tipo")==1) {
			$("#usr-reg-title").html($("section[data-type='p']").data("title"));
			$("#usr-reg-submit").data("type","p");
			$("section[data-type='p']").fadeIn();
			$("#type").val("p");
		} else {
			$("#usr-reg-title").html($("section[data-type='e']").data("title"));
			$("#usr-reg-submit").data("type","e");
			$("section[data-type='e']").fadeIn();
			$("#type").val("e");
		}		
		$("#insc-red").modal('hide');
	});
	$("#notificacion").click(function(){
		var id = $(this).data("id");
		$("#alerta").hide();
		$.ajax({									
			url: "fcn/f_usuarios.php",
			data: {method:"upd-Noti",id:id},
			type: "POST",
			dataType: "html",
			success:function(data){
				
					
			}
		});
	});
	$(document).on("click",".pre_pub",function(e){
		window.open("preguntas.php?tipo=1&publicacion=" + $(this).data("id_pub"),"_self");  
	});
	$(document).on("click",".resp_pub",function(e){
		window.open("preguntas.php?tipo=2&publicacion=" + $(this).data("id_pub"),"_self");
	});
	$(document).on("click",".detalle",function(e){
		window.open("detalle.php?id=" + $(this).data("id"),"_self");
	//	window.open("pub_" + $(this).attr("id"),"_self");
	});
	$(document).on("click",".perfil",function(e){
		window.open("perfil.php?id=" + $(this).data("id"),"_self");
	});
	
	
	
});
</script>