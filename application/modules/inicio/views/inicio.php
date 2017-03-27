<div class="flexslider">
    <ul class="slides">
		<?php if($sliders){ ?>
		<?php foreach($sliders as $slider){ ?>
        <li> <img src="<?php echo URL_ADMIN . $slider->imagen; ?>" />
            <div class="flex-caption">
                <center>
                	<p class="titulo"><?php echo $slider->titulo; ?></p>
                	<p><?php echo $slider->resumen; ?></p>
                    <a href="<?php echo $slider->enlace; ?>">Ver mas</a>
                </center>
            </div>
        </li>
		<?php } ?>
		<?php } ?>
    </ul>
</div>

<center class="productos-p">
	<div class="row">
		<div class="col-sm-8">
        	<h2 class="tachado">productos destacados</h2>
        </div>
        <div class="col-sm-4 productos-m">
			<!-- <div class="more"><a href="/productos/">ver mas novedades</a></div> -->
        </div>
    </div>
    <div class="row">
		<?php if($productos){ ?>
		<?php foreach($productos as $producto){ ?>
    	<div class="col-sm-3">
            <div class="box-listado">
           	    <a href="/productos/<?php echo $producto->codigo . "-" . $producto->url; ?>"><img src="<?php echo URL_ADMIN . $producto->imagenes->imagen; ?>" width="272" height="295" /> </a>
                <div class="text-center">
                    <a href="/productos/<?php echo $producto->codigo . "-" . $producto->url; ?>" class="tachado"><?php echo $producto->nombre; ?></a>
                </div>
                <!--<span class="cat"><?php echo $producto->categoria_nombre; ?></span>-->
                <p><?php echo $producto->resumen; ?></p>
                <span class="valor"><b>$ <?php echo formatearValor($producto->precio); ?></b></span>
           </div>
        </div>
		<?php } ?>
		<?php } ?>
    </div>

    <div class="row segundo-bloque">
    	<div class="col-sm-7">
        	<span class="tachado tt">Noticias</span>
			<?php if($noticias){ ?>
			<?php foreach($noticias as $noticia) { ?>
            <article class="listado"> <a href="/noticias/<?php echo str_replace("-", "/", $noticia->fecha) . "/" . $noticia->url; ?>"><img src="<?php echo URL_ADMIN . $noticia->imagen; ?>" width="226" height="172"></a>
             <div class="resumen">
              <p class="text-fecha"><?php echo fecha_real($noticia->fecha); ?></p>
              <h3><a href="/noticias/<?php echo str_replace("-", "/", $noticia->fecha) . "/" . $noticia->url; ?>"><?php echo $noticia->titulo; ?></a></h3>

              <p><?php echo $noticia->resumen; ?></p>
              <a class="seguir-leyendo" href="/noticias/<?php echo str_replace("-", "/", $noticia->fecha) . "/" . $noticia->url; ?>">SEGUIR LEYENDO</a>
             </div>
            </article>
			<?php } ?>
			<?php } ?>
            <div class="more"><a href="/noticias/">Ver mas noticias</a></div>
        </div>
        <div class="col-sm-5">
        	<!--<span class="tachado">video promocional</span>
            <div class="video-promocional">
            	<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php //echo $empresa_general->video; ?>?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
            </div>-->

        	<span class="tachado">quienes somos</span>
            <div class="imagen-response">
       	    	<img src="/imagenes/borrar/bannersito.jpg" width="474" height="216" />
            </div>
            <?php echo $quienessomos->contenido; ?>
            <div class="more"><a href="/quienessomos/">Seguir leyendo</a></div>
        </div>
    </div>



</center>


<script type="text/javascript">
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "fade",
      });
    });
</script>
