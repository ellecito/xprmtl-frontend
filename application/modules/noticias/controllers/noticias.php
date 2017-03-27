<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Noticias extends CI_Controller {
	
	function __construct(){
	
		parent::__construct();
		
		#current
		$this->layout->current = 6;
		$this->load->model('modelo_noticias','objNoticia');
	}
	
	public function index($pagina = 1) {
		#title
		$this->layout->title('Noticias');
		
		#metas
		$this->layout->setMeta('title','Noticias');
		$this->layout->setMeta('description','Noticias');
		$this->layout->setMeta('keywords','Noticias');
		
		#JS - pagination
		$this->layout->js('/js/jquery/rpage-master/responsive-paginate.js');
		$this->layout->js('/js/jquery/rpage-master/paginate-init.js');
		#nav
		$this->layout->nav(array("Noticias"=>"/"));
		
		#Paginación
		$this->load->library('pagination');
		$config['uri_segment'] = 2; 
		$config['base_url'] = base_url().'/noticias/';
		$config['per_page'] = 1;
		$config['total_rows'] = $this->objNoticia->total();
		
		$datos['noticias'] = $this->objNoticia->listar($config['per_page'], $pagina);
		
		$this->pagination->initialize($config);
		
		#La vista siempre debe ir cargada al final de la función
		$this->layout->view('index', $datos);
	}

	public function detalle($ano, $mes, $dia, $url){
		$where = array(
			"no_fecha" => $ano . "-" . $mes . "-" . $dia,
			"no_url" => $url
		);
		$noticia = $this->objNoticia->obtener($where);
		
		if($noticia) {
			#title
			$this->layout->title($noticia->titulo);
			
			#metas
			$this->layout->setMeta('title',$noticia->titulo);
			$this->layout->setMeta('description',$noticia->resumen);
			$this->layout->setMeta('keywords',$noticia->titulo);
			
			#slick
			$this->layout->css('/js/jquery/mycarousel/slick-detallenoticia.css');	
			$this->layout->js('/js/jquery/mycarousel/slick.js'); 
			
			#nav
			$this->layout->nav(array("Noticias"=>"noticias", $noticia->titulo =>"/"));
			
			$datos["noticia"] = $noticia;
		} else {	
			show_404();
		}
		
		$this->layout->view('detalle', $datos);
		
	}
	
}