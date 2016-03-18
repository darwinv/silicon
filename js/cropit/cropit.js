/**
 * JavaScript: Cropit
 */

$(document).ready(function(){
		
	$('.image-editor').cropit({
		exportZoom: 1,
		imageBackground: true,
		imageBackgroundBorderWidth: 25,
		smallImage: 'allow',
		maxZoom: 2,
		freeMove: true
	});
	
	
	$('#save-foto').click(function() {
		var imageData = $('.image-editor').cropit('export');
		if($("#save-foto").data("nro") === undefined){
			var count = 1;
			$('.foto').each(function(i, obj) {
				if($(this).children("img").attr("id") === undefined){
					$(this).css("background","transparent");
					$(this).children("img").attr("src",imageData);
					$(this).children("img").attr("id",count);
					$(this).children("i").removeClass('hidden');
					$("#arrastrar").addClass("hidden");
					return false;
				}
				count++;
			});
		}else{
			$("#"+$(this).data("nro")).attr("src",imageData);
			$("#"+$(this).data("nro")).parent().css("background","transparent");
			$("#"+$(this).data("nro")).next().removeClass('hidden');
			$(this).removeData("nro");
		}
	});
});