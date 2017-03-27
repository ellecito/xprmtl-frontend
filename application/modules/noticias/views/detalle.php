<div id="banner-principal">
	<center>
		<h1>Noticias</h1>
    </center>
 </div>
<center id="contenido">
  <?=$this->layout->getNav();?>
<div class="row">
	<div class="col-sm-7 noticia-d">
        <p class="text-fecha"><?php echo fecha_real($noticia->fecha); ?></p>
        <h2 class="h1"><?php echo $noticia->titulo; ?></h2>
        
        <div class="editable">
        <?php echo $noticia->contenido; ?>
        </div>
    </div>
    <div class="col-sm-5 gal-interna">
    
    	<div id="tabs-container">
            <ul class="tabs-menu">
                <?php if($noticia->imagen) { ?><li class="current"><a href="#tab-1">Imágenes</a></li><?php } ?>
                <?php //if($noticia->video) { ?><!--<li><a href="#tab-2">Video</a></li>--><?php //} ?>
            </ul>
            <div class="tab">
                <div id="tab-1" class="tab-content">
					<?php if($noticia->imagen) { ?>
                    <div class="galeria">
						<?php //foreach($noticia->imagenes as $imagen){ ?>
                        <div>
                            <img src="<?php echo URL_ADMIN . $noticia->imagen; ?>" width="502" height="424" /> 
                        </div>
						<?php //} ?>
                    </div>
					<?php } ?>
                </div>
				<?php //if($noticia->video){ ?>
                <div id="tab-2" class="tab-content">
                    <div class="video-promocional">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php //echo $noticia->video; ?>?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
				<?php //} ?>
            </div>
        </div>
    	
    </div>
</div>
</center>




 <script type="text/javascript">

$(document).ready(function(){
	  $('.galeria').slick({
          slidesToShow: 1,
		  slidesToScroll: 1,
		  autoplay: false,
		  dots: false,
		  fade: true,
		  arrows: true,
		  infinite: false		  
 	  });	
});	


$(document).ready(function() {
    $(".tabs-menu a").click(function(event) {
        event.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var tab = $(this).attr("href");
        $(".tab-content").not(tab).css("display", "none");
        $(tab).fadeIn();
    });
});

</script>