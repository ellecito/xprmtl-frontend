<div id="banner-principal">
	<center>
		<h1>Contáctanos</h1>
    </center>
 </div>
<center id="contenido">
  <?=$this->layout->getNav();?>

	<div class="row">
    	<div class="col-sm-8">
	<p>Escríbanos y cuéntenos en qué podemos asesorarlo</p>
	<form action="#" method="post" class="formulario ui-koalaform-formbox" id="form-contacto">
		<fieldset>
        	<div class="box-form">
			<label for="nombre">* Nombres:</label>
			<input type="text" tabindex="1" id="nombre" class="input validate[required]" title="Nombres" name="nombres" value="<?php if($this->session->userdata("usuario")) echo $this->session->userdata("usuario")->nombres; ?>" />
			</div>
            <div class="box-form">
			<label for="apellido">* Apellidos:</label>
			<input type="text" tabindex="2" id="apellido" class="input validate[required]" title="Apellidos" name="apellidos" value="<?php if($this->session->userdata("usuario")) echo $this->session->userdata("usuario")->apellidos; ?>" />
			</div>
            <div class="box-form">
			<label for="email">* E-mail:</label>
			<input type="text" tabindex="3" id="email" class="input validate[required,custom[email]]" title="E-Mail" name="email" value="<?php if($this->session->userdata("usuario")) echo $this->session->userdata("usuario")->email; ?>" />
			</div>
            <div class="box-form">
			<label for="fono">* Teléfono:</label>
			<input type="text" tabindex="4" id="fono" class="input validate[required,custom[phone]]" title="Teléfono" name="telefono" value="<?php if($this->session->userdata("usuario")) echo $this->session->userdata("usuario")->telefono; ?>" />
			</div>
            <div class="box-form">
			<label for="mensaje">* Mensaje:</label>
			<textarea tabindex="5" class="validate[required]" id="mensaje" rows="7" cols="50" title="Mensaje" name="mensaje"></textarea>
            </div>
			<div class="box-form">
                <label></label>
                <div class="g-recaptcha" data-sitekey="6LeZ5BYUAAAAAFjyX4yWOEj-xQuxadfn5K44Py1A" style="float: left;"></div>
            </div>
			<div class="caja-contacto">
				
				<input type="submit" tabindex="6" value="Enviar mensaje" id="boton-enviar" class="boton-enviar">
                <p>(*) Datos requeridos</p>
			</div>
		</fieldset>
	</form>
</div>
<div class="col-sm-4">
	<div id="contenido-adicional">
    	<div class="box">
        	<span><?php echo $empresa_general->nombre; ?></span>
            <ul>
                <li>Ubicación: <?php echo $empresa_general->direccion; ?></li>
                <li>Email: <?php echo $empresa_general->email; ?></li>
                <li>Teléfono contacto: <?php echo $empresa_general->telefono; ?></li>
            </ul>
        </div>
    </div>
</div>
</div>
</center>