<div id="banner-principal">
	<center>
		<h1>Registro</h1>
    </center>
 </div>
<center id="contenido">
  <?=$this->layout->getNav();?>

	<div class="row">
    	<div class="col-sm-7">
        	<p><?php echo $registro->contenido; ?></p>
    
            <form action="#" method="post" class="formulario ui-koalaform-formbox" id="form-registro">
            	<div class="box-form">
                    <label for="nombres">*Nombres</label>
                    <input type="text" tabindex="1" id="nombres" class="input validate[required]" title="Nombres" name="nombres">
                </div>
                <div class="box-form">
                    <label for="apellidos">*Apellidos</label>
                    <input type="text" tabindex="2" id="apellidos" class="input validate[required]" title="Apellidos" name="apellidos">
                </div>
                <div class="box-form">
                    <label for="telefono">*Teléfono</label>
                    <input type="text" tabindex="2" id="telefono" class="input validate[required, custom[phone]]" title="Teléfono" name="telefono">
                </div>
                <div class="box-form">
                    <label for="pais">*País</label>
					<select	name="pais" id="pais" class="input validate[required]">
						<option disabled selected>Seleccione</option>
						<?php foreach($paises as $pais){ ?>
						<option value="<?php echo $pais->codigo; ?>"><?php echo $pais->nombre; ?></option>
						<?php } ?>
					</select>
                </div>
                <div class="box-form">
                    <label for="region">*Región</label>
					<select	name="region" id="region" class="input validate[required]">
						<option disabled selected>Seleccione</option>
					</select>
                </div>
                <div class="box-form">
                    <label for="comuna">*Comuna</label>
					<select	name="comuna" id="comuna" class="input validate[required]">
						<option disabled selected>Seleccione</option>
					</select>
                </div>
                <div class="box-form">
                    <label for="direccion">*Dirección</label>
                    <input type="text" tabindex="3" id="direccion" class="input validate[required]" title="Dirección" name="direccion">
                </div>
                <div class="box-form">
                    <label for="email">*Email:</label>
                    <input type="text" tabindex="4" id="email" class="input validate[required, custom[email]]" title="Email" name="email">
                </div>
                <div class="box-form">
                    <label for="contrasena">*Contraseña:</label>
                    <input type="password" tabindex="5" id="contrasena" class="input validate[required]" title="Contraseña" name="contrasena">
                </div>
                <div class="box-form">
                    <label for="repetir">*Repetir Contraseña:</label>
                    <input type="password" tabindex="6" id="repetir" class="input validate[required, equals[contrasena]]" title="Repetir Contraseña" name="repetir">
                </div>
                <div class="box-form">
                    <label></label>
                    <div class="g-recaptcha" data-sitekey="6LeZ5BYUAAAAAFjyX4yWOEj-xQuxadfn5K44Py1A" style="float: left;"></div>
                </div>
            
            	<div class="caja-contacto">
                    
                    <input type="submit" tabindex="7" value="Registrarme" id="boton-enviar" class="boton-enviar">
                    <p>(*) Datos requeridos</p>
                </div>
            </form>
        </div>
    </div>


<div class="clear"></div>
 </center>