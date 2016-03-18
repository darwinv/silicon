
//fb
var scopes='email,user_location,publish_actions,user_photos,manage_pages,publish_pages',doing_fb=false,doing_fb_log=false;

window.fbAsyncInit = function() {
	FB.init({
	appId      : '1525400224445821',
	cookie     : true,
	xfbml      : false,
	version    : 'v2.5'});
};
				
(function(d, s, id){
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement(s); js.i = id;
	js.src = "//connect.facebook.net/en_US/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
$(document).ready(function(){

	var twac=false,twat=false,twlc=false,twlt=false;
	
	rg_twa_cb = function(d){
		clearInterval(twat);
		console.log(d.e);
		switch(d.e){
		case 0:
			//d.n = name
			//d.sn = screen_name
			//d.i = image
			//d.d = is this the default image?
			//d.l = location, puede ser vacia
			console.log(d.n);
			console.log(d.sn);
			console.log(d.i);
			console.log(d.l);
			$("#usr-reg").modal('show');
			$("#insc-red").hide();
			var tipo=$("#insc-red").data("tipo");
			$("#usr-reg").modal({
				  keyboard: false,
				  backdrop: "static"
			});
			if(tipo===undefined){
				tipo=$("#actualizar2").data("tipo");
			}
			$("section").hide();
			$("#usr-reg-skip").hide();
			$("#usr-reg-foto").hide();
			$("#usr-reg-submit").data("step",1);
			if (tipo=="1") {					
				$("#usr-reg-title").html($("section[data-type='p']").data("title"));
				$("#usr-reg-submit").data("type","p");
				$("section[data-type='p']").fadeIn();
				$("#type").val("p");
				$("#p_nombre").val(d.n);
				$("#p_direccion").val(d.l);
			} else {
				var name=d.fn + " " + d.ln;
				$("#usr-reg-title").html($("section[data-type='e']").data("title"));
				$("#usr-reg-submit").data("type","e");
				$("section[data-type='e']").fadeIn();
				$("#type").val("e");
				$("#e_razonsocial").val(d.n);
				$("#e_direccion").val(d.l);
			}
			if(!d.d){
				$("#foto-usuario").attr("src",d.i);
			}
			break;
			case 1:
				//cuenta pertenece a otro usuario
				alert("Error 1");
				break;
			case 2:
				//cuenta no dio los permisos requeridos
				alert("Error 2");
				break;
			case 3:
				//error al insertar cuenta en la base de datos
				alert("Error 3");
				break;
			case 4:
				//error del sdk
				alert("Error 4");
				break;
					
		}
	};
	
	
	function checkTwaC(){
		if(twac.closed){
			clearInterval(twat);
			//se cerro la venta,a mostrar alerta
		}
	}
				
	$('body').on('click','button#tw_reg_button',function(){
		var left = (screen.width/2)-(500/2),top = (screen.height/2)-(500/2);
		twac=window.open('//apreciodepana.com/fcn/f_manager/add_tw.php?state=0','','toolbar=no, location=no, directories=no, status=no, menubar=no, copyhistory=no, width=500, height=500, top='+top+', left='+left);
		twat=setInterval(checkTwaC,500);
	});

	
	lg_twa_cb = function(e){
		clearInterval(twlt);
		switch(e){
			case 0:
				location.reload(); 
				break;
			case 1:
				//cuenta no pertenece a nadie
				break;
			case 2:
				//cuenta no dio los permisos requeridos
				break;
			case 3:
				//error al insertar cuenta en la base de datos
				break;
			case 4:
				//error del sdk
				break;
					
		}
	};
	
	
	function checkTwlC(){
		if(twlc.closed){
			clearInterval(twlt);
			//se cerro la venta,a mostrar alerta
		}
	}
				
	$('body').on('click','button#tw_log_button',function(){
		var left = (screen.width/2)-(500/2),top = (screen.height/2)-(500/2);
		twlc=window.open('//apreciodepana.com/fcn/f_manager/add_tw.php?state=1','','toolbar=no, location=no, directories=no, status=no, menubar=no, copyhistory=no, width=500, height=500, top='+top+', left='+left);
		twlt=setInterval(checkTwlC,500);
		return false;
	});


	$('body').on('click','button#fb_log_button',function(){
		if(doing_fb_log)
			return false;
		else
			doing_fb_log=true;
	
		FB.login(function(response){
			if (response.status === 'connected') {
				$.ajax({
					url: "fcn/f_manager/fbjscb.php",
					method: "GET",
					data:{
						state:1,
					},
					cache:false,
					dataType: "json"
				}).done(function(d){
					doing_fb_log=false;
					switch(d.e){
						case 0:
							location.reload();
							break;
						case 1:
							//cuenta no pertenece a nadie
							break;
						case 2:
							//cuenta no dio los permisos requeridos
							break;
						case 3:
							//error al insertar cuenta en la base de datos
							break;
						case 4:
							//error del sdk
							break;
					}
				}).fail(function(a,b,d){
					doing_fb_log=false;
					//mostrar mensaje de error de conexi&oacute;n correspondiente
				});
			} else if (response.status === 'not_authorized') {
				//mostrar error de autorizaci&oacute;n
				doing_fb_log=false;
			} else {
				//mostrar error de conexi&oacute;n a fb
				doing_fb_log=false;
			}
		},{auth_type:'reauthenticate',scope:scopes});
		return false;
	});	
	
	$('body').on('click','button#fb_reg_button',function(){
		if(doing_fb)
			return false;
		else
			doing_fb=true;
	
		FB.login(function(response){
			if (response.status === 'connected') {
				$.ajax({
					url: "fcn/f_manager/fbjscb.php",
					method: "GET",
					data:{
						state:0,
					},
					cache:false,
					dataType: "json"
				}).done(function(d){
					doing_fb=false;
					switch(d.e){
						case 0:
							//d.fn = first_name
							//d.ln = last_name
							//d.l = location, puede ser vacio
							//d.em = email, puede regresar vacio
							//d.p = foto de perfil, existe la posibilidad de que sea una silueta de perfil nuevo
							//d.ps = booleano, es la foto una silueta?
							$("#usr-reg").modal('show');
							$("#insc-red").hide();
							var tipo=$("#insc-red").data("tipo");
							$("#usr-reg").modal({
								keyboard: false,
								backdrop: "static"
							});
							if(tipo===undefined){
								tipo=$("#actualizar2").data("tipo");
							}
							$("section").hide();
							$("#usr-reg-skip").hide();
							$("#usr-reg-foto").hide();
							$("#usr-reg-submit").data("step",1);
							if (tipo=="1") {					
								$("#usr-reg-title").html($("section[data-type='p']").data("title"));
								$("#usr-reg-submit").data("type","p");
								$("section[data-type='p']").fadeIn();
								$("#type").val("p");
								$("#p_nombre").val(d.fn);
								$("#p_apellido").val(d.ln);
								$("#p_direccion").val(d.l);
								$("#email").val(d.em);
							} else {
								var name=d.fn + " " + d.ln;
								$("#usr-reg-title").html($("section[data-type='e']").data("title"));
								$("#usr-reg-submit").data("type","e");
								$("section[data-type='e']").fadeIn();
								$("#type").val("e");
								$("#e_razonsocial").val(name);
								$("#e_direccion").val(d.l);
								$("#email").val(d.em);
							}
							if(!d.ps){
								$("#foto-usuario").attr("src",d.i);
							}

							break;
						case 1:
							//cuenta pertenece a otro usuario
							break;
						case 2:
							//cuenta no dio los permisos requeridos
							break;
						case 3:
							//error al insertar cuenta en la base de datos
							break;
						case 4:
							//error del sdk
							break;
					}
				}).fail(function(a,b,d){
					doing_fb=false;
					//mostrar mensaje de error de conexi&oacute;n correspondiente
				});
			} else if (response.status === 'not_authorized') {
				//mostrar error de autorizaci&oacute;n
				doing_fb=false;
			} else {
				//mostrar error de conexi&oacute;n a fb
				doing_fb=false;
			}
		},{auth_type:'reauthenticate',scope:scopes});
		return false;
	});	
});