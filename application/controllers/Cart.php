<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {
    
    public function muestraCart()
    {
        $carro = $_SESSION['carrito'];
        $cuerpo['d1'] = $this->load->view('cart', array('carro' => $carro), true);
        $this->load->view('plantilla', array('cuerpo' => $cuerpo));
    }
    
    public function mas($id)
    {
        $unique_id = md5($articulo["id"]);
        $_SESSION['carrito'][$unique_id]['unidades']++;
        //actualizar carrito
    }
    
    public function menos($id)
    {
        $unique_id = md5($articulo["id"]);
        $_SESSION['carrito'][$unique_id]['unidades']--;
        //actualizar carrito
    }
}