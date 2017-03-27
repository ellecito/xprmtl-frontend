<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout {
    private $obj;
    private $layout_view;
    private $title = 'XPRMTL';
    private $titleDefault = '';
    private $css_list = array(), $js_list = array();
	private $metas = '';
	private $navegacion = array();
	public 	$current = '';

    function __construct() {
		#obj
        $this->obj =& get_instance();
        $this->layout_view = "layout/default.php";

		#css
		$this->css('/css/hoja-estilos.css');

		#js
		$this->js('/js/jquery/1.9.1/jquery-1.9.1.min.js');
		
		#Menu responsive
		$this->css('/js/jquery/responsive-nav/responsive-nav.css');
		$this->js('/js/jquery/responsive-nav/responsive-nav.js');
		
		#JS - validador
		$this->css('/js/jquery/validation-engine/css/validationEngine.jquery.css');
		$this->js('/js/jquery/validation-engine/js/jquery.validationEngine.js');
		$this->js('/js/jquery/validation-engine/js/languages/jquery.validationEngine-es.js');
		$this->js('/js/jquery/noty/packaged/jquery.noty.packaged.js');
		
		#Colorbox
		$this->js('/js/jquery/micolorbox/script.js');
		$this->js('/js/jquery/micolorbox/jquery.colorbox.js');
		$this->css('/js/jquery/micolorbox/colorbox.css');
		
		$this->js('/js/sistema/index/login.js');
		
		$this->obj->load->model("inicio/modelo_empresa", 'objEmpresa');
		$e_g = $this->obj->objEmpresa->obtener(array("de_codigo" => 1));
		$this->setTitleDefault($e_g->slogan);

        #layout
        if(isset($this->obj->layout_view))
			$this->layout_view = $this->obj->layout_view;

    }

    function view($view, $data = null, $return = false) {
        $this->obj->load->model("inicio/modelo_empresa", 'objEmpresa');
		$this->obj->load->model("productos/modelo_categorias", "objCategorias");
		$data['empresa_general'] = $this->obj->objEmpresa->obtener(array("de_codigo" => 1));
		$this->setTitleDefault($data['empresa_general']->slogan);
		$data['sucursales'] = false;
		$data['categorias'] = $this->obj->objCategorias->listar();
		#render template
        $data['content_for_layout'] = $this->obj->load->view($view, $data, true);

        #template
        $this->block_replace = true;
        $output = $this->obj->load->view($this->layout_view, $data, $return);

        return $output;
    }

    /**
     * Agregar title a la pagina actual
     *
     * @param $title
     */
    function title($title){
        $this->title = $title.' - '.$this->titleDefault;
    }
	
	function setTitleDefault($titleDefault){
		$this->titleDefault = $titleDefault;
		//die($this->titleDefault);
	}

	function getTitle(){
        return $this->title;
	}

    /**
     * Agregar Javascript a la pagina actual
     * @param $item
     */
    function js($item){
        $this->js_list[] = $item;
    }

	function getJs(){
		$js = '';
		if($this->js_list){
			foreach ($this->js_list as $aux){
				$js .= '<script type="text/javascript" src="'.$aux.'"></script>
		';
			}
		}
		return $js;
    }

    /**
     * Agregar CSS a la pagina actual
     * @param $item
     */
    function css($item){
        $this->css_list[] = $item;
    }

	function getCss(){
		$css = '';
		if($this->css_list){
			foreach ($this->css_list as $aux){
				$css .= '<link rel="stylesheet" type="text/css"  href="'.$aux.'" />
		';
			}
		}
		return $css;
    }

	/**
     * Agregar Metas a la pagina actual
     * @param $name, $content
     */
    function setMeta($name,$content) {
    	$meta = new stdClass();
        $meta->name = $name;
        $meta->content = $content;
		$this->metas[] = $meta;
    }

	function headMeta() {
		$metas = '';
		if($this->metas){
			foreach($this->metas as $aux){
				$metas .= '<meta name="'.$aux->name.'" content="'.$aux->content.'" />
		';
			}
		}
        return $metas;
    }

	/**
     * Agregar Navegacion a la pagina actual
     * @param $nav
     */
    function nav($nav) {
		$this->navegacion = $nav;
    }

	function getNav() {
		$html = '';
		if($this->navegacion){
			$html = '<nav id="navigation">Usted está en: <a href="/">Inicio</a>';
			$i = 1;
			$ruta_master = '/';

			$html .= ' &gt; ';
			foreach($this->navegacion as $nombre=>$ruta)
			{
				$ruta_master = "/".$ruta."/";
				$html .= ($i==count($this->navegacion))? '<span>'.$nombre.'</span>':'<a href="'.$ruta_master.'">'.$nombre.'</a> &gt; ';
				$i++;
			}

			 $html .='</nav>';
		}
		return $html;
	}

}
