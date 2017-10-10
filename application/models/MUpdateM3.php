<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class MUpdateM3 extends CI_Model {


    public function __construct() {
       
        parent::__construct();
        $this->load->database();
    }

    //Public method to obtain the services
    public function update_prices_db($id_tienda, $bd_externa) {
        $consulta = "UPDATE $bd_externa.ps_product_shop, mercuri.productos, ";
		$consulta .= "mercuri.tiendas SET $bd_externa.ps_product_shop.price = mercuri.productos.costo_bolivar ";
		$consulta .= "WHERE mercuri.tiendas.id = mercuri.productos.tienda_id AND ";
		$consulta .= "$bd_externa.ps_product_shop.cp_externo = mercuri.productos.referencia ";
		$consulta .= "AND $bd_externa.ps_product_shop.id_shop = mercuri.tiendas.referencia ";
		$consulta .= "AND mercuri.productos.tienda_id = $id_tienda";
		
		$query = $this->db->query($consulta);
    }    

}
?>
