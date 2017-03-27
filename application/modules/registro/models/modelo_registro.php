<?php
class Modelo_registro extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	public function getLogin(){
		$sql= $this->db->select('pagina_descripcion')
					->from("np_pagina_idioma")
					->where('pagina_id', 2)
					->limit(1)
					->get();
        
		$resultado = $sql->row();
        if($resultado){
			return $resultado->pagina_descripcion;
		}else{
			return false;
		}
    }
	
	public function getVal($where){
		$sql= $this->db->select('*')
					->from("np_validador")
					->where($where)
					->where("v_estado", 1)
					->limit(1)
					->get();
        
		$resultado = $sql->row();
        if($resultado){
			if($this->valUser($resultado->v_usuarios)){
				if($this->updateVal(array("v_estado" => 0), array("v_codigo" => $resultado->v_codigo))  and $this->updateUser(array("u_estado" => 1), array("u_codigo" => $resultado->v_usuarios))){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
    }
	
	public function valUser($codigo){
		$sql= $this->db->select('*')
					->from("np_usuarios")
					->where('u_estado', 0)
					->where('u_codigo', $codigo)
					->limit(1)
					->get();
        
		$resultado = $sql->row();
        if($resultado){
			return true;
		}else{
			return false;
		}
    }
	
	public function valRegistro($email){
		$sql= $this->db->select('*')
					->from("np_usuarios")
					->where('u_estado', 1)
					->where('u_email', $email)
					->limit(1)
					->get();
        
		$resultado = $sql->row();
        if($resultado){
			return true;
		}else{
			return false;
		}
    }
	
	public function updateVal($datos, $where){
		$this->db->where($where);
		return $this->db->update("np_validador", $datos);
	}
	
	public function updateUser($datos, $where){
		$this->db->where($where);
		return $this->db->update("np_usuarios", $datos);
	}
	
	#MANTENDOR
	public function nextId(){
		$this->db->select_max("u_codigo","maximo");
		$sql = $this->db->get("np_usuarios");
		return $sql->row()->maximo+1;
	}
	
	public function nextIdVal(){
		$this->db->select_max("v_codigo","maximo");
		$sql = $this->db->get("np_validador");
		return $sql->row()->maximo+1;
	}
	
	function guardar($insert){
		return $this->db->insert('np_usuarios', $insert);
	}
	
	function guardarValidador($insert){
		return $this->db->insert('np_validador', $insert);
	}
}