<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {
    
    public function muestraCart()
    {        
        if (@!$_POST['upd']){
        $this->load->library('carrito');
        $this->load->helper('url');
        $this->load->library('session');
       //$this->session->unset_userdata('carrito');
        $euros=  $this->carrito->precio_total();
        $carro=$this->carrito->get_content();
        $cuerpo['d1'] = $this->load->view('cart', array('carro' => $carro, 'euros' =>$euros), true);
        $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        }
        else
        {
            
        }
    }
       
    public function guardar($id){
        $this->load->model('productos');
         $this->load->library('carrito'); 
         $this->load->helper('url');
        $producto=$this->productos->DetallesDe($id);
         $prod = array('id' => $producto[0]['idPro'],
            'nombre' => $producto['0']['nombrePro'],
            'precio' => $producto['0']['precio'],
            'img' => $producto['0']['imagen'],
            'unidades' => 1);       
        $this->carrito->introduce_pro($prod);
       redirect('/Cart/muestraCart', 'location',301); 
    }
    
    public function borrar($id)
    {
         $this->load->library('carrito'); 
         $this->load->helper('url');
        $unique_id = md5($id);
        $this->carrito->remove_producto($unique_id);
        redirect('/Cart/muestraCart', 'location',301); 
    }
    
    public function actualizar()
    {
        
    }
}