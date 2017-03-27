<div id="banner-principal">
	<center>
		<h1><?php echo $categoria; ?></h1>
    </center>
 </div>
<center id="contenido">
  	<?php echo $this->layout->getNav(); ?>


	<div class="row">
    
    	<div class="col-sm-3">
        	
            <h2 class="tachado">Seleccione una opción</h2>
            
            <div class="listado-filtros">
				<a <?php if(!$this->input->get("categoria")) echo 'class="active"'; ?> href="/productos/">TODOS (<?php echo $total; ?>)</a>
				<?php if($categorias) { ?>
				<?php foreach($categorias as $cat) { ?>
            	<a <?php if($this->input->get("categoria") == $cat->codigo) echo 'class="active"'; ?> href="/productos/?categoria=<?php echo $cat->codigo ?>"><?php echo $cat->nombre . " (" . $cat->cantidad . ")"; ?></a>
				<?php } ?>
				<?php } ?>
            </div>
        
        </div>
        <div class="col-sm-9">
        	<div class="col-sm-12">
            	<h2 class="tachado tt"><?php echo $categoria; ?></h2>
            </div>
            <div class="row">
				<?php if($productos) { ?>
				<?php foreach($productos as $producto) { ?>
				<div class="col-sm-4">
					<div class="box-listado">
						<a href="/productos/<?php echo $producto->codigo . "-" . $producto->url; ?>/"><img src="<?php echo URL_ADMIN. $producto->imagen; ?>" width="272" height="295" /> </a>
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
            
            
		<!-- [PAGINACION] -->
		<div id="paginacion">
		 <?php echo $this->pagination->create_links(); ?>
		</div>
        </div>
    </div>
<div class="clear"></div>
</center>