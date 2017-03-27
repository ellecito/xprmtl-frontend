<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Terminos extends CI_Controller {

	function __construct(){

		parent::__construct();
		$this->load->model('quienessomos/modelo_paginas', 'objQuienesSomos');
		#current
		$this->layout->current = 7;
	}

	public function index()	{
		#Title
		$this->layout->title('Términos y Condiciones');

		#Metas
		$this->layout->setMeta('title','Términos y Condiciones');
		$this->layout->setMeta('description','Términos y Condiciones');
		$this->layout->setMeta('keywords','Términos y Condiciones');

		#Nav
		$this->layout->nav(array("Términos y Condiciones"=>"/"));
		$contenido['terminos'] = $this->objQuienesSomos->obtener(array("pag_codigo" => 6));
		
		#La vista siempre,  debe ir cargada al final de la función
		$this->layout->view('index', $contenido);
	}

}
