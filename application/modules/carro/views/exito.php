<div id="banner-principal">
	<center>
		<h1>Transacción exitosa</h1>
    </center>
</div>
<center id="contenido" style="padding:5px;background:#ccc;">
	<?=$this->layout->getNav();?>
	<div class="opciones" style="margin-top: 50px;">
		<h2>Transacción Exitosa - OC#<?php echo $orden->codigo; ?></h2>
		<hr>
  <h3>Detalle de la compra</h3>
    	<div class="box">
				<table border="1"  cellspacing="0" cellpadding="0">
        		<tbody>
        			<tr>
        				<td class="seccion">Número Orden</td>
        				<td><?php echo $orden->codigo; ?></td>
        			</tr>
        			<tr>
        				<td class="seccion">Fecha</td>
        				<td><?php echo invierte_fecha($orden->fecha); ?></td>
        			</tr>
        			<tr>
        				<td class="seccion">Hora</td>
        				<td><?php echo $orden->hora; ?></td>
        			</tr>
        			<tr>
        				<td class="seccion">Nro Tarjeta</td>
        				<td>***********<?php echo $bitacora->numero_tarjeta; ?></td>
        			</tr>
        			<tr>
        				<td class="seccion">Código de autorización</td>
        				<td><?php echo $bitacora->codigo_autorizacion; ?></td>
        			</tr>
        			<tr>
        				<td class="seccion">Tipo de transacción</td>
        				<td>Venta</td>
        			</tr>
        			<tr>
        				<td class="seccion">Tipo Pago </td>
        				<td><?php switch ($bitacora->tipo_pago) {
        					case 'VN':
        						echo "Crédito";
        					break;
        					case 'VC':
        						echo "Crédito";
        					break;
        					case 'SI':
        						echo "Crédito";
        					break;
        					case 'CI':
        						echo "Crédito";
        					break;
        					case 'VD':
        						echo "Redcompra";
        					break;
        				}
        				?></td>
        			</tr>
        			<tr>
        				<td class="seccion">Tipo de Cuotas </td>
        				<td><?php switch ($bitacora->tipo_pago) {
        					case 'VN':
        						echo "Sin cuotas";
        					break;
        					case 'VC':
        						echo "Cuotas normales";
        					break;
        					case 'SI':
        						echo "Sin interés";
        					break;
        					case 'CI':
        						echo "Cuotas Comercio";
        					break;
        					case 'VD':
        						echo "Débito";
        					break;
        				}
        				?></td>
        			</tr>
        			<tr>
        				<td class="seccion">Numero de cuotas </td>
        				<td><?php switch ($bitacora->tipo_pago) {
        					case 'VN':
        						echo "00";
        					break;
        					case 'VC':
        						echo $bitacora->numero_cuotas;
        					break;
        					case 'SI':
        						echo "3";
        					break;
        					case 'CI':
        						echo "Número no definido";
        					break;
        					case 'VD':
        						echo "00";
        					break;
        				}
        				?></td>

        			</tr>
        			<tr>
        				<td class="seccion">Url Comercio</td>
        				<td><?php echo 'http://'.$_SERVER['HTTP_HOST']; ?></td>
        			</tr>
        			<tr>
        				<td class="seccion">Nombre Comercio</td>
        				<td>XPRMTL</td>
        			</tr>
        		</tbody>
        	</table>
      </div>
  </div>
	<br />
	<hr />

	<h3>Productos comprados</h3>
	<div class="box">
		<?php echo $orden->detalle; ?>
	</div>
	<br />
	<hr />

	<h3>En caso de devolución</h3>
	<div class="bloque-listar">
			<fieldset class="editable">
				<?php echo $devolucion->contenido; ?>
			</fieldset>
	</div>

	<div class="clear"></div>
</center>
