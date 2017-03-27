<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Productos extends CI_Controller {

	function __construct(){
		parent::__construct();
		#current
		$this->layout->current = 7;
		$this->load->model("modelo_productos", "objProductos");
		$this->load->model("modelo_categorias", "objCategorias");
	}

	public function index($pagina = 1){
		
		#Title
		$this->layout->title('Productos');

		#Metas
		$this->layout->setMeta('title','Productos');
		$this->layout->setMeta('description','Productos');
		$this->layout->setMeta('keywords','Productos');

		#JS - pagination
		$this->layout->js('/js/jquery/rpage-master/responsive-paginate.js');
		$this->layout->js('/js/jquery/rpage-master/paginate-init.js');
		
		$where = "";
		if($this->input->get("categoria")){
			$where = array("ca_codigo" => $this->input->get("categoria"));
			$contenido["categoria"] = $this->objCategorias->obtener($where)->nombre;
		}else{
			$contenido["categoria"] = "Todos";
		}
		
		#Paginación
		$this->load->library('pagination');
		$config['uri_segment'] = 2;
		$config['base_url'] = base_url().'/productos/';
		$config['per_page'] = 15;
		$config['total_rows'] = $this->objProductos->total($where);
		$contenido["total"] = $this->objProductos->total();
		$contenido["productos"] = $this->objProductos->listar($config["per_page"], $pagina, $where);
		#Nav
		$this->layout->nav(array("Productos"=>"/"));
		//die(print_array($contenido["productos"]));
		$this->pagination->initialize($config);
		#La vista siempre,  debe ir cargada al final de la función
		$this->layout->view('index', $contenido);
	}


	public function detalle($producto = false)	{
		if(!$producto) redirect("/");
		$producto = explode("-", $producto);
		$contenido["producto"] = $this->objProductos->obtener(array("pr_codigo" => $producto[0]));
		if(!$contenido["producto"]) redirect("/");
		#Title
		$this->layout->title($contenido["producto"]->nombre);

		#Metas
		$this->layout->setMeta('title',$contenido["producto"]->nombre);
		$this->layout->setMeta('description',$contenido["producto"]->nombre);
		$this->layout->setMeta('keywords',$contenido["producto"]->resumen);

		#slick
		$this->layout->css('/js/jquery/mycarousel/slick.css');
		$this->layout->js('/js/jquery/mycarousel/slick.js');

		#colorbox
		$this->layout->css('/js/jquery/micolorbox/colorbox.css');
		$this->layout->js('/js/jquery/micolorbox/jquery.colorbox.js');
		$this->layout->js('/js/jquery/micolorbox/script.js');
		$this->layout->js('/js/sistema/productos/detalle.js');

		#Nav
		$this->layout->nav(array("Productos" => "productos", $contenido["producto"]->nombre =>"/"));
		
		$where = "pr_codigo != " . $contenido["producto"]->codigo . " AND ca_codigo = " . $contenido["producto"]->categoria->codigo;
		$contenido['productos'] = $this->objProductos->listar(3, false, $where);
		
		#La vista siempre,  debe ir cargada al final de la función
		$this->layout->view('detalle', $contenido);
	}

}
