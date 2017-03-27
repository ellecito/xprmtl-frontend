<div id="banner-principal">
	<center>
		<h1><?php echo $producto->categoria->nombre; ?></h1>
    </center>
</div>
<center id="contenido">
  	<?php echo $this->layout->getNav();?>
	<div class="row">
    	<!--<div class="col-sm-3">
            <h2 class="tachado">Seleccione una opción</h2>
            <div class="listado-filtros">
            	<?php /*if($categorias) { ?>
				<?php foreach($categorias as $cat) { ?>
            	<a class="active" href="/productos/"><?php echo $cat->nombre . " (" . $cat->codigo . ")"; ?></a>
				<?php } ?>
				<?php }*/ ?>
            </div>
        </div>-->
        <div class="col-sm-12">
        	<div class="col-sm-5">
				<div class="big">
					<a class="group1" href="<?php echo URL_ADMIN  . $producto->imagenes[0]->imagen; ?>">
						<img src="<?php echo URL_ADMIN  . $producto->imagenes[0]->imagen; ?>" width="363" height="391" />
					</a>
				</div>
				<div class="cont-galeria">
					<div class="galeria">
						<?php $i = FALSE; foreach($producto->imagenes as $imagen){ ?>
						<?php if($i){ ?>
						<div>
							<a class="group1" href="<?php echo URL_ADMIN  . $imagen->imagen; ?>">
								<img src="<?php echo URL_ADMIN  . $imagen->imagen; ?>" width="104" height="106" />
							</a>
						</div>
						<?php } $i = TRUE; ?>
						<?php } ?>
					</div>
				</div>	
			</div>
            
					<div class="col-sm-7">
						<h2 class="tachado tt"><?php echo $producto->nombre; ?></h2>
						<?php echo $producto->descripcion; ?>
						<h2 class="tachado tt2">Especificaciones técnicas</h2>
						<div class="editable">
							<?php echo $producto->especificaciones_tecnicas; ?>
						</div>
						<div class="precio-especial">
							Valor producto
							<b>$ <?php echo formatearValor($producto->precio); ?></b>
						</div>
						<a href="#" class="tachado btn-carrito" id="agregar-carro" rel="<?php echo $producto->codigo; ?>"><img src="/imagenes/template/carrito.png" />Agregar producto al carrito</a>
					</div>
            <div class="clear"></div>
            
            <div class="row" style="margin:100px 0;">
                <div class="col-sm-12">
                    <h2 class="tachado">productos que pueden interesarte</h2>
                </div>
                
                <div class="galeriados col-sm-12">
					<?php if($productos) { ?>
					<?php foreach($productos as $producto) { ?>
                    <div class="listado-gal">
                        <div class="box-listado">
                            <a href="/productos/<?php echo $producto->codigo . "-" . $producto->url; ?>/"><img src="<?php echo URL_ADMIN . $producto->imagenes->imagen; ?>" width="266" height="177" /> </a>
                            <div class="text-center">
                                <a href="/productos/<?php echo $producto->codigo . "-" . $producto->url; ?>/" class="tachado"><?php echo $producto->nombre; ?></a>
                            </div>
                            <span class="cat"><?php echo $producto->categoria->nombre; ?></span>
                            <p><?php echo $producto->resumen; ?></p>
                            <span class="valor">Valor: <b>$ <?php echo formatearValor($producto->precio); ?></b></span>
                        </div>
                    </div>
					<?php } ?>
					<?php } ?>
				</div>
            </div>
        </div>        
	</div>
	<div class="clear"></div>
</center>

<script type="text/javascript">
$(document).ready(function(){
	$('.galeria').slick({
        slidesToShow: 3,
		slidesToScroll: 1,
		autoplay: false,
		dots: false,
		autoplaySpeed: 5000,
		arrows: true,
		infinite: false		  
 	});
	$('.galeriados').slick({
        slidesToShow: 3,
		slidesToScroll: 1,
		autoplay: false,
		dots: true,
		autoplaySpeed: 5000,
		arrows: false,
		infinite: false,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3,
					infinite: true,
					dots: true
				}
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 400,
				settings: {
					slidesToShow: 1
				}
			}
		]
 	});
});	
</script>