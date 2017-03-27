<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "inicio";
$route['404_override'] = '';


/* RUTAS PYME */

$route['carro-de-compras'] = "carro_de_compra";
$route['carro-de-compras/agregar/(:num)'] = "carro_de_compra/agregar/$1";

$route['noticias'] = "noticias";
$route['noticias/(:num)'] = "noticias/index/$1";
$route['noticias/(:num)/(:num)/(:num)/(:any)'] = "noticias/detalle/$1/$2/$3/$4";

$route['productos/(:num)'] = "productos/index/$1";
$route['productos/(:any)'] = "productos/detalle/$1";



//paginas editables
$route['terminos-y-condiciones'] = "terminos";


$route['logout'] = "inicio/logout";
/* End of file routes.php */
/* Location: ./application/config/routes.php */
