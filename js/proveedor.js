$(document ).ready(function() {
	 
	paginar(1, '#lista-prov-active');
	
	/****************AGREGAR PROVEEDOR**************/
		/**CHECK TITULAR**/
	$(".diff_titular_checkbox").change(function() {
		var $container    = $(this).parents('.form-proveedor');
	  	$container.find(".diff-titular-field").toggle("fast");
	   if ($(this).is(':checked')) {
	   		$container.find(".diff-titular-field input, .diff-titular-field select").prop("disabled",false);
	   }else{
	   		$container.find(".diff-titular-field input, .diff-titular-field select").prop("disabled",true);
	   }
	});
	
		/**BANCOS DINAMICOS**/	
	initFormValidation('#reg-prov-form');
	initFormValidation('#edit-prov-form');	
	// The maximum number of options
	function initFormValidation(formContainer){
    var MAX_OPTIONS = 15;
    $(formContainer)
        // Add button click handler
        .on('click', '.addButton', function() {
            var $template = $(formContainer+' #optionTemplate');           
             $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .addClass('aditionalOpt')                       
                                .insertBefore($template);
                                
                 $clone.find("input, select").prop("disabled",false);
                var $optionA   = $clone.find('[name="prov_banco[]"]');
                $optionB  = $clone.find('[name="prov_tipo_banco[]"]');
                $optionC  = $clone.find('[name="prov_nro_cuenta[]"]');
                
                 
            // Add new field
            $(formContainer).formValidation('addField', $optionA);
            $(formContainer).formValidation('addField', $optionB);
            $(formContainer).formValidation('addField', $optionC);
        })

        // Remove button click handler
        .on('click', '.removeButton', function() {
            var $row    = $(this).parents('.form-group'),
                $optionA  = $row.find('[name="prov_banco[]"]');
				$optionB  = $row.find('[name="prov_tipo_banco[]"]');
                $optionC  = $row.find('[name="prov_nro_cuenta[]"]');
            // Remove element containing the option
            $row.remove();

            // Remove field
            $(formContainer).formValidation('removeField', $optionA);
            $(formContainer).formValidation('removeField', $optionB);
            $(formContainer).formValidation('removeField', $optionC);
        })

        // Called after adding new field
        .on('added.field.fv', function(e, data) {
            // data.field   --> The field name
            // data.element --> The new field element
            // data.options --> The new field options

            if (data.field === 'prov_nro_cuenta[]') {
                if ($(formContainer).find(':visible[name="prov_nro_cuenta[]"]').length >= MAX_OPTIONS) {
                    $(formContainer).find('.addButton').attr('disabled', 'disabled');
                }
            }
        })

        // Called after removing the field
        .on('removed.field.fv', function(e, data) {
           if (data.field === 'prov_nro_cuenta[]') {
                if ($(formContainer).find(':visible[name="prov_nro_cuenta[]"]').length < MAX_OPTIONS) {
                    $(formContainer).find('.addButton').removeAttr('disabled');
                }
            }
        });
        
     }
        /**FIN BANCOS DINAMICOS**/    
    $("body").on('click', '.admin-reg-prov', function(e) {
		btnModalProveedor('#reg-prov-form');
	});
	 $("body").on('click', '.admin-edit-prov', function(e) {
		btnModalProveedor('#edit-prov-form');
		 $('#edit-prov-form').data("proveedor_id",$(this).data("proveedor_id"));	//usuario que modificare
      
	});
	function btnModalProveedor(container){ 
		$(container+" .btn-prov-submit").data("step",1).html('Continuar');
		$(container+" .diff-titular-field").hide();
		$(container+" section[data-step=2]").fadeOut( "fast", function() {
					$(container+" section[data-step=1]").fadeIn("fast");
				});
				
		step = $(container+" .btn-prov-submit").data("step");
		
	}	
	$(".btn-prov-submit").click(function(){
		var $container    = $(this).parents('.form-proveedor');
		var step, section;
		step = $(this).data("step");
		switch(step){
		case 1:
			if(validarFormReg(step,$container)){
				step++;
				$container.find(".btn-prov-submit").data("step",step);
				$container.find("section[data-step=1]").fadeOut( "slow", function() {
					$container.find("section[data-step='"+step+"']").fadeIn("slow");
					$container.find(".btn-prov-submit").html('Guardar');
				});
			}
			break;
		case 2:
			$container.data('formValidation').validate();
			break;
		}
	});
	function validarFormReg(step, $container){
		var fv = $container.data('formValidation'), // FormValidation instance 
		
		$container_section = $container.find('section[data-step="' + step +'"]');
		
        // Validate the container
        fv.validateContainer($container_section);
        var isValidStep = fv.isValidContainer($container);
        if (isValidStep === false || isValidStep === null) {
            // Do not jump to the next step
            return false;
        }        
        return true;
	}	
	$('#reg-prov-form').formValidation({
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
			prov_documento: {validators : {
				notEmpty:{},	
				digits:{},
				stringLength : { max :  10},
				blank: {}}},
			prov_nombre : {validators : {
				notEmpty : {},
				stringLength : {min : 5, max : 512}}},
			prov_email : {validators : {
				notEmpty : {},
				emailAddress : {},
				blank: {}}},
			prov_documento_titular: {validators : {
				notEmpty:{},	
				digits:{},
				stringLength : { max :  10},
				blank: {}}},
			prov_nombre_titular : {validators : {
				notEmpty : {},
				stringLength : {min : 5, max : 512}}},
			prov_email_titular : {validators : {
				notEmpty : {},
				emailAddress : {},
				blank: {}}},
			prov_telefono : {validators : {
				notEmpty : {},
				phone : {country:'VE'}}},			
			prov_direccion : {validators : {
				notEmpty : {},
				stringLength : {min: 10,max : 1024}}},
            'prov_nro_cuenta[]': {
                validators: {
                	notEmpty: {},
                	integer: {},                   
                    stringLength: {
                        max: 20,
                        min: 20,
                        message: 'Numero de cuenta debe ser exactamente 20 Numeros'
                    }
                }
            },
            'prov_banco[]': {
                validators: {
                	notEmpty: {}
                }
            },
            'prov_tipo_banco[]': {
                validators: {
                	notEmpty: {}
                }
            }
		}
	}).on('success.form.fv', function(e) {
		e.preventDefault();		
		var form = $(e.target);
		var fv = form.data('formValidation');
		var method = "&metodo="+$(this).data("method");		
		$.ajax({
			url: form.attr('action'), // la URL para la petición
            data: form.serialize() + method , // la información a enviar
            type: 'POST', // especifica si será una petición POST o GET
            dataType: 'json', // el tipo de información que se espera de respuesta		           
            success: function (data) {
	           	if (data.result === 'error') {
	            	for (var field in data.fields) {
	        			fv
	                    // Show the custom message
	                    .updateMessage(field, 'blank', data.fields[field])
	                    // Set the field as invalid
	                    .updateStatus(field, 'INVALID', 'blank');
	            	}
	            }else{ //si registramos usuarios por backend            			
            		swal({
						title: "Registro de Proveedor",
						text: "&iexcl;Proveedor Creado Exitosamente!",
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
  /******************************FIN AGREGAR PROVEEDORES*********************************/  
  /**********************MODIFICAR PROVEEDORES*********************/
 $('.modal-edit-proveedor').on('show.bs.modal', function (e) {
		var proveedor_id= $('#edit-prov-form').data("proveedor_id"),
		container='#edit-prov-form';
		defaultModal(container);
		proveedor_id = parseInt(proveedor_id);
		if(proveedor_id>0){
			$.ajax({
				url:"paginas/proveedor/fcn/f_proveedor.php", // la URL para la petici&oacute;n
	            data: {metodo:"getProveedores", id:proveedor_id}, // la informaci&oacute;n a enviar
	            type: 'POST', // especifica si ser&aacute; una petici&oacute;n POST o GET
	            dataType: 'json', // el tipo de informaci&oacute;n que se espera de respuesta
	            success: function (data) {
	            	// c&oacute;digo a ejecutar si la petici&oacute;n es satisfactoria; 
	            	if (data.result === 'OK') {
	            				$(container+' #prov_tipo').val(data.campos.p_tipo);
				            	$(container+' #prov_documento').val(data.campos.p_documento);
				            	$(container+' #prov_nombre').val(data.campos.p_nombre);
				            	$(container+' #prov_telefono').val(data.campos.p_telefono);
				            	$(container+' #prov_email').val(data.campos.p_email);
				            	$(container+' #prov_direccion').val(data.campos.p_direccion);			            	
				            	console.log(data.campos);
				            	if(data.campos.documento!=null && data.campos.email!=null){
				            		$(container+' #diff_titular').click();
				            		$(container+' #prov_tipo_titular').val(data.campos.tipo);
					            	$(container+' #prov_documento_titular').val(data.campos.documento);
					            	$(container+' #prov_nombre_titular').val(data.campos.nombre);
					            	$(container+' #prov_email_titular').val(data.campos.email);  		
				            	}
				            	getBancos(container, data.campos.id);
		            }
	          	},// c&oacute;digo a ejecutar si la petici&oacute;n falla;
	            error: function (xhr, status) {
	            	SweetError(status);
	            }
	        });
	    }
	});
	function getBancos(container, proveedor_id){
		$.ajax({
				url:"paginas/proveedor/fcn/f_proveedor.php", // la URL para la petici&oacute;n
	            data: {metodo:"getrBancos", id:proveedor_id}, // la informaci&oacute;n a enviar
	            type: 'POST', // especifica si ser&aacute; una petici&oacute;n POST o GET
	            dataType: 'html', // el tipo de informaci&oacute;n que se espera de respuesta
	            success: function (data) {
	            	$(container+' #optionTemplate').before(data);            	
	            	/*var $newsInputs=$(container+" .aditionalOpt input, "+container+" .aditionalOpt select");
	            	console.log(container);
	            	$(container).formValidation('addField', $newsInputs);*/
	            	 var $optionA   = $(container).find('[name="prov_banco[]"]');
	                $optionB  = $(container).find('[name="prov_tipo_banco[]"]');
	                $optionC  = $(container).find('[name="prov_nro_cuenta[]"]');	                
	                 
		            // Add new field
		            $(container).formValidation('addField', $optionA);
		            $(container).formValidation('addField', $optionB);
		            $(container).formValidation('addField', $optionC);	            	
	          	}, 
	            error: function (xhr, status) {
	            	SweetError(status);
	            }
	        });
	}
	function defaultModal(container){
		 var $container	= $(container);
		 
		 /**DEFAULT TITULAR**/
		 $container.find(".diff-titular-field input, .diff-titular-field select").prop("disabled",true);
		 $container.find(".diff-titular-field").hide();
		 $container.find( ".diff_titular_checkbox" ).prop( "checked", false );
		 
		 /**DEFAULT BANCOS**/
		 $container.find(".aditionalOpt").remove();
	}
	
 $('#edit-prov-form').formValidation({
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
			prov_documento: {validators : {
				notEmpty:{},	
				digits:{},
				stringLength : { max :  10},
				blank: {}}},
			prov_nombre : {validators : {
				notEmpty : {},
				stringLength : {min : 5, max : 512}}},
			prov_email : {validators : {
				notEmpty : {},
				emailAddress : {},
				blank: {}}},
			prov_documento_titular: {validators : {
				notEmpty:{},	
				digits:{},
				stringLength : { max :  10},
				blank: {}}},
			prov_nombre_titular : {validators : {
				notEmpty : {},
				stringLength : {min : 5, max : 512}}},
			prov_email_titular : {validators : {
				notEmpty : {},
				emailAddress : {},
				blank: {}}},
			prov_telefono : {validators : {
				notEmpty : {},
				phone : {country:'VE'}}},			
			prov_direccion : {validators : {
				notEmpty : {},
				stringLength : {min: 10,max : 1024}}},
            'prov_nro_cuenta[]': {
                validators: {
                	notEmpty: {},
                	integer: {},                   
                    stringLength: {
                        max: 20,
                        min: 20,
                        message: 'Numero de cuenta debe ser exactamente 20 Numeros'
                    }
                }
            },
            'prov_banco[]': {
                validators: {
                	notEmpty: {}
                }
            },
            'prov_tipo_banco[]': {
                validators: {
                	notEmpty: {}
                }
            }
		}
	}).on('success.form.fv', function(e) {
		e.preventDefault();	
		var form = $(e.target);
		var fv = form.data('formValidation');
		var method = "&metodo="+$(this).data("method");
		var id = "&id="+$(this).data("proveedor_id");
		$.ajax({
			url: form.attr('action'), // la URL para la petición
            data: form.serialize() + method + id, // la información a enviar
            type: 'POST', // especifica si será una petición POST o GET
            dataType: 'json', // el tipo de información que se espera de respuesta		           
            success: function (data) {
	           	if (data.result === 'error') {
	            	for (var field in data.fields) {
	        			fv
	                    // Show the custom message
	                    .updateMessage(field, 'blank', data.fields[field])
	                    // Set the field as invalid
	                    .updateStatus(field, 'INVALID', 'blank');
	            	}
	            }else{ //si registramos usuarios por backend            			
            		swal({
						title: "Registro de Proveedor",
						text: "&iexcl;Proveedor Creado Exitosamente!",
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
    
 /*******************************MOSTRAR DETALLE PROVEEDOR******************************/	
 
  
	$("body").on('click', '.admin-ver-prov', function(e) {
	 	
	 	var proveedores_id= $(this).data("proveedor_id"),
	    $modal=$('.modal-detalle-prov');
		proveedores_id = parseInt(proveedores_id);
		  
		if(proveedores_id>0){			
			
			$.ajax({
				url:"paginas/proveedor/fcn/f_proveedor.php", // la URL para la petici&oacute;n
		        data: {metodo:"buscarDetalleProveedores", id:proveedores_id}, // la informaci&oacute;n a enviar
		        type: 'POST', // especifica si ser&aacute; una petici&oacute;n POST o GET
		        dataType: 'json', // el tipo de informaci&oacute;n que se espera de respuesta
		        success: function (data) {
		        	// c&oacute;digo a ejecutar si la petici&oacute;n es satisfactoria;
		        	if (data.result === 'OK') {            		
		        		 
		        		$modal.find('.info-prov-detalle .nombre').html(data.campos.p_nombre);	
		        		$modal.find('.info-prov-detalle .documento').html(data.campos.p_tipo+' - '+data.campos.p_documento);	            	
		            	$modal.find('.info-prov-detalle .telefono').html(data.campos.p_telefono);
		            	$modal.find('.info-prov-detalle .correo').html(data.campos.p_email);
		            	$modal.find('.info-prov-detalle .direccion').html(data.campos.p_direccion);
		            	
		            	if(data.campos.documento!=null){
		            		$modal.find('.info-prov-titular-detalle').removeClass('hide');
		            		$modal.find('.info-prov-titular-detalle .nombre').html(data.campos.nombre);	
		            		$modal.find('.info-prov-titular-detalle .documento').html(data.campos.tipo+' - '+data.campos.documento);	            	
			            	$modal.find('.info-prov-titular-detalle .telefono').html(data.campos.telefono);
			            	$modal.find('.info-prov-titular-detalle .correo').html(data.campos.email);
			            	$modal.find('.info-prov-titular-detalle .direccion').html(data.campos.direccion);
		            	}else{
		            		$modal.find('.info-prov-titular-detalle').addClass('hide');
		            	}
		            	$modal.find('.info-bancaria').html(data.campos.bancos);		            	
		            }
		      	},// c&oacute;digo a ejecutar si la petici&oacute;n falla;
		        error: function (xhr, status) {
		        	SweetError(status);
		        }
		    });
        
       }
	});
	/********************FUNCIONES REALIZADAS PARA OPTIMIZAR EL LISTADO**************/
	function paginar(pagina, container, status){
		var total=$(container+" #paginacion").data("total"); 
		loadingAjax(true);
		$.ajax({
			url:"paginas/proveedor/fcn/f_proveedor.php",
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
			}
		});
	}	
	
});