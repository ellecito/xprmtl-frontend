<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<h1>Webpay - Transaccion Normal</h1>

<?php
/**
 * @author     Allware Ltda. (http://www.allware.cl)
 * @copyright  2015 Transbank S.A. (http://www.tranbank.cl)
 * @date       Jan 2015
 * @license    GNU LGPL
 * @version    2.0.1
 */

require_once($_SERVER["DOCUMENT_ROOT"] . '/application/libraries/webpay/webpay.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/application/libraries/webpay/certificate.php');

/** Configuracion parametros de la clase Webpay */
$sample_baseurl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REDIRECT_URL'];

$configuration = new Configuration();
$configuration->setEnvironment($certificate['environment']);
$configuration->setCommerceCode($certificate['commerce_code']);
$configuration->setPrivateKey($certificate['private_key']);
$configuration->setPublicCert($certificate['public_cert']);
$configuration->setWebpayCert($certificate['webpay_cert']);

/** Creacion Objeto Webpay */
$webpay = new Webpay($configuration);

$action = isset($_GET["action"]) ? $_GET["action"] : 'init';

$post_array = false;

switch ($action) {

    default:

        $tx_step = "Init";

        /** Monto de la transacción */
        $amount = $this->session->userdata("orden")->monto;

        /** Orden de compra de la tienda */
        $buyOrder = $this->session->userdata("orden")->codigo;

        /** Código comercio de la tienda entregado por Transbank */
        $sessionId = uniqid();
        
        /** URL de retorno */
        $urlReturn = $sample_baseurl."?action=getResult";
        
        /** URL Final */
		$urlFinal  = $sample_baseurl."?action=end";

        $request = array(
            "amount"    => $amount,
            "buyOrder"  => $buyOrder,
            "sessionId" => $sessionId,
            "urlReturn" => $urlReturn,
            "urlFinal"  => $urlFinal,
        );

        /** Iniciamos Transaccion */
        $result = $webpay->getNormalTransaction()->initTransaction($amount, $buyOrder, $sessionId, $urlReturn, $urlFinal);
        
        /** Verificamos respuesta de inicio en webpay */
        if (!empty($result->token) && isset($result->token)) {
            $message = "Sesion iniciada con exito en Webpay";
            $token = $result->token;
            $next_page = $result->url;
        } else {
            $message = "webpay no disponible";
        }

        $button_name = "Continuar &raquo;";
        
        break;

    case "getResult":
        
        $tx_step = "Get Result";

        if (!isset($_POST["token_ws"]))
            break;

        /** Token de la transacción */
        $token = filter_input(INPUT_POST, 'token_ws');
        
        $request = array(
            "token" => filter_input(INPUT_POST, 'token_ws')
        );

        /** Rescatamos resultado y datos de la transaccion */
        $result = $webpay->getNormalTransaction()->getTransactionResult($token);
        $this->load->model("modelo_bitacora", "objBitacora");
		if($this->objBitacora->obtener(array("bw_orden_de_compra" => $result->buyOrder))){
			$bitacora_result = false;
		}else{
			$prefijo = "bw_";
			$bitacora_webpay = array(
				"{$prefijo}codigo" => $this->objBitacora->getLastId(),
				"{$prefijo}tipo_transaccion" => 'TR_NORMAL',
				"{$prefijo}respuesta" => $result->detailOutput->responseCode,
				"{$prefijo}orden_de_compra" => $result->buyOrder,
				"{$prefijo}id_sesion" => $result->sessionId,
				"{$prefijo}codigo_autorizacion" => $result->detailOutput->authorizationCode,
				"{$prefijo}monto" => $result->detailOutput->amount,
				"{$prefijo}final_numero_tarjeta" => $result->cardDetail->cardNumber,
				"{$prefijo}fecha_expiracion" => substr($result->transactionDate, 0, 10),
				"{$prefijo}fecha_contable" => substr($result->transactionDate, 0, 10),
				"{$prefijo}fecha_transaccion" => substr($result->transactionDate, 0, 10),
				"{$prefijo}tipo_pago" => $result->detailOutput->paymentTypeCode,
				"{$prefijo}numero_cuotas" => $result->detailOutput->sharesNumber,
				"{$prefijo}mac" => "",
				"{$prefijo}tasa_de_interes_max" => "",
				"{$prefijo}ip" => $_SERVER['REMOTE_ADDR'],
				"{$prefijo}hora_transaccion" => substr($result->transactionDate, 11, 8),
				"{$prefijo}id_transaccion" => $result->detailOutput->commerceCode
			);
			$this->objBitacora->insertar($bitacora_webpay);
			$bitacora_result = true;
		}
        /** Verificamos resultado  de transacción */
        if($result->detailOutput->responseCode === 0 && $bitacora_result){
			$this->load->model("modelo_pedidos", "objPedidos");
			$this->load->model("registro/email", "objEmail");
			$this->objEmail->pago();
			$this->objPedidos->actualizar(array("ps_codigo" => 2), array("pe_codigo" => $result->buyOrder));
            /** propiedad de HTML5 (web storage), que permite almacenar datos en nuestro navegador web */
            echo '<script>window.localStorage.clear();</script>';
            echo '<script>localStorage.setItem("authorizationCode", '.$result->detailOutput->authorizationCode.')</script>';
            echo '<script>localStorage.setItem("amount", '.$result->detailOutput->amount.')</script>';
            echo '<script>localStorage.setItem("buyOrder", '.$result->buyOrder.')</script>';

            $message = "Pago ACEPTADO por webpay (se deben guardatos para mostrar voucher)";
            $next_page = $result->urlRedirection;
            
        }else{
			$this->load->model("modelo_pedidos", "objPedidos");
			$this->objPedidos->actualizar(array("ps_codigo" => 3), array("pe_codigo" => $result->buyOrder));
			//$this->session->sess_destroy("carro");
            $message = "Pago RECHAZADO por webpay - " . utf8_decode($result->detailOutput->responseDescription);
            //$message = "Pago RECHAZADO por webpay";
            $next_page = '';
			redirect("/carro/error/");
        }

        $button_name = "Continuar &raquo;";

        break;
    
    case "end":
        
        $post_array = true;
        
        $tx_step = "End";
        $request = "";
        $result = $_POST;
        
        $message = "Transacion Finalizada";
        $next_page = $sample_baseurl."?action=nullify";
        $button_name = "Anular Transacci&oacute;n &raquo;";
		redirect("/carro/exito/");
        break;   

    
    case "nullify":

        $tx_step = "nullify";
        
        $request = $_POST;
        
        /** Codigo de Comercio */
        $commercecode = null;

        /** Código de autorización de la transacción que se requiere anular */
        $authorizationCode = filter_input(INPUT_POST, 'authorizationCode');

        /** Monto autorizado de la transacción que se requiere anular */
        $amount =  filter_input(INPUT_POST, 'amount');

        /** Orden de compra de la transacción que se requiere anular */
        $buyOrder =  filter_input(INPUT_POST, 'buyOrder');
        
        /** Monto que se desea anular de la transacción */
        $nullifyAmount = 200;

        $request = array(
            "authorizationCode" => $authorizationCode, // Código de autorización
            "authorizedAmount" => $amount, // Monto autorizado
            "buyOrder" => $buyOrder, // Orden de compra
            "nullifyAmount" => $nullifyAmount, // idsession local
            "commercecode" => $configuration->getCommerceCode(), // idsession local
        );
        
        $result = $webpay->getNullifyTransaction()->nullify($authorizationCode, $amount, $buyOrder, $nullifyAmount, $commercecode);
		
		$this->load->model("modelo_pedidos", "objPedidos");
		$this->objPedidos->actualizar(array("ps_codigo" => 3), array("pe_codigo" => $result->buyOrder));
        /** Verificamos resultado  de transacción */
        if (!isset($result->authorizationCode)) {
            $message = "webpay no disponible";
        } else {
            $message = "Transaci&oacute;n Finalizada";
        }

        $next_page = '';
        
        break;
}

echo "<h2>Step: " . $tx_step . "</h2>";

if (!isset($request) || !isset($result) || !isset($message) || !isset($next_page)) {

    $result = "Ocurri&oacute; un error al procesar tu solicitud";
    echo "<div style = 'background-color:lightgrey;'><h3>result</h3>$result;</div><br/><br/>";
    echo "<a href='.'>&laquo; volver a index</a>";
    die;
}

/* Respuesta de Salida - Vista WEB */
?>

<div style="background-color:lightyellow;">
	<h3>request</h3>
	<?php  print_array($request); ?>
</div>
<div style="background-color:lightgrey;">
	<h3>result</h3>
	<?php  print_array($result); ?>
</div>
<p><samp><?php  echo $message; ?></samp></p>

<?php if (strlen($next_page) && $post_array) { ?>

        <form action="<?php echo $next_page; ?>" method="post">
            <input type="hidden" name="authorizationCode" id="authorizationCode" value="">
            <input type="hidden" name="amount" id="amount" value="">
            <input type="hidden" name="buyOrder" id="buyOrder" value="">
            <input type="submit" value="<?php echo $button_name; ?>">
        </form>

        <script>
            
            var authorizationCode = localStorage.getItem('authorizationCode');
            document.getElementById("authorizationCode").value = authorizationCode;
            
            var amount = localStorage.getItem('amount');
            document.getElementById("amount").value = amount;
            
            var buyOrder = localStorage.getItem('buyOrder');
            document.getElementById("buyOrder").value = buyOrder;
            
            localStorage.clear();
            
        </script>
        
<?php } elseif (strlen($next_page)) { ?>
    <form action="<?php echo $next_page; ?>" method="post" id="fist_form">
    
    <input type="hidden" name="token_ws" value="<?php echo ($token); ?>">
    <input type="submit" value="<?php echo $button_name; ?>">
</form>
<?php } ?>

<br>
<a href=".">&laquo; volver a index</a>