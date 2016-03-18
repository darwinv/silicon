// Plugin de editor HTML

$(document).ready(function(){
	var pagos="";
	$("#compras").css("display","block");
	$("#pagos-ven #titulo").text("Pagos");
//	switch($('body').data("tipo")){
//		case 1:
//			$("#uno1").addClass("active");
//			break;
//		case 2:
//			$("#uno2").addClass("active");
//			break;
//		case "":
			$("#dos3").addClass("active");
//			break;		
//	}
 	$(".pesta-compras").click(function(){
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
		$(".pesta-compras").removeClass("active");
		$(this).addClass("active");
	});
	
	
	$(document).on("click",".vinculoenvios",function(){
		var id=$(this).attr("id").substr(5);
		$("#envios-ven").modal('show');
		$.ajax({
			url : "paginas/compra/fcn/f_envios.php",
			data : {id:id},
			type : "POST",
			dataType : "html",
			success : function(data){
				$("#btn-agregar-guia").addClass("hidden");
				$("#btn-guardar2").addClass("hidden");
				$("#btn-guardar-guia").removeClass("hidden");
				$("#ajaxcontainer3").html(data);
				actual=id;
			}
		});
	});	
	$("#lista-pagos").on("click",".boton-status",function(){
		//fa fa-clock-o naranja-apdp
		//fa fa-thumbs-o-up verde-apdp
		//fa fa-remove rojo-apdp
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
			id=$("#lista-pagos").data("id");
			$.ajax({
				url:"paginas/venta/fcn/f_ventas.php",
				data:{metodo:"actualizarPagos",pagos:pagos,id:id},
				type:"POST",
				dataType:"html",
				success:function(data){
					loadingAjax(false);
					document.location.reload();
				}
			});
		}
	});	
	$("#btn-add-guia").click(function(){
		$("#frm-envios").slideDown();
		$("#btn-agregar-guia").addClass("hidden");
		$("#btn-guardar2").addClass("hidden");
		$("#btn-guardar-guia").removeClass("hidden");
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
				p_fecha:{validators:{
					notEmpty:{}}},
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
			form=$("#frm-reg-envios").serialize() + "&metodo=guardarEnvio&id=" + $("#lista-pagos").data("id");
			$.ajax({
				url : "paginas/venta/fcn/f_ventas.php",
				data : form,
				type : "POST",
				dataType : "html",
				success : function(data){
					console.log(data);
					var nuevaFila='<tr><td align="center">' + $("#p_fecha").val() + '</td><td align="center">' + $("#p_cantidad").val();
					nuevaFila+='</td><td align="center">' + $("#p_agencia option:selected").html() + '</td><td align="center">' + $("#p_numero").val() + '</td><td align="center">ver</td></tr>';					
					$("#p_cantidad").val("");
					$("#p_direccion").val("");
					$("#p_numero").val("");
					$("#p_fecha").val("");
					$("#p_monto").val("");
					$("#p_agencia").val("");
					$("#envios-ven").modal("hide");
					$("#frm-envios").slideUp();
					$("#tabla-envios").append(nuevaFila);
				}
			});

		});		
	});	
	$(document).on("click","#ver-preguntas",function(e){
		var pub=$("#lista-pagos").data("pub");
        redirect_ids = [["id_pub",pub]]; // Declaracion de array con los id y los nombres que se recibiran via POST en el destino
	    redirect("preguntas/ventas", redirect_ids);
	});	
	$(document).on("click",".vinculopagos",function(){
		var id=$(this).attr("id").substr(4);
		var pagina="paginas/venta/fcn/f_pagos2.php";
		$("#btn-guardar").addClass("hidden");
		var elDiv=$("#ajaxcontainer");
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
		
		$("#frm-informar-pago").formValidation({
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
				p_forma_pago:{validators:{				
					notEmpty:{}}},
				p_banco:{validators:{				
					notEmpty:{}}},
				p_monto:{validators:{				
					notEmpty:{}}},
				p_referencia:{validators:{				
					notEmpty:{}}}
			}
		}).on('success.form.fv',function(e){
			e.preventDefault();
			var form=$("#frm-informar-pago").serialize() + "&metodo=guardarPago&id=" + id;
			$.ajax({
				url:"paginas/compra/fcn/f_compras.php",
				data:form,
				type:"POST",
				dataType:"html",
				success:function(data){				
					console.log(data);
					swal({
						title:"Exito",
						text: "Se informo el pago sin problemas",
						imageUrl: "galeria/img/logos/bill-ok.png",
						showConfirmButton: true						
					});
					$("#informar-pago").modal('hide');
					$("#p_monto").val("");
					$("#p_referencia").val("");
				}
			});
		});
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