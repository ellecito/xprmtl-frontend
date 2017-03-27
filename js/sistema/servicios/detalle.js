$(document).ready(function(){
   
	$("#contacto-servicio").KoalaForm({
		use_css: true,
		disableButtonOnSubmit: false,
		onBlur: false,
		successMessage: {
			title: "<strong>Procesando</strong>:",
			msg:"Su mensaje está siendo procesado, espere un momento."
			//iconClass:"ui-icon ui-icon-clock"
		},
		ajaxOptions: {
			url: "/contacto/envio/",                        
			success: function(json){
				if(json.result){					
					//alert(json.html);
					$.KoalaFormHide();
					$.KoalaFormMsgBox("","Sus comentarios han sido enviados. Nos contactaremos con Ud. a la brevedad.",null,null,"ui-icon ui-icon-ok");
					$("#koalaFormBox-p").addClass("ui-state-highlight-exito");
					$.KFWOverlay('hide');
					$('#form-reflex')[0].reset();
				}else{
                    $.KoalaFormHide();
					$.KoalaFormMsgBox("","Ha ocurrido un error inesperado, por favor intentelo más tarde.","no",null,"ui-icon ui-icon-alert");
                    $.KFWOverlay('hide');
				}
			}
		},
		onSuccess: function(form){
			return false;
		}
	});
	$('.comentar').click(function () {
       $('html, body').animate({
           scrollTop: $(document).height() - 350
       },
       1500);
	   $('#nombre').focus();
       return false;
   });
	
   // GALERIA
	var control = false;
	if($("#slider2 ul li").length > 1) control = true;
	$("#slider2").easySlider({controlsFade: false, controlsShow: control});
	$("a[rel='galeria']").colorbox({transition:"elastic",current: "Imagen {current} de {total}"});
	$(".multimedia").tabs();
   
});