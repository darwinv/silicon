/**
 * @author CDODESARROLLO2
 
*/ 
$(document).ready(function(){
	$("#corazon").click(function(){
		if($(this).hasClass("iconos-fav")){
			$(this).removeClass("iconos-fav");
			$(this).addClass("iconos");
			var t=$("#spanFav").data("count")-1;
			$("#spanFav").data("count",t);
			var tipo=2;
		}else{
			$(this).removeClass("iconos");
			$(this).addClass("iconos-fav");
			var t=$("#spanFav").data("count")+1;
			$("#spanFav").data("count",t);
			var tipo=1;
		}
		/*
		if(t>0){
			$("#spanFav").text(t);
		}else{
			$("#spanFav").text("");
		}
		*/
		id=$(this).data("id");
		$.ajax({
			url:"paginas/detalle/fcn/f_detalle.php",
			data:{metodo:"actualizarFavoritos",tipo:tipo,id:id},
			type:"POST",
			dataType:"html",
			success: function(data){
				console.log(data);
			}
		});
	});
	$("#cmdLimpiar").click(function(){
		$("#txtPregunta").val("");
		$("#restante").text("240");
		$("#txtPregunta").focus();
	});
	$("#cmdPreguntar").click(function(e){
		e.preventDefault();
		if($(this).data("usuario")==""){
			$(".dropdown-toggle").dropdown('toggle');
			return false;
		}
		if($("#txtPregunta").val()!=""){
			var pregunta=$("#txtPregunta").val();
			var id=$(this).data("id");
			var id_poster = $(this).data("usuario");
			var usr_id= $(this).data("usr_id");
			$.ajax({
				url:"paginas/detalle/fcn/f_detalle.php",
				data:{metodo:"guardarPregunta",id:id,pregunta:pregunta,tipo:1,usr:usr_id},
				type:"POST",
				dataType:"html",
				success:function(data){
					$("#preguntas").html(data);
					$("#txtPregunta").val("");
					$("#txtPregunta").removeClass("form-textarea-msj2-act");
					$("#txtPregunta").addClass("form-textarea-msj2");	
					$("#txtPregunta").focus();
					$.ajax({
						url: "paginas/detalle/fcn/f_detalle.php",
						data: {metodo:"enviarPregunta",pub_id:id,pregunta:pregunta,id_poster:id_poster,usr_id:usr_id},
						type: "POST",
						dataType: "html",
						success:function(data){

						}
					});

				}
		
			});
		}
	});
//	$('#txtPregunta').keyup(function(){
	$(document).on('keyup','#txtPregunta',function(){
		if(($("#txtPregunta").val()).length>240){
			var value=$(this).val();
			$(this).val(value.substring(0, 240));
			$("#restante").text("0");
			return false;
		}
		if($(this).val()!=""){
			if(!$(this).hasClass("form-textarea-msj2-act")){
				$(this).removeClass("form-textarea-msj2");
				$(this).addClass("form-textarea-msj2-act");
			}
			var restante = 240 - $(this).val().length;
			$("#restante").text(restante);
		}else{
			$(this).removeClass("form-textarea-msj2-act");
			$(this).addClass("form-textarea-msj2");
			$("#restante").text("240");
		}
	});
	
});