<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {
    
    public function index()
    {
        $this->load->helper('url');     
        $this->load->library('carrito');
        
        $prueba=new Carrito();
        $prueba->introduce_pro('2', 'prueba', '23€', 'fru/1', '3');
        $prueba->introduce_pro('1', 'uno', '13€', 'car/1', '1');
        $carro=$prueba->resumen_carrito();
        print_r($carro);
        
        /*$cuerpo['d1']=$this->load->view('cart',array('carro'=>$carro), true);
        $this->load->view('plantilla', array('cuerpo'=>$cuerpo));*/
    }
    
}