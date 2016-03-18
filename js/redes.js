$(document).ready(function(){
	$("#btnCalendario").click(function(){
		if($("#calendario").css("display")=="block"){
			$("#calendario").css("display","none");
		}else{
			$("#calendario").css("display","block");
		}
	});
	$("#btnImagenes").click(function(){
		if($("#imagenes").css("display")=="block"){
			$("#imagenes").css("display","none");
		}else{
			$("#imagenes").css("display","block");
		}
	});
	$("#btnAgregar").click(function(){
		$("#titulo").text("Crea tu mensaje ");
		$("#calendario").css("display","none");
		$("#imagenes").css("display","none");
		$("#btn-ok").text("Guardar");
	});
	$(".modificar").click(function(){
		$("#titulo").text("Edita tu mensaje");
		$("#calendario").css("display","none");
		$("#imagenes").css("display","none");
		$("#btn-ok").text("Modificar");		
	});
	$(".eliminar").click(function(){
		alert("C&oacute;digo de eliminar");
	});
	$("#btnLimpiar").click(function(){
		$("#descripcion").val("");
		/*if(!$("#descripcion").hasClass("form-textarea-msj")){
			$("#descripcion").addClass("form-textarea-msj");
		}*/
		$("#descripcion").focus();
	});	
	
	$("#dia").click(function(){
		   
   	$("#dias").css({ //opacity: .9,
           //filter: "Alpha(Opacity=50)",
           backgroundColor: "RGBA(54,54,54,0.5)"
      });
	});
	
	$(".redes-dias").click(function(e){
		e.preventDefault();
		var dia=$(this).attr("data-dia"),
		act=$(this).attr("data-act");
		if(act==1){
			$("#i"+dia).hide("swing");
			$("#"+dia).attr("data-act","0");
		}else{
			$("#i"+dia).show("swing");
			$("#"+dia).attr("data-act","1");
		}
		
	});	
		
	$("#descripcion").keyup(function(){
		var valor=$(this).val();
		if(valor!=""){
			var restante=140 - valor.length;
			$("#restante").text(restante);
			/*
			if($(this).hasClass("form-textarea-msj")){
				$(this).removeClass("form-textarea-msj");
			}
			*/
		}else{
			$("#restante").text("140");
			/*$(this).addClass("form-textarea-msj");*/
		}
	});
	
	$(".redsocial").click(function() {
			var rs = $(this).data("rs"),
			t = parseInt($("#"+rs).attr("data-"+rs));
			if(t==0){
				$("#"+rs).attr("data-"+rs,"1");
				$("#f-"+rs).removeClass('opacity');
				$("#"+rs).show("swing");
			}else{
				$("#"+rs).attr("data-"+rs,"0");
				$("#f-"+rs).addClass('opacity');
				$("#"+rs).hide("swing");
			}
		});
		
	$(".compartir").click(function() {
			var rs = $(this).data("rs"),
			t = parseInt($("#c"+rs).attr("data-"+rs));
			if(t==0){
				$("#c"+rs).attr("data-"+rs,"1");
				$("#c-"+rs).removeClass('opacity');
				$("#c"+rs).show("swing");
			}else{
				$("#c"+rs).attr("data-"+rs,"0");
				$("#c-"+rs).addClass('opacity');
				$("#c"+rs).hide("swing");
			}
	});			
	
	
	/********************INICIO DEL CROPIT *****************/
	$(document).on("click", ".foto", function(e) {
		
		if($(e.target).is('i')){
			var index = $(this);
			$(this).children("img").removeAttr('src');
			$(this).children("img").removeAttr("id");
            $(this).children("i").addClass('hidden');
            $(this).css("background","");
			$('.foto').each(function(i, obj){
				if($(this).children("img").attr("src") === undefined && $(this).next().children("img").attr("src") !== undefined){
					$(this).children("img").attr("src",$(this).next().children("img").attr("src"));
					$(this).css("background","transparent");
					$(this).children("img").attr("id",i+1);
					$(this).children("i").removeClass('hidden');
					$(this).next().children("img").removeAttr("src");
					$(this).next().children("img").removeAttr("id");
		            $(this).next().children("i").addClass('hidden');
		            $(this).next().css("background","");
				}
			});
			$("#arrastrar").removeClass("hidden");
			$("#imagen").addClass("hidden");
        }else{
        	var numero = $(this).children("img").attr("id");
			if(numero !== undefined){
				$("#save-foto").data("nro",numero);
			}
			$('.cropit-image-input').click();
        }		
	});
	$(document).on("click",".foto2",function(){
		$('.cropit-image-input').click();
	});
	/*
	 * Captura el cambio del input
	 */
	$(document).on("change", ".cropit-image-input", function() {
		var file = this.files[0];
		var imageType = "image";
		if (file.type.substring(0,5) == imageType) {
			var reader = new FileReader();
			reader.onload = function(e) {
				// Create a new image.
				var img = new Image();
				// Set the img src property using the data URL.
				img.src = reader.result;
				// Add the image to the page.
				$(".cropit-image-input").val("");
				$('#cropper').modal("show");
				$('#usr-reg-title').html("Edita la foto de tu producto");
			};
			reader.readAsDataURL(file);
			$("#arrastrar").addClass("hidden");
			$("#imagen").removeClass("hidden");
		} else {
			SweetError("Archivo no soportado.");
		}		
	});
	/*
	 * Revalidar el campo txtPrecio para que funcione con el validador.
	 */
	$("#cambiar-foto").click(function(){
		$("#cropper").modal("hide");
		$('.cropit-image-input').click();
	});	
	/********************FIN DEL CROPIT ********************/
});

$(document).ready(function() {



var input1 = $('#fromm').pickadate({editable: true, container: '#date-picker',  monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
  weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mier', 'Jue', 'Vie', 'Sab'],
  today: 'Hoy',
  clear: 'Limpiar',
  close: 'Cerrar',
    format: 'yyyy-mm-dd',
  formatSubmit: 'y-m-d'});
var picker1 = input1.pickadate('picker');
picker1.set('min', true);

var input2 = $('#t2').pickadate({editable: true, container: '#date-picker',  monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
  weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mier', 'Jue', 'Vie', 'Sab'],
  today: 'Hoy',
  clear: 'Limpiar',
  close: 'Cerrar',
    format: 'yyyy-mm-dd',
  formatSubmit: 'y-m-d'});
var picker2 = input2.pickadate('picker');
//picker2.set('min', picker1.get('select'));
picker1.on('set', function(event){
  if ( event.select ) {
    picker2.set('min', picker1.get('select'));
  }
});
picker2.on('set', function(event){
  if ( event.select ) {
    picker1.set('max', picker2.get('select'));
  }
});

var input3 = $('#t3').pickatime({
	editable: true,
	clear: "Limpiar"
});
var picker3 = input3.pickatime('picker');

var input4 = $('#t4').pickadate({ disabled: 'picker__day--disabled', editable: true, container: '#date-picker'});
var picker4 = input4.pickadate('picker');

//Fecha desde
$('#fromm').off('click focus');

$('#from').on('click', function(e) {
	$("#fromm").css("display","block");
  if (picker1.get('open')) { 
    picker1.close();
  } else {
    picker1.open();
  }
  
  e.stopPropagation();    
});
//fecha hasta
$('#t2').off('click focus');

$('#2').on('click', function(e) {
$("#t2").css("display","block");
  if (picker2.get('open')) { 
    picker2.close();
  } else {
    picker2.open();
  }
  
  e.stopPropagation();    
});
//Hora
$('#t3').off('click focus');

$('#3').on('click', function(e) {
	$("#t3").css("display","block");
  if (picker3.get('open')) { 
    picker3.close();
  } else {
    picker3.open();
  }
  
  e.stopPropagation();    
});
//Dia
/*$('#t4').off('click focus');

$('#4').on('click', function(e) {
  if (picker4.get('open')) { 
    picker4.close();
  } else {
    picker4.open();
  }
  
  e.stopPropagation();    
});*/

$('#4').on('click', function(e) {
	$("#dias").css("display","block");
});

$(document).on("click",".pesta",function(){
	if($(this).attr("id")=="irActivas"){
		$("#irPausadas").removeClass("active");
		$(this).addClass("active");
	}else{
		$("#irActivas").removeClass("active");
		$(this).addClass("active");		
	}
});
});
