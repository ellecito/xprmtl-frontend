$(document).ready(function() {
	
	$("#pais").change(function(e){
		e.preventDefault();
		$("#region").html("<option disabled selected>Buscando...</option>");
		$("#region").trigger("chosen:updated");
		$.ajax({
			url: '/registro/buscar_region/',
			type: 'post',
			dataType: 'json',
			data: "pais=" + $(this).val(),
			success: function(json){
				if(json.result){
					$("#region").html(json.html);
					$("#region").trigger("chosen:updated");
				}
			}
		});
	});
	
	$("#region").change(function(e){
		e.preventDefault();
		$("#comuna").html("<option disabled selected>Buscando...</option>");
		$("#comuna").trigger("chosen:updated");
		$.ajax({
			url: '/registro/buscar_comuna/',
			type: 'post',
			dataType: 'json',
			data: "region=" + $(this).val(),
			success: function(json){
				if(json.result){
					$("#comuna").html(json.html);
					$("#comuna").trigger("chosen:updated");
				}
			}
		});
	});
	
	$("#form-registro").validationEngine('attach', {
	    promptPosition:'topLeft',
		validationEventTrigger:false,
	    scroll: false,
	    showOneMessage:true,
		onValidationComplete: function(form, status){
			if(status) {
				noty({
					text: 'Verificando datos. Por favor, espere un momento.',
					layout: 'topCenter',
					type: 'alert',
					closeWith: [],
					killer:true,
					template: '<div class="noty_message"><img src="/imagenes/icons/ajax-loader.gif">&nbsp;&nbsp;<span class="noty_text"></span><div class="noty_close"></div></div>',
					fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>'
				});

				$.ajax({
					url: '/registro/envio/',
					type: 'post',
					dataType: 'json',
					data: $("#form-registro").serialize(),
					success: function(json){
						if(json.result){
							noty({
								text: "Registro realizado con éxito",
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