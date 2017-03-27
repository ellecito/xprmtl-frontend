<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Inicio extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model("modelo_sliders", "objSliders");
		$this->load->model("modelo_usuarios", "objUsuario");
		$this->load->model("productos/modelo_productos", "objProducto");
		$this->load->model("noticias/modelo_noticias", "objNoticia");
		$this->load->model('quienessomos/modelo_paginas', 'objQuienesSomos');
		$this->load->model("inicio/modelo_empresa", 'objMeta');
	}

	public function index(){
		$meta = $this->objMeta->obtener(array("de_codigo" => 1));
		#title
		$this->layout->title($meta->nombre);
		
		#metas
		$this->layout->setMeta('title', $meta->nombre);
		$this->layout->setMeta('description',$meta->descripcion);
		$this->layout->setMeta('keywords',$meta->keywords);
		
		#slider
		$this->layout->css('/js/jquery/flexslider/flexslider.css');
		$this->layout->js('/js/jquery/flexslider/jquery.flexslider.js');
		
		$contenido = array(
			"home_indicador" => true,
			"sliders" => $this->objSliders->listar(),
			"noticias" => $this->objNoticia->listar(2, false),
			"productos" => $this->objProducto->listar(false, false, array("pr_destacado" => 1)),
			"quienessomos" => $this->objQuienesSomos->obtener(array("pag_codigo" => 3))
		);
		$this->layout->view('inicio',$contenido);
		
	}
	
	public function login(){
		
		if($this->input->post()){
			
			#validacion
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_message('valid_email', '* El email no es válido');
			$this->form_validation->set_error_delimiters('<div>','</div>');
			
			if(!$this->form_validation->run('login')){
				$error = validation_errors();
				echo json_encode(array("result"=>false,"msg"=>$error));
			}
			else
			{
				try{
					$where = array(
						"us_email" => $this->input->post('email'),
						"us_contrasena" => md5($this->input->post('contrasena'))
					);
					if($usuario = $this->objUsuario->obtener($where)){
						$this->session->set_userdata('usuario',$usuario);
						echo json_encode(array("result"=>true));
					}
					else
						echo json_encode(array("result"=>false,"msg"=>"Los datos ingresados no son validos."));
					
				}
				catch(Exception $e){
					echo json_encode(array("result"=>false,"msg"=>$e->getMessage()));
					// echo json_encode(array("result"=>false,"msg"=>"Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
				}
			}
		}
		else
			redirect('/');
	
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect('/');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */