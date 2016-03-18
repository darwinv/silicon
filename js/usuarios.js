$(document ).ready(function() {
	

	
$("#update_usr-reg-submit").click(function(){
		$("#usr-update-form").data('formValidation').validate();
});

/* ============================----- Modal Registrar -----=========================*/
  
	$(".admin-reg-user").click(function(){
		$("#usr-reg-submit-admin").data("step",1);
		$("#type_admin").val("p");
		$("section[data-step=2]").fadeOut( "fast", function() {  
					$("section[data-step=1]").fadeIn("fast");
				});
	});
	$("#usr-reg-submit-admin").click(function(){
		var step, section;
		step = $(this).data("step");  
		switch(step){
		case 1:
			if(validarFormReg(step)){  
				step++;
				$(this).data("step",step);		 
				$("section[data-step=1]").fadeOut( "slow", function() { 
					$("section[data-step='"+step+"']").fadeIn("slow");
					document.getElementById("seudonimo_admin").focus();									
				});
				 
			}
			break;
		case 2:
			$("#usr-reg-form-admin").data('formValidation').validate();
			break;
		}
	});
	$('#usr-reg-form-admin').formValidation({
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
			p_identificacion_admin: {validators : {
				notEmpty:{},
				digits:{},	
				stringLength : { max : 10 },
				blank: {}}},
			p_nombre_admin : {validators : {
				notEmpty : {},
				stringLength : {max : 512},
				regexp: {regexp: /^[\u00F1a-z\s]+$/i}}},
			p_apellido_admin : {validators : {
				notEmpty : {},
				stringLength : {max : 512},
				regexp: {regexp: /^[\u00F1a-z\s]+$/i}}},
			p_telefono_admin : {validators : {
				notEmpty : {},
				phone : {country:'VE'}}},
			p_estado_admin : {validators : {
				notEmpty : {}}},
			p_direccion_admin : {validators : {
				notEmpty : {},
				stringLength : {min: 10,max : 1024}}},
			e_rif_admin: {validators : {
				notEmpty:{},	
				digits:{},
				stringLength : { max :  10},
				blank: {}}},
			e_razonsocial_admin : {validators : {
				notEmpty : {},
				stringLength : {min : 5, max : 512}}},
			e_categoria_admin : {validators : {
				notEmpty : {}}},
			e_telefono_admin : {validators : {
				notEmpty : {},
				phone : {country:'VE'}}},
			e_estado_admin : {validators : {
				notEmpty : {}}},
			e_direccion_admin : {validators : {
				notEmpty : {},
				stringLength : {min: 10,max : 1024}}},			
			seudonimo_admin : {validators : {
				notEmpty : {},
				stringLength : {max : 64},
				regexp: {regexp: /^[a-zA-Z0-9_.-]*$/i},
				blank: {}}},
			email_admin : {validators : {
				notEmpty : {},
				emailAddress : {},
				blank: {}}},
			email_val_admin : {validators : {
				identical: {field: 'email_admin'}}},
			password_admin : {validators : {
				notEmpty : {},
				stringLength : {min:6,max : 64}}},
			password_val_admin : {validators : {
				identical: {field: 'password_admin'}}}
		}
	}).on('success.form.fv', function(e) {
		e.preventDefault();				
		var form = $(e.target);
		var fv = form.data('formValidation');
		//var foto = "&foto="+$("#foto-usuario").attr("src");
		var method = "&method="+$(this).data("method");
		
		$.ajax({
			url: form.attr('action'), // la URL para la petición
            data: form.serialize() + method , // la información a enviar
            type: 'POST', // especifica si será una petición POST o GET
            dataType: 'json', // el tipo de información que se espera de respuesta		           
            success: function (data) {
            	// código a ejecutar si la petición es satisfactoria;	
            	// console.log(data);
	           	if (data.result === 'error') {
            		$("section").hide();
            		keys = Object.keys(data.fields);
            		if(jQuery.inArray("e_rif_admin",keys) !== -1 || jQuery.inArray("p_identificacion_admin",keys) !== -1){
            			$("#usr-reg-submit-admin").data("step",1);
            			$("section[data-step=1]").show();
            		}else if(jQuery.inArray("seudonimo_admin",keys) !== -1 || jQuery.inArray("email_admin",keys)!== -1){
            			$("#usr-reg-submit-admin").data("step",2);	
            			$("section[data-step=2]").show();
            		}
	            	for (var field in data.fields) { 
	        			fv
	                    // Show the custom message
	                    .updateMessage(field, 'blank', data.fields[field])
	                    // Set the field as invalid
	                    .updateStatus(field, 'INVALID', 'blank');
	            	}
	            }else{ //si registramos usuarios por backend
	            			
	            				swal({
							title: "Registro de Usuario", 
							text: "&iexcl;Usuario Creado Exitosamente!",
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
/**************MODIFICAR USUARIO*************/
$('#usr-update-form').formValidation({
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
			update_seudonimo : {validators : {
				notEmpty : {},
				stringLength : {max : 64},
				regexp: {regexp: /^[a-zA-Z0-9_.-]*$/i},
				blank: {}}},
			update_email : {validators : {
				notEmpty : {},
				emailAddress : {},
				blank: {}}},
			email_val : {validators : {
				identical: {field: 'email'}}},
			update_password : {validators : {
				notEmpty : {},
				stringLength : {min:6,max : 64}}},
			update_password_val : {validators : {
				identical: {field: 'update_password'}}}
		}
	}).on('success.form.fv', function(e) {
	 
		e.preventDefault();			
		var form = $(e.target);
		var fv = form.data('formValidation'); 
		var method = "&method="+$(this).data("method");
		 
		var usuarios_id = "&update_usuarios_id="+$(this).data("usuarios_id");
		 
		$.ajax({
			url: form.attr('action'), // la URL para la petición
            data: form.serialize() + method + usuarios_id, // la información a enviar
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
	            }else{  
	            	
	            	swal({
							title: "Usuario Actualizado", 
							text: "&iexcl;Usuario Actualizado Exitosamente!",
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
	$("body").on('click', '.btn-container-password', function(e) {		
		var disable=$("#usr-update-info #update_password").prop("disabled");  
		if(disable){
			show_update_password();
		 	$(this).data("status","1");		
		}else{
			hide_update_password();
		 	$(this).data("status","0");	
		}		
	});	 
	 
	
	$("body").on('click', '.update_user', function(e) {   
		hide_update_password();
        $("section[data-step='2']").show();	  
        $('#usr-update-form').data("usuarios_id",$(this).data("usuarios_id"));	//usuario que modificare 
		$('#usr-update-info').data("usuarios_id",$(this).data("usuarios_id"));		//para auto-cargar la data del formulario	 
	});
	
	/* ============================----- Actualizar info social -----=========================*/	 
	$('.modal-update-user').on('show.bs.modal', function (e) { 
		 
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
				            	$('.modal-update-user #update_seudonimo').val(data.campos.a_seudonimo);
				            	$('.modal-update-user #update_email').val(data.campos.a_email);
				            	$('.modal-update-user #update_id_rol_select').val(data.campos.a_id_rol);	 
		            }
	          	},// c&oacute;digo a ejecutar si la petici&oacute;n falla;
	            error: function (xhr, status) {
	            	SweetError(status);
	            }
	        });
	    }
	});	
	
	
	/*---======= FORM PARA ELIMINAR USUARIOS ========---*/
    $("body").on('click', '.select-usr-delete', function(e) {
    	//guardamos el ID del usuario que borraremos logicamente   
    	$('#usr-act-form-delete').data("usuarios_id",$(this).data("usuarios_id"));    	 
    });
    $("body").on('click', '.select-usr-active', function(e) {
    	//guardamos el ID del usuario que borraremos logicamente   
    	$('#usr-act-form-active').data("usuarios_id",$(this).data("usuarios_id"));    	 
    });
    
    
   /********************ELIMINAR USUARIO **********************/
	$('.usr-act-form-edit').formValidation({ 
	
	}).on('success.form.fv', function(e) {   
		e.preventDefault();
		var form = $(e.target); 
		var method = "&method="+$(this).data("method");  
		var status = "&status_usuarios_id="+$(this).data("status"); ;
		var usuario = "&usuarios_id="+$(this).data("usuarios_id");
		$.ajax({
			url: form.attr('action'), // la URL para la petición
            data: method + status + usuario, // la información a enviar
            type: 'POST', // especifica si será una petición POST o GET
            dataType: 'json', // el tipo de información que se espera de respuesta
            success: function (data) {
            	if (data.result === 'error'){
	            	SweetError("Borrar Usuario");
	            	$('#msj-eliminar').modal('hide');
	            }else{
	            	location.reload();
                } 
            	
          	},// código a ejecutar si la petición falla;
            error: function (xhr, status) {
            	SweetError(status);
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
				            	
				            	$('.modal-datail-user .rif').html(data.campos.n_identificacion); 
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
	
    /* ============================----- Mostrar Detalle Tienda -----=========================*/	 
	$('.modal-detalle-user').on('show.bs.modal', function (e  ) { 
		 
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
				            	$('.modal-update-user #update_seudonimo').val(data.campos.a_seudonimo);
				            	$('.modal-update-user #update_email').val(data.campos.a_email);
				            	$('.modal-update-user #update_id_rol_select').val(data.campos.a_id_rol);	 
		            }
	          	},// c&oacute;digo a ejecutar si la petici&oacute;n falla;
	            error: function (xhr, status) {
	            	SweetError(status);
	            }
	        });
	    }
	});	
	
	$(document).on("click",".tab-shop",function(e){ 
		var status=$(this).data("status");
		if(status==3){
			$(".admin-reg-user").addClass("hidden");
		}else{
			$(".admin-reg-user").removeClass("hidden");
		}

	}); 
    $(document).on("click",".botonPagina",function(e){
		e.preventDefault();
		var pagina=$(this).data("pagina");
		var container=$(this).data("container");
		var status=$(this).data("status");
		paginar(pagina, container, status);
	});
	$(document).on("click",".navegador",function(e){
		e.preventDefault();
		var container=$(this).data("container");
		var status=$(this).data("status");
		var pagina=$(container+" #paginacion").data("paginaactual"); 
		console.log(pagina);
		switch($(this).data("funcion")){
			case "anterior1": 
				pagina--;			 
				break;
			case "anterior2":
				var i=pagina;
				while(true){
					$('#paginacion').find('[data-pagina=' + i + ']').parent().addClass("hidden");
					$('#paginacion').find('[data-pagina=' + (i - 10) + ']').parent().removeClass("hidden");
					if(i % 10 == 0)
					break;
					i++;
				}
				i=pagina-1;		
				while(true){
					$('#paginacion').find('[data-pagina=' + i + ']').parent().addClass("hidden");
					$('#paginacion').find('[data-pagina=' + (i - 10) + ']').parent().removeClass("hidden");
					if(i % 10 == 0)
					break;
					i--;
				}
				if(((i-10) * 25)<=0)
				$("#paginacion #anterior2").addClass("hidden");
				var actual=pagina - 10;
				pagina-=10;
				var actual=pagina;
				//paginar(pagina,actual);
				$("#paginacion #siguiente2").removeClass("hidden");			
				break;
			case "siguiente1": 
				pagina++;			 
				break;
			case "siguiente2":
				var i=pagina;
				while(true){
					$('#paginacion').find('[data-pagina=' + i + ']').parent().addClass("hidden");
					$('#paginacion').find('[data-pagina=' + (i + 10) + ']').parent().removeClass("hidden");
					if(i % 10 == 0)
					break;
					i--;
				}
				i=pagina+1;		
				while(true){
					$('#paginacion').find('[data-pagina=' + i + ']').parent().addClass("hidden");
					$('#paginacion').find('[data-pagina=' + (i + 10) + ']').parent().removeClass("hidden");
					if(i % 10 == 0)
					break;
					i++;	
				}
				if(((i+10) * 25)>=$("#paginacion").data("total"))
				$("#paginacion #siguiente2").addClass("hidden");
				var actual=pagina + 10;
				pagina+=10;
				var actual=pagina;
				
				$("#paginacion #anterior2").removeClass("hidden");
				break;
		}
		
		paginar(pagina,container,status); 
	});
	/********************FUNCIONES REALIZADAS PARA OPTIMIZAR EL LISTADO**************/
	function paginar(pagina, container, status){ 
		
		var total=$(container+" #paginacion").data("total"); 
		loadingAjax(true);
		$.ajax({
			url:"paginas/adminusr/fcn/f_adminusr.php",
			data:{metodo:"buscar",pagina:pagina,total:total,orden:" ",status:status},
			type:"POST",
			dataType:"html",
			success:function(data){
				$(container+" #ajaxContainer").html(data);
				$(container+" #paginacion li").removeClass("active");
				$(container+" #paginacion").find('[data-pagina=' + pagina + ']').parent().addClass("active");				
				$(container+" #inicio").text(((pagina-1)*25)+1);
				if(total<pagina*25){		
					$(container+" #final").text(total + " de ");
				}else{
					$(container+" #final").text(pagina*25 + " de ");
				}
				$(container+" html,body").animate({
    				scrollTop: 0
				}, 200);
				if(pagina % 10 == 1){
					$(container+" #paginacion #anterior1").addClass("hidden");
				}else{
					$(container+" #paginacion #anterior1").removeClass("hidden");
				}			
				$(container+" #paginacion").data("paginaactual",pagina);
				if(pagina*25>=total || pagina % 10==0){
					$(container+" #paginacion #siguiente1").addClass("hidden");
				}else{
					$(container+" #paginacion #siguiente1").removeClass("hidden");
				}
				loadingAjax(false);
				
				
				/*$(container+" #paginacion li").removeClass("active");
				$(container+" #paginacion").find('[data-pagina=' + pagina + ']').parent().addClass("active");
				$(container+" #ajaxContainer").html(data);
				$(container+" #inicio").text(((pagina-1)*25)+1);
				if(total<pagina*25){		
					$(container+" #final").text(total + " de ");
				}else{
					$(container+" #final").text(pagina*25 + " de ");
				}
				$('html,body').animate({
    				scrollTop: 0
				}, 200);
				if(pagina % 10 == 1){
					$(container+" #paginacion #anterior1").addClass("hidden");
				}else{
					$(container+" #paginacion #anterior1").removeClass("hidden");
				}			
				$(container+" #principal #paginacion").data("paginaactual",pagina);
				if(pagina*25>=total || pagina % 10==0){
					$(container+" #paginacion #siguiente1").addClass("hidden");
				}else{
					$(container+" #paginacion #siguiente1").removeClass("hidden");
				}
				loadingAjax(false);*/
			}
		});
	}
	
	/**FUNCIONES PARA CAMBIAR DATOS DE USUARIOS**/
	function show_update_password(){
		$('.password_container .input').removeClass('hidden');
		$(".password_container .input").fadeIn("slow"); 			
		$("#usr-update-info #update_password, #update_password_val").prop("disabled",false);
	}
	function hide_update_password(){
		$(".password_container .input").fadeOut("slow", function() {
		   $('.password_container .input').addClass('hidden');
		});	 
		$("#usr-update-info #update_password, #update_password_val").prop("disabled",true);
	}
	function validarFormReg(step){ 
		var fv = $('#usr-reg-form-admin').data('formValidation'), // FormValidation instance 
		
		$container = $('#usr-reg-form-admin').find('section[data-step="' + step +'"]');
		
        // Validate the container
        fv.validateContainer($container);	
        var isValidStep = fv.isValidContainer($container);
        if (isValidStep === false || isValidStep === null) {
            // Do not jump to the next step
            return false;
        }        
        return true;
	}
	
	
	/****FUNCION PARA ARMAR LOS LISTADOS USUARIOS ACTIVOS E INACTIVOS**/
	paginar(1, '#lista-shop-active', 1);
	paginar(1, '#lista-shop-inactive', 3);
	
});
 
