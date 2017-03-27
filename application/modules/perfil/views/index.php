<div id="banner-principal">
	<center>
		<h1>Perfil</h1>
    </center>
 </div>
<center id="contenido">
  <?=$this->layout->getNav();?>

	<div class="row">
    	<div class="col-sm-7">
            <form action="#" method="post" class="formulario ui-koalaform-formbox" id="form-registro">
            	<div class="box-form">
                    <label for="nombres">*Nombres</label>
                    <input type="text" tabindex="1" id="nombres" class="input validate[required]" title="Nombres" name="nombres" value="<?php echo $this->session->userdata("usuario")->nombres; ?>" />
                </div>
                <div class="box-form">
                    <label for="apellidos">*Apellidos</label>
                    <input type="text" tabindex="2" id="apellidos" class="input validate[required]" title="Apellidos" name="apellidos" value="<?php echo $this->session->userdata("usuario")->apellidos; ?>" />
                </div>
                <div class="box-form">
                    <label for="telefono">*Teléfono</label>
                    <input type="text" tabindex="2" id="telefono" class="input validate[required, custom[phone]]" title="Teléfono" name="telefono" value="<?php echo $this->session->userdata("usuario")->telefono; ?>" />
                </div>
                <div class="box-form">
                    <label for="pais">*País</label>
					<select	name="pais" id="pais" class="input">
						<option disabled selected>Seleccione</option>
						<?php foreach($paises as $pais){ ?>
						<option value="<?php echo $pais->codigo; ?>"><?php echo $pais->nombre; ?></option>
						<?php } ?>
					</select>
                </div>
                <div class="box-form">
                    <label for="region">*Región</label>
					<select	name="region" id="region" class="input">
						<option disabled selected>Seleccione</option>
					</select>
                </div>
                <div class="box-form">
                    <label for="comuna">*Comuna</label>
					<select	name="comuna" id="comuna" class="input validate[required]">
						<option value="<?php echo $comuna->codigo; ?>"><?php echo $comuna->nombre; ?></option>
					</select>
                </div>
                <div class="box-form">
                    <label for="direccion">*Dirección</label>
                    <input type="text" tabindex="3" id="direccion" class="input validate[required]" title="Dirección" name="direccion" value="<?php echo $this->session->userdata("usuario")->direccion; ?>" />
                </div>
                <div class="box-form">
                    <label for="email">*Email:</label>
                    <input type="text" tabindex="4" id="email" class="input validate[required, custom[email]]" title="Email" name="email" value="<?php echo $this->session->userdata("usuario")->email; ?>" />
                </div>
            
            	<div class="caja-contacto">
                    
                    <input type="submit" tabindex="7" value="Actualizar" id="boton-enviar" class="boton-enviar">
                    <p>(*) Datos requeridos</p>
                </div>
            </form>
            <form action="#" method="post" class="formulario ui-koalaform-formbox" id="form-password">
				<div class="box-form">
                    <label for="contrasena_actual">*Contraseña actual:</label>
                    <input type="password" tabindex="5" id="contrasena_actual" class="input validate[required]" title="Contraseña" name="contrasena_actual">
                </div>
                <div class="box-form">
                    <label for="contrasena">*Contraseña nueva:</label>
                    <input type="password" tabindex="5" id="contrasena" class="input validate[required]" title="Contraseña" name="contrasena">
                </div>
                <div class="box-form">
                    <label for="repetir">*Repetir Contraseña:</label>
                    <input type="password" tabindex="6" id="repetir" class="input validate[required, equals[contrasena]]" title="Repetir Contraseña" name="repetir">
                </div>
            
            	<div class="caja-contacto">
                    
                    <input type="submit" tabindex="7" value="Cambiar contraseña" id="boton-enviar" class="boton-enviar">
                    <p>(*) Datos requeridos</p>
                </div>
            </form>
        </div>
    </div>


<div class="clear"></div>
 </center>