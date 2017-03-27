<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Registro extends CI_Controller {
	
	function __construct(){
	
		parent::__construct();
		if($this->session->userdata("usuario")) redirect("/");
		#current
		$this->layout->current = 7;
		$this->load->model('quienessomos/modelo_paginas', 'objQuienesSomos');
		$this->load->model('modelo_pais', 'objPais');
		$this->load->model('modelo_region', 'objRegion');
		$this->load->model('modelo_comuna', 'objComuna');
		$this->load->model("inicio/modelo_usuarios", "objUsuario");
		$this->load->model("email", "objEmail");
	}
	
	public function index(){
		#Title
		$this->layout->title('Registro');
		
		#Metas
		$this->layout->setMeta('title','Registro');
		$this->layout->setMeta('description','Registro');
		$this->layout->setMeta('keywords','Registro');
		
		#JS - validador
		$this->layout->js('/js/sistema/registro/index.js');
		
		#Google reCAPTCHA
		$this->layout->js('https://www.google.com/recaptcha/api.js');
		
		#Nav
		$this->layout->nav(array("Registro"=>"/"));
		
		#La vista siempre,  debe ir cargada al final de la función
		$contenido['registro'] = $this->objQuienesSomos->obtener(array("pag_codigo" => 2));
		$contenido['paises'] = $this->objPais->listar();
		$this->layout->view('index', $contenido);
	}
	
	public function envio(){
		if($this->input->post()){
			
			#validacion
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_message('valid_email', '* El email no es válido');
			$this->form_validation->set_error_delimiters('<div>','</div>');
			
			if(!$this->form_validation->run('registro')){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			if($this->input->post("contrasena") !=  $this->input->post("repetir")){
				echo json_encode(array("result"=>false,"msg"=>"Contraseñas no coinciden."));
				exit;
			}
			
			if($this->objUsuario->obtener(array("us_email" => $this->input->post("email")))){
				echo json_encode(array("result"=>false,"msg"=>"Ya existe un usuario con ese email."));
				exit;
			}
			
			$secret = "6LeZ5BYUAAAAAGIYn3DSAv_9PHlIe62unU7408jd";
		 	$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $this->input->post("g-recaptcha-response") . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
		 	$response = json_decode($response);
		 	if($response->success == false || !$this->input->post("g-recaptcha-response")){
		 		echo json_encode(array("result"=>false,"msg"=>"<div>Error con Google reCAPTCHA.</div>"));
		 		exit;
		 	}
			
			$insert = array(
				"us_codigo" => $this->objUsuario->getLastId(),
				"us_estado" => 1,
				"us_visible" => 1,
				"co_codigo" => $this->input->post("comuna"),
				"us_email" => $this->input->post("email"),
				"us_nombres" => $this->input->post("nombres"),
				"us_apellidos" => $this->input->post("apellidos"),
				"us_telefono" => $this->input->post("telefono"),
				"us_direccion" => $this->input->post("direccion"),
				"us_contrasena" => md5($this->input->post("contrasena"))
			);
			$this->objUsuario->insertar($insert);
			$this->objEmail->registro();
			echo json_encode(array("result"=>true));
		}else
			redirect('/registro/');
	}
	
	public function buscar_region(){
		if($this->input->post()){
			$html = '<option disabled selected>Seleccione</option>';
			foreach($this->objRegion->listar(array("pa_codigo" => $this->input->post("pais"))) as $region){
				$html.= '<option value="' . $region->codigo . '">' . $region->nombre . '</option>';
			}
			echo json_encode(array("result" => true, "html" => $html));
		}else{
			redirect('/registro/');
		}
	}
	
	public function buscar_comuna(){
		if($this->input->post()){
			$html = '<option disabled selected>Seleccione</option>';
			foreach($this->objComuna->listar(array("re_codigo" => $this->input->post("region"))) as $comuna){
				$html.= '<option value="' . $comuna->codigo . '">' . $comuna->nombre . '</option>';
			}
			echo json_encode(array("result" => true, "html" => $html));
		}else{
			redirect('/registro/');
		}
	}
	
}