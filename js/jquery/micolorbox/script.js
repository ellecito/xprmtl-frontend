$(document).ready(function(){				
	if (screen.width>800){
				$(".group1").colorbox({rel:'group1', maxWidth: "95%", maxHeight: "95%"});
				$(".group2").colorbox({rel:'group1', maxWidth: "95%", maxHeight: "95%"});
				$(".group3").colorbox({rel:'group1', maxWidth: "95%", maxHeight: "95%"});
				$(".group4").colorbox({rel:'group1', maxWidth: "95%", maxHeight: "95%"});
				$(".murovirtual-lb").colorbox({iframe:true, width:"960px", height:"520px"});
				$(".costo-envio-lb").colorbox({iframe:true, width:"500px", height:"400px"});
				$(".contacto-iframe").colorbox({iframe:true, width:"550px", height:"450px"});
				$(".login-iframe").colorbox({iframe:true, width:"550px", height:"300px"});
				$(".destacar-iframe").colorbox({iframe:true,overlayClose:false,escKey:false, width:"700px", height:"500px"});
	} else { 
				$(".group1").colorbox({rel:'group1', maxWidth:"95%",maxHeight: "95%"});
				$(".group2").colorbox({rel:'group1', maxWidth:"95%",maxHeight: "95%"});
				$(".group3").colorbox({rel:'group1', maxWidth:"95%",maxHeight: "95%"});
				$(".group4").colorbox({rel:'group1', maxWidth:"95%",maxHeight: "95%"});
				$(".murovirtual-lb").colorbox({iframe:true, maxWidth:"95%",maxHeight: "95%", width: "95%",  height: "90%"});
				$(".contacto-iframe").colorbox({iframe:true, maxWidth:"90%",maxHeight: "100%", width: "90%",  height: "100%"});
				$(".login-iframe").colorbox({iframe:true, maxWidth:"90%",maxHeight: "100%", width: "90%",  height: "100%"});
				$(".destacar-iframe").colorbox({iframe:true,overlayClose:false,escKey:false, maxWidth:"90%",maxHeight: "100%", width: "90%",  height: "100%"});

	}
});