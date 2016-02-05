<?php

class Categoria extends CI_Controller {

    public function venta($idPro, $idPed, $unidades, $precio, $iva){
        $this->load->model('pedidos');
        $this->load->helper('url');
        
    }
}

