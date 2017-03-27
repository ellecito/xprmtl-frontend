<?php
    function google($type, $options = false, $config = false)
    {
        if($options == false)
            $options = array();

        if(is_string($type) && is_array($options))
        {
            return $type($options, $config);
        }
        else
            exit('Error al intentar crear el helper para Google'); 
    }

    

    

    function plus($options, $config)
    {
        /* ___________Opciones____________________________

         * 

         * ____________options

         * size        :  small - medium - tall

         * ________________________________________________

         */

        

		$script = '<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>';
        $script .=  '<g:plusone ';
        if(isset($options['size']) ? $script .= 'size="'.$options['size'].'"' : $script .= '');
        $script .= '></g:plusone>';

        return $script;
    }

    function maps($options, $config)
    {
        /* ___________Opciones____________________________
         * 
         * ______________options (1 o más arrays)
         * latlng       : latitudes, las dos, separadas por coma ejemplo: -37.484155,-72.35173
         * title        : nombre de la entidad
         * content      : descripción de la entidad
         * image        : ruta imagen, logo marcador, puede ser jpg, png o gif
		 
         * ______________config
         * width        :  número en pixeles
         * height       :  número en pixeles
         * zoom         :  número entero
         * scrollwheel  :  string booleano (zoom con scroll, defecto true)
         * ________________________________________________
         */

        if(isset($config['width']) 
                ? $width = $config['width'] : $width = '510px');
        if(isset($config['height']) 
                ? $height = $config['height'] : $height = '403px');
        if(isset($config['zoom']) 
                ? $zoom = $config['zoom'] : $zoom = '8');
		if(isset($config['scrollwheel']) 
                ? $scrollwheel = $config['scrollwheel'] : $scrollwheel = 'true');
		$div = '
			<script type="text/javascript" src="http://maps.google.com/maps/api/js"></script>
			<script type="text/javascript" >
				$(document).ready(function(){ $(\'body\').attr(\'onLoad\',\'maps()\'); });
			</script>';

        $div .= '<div id="map_canvas" style="width:'.$width.'; height:'.$height.'"></div>';
        $script = '<script type="text/javascript">';

        if(count($options) > 0)
        {
            $script .= 'function maps(){ ';
            foreach($options as $item=>$dato)
            {
                $script .= 'var latlng'.$item.' = new google.maps.LatLng('.$dato['latlng'].'); ';
            }

            $script .= 'var myOptions = {';
            $script .= 'zoom: '.$zoom.', scrollwheel:'.$scrollwheel.', center: latlng0, mapTypeId: google.maps.MapTypeId.ROADMAP ';
            $script .= '}; ';
            $script .= 'var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions); ';
			
            foreach($options as $item=>$dato)
            {
                $script .= 'var marker'.$item.' = new google.maps.Marker({ ';
                $script .= 'position: latlng'.$item.', ';
                $script .= 'map: map, ';
                $script .= "icon: '".$dato['image']."', ";
                $script .= 'title:"'.$dato['title'].'" ';
                $script .= '}); ';
            }

            foreach($options as $item=>$dato)
            {
                $script .= 'var infowindow'.$item.' = new google.maps.InfoWindow(); ';
                $script .= "infowindow".$item.".setContent('".$dato['content']."');";
                $script .= "google.maps.event.addListener(marker".$item.", 'click', function(){ ";
                $script .= 'infowindow'.$item.'.open(map, marker'.$item.'); ';
                $script .= '}); ';
            }
            $script .= '}';
        }
        $script .= '</script>';
		
        return $div.$script;
    }