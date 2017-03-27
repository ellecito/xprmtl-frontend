<div id="banner-principal">
	<center>
		<h1>Carro de compras</h1>
    </center>
</div>
<center id="contenido">
	<?php echo $this->layout->getNav(); ?>
	<div class="carrito-compra">
		<?php if($this->cart->total_items() > 0){ ?>
			<div class="titulos">
				<span class="info">Información del producto</span>
				<span class="descripcion">Descripción Corta</span>
				<span class="cantidad">Cantidad</span>
				<span class="valor">Valor final</span>
				<span class="opciones">&nbsp;</span>
			</div>
			<?php foreach($this->cart->contents() as $aux){ ?>
				<?php if($aux['qty']>0){ ?>
				<?php foreach($this->cart->product_options($aux['rowid']) as $key => $op){
					if($key == 'imagen')
						$imagen = $op;
					if($key == 'resumen')
						$resumen = $op;
					if($key == 'categoria')
						$categoria = $op;
				} ?>
				<div class="content">
					<div class="info">
						<div class="col-sm-6">
							<img src="<?php echo $imagen; ?>" width="266" height="177" />
						</div>
						<div class="col-sm-6">
							<span class="uno"><?php echo $aux['name']; ?></span>
							<span class="dos">Codigo: <?php echo $aux['id']; ?></span>
							<span><?php echo $categoria; ?></span>
						</div>
					</div>
					<div class="descripcion">
						<p><?php echo $resumen; ?></p>
					</div>
					<div class="cantidad"> <input type="text" class="input cant" id="cantidad" name="cantidad" value="<?php echo $aux['qty'] ?>"></div>
					<div class="valor" id="valor">$<?php echo formatearValor($aux['qty']*$aux['price']); ?></div>
					<input type="hidden" class="precio" value="<?php echo $aux['price']; ?>">
					<input type="hidden" class="id" value="<?php echo $aux['rowid']; ?>">
					<div class="opciones"><a href="#" class="eliminar" rel="<?php echo $aux['rowid']; ?>"><img src="/imagenes/template/not.png" width="19" height="19" /></a></div>
				</div>
				<?php } ?>
			<?php } ?>
		<?php } ?>
    </div>

	<div class="opciones" style="margin-top: 50px;">
		<h2>Opciones de pago</h2>
    	<div class="box" style="background: #FFFFFF;">
   	  		<img src="/imagenes/sitio/webpay.jpg" width="456" height="200" alt="Webpay" style="width: auto;"/>
        </div>
	</div>
	<?php if(!$this->session->userdata("usuario")){ ?>
    <span class="importante"><b>¡Importante!</b>Para poder cotizar debe iniciar sesión</span>
	<?php } ?>
	<?php if($this->session->userdata("usuario")): ?>
		<?php if($this->cart->total_items() > 0): ?>
    <form id="form-carro-compra" action="" method="post">
			<input type="hidden" value="1" name="1">
    		<input type="submit" class="boton-enviar mi-btn" value="Comprar" style="margin-top: 0px">
				<label for="" style="width: 73%;">
					<h5 style="text-align: right;">
						Al presionar en comprar, estás aceptando los <a href="/terminos-y-condiciones/">Términos y Condiciones</a>
					</h5>
				</label>
    </form>
	<?php else: ?>
		<h2>Tu carro de compra está vacío... <a href="/productos">Ir a los productos</a></h2>
	<?php endif; ?>
	<?php endif; ?>
	<div class="clear"></div>
</center>
<script>
$(document).ready(function(){
	
});
</script>
