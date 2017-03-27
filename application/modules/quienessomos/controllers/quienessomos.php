<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Quienessomos extends CI_Controller {

	function __construct(){

		parent::__construct();
		$this->load->model('modelo_paginas', 'objQuienesSomos');
		#current
		$this->layout->current = 7;
	}

	public function index()	{
		#Title
		$this->layout->title('Quienes somos');

		#Metas
		$this->layout->setMeta('title','Quienes somos');
		$this->layout->setMeta('description','Quienes somos');
		$this->layout->setMeta('keywords','Quienes somos');

		#Nav
		$this->layout->nav(array("Quienes somos"=>"/"));
		$contenido['quienessomos'] = $this->objQuienesSomos->obtener(array("pag_codigo" => 1));
		
		#La vista siempre,  debe ir cargada al final de la función
		$this->layout->view('index', $contenido);
	}

}
