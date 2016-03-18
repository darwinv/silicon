$(document).ready(function(){
	$('#txtBuscar').val($("#principal").data("palabra"));
	$('#txtBuscar').select();
	$(document).on("change","#filtro",function(e){
		if($("#ubicacion").data("estado")!=undefined){
			var estado=$("#ubicacion").data("estado");
		}else{
			var estado="";
		}
		var palabra=$("#principal").data("palabra");
		var orden=$(this).val();
		loadingAjax(true);
		$.ajax({
			url:"paginas/listadotiendas/fcn/f_listado.php",
			data:{metodo:"ordenar",orden:orden,estado:estado,palabra:palabra},
			type:"POST",
			dataType:"html",
			success:function(data){
				$("#ajaxContainer").html(data);
				$(".pagination li").removeClass("active");
				$(".pagination li").first().addClass("active");
				loadingAjax(false);
				$("#principal #paginacion").data("paginaactual",1);
				$("#paginacion #anterior1").addClass("hidden");
				$("#paginacion #anterior2").addClass("hidden");
				$("#paginacion #siguiente1").removeClass("hidden");
				$('#paginacion').find('[data-pagina=1]').parent().addClass("active");			
			}
		});
	});
	$(document).on("click",".navegador",function(e){
		e.preventDefault();
		var pagina=$("#paginacion").data("paginaactual");
		switch($(this).data("funcion")){
			case "anterior1":
				var actual=pagina - 1;
				pagina--;			
				paginar(pagina,actual);
//				$("#paginacion #siguiente1").removeClass("hidden");
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
				paginar(pagina,actual);
				$("#paginacion #siguiente2").removeClass("hidden");			
				break;
			case "siguiente1":
				var actual=pagina + 1;
				pagina++;			
				paginar(pagina,actual);
//				$("#paginacion #anterior1").removeClass("hidden");
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
				paginar(pagina,actual);
				$("#paginacion #anterior2").removeClass("hidden");
				break;
		}
	});
	$("#principal").on("click",".imagen",function(){
		window.open("perfil.php?id=" + $(this).data("id"),"_self");
	});
	/********************FUNCIONES REALIZADAS PARA OPTIMIZAR EL LISTADO**************/
	function paginar(pagina,actual){
		var total=$("#paginacion").data("total");
		var palabra=$("#principal").data("palabra");
		var orden=$("#filtro").val();
		if($("#ubicacion").data("estado")!=undefined){
			var estado=$("#ubicacion").data("estado");
		}else{
			var estado="";
		}
		loadingAjax(true);
		$.ajax({
			url:"paginas/listadotiendas/fcn/f_listado.php",
			data:{metodo:"buscar",pagina:pagina,total:total,palabra:palabra,estado:estado,orden:orden},
			type:"POST",
			dataType:"html",
			success:function(data){
				$("#paginacion li").removeClass("active");
				$('#paginacion').find('[data-pagina=' + pagina + ']').parent().addClass("active");
				//$('#paginacion data-pagina=2').parent().addClass("active");
				$("#ajaxContainer").html(data);
				$("#inicio").text(((pagina-1)*25)+1);
				if(total<pagina*25){		
					$("#final").text(total + " de ");
				}else{
					$("#final").text(pagina*25 + " de ");
				}
				$('html,body').animate({
    				scrollTop: 0
				}, 200);
				if(pagina % 10 == 1){
					$("#paginacion #anterior1").addClass("hidden");
				}else{
					$("#paginacion #anterior1").removeClass("hidden");
				}			
				$("#principal #paginacion").data("paginaactual",pagina);
				if(pagina*25>=total || pagina % 10==0){
					$("#paginacion #siguiente1").addClass("hidden");
				}else{
					$("#paginacion #siguiente1").removeClass("hidden");
				}
				loadingAjax(false);
			}
		});
	}
	$(document).on("click",".botonPagina",function(e){
		e.preventDefault();
		var pagina=$(this).data("pagina");
		var actual=$(this);
		paginar(pagina,actual);
	});
	$(document).on("click",".filtroest",function(e){
		e.preventDefault();
		var id=$(this).data("id");
		var palabra=$("#principal").data("palabra");
		if($("#categoria").data("categoria")!=undefined){
			var categoria=$("#categoria").data("categoria");
		}else{
			var categoria="";
		}
		if($("#condicion").data("condicion")!=undefined){
			var condicion=$("#condicion").data("condicion");
		}else{
			var condicion="";
		}
		loadingAjax(true);
		$.ajax({
			url:"paginas/listadotiendas/fcn/f_listado.php",
			data:{metodo:"filtrarEst",id:id,palabra:palabra,categoria:categoria,condicion:condicion},
			type:"POST",
			dataType:"html",
			success:function(data){
				$("#principal").html(data);
				$('html,body').animate({
    				scrollTop: 0
				}, 200);				
				loadingAjax(false);
			}
		});
	});
});