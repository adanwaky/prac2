<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {
    
    public function addCart($proid, $pronom, $propre, $proimg, $procant)
    {
        $this->load->helper('url');     
        $this->load->library('carrito');
        
        $carrito=new Carrito();
        $carrito->introduce_pro($proid, $pronom, $propre, $proimg, $procant);        
        $carro=$prueba->resumen_carrito();      
        
        $cuerpo['d1']=$this->load->view('cart',array('carro'=>$carro), true);
        $this->load->view('plantilla', array('cuerpo'=>$cuerpo));
    }
    
}