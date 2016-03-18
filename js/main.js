$(function() {
	var Accordion = function(el, multiple) {
		this.el = el || {};
		this.multiple = multiple || false;

		// Variables privadas
		var links = this.el.find('.link');
		// Evento
		links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown);
	};

	Accordion.prototype.dropdown = function(e) {
		var $el = e.data.el;
			$this = $(this),
			$next = $this.next();

		$next.slideToggle();
		$this.parent().toggleClass('open');

		if (!e.data.multiple) {
			$el.find('.submenu').not($next).slideUp().parent().removeClass('open');
		}
	};	

	var accordion = new Accordion($('#accordion'), false);
	
	//############SCRIPT PARA RESTRICCIONES DE USUARIOS#############
	if ($('.show-menu-left').length){   //asegurar que este script efectivamente este mostrado o no//
		var id_rol=parseInt($('.show-menu-left').data("id_rol"));
		
		//#######USUARIO ROL 1#######
		if(id_rol==1){
			$(".resumen, .venta, .factura, .fact-pagar, .red, .configurar, .admin-usuarios, .compras-tienda").removeClass("hidden");
		}
		//#######USUARIO ROL 2#######
		else if(id_rol==2){
			$(".resumen, .venta, .factura, .fact-pagar, .red, .configurar, .compras-tienda").removeClass("hidden");
		}
		//#######USUARIO ROL 3#######
		else if(id_rol==3 || id_rol==0){
			$(".resumen, .compra,  .configurar").removeClass("hidden");
		}
				
    }
});
/*FUNCIONES*/
function SweetError(text){
	swal({
		title: "Error, intenta de nuevo", 
		text: "Codigo:"+  text,
		imageUrl: "galeria/img-site/logos/bill-error.png",
		showConfirmButton: true
		});
}
function loadingAjax(status){
	if(status){
		//$('<div class="modal-backdrop fade in cargador" style="display:none"></div>').appendTo(document.body);
		$(".modal-backdrop").css("display","");
	}else{
		$(".modal-backdrop").fadeOut("slow");
	}
}
function getQuerystringValue(sQueryName, bCaseSensitive) {
	/// <summary>Returns the value of a given querystring param name. If param is there more than once, the last version will be choosen. Example: getQuerystringValue('pageid'); If param name not in querystring null will be returned.</summary>
	/// <returns type="String|null" />
	/// <param name="sQueryName" type="String">The param name to look for in querystring</param>
	/// <param name="bCaseSensitive" type="Boolean">Should the param name match be case sensitive? [false]</param>
	
	var QueryValue;
	var bCaseSensitive = (arguments.length==2) ? arguments[1] : false;
	var sLoc = document.location.search+'';
	var i = (bCaseSensitive) ? sLoc.lastIndexOf(sQueryName) : sLoc.toLowerCase().lastIndexOf(sQueryName.toLowerCase());
	if (i>-1) {
		var selectedParam = sLoc.substr(i, sLoc.length-i).split('&');
		if (selectedParam.length>0) {
			QueryValue = unescape(selectedParam[0].split('=')[1]);
		}
	}
	return QueryValue;
}