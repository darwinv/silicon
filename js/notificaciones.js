$(document).ready(function() {
	function CargarNotificaciones(pagina){
		if ($('#ver-mas-footer').is(':visible')){
			$.ajax({
				url:"paginas/notificaciones/fcn/f_notificaciones.php",
				data:{method:'get_Notificaciones',pagina:pagina},
				type:"POST",
				dataType:"json",
				success:function(data){  
				    if (data.notificaciones != "") {
					     $(".notificaciones:last").after(data.notificaciones);
					     pagina++;
					     $('#ver-mas-footer').data("pagina",pagina);
				    }else{
				    	$('#ver-mas-footer').hide();
				    	$('.div-footer-container').show();				    	
				    }
			    }
		   });
	  	}
	   
  	}
  	$(window).scroll(function(){
	  if(($(window).scrollTop() + $(window).height() == $(document).height()) || ($(window).scrollTop() == $(document).height() - $(window).height())) {
   	 	var pagina=$('#ver-mas-footer').data("pagina");
   	 	CargarNotificaciones(pagina);
	 }					
	});
	
	
	$(".ver-mas-footer").click(function(e){
		var pagina=$(this).data("pagina");
   	 	CargarNotificaciones(pagina);
	});
	
  //INICIAMOS LA CARGA DE LAS NOTIFICACIONES
  	CargarNotificaciones(1);
  	$('.div-footer-container').hide();	
});