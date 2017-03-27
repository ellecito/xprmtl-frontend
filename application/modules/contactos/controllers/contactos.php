<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Contactos extends CI_Controller {

	function __construct(){
	
		parent::__construct();
		
		#models
		$this->load->model('modelo_contacto','objContacto');
		$this->load->model("registro/email", "objEmail");
		
		#current
		$this->layout->current = 6;

	} 
	
	public function index(){
		
		#title
		$this->layout->title('Contacto');
		
		#metas
		$this->layout->setMeta('title','Contactos');
		$this->layout->setMeta('description','Contactos');
		$this->layout->setMeta('keywords','Contactos');
		
		
		#JS - validador
		$this->layout->js('/js/sistema/contacto/index.js');
		
		#Google reCAPTCHA
		$this->layout->js('https://www.google.com/recaptcha/api.js');
		
		#Nav
		$this->layout->nav(array("Contáctanos"=>"/"));
		
		$this->layout->view('index');
	}
	
	public function envio(){
		if($this->input->post()){
			
			#validacion
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_message('valid_email', '* El email no es válido');
			$this->form_validation->set_error_delimiters('<div>','</div>');
			
			if(!$this->form_validation->run('contacto')){
				$error = validation_errors();
				echo json_encode(array("result"=>false,"msg"=>$error));
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
				"cn_codigo" => $this->objContacto->getLastId(),
				"cn_nombres" => $this->input->post("nombres"),
				"cn_apellidos" => $this->input->post("apellidos"),
				"cn_fecha" => date("Y-m-d H:i:s"),
				"cn_email" => $this->input->post("email"),
				"cn_telefono" => $this->input->post("telefono"),
				"cn_mensaje" => $this->input->post("mensaje")
			);
			if($this->objContacto->insertar($insert)) echo json_encode(array("result"=>true));
			$this->objEmail->contacto();
		}
		else
			redirect('/contactos/');
	}
}
