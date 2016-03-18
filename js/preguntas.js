$(document).ready(function(){
	
	$(".limpiar").click(function(){
		var id=$(this).data("id");
		var pub_id=$(this).data("pub_id");
		$("#txtPregunta"+pub_id).val("");
		$("#txtRespuesta"+id).val("");
		var restante = 240;
		$("#restante"+id).text(restante);
	});
	
	$(".limpiarP").click(function(){
		var id=$(this).data("id");
		var pub_id=$(this).data("pub_id");
		$("#txtPregunta"+pub_id).val("");
		var restante = 240;
		$("#restante"+id).text(restante);
	});
	
	$(".btnResponder").click(function(e){
		e.preventDefault();	
		var siguiente = $(this).data("activar");
		var primero = $(this).data("primero");
		var id_poster = $(this).data("id_poster");
		var id=$(this).data("id");								// id de la pregunta
		var pub_id=$(this).data("pub_id");						// id de la publicacion
		var usr_id = $(this).data("usr_id");					// id del usuario que realizo la pregunta			
		var cantP = $("#cantP").text();
		var cant= parseInt($("#panel"+pub_id).data("cant-pregunta"));		
		if($("#txtRespuesta" + id).val() != ""){		
			var respuesta=$("#txtRespuesta" + id).val();
			$.ajax({											// Primer ajax guarda la respuesta			
				url: "paginas/preguntas/fcn/f_pregunta.php",
				data:{ metodo:"guardarRespuesta",id:id,respuesta:respuesta,pub_id:pub_id,tipo:2,usr:usr_id},
				type: "POST",
				dataType: "html",	
				success:function(data){
					cantP--;
					cant--; 
					$("#" + id).remove(); 
					if(cant==0){
						$("#panel"+pub_id).addClass("hidden");
						$("p.toggleResponder:first").click();
					}else{
						$("#panel"+pub_id+" p.toggleResponder:first").click();						
					} 
					
					$("#cantP").text(cantP);
					$("#panel"+pub_id).data("cant-pregunta",cant);
					 
							if($(".activo").is(":visible")){
										
								if(primero==id){
									$(this).data("primero",siguiente);
									var nuevo = $(this).data("primero");
									$("#responder" + nuevo).css("display","block");
								}else
								if(siguiente==primero){
								$("#responder" + primero).css("display","block");
								}else
								$("#responder" + primero).css("display","block");
							}	
	
					$.ajax({									// Segundo ajax envia notifiacion al correo del usuario que realizo la pregunta
						url: "paginas/preguntas/fcn/f_pregunta.php",
						data: {metodo:"enviarRespuesta",pub_id:pub_id,usr_id:usr_id,respuesta:respuesta,id_poster:id_poster},
						type: "POST",
						dataType: "html",
						success:function(data){
							
					
						}										
					});//cierre segundo ajax				
				}			
			});	//cierre primer ajax		
		}		
	});
	
	$(".btnPreguntar").click(function(e){
		e.preventDefault();
		var cantP = $("#cantP").text();
		var id_poster = $(this).data("id_poster");
		var pub_id=$(this).data("pub_id");
		var usr_id = $(this).data("usr_id");
		if($("#txtPregunta" + pub_id).val() != ""){		
			var pregunta=$("#txtPregunta" + pub_id).val();
			var nuevo = ' <br>';
			nuevo = nuevo + '<p class="t14 marL20 marR20" id="pregun';
			nuevo = nuevo + pub_id+1000;
			nuevo = nuevo + '" style="border-bottom: #ccc 1px dashed;" >';
			nuevo = nuevo + '<i class="fa fa-comment blueO-apdp marL10"></i> <span class="marL5">';
			nuevo = nuevo + pregunta;
			nuevo = nuevo + '<br></span> <br>';
			nuevo = nuevo + '</p>';		
			$.ajax({
				url: "paginas/preguntas/fcn/f_pregunta.php",
				data:{ metodo:"guardarPregunta",respuesta:pregunta,pub_id:pub_id,tipo:1,usr:usr_id},
				type: "POST",
				dataType: "html",	
				success:function(data){	
					cantP++;			
					$("#panel"+pub_id).prepend(nuevo);
					$("#cantP").text(cantP);
					$("#" + pub_id).css("display","none");
					$("#Preguntar"+pub_id).text("Hacer otra Pregunta");
						$.ajax({									// Segundo ajax envia notifiacion al correo de usuario due&ntilde;o de la publicacion
						url: "paginas/preguntas/fcn/f_pregunta.php",
						data: {metodo:"enviarPregunta",pub_id:pub_id,usr_id:usr_id,pregunta:pregunta,id_poster:id_poster},
						type: "POST",
						dataType: "html",
						success:function(data){
							
						}										
					});//cierre segundo ajax	
				}			
			});			
		}		
		
	});

	$(".eliminar").click(function(e){
		e.preventDefault();
		var id=$(this).data("id");
		var pub_id= $(this).data("pub_id");
		var cantP = $("#cantP").text();
		var cant= parseInt($("#panel"+pub_id).data("cant-pregunta"));	
		$.ajax({
			url: "paginas/preguntas/fcn/f_pregunta.php",
			data: {metodo: "eliminarPregunta",id:id},
			type: "POST",
			dataType: "html",
			success:function(data){
				cantP--;
				cant--; 
				$("#" + id).remove(); 
					if(cant==0){
						$("#panel"+pub_id).addClass("hidden");
						$("p.toggleResponder:first").click();
					}else{
						$("#panel"+pub_id+" p.toggleResponder:first").click();						
					}
					 
				$("#cantP").text(cantP);
				$("#panel"+pub_id).data("cant-pregunta",cant);
				
				swal({
					title: "Eliminada", 
					text: "La pregunta ha sido eliminada.",
					timer: 2000, 
					showConfirmButton: true
				});			
			}
		});
		
	});


	$(".toggleResponder").click(function(e){
		e.preventDefault();
		var id=$(this).data("id");	
			if($("#responder" + id).is(":visible")){
			$.ajax({
				type: "POST",
				dataType: "html",	
				success:function(e){
					$("#responder" + id).css("display","none");
					$(".bor").addClass("borBD");
					$("#eti-p"+id).addClass("borBD");				
				}			
			});
			}else{
			$.ajax({
				type: "POST",
				dataType: "html",	
				success:function(e){
					$(".activo").css("display","none");
					$(".bor").addClass("borBD");
					$("#eti-p"+id).removeClass("borBD"); 
					$("#responder" + id).css("display","block"); 
					$("#txtRespuesta" + id).focus();
				}			
			});				
			}		
			 		
			
	});
	

	$(".togglePreguntar").click(function(e){
		e.preventDefault();
		var id=$(this).data("id");	
			if($("#" + id).is(":visible")){
			$.ajax({
				type: "POST",
				dataType: "html",	
				success:function(e){
					$("#" + id).css("display","none");
					$("#Preguntar"+id).text("Hacer otra Pregunta");
				}			
			});
			}else{
			$.ajax({
				type: "POST",
				dataType: "html",	
				success:function(e){
					$("#" + id).css("display","block");	
					$("#Preguntar"+id).text("Ocultar");
				}			
			});				
			}						
	});
	
	
	
	
	$("#Ventas_pregunta").click(function(e){
		e.preventDefault();
			var tipo=1;
			alert(1);
			$.ajax({
				url: "preguntas.php",
				data:{ tipo:tipo},
				type: "POST",
				dataType: "html",	
				success:function(data){
					alert(tipo);
				}			
			});			
	});
	
	$("#Compras_pregunta").click(function(e){
		e.preventDefault();
			var tipo=$(this).data("tipo");
			$.ajax({
				url: "preguntas.php",
				data:{ tipo:tipo},
				type: "POST",
				dataType: "html",	
				success:function(data){
					alert("Compras");
				}			
			});			
	});
	
	$('.respuesta').keyup(function(){	
		var id=$(this).data("id");
		var respuesta=$("#txtRespuesta" + id).val();
		if(($("#txtRespuesta"+id).val()).length>240){
			var value=$(this).val();
			$(this).val(value.substring(0, 240));
			$("#restante"+id).text("0");
			return false;
		}
		if($(this).val()!=""){
			var restante = 240 - $(this).val().length;
			$("#restante"+id).text(restante);
		}else{
			$("#restante"+id).text("240");
		}
	});
	
	$('.preguntas').keyup(function(){
		var id=$(this).data("id");
		var respuesta=$("#txtPregunta" + id).val();
		if(($("#txtPregunta"+id).val()).length>240){
			var value=$(this).val();
			$(this).val(value.substring(0, 240));
			$("#restante"+id).text("0");
			return false;
		}
		if($(this).val()!=""){
			if(!$("#txtPregunta"+id).hasClass("form-textarea-msj-act")){
				$("#txtPregunta"+id).removeClass("form-textarea-msj");
				$("#txtPregunta"+id).addClass("form-textarea-msj-act");
			}
			var restante = 240 - $(this).val().length;
			$("#restante"+id).text(restante);
		}else{
			$("#txtPregunta"+id).removeClass("form-textarea-msj-act");
			$("#txtPregunta"+id).addClass("form-textarea-msj");
			$("#restante"+id).text("240");
		}
	});
		
});