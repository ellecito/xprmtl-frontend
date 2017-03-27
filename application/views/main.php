<section id="header">
 <center>
  <!-- [LOGO] -->
  <div id="logo">
   <?php if(isset($home_indicador)){ ?>
   <h1>Speed Up</h1>
   <img class="fix-logo" src="/imagenes/template/logo.png" width="176" height="35" alt="Speed Up" />
   <?php } else{ ?>
   <a href="/" title="Inicio: Tecla de Acceso 0" accesskey="0"><img src="/imagenes/template/logo.png" width="176" height="35" alt="Speed Up" /></a>
   <?php } ?>
  </div>
  <!-- [MENU] -->
  <div id="top">
  	<div class="box1">
		<?php if($this->session->userdata("usuario")){ ?>
        	<a href="/perfil/"><?php echo $this->session->userdata("usuario")->email ?></a>
            |
			<a href="/logout/">CERRAR SESIÓN</a>
		<?php }else{ ?>
			<a id="btn-login" href="#">INICIAR SESIÓN</a>
			|
			<a href="/registro/">REGISTRARME</a>
			<div id="panel-login">
				<span>INICIAR SESIÓN</span>
				<form action="#" method="post" id="form-login">
				<input class="user" placeholder="Ingrese su correo" type="text" id="Email-l" title="Email" name="email">
				<input placeholder="Contraseña" class="pass" type="password" id="Contrasena-l" title="Contraseña" name="contrasena">
				<input type="submit" tabindex="7" value="Ingresar" id="boton-enviar" class="boton-enviar">
				</form>
				<a href="#">RECUPERAR CONTRASEÑA</a>
			</div>
		<?php } ?>
    </div>
    <div class="box2">
    	BÚSCANOS EN:
		<?php if($empresa_general->facebook){ ?>
        <a href="<?php echo $empresa_general->facebook; ?>" style="margin-left:10px;" target="_blank"><img src="/imagenes/template/facebook.png" width="23" height="21" /></a>
		<?php } ?>
		
		<?php if($empresa_general->instagram){ ?>
        <a href="<?php echo $empresa_general->instagram; ?>" target="_blank"><img src="/imagenes/template/instagram.png" width="24" height="21" /></a>
		<?php } ?>
		
		<?php if($empresa_general->youtube){ ?>
        <a href="<?php echo $empresa_general->youtube; ?>" target="_blank"><img src="/imagenes/template/youtube.png" width="21" height="21" /></a>
		<?php } ?>
		
		<?php if($empresa_general->twitter){ ?>
        <a href="<?php echo $empresa_general->twitter; ?>" target="_blank"><img src="/imagenes/template/twitter.png" width="21" height="21" /></a>
		<?php } ?>
    </div>
  </div>
  <div id="nav">
   <ul class="lista-menu">
    <li><a href="/productos/" title="Productos: Tecla de Acceso 1" accesskey="1">Productos</a>
		<?php if($categorias){ ?>
    	<ul>
			<?php foreach($categorias as $cat){ ?>
        	<li><a href="/productos/?categoria=<?php echo $cat->codigo; ?>"><?php echo $cat->nombre; ?></a></li>
			<?php } ?>
        </ul>
		<?php } ?>
    </li>
    <li><a href="/quienessomos/" title="Quienes somos: Tecla de Acceso 3" accesskey="3">Quienes somos</a></li>
    <li><a href="/noticias/" title="Noticias: Tecla de Acceso 4" accesskey="4">Noticias</a></li>
    <li><a href="/contactos/" title="Contacto: Tecla de Acceso 5" accesskey="5">Contacto</a></li>
    <li><a href="/carro/" title="Carrito de compras: Tecla de Acceso 6" accesskey="6">Carro de compras</a></li>
   </ul>
  </div>
 </center>
</section>
<script type="text/javascript">
	var navigation = responsiveNav("#nav");
</script>
