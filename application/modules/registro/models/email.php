<?php

class Email extends CI_Model
{

    function __construct(){
		$this->load->model("inicio/modelo_empresa", 'objContacto');
        parent::__construct();
    }

	private function getEmail(){
        if($contacto = $this->objContacto->obtener(array("de_codigo" => 1))){
			return $contacto;
		}else{
			return false;
		}
	}

    public function registro(){
		$contacto = $this->getEmail();
        $asunto = "Nuevo Usuario";
        $cuerpo = "Se ha registrado un nuevo usuario.<br /><br />
        Datos: <br /><br />
		<b>Nombres</b>: " . $this->input->post("nombres") . "
		<br /><b>Apellidos</b>: " . $this->input->post("apellidos") . "
		<br /><b>Email</b>: " . $this->input->post("email") . "
		<br /><b>Teléfono</b>: " . $this->input->post("telefono") . "
		<br /><b>Dirección</b>: " . $this->input->post("direccion");
        
        $this->email->from("no-reply@xprmtl.cl","XPRMTL");
        $this->email->to($contacto->email);
        $this->email->cc($contacto->email_cc);
        $this->email->bcc($contacto->email_bcc);
        $this->email->subject($asunto." [".date('d/m/y')." ".date('H:i:s')."]");
        $this->email->message($cuerpo);
        $this->email->send();
    }
	
	public function contacto(){
		$contacto = $this->getEmail();
        $asunto = "Nuevo Contacto";
        $cuerpo = "Se ha ingresado un nuevo formulario de contacto.<br /><br />
        Datos: <br /><br />
		<b>Nombres</b>: " . $this->input->post("nombres") . "
		<br /><b>Apellidos</b>: " . $this->input->post("apellidos") . "
		<br /><b>Email</b>: " . $this->input->post("email") . "
		<br /><b>Teléfono</b>: " . $this->input->post("telefono") . "
		<br /><b>Mensaje</b>: " . $this->input->post("mensaje");
        
        $this->email->from("no-reply@xprmtl.cl","XPRMTL");
        $this->email->to($contacto->email);
        $this->email->cc($contacto->email_cc);
        $this->email->bcc($contacto->email_bcc);
        $this->email->subject($asunto." [".date('d/m/y')." ".date('H:i:s')."]");
        $this->email->message($cuerpo);
        $this->email->send();
    }
	
	public function pedido(){
		$contacto = $this->getEmail();
        $asunto = "Nuevo Pedido";
		$cuerpo = '<h3>Datos Cotizador.</h3>';
		$cuerpo.= '<b>Nombre Completo</b>: ' . $this->session->userdata("usuario")->nombres . " " . $this->session->userdata("usuario")->apellidos . '<br />';
		$cuerpo.= '<b>Email</b>: ' . $this->session->userdata("usuario")->email . '<br /><br />';
		$cuerpo.= $this->session->userdata("orden")->detalle;
		
        $this->email->from("no-reply@xprmtl.cl","XPRMTL");
        $this->email->to($contacto->email);
        $this->email->cc($contacto->email_cc);
        $this->email->bcc($contacto->email_bcc);
        $this->email->subject($asunto." [".date('d/m/y')." ".date('H:i:s')."]");
        $this->email->message($cuerpo);
        $this->email->send();
    }
	
	public function pago(){
		$contacto = $this->getEmail();
        $asunto = "Nuevo Pedido";
		$cuerpo = "Se ha realizo exitosamente el pago de su pedido.<br /><br />
        Datos de pedido: <br /><br />";
		$cuerpo.= $this->session->userdata("orden")->detalle;
		$cuerpo.= "<br /><br />";
		$cuerpo.= "En los proximos dias recibira su numero de tracking para realizar seguimiento de su compra. Muchas gracias por comprar en XPRMTL.";
		$cuerpo.= "<br /><br />";
		$cuerpo.= "Para cualquier consulta, escribanos a " . $contacto->email . " o llamenos a nuestro telefono " . $contacto->telefono;
		
        $this->email->from("no-reply@xprmtl.cl","XPRMTL");
        $this->email->to($contacto->email);
        $this->email->cc($contacto->email_cc);
        $this->email->bcc($contacto->email_bcc);
        $this->email->subject($asunto." [".date('d/m/y')." ".date('H:i:s')."]");
        $this->email->message($cuerpo);
        $this->email->send();
    }

}
