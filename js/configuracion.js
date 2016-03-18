/**
 * JS "configuracion.php"
 */
$(document).ready(function(){
	$("#info-usuario").click(function(){
		if($(this).data("type") === "N"){
			$("#info-personal").modal("show");
		}else{
			$("#info-empresarial").modal("show");
		}
	});
	/*---======= Validacion de Datos Personales NAT ========---*/
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
		var method = "&method=act-nat";
		$.ajax({
			url: form.attr('action'), // la URL para la petici&oacute;n
            data: form.serialize() + method, // la informaci&oacute;n a enviar
            type: 'POST', // especifica si ser&aacute; una petici&oacute;n POST o GET
            dataType: 'json', // el tipo de informaci&oacute;n que se espera de respuesta
            success: function (data) {
            	// c&oacute;digo a ejecutar si la petici&oacute;n es satisfactoria;
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
							location.reload();
						});
                }
          	},// c&oacute;digo a ejecutar si la petici&oacute;n falla;
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
		var method = "&method=act-jur";
		$.ajax({
			url: form.attr('action'), // la URL para la petici&oacute;n
            data: form.serialize() + method, // la informaci&oacute;n a enviar
            type: 'POST', // especifica si ser&aacute; una petici&oacute;n POST o GET
            dataType: 'json', // el tipo de informaci&oacute;n que se espera de respuesta
            success: function (data) {
            	// c&oacute;digo a ejecutar si la petici&oacute;n es satisfactoria;
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
							location.reload();
						});
                }
          	},// c&oacute;digo a ejecutar si la petici&oacute;n falla;
            error: function (xhr, status) {
            	SweetError(status);
            }
        });
    });
	/*---======= Validacion de Datos Personales Correo ========---*/
	$('#usr-act-form-email').formValidation({
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
			email : {validators : {
				notEmpty : {},
				emailAddress : {},
				blank: {}}}
		}
	}).on('success.form.fv', function(e) {
		e.preventDefault();
		var form = $(e.target);
		var fv = form.data('formValidation');
		var method = "&method=act-email";
		$.ajax({
			url: form.attr('action'), // la URL para la petici&oacute;n
            data: form.serialize()+ method, // la informaci&oacute;n a enviar
            type: 'POST', // especifica si ser&aacute; una petici&oacute;n POST o GET
            dataType: 'json', // el tipo de informaci&oacute;n que se espera de respuesta
            success: function (data) {
            	// c&oacute;digo a ejecutar si la petici&oacute;n es satisfactoria;
            	console.log(data);
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
							location.reload();
						});
                }
          	},// c&oacute;digo a ejecutar si la petici&oacute;n falla;
            error: function (xhr, status) {
            	SweetError(status);
            }
        });
    });
	/*---======= Validacion de Datos Personales Seudonimo ========---*/
	$('#usr-act-form-seudonimo').formValidation({
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
			seudonimo : {validators : {
				notEmpty : {},
				stringLength : {max : 64},
				regexp: {regexp: /^[a-zA-Z0-9_.-]*$/i},
				blank: {}}}
		}
	}).on('success.form.fv', function(e) {
		e.preventDefault();
		var form = $(e.target);
		var fv = form.data('formValidation');
		var method = "&method=act-seudonimo";
		$.ajax({
			url: form.attr('action'), // la URL para la petici&oacute;n
            data: form.serialize()+ method, // la informaci&oacute;n a enviar
            type: 'POST', // especifica si ser&aacute; una petici&oacute;n POST o GET
            dataType: 'json', // el tipo de informaci&oacute;n que se espera de respuesta
            success: function (data) {
            	// c&oacute;digo a ejecutar si la petici&oacute;n es satisfactoria;
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
							location.reload();
						});
                }
          	},// c&oacute;digo a ejecutar si la petici&oacute;n falla;
            error: function (xhr, status) {
            	SweetError(status);
            }
        });
    });
	/*---======= Validacion de Datos Personales Password ========---*/
	$('#usr-act-form-pass').formValidation({
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
			password_act : {validators : {
				notEmpty : {}}},
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
		var method = "&method=act-pass";
		var bill,text,title;
		$.ajax({
			url: form.attr('action'), // la URL para la petici&oacute;n
            data: form.serialize() + method, // la informaci&oacute;n a enviar
            type: 'POST', // especifica si ser&aacute; una petici&oacute;n POST o GET
            dataType: 'json', // el tipo de informaci&oacute;n que se espera de respuesta
            success: function (data) {
            	// c&oacute;digo a ejecutar si la petici&oacute;n es satisfactoria;
            	// console.log(data);
	            if (data.result !== 'error') {
	            	title = "Exito";
	            	text = "Se actualizo correctamente.";
	            	image = "bill-ok.png";
	            } else {
	            	title = "Error";
	            	text = "La contrase\u00f1a es incorrecta.";
	            	image = "bill-error.png";
	            }
	            swal({
					title: title,
					text: text,
					imageUrl: "galeria/img-site/logos/"+image,
					timer: 2000,
					showConfirmButton: true
					}, function(){
						location.reload();
					});
          	},// c&oacute;digo a ejecutar si la petici&oacute;n falla;
            error: function (xhr, status) {
            	SweetError(status);
            }
        });
    });
	/* ============================----- Actualizar info social -----=========================*/	
	$('.modal-conf').on('show.bs.modal', function (e) {
		var type = $(this).data("type");
		$.ajax({
			url: "fcn/f_usuarios.php", // la URL para la petici&oacute;n
            data: {method:"get"}, // la informaci&oacute;n a enviar
            type: 'POST', // especifica si ser&aacute; una petici&oacute;n POST o GET
            dataType: 'json', // el tipo de informaci&oacute;n que se espera de respuesta
            success: function (data) {
            	// c&oacute;digo a ejecutar si la petici&oacute;n es satisfactoria;
            	// console.log(data);
            	if (data.result === 'OK') {
	            	switch(type){
		        		case "seudonimo":
		        			$("#seudonimo").val(data.campos.a_seudonimo);
		        			break;
		        		case "personal":
		        			$("#p_tipo").val(data.campos.n_tipo);
			            	$("#p_nombre").val(data.campos.n_nombre);
			            	$("#p_apellido").val(data.campos.n_apellido);
			            	$("#p_identificacion").val(data.campos.n_identificacion);
			            	$('#p_telefono').val(data.campos.u_telefono);
			            	$("#p_estado").val(data.campos.u_estados_id);
			            	$('#p_direccion').val(data.campos.u_direccion);
			            	$('#p_identificacion').data('valid',data.campos.n_identificacion);
		        			break;
		        		case "empresarial":
		        			$("#e_tipo").val(data.campos.j_tipo);
			            	$("#e_razonsocial").val(data.campos.j_razon_social);
			            	$("#e_categoria").val(data.campos.j_categorias_juridicos_id);
			            	$("#e_rif").val(data.campos.j_rif);
			            	$('#e_telefono').val(data.campos.u_telefono);
			            	$("#e_estado").val(data.campos.u_estados_id);
			            	$('#e_direccion').val(data.campos.u_direccion);
		        			break;
		        		case "correo":
		        			$("#email").val(data.campos.a_email);
		        			break;
	        		}
	            }
          	},// c&oacute;digo a ejecutar si la petici&oacute;n falla;
            error: function (xhr, status) {
            	SweetError(status);
            }
        });
	});	
	$( "#btn-social-act" ).click(function(){
		var form = $( "#usr-act-form-social" );
		var fv = form.data('formValidation');
		var method = "&method=act-social";
		$.ajax({
			url: form.attr('action'), // la URL para la petici&oacute;n
            data: form.serialize() + method, // la informaci&oacute;n a enviar
            type: 'POST', // especifica si ser&aacute; una petici&oacute;n POST o GET
            dataType: 'html', // el tipo de informaci&oacute;n que se espera de respuesta
            success: function (data) {
            	// c&oacute;digo a ejecutar si la petici&oacute;n es satisfactoria;
            	console.log(data);
	            if (data.result !== 'error') {
	            	swal({
						title: "Exito",
						text: "Se actualizo correctamente.",
						imageUrl: "galeria/img-site/logos/bill-ok.png",
						timer: 2000,
						showConfirmButton: true
						}, function(){							
							//location.reload();
						});
	            }
          	},// c&oacute;digo a ejecutar si la petici&oacute;n falla;
            error: function (xhr, status) {
            	SweetError(status);
            }
        });
	});	
	$("#configuracion").css("display","block");
	$("#uno4").addClass("active");
});
