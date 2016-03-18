<?php require 'config/core.php';
if(!isset($_GET["tipo"])){
	header ( "Location: index.php" );
}
switch($_GET["tipo"]){
	case 1:
		$display1="";
		$display2="hidden";
		$display3="hidden";
		break;
	case 2:
		$display1="hidden";
		$display2="";
		$display3="hidden";
		break;
	case 3:
		$display1="hidden";
		$display2="hidden";
		$display3="";
		break;		
}
?>
<!DOCTYPE html>
<html lang="es">
<link rel="stylesheet" href="js/cropit/cropit.css">
<?php include "fcn/incluir-css-js.php";?>
<body>

<?php
 include "clases/usuarios.php";
 session_start();
 $usuario = new usuario($_SESSION['id']);
 if($u=$usuario->tieneTwitter()){
	$tiene_twitter = "{n:'".$u['name']."',p:'".str_replace("_normal","",$u['img'])."',i:".$u['id']."}";
 }else{
	$tiene_twitter = "false";
 }
 
 if($u=$usuario->tieneFacebook()){
	$tiene_facebook = "{n:'".$u['first_name']." ".$u['last_name']."',p:'".$u['img']."',i:".$u['id']."}";
 }else{
	$tiene_facebook = "false";
 }
 
 if($u=$usuario->tieneFanpage()){
	$tiene_fanpage = "{n:'".$u['name']."',p:'".$u['img']."',i:".$u['id']."}";
 }else{
	$tiene_fanpage = "false";
 }
 ?>
	<script type="text/javascript" >
		var manager_tiene_tw = <?php echo $tiene_twitter;?>, 
		manager_tiene_fb = <?php echo $tiene_facebook;?>,
		manager_tiene_fbp = <?php echo $tiene_fanpage;?>;
		
		function updateTwButton(){
			if(manager_tiene_tw){
				$('.ctw_manager').show();
				$('#vin_tw_red_kill').show();
				$('#vin_tw_red_img').attr('src',manager_tiene_tw.p);
				$('#c-tw').attr('src',manager_tiene_tw.p);
				$('#f-tw').attr('src',manager_tiene_tw.p);
				$('#vin_tw_red_button').text(manager_tiene_tw.n);
				$('#vin_tw_red_button').attr('href','#');
				$('#vin_tw_red_kill').attr('pid',manager_tiene_tw.i);
			}else{
				$('.ctw_manager').hide();
				$('#vin_tw_red_kill').hide();
				$('#vin_tw_red_img').attr('src',"prueba");
				$('#c-tw').attr('src',"galeria/img-site/logos/silueta-bill.png");
				$('#f-tw').attr('src',"galeria/img-site/logos/silueta-bill.png");
				$('#vin_tw_red_button').text("Vincula tu cuenta de Twitter");
				$('#vin_tw_red_button').attr('href','http://apreciodepana.com/fcn/f_manager/add_tw_alt.php');
				$('#vin_tw_red_kill').attr('pid',0);
			}
		}
		
		function updateFbButton(){
			if(manager_tiene_fb){
				$('.cfb_manager').show();
				$('#vin_fb_red_kill').show();
				$('#vin_fb_red_img').attr('src',manager_tiene_fb.p);
				$('#c-fb').attr('src',manager_tiene_fb.p);
				$('#f-fb').attr('src',manager_tiene_fb.p);
				$('#vin_fb_red_button').attr('disabled',true);
				$('#vin_fb_red_button').text(manager_tiene_fb.n);
				$('#vin_fb_red_kill').attr('pid',manager_tiene_fb.i);
			}else{
				$('.cfb_manager').hide();
				$('#vin_fb_red_kill').hide();
				$('#vin_fb_red_img').attr('src',"prueba");
				$('#c-fb').attr('src',"galeria/img-site/logos/silueta-bill.png");
				$('#f-fb').attr('src',"galeria/img-site/logos/silueta-bill.png");
				$('#vin_fb_red_button').text("Vincula tu cuenta de Facebook");
				$('#vin_fb_red_button').attr('disabled',false);
				$('#vin_fb_red_kill').attr('pid',0);
			}
		}
		
		function updateFbpButton(){
			if(manager_tiene_fbp){
				$('.cfp_manager').show();
				$('#vin_fbp_red_kill').show();
				$('#vin_fbp_red_img').attr('src',manager_tiene_fbp.p);
				$('#c-fp').attr('src',manager_tiene_fbp.p);
				$('#f-fp').attr('src',manager_tiene_fbp.p);
				$('#vin_fbp_red_button').attr('disabled',true);
				$('#vin_fbp_red_button').text(manager_tiene_fbp.n);
				$('#vin_fbp_red_kill').attr('pid',manager_tiene_fbp.i);
			}else{
				$('.cfp_manager').hide();
				$('#vin_fbp_red_kill').hide();
				$('#vin_fbp_red_img').attr('src',"prueba");
				$('#c-fp').attr('src',"galeria/img-site/logos/silueta-bill.png");
				$('#f-fp').attr('src',"galeria/img-site/logos/silueta-bill.png");
				$('#vin_fbp_red_button').text("Vincula tu fan page");
				$('#vin_fbp_red_button').attr('disabled',false);
				$('#vin_fbp_red_kill').attr('pid',0);
			}
		}
		
		function checkAllDays(a,val){
			var b=a.split(","),bl=b.length,i=0;
			for(;i<bl;i++){
				while(parseInt($('#'+b[i]).attr('data-act')) != val)
					$('#'+b[i]).click();
			}
		
		}
		
		
		
		/*var twapc=false,twapt=false;
		
		ap_twa_cb = function(d){
			clearInterval(twapt);
			switch(d.e){
				case 0:
					manager_tiene_tw = {
						i : d.d,
						n : d.n,
						p : d.i
					};
					updateTwButton();
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
		
		function checkTwapC(){
			if(twapt.closed){
				clearInterval(twapt);
			}
		}
		$('body').on('click','button#vin_tw_red_button',function(){
			var left = (screen.width/2)-(500/2),top = (screen.height/2)-(500/2);
			twapc=window.open('//apreciodepana.com/fcn/f_manager/add_tw.php?state=2','','toolbar=no, location=no, directories=no, status=no, menubar=no, copyhistory=no, width=500, height=500, top='+top+', left='+left);
			twapt=setInterval(checkTwapC,500);
			return false;
		});*/
		
		function doThing(t){
			var str=[];
			str[0]="<li id='manager_pub_un_"+t.id+"' sn_len='"+t.len+"' sn_des='"+t.des+"' sn_tw='"+t.tw+"' sn_id='"+t.id+"' sn_fb='"+t.fb+"' sn_gp='"+t.gp+"' sn_fbp='"+t.fbp+"' class='pub_item'><div class='col-xs-12 col-sm-12 col-md-1 col-lg-1  '><div class='marco-foto-publicaciones  point ' style='width: 65px; height: 65px;' >";
			str[1]="<img src='"+t.picture+"'  class='img img-responsive center-block img-apdp'></div></div><div class='col-xs-12 col-sm-12 col-md-7 col-lg-6  t14  '>";
			str[2]="<span class='detalle.php'> <a href='#'>"+t.titulo+"</a> </span><br>";
			str[3]="<span class='red t14'>"+t.monto+"</span><br>";
			str[4]="<span class='grisC t14'>"+t.condicion+"</span></div>";
			str[5]="<div class='col-xs-12 col-sm-12 col-md-4 col-lg-5  text-right '><button type='button' class='btn2 btn-default boton hidden' data-toggle='modal' data-target='#info-publicacion'  ><i class='fa fa-plus-square'></i> Agregar Descripci&oacute;n</button><button type='button' class='btn2 btn-default boton manager_edit_publication_thing' data-toggle='modal' data-target='#red-social'  ><i class='fa fa-share-alt' ></i> Redes Sociales</button> <button id='' type='button' class='btn2 btn-warning hidden' data-toggle='modal'>Compartir</button> <button type='button' class='btn2 btn-default dropdown-toggle  ' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' ><span class='glyphicon glyphicon-cog '></span><span class='caret'></span></button><ul  class='  dropdown-menu pull-right'><li><a class='pausar'  id='' href='' data-toggle='modal'>Dejar de compartir</a></li></ul></div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10'><center><hr class=' center-block'></center></div></li>";
			return str.join('');
		}
		
		function doThingM(t){
			var str=[];
			str[0]="<li id='manager_ms_un_"+t.i+"' m='"+t.m+"' ts_en='"+t.ts_en+"' te_en='"+t.te_en+"' h='"+t.h+"' d='"+t.d+"'sn_tw='"+t.tw+"' sn_fb='"+t.fb+"' sn_gp='"+t.gp+"' sn_fbp='"+t.fbp+"' pp='"+t.t_p+"' class='pub_item'><div class='col-xs-12 col-sm-12 col-md-1 col-lg-1  '><div class='marco-foto-publicaciones  point ' style='width: 65px; height: 65px;' >";
			str[1]="<img src='"+t.t_p+"'  class='img img-responsive center-block img-apdp'></div></div><div class='col-xs-12 col-sm-12 col-md-7 col-lg-6  t14  '>";
			str[2]="<div class='marL20'>"+t.m+"</div><div class='marL20'><a href='#' data-toggle='modal' data-target='#add-msj' manager_mes_id='"+t.i+"'  class='modificar'>Editar <i class='fa fa-pencil marT5 marL5 '></i></a></div></div>";
			str[3]="<div class='col-xs-12 col-sm-12 col-md-3 col-lg-2  text-left '><div style='background:#F8F8F8' class='pad10 t10 grisC' >Desde: <span class='grisO'>";
			str[4]=t.ts_es+" </span><br>Hasta:<span class='grisO'> ";
			str[5]=t.te_es+" </span></div></div><div class='col-xs-12 col-sm-12 col-md-1 col-lg-1  text-center '><br>";
			str[6]="<a class='del_dis_message' manager_mes_id='"+t.i+"' 'href='#' data-target='#msj-eliminar' data-toggle='modal'><i class='fa fa-remove red t16'></i>	</a></div><div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 marB10 marT10'><center><hr class=' center-block'></center></div>";
			return str.join('');
		}
		
		function getPublications(t){
			$("ul#active_publications").html("");
			$.ajax({
				url: "fcn/f_manager/get_user_publications.php?type="+t,
				method: "GET",
				cache: false,
				dataType: "json"
			}).done(function(d){
				switch(d.e){
					case 0:
						var sn=d.sn,snl=sn.length,snb=[],nsnb=[],i=0,j=0,item;
						if(snl>0){
							for(;i<snl;i++){
								item=sn[i];
								snb[j++]=doThing(item);
							}
							$("ul#active_publications").html(snb.join(''));
						}
						break;
					case 1:
						break;
				}
			}).fail(function(a,b,d){
				//fallo
			});	
		}
		
		function getMessages(){
			$.ajax({
				url: "fcn/f_manager/get_user_messages.php",
				method: "GET",
				cache: false,
				dataType: "json"
			}).done(function(d){
				addin_fbp=false;
				switch(d.e){
					case 0:
						var sn=d.sn,snl=sn.length,snb=[],i=0,j=0,item;
						if(snl>0){
							for(;i<snl;i++){
								item=sn[i];
								snb[j++]=doThingM(item);
							}
							$("ul#messages_ns").html(snb.join(''));
						}
						break;
					case 1:
						break;
				}
			}).fail(function(a,b,d){
				//fallo
			});	
		
		}
		
		function getDays(){
			var days=[],i=0;
			$('.redes-dias').each(function() {
				if(parseInt($(this).attr('data-act'))==1)
					days[i++]=$(this).attr('data-dia');
			});
			return days.join(",");
		
		}
		
		
		$(document).ready(function(){
			updateTwButton();
			updateFbButton();
			updateFbpButton();
			var pubtype=1;
			getPublications(1);
			getMessages();
			
			
			$('body').on('click','#irActivas',function(){
				if(pubtype!=1){
					pubtype=1;
					getPublications(pubtype);}
			});
			
			$('body').on('click','#irPausadas',function(){
				if(pubtype!=0){
					pubtype=0;
					getPublications(pubtype);}
			});
			
			
			var killing_sn=false;
			var max_chars=0,pub_tw=0,pub_fb=0,pub_fbp=0,pub_gp=0,pub_id=0,pub_len=0,pub_des="",editing_aut=false,
			mes_tw=0,mes_max_chars=0,mes_fb=0,mes_fbp=0,mes_gp=0,mes_id=0,addin_ms=false,edit=false;
			
			l_regex=/\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'".,<>?«»“”‘’]))/gi,
			reCountChars = function(counter,chars,file,start){
				var matches;
				/*if(file){
					if(myDropzone.getAcceptedFiles().length>0){
					start=start-23;}
				}*/
				if((matches=chars.match(l_regex))!=null){
					start=start-(matches.length*23);
					chars=chars.replace(l_regex,'');
				}
				start=start-(chars.length);
				$(counter).text(start);
				if(start>=20)
					$(counter).css('color','#000');
				if(start>=0 && start<20)
					$(counter).css('color','#ffc107');
				else if(start<0)
					$(counter).css('color','#f44336');
				return start;
			}
			
			$('body').on('click','button#del_mes_button_manager',function(){
				$.ajax({
					url: "fcn/f_manager/kill_message.php",
					method: "POST",
					data:{
						id:mes_id,
					},
					cache: false,
					dataType: "json"
				}).done(function(d){
					switch(d.e){
						case 0:
							$('#msj-eliminar').click();
							$('#add-msj').click();
							$('#manager_ms_un_'+mes_id).remove();
							mes_id=0;
							break;
						case 1:
							//Error al eliminar
							break;
					}
				}).fail(function(a,b,d){
				});	
				return false;
			});
			
			$('body').on('click','a.modificar',function(){
				mes_id = $(this).attr('manager_mes_id');
				mes_tw = parseInt($(this).parents('li.pub_item').attr('sn_tw'));
				mes_fb = parseInt($(this).parents('li.pub_item').attr('sn_fb'));
				mes_fbp= parseInt($(this).parents('li.pub_item').attr('sn_fbp'));
				mes_gp = parseInt($(this).parents('li.pub_item').attr('sn_gp'));
				$("#delete_thingy").show();
				checkAllDays("sun,mon,tue,wed,thu,fri,sat",0);
				checkAllDays($(this).parents('li.pub_item').attr('d'),1);
				while(parseInt($("#tw").attr('data-tw')) != mes_tw)
					$('#fftw').click(); 
				
				while(parseInt($("#fb").attr('data-fb')) != mes_fb)
					$('#fffb').click();
					
				while(parseInt($("#fp").attr('data-fp')) != mes_fbp)
					$('#fffp').click();
					
				while(parseInt($("#gr").attr('data-gr')) != mes_gp)
					$('#ffgp').click();
				
				if(mes_tw==1)
					mes_max_chars=140;
				else
					mes_max_chars=2000;
				document.new_msg_manager.descripcion_nm.value=$(this).parents('li.pub_item').attr('m');
				document.new_msg_manager.from.value =	$(this).parents('li.pub_item').attr('ts_en');
				document.new_msg_manager.until.value =	$(this).parents('li.pub_item').attr('te_en');
				document.new_msg_manager.hour.value	=	$(this).parents('li.pub_item').attr('h');
				$("#1").attr("src",$(this).parents('li.pub_item').attr('pp'));
				var path=$("#1").attr("src");
				if(path.length>3){
					$('#imagen_manager').removeClass("hidden");
					$('#arrastrar_manager').addClass("hidden");
				}else{
					$('#imagen_manager').addClass("hidden");
					$('#arrastrar_manager').removeClass("hidden");
				}
				edit=true;
			});
			
			$('body').on('click','.del_dis_message',function(){
				mes_id=$(this).attr('manager_mes_id');
			});
			
			$('#cctw').on('click',function(){
				if(parseInt($("#ctw").attr('data-tw'))==0){
					max_chars=140-pub_len;
				}else{
					max_chars=2000-pub_len;}
			});
			
			$('#fftw').on('click',function(){
				if(parseInt($("#tw").attr('data-tw'))==0){
					mes_max_chars=140;
				}else{
					mes_max_chars=2000;}
			});
			
			$('textarea#descripcion').on('input propertychange', function(){
				reCountChars('span#restante',document.manager_mod_aut_pub.descripcion.value,false,max_chars);
			});
			
			$('textarea#descripcion_nm').on('input propertychange', function(){
				reCountChars('span#restante_nm',document.new_msg_manager.descripcion_nm.value,true,mes_max_chars);
			});
			
			
			$('body').on('click','button#btnAgregar',function(){
				mes_tw=0,mes_max_chars=2000,mes_fb=0,mes_fbp=0,mes_gp=0,mes_id=0,edit=false;
				checkAllDays("sun,mon,tue,wed,thu,fri,sat",1);
				$('#imagen_manager').removeClass("hidden");
				$('#arrastrar_manager').addClass("hidden");
				$("#1").attr("src","");
				while(parseInt($("#tw").attr('data-tw')) != pub_tw)
					$('#fftw').click(); 
				
				while(parseInt($("#fb").attr('data-fb')) != pub_fb)
					$('#fffb').click();
					
				while(parseInt($("#fp").attr('data-fp')) != pub_fbp)
					$('#fffp').click();
					
				while(parseInt($("#gr").attr('data-gr')) != pub_gp)
					$('#ffgp').click();
				$('#new_msg_manager')[0].reset();
				$("#delete_thingy").hide();
				$("#1").attr("src","");
			});
			
			
			$('body').on('submit','form#new_msg_manager',function(e){
				e.preventDefault();
				if(addin_ms==true)
					return false;
				else
					addin_ms=true;
				
				mes_tw = parseInt($("#tw").attr('data-tw'));
				mes_fb = parseInt($("#fb").attr('data-fb'));
				mes_fbp = parseInt($("#fp").attr('data-fp'));
				mes_gp = parseInt($("#gr").attr('data-gr'));
				var days=getDays();
				if(days.length<3){
					//debe marcar al menos un dia
					return false;
				}
				
				var mes_txt = document.new_msg_manager.descripcion_nm.value,
					data={
						message:mes_txt,
						time_start:document.new_msg_manager.from.value,
						time_end:document.new_msg_manager.until.value,
						days:getDays(),
						hour:document.new_msg_manager.hour.value,
						publish_tw:mes_tw,
						publish_fb:mes_fb,
						publish_fbp:mes_fbp,
						publish_group:mes_gp,
						img:$('#1').attr('src')
					};
					
				if(edit){
					data.edit=true;
					data.mes_id=mes_id;}
				
				if((mes_max_chars - mes_txt)<0){
					//descripci&oacute;n es muy larga
					return false;}
				$.ajax({
					url: "fcn/f_manager/add_sch_message.php",
					method: "POST",
					data:data,
					cache: false,
					dataType: "json"
				}).done(function(d){
					addin_ms=false;
					switch(d.e){
						case 0:
							if(edit){
								$("#manager_ms_un_"+mes_id).replaceWith(doThingM(d.c));
							}else{
								$("#messages_ns").prepend(doThingM(d.c));
							}
							$('#imagen_manager').removeClass("hidden");
							$('#arrastrar_manager').addClass("hidden");
							$("#1").attr("src","");
							$('div#add-msj').click();
							//todo bien.
							break;
						case 1:
							//Error al actualizar
							break;
						case 2:
							//error bd
							break;
						case 3:
							//error al validar usuario
							break;
						case 4:
							//El mensaje es muy corto
							break;
						case 5:
							//El mensaje es muy largo
							break;
					}
				}).fail(function(a,b,d){
					addin_ms=false;
				});
				return false;
				/*console.log(pub_tw);
				console.log(pub_fb);
				console.log(pub_fbp);
				console.log(pub_gp);*/
			});
			
			
			
			
			
			
			
			
			
			$('body').on('click','button.manager_edit_publication_thing',function(){
				pub_tw = parseInt($(this).parents('li.pub_item').attr('sn_tw'));
				pub_fb = parseInt($(this).parents('li.pub_item').attr('sn_fb'));
				pub_fbp= parseInt($(this).parents('li.pub_item').attr('sn_fbp'));
				pub_gp = parseInt($(this).parents('li.pub_item').attr('sn_gp'));
				pub_id = parseInt($(this).parents('li.pub_item').attr('sn_id'));
				pub_len= parseInt($(this).parents('li.pub_item').attr('sn_len'));
				pub_des= $(this).parents('li.pub_item').attr('sn_des');
				
				/*console.log(parseInt($("#ctw").attr('data-tw')));
				$('#cctw').click();
				console.log(parseInt($("#ctw").attr('data-tw')));*/
				/*console.log(parseInt($("#ctw").attr('data-tw')));
				console.log(pub_tw);*/
				while(parseInt($("#ctw").attr('data-tw')) != pub_tw)
					$('#cctw').click(); 
				
				while(parseInt($("#cfb").attr('data-fb')) != pub_fb)
					$('#ccfb').click();
					
				while(parseInt($("#cfp").attr('data-fp')) != pub_fbp)
					$('#ccfp').click();
					
				while(parseInt($("#cgr").attr('data-gr')) != pub_gp)
					$('#ccgp').click();
					
					
				/*if(pub_tw==1) $('#cctw').click();
				if(pub_fb==1) $('#ccfb').click();
				if(pub_fbp==1)$('#ccfbp').click();
				if(pub_gp==1) $('#ccgp').click();*/
				document.manager_mod_aut_pub.descripcion.value=pub_des;
			});
			
			
			$('body').on('submit','form#manager_mod_aut_pub',function(e){
				e.preventDefault();
				var del=false;
				pub_des = document.manager_mod_aut_pub.descripcion.value;
				pub_tw = parseInt($("#ctw").attr('data-tw'));
				pub_fb = parseInt($("#cfb").attr('data-fb'));
				pub_fbp = parseInt($("#cfp").attr('data-fp'));
				pub_gp = parseInt($("#cgr").attr('data-gr'));
				
				if(pub_tw==0 && pub_fb==0 && pub_fbp==0 && pub_gp==0)
					del=true;
				
				if((max_chars-pub_des.length)<0){
					//descripci&oacute;n es muy larga
					return false;}
					
				if(editing_aut==true)
					return false;
				else
					editing_aut=true;
				
				console.log(pub_des);
				$.ajax({
					url: "fcn/f_manager/change_pub_targets.php",
					method: "POST",
					data:{
						id:pub_id,
						tw:pub_tw,
						fb:pub_fb,
						fbp:pub_fbp,
						gp:pub_gp,
						des:pub_des,
					},
					cache: false,
					dataType: "json"
				}).done(function(d){
					editing_aut=false;
					switch(d.e){
						case 0:
							var d=$('li#manager_pub_un_'+pub_id);
							d.attr('sn_tw',pub_tw);
							d.attr('sn_fb',pub_fb);
							d.attr('sn_fbp',pub_fbp);
							d.attr('sn_gp',pub_gp);
							d.attr('sn_des',pub_des);
							if(pubtype==1){
								if(pub_tw==0 && pub_fb==0 && pub_fbp==0 && pub_gp==0)
									d.remove();
							
							}else{
								if(pub_tw==1 || pub_fb==1 || pub_fbp==1 || pub_gp==1)
									d.remove();
							}
							$('div#red-social').click();
							//todo bien.
							
							break;
						case 1:
							//Error al actualizar
							break;
					}
				}).fail(function(a,b,d){
					editing_aut=false;
				});	
				return false;
				/*console.log(pub_tw);
				console.log(pub_fb);
				console.log(pub_fbp);
				console.log(pub_gp);*/
			});
			
			
			
			
			
			$('body').on('click','a.manager_kill_sn',function(){
				var id=$(this).attr('pid');
				var sn=$(this).attr('sn');
				$.ajax({
					url: "fcn/f_manager/kill.php",
					method: "POST",
					data:{
						type: sn,
						pid: id,
					},
					cache: false,
					dataType: "json"
				}).done(function(d){
					addin_fbp=false;
					switch(d.e){
						case 0:
							switch(sn){
								case "tw":
									manager_tiene_tw = false;
									updateTwButton();
									break;
								case "fb":
									manager_tiene_fb = false;
									updateFbButton();
									break;
								case "fbp":
									manager_tiene_fbp = false;
									updateFbpButton();
									break;
							}
							break;
						case 1:
							//Error al eliminar
							break;
						case 2:
							//Error de Parametro
							break;
					}
				}).fail(function(a,b,d){
					addin_fbp=false;
				});	
				return false;
			});
			
			gettin_fbp=false,addin_fbp=false;
			$('body').on('click','button#fan_page_add',function(){
				if(addin_fbp || manager_tiene_fbp)
					return false;
				else
					addin_fbp=true;
				$.ajax({
					url: "fcn/f_manager/fb_add_page.php",
					method: "POST",
					data:{
						id:$('input[name=fan-page]:checked').val(),
					},
					cache: false,
					dataType: "json"
				}).done(function(d){
					addin_fbp=false;
					switch(d.e){
						case 0:
							var ll=d.p.length,arr=d.p,item=false,i=0,j=0,str=[];
							manager_tiene_fbp={
								i : d.d,
								n : d.n,
								p : d.p
							};
							updateFbpButton();
							break;
						case 1:
							//usuario no tiene cuenta de facbeook
							break;
						case 2:
							//usuario ya tiene un fan page
							break;
						case 3:
							//error del sdk
							break;
					}
				}).fail(function(a,b,d){
					addin_fbp=false;
				});	
					
					
			});
			
			
			
			$('body').on('click','button#vin_fbp_red_button',function(){
				if(gettin_fbp || manager_tiene_fbp)
					return false;
				else
					gettin_fbp=true;
				$.ajax({
					url: "fcn/f_manager/fb_get_pages.php",
					method: "GET",
					cache:false,
					dataType: "json"
				}).done(function(d){
					gettin_fbp=false;
					switch(d.e){
						case 0:
							var ll=d.p.length,arr=d.p,item=false,i=0,j=0,str=[];
							if(ll>0){
								for(;i<ll;i++){
									item=arr[i];
									str[j++]='<li><input type="radio" style="width: 20px; height: 20px;" value="'+item.i+'" name="fan-page" /><img src="'+item.p+'" style="width: 50px; height: 50px;" class="marL10" /><span class="marL10">'+item.n+'</span></li>';
								}
								$("ul#fan_page_list").html(str.join(''));
							}else{
								//no hay fan pages
							}
							break;
						case 1:
							//usuario no tiene cuenta de fb
							break;
						case 2:
							//usuario ya tiene un fan page
							break;
						case 3:
							//error del sdk
							break;
					}
				}).fail(function(a,b,d){
					gettin_fbp=false;
				});
			
			});
			
			
			var doing_fb_app=false;
			$('body').on('click','button#vin_fb_red_button',function(){
				if(doing_fb_app || manager_tiene_fb)
					return false;
				else
					doing_fb_app=true;
			
				FB.login(function(response){
					if (response.status === 'connected') {
						$.ajax({
							url: "fcn/f_manager/fbjscb.php",
							method: "GET",
							data:{
								state:2,
							},
							cache:false,
							dataType: "json"
						}).done(function(d){
							doing_fb_app=false;
							switch(d.e){
								case 0:
									manager_tiene_fb={
										i : d.d,
										n : d.fn + " "+ d.ln,
										p : d.p
									};
									updateFbButton();
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
								case 5:
									//El usuario ya tiene otra cuenta de fb vinculada
									break;
							}
						}).fail(function(a,b,d){
							doing_fb_app=false;
							//mostrar mensaje de error de conexi&oacute;n correspondiente
						});
					} else if (response.status === 'not_authorized') {
						//mostrar error de autorizaci&oacute;n
						doing_fb_app=false;
					} else {
						//mostrar error de conexi&oacute;n a fb
						doing_fb_app=false;
					}
			},{auth_type:'reauthenticate',scope:scopes});
			return false;
			});
			
			
		});
	</script>
 <?php


?>


<?php include "temas/header.php";?>
<div class="container">	
	<div class="row">
	<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 ">
		<?php include "temas/menu-left-usr.php";?>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 ">	
		<div class="marL20 ">
		<div class="<?php echo $display1;?>"><?php include "paginas/redes/p_redes_vincular.php";?></div>
		<div class="<?php echo $display2;?>"><?php include "paginas/redes/p_redes_publicaciones.php";?></div>	
			<div class="<?php echo $display3;?>"><?php include "paginas/redes/p_redes_mensajes.php";?></div>
		</div>
	</div>
	</div>
</div>

<?php 
include "temas/footer.php";
include "modales/m_delete.php";
include "modales/m_add_mensaje.php";
include "modales/m_redes_sociales.php";
include "modales/m_vincular_grupo.php";
include "modales/m_vincular_fan.php";
include "modales/m_delete.php";
include "modales/m_cropper.php";
?>
<script src="js/redes.js"></script>
<div class="modal-backdrop fade in cargador" style="display:none"></div>
</body>
</html>
