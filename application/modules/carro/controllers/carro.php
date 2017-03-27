<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Carro extends CI_Controller {

	function __construct(){

		parent::__construct();

		#current
		$this->layout->current = 7;
		$this->load->model("productos/modelo_productos", "objProductos");
		$this->load->model("modelo_pedidos", "objPedidos");
		$this->load->model("modelo_rel", "objRelPP");
		$this->load->model("registro/email", "objEmail");
		$this->load->model('quienessomos/modelo_paginas', 'objQuienesSomos');
		$this->load->model("modelo_bitacora", "objBitacora");
	}

	public function index(){
		#Title
		$this->layout->title('Carro de compras');

		#Metas
		$this->layout->setMeta('title','Carro de compras');
		$this->layout->setMeta('description','Carro de compras');
		$this->layout->setMeta('keywords','Carro de compras');

		#Nav
		$this->layout->nav(array("Carro de compras"=>"/"));
		$this->layout->js('/js/sistema/carro/index.js');

		#La vista siempre,  debe ir cargada al final de la función
		$this->layout->view('index');
	}
	
	public function agregar(){
		if($this->input->post()){
            try{
                if(!is_numeric($this->input->post('producto')))
                    throw new Exception();
                
                $producto = $this->objProductos->obtener(array("pr_codigo" => $this->input->post('producto')));
                $flag = true;
                if($this->cart->total_items() > 0){
                    foreach($this->cart->contents() as $aux){
						if($aux['id'] == $producto->codigo) $flag = false;
                    }
					if($flag){
						$nombre = str_replace(array(','),'',remove_accent(utf8_decode($producto->nombre)));
						$data = array(
							'id'=>$producto->codigo,
							'qty'=> 1,
							'price'=>$producto->precio,
							'name'=> $nombre,
							'options' => array(
								'imagen' => URL_ADMIN . $producto->imagen,
								'resumen' => $producto->resumen,
								'categoria' => $producto->categoria->nombre
							)
						);
						$this->cart->insert($data);
						echo json_encode(array("result"=>true));
					}else{
						echo json_encode(array("result"=>false,"msg"=>"Producto ya ingresado en el carro."));
					}
                }else{
					$nombre = str_replace(array(','),'',remove_accent(utf8_decode($producto->nombre)));
					$data = array(
						'id'=>$producto->codigo,
						'qty'=> 1,
						'price'=>$producto->precio,
						'name'=> $nombre,
						'options' => array(
							'imagen' => URL_ADMIN . $producto->imagen,
							'resumen' => $producto->resumen,
							'categoria' => $producto->categoria->nombre
						)
					);
					$this->cart->insert($data);
					echo json_encode(array("result"=>true));
				}

            }
            catch(Exception $e){
                //echo json_encode(array("result"=>false,"msg"=>$e->getMessage()));
                echo json_encode(array("result"=>false,"msg"=>"Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
            }
        }
        else
            throw new Exception();
	
	}
	
	public function eliminar(){
        if($this->input->post()){
    		try{
    			$id = $this->input->post('id');
    			$data = array(
    				'rowid'=>$id,
    				'qty'=> 0
    			);
    			$this->cart->update($data);
				
    			echo json_encode(array("result"=>true));
    		}
    		catch(Exception $e){
    			//echo json_encode(array("result"=>false,"msg"=>$e->getMessage()));
                echo json_encode(array("result"=>false,"msg"=>"Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
    		}
        }
        else
            throw new Exception();
	}
	
	public function actualizar(){
	
        if($this->input->post()){
    		try{
                if(!is_numeric($this->input->post('qty'))) throw new Exception();
    			$id = $this->input->post('id');
    			$cantidad = $this->input->post('qty');
    			$data = array(
    				'rowid'=>$id,
    				'qty'=> $cantidad
    			);
    			$this->cart->update($data);
				
    			echo json_encode(array("result"=>true));
    		}
    		catch(Exception $e){
    			//echo json_encode(array("result"=>false,"msg"=>$e->getMessage()));
                echo json_encode(array("result"=>false,"msg"=>"Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
    		}
        }
        else
            throw new Exception();
	}
	
	public function crear_orden(){
        if($this->input->post()){

			$html = '<table style="width: 100%">
						<tr>
							<th>
								Producto
							</th>
							<th>
								Cantidad
							</th>
							<th>
								SubTotal
							</th>
						</tr>';

			foreach($this->cart->contents() as $aux){
				$html .= '<tr>
							<td>
								'.$aux['name'].'
							</td>
							<td>
								'.$aux['qty'].'
							</td>
							<td>
								$'.number_format($aux['price'],0,",",".").'
							</td>
						</tr>';
			}

			$html .= '<tr>
						<td colspan="2">
							Total
						</td>
						<td>
							$'.number_format($this->cart->total(),0,",",".").'
						</td>
					</tr>
				</table>';

            $data = array(
                'pe_codigo'		=> $this->objPedidos->getLastId(),
                'pe_fecha' 		=> date('Y-m-d'),
                'pe_hora'		=> date('H:i:s'),
                'pe_monto'		=> $this->cart->total(),
				'pe_detalle'	=> $html,
				'ps_codigo' 	=> 1,
				'us_codigo' 	=> $this->session->userdata('usuario')->codigo,
            );

            $this->objPedidos->insertar($data);

            foreach($this->cart->contents() as $aux){
				$datos = array(
					"pp_codigo" 	=> $this->objRelPP->getLastId(),
					"pe_codigo" 	=> $data['pe_codigo'],
					"pr_codigo" 	=> $aux['id'],
					"pp_cantidad" 	=> $aux['qty']
				);
                $this->objRelPP->insertar($datos);
				unset($datos);
            }

			$this->session->set_userdata('orden',$this->objPedidos->obtener(array("pe_codigo" => $data['pe_codigo'])));
			$this->cart->destroy();
			$this->objEmail->pedido();
			echo json_encode(array('result' => true));
			exit;
        }
    }
	
	public function webpay(){
		if(!$this->session->userdata("orden")) redirect("/carro/");
		#metas
		$this->layout->title('Webpay');
		$this->layout->setMeta('title','Webpay');
		$this->layout->setMeta('keywords', 'Webpay');
		$this->layout->setMeta('description', 'Webpay');

		#JS
		$this->layout->js("/js/sistema/carro/webpay.js");
		#navegacion
		$this->layout->nav(array("Pago con webpay"=>"/"));

		#view
		$this->layout->view('webpay');
	}
	
	public function exito(){

		#metas
        $this->layout->title('WebPay Éxito');
        $this->layout->setMeta('title','WebPay Éxito');
        $this->layout->setMeta('keywords', 'WebPay Éxito');
        $this->layout->setMeta('description', 'WebPay Éxito');


		if(!$this->session->userdata('orden'))
			redirect("/");
		
		#vaciamos el carro
		$contenido = array(
			"orden" => $this->session->userdata('orden'),
			"bitacora" => $this->objBitacora->obtener(array("bw_orden_de_compra" => $this->session->userdata('orden')->codigo)),
			"devolucion" => $this->objQuienesSomos->obtener(array("pag_codigo" => 4))
		);
		
		$this->session->unset_userdata('orden');

		#navegacion
		$this->layout->nav(array("WebPay Éxito"=>"/"));

		#view
		$this->layout->view('exito',$contenido);

	}

	public function error(){
		
		if(!$this->session->userdata('orden'))
			redirect("/");

		#metas
		$this->layout->title('WebPay Error');
		$this->layout->setMeta('title','WebPay Error');
		$this->layout->setMeta('keywords', 'WebPay Error');
		$this->layout->setMeta('description', 'WebPay Error');
		
		$contenido = array(
			"orden" => $this->session->userdata('orden'),
			"error" => $this->objQuienesSomos->obtener(array("pag_codigo" => 5))
		);
		
		$this->session->unset_userdata('orden');
		
		#navegacion
		$this->layout->nav(array("WebPay Error"=>"/"));

		#view
		$this->layout->view("error",$contenido);
	}

}
