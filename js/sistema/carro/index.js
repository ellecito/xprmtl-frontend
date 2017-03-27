$(document).ready(function(){
	$(".eliminar").click(function(e){
		e.preventDefault();
		var id = $(this).attr('rel');

		noty({
			layout: 'topCenter',
			killer: true,
			fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>',
			text: '¿Está seguro que desea eliminar este producto?',
			buttons: [
				{
					addClass: 'btn btn-primary', text: 'Aceptar', onClick: function($noty) {
						$noty.close();
						$(window).unbind('beforeunload');

						noty({
							text: 'Eliminado. Por favor, espere un momento.',
							layout: 'topCenter',
							type: 'alert',
							killer:true,
							closeWith: [],
							template: '<div class="noty_message"><img src="/imagenes/icons/ajax-loader.gif">&nbsp;&nbsp;<span class="noty_text"></span><div class="noty_close"></div></div>',
							fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>'
						});

						$.ajax({
							url: '/carro/eliminar/',
							type: 'post',
							dataType: 'json',
							data: "id="+id,
							success: function(json){
								if(json.result){
									noty({
										text: "Producto eliminado con éxito.",
										layout: 'topCenter',
										type: 'success',
										killer: true
									});
									setTimeout(function() {
										window.location.reload();
									}, 1000);
								}else{
									noty({
										text: json.msg,
										layout: 'topCenter',
										type: 'error',
										killer: true
									});
								}
							}
						});
					}
				},
				{
					addClass: 'btn btn-danger', text: 'Cancelar', onClick: function($noty) {
						$noty.close();
					}
				}
			]
		});	
	});
	
	$("#form-carro-compra").validationEngine('attach', {
        promptPosition: 'topLeft',
        validationEventTrigger: false,
        showOneMessage: true,
        onValidationComplete: function(form, status) {
            if (status) {

                noty({
                    text: 'Procesando compra. Por favor espere un momento.',
                    layout: 'topCenter',
                    type: 'alert',
                    closeWith: [],
                    killer: true,
                    template: '<div class="noty_message"><img src="/imagenes/icons/ajax-loader.gif">&nbsp;&nbsp;<span class="noty_text"></span><div class="noty_close"></div></div>',
                    fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>'
                });

                $.ajax({
                    url: '/carro/crear_orden/',
                    type: 'post',
                    dataType: 'json',
                    data: $("#form-carro-compra").serialize(),
                    success: function(json) {
                        if (json.result) {
                            setTimeout(function(){
                               window.location.href = "/carro/webpay/";
                           }, 1000);
                        } else {
                            noty({
                                text: "Orden de compra generada exitosamente.",
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

	$('.cant').keyup(function(event){
        this.value = this.value.replace(/[^0-9\.]/g,'');
		var precio = $(this).parent().siblings(".precio").val();
		precio = precio*this.value;

		$(this).parent().siblings(".valor").html('<div class="valor">$' + addCommas(precio) + '</div>');
		$(this).parent().siblings(".valor").trigger("chosen:updated");
		if(this.value>0){
			$.ajax({
				url: '/carro/actualizar/',
				type: 'post',
				dataType: 'json',
				data: "id="+$(this).parent().siblings(".id").val()+"&qty="+this.value,
			});
		}
	});

	function addCommas(nStr){
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + '.' + '$2');
		}
		return x1 + x2;
	}
});