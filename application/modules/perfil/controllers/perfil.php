<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Perfil extends CI_Controller {
	
	function __construct(){
	
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect("/");
		#current
		$this->layout->current = 7;
		$this->load->model('registro/modelo_pais', 'objPais');
		$this->load->model('registro/modelo_region', 'objRegion');
		$this->load->model('registro/modelo_comuna', 'objComuna');
		$this->load->model("inicio/modelo_usuarios", "objUsuario");
	}
	
	public function index(){
		#Title
		$this->layout->title('Perfil');
		
		#Metas
		$this->layout->setMeta('title','Perfil');
		$this->layout->setMeta('description','Perfil');
		$this->layout->setMeta('keywords','Perfil');
		
		#JS - validador
		$this->layout->js('/js/sistema/perfil/index.js');
		
		#Google reCAPTCHA
		$this->layout->js('https://www.google.com/recaptcha/api.js');
		#Nav
		$this->layout->nav(array("Perfil"=>"/"));
		#La vista siempre,  debe ir cargada al final de la función
		$contenido['paises'] = $this->objPais->listar();
		$contenido['comuna'] = $this->objComuna->obtener(array("co_codigo" => $this->session->userdata("usuario")->codigo));
		$this->layout->view('index', $contenido);
	}
	
	public function envio(){
		if($this->input->post()){
			
			#validacion
			$this->form_validation->set_rules('nombres', 'Nombres', 'required');
			$this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
			$this->form_validation->set_rules('telefono', 'Teléfono', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('direccion', 'Dirección', 'required');
			$this->form_validation->set_rules('comuna', 'Dirección', 'required');
			
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_message('valid_email', '* El email no es válido');
			$this->form_validation->set_error_delimiters('<div>','</div>');
			
			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			/*if($this->input->post("contrasena") !=  $this->input->post("repetir")){
				echo json_encode(array("result"=>false,"msg"=>"Contraseñas no coinciden."));
				exit;
			}*/
			
			if($this->objUsuario->obtener(array("us_email" => $this->input->post("email")))){
				if($this->input->post("email") != $this->session->userdata("usuario")->email){
					echo json_encode(array("result"=>false,"msg"=>"Ya existe un usuario con ese email."));
					exit;
				}
			}
			
			$update = array(
				"co_codigo" => $this->input->post("comuna"),
				"us_email" => $this->input->post("email"),
				"us_nombres" => $this->input->post("nombres"),
				"us_apellidos" => $this->input->post("apellidos"),
				"us_telefono" => $this->input->post("telefono"),
				"us_direccion" => $this->input->post("direccion")
			);
			
			$where = array(
				"us_codigo" => $this->session->userdata("usuario")->codigo
			);
			$this->objUsuario->actualizar($update,$where);
			echo json_encode(array("result"=>true));
			exit;
		}else
			redirect('/perfil/');
	}
	
	public function password(){
		if($this->input->post()){
			
			#validacion
			$this->form_validation->set_rules('contrasena', 'Contraseña nueva', 'required');
			$this->form_validation->set_rules('repetir', 'Repetir contraseña', 'required');
			$this->form_validation->set_rules('contrasena_actual', 'Contraseña actual', 'required');
			
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_message('valid_email', '* El email no es válido');
			$this->form_validation->set_error_delimiters('<div>','</div>');
			
			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			if($this->input->post("contrasena") !=  $this->input->post("repetir")){
				echo json_encode(array("result"=>false,"msg"=>"Contraseñas no coinciden."));
				exit;
			}
			
			if($this->input->post("contrasena_actual") != $this->session->userdata("usuario")->contrasena){
				echo json_encode(array("result"=>false,"msg"=>"Contraseña actual no valida."));
				exit;
			}
			
			$update = array(
				"us_contrasena" => md5($this->input->post("contrasena"))
			);
			
			$where = array(
				"us_codigo" => $this->session->userdata("usuario")->codigo
			);
			$this->objUsuario->actualizar($update,$where);
			echo json_encode(array("result"=>true));
			exit;
		}else
			redirect('/perfil/');
	}
	
	public function buscar_region(){
		if($this->input->post()){
			$html = '<option disabled selected>Seleccione</option>';
			foreach($this->objRegion->listar(array("pa_codigo" => $this->input->post("pais"))) as $region){
				$html.= '<option value="' . $region->codigo . '">' . $region->nombre . '</option>';
			}
			echo json_encode(array("result" => true, "html" => $html));
		}else{
			redirect('/perfil/');
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
			redirect('/perfil/');
		}
	}
	
}