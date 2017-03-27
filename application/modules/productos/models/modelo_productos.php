<?php
class Modelo_productos extends CI_Model {
	private $tabla;
	private $prefijo;
	
	function __construct(){
		$this->tabla = "productos";
		$this->load->model("productos/modelo_categorias", "objCategorias");
		$this->load->model("productos/modelo_imagenes", "objImagen");
		$this->prefijo = substr($this->tabla, 0, 2) . "_";
		parent::__construct();
	}
	
	public function getLastId(){
		$this->db->select_max("{$this->prefijo}codigo","maximo");
		$sql = $this->db->get($this->tabla);
		return $sql->row()->maximo+1;
	}
	
	public function insertar($datos){
		return $this->db->insert($this->tabla, $datos);
	}
	
	public function actualizar($datos, $where){
		$this->db->where($where);
		return $this->db->update($this->tabla, $datos);
	}
	
	public function total($where = false){
		$this->db->where("{$this->prefijo}visible", 1);
		$this->db->where("{$this->prefijo}estado", 1);
		if($where) $this->db->where($where);
		return $this->db->count_all_results($this->tabla);
	}
	
	public function obtener($where){
		$sql = $this->db->select('*')
				->from($this->tabla)
				->where("{$this->prefijo}visible", 1)
				->where("{$this->prefijo}estado", 1)
				->where($where)
				->limit(1)
				->get();
				
        $resultado = $sql->row();
		
        if($resultado){
			$obj = new stdClass();
			foreach(get_object_vars($resultado) as $key => $val){
				$obj->{str_replace($this->prefijo, "", $key)} = $resultado->{$key};
			}
			$obj->categoria = $this->objCategorias->obtener(array("ca_codigo" => $resultado->ca_codigo));
			unset($obj->ca_codigo);
			$obj->imagenes = $this->objImagen->listar(false, false, array("pr_codigo" => $obj->codigo));
			return $obj;
        }else{
			return false;
        }
	}
	
	public function listar($cantidad = false, $pagina = false, $where = false){
		
		if($where) $this->db->where($where);
		if($cantidad and !$pagina) $this->db->limit($cantidad);
		if($cantidad and $pagina){
			$desde = ($pagina - 1) * $cantidad;
			$this->db->limit($cantidad, $desde);
		} 
		
		$sql = $this->db->select('*')
				->from($this->tabla)
				->where("{$this->prefijo}visible", 1)
				->where("{$this->prefijo}estado", 1)
				->get();
				
        $result = $sql->result();
        if($result){
			$listado = array();
			foreach($result as $resultado){
				$obj = new stdClass();
				foreach(get_object_vars($resultado) as $key => $val){
					$obj->{str_replace($this->prefijo, "", $key)} = $resultado->{$key};
				}
				$obj->categoria = $this->objCategorias->obtener(array("ca_codigo" => $resultado->ca_codigo));
				unset($obj->ca_codigo);
				$obj->imagenes = $this->objImagen->obtener(array("pr_codigo" => $obj->codigo));
				$listado[] = $obj;
			}
			return $listado;
        }else {
			return false;
        }
    }
}