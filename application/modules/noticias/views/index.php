<div id="banner-principal">
	<center>
		<h1>Noticias</h1>
    </center>
 </div>
<center id="contenido">
  <?=$this->layout->getNav();?>

<?php if($noticias){ ?>
<?php foreach($noticias as $noticia){ ?>
<article class="listado">
	<a href="<?php echo str_replace("-", "/", $noticia->fecha) . "/" . $noticia->url; ?>"><img src="<?php echo URL_ADMIN . $noticia->imagen; ?>" alt="<?php echo $noticia->titulo; ?>" width="226" height="172" /></a>
	<div class="resumen">
		<p class="text-fecha"><?php echo fecha_real($noticia->fecha); ?></p>
		<h3><a href="<?php echo str_replace("-", "/", $noticia->fecha) . "/" . $noticia->url; ?>"><?php echo $noticia->titulo; ?></a></h3>
		<p><?php echo $noticia->resumen; ?></p>
		<a class="seguir-leyendo" href="<?php echo str_replace("-", "/", $noticia->fecha) . "/" . $noticia->url; ?>">SEGUIR LEYENDO</a>
	</div>
</article>
<?php } ?>

<div id="paginacion">
	<?php echo $this->pagination->create_links(); ?>
</div>
<?php } ?>
</center>