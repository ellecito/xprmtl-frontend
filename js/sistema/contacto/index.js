$(document).ready(function() {
	
	$("#form-contacto").validationEngine('attach', {
	    promptPosition:'topLeft',
		validationEventTrigger:false,
	    scroll: false,
	    showOneMessage:true,
		onValidationComplete: function(form, status){
			if(status) {
				noty({
					text: 'Su mensaje está siendo enviado. Por favor, espere un momento.',
					layout: 'topCenter',
					type: 'alert',
					closeWith: [],
					killer:true,
					template: '<div class="noty_message"><img src="/imagenes/icons/ajax-loader.gif">&nbsp;&nbsp;<span class="noty_text"></span><div class="noty_close"></div></div>',
					fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>'
				});

				$.ajax({
					url: '/contactos/envio/',
					type: 'post',
					dataType: 'json',
					data: $("#form-contacto").serialize(),
					success: function(json){
						if(json.result){
							noty({
								text: "Su mensaje ha sido enviado con éxito.",
								layout: 'topCenter',
								type: 'success',
								killer: true
							});

							setTimeout(function(){
								window.location.href = '/';
							}, 1000);
						}else{
							noty({
								text: json.msg,
								layout: 'topCenter',
								type: 'error',
								timeout: 3000,
								killer: true
							});
						}
					}
				});
			}
		}
	});
	
});